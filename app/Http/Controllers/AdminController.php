<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ressource;
use App\Models\Demande;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard with global statistics.
     */
    public function index()
    {
        // Global Statistics
        $totalUsers = User::count();
        $totalResources = Ressource::count();
        $activeReservations = Demande::where('status', 'active')->count();
        $pendingDemandes = Demande::where('status', 'en_attente')->count();

        // Resource Occupation Stats (Simple mock or real logic)
        $occupiedResources = Ressource::whereHas('demandes', function($q) {
            $q->where('status', 'active');
        })->count();
        
        $usagePercentage = $totalResources > 0 ? round(($occupiedResources / $totalResources) * 100) : 0;

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalResources', 
            'activeReservations', 
            'pendingDemandes',
            'usagePercentage'
        ));
    }

    /**
     * List all users for management with filtering.
     */
    public function users(Request $request)
    {
        $query = User::with(['roles.permissions', 'permissions']);

        // Filter by Role
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('id', $request->role);
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $users = $query->get(); 
        $allRoles = \App\Models\Role::with('permissions')->get(); // Load permissions for JS
        $allPermissions = \App\Models\Permission::all();
        
        $rolesWithPermissions = $allRoles->mapWithKeys(function ($role) {
            return [$role->id => $role->permissions->pluck('id')];
        });

        return view('admin.users', compact('users', 'allRoles', 'allPermissions', 'rolesWithPermissions'));
    }

    /**
     * Toggle user active status.
     */
    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        // Prevent disabling yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activé' : 'désactivé';
        return back()->with('success', "Utilisateur {$user->name} {$status}.");
    }

    /**
     * Update user roles.
     */
    public function updateUserRoles(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // 1. Sync Roles
        $newRoles = [];
        if ($request->has('roles')) {
            $newRoles = $request->roles;
            $user->roles()->sync($newRoles);
        } else {
            $user->roles()->detach();
        }

        // 2. Calculate Permissions Diff
        
        // Get all standard permissions provided by the selected roles
        $rolePermissions = \App\Models\Permission::whereHas('roles', function($q) use ($newRoles) {
            $q->whereIn('roles.id', $newRoles);
        })->pluck('id')->toArray();

        // Get permissions the user WANTS (checked in the form)
        $desiredPermissions = $request->input('permissions', []);
        if (is_null($desiredPermissions)) $desiredPermissions = [];
        
        // CAST TO INTEGERS for strict comparison safety
        $rolePermissions = array_map('intval', $rolePermissions);
        $desiredPermissions = array_map('intval', $desiredPermissions);

        // Permissions to GRANT explicitly (User wants it, but Role doesn't have it)
        $toGrant = array_diff($desiredPermissions, $rolePermissions);

        // Permissions to FORBID explicitly (Role has it, but User didn't check it)
        $toForbid = array_diff($rolePermissions, $desiredPermissions);

        // Prepare sync array
        $syncData = [];
        
        foreach ($toGrant as $permId) {
            $syncData[$permId] = ['is_forbidden' => false];
        }

        foreach ($toForbid as $permId) {
            $syncData[$permId] = ['is_forbidden' => true];
        }

        $user->permissions()->sync($syncData);

        return back()->with('success', "Rôles et permissions mis à jour pour {$user->name}.");
    }

    /**
     * List all resources (Catalog).
     */
    /**
     * List all resources (Catalog) with filtering.
     */
    public function resources(Request $request)
    {
        $query = Ressource::with(['manager', 'creator', 'serveur', 'machineVirtuelle', 'equipementReseau', 'baieStockage']);

        // Filter by Type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $resources = $query->get();

        return view('admin.resources', compact('resources'));
    }

    /**
     * Update Resource Details.
     */
    public function updateResourceDetails(Request $request, $id)
    {
        $resource = Ressource::findOrFail($id);
        
        // Update basic info
        $resource->update([
            'name' => $request->name,
        ]);

        // Update specific details based on type
        switch ($resource->type) {
            case 'serveur':
                $resource->serveur()->updateOrCreate(
                    ['ressource_id' => $resource->id],
                    $request->only(['cpu', 'ram', 'stockage', 'os', 'modele', 'numero_serie'])
                );
                break;
            case 'machine_virtuelle':
                $resource->machineVirtuelle()->updateOrCreate(
                    ['ressource_id' => $resource->id],
                    $request->only(['cpu', 'ram', 'stockage', 'os', 'hyperviseur', 'adresse_ip'])
                );
                break;
            case 'equipement_reseau':
                $resource->equipementReseau()->updateOrCreate(
                    ['ressource_id' => $resource->id],
                    $request->only(['type_equipement', 'modele', 'numero_ports', 'bande_passante'])
                );
                break;
            case 'baie_stockage':
                $resource->baieStockage()->updateOrCreate(
                    ['ressource_id' => $resource->id],
                    $request->only(['type_stockage', 'capacite', 'systeme_fichiers'])
                );
                break;
        }

        return back()->with('success', 'Détails de la ressource mis à jour.');
    }

    /**
     * Toggle Maintenance Status.
     */
    /**
     * Toggle Maintenance Status.
     */
    /**
     * Toggle Maintenance Status.
     */
    public function toggleMaintenance(Request $request, $id)
    {
        $resource = \App\Models\Ressource::findOrFail($id);
        
        if ($resource->status === 'maintenance') {
            // FINISH MAINTENANCE
            $resource->status = 'disponible';
            
            // Find the ongoing period and close it
            $period = \App\Models\MaintenancePeriod::where('ressource_id', $resource->id)
                        ->where('status', 'ongoing')
                        ->latest()
                        ->first();
            
            if ($period) {
                $period->update([
                    'status' => 'completed',
                    'end_date' => now() // Actual end date is now
                ]);
            }

            $message = 'Maintenance terminée. Ressource disponible.';

        } else {
            // START MAINTENANCE
            $resource->status = 'maintenance';
            
            $reason = $request->input('reason', 'Maintenance Rapide');
            $days = $request->input('days', 5);

            // Create new record
            \App\Models\MaintenancePeriod::create([
                'ressource_id' => $resource->id,
                'start_date' => now(),
                'end_date' => now()->addDays($days),
                'reason' => $reason,
                'status' => 'ongoing'
            ]);

            $message = 'Ressource mise en maintenance.';
        }
        
        $resource->save();

        return back()->with('success', $message);
    }

    /**
     * Delete Resource.
     */
    public function destroyResource($id)
    {
        $resource = \App\Models\Ressource::findOrFail($id);
        $resource->delete();
        
        return back()->with('success', 'Ressource supprimée avec succès.');
    }

    /**
     * Store a new resource.
     */
    public function storeResource(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:serveur,machine_virtuelle,equipement_reseau,baie_stockage',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $resource = \App\Models\Ressource::create([
            'name' => $request->name,
            'type' => $request->type,
            'status' => 'disponible',
            'is_active' => true,
            'manager_id' => $request->manager_id,
            'created_by' => auth()->id(),
        ]);

        // Create specific details based on type
        // Create specific details based on type
        switch ($request->type) {
            case 'serveur':
                $resource->serveur()->create($request->only(['cpu', 'ram', 'stockage', 'os', 'modele', 'numero_serie', 'emplacement']) + ['etat' => 'Actif']);
                break;
            case 'machine_virtuelle':
                $resource->machineVirtuelle()->create($request->only(['cpu', 'ram', 'stockage', 'os', 'hyperviseur', 'adresse_ip', 'bande_passante']) + ['etat' => 'Actif']);
                break;
            case 'equipement_reseau':
                $resource->equipementReseau()->create($request->only(['type_equipement', 'modele', 'numero_ports', 'bande_passante', 'emplacement']) + ['etat' => 'Actif']);
                break;
            case 'baie_stockage':
                $resource->baieStockage()->create($request->only(['type_stockage', 'capacite', 'systeme_fichiers', 'emplacement']) + ['etat' => 'Actif']);
                break;
        }

        return back()->with('success', 'Ressource ajoutée avec succès.');
    }

    /**
     * Manage maintenance periods (Placeholder).
     */
    /**
     * Store a scheduled maintenance.
     */
    public function storeMaintenance(Request $request)
    {
        $request->validate([
            'ressource_id' => 'required|exists:ressources,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'reason' => 'required|string|max:255',
        ]);

        // Logic: If end_date is missing, default to +5 days from start
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = $request->end_date ? \Carbon\Carbon::parse($request->end_date) : $startDate->copy()->addDays(5);

        // Determine status based on start date
        $status = $startDate->isPast() ? 'ongoing' : 'scheduled';

        \App\Models\MaintenancePeriod::create([
            'ressource_id' => $request->ressource_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'reason' => $request->reason,
            'status' => $status,
        ]);

        // If it's starting immediately/ongoing, update resource status too
        if ($status === 'ongoing') {
            $resource = \App\Models\Ressource::find($request->ressource_id);
            if ($resource) {
                $resource->status = 'maintenance';
                $resource->save();
            }
        }

        return back()->with('success', 'Maintenance planifiée avec succès.');
    }

    /**
     * Manage maintenance periods.
     */
    public function maintenance(\Illuminate\Http\Request $request)
    {
        $queryType = $request->input('type');

        // 1. Resources currently in maintenance status
        $resourcesQuery = Ressource::where('status', 'maintenance');
        if ($queryType) {
            $resourcesQuery->where('type', $queryType);
        }
        $resourcesUnderMaintenance = $resourcesQuery->get();

        // 2. All Maintenance Periods (History & Scheduled)
        // Ensure you have: use App\Models\MaintenancePeriod; at the top
        $periodsQuery = \App\Models\MaintenancePeriod::with('ressource')
                                ->orderBy('start_date', 'desc');
        
        if ($queryType) {
            $periodsQuery->whereHas('ressource', function($q) use ($queryType) {
                $q->where('type', $queryType);
            });
        }
        
        $maintenancePeriods = $periodsQuery->get();

        return view('admin.maintenance', compact('resourcesUnderMaintenance', 'maintenancePeriods', 'queryType'));
    }

    /**
     * List all demands.
     */
    public function demandes()
    {
        $demandes = \App\Models\Demande::with(['user', 'ressource'])->latest()->get();
        $compteDemandes = \App\Models\CompteDemande::where('status', 'en_attente')->latest()->get();
        return view('admin.demandes', compact('demandes', 'compteDemandes'));
    }

    /**
     * Approve a demande.
     */
    public function approveDemande($id)
    {
        $demande = \App\Models\Demande::findOrFail($id);
        $demande->update([
            'status' => 'approuvee',
            'approved_at' => now(),
            'responsable_id' => auth()->id() // Admin is approving
        ]);

        return back()->with('success', 'Demande approuvée avec succès.');
    }

    /**
     * Refuse a demande.
     */
    public function refuseDemande($id)
    {
        $demande = \App\Models\Demande::findOrFail($id);
        $demande->update([
            'status' => 'refusee',
            'refused_at' => now(),
            'responsable_id' => auth()->id() // Admin is refusing
        ]);

        return back()->with('success', 'Demande refusée.');
    }

    /**
     * Approve Account Request
     */
    public function approveCompteDemande($id)
    {
        $demande = \App\Models\CompteDemande::findOrFail($id);
        
        // Check if email already exists
        if (\App\Models\User::where('email', $demande->email)->exists()) {
             return back()->with('error', 'Un utilisateur avec cet email existe déjà.');
        }

        // Map requested role to valid ENUM type and database Role
        $type = 'utilisateur_interne'; // Default type for most users
        $roleName = 'utilisateur_interne'; // Default role

        // Special Admin/Responsable logic
        if ($demande->role === 'responsable') {
            $type = 'responsable_technique';
            $roleName = 'responsable_technique';
        } elseif ($demande->role === 'admin') {
            $type = 'admin';
            $roleName = 'admin';
        } 
        // Academic Roles (keep type as utilisateur_interne)
        elseif (in_array($demande->role, ['ingenieur', 'enseignant', 'doctorant'])) {
            $roleName = $demande->role; // Name matches the passed value
            $type = 'utilisateur_interne';
        }

        // Create User
        $user = \App\Models\User::create([
            'name' => $demande->nom_complet,
            'email' => $demande->email,
            'password' => $demande->password, // Already hashed
            'type' => $type, 
            'is_active' => true
        ]);

        // Assign Role
        $role = \App\Models\Role::where('name', $roleName)->first();
        if ($role) {
            $user->roles()->attach($role->id);
        } else {
            // Fallback: Try to find 'utilisateur_interne' if the specific one failed, or log error
            $defaultRole = \App\Models\Role::where('name', 'utilisateur_interne')->first();
            if ($defaultRole) {
                $user->roles()->attach($defaultRole->id);
            }
        }

        // Update Request Status
        $demande->update(['status' => 'approuvee']);

        return back()->with('success', 'Compte créé avec succès.');
    }

    /**
     * Refuse Account Request
     */
    public function refuseCompteDemande($id)
    {
        $demande = \App\Models\CompteDemande::findOrFail($id);
        $demande->update(['status' => 'refusee']);

        return back()->with('success', 'Demande de compte refusée.');
    }

    /**
     * Statistics Dashboard.
     */
    public function statistics()
    {
        // 1. Key Metrics
        $totalResources = \App\Models\Ressource::count();
        $totalUsers = \App\Models\User::count();
        $totalMaintenance = \App\Models\Ressource::where('status', 'maintenance')->count();
        $availableResources = \App\Models\Ressource::where('status', 'disponible')->count();

        // 2. Occupation Rate
        // Formula: (Total - Available) / Total * 100
        $occupationRate = $totalResources > 0 
            ? round((($totalResources - $availableResources) / $totalResources) * 100, 1) 
            : 0;

        // 3. Breakdown by Type
        $resourcesByType = \App\Models\Ressource::select('type', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');

        // 4. Breakdown by Status
        $resourcesByStatus = \App\Models\Ressource::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // 5. Reserved Resources Breakdown (for Pie Chart)
        $totalReserved = \App\Models\Ressource::where('status', 'reserve')->count();
        $reservedByType = \App\Models\Ressource::where('status', 'reserve')
            ->select('type', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');

        return view('admin.statistics', compact(
            'totalResources', 
            'totalUsers', 
            'totalMaintenance', 
            'occupationRate',
            'resourcesByType',
            'resourcesByStatus',
            'totalReserved',
            'reservedByType'
        ));
    }
    /**
     * Show profile page.
     */
    public function profile()
    {
        return view('admin.profile', ['user' => auth()->user()]);
    }

    /**
     * Update profile.
     */
    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed',
            'avatar' => 'nullable|image|max:1024', // Max 1MB
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && \Illuminate\Support\Facades\Storage::exists('public/' . $user->avatar)) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markNotificationsRead()
    {
        $user = auth()->user();
        \App\Models\Notification::where('user_id', $user->id)
                                ->where('status', 'unread')
                                ->update(['status' => 'read', 'read_at' => now()]);
        
        return response()->json(['success' => true]);
    }
}
