<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ExchangeRateService;

class FetchExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches and stores the latest exchange rates from the European Central Bank.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new ExchangeRateService();

        try {
            $count = $service->fetchAndStoreFromEcb();
            $this->info("Successfully saved {$count} exchange rates.");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return 0;
    }
}
