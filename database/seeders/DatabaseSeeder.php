<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Course;
use App\Models\Role;
use App\Models\TeeTime;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = collect(['member', 'marshal', 'pro-shop'])
            ->map(fn (string $name): Role => Role::firstOrCreate(['name' => $name]));

        $golfer = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $golfer->roles()->attach($roles->firstWhere('name', 'member'), ['assigned_at' => now()]);

        $otherGolfers = User::factory(5)->create();

        $teeTimes = Course::factory(3)->create()->flatMap(
            fn (Course $course) => TeeTime::factory(4)->create(['course_id' => $course->id])
        );

        // The demo golfer gets a few bookings to click through in the video.
        $teeTimes->take(3)->each(
            fn (TeeTime $teeTime) => Booking::factory()->create([
                'golfer_id' => $golfer->id,
                'tee_time_id' => $teeTime->id,
            ])
        );

        $teeTimes->skip(3)->each(
            fn (TeeTime $teeTime) => Booking::factory()->create([
                'golfer_id' => $otherGolfers->random()->id,
                'tee_time_id' => $teeTime->id,
            ])
        );
    }
}
