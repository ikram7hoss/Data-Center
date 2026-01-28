<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataCenterController;
use App\Models\Notification;

Route::get('/', function () {
    return view('welcome');
});

// --- DASHBOARD PRINCIPAL ---
Route::get('/responsable/dashboard', [DataCenterController::class, 'index'])->name('resp.dashboard');

// --- GESTION DES RESSOURCES (Modifier & Mettre à jour) ---
Route::get('/responsable/resource/{id}/edit', [DataCenterController::class, 'edit'])->name('resource.edit');
Route::put('/responsable/resource/{id}/update', [DataCenterController::class, 'update'])->name('resource.update');
// Route pour ajouter une nouvelle ressource
Route::post('/responsable/resource/store', [DataCenterController::class, 'store'])->name('resource.store');
// supp un ressource
Route::delete('/responsable/resource/{resource}', [DataCenterController::class, 'delete'])->name('resource.delete');

// --- GESTION DES DEMANDES (Approuver / Refuser) ---
// Route pour afficher la liste (C'est celle-ci qui manquait sans doute)
Route::get('/responsable/demandes', [DataCenterController::class, 'demandes'])->name('responsable.demandes');
// On utilise une route dynamique pour l'action (approuver ou refuser)
Route::prefix('responsable')->name('demandes.')->group(function () {
    Route::post('/demandes/{id}/approuver', [DataCenterController::class, 'approuver'])->name('approuver');
    Route::post('/demandes/{id}/refuser', [DataCenterController::class, 'refuser'])->name('refuser');
});
// --- MODÉRATION ---
// afficher la page
Route::get('/responsable/moderation', [DataCenterController::class, 'moderation'])->name('responsable.moderation');

//suppression (C'est celle-ci qui cause souvent la 404 si elle manque)
Route::delete('/responsable/moderation/{id}', [DataCenterController::class, 'destroy'])->name('moderation.delete');
Route::delete('/moderation/message/{id}', [DataCenterController::class, 'deleteMessage'])->name('moderation.delete');
Route::post('/responsable/moderation/{id}/approve', [DataCenterController::class, 'approve'])->name('moderation.approve');
Route::post('/responsable/moderation/{id}/report', [DataCenterController::class, 'report'])->name('moderation.report');
Route::delete('/moderation/delete/{id}', [DataCenterController::class, 'destroy'])->name('moderation.delete');
Route::post('/notifications/read/{id}', [DataCenterController::class, 'markAsRead'])->name('notifications.read');

Route::get('/api/notifications/latest', function () {
    return response()->json([
        'count' => \App\Models\Notification::where('user_id', auth()->id())->where('status', 'unread')->count(),
        'notifications' => \App\Models\Notification::where('user_id', auth()->id())
                            ->where('status', 'unread')
                            ->orderBy('created_at', 'desc')->get()
    ]);
});

Route::get('/api/notifications/latest', [DataCenterController::class, 'getLatestNotifications'])
         ->name('api.notifications.latest');
Route::post('/api/notifications/clear', [DataCenterController::class, 'clearNotifications']);


Route::patch('/notifications/{id}/read', [DataCenterController::class, 'markAsRead'])->name('notifications.markAsRead');