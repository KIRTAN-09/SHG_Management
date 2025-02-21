<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'Member-list',
            'Member-create',
            'Member-edit',
            'Member-delete',
            'Group-list',
            'Group-create',
            'Group-edit',
            'Group-delete',
            'Savings-list',
            'Savings-create',
            'Savings-edit',
            'Savings-delete',
            'User-list',
            'User-create',
            'User-edit',
            'User-delete',
            'Iga-list',
            'Iga-create',
            'Iga-edit',
            'Iga-delete',
            'Training-list',
            'Training-create',
            'Training-edit',
            'Training-delete',
            'Meetings-list',
            'Meetings-create',
            'Meetings-edit',
            'Meetings-delete',
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->where('guard_name', 'web')->exists()) {
                Permission::create(['name' => $permission, 'guard_name' => 'web']);
            }
        }

        // Assign all permissions to the admin role
        $adminRole = Role::where('name', 'user')->first();
        if ($adminRole) {
            $adminRole->syncPermissions($permissions);
        }

    
    }
}
