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
use App\Http\Controllers\DataCenterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemandeCompteController;

// --- Routes Publiques ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/espace-invite', function () {
    $resources = \App\Models\Ressource::all();
    return view('espace-invite', compact('resources'));
})->name('espace.invite');

Route::get('/demande-compte', [DemandeCompteController::class, 'create'])->name('demande.create');

// --- Authentification ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirection intelligente après login
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('internal.dashboard');
})->middleware(['auth']);

// --- ADMIN ROUTES ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::post('/users/{id}/update-role', [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::get('/resources', [AdminController::class, 'resources'])->name('resources');
    Route::post('/resources', [AdminController::class, 'storeResource'])->name('resources.store');
    Route::get('/demandes', [AdminController::class, 'demandes'])->name('demandes');
    Route::post('/demandes/{id}/approve', [AdminController::class, 'approveDemande'])->name('demandes.approve');
    Route::post('/demandes/{id}/refuse', [AdminController::class, 'refuseDemande'])->name('demandes.refuse');
});

// --- RESPONSABLE ROUTES ---
Route::middleware(['auth'])->prefix('responsable')->group(function () {
    Route::get('/dashboard', [DataCenterController::class, 'index'])->name('resp.dashboard');
    Route::get('/demandes', [DataCenterController::class, 'demandes'])->name('responsable.demandes');
    Route::post('/demandes/{id}/approuver', [DataCenterController::class, 'approuver'])->name('demandes.approuver');
    Route::post('/demandes/{id}/refuser', [DataCenterController::class, 'refuser'])->name('demandes.refuser');
});

// --- Espace Interne ---
Route::middleware(['auth'])->prefix('internal')->name('internal.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    // 1. Route pour la mise à jour du mot de passe
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    
    // 2. Routes pour les Incidents (Liste + Détails + Création)
    Route::get('/incidents', [IncidentListController::class, 'index'])->name('incidents.index');
    Route::get('/incidents/create/{reservation_id?}', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents/store', [IncidentController::class, 'store'])->name('incidents.store');
    Route::get('/incidents/{id}', [IncidentShowController::class, 'show'])->name('incidents.show'); // <--- Route manquante ajoutée

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    
    // 3. Route pour marquer une notification comme lue
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});


