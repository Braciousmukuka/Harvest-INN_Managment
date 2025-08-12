<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['crop', 'livestock', 'dairy', 'poultry', 'other'];
        $priceUnits = ['per unit', 'per kg', 'per lb', 'per dozen'];
        $quantityUnits = ['units', 'kg', 'lb', 'dozen'];
        $statuses = ['in_stock', 'low_stock', 'out_of_stock'];

        return [
            'name' => $this->faker->words(2, true),
            'sku' => strtoupper($this->faker->unique()->bothify('??###')),
            'description' => $this->faker->sentence(),
            'category' => $this->faker->randomElement($categories),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'price_unit' => $this->faker->randomElement($priceUnits),
            'quantity' => $this->faker->numberBetween(0, 1000),
            'quantity_unit' => $this->faker->randomElement($quantityUnits),
            'low_stock_threshold' => $this->faker->numberBetween(5, 50),
            'status' => $this->faker->randomElement($statuses),
            'harvested_date' => $this->faker->optional()->date(),
            'expiry_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'location' => $this->faker->optional()->city(),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
