<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RessourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Ressource::insert([
        [
            'name' => 'Serveur-01',
            'type' => 'serveur',
            'status' => 'disponible',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'VM-01',
            'type' => 'machine_virtuelle',
            'status' => 'disponible',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}

}
