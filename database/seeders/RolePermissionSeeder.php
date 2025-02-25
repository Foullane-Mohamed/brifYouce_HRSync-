<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Créer des permissions
        $permissions = [
            'manage users',
            'manage employees',
            'manage departments',
            'view hierarchy',
            // Ajoutez d'autres permissions selon vos besoins
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Créer des rôles et attribuer des permissions
        $adminRole = Role::create(['name' => 'admin']);
        $hrRole = Role::create(['name' => 'hr']);
        $managerRole = Role::create(['name' => 'manager']);
        $employeeRole = Role::create(['name' => 'employee']);

        // Attribuer toutes les permissions à l'admin
        $adminRole->givePermissionTo(Permission::all());

        // Attribuer des permissions spécifiques aux autres rôles
        $hrRole->givePermissionTo(['manage employees', 'manage departments']);
        $managerRole->givePermissionTo(['manage employees', 'view hierarchy']);
        $employeeRole->givePermissionTo(['view hierarchy']);
    }
}
