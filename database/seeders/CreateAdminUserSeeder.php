<?php

namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'KIRTAN P',
                'email' => 'kirtanpateliya7869@gmail.com',
                'password' => bcrypt('1609')
            ],
            [
                'name' => 'Jay Survey',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456')
            ],
            [
                'name' => 'Kishor Kumar',
                'email' => 'kishorsuthar1204@gmail.com',
                'password' => bcrypt('9813aagemenidera')
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            $role = Role::firstOrCreate(['name' => 'Admin']);
            $permissions = Permission::pluck('id', 'id')->all();
            $role->syncPermissions($permissions);
            $user->assignRole([$role->id]);
        }
    }
}