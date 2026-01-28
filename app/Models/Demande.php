<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ressource;

class Demande extends Model
{
    protected $fillable = ['user_id','ressource_id','periode_start','periode_end','justification',
  'status',];
public function ressource()
{
    return $this->belongsTo(Ressource::class);
}

}
