<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataCenterController;
use App\Http\Controllers\DemandeCompteController; // On le garde une seule fois ici

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth');

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

// Catalogue des ressources
Route::get('/espace-invite', [DataCenterController::class, 'catalogue']);

// Affichage du formulaire
Route::get('/demande-compte', [DataCenterController::class, 'creationCompte']);

<<<<<<< HEAD
// Envoi du formulaire (On utilise la route 'compte.store' que tu as dans ton HTML)
Route::post('/envoi-demande', [DemandeCompteController::class, 'store'])->name('compte.store');
=======
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
Route::post('/demande-compte', [App\Http\Controllers\DataCenterController::class, 'storeCompte'])->name('compte.store');
// Groupe protégé pour l'ADMIN
Route::middleware(['auth', 'CheckRole:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
});

// Groupe protégé pour l'INTERNE
Route::middleware(['auth', 'CheckRole:interne'])->group(function () {
    Route::get('/responsable/dashboard', [App\Http\Controllers\DataCenterController::class, 'index'])->name('responsable.dashboard');
});
>>>>>>> main
