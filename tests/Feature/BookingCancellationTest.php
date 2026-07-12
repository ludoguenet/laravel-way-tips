<?php

use App\Models\Booking;
use App\Models\User;

test('the owning golfer can cancel their booking via is() and touch()', function () {
    $golfer = User::factory()->create();
    $booking = Booking::factory()->create(['golfer_id' => $golfer->id]);

    $response = $this->actingAs($golfer)->post(route('bookings.cancel', $booking));

    $response->assertRedirect(route('bookings.show', $booking));
    expect($booking->fresh()->cancelled_at)->not->toBeNull();
});

test('a golfer cannot cancel someone else\'s booking', function () {
    $golfer = User::factory()->create();
    $booking = Booking::factory()->create();

    $this->actingAs($golfer)->post(route('bookings.cancel', $booking))->assertForbidden();

    expect($booking->fresh()->cancelled_at)->toBeNull();
});

test('the legacy cancellation route behaves the same way', function () {
    $golfer = User::factory()->create();
    $booking = Booking::factory()->create(['golfer_id' => $golfer->id]);
    $strangerBooking = Booking::factory()->create();

    $this->actingAs($golfer)
        ->post(route('bookings.cancel-legacy', $booking))
        ->assertRedirect(route('bookings.show', $booking));
    expect($booking->fresh()->cancelled_at)->not->toBeNull();

    $this->actingAs($golfer)
        ->post(route('bookings.cancel-legacy', $strangerBooking))
        ->assertForbidden();
    expect($strangerBooking->fresh()->cancelled_at)->toBeNull();
});
