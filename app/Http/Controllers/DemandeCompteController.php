<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemandeCompteController extends Controller
{
    public function create()
    {
        return view('demande');
    }

    public function store(Request $request)
    {
        // On valide les données reçues
        $request->validate([
            'nom_complet' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        // Pour l'instant, on redirige avec un message de succès
        return redirect()->route('demande.create')->with('success', 'Ta demande a bien été envoyée !');
    }
}
