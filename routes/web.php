<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\Internal\ResourceController;
use App\Http\Controllers\Internal\ReservationController;
use App\Http\Controllers\Internal\IncidentController;
use App\Http\Controllers\Internal\NotificationController;

Route::group([], function () {
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');

    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/my-reservations/{demande}', [ReservationController::class, 'show'])->name('reservations.show');


    Route::get('/incidents/create', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});
Route::get('/login', function () {
    return 'Login page not implemented yet';
})->name('login');

