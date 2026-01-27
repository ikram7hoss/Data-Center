<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompteDemande extends Model
{
    protected $fillable = ['nom_complet', 'email', 'equipe', 'motif'];
}
