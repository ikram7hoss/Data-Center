<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataCenter;
use App\Models\Ressource;
use App\Models\Serveur;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. On crée le Data Center principal
        $dc = DataCenter::create([
            'name' => 'DC-Casablanca',
            'location' => 'Zone Industrielle'
        ]);

        // --- SERVEUR 1 : DELL (Standard) ---
        $res1 = Ressource::create([
            'name' => 'SRV-DELL-01',
            'type' => 'SRV',
            'status' => 'disponible',
            'is_active' => true,
            'data_center_id' => $dc->id
        ]);

        Serveur::create([
            'ressource_id' => $res1->id,
            'cpu' => 16,
            'ram' => 64,
            'stockage' => 2000,
            'os' => 'Ubuntu 22.04',
            'emplacement' => 'Rack A1',
            'etat' => 'neuf'
        ]);

        // --- SERVEUR 2 : HP (Puissant) ---
        $res2 = Ressource::create([
            'name' => 'SRV-HP-02',
            'type' => 'SRV',
            'status' => 'maintenance',
            'is_active' => true,
            'data_center_id' => $dc->id
        ]);

        Serveur::create([
            'ressource_id' => $res2->id,
            'cpu' => 32,
            'ram' => 128,
            'stockage' => 4000,
            'os' => 'Windows Server 2022',
            'emplacement' => 'Rack B3',
            'etat' => 'neuf'
        ]);

        // --- SERVEUR 3 : IBM (Stockage Massif) ---
        $res3 = Ressource::create([
            'name' => 'SRV-IBM-STORAGE',
            'type' => 'SRV',
            'status' => 'disponible',
            'is_active' => true,
            'data_center_id' => $dc->id
        ]);

        Serveur::create([
            'ressource_id' => $res3->id,
            'cpu' => 8,
            'ram' => 32,
            'stockage' => 10000, // 10 TB
            'os' => 'TrueNAS',
            'emplacement' => 'Rack C1',
            'etat' => 'neuf'
        ]);

        // --- SERVEUR 4 : CISCO (Calcul Intensif) ---
        $res4 = Ressource::create([
            'name' => 'SRV-CISCO-PRO',
            'type' => 'SRV',
            'status' => 'disponible',
            'is_active' => true,
            'data_center_id' => $dc->id
        ]);

        Serveur::create([
            'ressource_id' => $res4->id,
            'cpu' => 64,
            'ram' => 256,
            'stockage' => 8000,
            'os' => 'RedHat Enterprise',
            'emplacement' => 'Rack D5',
            'etat' => 'neuf'
        ]);
    }
}
