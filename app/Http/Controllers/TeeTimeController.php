<?php

namespace App\Http\Controllers;

use App\Models\TeeTime;
use Inertia\Inertia;
use Inertia\Response;

class TeeTimeController extends Controller
{
    /**
     * Show upcoming tee times a golfer can book.
     */
    public function index(): Response
    {
        $teeTimes = TeeTime::with('course')
            ->withCount('bookings')
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->get();

        return Inertia::render('TeeTimes/Index', [
            'teeTimes' => $teeTimes,
        ]);
    }
}
