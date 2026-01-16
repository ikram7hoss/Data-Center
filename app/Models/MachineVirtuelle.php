<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineVirtuelle extends Model
{
    use HasFactory;

    protected $fillable = [
        'ressource_id',
        'cpu',
        'ram',
        'stockage',
        'os',
        'bande_passante',
        'etat',  // dispo / reserve / maintenance
    ];

    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }
}
