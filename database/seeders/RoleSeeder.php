<?php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Administrator with full access to all features',
        ]);

        Role::create([
            'name' => 'HR Manager',
            'slug' => 'hr',
            'description' => 'HR Manager with access to HR-related features',
        ]);

        Role::create([
            'name' => 'Employee',
            'slug' => 'employee',
            'description' => 'Regular employee with limited access',
        ]);
    }
}
