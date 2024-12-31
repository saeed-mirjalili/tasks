<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Time>
 */
class TimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start'=>fake()->dateTimeBetween('-3 days', '-1 days'),
            'end'=>fake()->dateTimeBetween('-1 days', 'now'),
            'task_id'=>fake()->numberBetween('1','9'),
        ];
    }
}
