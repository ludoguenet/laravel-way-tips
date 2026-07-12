<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Paired with GolferBookingController for the "whereBelongsTo" tip.
 */
class LegacyGolferBookingController extends Controller
{
    public function index(User $golfer): Response
    {
        $bookings = Booking::where('golfer_id', $golfer->id)
            ->with('teeTime.course')
            ->latest('id')
            ->get();

        return Inertia::render('Golfers/Bookings', [
            'golfer' => $golfer,
            'bookings' => $bookings,
            'servedBy' => 'LegacyGolferBookingController@index — Booking::where(\'golfer_id\', $golfer->id)',
        ]);
    }
}
