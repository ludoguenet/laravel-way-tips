<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TeeTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ProShopDashboardController extends Controller
{
    /**
     * Show today's bookings — staff only, enforced with Gate::allowIf().
     */
    public function index(Request $request): Response
    {
        Gate::allowIf(
            $request->user()->hasRole('marshal') || $request->user()->hasRole('pro-shop')
        );

        $todaysTeeTimeIds = TeeTime::whereDate('starts_at', today())->pluck('id');

        $todaysBookings = Booking::whereIn('tee_time_id', $todaysTeeTimeIds)
            ->with(['golfer', 'teeTime.course'])
            ->get();

        return Inertia::render('ProShop/Dashboard', [
            'bookings' => $todaysBookings,
            'servedBy' => 'ProShopDashboardController@index — Gate::allowIf(...)',
        ]);
    }
}
