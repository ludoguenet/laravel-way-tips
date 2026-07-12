<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingCancellationController extends Controller
{
    /**
     * Cancel a booking — ownership via is(), the timestamp via touch().
     */
    public function store(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->golfer()->is($request->user()), 403);

        $booking->touch('cancelled_at');

        return redirect()->route('bookings.show', $booking)
            ->with('status', 'Booking cancelled (the Laravel way).');
    }
}
