<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
  'user_id',
  'ressource_id',
  'title',
  'description',
  'severity',
  'status',
];

public function user()
{
  return $this->belongsTo(\App\Models\User::class);
}

public function ressource()
{
  return $this->belongsTo(\App\Models\Ressource::class);
}

}
