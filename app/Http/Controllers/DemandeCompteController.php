<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemandeCompteController extends Controller
{
    public function create()
    {
        return view('demande');
    }

    // C'est ici que tu reçois les données pour tes catalogues
    public function store(Request $request)
    {
        // Cette ligne permet de voir toutes les données envoyées (nom, email, etc.)
        dd($request->all());
    }
}
