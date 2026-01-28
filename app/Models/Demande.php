<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ressource;

class Demande extends Model
{
protected $fillable = [
    'user_id',
    'ressource_id',
    'responsable_id',
    'periode_start',
    'periode_end',
    'status',
    'justification',
    'raison_refus',
    'notes',
    'approved_at',
    'refused_at',
    'started_at',
    'ended_at',
];

protected $casts = [
    'periode_start' => 'date',
    'periode_end' => 'date',
    'approved_at' => 'datetime',
    'refused_at' => 'datetime',
    'started_at' => 'datetime',
    'ended_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];

protected $casts = [
        'periode_start' => 'date',
        'periode_end' => 'date',
        'approved_at' => 'datetime',
        'refused_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('status', 'en_attente');
    }

    public function scopeApprouvees($query)
    {
        return $query->where('status', 'approuvee');
    }

    public function scopeRefusees($query)
    {
        return $query->where('status', 'refusee');
    }

    public function scopeActives($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeTerminees($query)
    {
        return $query->where('status', 'terminee');
    }

    public function scopeConflits($query)
    {
        return $query->where('status', 'conflit');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'en_attente';
    }

    public function isApproved()
    {
        return $this->status === 'approuvee';
    }

    public function isRefused()
    {
        return $this->status === 'refusee';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isCompleted()
    {
        return $this->status === 'terminee';
    }

    public function hasConflict()
    {
        return $this->status === 'conflit';
    }

    public function approve($userId, $notes = null)
    {
        $this->update([
            'status' => 'approuvee',
            'responsable_id' => $userId,
            'approved_at' => now(),
            'notes' => $notes,
        ]);
    }

    public function refuse($userId, $raison, $notes = null)
    {
        $this->update([
            'status' => 'refusee',
            'responsable_id' => $userId,
            'refused_at' => now(),
            'raison_refus' => $raison,
            'notes' => $notes,
        ]);
    }

    public function activate()
    {
        $this->update([
            'status' => 'active',
            'started_at' => now(),
        ]);
    }

    public function complete()
    {
        $this->update([
            'status' => 'terminee',
            'ended_at' => now(),
        ]);
    }
}

public function ressource()
{
    return $this->belongsTo(Ressource::class);
}

public function responsable()
{
    return $this->belongsTo(User::class, 'responsable_id');
}

public function notifications()
{
    return $this->hasMany(Notification::class);
}

// Scopes
public function scopeEnAttente($query)
{
    return $query->where('status', 'en_attente');
}

public function scopeApprouvees($query)
{
    return $query->where('status', 'approuvee');
}

public function scopeRefusees($query)
{
    return $query->where('status', 'refusee');
}

public function scopeActives($query)
{
    return $query->where('status', 'active');
}

public function scopeTerminees($query)
{
    return $query->where('status', 'terminee');
}

public function scopeConflits($query)
{
    return $query->where('status', 'conflit');
}

// Helper methods
public function isPending()
{
    return $this->status === 'en_attente';
}

public function isApproved()
{
    return $this->status === 'approuvee';
}

public function isRefused()
{
    return $this->status === 'refusee';
}

public function isActive()
{
    return $this->status === 'active';
}

public function isCompleted()
{
    return $this->status === 'terminee';
}

public function hasConflict()
{
    return $this->status === 'conflit';
}

public function approve($userId, $notes = null)
{
    $this->update([
        'status' => 'approuvee',
        'responsable_id' => $userId,
        'approved_at' => now(),
        'notes' => $notes,
    ]);
}

public function refuse($userId, $raison, $notes = null)
{
    $this->update([
        'status' => 'refusee',
        'responsable_id' => $userId,
        'refused_at' => now(),
        'raison_refus' => $raison,
        'notes' => $notes,
    ]);
}

public function activate()
{
    $this->update([
        'status' => 'active',
        'started_at' => now(),
    ]);
}

public function complete()
{
    $this->update([
        'status' => 'terminee',
        'ended_at' => now(),
    ]);
}
}