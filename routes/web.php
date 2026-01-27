<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeCompteController;

Route::get('/', function () {
    return view('welcome');
});

// Routes pour ton formulaire
Route::get('/demande', [DemandeCompteController::class, 'create'])->name('demande.create');
Route::post('/demande', [DemandeCompteController::class, 'store'])->name('compte.store');

// Route pour l'espace invité (pour corriger ton erreur 404)
Route::get('/espace-invite', function () {
    return view('espace-invite');
})->name('espace.invite');
