<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' => rand(1, 5),
            'market_id' => rand(1, 4),
            'cost' => rand(1, 5) * 10,
            'quantity' => rand(10, 20),
            'from' => now()->addDays(10)->toDateString(),
            'to' => now()->addDays(10)->toDateString()
        ];
    }
}
