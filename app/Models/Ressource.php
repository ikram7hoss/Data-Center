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
        'status',          // dispo / reserve / maintenance
        'is_active',       // statut général activé / désactivé
        'location',      // Added from form
        'description',   // Added from form (textarea)
        'maintenance_start', // date début maintenance
        'maintenance_end',   // date fin maintenance
        'data_center_id',
    ];
     protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relations
    public function dataCenter()
    {
        return $this->belongsTo(DataCenter::class);
    }

    public function serveur()
    {
        return $this->hasOne(Serveur::class);
    }

    public function machineVirtuelle()
    {
        return $this->hasOne(MachineVirtuelle::class);
    }

    public function equipementReseau()
    {
        return $this->hasOne(EquipementReseau::class);
    }

    public function baieStockage()
    {
        return $this->hasOne(BaieStockage::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    public function responsables()
    {
        return $this->belongsToMany(User::class, 'responsable_ressources');
    }

    public function maintenancePeriods()
    {
        return $this->hasMany(MaintenancePeriod::class);
    }

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('status', 'disponible')->where('is_active', true);
    }

    public function scopeReservees($query)
    {
        return $query->where('status', 'reserve');
    }

    public function scopeEnMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    public function scopeActives($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactives($query)
    {
        return $query->where('is_active', false);
    }

    // Helper methods
    public function getDetailAttribute()
    {
        return match($this->type) {
            'serveur' => $this->serveur,
            'machine_virtuelle' => $this->machineVirtuelle,
            'equipement_reseau' => $this->equipementReseau,
            'baie_stockage' => $this->baieStockage,
            default => null,
        };
    }

    public function isAvailable()
    {
        return $this->status === 'disponible' && $this->is_active;
    }

    public function isReserved()
    {
        return $this->status === 'reserve';
    }

    public function isUnderMaintenance()
    {
        return $this->status === 'maintenance';
    }
}
