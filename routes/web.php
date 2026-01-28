<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataCenterController;
use App\Http\Controllers\Internal\ResourceController;
use App\Http\Controllers\Internal\ReservationController;
use App\Http\Controllers\Internal\IncidentController;
use App\Http\Controllers\Internal\NotificationController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->prefix('internal')->name('internal.')->group(function () {
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');

    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/my-reservations/{demande}', [ReservationController::class, 'show'])->name('reservations.show');

    Route::get('/incidents/create', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});


