<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ressource;
use App\Models\Demande;
use App\Models\Message; // Assure-toi que le modèle Message existe
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataCenterController extends Controller
{
    public function index()
    {
        $resources = Ressource::where('manager_id', Auth::id())->get();

    // On crée une collection de tests pour simuler des demandes réelles
    $demandes = collect([
        (object)[
            'id' => 1,
            'user' => (object)['name' => 'Jean Dupont'],
            'ressource' => (object)['name' => 'Serveur i30'],
            'periode_start' => '2026-02-01',
            'periode_end' => '2026-02-10',
            'status' => 'En attente'
        ]
    ]);

        // Récupération de tes ressources (manager_id ajouté en SQL)
        $resources = Ressource::with(['serveur', 'machineVirtuelle'])
                    ->where('manager_id', Auth::id())
                    ->get();

        // Récupération des demandes liées à tes ressources
        $demandes = Demande::whereIn('ressource_id', $resources->pluck('id'))
                    ->get()
                    ->map(function($demande) {
                        // Statut virtuel pour éviter l'erreur de colonne manquante
                        $demande->status = 'En attente';
                        return $demande;
                    });

        return view('responsable.dashboard', compact('resources', 'demandes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
        ]);

        $resource = Ressource::create([
            'name' => $request->name,
            'type' => $request->type,
            'status' => 'disponible', // Cette colonne existe dans 'ressources'
            'is_active' => true,
            'manager_id' => Auth::id(),
        ]);

        if ($request->type == 'Serveur' || $request->type == 'Serveur Physique') {
            $resource->serveur()->create([
                'cpu' => $request->cpu ?? 'N/A',
                'ram' => $request->ram ?? 'N/A',
                'ip_address' => $request->ip_address ?? '0.0.0.0',
            ]);
        }

        return redirect()->back()->with('success', 'Nouvelle ressource ajoutée.');
    }

    public function update(Request $request, $id)
    {
        $resource = Ressource::findOrFail($id);
        $resource->update($request->only(['name', 'is_active']));

        if ($resource->serveur) {
            $resource->serveur->update($request->only(['cpu', 'ram', 'storage', 'ip_address']));
        }
        return redirect()->back()->with('success', 'Ressource mise à jour');
    }

    // ATTENTION: Cette fonction plantera tant que la table 'demandes' n'a pas de colonne 'status'
    public function handleDemande(Request $request, $id, $action)
    {
        return redirect()->back()->with('error', 'Action impossible : la colonne status est manquante dans la table demandes.');
    }

    public function demandes()
{
    // On récupère les IDs de tes ressources pour filtrer les demandes
    $resourceIds = \App\Models\Ressource::where('manager_id', auth()->id())->pluck('id');

    // On récupère les demandes liées
    $demandes = \App\Models\Demande::whereIn('ressource_id', $resourceIds)
        ->get()
        ->map(function($demande) {
            $demande->status = 'En attente'; // Statut virtuel pour le test
            return $demande;
        });

    return view('responsable.demandes', compact('demandes'));
}
public function storeCompte(Request $request)
    {
        $request->validate([
            'nom'      => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required'
        ]);

        \App\Models\User::create([
            'name'     => $request->nom,
            'email'    => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->back()->with('success', 'Votre demande a été envoyée avec succès !');
    }
}
