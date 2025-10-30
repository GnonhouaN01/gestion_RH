<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'employee_id' => Employee::factory(),
            'start_time' => fake()->dateTimeBetween('now', '+1 week'),
            'end_time' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
            'notes' => fake()->sentence(6),
        ];
    }
}
