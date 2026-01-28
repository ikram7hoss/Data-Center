<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\Incident;

class IncidentShowController extends Controller
{
    public function show(Incident $incident)
    {
        $incident->load(['ressource','user']);
        return view('internal.incidents.show', compact('incident'));
    }
}
