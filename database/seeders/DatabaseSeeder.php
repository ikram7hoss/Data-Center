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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'type' => 'utilisateur_interne',
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'ikram@example.com',
            'password' => bcrypt('12345'), // Or Hash::make('password') if Hash imported
            'type' => 'admin',
            'is_active' => true,
        ]);

        $this->call([
            RoleSeeder::class,
            ResourceSeeder::class,
        ]);
    }
}
