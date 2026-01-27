<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ressource;
use App\Models\User;
use App\Models\Demande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DataCenterController extends Controller
{
    /**
     * Affiche le catalogue pour les invités avec les vraies données techniques.
     */
    public function catalogue()
    {
        // On utilise 'with' pour charger les relations et éviter les "N/A"
        $ressources = Ressource::with(['serveur', 'machineVirtuelle'])
            ->get();

        return view('invite', compact('ressources'));
    }

    /**
     * Affiche le formulaire de création de compte.
     */
    public function creationCompte()
    {
        return view('datacenter.demande');
    }

    /**
     * Enregistre une nouvelle demande d'ouverture de compte.
     */
    public function storeDemande(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role_souhaite' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role_souhaite,
            'status' => 'en_attente'
        ]);

        return redirect('/espace-invite')->with('success', 'Votre demande a été envoyée !');
    }

    /**
     * Dashboard du Responsable.
     */
    public function index()
    {
        $resources = Ressource::with(['serveur', 'machineVirtuelle'])
                    ->where('manager_id', Auth::id())
                    ->get();

        $demandes = Demande::whereIn('ressource_id', $resources->pluck('id'))
                    ->get()
                    ->map(function($demande) {
                        $demande->status = 'En attente';
                        return $demande;
                    });

        return view('responsable.dashboard', compact('resources', 'demandes'));
    }
}
