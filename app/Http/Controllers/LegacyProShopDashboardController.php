<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Paired with ProShopDashboardController for the "Gate::allowIf" tip.
 */
class LegacyProShopDashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $isStaff = $request->user()->hasRole('marshal') || $request->user()->hasRole('pro-shop');

        if (! $isStaff) {
            abort(403);
        }

        $todaysBookings = Booking::whereHas(
            'teeTime',
            fn ($query) => $query->whereDate('starts_at', today())
        )->with(['golfer', 'teeTime.course'])->get();

        return Inertia::render('ProShop/Dashboard', [
            'bookings' => $todaysBookings,
            'servedBy' => 'LegacyProShopDashboardController@index — if (! $isStaff) { abort(403); }',
        ]);
    }
}
