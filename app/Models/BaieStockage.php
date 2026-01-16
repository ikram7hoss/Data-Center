<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaieStockage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ressource_id',
        'capacite',      // en GB
        'emplacement',
        'etat',          // dispo / reserve / maintenance
    ];

    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }
}
