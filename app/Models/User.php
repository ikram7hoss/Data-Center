<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'is_active',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /* =======================
       Relations
    ======================= */

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    public function demandesApprouvees()
    {
        return $this->hasMany(Demande::class, 'responsable_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function ressourcesSupervises()
    {
        return $this->belongsToMany(Ressource::class, 'responsable_ressources');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission')
                    ->withPivot('is_forbidden');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    /* =======================
       Helpers Roles
    ======================= */

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function isAdmin()
    {
        return $this->type === 'admin' || $this->hasRole('admin');
    }

    public function isResponsableTechnique()
    {
        return $this->type === 'responsable_technique' || $this->hasRole('responsable_technique');
    }

    public function isUtilisateurInterne()
    {
        return $this->type === 'utilisateur_interne' || $this->hasRole('utilisateur_interne');
    }

    public function isInvite()
    {
        return $this->type === 'invite' || $this->hasRole('invite');
    }

    /* =======================
       Permissions Logic
    ======================= */

    public function hasPermission($permissionName)
    {
        // 1. Direct FORBIDDEN
        $isForbidden = $this->permissions()
            ->where('name', $permissionName)
            ->wherePivot('is_forbidden', true)
            ->exists();

        if ($isForbidden) {
            return false;
        }

        // 2. Direct GRANTED
        $isGranted = $this->permissions()
            ->where('name', $permissionName)
            ->wherePivot('is_forbidden', false)
            ->exists();

        if ($isGranted) {
            return true;
        }

        // 3. Role Permissions
        return $this->roles()->whereHas('permissions', function ($query) use ($permissionName) {
            $query->where('name', $permissionName);
        })->exists();
    }

    /**
     * Get the effective permissions for the user
     * (Role permissions + Direct granted - Forbidden)
     */
    public function getEffectivePermissions()
    {
        // 1. Role permissions
        $rolePermissions = $this->roles->flatMap->permissions;

        // 2. Forbidden permissions
        $forbiddenIds = $this->getForbiddenPermissions()->pluck('id');

        // 3. Active role permissions
        $activeRolePermissions = $rolePermissions->whereNotIn('id', $forbiddenIds);

        // 4. Granted permissions
        $grantedPermissions = $this->getGrantedPermissions();

        // 5. Merge + unique
        return $activeRolePermissions
            ->merge($grantedPermissions)
            ->unique('id')
            ->values();
    }

    public function getGrantedPermissions()
    {
        return $this->permissions->filter(function ($perm) {
            return $perm->pivot->is_forbidden == 0;
        });
    }

    public function getForbiddenPermissions()
    {
        return $this->permissions->filter(function ($perm) {
            return $perm->pivot->is_forbidden == 1;
        });
    }
}
