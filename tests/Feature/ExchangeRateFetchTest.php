<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\ExchangeRateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Models\ExchangeRate;

class ExchangeRateFetchTest extends TestCase
{
    use RefreshDatabase;

    public function test_parse_ecb_xml_returns_expected_array(): void
    {
        $xml = file_get_contents(base_path('tests/Fixtures/ecb.xml'));

        $service = new ExchangeRateService();
        $result = $service->parseEcbXml($xml);

        $this->assertCount(3, $result);
        $this->assertEquals('EUR', $result[0]['currency_from']);
        $this->assertEquals('USD', $result[0]['currency_to']);
        $this->assertEquals('2025-07-02', $result[0]['rate_date']);
        $this->assertEquals(1.0723, $result[0]['rate']);
    }


    public function test_fetches_and_saves_exchange_rates(): void
    {
        Http::fake([
            '*' => Http::response(file_get_contents(base_path('tests/Fixtures/ecb.xml')), 200),
        ]);

        $service = new ExchangeRateService();
        $service->fetchAndStoreFromEcb();

        $this->assertDatabaseCount(ExchangeRate::class, 3);
    }


    public function test_filters_exchange_rates_by_currency(): void
    {
        ExchangeRate::factory()->create([
            'currency_to' => 'USD', 
            'rate_date' => now()->subDays(4)
        ]);
        ExchangeRate::factory()->create([
            'currency_to' => 'JPY', 
            'rate_date' => now()->subDays(4)
        ]);

        $response = $this->getJson('/api/exchange-rates?currency_to=USD');
        $response->assertStatus(200);

        $data = $response->json('data');

        foreach ($data as $item) {
            $this->assertEquals('USD', $item['currency_to']);
        }
    }


    public function test_returns_validation_error_for_invalid_filter(): void
    {
        $response = $this->getJson('/api/exchange-rates?rate_date=not-a-date');

        $response->assertStatus(422)
                 ->assertJsonStructure(['message', 'errors']);
    }


    public function test_artisan_command_runs_successfully()
    {
        Http::fake([
            '*' => Http::response(file_get_contents(base_path('tests/Fixtures/ecb.xml')), 200),
        ]);

        $this->artisan('app:fetch-exchange-rates')
            ->expectsOutput('Successfully saved 3 exchange rates.')
            ->assertExitCode(0);
    }
}
