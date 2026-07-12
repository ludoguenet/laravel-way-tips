<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\TeeTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeeTime>
 */
class TeeTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'starts_at' => fake()->dateTimeBetween('+1 day', '+3 weeks'),
            'capacity' => fake()->randomElement([2, 3, 4]),
        ];
    }
}
