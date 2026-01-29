<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function create($reservation_id)
{
    return view('internal.incidents.create', compact('reservation_id'));
}

public function store(Request $request)
{
    $request->validate([
        'ressource_id' => 'required|exists:ressources,id',
        'title' => 'required|string|max:255',
        'description' => 'required',
        'severity' => 'required|in:low,medium,high',
    ]);

    Incident::create([
        'user_id' => auth()->id(),
        'ressource_id' => $request->ressource_id,
        'title' => $request->title,
        'description' => $request->description,
        'severity' => $request->severity,
        'status' => 'ouvert',
    ]);

    return redirect()->route('internal.reservations.index')->with('success', 'Incident signalé.');
}
}
