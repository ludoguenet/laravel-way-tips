<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TeeTime;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    /**
     * Show the current golfer's bookings.
     */
    public function index(Request $request): Response
    {
        $bookings = $request->user()->bookings()
            ->with('teeTime.course')
            ->latest('id')
            ->get();

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Book a tee time by creating through the golfer's relationship.
     */
    public function store(Request $request, TeeTime $teeTime): RedirectResponse
    {
        $validated = $request->validate([
            'players' => ['required', 'integer', 'min:1', 'max:4'],
        ]);

        $booking = $request->user()->bookings()->create([
            'tee_time_id' => $teeTime->id,
            'players' => $validated['players'],
        ]);

        return redirect()->route('bookings.show', $booking);
    }

    /**
     * Show a single booking, resolved via route model binding.
     */
    public function show(Booking $booking): Response
    {
        $booking->load(['teeTime.course', 'golfer']);

        return Inertia::render('Bookings/Show', [
            'booking' => $booking,
            'otherGolfers' => User::whereKeyNot($booking->golfer_id)->orderBy('name')->get(['id', 'name']),
            'servedBy' => 'BookingController@show — route model binding',
        ]);
    }
}
