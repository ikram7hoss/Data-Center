<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Permissions
        $permissions = [
            'view_dashboard',
            'manage_users',
            'view_users',
            'manage_resources',
            'view_resources',
            'manage_maintenance',
            'view_reports',
            'create_demande',
            'approve_demande',
        ];

        foreach ($permissions as $permName) {
            Permission::firstOrCreate(['name' => $permName]);
        }

        // 2. Create Roles and Assign Permissions
        
        // Admin
        $admin = Role::firstOrCreate(['name' => 'admin', 'description' => 'Administrateur complet']);
        $admin->permissions()->sync(Permission::all()); // All permissions

        // Responsable Technique
        $responsable = Role::firstOrCreate(['name' => 'responsable_technique', 'description' => 'Gère les ressources et demandes']);
        $responsable->givePermission('view_dashboard');
        $responsable->givePermission('manage_resources');
        $responsable->givePermission('view_resources');
        $responsable->givePermission('manage_maintenance');
        $responsable->givePermission('approve_demande');
        $responsable->givePermission('view_users');

        // Utilisateur Interne
        $interne = Role::firstOrCreate(['name' => 'utilisateur_interne', 'description' => 'Employé standard']);
        $interne->givePermission('view_dashboard');
        $interne->givePermission('view_resources');
        $interne->givePermission('create_demande');

        // Invité
        $invite = Role::firstOrCreate(['name' => 'invite', 'description' => 'Accès limité']);
        $invite->givePermission('view_resources');

        // New Academic Roles
        $ingenieur = Role::firstOrCreate(['name' => 'ingenieur', 'description' => 'Ingénieur']);
        $ingenieur->givePermission('view_resources');
        $ingenieur->givePermission('create_demande');

        $enseignant = Role::firstOrCreate(['name' => 'enseignant', 'description' => 'Enseignant']);
        $enseignant->givePermission('view_resources');
        $enseignant->givePermission('create_demande');

        $doctorant = Role::firstOrCreate(['name' => 'doctorant', 'description' => 'Doctorant']);
        $doctorant->givePermission('view_resources');
        $doctorant->givePermission('create_demande');
    }
}
