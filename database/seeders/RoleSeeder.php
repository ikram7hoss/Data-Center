<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

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

        $seedUserId = null;
        $hasUserId = Schema::hasColumn('permissions', 'user_id');
        $hasName = Schema::hasColumn('permissions', 'name');
        $hasPermissionName = Schema::hasColumn('permissions', 'permission_name');

        if ($hasUserId) {
            $seedUser = User::firstOrCreate(
                ['email' => 'system@local.test'],
                [
                    'name' => 'System',
                    'password' => Hash::make('password'),
                    'type' => 'admin',
                    'is_active' => true,
                ]
            );
            $seedUserId = $seedUser->id;
        }

        foreach ($permissions as $permName) {
            $attributes = [];
            if ($hasPermissionName) {
                $attributes['permission_name'] = $permName;
            }
            if ($hasName) {
                $attributes['name'] = $permName;
            }
            if (empty($attributes)) {
                continue;
            }
            $defaults = [];
            if (!is_null($seedUserId) && $hasUserId) {
                $defaults['user_id'] = $seedUserId;
            }
            Permission::firstOrCreate($attributes, $defaults);
        }

        // 2. Create Roles and Assign Permissions
        
        $hasRolePermission = Schema::hasTable('role_permission');

        // Admin
        $admin = Role::firstOrCreate(['name' => 'admin', 'description' => 'Administrateur complet']);
        if ($hasRolePermission) {
            $admin->permissions()->sync(Permission::all()); // All permissions
        }

        // Responsable Technique
        $responsable = Role::firstOrCreate(['name' => 'responsable_technique', 'description' => 'Gère les ressources et demandes']);
        if ($hasRolePermission) {
            $responsable->givePermission('view_dashboard');
            $responsable->givePermission('manage_resources');
            $responsable->givePermission('view_resources');
            $responsable->givePermission('manage_maintenance');
            $responsable->givePermission('approve_demande');
            $responsable->givePermission('view_users');
        }

        // Utilisateur Interne
        $interne = Role::firstOrCreate(['name' => 'utilisateur_interne', 'description' => 'Employé standard']);
        if ($hasRolePermission) {
            $interne->givePermission('view_dashboard');
            $interne->givePermission('view_resources');
            $interne->givePermission('create_demande');
        }

        // Invité
        $invite = Role::firstOrCreate(['name' => 'invite', 'description' => 'Accès limité']);
        if ($hasRolePermission) {
            $invite->givePermission('view_resources');
        }

        // New Academic Roles
        $ingenieur = Role::firstOrCreate(['name' => 'ingenieur', 'description' => 'Ingénieur']);
        if ($hasRolePermission) {
            $ingenieur->givePermission('view_resources');
            $ingenieur->givePermission('create_demande');
        }

        $enseignant = Role::firstOrCreate(['name' => 'enseignant', 'description' => 'Enseignant']);
        if ($hasRolePermission) {
            $enseignant->givePermission('view_resources');
            $enseignant->givePermission('create_demande');
        }

        $doctorant = Role::firstOrCreate(['name' => 'doctorant', 'description' => 'Doctorant']);
        if ($hasRolePermission) {
            $doctorant->givePermission('view_resources');
            $doctorant->givePermission('create_demande');
        }
    }
}
