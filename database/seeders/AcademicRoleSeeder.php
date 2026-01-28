<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class AcademicRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure permissions exist
        $perms = ['view_resources', 'create_demande'];
        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // 2. Create Roles
        $roles = [
            'ingenieur' => 'Ingénieur',
            'enseignant' => 'Enseignant',
            'doctorant' => 'Doctorant'
        ];

        foreach ($roles as $key => $label) {
            $role = Role::firstOrCreate(['name' => $key], ['description' => $label]);
            
            // Assign permissions safely
            $role->givePermission('view_resources');
            $role->givePermission('create_demande');
        }
    }
}
