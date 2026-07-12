<?php

use App\Http\Controllers\BookingCancellationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingOwnershipController;
use App\Http\Controllers\BookingTransferController;
use App\Http\Controllers\GolferBookingController;
use App\Http\Controllers\GolferController;
use App\Http\Controllers\GolferRoleController;
use App\Http\Controllers\LegacyBookingCancellationController;
use App\Http\Controllers\LegacyBookingController;
use App\Http\Controllers\LegacyBookingOwnershipController;
use App\Http\Controllers\LegacyBookingTransferController;
use App\Http\Controllers\LegacyGolferBookingController;
use App\Http\Controllers\LegacyGolferRoleController;
use App\Http\Controllers\LegacyProShopDashboardController;
use App\Http\Controllers\ProShopDashboardController;
use App\Http\Controllers\TeeTimeController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::get('tee-times', [TeeTimeController::class, 'index'])->name('tee-times.index');

    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('tee-times/{teeTime}/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}/ownership', [BookingOwnershipController::class, 'show'])->name('bookings.ownership');
    Route::post('bookings/{booking}/cancel', [BookingCancellationController::class, 'store'])->name('bookings.cancel');
    Route::post('bookings/{booking}/transfer', [BookingTransferController::class, 'store'])->name('bookings.transfer');

    Route::get('golfers', [GolferController::class, 'index'])->name('golfers.index');
    Route::post('golfers/{golfer}/roles', [GolferRoleController::class, 'store'])->name('golfers.roles.store');
    Route::patch('golfers/{golfer}/roles/{role}', [GolferRoleController::class, 'update'])->name('golfers.roles.update');
    Route::get('golfers/{golfer}/bookings', [GolferBookingController::class, 'index'])->name('golfers.bookings.index');

    Route::get('pro-shop', [ProShopDashboardController::class, 'index'])->name('pro-shop.index');

    // "Old way" demo routes for the tutorial videos — see the Legacy*Controller pair.
    Route::get('bookings/{id}/legacy', [LegacyBookingController::class, 'show'])->name('bookings.show-legacy');
    Route::post('tee-times/{teeTime}/bookings/legacy', [LegacyBookingController::class, 'store'])->name('bookings.store-legacy');
    Route::post('golfers/{golfer}/roles/legacy', [LegacyGolferRoleController::class, 'store'])->name('golfers.roles.store-legacy');
    Route::patch('golfers/{golfer}/roles/{role}/legacy', [LegacyGolferRoleController::class, 'update'])->name('golfers.roles.update-legacy');
    Route::get('golfers/{golfer}/bookings/legacy', [LegacyGolferBookingController::class, 'index'])->name('golfers.bookings.index-legacy');
    Route::get('bookings/{booking}/ownership/legacy', [LegacyBookingOwnershipController::class, 'show'])->name('bookings.ownership-legacy');
    Route::post('bookings/{booking}/cancel/legacy', [LegacyBookingCancellationController::class, 'store'])->name('bookings.cancel-legacy');
    Route::post('bookings/{booking}/transfer/legacy', [LegacyBookingTransferController::class, 'store'])->name('bookings.transfer-legacy');
    Route::get('pro-shop/legacy', [LegacyProShopDashboardController::class, 'index'])->name('pro-shop.index-legacy');
});

require __DIR__.'/settings.php';
