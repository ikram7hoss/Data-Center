<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ressource;
use Illuminate\Support\Facades\DB;

class RessourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyage de la table avant de remplir
        DB::table('ressources')->delete();

        // Ajout de données de test avec les colonnes créées dans la migration
        Ressource::create([
            'name'      => 'SRV-DELL-01',
            'type'      => 'SRV',
            'status'    => 'dispo',
            'is_active' => true
        ]);

        Ressource::create([
            'name'      => 'VM-PROD-01',
            'type'      => 'VM',
            'status'    => 'maint',
            'is_active' => true
        ]);

        Ressource::create([
            'name'      => 'NAS-BACKUP',
            'type'      => 'NAS',
            'status'    => 'dispo',
            'is_active' => true
        ]);
    }
}
