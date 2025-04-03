<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->unique()->name(),
            'buyer_tin' => fake()->regexify('[0-9]{10}'),
            'seller_tin' => fake()->regexify('[0-9]{10}'),
            'product_code' => fake()->regexify('[A-Z]{3}'),
            'net_amount' => fake()->randomFloat(2, 10, 1000),
            'issue_date' => fake()->dateTimeBetween('-1 month', '-1 week'),
            'edit_date' => fake()->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
