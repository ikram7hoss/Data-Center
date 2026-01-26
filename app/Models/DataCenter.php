<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCenter extends Model
{
    use HasFactory;

    protected $table = 'data_centers';

    protected $fillable = [
        'name',
        'location',
        'description',
        'total_capacity_cpu',
        'total_capacity_ram',
        'total_capacity_storage',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relations
    public function ressources()
    {
        return $this->hasMany(Ressource::class);
    }

    // Helper methods
    public function getUtilizationPercentage()
    {
        // This would be calculated based on actual usage
        return 0;
    }

    public function getTotalRessources()
    {
        return $this->ressources()->count();
    }

    public function getActiveRessources()
    {
        return $this->ressources()->where('is_active', true)->count();
    }
}
