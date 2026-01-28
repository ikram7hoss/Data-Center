<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'type' => 'utilisateur_interne',
                'password' => bcrypt('password'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'ikram@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('12345'),
                'type' => 'admin',
                'is_active' => true,
            ]
        );

        // Create Technical Manager (Farah)
        $farah = User::firstOrCreate(
            ['email' => 'farah@example.com'],
            [
                'name' => 'Farah',
                'password' => bcrypt('123456'),
                'type' => 'responsable_technique',
                'is_active' => true,
            ]
        );

        $this->call([
            RoleSeeder::class,
            ResourceSeeder::class,
        ]);

        // Attach Role to Farah after RoleSeeder runs (so the role exists)
        $roleTech = \App\Models\Role::where('name', 'responsable_technique')->first();
        if ($roleTech) {
            // Check if already attached to avoid duplicates? attach() allows dupes in some DBs or throws error?
            // syncWithoutDetaching is safer
            $farah->roles()->syncWithoutDetaching([$roleTech->id]);
        }
    }
}
