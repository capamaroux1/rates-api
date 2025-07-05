<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExchangeRate>
 */
class ExchangeRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'currency_from' => 'EUR',
            'currency_to' => $this->faker->currencyCode(),
            'rate' => $this->faker->randomFloat(6, 0.5, 2),
            'rate_date' => now()->subDay(),
            'retrieved_at' => now(),
        ];
    }
}
