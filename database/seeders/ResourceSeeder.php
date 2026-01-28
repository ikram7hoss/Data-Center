<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ressource;
use App\Models\User;

class ResourceSeeder extends Seeder
{
    public function run()
    {
        // Ensure we have a manager
        $manager = User::where('type', 'responsable_technique')->first();
        if (!$manager) {
            $manager = User::factory()->create([
                'name' => 'Ahmed Amrani',
                'email' => 'tech@datacenter.ma',
                'type' => 'responsable_technique',
                'password' => bcrypt('password')
            ]);
        }

        $resources = [
            [
                'name' => 'Dell PowerEdge R740 - Serveur Principal',
                'type' => 'serveur',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => '2x Intel Xeon Gold 6248R',
                'spec_ram' => '128 GB DDR4',
                'spec_storage' => '2x 480GB SSD (RAID 1) + 4x 4TB HDD (RAID 5)',
            ],
            [
                'name' => 'HP ProLiant DL380 Gen10',
                'type' => 'serveur',
                'status' => 'maintenance',
                'manager_id' => $manager->id,
                'spec_cpu' => 'Intel Xeon Silver 4208',
                'spec_ram' => '64 GB',
                'spec_storage' => '1TB NVMe',
            ],
            [
                'name' => 'VM-Ubuntu-AI-Training',
                'type' => 'machine_virtuelle',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => '8 vCPU',
                'spec_ram' => '32 GB',
                'spec_storage' => '200 GB SSD',
            ],
            [
                'name' => 'VM-Web-Production-01',
                'type' => 'machine_virtuelle',
                'status' => 'active', // 'active' is not in status enum? check status enum too.
                'manager_id' => $manager->id,
                'spec_cpu' => '4 vCPU',
                'spec_ram' => '16 GB',
                'spec_storage' => '100 GB',
            ],
            [
                'name' => 'Cisco Catalyst 9300 - Switch Core',
                'type' => 'equipement_reseau',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => 'N/A',
                'spec_ram' => 'N/A',
                'spec_storage' => 'N/A',
            ],
            [
                'name' => 'Baie de Stockage NetApp AFF A250',
                'type' => 'baie_stockage',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => 'N/A',
                'spec_ram' => 'N/A',
                'spec_storage' => '30 TB All-Flash',
            ],
            [
                'name' => 'VM-Database-PostgreSQL',
                'type' => 'machine_virtuelle',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => '16 vCPU',
                'spec_ram' => '64 GB',
                'spec_storage' => '500 GB NVMe',
            ],
            // 15 New Resources Added Here
            [
                'name' => 'IBM Power System E980',
                'type' => 'serveur',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => '4x POWER9 3.9GHz',
                'spec_ram' => '512 GB',
                'spec_storage' => '10 TB NVMe',
            ],
            [
                'name' => 'VM-Dev-Environment-01',
                'type' => 'machine_virtuelle',
                'status' => 'active',
                'manager_id' => $manager->id,
                'spec_cpu' => '4 vCPU',
                'spec_ram' => '8 GB',
                'spec_storage' => '100 GB SSD',
            ],
            [
                'name' => 'Juniper EX4300 Switch',
                'type' => 'equipement_reseau',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => 'N/A',
                'spec_ram' => 'N/A',
                'spec_storage' => 'N/A',
            ],
            [
                'name' => 'Synology RackStation RS3617xs+',
                'type' => 'baie_stockage',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => 'Xeon D-1531',
                'spec_ram' => '16 GB',
                'spec_storage' => '120 TB HDD',
            ],
            [
                'name' => 'Dell PowerEdge R640',
                'type' => 'serveur',
                'status' => 'maintenance',
                'manager_id' => $manager->id,
                'spec_cpu' => '2x Intel Xeon Gold 5218',
                'spec_ram' => '256 GB',
                'spec_storage' => '2x 960GB SSD',
            ],
            [
                'name' => 'VM-CI-CD-Pipeline',
                'type' => 'machine_virtuelle',
                'status' => 'active',
                'manager_id' => $manager->id,
                'spec_cpu' => '8 vCPU',
                'spec_ram' => '32 GB',
                'spec_storage' => '500 GB SSD',
            ],
            [
                'name' => 'FortiGate 60F Firewall',
                'type' => 'equipement_reseau',
                'status' => 'active',
                'manager_id' => $manager->id,
                'spec_cpu' => 'SOC4',
                'spec_ram' => 'N/A',
                'spec_storage' => 'N/A',
            ],
            [
                'name' => 'Lenovo ThinkSystem SR650',
                'type' => 'serveur',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => 'Intel Xeon Platinum 8280',
                'spec_ram' => '768 GB',
                'spec_storage' => '4x 3.84TB SSD',
            ],
            [
                'name' => 'VM-Hadoop-Cluster-Node1',
                'type' => 'machine_virtuelle',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => '12 vCPU',
                'spec_ram' => '64 GB',
                'spec_storage' => '2 TB HDD',
            ],
            [
                'name' => 'VM-Hadoop-Cluster-Node2',
                'type' => 'machine_virtuelle',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => '12 vCPU',
                'spec_ram' => '64 GB',
                'spec_storage' => '2 TB HDD',
            ],
            [
                'name' => 'VM-Hadoop-Cluster-Node3',
                'type' => 'machine_virtuelle',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => '12 vCPU',
                'spec_ram' => '64 GB',
                'spec_storage' => '2 TB HDD',
            ],
            [
                'name' => 'Dell EMC Unity 480F',
                'type' => 'baie_stockage',
                'status' => 'maintenance',
                'manager_id' => $manager->id,
                'spec_cpu' => 'N/A',
                'spec_ram' => 'N/A',
                'spec_storage' => '200 TB Flash',
            ],
            [
                'name' => 'Cisco Meraki MX84',
                'type' => 'equipement_reseau',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => 'N/A',
                'spec_ram' => 'N/A',
                'spec_storage' => 'N/A',
            ],
            [
                'name' => 'HP ProLiant DL360 Gen10',
                'type' => 'serveur',
                'status' => 'disponible',
                'manager_id' => $manager->id,
                'spec_cpu' => 'Intel Xeon Silver 4210',
                'spec_ram' => '64 GB',
                'spec_storage' => '1 TB NVMe',
            ],
            [
                'name' => 'VM-Monitoring-Grafana',
                'type' => 'machine_virtuelle',
                'status' => 'active',
                'manager_id' => $manager->id,
                'spec_cpu' => '2 vCPU',
                'spec_ram' => '4 GB',
                'spec_storage' => '50 GB SSD',
            ],
        ];

        foreach ($resources as $res) {
            $status = ($res['status'] === 'active') ? 'reserve' : $res['status']; // Map 'active' to 'reserve'

            $r = Ressource::create([
                'name' => $res['name'],
                'type' => $res['type'],
                'status' => $status,
                'is_active' => true,
                'manager_id' => $res['manager_id'],
            ]);

            // Create specific relation details if needed (simplified for now to stick to main table logic if possible or use polymorphic)
            // For this quick fix, we assume Ressource model might have had json columns or we just create basics.
            // But looking at migrations, we have separate tables. Let's populate them briefly.

            if ($res['type'] == 'serveur') {
                \App\Models\Serveur::create([
                    'ressource_id' => $r->id,
                    'cpu' => is_numeric(filter_var($res['spec_cpu'], FILTER_SANITIZE_NUMBER_INT))
                        ? filter_var($res['spec_cpu'], FILTER_SANITIZE_NUMBER_INT) : 16,
                    'ram' => is_numeric(filter_var($res['spec_ram'], FILTER_SANITIZE_NUMBER_INT))
                        ? filter_var($res['spec_ram'], FILTER_SANITIZE_NUMBER_INT) : 64,
                    'storage' => 1000,            // correspond à ta colonne migration
                    'os' => 'Linux/Windows',
                    'ip_address' => '192.168.1.' . rand(10, 50),
                    'network' => 'LAN'

                ]);
            } elseif ($res['type'] == 'machine_virtuelle') {
                \App\Models\MachineVirtuelle::create([
                    'ressource_id' => $r->id,
                    'cpu' => is_numeric(filter_var($res['spec_cpu'], FILTER_SANITIZE_NUMBER_INT)) ? filter_var($res['spec_cpu'], FILTER_SANITIZE_NUMBER_INT) : 4,
                    'ram' => is_numeric(filter_var($res['spec_ram'], FILTER_SANITIZE_NUMBER_INT)) ? filter_var($res['spec_ram'], FILTER_SANITIZE_NUMBER_INT) : 16,
                    'stockage' => 100, // Dummy
                    'os' => 'Ubuntu 22.04 LTS',
                    'etat' => 'running',
                    'bande_passante' => 1000,
                    'adresse_ip' => '10.0.0.' . rand(10, 50)
                ]);
            }
        }
    }
}
