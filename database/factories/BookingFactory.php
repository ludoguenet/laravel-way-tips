<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\TeeTime;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'golfer_id' => User::factory(),
            'tee_time_id' => TeeTime::factory(),
            'players' => fake()->numberBetween(1, 4),
            'cancelled_at' => null,
        ];
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'cancelled_at' => now(),
        ]);
    }
}
