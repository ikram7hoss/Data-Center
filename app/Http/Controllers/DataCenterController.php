<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ressource;
use App\Models\Demande; 
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataCenterController extends Controller
{
    public function index()
    {
        // Get resources managed by the current user
        $resources = Ressource::where('manager_id', Auth::id())->with(['serveur', 'machineVirtuelle'])->get();
        
        // Get demands related to these resources
        $demandes = Demande::whereIn('ressource_id', $resources->pluck('id'))
                           ->with(['user', 'ressource'])
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('responsable.dashboard', compact('resources', 'demandes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'cpu' => 'nullable|string',
            'ram' => 'nullable|string',
            'stockage' => 'nullable|string',
            'os' => 'nullable|string',
            'ip_address' => 'nullable|string',
            'network' => 'nullable|string',
        ]);

        $resource = Ressource::create([
            'name' => $request->name,
            'type' => $request->type,
            'status' => 'disponible',
            'is_active' => true,
            'manager_id' => Auth::id(), // Assign to current manager
        ]);

        // Create specific details based on type
        if ($validated['type'] == 'serveur') {
             $resource->serveur()->create([
                'cpu' => $validated['cpu'] ?? 'N/A',
                'ram' => $validated['ram'] ?? 'N/A',
                'stockage' => $validated['stockage'] ?? 'N/A',
                'os' => $validated['os'] ?? 'N/A',
                'ip_address' => $validated['ip_address'] ?? '0.0.0.0',
                'network' => $validated['network'] ?? 'N/A',
            ]);
        } elseif ($validated['type'] == 'machine_virtuelle') {
             $resource->machineVirtuelle()->create([
                'cpu' => $validated['cpu'] ?? 'N/A',
                'ram' => $validated['ram'] ?? 'N/A',
                'stockage' => $validated['stockage'] ?? 'N/A',
                'os' => $validated['os'] ?? 'N/A',
                'adresse_ip' => $validated['ip_address'] ?? '0.0.0.0', 
                'bande_passante' => is_numeric($validated['network'] ?? 0) ? ($validated['network'] ?? 0) : 0,
            ]);
        }

        return redirect()->back()->with('success', 'Ressource et spécifications créées avec succès !');
    }

    public function update(Request $request, $id)
    {
        $resource = Ressource::findOrFail($id);
        
        // Ensure the user manages this resource
        if ($resource->manager_id !== Auth::id() && Auth::user()->type !== 'admin') {
             // Optional: Authorized check logic could go here
        }

        // Capture old status
        $oldStatus = $resource->status;

        // 1. Mise à jour de la table principale 'ressources'
        $resource->update($request->only([
            'name',
            'type',
            'os',
            'location',
            'status',
            'is_active',
            'description'
        ]));

        // Check if status changed
        if ($oldStatus !== $resource->status) {
            // Find all admins
            $admins = \App\Models\User::where('type', 'admin')->get();
            
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'title'   => 'Changement de statut',
                    'message' => "La ressource '{$resource->name}' est passée du statut '{$oldStatus}' à '{$resource->status}'.",
                    'type'    => 'resource_update',
                    'status'  => 'unread'
                ]);
            }
        }

        // 2. Mise à jour des spécifications détaillées
        if ($resource->serveur) {
            $resource->serveur->update($request->only([
                'cpu', 'ram', 'stockage', 'ip_address', 'os', 'network'
            ]));
        } elseif ($resource->machineVirtuelle) {
             $resource->machineVirtuelle->update([
                'cpu' => $request->cpu,
                'ram' => $request->ram,
                'stockage' => $request->stockage,
                'os' => $request->os,
                'adresse_ip' => $request->ip_address,
                // 'bande_passante' => $request->network // Optional mapping
             ]);
        }

        return redirect()->back()->with('success', 'Ressource mise à jour');
    }

    public function handleDemande(Request $request, $id, $action) 
    {
        $demande = Demande::findOrFail($id);

        if ($action === 'approve') {
            $demande->update([
                'status' => 'approuvee',
                'approved_at' => now(),
                'responsable_id' => Auth::id()
            ]);
            
             // Notification au demandeur
             Notification::create([
                'user_id' => $demande->user_id,
                'title'   => 'Demande approuvée ✅',
                'message' => 'Votre demande pour la ressource ' . ($demande->ressource->name ?? '') . ' a été acceptée.',
                'type'    => 'status_update',
                'status'  => 'unread'
            ]);

             return redirect()->back()->with('success', 'Demande approuvée.');

        } elseif ($action === 'refuse') {
             $demande->update([
                'status' => 'refusee',
                'refused_at' => now(),
                'responsable_id' => Auth::id()
            ]);

            // Notification au demandeur
            Notification::create([
                'user_id' => $demande->user_id,
                'title'   => 'Demande refusée ❌',
                'message' => 'Votre demande a été refusée.',
                'type'    => 'status_update',
                'status'  => 'unread'
            ]);

             return redirect()->back()->with('success', 'Demande refusée.');
        }

        return redirect()->back()->with('error', 'Action non reconnue.');
    }

    public function delete(Ressource $resource)
    {
        try {
            $resource->delete();

            return redirect()->back()->with('success', 'Ressource supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression.');
        }
    }

    public function demandes(Request $request)
    {
        // 1. On récupère l'onglet cliqué (par défaut 'en_attente')
        $tab = $request->get('tab', 'en_attente');

        // Resources managed by this user
        $resourceIds = Ressource::where('manager_id', Auth::id())->pluck('id');

        // 2. On récupère uniquement les demandes qui correspondent au statut de l'onglet et aux ressources gérées
        $demandes = Demande::with(['ressource', 'user'])
            ->whereIn('ressource_id', $resourceIds)
            ->where('status', $tab)
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. On renvoie la vue avec les données
        return view('responsable.demandes', compact('demandes'));
    }

    public function approuver($id)
    {
        // Wrapper for handleDemande or specific implementation if needed
        // For now, redirecting to handleDemande logic or implementing directly
        // Given handleDemande exists, we might not need this if routes use handleDemande.
        // But keeping it if routes point here.
        return $this->handleDemande(request(), $id, 'approve');
    }

    public function refuser(Request $request, $id)
    {
        $request->validate(['raison_refus' => 'required|min:5']);

        $demande = Demande::findOrFail($id);
        $demande->update([
            'status' => 'refusee',
            'raison_refus' => $request->raison_refus,
            'refused_at' => now(),
            'responsable_id' => Auth::id()
        ]);

        // --- ENVOI DE NOTIFICATION À L'UTILISATEUR ---
        Notification::create([
            'user_id' => $demande->user_id,
            'title'   => 'Demande refusée ❌',
            'message' => 'Votre demande a été refusée. Motif : ' . $request->raison_refus,
            'type'    => 'status_update',
            'status'  => 'unread'
        ]);

        return redirect()->back()->with('success', 'Demande refusée et utilisateur notifié.');
    }

    public function moderation()
    {
        // Récupère uniquement les notifications du responsable connecté
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Récupère les messages de discussion pour modération
        $messages = Message::with(['user', 'ressource'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('responsable.moderation', compact('notifications', 'messages'));
    }

    public function getLatestNotifications()
    {
        $notifications = Message::where('is_notified', true)
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications
        ]);
    }

    public function clearNotifications()
    {
        Message::where('is_notified', true)
            ->update(['is_notified' => false]);

        return response()->json(['success' => true]);
    }

    public function report($id)
    {
        // Recherche du message par son ID
        $message = \App\Models\Message::findOrFail($id);

        // Mise à jour du statut vers 'reported'
        $message->update(['status' => 'reported']);

        // Retour à la page précédente avec message de succès
        return back()->with('success', 'Le message a été signalé et marqué en rouge.');
    }

    // Action pour le bouton Accepter (le check vert)
    public function approve($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['status' => 'approved']);

        // Notification optionnelle pour l'auteur du message
        Notification::create([
            'user_id' => $message->user_id,
            'title'   => 'Message Approuvé',
            'message' => 'Votre message a été validé par le modérateur.',
            'type'    => 'moderation',
            'status'  => 'unread'
        ]);

        return back()->with('success', 'Le message a été marqué comme approuvé.');
    }

    public function markAsRead($id)
    {
        $notification = \App\Models\Notification::findOrFail($id);
        $notification->update(['status' => 'read']);

        return back()->with('success', 'Notification traitée.');
    }

    public function deleteMessage($id)
    {
        // On cherche le message dans la table 'messages'
        $message = Message::find($id);

        if ($message) {
            $message->delete(); // Supprime physiquement la ligne de la base de données
            return redirect()->back()->with('success', 'Le message a été supprimé avec succès.');
        }

        return redirect()->back()->with('error', 'Message introuvable.');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Message supprimé avec succès.');
    }
}
