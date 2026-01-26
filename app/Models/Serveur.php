<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serveur extends Model
{
    use HasFactory;

    protected $table = 'serveurs';

    protected $fillable = [
        'ressource_id',
        'cpu',
        'ram',
        'stockage',
        'os',
        'emplacement',
        'etat',
        'modele',
        'numero_serie',
    ];

    // Relations
    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }

    // Helper methods
    public function getUtilizationPercentage()
    {
        // Calculate based on allocated resources
        return 0;
    }
}
