<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemandeCompteController extends Controller
{
    public function create()
    {
        return view('auth.demande');
    }

    public function store(Request $request)
    {
    // On valide les données reçues
        $request->validate([
            'nom_complet' => 'required',
            'email' => 'required|email|unique:compte_demandes,email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        // Création de la demande
        \App\Models\CompteDemande::create([
            'nom_complet' => $request->nom_complet,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            'status' => 'en_attente'
        ]);

        // Notifier les administrateurs
        $admins = \App\Models\User::where('type', 'admin')
                    ->orWhereHas('roles', function ($query) {
                        $query->where('name', 'admin');
                    })->get();
                    
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'type' => 'account_request',
                'title' => 'Nouvelle demande de compte',
                'message' => "Nouvelle demande de {$request->nom_complet} ({$request->role})",
                'status' => 'unread'
            ]);
        }

        // Pour l'instant, on redirige avec un message de succès
        return redirect()->route('demande.create')->with('success', 'Ta demande a bien été envoyée ! Elle sera traitée par un administrateur.');
    }
}
