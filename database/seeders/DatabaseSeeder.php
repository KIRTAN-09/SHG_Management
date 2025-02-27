<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Guest User',
            'email' => 'Guestuser@gmail.com',
            'password' => bcrypt('2025'), // Added password
        ]);

        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            MemberSeeder::class,
        ]);

        $this->call(PermissionSeeder::class);
    }
}
