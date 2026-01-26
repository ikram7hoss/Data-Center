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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relations
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

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // Helper methods
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function hasPermission($permissionName)
    {
        return $this->roles()->whereHas('permissions', function($query) {
            $query->where('name', $permissionName);
        })->exists();
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
}

    // Un utilisateur peut avoir plusieurs permissions
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
