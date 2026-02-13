<?php

namespace Zohaib482\SimpleRbac\Database\Seeders;

use Illuminate\Database\Seeder;
use Zohaib482\SimpleRbac\Models\Role;
use Zohaib482\SimpleRbac\Models\Permission;

class RbacSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',

            // Role management
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',

            // Permission management
            'view_permissions',
            'assign_permissions',

            // Content management (example)
            'view_posts',
            'create_posts',
            'edit_posts',
            'delete_posts',

            // Dashboard access
            'access_dashboard',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to admin
        $adminRole->permissions()->sync(Permission::all()->pluck('id'));

        // Assign basic permissions to regular user
        $userPermissions = [
            'access_dashboard',
            'view_posts',
        ];

        $userRole->permissions()->sync(
            Permission::whereIn('name', $userPermissions)->pluck('id')
        );

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
