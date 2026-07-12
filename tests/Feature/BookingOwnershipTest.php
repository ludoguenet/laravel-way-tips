<?php

use App\Models\Booking;
use App\Models\User;

test('whereKey confirms ownership for the owning golfer', function () {
    $golfer = User::factory()->create();
    $booking = Booking::factory()->create(['golfer_id' => $golfer->id]);

    $response = $this->actingAs($golfer)->get(route('bookings.ownership', $booking));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page->component('Bookings/Ownership')->where('owns', true));
});

test('whereKey denies ownership for a different golfer', function () {
    $golfer = User::factory()->create();
    $booking = Booking::factory()->create();

    $response = $this->actingAs($golfer)->get(route('bookings.ownership', $booking));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page->component('Bookings/Ownership')->where('owns', false));
});

test('the legacy ownership check agrees with the new one', function () {
    $golfer = User::factory()->create();
    $booking = Booking::factory()->create(['golfer_id' => $golfer->id]);
    $strangerBooking = Booking::factory()->create();

    $this->actingAs($golfer)
        ->get(route('bookings.ownership-legacy', $booking))
        ->assertInertia(fn ($page) => $page->where('owns', true));

    $this->actingAs($golfer)
        ->get(route('bookings.ownership-legacy', $strangerBooking))
        ->assertInertia(fn ($page) => $page->where('owns', false));
});
