<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeCompteController;

// 1. Accueil -> Affiche direct les catalogues
Route::get('/', function () {
    return view('espace-invite');
});

// 2. Affichage du formulaire
Route::get('/demande', [DemandeCompteController::class, 'create'])->name('demande.create');

// 3. Envoi du formulaire (pour ne plus avoir l'écran noir dd)
Route::post('/demande', [DemandeCompteController::class, 'store'])->name('compte.store');
