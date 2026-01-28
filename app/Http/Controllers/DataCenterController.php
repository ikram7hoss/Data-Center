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
        $resources = Ressource::where('manager_id', Auth::id())->get();
        // On crée une collection de tests pour simuler des demandes réelles 
        $demandes = collect([(object)['id' => 1, 'user' => (object)['name' => 'Jean Dupont'], 'ressource' => (object)['name' => 'Serveur i30'], 'periode_start' => '2026-02-01', 'periode_end' => '2026-02-10', 'status' => 'En attente']]);
        // Récupération de tes ressources (manager_id ajouté en SQL) $resources = Ressource::with(['serveur', 'machineVirtuelle']) ->where('manager_id', Auth::id()) ->get(); // Récupération des demandes liées à tes ressources
        $demandes = Demande::whereIn('ressource_id', $resources->pluck('id'))->get()->map(function ($demande) {
            // Statut virtuel pour éviter l'erreur de colonne manquante 
            $demande->status = 'En attente';
            return $demande;
        });
        return view('responsable.dashboard', compact('resources', 'demandes'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required|string',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'cpu' => 'nullable|string',
            'ram' => 'nullable|string',
            'storage' => 'nullable|string',
            'os' => 'nullable|string',
            'ip_address' => 'nullable|string',
            'network' => 'nullable|string',
        ]);

        $resource = Ressource::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'status' => $validated['status'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'is_active' => true,
            'data_center_id' => 1,
        ]);

        $resource->serveur()->create([
            'cpu' => $validated['cpu'],
            'ram' => $validated['ram'],
            'storage' => $validated['storage'],
            'os' => $validated['os'],
            'ip_address' => $validated['ip_address'],
            'network' => $validated['network'],
        ]);

        return redirect()->back()->with('success', 'Ressource et spécifications créées avec succès !');
    }

    public function update(Request $request, $id)
    {
        $resource = Ressource::findOrFail($id);

        // 1. Mise à jour de la table principale 'ressources'
        // On ajoute 'type', 'os', 'location', 'status' et 'description' qui manquaient
        $resource->update($request->only([
            'name',
            'type',
            'os',
            'location',
            'status',
            'is_active',
            'description'
        ]));

        // 2. Mise à jour de la table liée 'serveurs' (si elle existe)
        if ($resource->serveur) {
            $resource->serveur->update($request->only([
                'cpu',
                'ram',
                'storage',
                'ip_address'
            ]));
        }

        return redirect()->back()->with('success', 'Ressource mise à jour avec succès');
    }

    // ATTENTION: Cette fonction plantera tant que la table 'demandes' n'a pas de colonne 'status'
    public function handleDemande(Request $request, $id, $action)
    {
        return redirect()->back()->with('error', 'Action impossible : la colonne status est manquante dans la table demandes.');
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

        // 2. On récupère uniquement les demandes qui correspondent au statut de l'onglet
        // On utilise 'with' pour charger les infos de la ressource sans faire trop de requêtes
        $demandes = Demande::with('ressource')
            ->where('status', $tab)
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. On renvoie la vue avec les données filtrées et le nom de l'onglet actuel
        $demandes = Demande::with('user')->get();
        return view('responsable.demandes', compact('demandes'));
    }

    public function approuver($id)
    {
        $demande = Demande::findOrFail($id);
        $demande->update(['status' => 'approuvee', 'approved_at' => now()]);

        // --- ENVOI DE NOTIFICATION À L'UTILISATEUR ---
        Notification::create([
            'user_id' => $demande->user_id, // L'utilisateur qui a fait la demande
            'title'   => 'Demande approuvée ✅',
            'message' => 'Votre demande pour la ressource ' . ($demande->ressource->name ?? '') . ' a été acceptée.',
            'type'    => 'status_update',
            'status'  => 'unread'
        ]);

        return redirect()->back()->with('success', 'Demande approuvée et utilisateur notifié !');
    }

    public function refuser(Request $request, $id)
    {
        $request->validate(['raison_refus' => 'required|min:5']);

        $demande = Demande::findOrFail($id);
        $demande->update([
            'status' => 'refusee',
            'raison_refus' => $request->raison_refus,
            'refused_at' => now()
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
