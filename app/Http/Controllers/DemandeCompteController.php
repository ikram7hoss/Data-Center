<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompteDemande;

class DemandeCompteController extends Controller {
    public function store(Request $request) {
        CompteDemande::create([
            'nom_complet' => $request->nom_complet,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

       return redirect()->back()->with('success', 'Votre demande a bien été envoyée !');
    }
}
