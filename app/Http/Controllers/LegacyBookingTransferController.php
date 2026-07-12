<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Paired with BookingTransferController for the "associate()" tip.
 */
class LegacyBookingTransferController extends Controller
{
    public function store(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'golfer_id' => ['required', 'exists:users,id'],
        ]);

        $booking->update([
            'golfer_id' => $validated['golfer_id'],
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('status', 'Booking transferred (the old way).');
    }
}
