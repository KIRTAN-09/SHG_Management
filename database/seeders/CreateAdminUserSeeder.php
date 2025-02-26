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
        $user = User::create([
            'name' => 'Jay Surve', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $user = User::create([
            'name' => 'KIRTAN P.', 
            'email' => 'kirtanpateliya7869@gmail.com',
            'password' => bcrypt('1609')
        ]);

        $user = User::create([
            'name' => 'KISHOR SUTHAR', 
            'email' => 'kishorsuthar1204@gmail.com',
            'password' => bcrypt('98982Kilochavanu')
        ]);
        
        $role = Role::create(['name' => 'Admin']);
         
        $permissions = Permission::pluck('id','id')->all();
       
        $role->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);
    }
}