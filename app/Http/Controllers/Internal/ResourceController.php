<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ressource;

class ResourceController extends Controller
{
 public function index(Request $request)
{
    $query = \App\Models\Ressource::query();

    // Filtres
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $ressources = $query->get();
    
    // Définition des types demandés
    $types = [
        'machines_virtuelles' => 'Machines Virtuelles',
        'baies_stockage' => 'Baies de Stockage',
        'equipements_reseau' => 'Équipements Réseau'
    ];

    return view('internal.resources.index', compact('ressources', 'types'));
}
}

