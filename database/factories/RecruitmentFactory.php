<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recruitment>
 */
class RecruitmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraph(),
            'positions_needed' => fake()->numberBetween(1, 5),
            'status' => fake()->randomElement(['Open', 'Closed']),
            'start_date' => fake()->dateTimeBetween('-2 months', 'now'),
            'end_date' => fake()->dateTimeBetween('now', '+2 months'),
        ];
    }
}
