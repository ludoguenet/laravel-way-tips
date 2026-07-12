<?php

use App\Models\Booking;
use App\Models\Course;
use App\Models\TeeTime;
use App\Models\User;

test('guests are redirected to the login page', function () {
    $booking = Booking::factory()->create();

    $this->get(route('bookings.show', $booking))->assertRedirect(route('login'));
});

test('a golfer can view their own booking via route model binding', function () {
    $golfer = User::factory()->create();
    $teeTime = TeeTime::factory()->for(Course::factory())->create();
    $booking = Booking::factory()->create([
        'golfer_id' => $golfer->id,
        'tee_time_id' => $teeTime->id,
    ]);

    $response = $this->actingAs($golfer)->get(route('bookings.show', $booking));

    $response->assertOk();
    $response->assertInertia(
        fn ($page) => $page
            ->component('Bookings/Show')
            ->where('booking.id', $booking->id)
            ->where('booking.tee_time.course.id', $teeTime->course_id)
    );
});

test('visiting a booking that does not exist 404s', function () {
    $golfer = User::factory()->create();

    $this->actingAs($golfer)
        ->get(route('bookings.show', ['booking' => 999]))
        ->assertNotFound();

    $this->actingAs($golfer)
        ->get(route('bookings.show-legacy', ['id' => 999]))
        ->assertNotFound();
});

test('the legacy route resolves the same booking by manual lookup', function () {
    $golfer = User::factory()->create();
    $booking = Booking::factory()->create(['golfer_id' => $golfer->id]);

    $response = $this->actingAs($golfer)->get(route('bookings.show-legacy', $booking->id));

    $response->assertOk();
    $response->assertInertia(
        fn ($page) => $page->component('Bookings/Show')->where('booking.id', $booking->id)
    );
});

test('a golfer only sees their own bookings on the index', function () {
    $golfer = User::factory()->create();
    $otherGolfer = User::factory()->create();

    $ownBooking = Booking::factory()->create(['golfer_id' => $golfer->id]);
    Booking::factory()->create(['golfer_id' => $otherGolfer->id]);

    $response = $this->actingAs($golfer)->get(route('bookings.index'));

    $response->assertOk();
    $response->assertInertia(
        fn ($page) => $page
            ->component('Bookings/Index')
            ->has('bookings', 1)
            ->where('bookings.0.id', $ownBooking->id)
    );
});
