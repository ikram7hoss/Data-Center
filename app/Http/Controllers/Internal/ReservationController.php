<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ressource;
use App\Models\Demande;
use Illuminate\Support\Facades\Auth;


class ReservationController extends Controller
{
   public function create()
{
    $ressources = Ressource::orderBy('name')->get();
    return view('internal.reservations.create', compact('ressources'));
}
public function show(\App\Models\Demande $demande)
{
    $demande->load('ressource');
    return view('internal.reservations.show', compact('demande'));
}

public function index(Request $request)
{
    $query = Demande::where('user_id', Auth::id())->with('ressource');

    // Filtre par Statut (ton Blade utilise en_attente, approuvee, etc.)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filtre par Ressource
    if ($request->filled('ressource_id')) {
        $query->where('ressource_id', $request->ressource_id);
    }

    // Filtres par Dates (Période)
    if ($request->filled('from')) {
        $query->where('periode_start', '>=', $request->from);
    }
    if ($request->filled('to')) {
        $query->where('periode_end', '<=', $request->to);
    }

    $demandes = $query->orderBy('created_at', 'desc')->get();
    
    // Nécessaire pour le menu déroulant du filtre dans la vue
    $ressources = Ressource::orderBy('name')->get();

    return view('internal.reservations.index', compact('demandes', 'ressources'));
}

public function store(Request $request)
{

    $data = $request->validate([
        'ressource_id'   => ['required', 'exists:ressources,id'],
        'periode_start'  => ['required', 'date'],
        'periode_end'    => ['required', 'date', 'after_or_equal:periode_start'],
        'justification'  => ['nullable', 'string'],
    ]);

    $data['user_id'] = Auth::id() ?? 1; 
    $data['status'] = 'en_attente';
    $conflict = Demande::where('ressource_id', $data['ressource_id'])
      ->whereIn('status', ['en_attente', 'approuvee', 'active'])
    ->where(function ($q) use ($data) {
        $q->whereBetween('periode_start', [$data['periode_start'], $data['periode_end']])
          ->orWhereBetween('periode_end', [$data['periode_start'], $data['periode_end']])
          ->orWhere(function ($q2) use ($data) {
              $q2->where('periode_start', '<=', $data['periode_start'])
                 ->where('periode_end', '>=', $data['periode_end']);
          });
    })
    ->exists();

if ($conflict) {
    return back()->withErrors(['periode_start' => 'Conflit: ressource déjà réservée sur cette période.'])
                 ->withInput();
}



    Demande::create($data);

    return redirect()->route('internal.reservations.index');
}
public function destroy($id)
{
    $demande = Demande::where('user_id', auth()->id())
        ->whereIn('status', ['en_attente', 'refusee'])
        ->findOrFail($id);

    $demande->delete();

    return redirect()->route('internal.reservations.index')
                     ->with('success', 'La demande a été annulée avec succès.');
}
}

