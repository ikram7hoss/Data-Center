<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataCenterController;

Route::get('/', function () {
    return view('welcome');
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