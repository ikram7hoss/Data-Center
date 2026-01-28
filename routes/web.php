<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Internal\ResourceController;
use App\Http\Controllers\Internal\ReservationController;
use App\Http\Controllers\Internal\IncidentController;
use App\Http\Controllers\Internal\NotificationController;
use App\Http\Controllers\Internal\IncidentListController;
use App\Http\Controllers\Internal\IncidentShowController;
use App\Http\Controllers\Internal\DashboardController;

// --- Routes Publiques ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/espace-invite', function () {
    return view('espace-invite');
})->name('espace.invite');

Route::get('/demande-compte', [\App\Http\Controllers\DemandeCompteController::class, 'create'])->name('demande.create');

// --- Authentification ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Espace Interne (Connecté) ---
Route::middleware(['auth'])->prefix('internal')->name('internal.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil (Utilise le ProfileController à la racine comme convenu)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Ressources
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');

    // Réservations
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/my-reservations/{demande}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    // Incidents
    Route::get('/incidents', [IncidentListController::class, 'index'])->name('incidents.index');
    Route::get('/incidents/create/{reservation_id?}', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents/store', [IncidentController::class, 'store'])->name('incidents.store');
    Route::get('/incidents/{incident}', [IncidentShowController::class, 'show'])->name('incidents.show');
});






