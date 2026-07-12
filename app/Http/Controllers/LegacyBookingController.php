<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TeeTime;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Paired with BookingController for the golf-app tutorial series.
 * This controller intentionally keeps "the old way" alive for each tip so
 * both approaches can be demoed side by side. Safe to delete once the
 * videos are recorded.
 */
class LegacyBookingController extends Controller
{
    public function show(int $id): Response
    {
        $booking = Booking::with(['teeTime.course', 'golfer'])->findOrFail($id);

        return Inertia::render('Bookings/Show', [
            'booking' => $booking,
            'otherGolfers' => User::whereKeyNot($booking->golfer_id)->orderBy('name')->get(['id', 'name']),
            'servedBy' => 'LegacyBookingController@show — Booking::findOrFail($id)',
        ]);
    }

    /**
     * Book a tee time the old way — building the attribute array by hand.
     */
    public function store(Request $request, TeeTime $teeTime): RedirectResponse
    {
        $validated = $request->validate([
            'players' => ['required', 'integer', 'min:1', 'max:4'],
        ]);

        $booking = Booking::create([
            'golfer_id' => $request->user()->id,
            'tee_time_id' => $teeTime->id,
            'players' => $validated['players'],
        ]);

        return redirect()->route('bookings.show', $booking);
    }
}
