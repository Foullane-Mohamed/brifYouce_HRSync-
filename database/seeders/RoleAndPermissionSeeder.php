<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Company permissions
            'view companies',
            'create companies',
            'update companies',
            'delete companies',
            
            // Department permissions
            'view departments',
            'create departments',
            'update departments',
            'delete departments',
            
            // Employee permissions
            'view employees',
            'create employees',
            'update employees',
            'delete employees',
            
            // Contract permissions
            'view contracts',
            'create contracts',
            'update contracts',
            'delete contracts',
            
            // Career development permissions
            'view career developments',
            'create career developments',
            'update career developments',
            'delete career developments',
            
            // Training permissions
            'view trainings',
            'create trainings',
            'update trainings',
            'delete trainings',
            
            // Org chart permissions
            'view org chart',
            
            // User permissions
            'view profile',
            'update profile',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $companyAdminRole = Role::create(['name' => 'company_admin']);
        $companyAdminRole->givePermissionTo([
            'view companies',
            'update companies',
            'view departments',
            'create departments',
            'update departments',
            'delete departments',
            'view employees',
            'create employees',
            'update employees',
            'delete employees',
            'view contracts',
            'create contracts',
            'update contracts',
            'delete contracts',
            'view career developments',
            'create career developments',
            'update career developments',
            'delete career developments',
            'view trainings',
            'create trainings',
            'update trainings',
            'delete trainings',
            'view org chart',
            'view profile',
            'update profile',
        ]);

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view departments',
            'view employees',
            'update employees',
            'view contracts',
            'create contracts',
            'update contracts',
            'view career developments',
            'create career developments',
            'update career developments',
            'view trainings',
            'view org chart',
            'view profile',
            'update profile',
        ]);

        $employeeRole = Role::create(['name' => 'employee']);
        $employeeRole->givePermissionTo([
            'view profile',
            'update profile',
        ]);
    }
}