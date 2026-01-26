<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaieStockage extends Model
{
    use HasFactory;

    protected $table = 'baies_stockage';

    protected $fillable = [
        'ressource_id',
        'capacite',
        'emplacement',
        'etat',
        'type_stockage',
        'capacite_utilisee',
        'systeme_fichiers',
    ];

    // Relations
    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }

    // Helper methods
    public function getUtilizationPercentage()
    {
        if ($this->capacite == 0) {
            return 0;
        }
        return ($this->capacite_utilisee / $this->capacite) * 100;
    }

    public function getAvailableCapacity()
    {
        return $this->capacite - $this->capacite_utilisee;
    }
}
