<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataCenterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    // Redirect other roles to their specific dashboards (to be implemented)
    // For now, default to admin or welcome
    return redirect()->route('admin.dashboard'); 
})->middleware(['auth']);

// --- ADMIN ROUTES ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::post('/users/{id}/toggle-status', [App\Http\Controllers\AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::post('/users/{id}/update-roles', [App\Http\Controllers\AdminController::class, 'updateUserRoles'])->name('users.update-roles');
    Route::post('/users/{id}/update-role', [App\Http\Controllers\AdminController::class, 'updateUserRole'])->name('users.role');

    // Resource Management
    Route::get('/resources', [App\Http\Controllers\AdminController::class, 'resources'])->name('resources');
    Route::post('/resources', [App\Http\Controllers\AdminController::class, 'storeResource'])->name('resources.store');
    Route::post('/resources/{id}/update-details', [App\Http\Controllers\AdminController::class, 'updateResourceDetails'])->name('resources.update-details');
    Route::post('/resources/{id}/maintenance', [App\Http\Controllers\AdminController::class, 'toggleMaintenance'])->name('resources.maintenance');
    Route::delete('/resources/{id}', [App\Http\Controllers\AdminController::class, 'destroyResource'])->name('resources.destroy');
    
    // Maintenance (Placeholder)
    Route::get('/maintenance', [App\Http\Controllers\AdminController::class, 'maintenance'])->name('maintenance');
    Route::post('/maintenance', [App\Http\Controllers\AdminController::class, 'storeMaintenance'])->name('maintenance.store');

    // Demandes Management
    Route::get('/demandes', [App\Http\Controllers\AdminController::class, 'demandes'])->name('demandes');
    Route::post('/demandes/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveDemande'])->name('demandes.approve');
    Route::post('/demandes/{id}/refuse', [App\Http\Controllers\AdminController::class, 'refuseDemande'])->name('demandes.refuse');
    
    // Account Requests
    Route::post('/demandes-compte/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveCompteDemande'])->name('demandes-compte.approve');
    Route::post('/demandes-compte/{id}/refuse', [App\Http\Controllers\AdminController::class, 'refuseCompteDemande'])->name('demandes-compte.refuse');

    // Statistics
    Route::get('/statistics', [App\Http\Controllers\AdminController::class, 'statistics'])->name('statistics');

    Route::get('/profile', [App\Http\Controllers\AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\AdminController::class, 'updateProfile'])->name('profile.update');

    // Notifications
    Route::post('/notifications/read', [App\Http\Controllers\AdminController::class, 'markNotificationsRead'])->name('notifications.read');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- DASHBOARD PRINCIPAL ---
Route::get('/responsable/dashboard', [DataCenterController::class, 'index'])->name('resp.dashboard');

// --- GESTION DES RESSOURCES (Modifier & Mettre à jour) ---
Route::get('/responsable/resource/{id}/edit', [DataCenterController::class, 'edit'])->name('resource.edit');
Route::post('/responsable/resource/{id}/update', [DataCenterController::class, 'update'])->name('resource.update');
// Route pour ajouter une nouvelle ressource
Route::post('/responsable/resource/store', [DataCenterController::class, 'store'])->name('resource.store');

// --- GESTION DES DEMANDES (Approuver / Refuser) ---
// On utilise une route dynamique pour l'action (approuver ou refuser)
Route::post('/responsable/demande/{id}/{action}', [DataCenterController::class, 'handleDemande'])->name('demande.handle');
// pour afficher uniquement les demandes
Route::get('/responsable/demandes', [DataCenterController::class, 'demandes'])->name('responsable.demandes');
// --- MODÉRATION ---
Route::delete('/message/{id}', [DataCenterController::class, 'deleteMessage'])->name('messages.delete');
//nv routes
use App\Http\Controllers\DemandeCompteController;

// Route pour voir les 4 catalogues serveurs
Route::get('/espace-invite', function () {
    return view('espace-invite');
})->name('espace.invite');

// Routes pour le formulaire de demande de compte
Route::get('/demande-compte', [DemandeCompteController::class, 'create'])->name('demande.create');
Route::post('/demande-compte', [DemandeCompteController::class, 'store'])->name('compte.store');


