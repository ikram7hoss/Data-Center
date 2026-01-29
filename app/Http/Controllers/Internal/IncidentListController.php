<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentListController extends Controller
{
    public function index()
    {
        // Récupère les incidents de l'utilisateur connecté
        $incidents = Incident::where('user_id', auth()->id())->latest()->get();
        return view('internal.incidents.index', compact('incidents'));
    }
}
