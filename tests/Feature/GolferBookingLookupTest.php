<?php

use App\Models\Booking;
use App\Models\User;

test('whereBelongsTo returns only the given golfer\'s bookings', function () {
    $golfer = User::factory()->create();
    $otherGolfer = User::factory()->create();

    $ownBooking = Booking::factory()->create(['golfer_id' => $golfer->id]);
    Booking::factory()->create(['golfer_id' => $otherGolfer->id]);

    $response = $this->actingAs($golfer)->get(route('golfers.bookings.index', $golfer));

    $response->assertOk();
    $response->assertInertia(
        fn ($page) => $page
            ->component('Golfers/Bookings')
            ->has('bookings', 1)
            ->where('bookings.0.id', $ownBooking->id)
    );
});

test('the legacy lookup route returns the same bookings', function () {
    $golfer = User::factory()->create();
    $otherGolfer = User::factory()->create();

    $ownBooking = Booking::factory()->create(['golfer_id' => $golfer->id]);
    Booking::factory()->create(['golfer_id' => $otherGolfer->id]);

    $response = $this->actingAs($golfer)->get(route('golfers.bookings.index-legacy', $golfer));

    $response->assertOk();
    $response->assertInertia(
        fn ($page) => $page
            ->component('Golfers/Bookings')
            ->has('bookings', 1)
            ->where('bookings.0.id', $ownBooking->id)
    );
});
