<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineVirtuelle extends Model
{
    use HasFactory;

    protected $table = 'machines_virtuelles';

    protected $fillable = [
        'ressource_id',
        'cpu',
        'ram',
        'stockage',
        'os',
        'bande_passante',
        'etat',
        'hyperviseur',
        'adresse_ip',
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
