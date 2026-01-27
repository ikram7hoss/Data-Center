<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'status',
        'is_active',
        'maintenance_start',
        'maintenance_end',
        'data_center_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'maintenance_start' => 'date',
        'maintenance_end' => 'date',
    ];

    // --- RELATIONS ---

    public function serveur()
    {
        return $this->hasOne(Serveur::class, 'ressource_id');
    }

    public function machineVirtuelle()
    {
        return $this->hasOne(MachineVirtuelle::class, 'ressource_id');
    }

    public function baieStockage()
    {
        return $this->hasOne(BaieStockage::class, 'ressource_id');
    }

    // --- LA CORRECTION EST ICI ---
    // On ajoute 'SRV', 'VM', et 'NAS' pour correspondre à ton affichage
    public function getDetailAttribute()
    {
      return match($this->type) {
        'SRV', 'serveur' => $this->serveur,
        'VM', 'machine_virtuelle' => $this->machineVirtuelle,
        default => null
        };
    }

    public function scopeActives($query)
    {
        return $query->where('is_active', true);
    }
}
