<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\Notification;
use App\Models\Incident;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'active_reservations' => Demande::where('user_id', $userId)->where('status', 'active')->count(),
            'pending_requests'    => Demande::where('user_id', $userId)->where('status', 'en_attente')->count(),
            'unread_notifications' => Notification::where('user_id', $userId)->where('status', 'unread')->count(),
            'open_incidents'      => Incident::where('user_id', $userId)->where('status', 'open')->count(),
        ];

        $recentDemandes = Demande::where('user_id', $userId)
            ->with('ressource')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('internal.dashboard', compact('stats', 'recentDemandes'));
    }
}

