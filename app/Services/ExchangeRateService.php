<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\ExchangeRate;

class ExchangeRateService 
{   
    /**
     * Fetches the latest exchange rates from the European Central Bank (ECB) and stores them.
     *
     * @return int The number of exchange rates successfully fetched and stored.
     */
    public function fetchAndStoreFromEcb(): int
    {
        $xmlString = $this->fetchXml();
        $data = $this->parseEcbXml($xmlString);
        $this->storeRates($data);

        return count($data);
    }


    /**
     * Parses the given ECB (European Central Bank) XML string and returns an array of exchange rates.
     *
     * @param string $xmlString The XML string containing ECB exchange rate data.
     * @return array An associative array of parsed exchange rates.
     */
    public function parseEcbXml(string $xmlString): array
    {
        $xml = simplexml_load_string($xmlString);
        $cube = $xml->Cube->Cube;
        $rateDate = (string) $cube['time'];
        $data = [];
        $now = now();

        foreach ($cube->Cube as $rate) {
            $data[] = [
                'currency_from' => 'EUR',
                'currency_to'   => (string) $rate['currency'],
                'rate_date'  => $rateDate,
                'rate'       => (float) $rate['rate'],
                'retrieved_at' => $now,
            ];
        }

        return $data;
    }


    /**
     * Fetches the XML data required for exchange rate processing.
     *
     * @return string The raw XML data as a string.
     */
    protected function fetchXml(): string
    {
        $response = Http::withOptions(['verify' => false])
            ->get(config('services.exchange_rates.xml_url'));

        if (!$response->successful()) {
            throw new \Exception('Failed to fetch exchange rates.');
        }

        return $response->body();
    }


    /**
     * Stores the provided exchange rate data.
     *
     * @param array $data An associative array containing exchange rate information to be stored.
     * @return void
     */
    protected function storeRates(array $data): void
    {
        ExchangeRate::upsert(
            $data,
            uniqueBy: ['currency_from', 'currency_to', 'rate_date'],
            update: ['rate', 'retrieved_at']
        );
    }    
}
