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

    public function approve($id)
    {
        $demande = \App\Models\CompteDemande::findOrFail($id);
        
        // Prevent double approval
        if ($demande->status === 'approuvee') {
            return back()->with('error', 'Cette demande a déjà été approuvée.');
        }

        // Create the User
        $user = \App\Models\User::create([
            'name' => $demande->nom_complet,
            'email' => $demande->email,
            'password' => $demande->password, // Already hashed in store()
            'type' => 'utilisateur_interne', // Default type, roles handle specifics
            'is_active' => true,
        ]);

        // Assign Role
        $roleName = $demande->role;
        // Map friendly names to db role names if necessary, or assume they match
        // strict mapping based on value in select: ingenieur, enseignant, doctorant
        $role = \App\Models\Role::where('name', $roleName)->first();
        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
        }

        // Update Demande Status
        $demande->update(['status' => 'approuvee']);

        // Notify Admins/User (Optional, could add notification here)

        return back()->with('success', "Compte créé avec succès pour {$user->name}.");
    }

    public function refuse($id)
    {
        $demande = \App\Models\CompteDemande::findOrFail($id);
        $demande->update(['status' => 'refusee']);

        return back()->with('success', 'Demande refusée.');
    }
}
