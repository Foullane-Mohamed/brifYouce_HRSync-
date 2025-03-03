<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('slug', 'admin')->first()->id,
            'employee_id' => 'ADM001',
        ]);

        // Create HR User
        User::create([
            'name' => 'HR Manager',
            'email' => 'hr@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('slug', 'hr')->first()->id,
            'employee_id' => 'HR001',
            'position' => 'HR Manager',
            'department' => 'Human Resources',
            'hire_date' => now()->subYears(2),
        ]);

        // Create some Employee Users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('slug', 'employee')->first()->id,
            'employee_id' => 'EMP001',
            'phone_number' => '123-456-7890',
            'position' => 'Software Developer',
            'department' => 'Engineering',
            'hire_date' => now()->subYears(1),
            'salary' => 75000,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('slug', 'employee')->first()->id,
            'employee_id' => 'EMP002',
            'phone_number' => '987-654-3210',
            'position' => 'Marketing Specialist',
            'department' => 'Marketing',
            'hire_date' => now()->subMonths(8),
            'salary' => 65000,
        ]);
    }
}