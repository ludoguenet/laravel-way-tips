<?php

use App\Models\Booking;
use App\Models\Course;
use App\Models\TeeTime;
use App\Models\User;

test('a golfer can book a tee time and the relationship sets the golfer_id', function () {
    $golfer = User::factory()->create();
    $teeTime = TeeTime::factory()->for(Course::factory())->create();

    $response = $this->actingAs($golfer)->post(route('bookings.store', $teeTime), [
        'players' => 3,
    ]);

    $booking = Booking::sole();

    $response->assertRedirect(route('bookings.show', $booking));
    expect($booking->golfer_id)->toBe($golfer->id);
    expect($booking->tee_time_id)->toBe($teeTime->id);
    expect($booking->players)->toBe(3);
});

test('the legacy store route creates an equivalent booking', function () {
    $golfer = User::factory()->create();
    $teeTime = TeeTime::factory()->for(Course::factory())->create();

    $response = $this->actingAs($golfer)->post(route('bookings.store-legacy', $teeTime), [
        'players' => 2,
    ]);

    $booking = Booking::sole();

    $response->assertRedirect(route('bookings.show', $booking));
    expect($booking->golfer_id)->toBe($golfer->id);
    expect($booking->players)->toBe(2);
});

test('players is validated', function () {
    $golfer = User::factory()->create();
    $teeTime = TeeTime::factory()->for(Course::factory())->create();

    $this->actingAs($golfer)
        ->post(route('bookings.store', $teeTime), ['players' => 0])
        ->assertInvalid(['players']);
});
