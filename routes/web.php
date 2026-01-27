<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataCenterController;
use App\Http\Controllers\DemandeCompteController; // On le garde une seule fois ici

Route::get('/', function () {
    return view('welcome');
});

// Catalogue des ressources
Route::get('/espace-invite', [DataCenterController::class, 'catalogue']);

// Affichage du formulaire
Route::get('/demande-compte', [DataCenterController::class, 'creationCompte']);

// Envoi du formulaire (On utilise la route 'compte.store' que tu as dans ton HTML)
Route::post('/envoi-demande', [DemandeCompteController::class, 'store'])->name('compte.store');
