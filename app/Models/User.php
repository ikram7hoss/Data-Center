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

    // Un utilisateur peut avoir plusieurs demandes
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    // Un utilisateur peut avoir plusieurs permissions
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
