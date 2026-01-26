<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipementReseau extends Model
{
    use HasFactory;

    protected $table = 'equipements_reseau';

    protected $fillable = [
        'ressource_id',
        'bande_passante',
        'emplacement',
        'etat',
        'type_equipement',
        'numero_ports',
        'modele',
    ];

    // Relations
    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }

    // Helper methods
    public function getUtilizationPercentage()
    {
        // Calculate based on allocated bandwidth
        return 0;
    }
}
