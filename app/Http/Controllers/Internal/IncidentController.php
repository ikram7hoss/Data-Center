<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Ressource;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function create(Request $request)
{

    $selected_resource_id = $request->query('ressource_id');
    $selected_reservation_id = $request->query('reservation_id');


    $ressources = \App\Models\Ressource::orderBy('name')->get();

    return view('internal.incidents.create', compact('ressources', 'selected_resource_id', 'selected_reservation_id'));
}
   public function store(Request $request)
{
    $data = $request->validate([
        'ressource_id' => ['required', 'exists:ressources,id'],
        'title'        => ['required', 'string', 'max:255'],
        'description'  => ['required', 'string'],
        'severity'     => ['required', 'in:low,medium,high'],
    ]);

    $data['user_id'] = auth()->id();      
    $data['status'] = 'open';  

    \App\Models\Incident::create($data);


    \App\Models\Notification::create([
        'user_id' => $data['user_id'],
        'type'    => 'incident',
        'title'   => 'Incident envoyé',
        'message' => 'Votre incident concernant la ressource #'.$data['ressource_id'].' a été enregistré.',
        'status'  => 'unread',
    ]);


    return redirect()->route('internal.incidents.index')
                     ->with('success', 'Incident signalé avec succès.');
}

}