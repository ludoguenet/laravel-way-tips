<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class GolferBookingController extends Controller
{
    /**
     * Show a specific golfer's bookings, for the pro shop staff screen.
     */
    public function index(User $golfer): Response
    {
        $bookings = Booking::whereBelongsTo($golfer, 'golfer')
            ->with('teeTime.course')
            ->latest('id')
            ->get();

        return Inertia::render('Golfers/Bookings', [
            'golfer' => $golfer,
            'bookings' => $bookings,
            'servedBy' => 'GolferBookingController@index — Booking::whereBelongsTo($golfer, \'golfer\')',
        ]);
    }
}
