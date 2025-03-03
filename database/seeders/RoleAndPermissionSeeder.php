<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        // Company permissions
        Permission::create(['name' => 'view companies']);
        Permission::create(['name' => 'create companies']);
        Permission::create(['name' => 'edit companies']);
        Permission::create(['name' => 'delete companies']);
        
        // User permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        
        // Employee permissions
        Permission::create(['name' => 'view employees']);
        Permission::create(['name' => 'create employees']);
        Permission::create(['name' => 'edit employees']);
        Permission::create(['name' => 'delete employees']);
        
        // Department permissions
        Permission::create(['name' => 'view departments']);
        Permission::create(['name' => 'create departments']);
        Permission::create(['name' => 'edit departments']);
        Permission::create(['name' => 'delete departments']);
        
        // Career event permissions
        Permission::create(['name' => 'view career events']);
        Permission::create(['name' => 'create career events']);
        Permission::create(['name' => 'edit career events']);
        Permission::create(['name' => 'delete career events']);

        // Create roles and assign permissions
        
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
        
        // HR role
        $hrRole = Role::create(['name' => 'hr']);
        $hrRole->givePermissionTo([
            'view employees', 'create employees', 'edit employees', 'delete employees',
            'view departments', 'create departments', 'edit departments', 'delete departments',
            'view users', 'create users', 'edit users',
            'view career events', 'create career events', 'edit career events', 'delete career events',
        ]);
        
        // Manager role
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view employees', 'edit employees',
            'view departments',
            'view users',
            'view career events', 'create career events',
        ]);
        
        // Employee role
        $employeeRole = Role::create(['name' => 'employee']);
        $employeeRole->givePermissionTo([
            'view employees',
            'view departments',
            'view career events',
        ]);
    }
}