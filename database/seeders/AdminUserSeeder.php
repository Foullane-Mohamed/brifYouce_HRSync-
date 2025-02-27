<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Assurez-vous que le rôle admin existe
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Créez un utilisateur admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Assignez le rôle admin
        $admin->assignRole($adminRole);
    }
}