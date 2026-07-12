<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Paired with BookingOwnershipController for the "whereKey" tip.
 */
class LegacyBookingOwnershipController extends Controller
{
    public function show(Request $request, Booking $booking): Response
    {
        $owns = $request->user()->bookings()
            ->where('id', $booking->id)
            ->exists();

        return Inertia::render('Bookings/Ownership', [
            'booking' => $booking,
            'owns' => $owns,
            'servedBy' => 'LegacyBookingOwnershipController@show — where(\'id\', $booking->id)',
        ]);
    }
}
