<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingTransferController extends Controller
{
    /**
     * Transfer a booking to another golfer by associating the relationship.
     */
    public function store(Request $request, Booking $booking): RedirectResponse
    {
        $golfer = User::findOrFail((int) $request->validate([
            'golfer_id' => ['required', 'exists:users,id'],
        ])['golfer_id']);

        $booking->golfer()->associate($golfer)->save();

        return redirect()->route('bookings.show', $booking)
            ->with('status', "Transferred to {$golfer->name} (the Laravel way).");
    }
}
