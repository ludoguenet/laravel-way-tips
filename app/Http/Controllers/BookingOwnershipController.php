<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookingOwnershipController extends Controller
{
    /**
     * Check whether the current golfer owns a booking, via whereKey().
     */
    public function show(Request $request, Booking $booking): Response
    {
        $owns = $request->user()->bookings()->whereKey($booking)->exists();

        return Inertia::render('Bookings/Ownership', [
            'booking' => $booking,
            'owns' => $owns,
            'servedBy' => 'BookingOwnershipController@show — whereKey($booking)',
        ]);
    }
}
