<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Paired with BookingCancellationController for the "is()" and "touch()" tips.
 */
class LegacyBookingCancellationController extends Controller
{
    public function store(Request $request, Booking $booking): RedirectResponse
    {
        if ($booking->golfer_id !== $request->user()->id) {
            abort(403);
        }

        $booking->update([
            'cancelled_at' => now(),
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('status', 'Booking cancelled (the old way).');
    }
}
