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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

// --- Routes Publiques ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/espace-invite', function () {
    $resources = \App\Models\Ressource::all();
    return view('espace-invite', compact('resources'));
})->name('espace.invite');

Route::get('/demande-compte', [DemandeCompteController::class, 'create'])->name('demande.create');
Route::post('/demande-compte', [DemandeCompteController::class, 'store'])->name('compte.store');

// --- Authentification ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Redirection intelligente après login
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('internal.dashboard');
})->middleware(['auth'])->name('dashboard');

// --- Auth scaffolding routes (for tests) ---
Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', function (Request $request, string $id, string $hash) {
    $user = User::findOrFail($id);

    if (!hash_equals((string) $hash, sha1($user->email))) {
        abort(403);
    }

    if (is_null($user->email_verified_at)) {
        $user->email_verified_at = now();
        $user->save();
        event(new Verified($user));
    }

    return redirect(route('dashboard', absolute: false).'?verified=1');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/confirm-password', function () {
    return view('auth.confirm-password');
})->middleware('auth')->name('password.confirm');

Route::post('/confirm-password', function (Request $request) {
    $request->validate([
        'password' => ['required'],
    ]);

    if (!Hash::check($request->password, $request->user()->password)) {
        return back()->withErrors(['password' => __('auth.password')]);
    }

    $request->session()->passwordConfirmed();
    return redirect()->intended();
})->middleware('auth');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => ['required', 'email']]);

    Password::sendResetLink($request->only('email'));

    return back();
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required', 'confirmed', PasswordRule::defaults()],
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.store');

// --- ADMIN ROUTES ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    
    Route::get('/statistics', [AdminController::class, 'index'])->name('statistics'); 
    Route::get('/maintenance', [AdminController::class, 'index'])->name('maintenance');

    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('/notifications/read', [AdminController::class, 'markNotificationsRead'])->name('notifications.read');

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

// --- Espace Interne (Ton travail) ---
Route::middleware(['auth'])->prefix('internal')->name('internal.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{demande}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    
    Route::get('/incidents', [IncidentListController::class, 'index'])->name('incidents.index');
    Route::get('/incidents/create/{reservation_id?}', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents/store', [IncidentController::class, 'store'])->name('incidents.store');
    Route::get('/incidents/{id}', [IncidentShowController::class, 'show'])->name('incidents.show');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});
