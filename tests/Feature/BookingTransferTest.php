<?php

use App\Models\Booking;
use App\Models\User;

test('a booking can be transferred to another golfer via associate()', function () {
    $requester = User::factory()->create();
    $originalGolfer = User::factory()->create();
    $newGolfer = User::factory()->create();
    $booking = Booking::factory()->create(['golfer_id' => $originalGolfer->id]);

    $response = $this->actingAs($requester)->post(route('bookings.transfer', $booking), [
        'golfer_id' => $newGolfer->id,
    ]);

    $response->assertRedirect(route('bookings.show', $booking));
    expect($booking->fresh()->golfer_id)->toBe($newGolfer->id);
});

test('the legacy transfer route has the same effect', function () {
    $requester = User::factory()->create();
    $originalGolfer = User::factory()->create();
    $newGolfer = User::factory()->create();
    $booking = Booking::factory()->create(['golfer_id' => $originalGolfer->id]);

    $response = $this->actingAs($requester)->post(route('bookings.transfer-legacy', $booking), [
        'golfer_id' => $newGolfer->id,
    ]);

    $response->assertRedirect(route('bookings.show', $booking));
    expect($booking->fresh()->golfer_id)->toBe($newGolfer->id);
});
