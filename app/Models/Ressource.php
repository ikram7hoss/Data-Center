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
        'manager_id',      // pour mon rôle Responsable 
        'maintenance_start', // date début maintenance
        'maintenance_end',   // date fin maintenance
    ];

    // Une ressource peut être associée à un serveur, une VM, un équipement réseau ou une baie
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

    // Une ressource peut avoir plusieurs demandes
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
