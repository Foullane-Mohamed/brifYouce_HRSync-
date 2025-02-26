<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create super admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $adminUser->assignRole('admin');

        // Create company admin users for each company
        $companies = Company::all();
        foreach ($companies as $company) {
            $companyAdmin = User::create([
                'name' => $company->name . ' Admin',
                'email' => 'admin@' . strtolower(str_replace(' ', '', $company->name)) . '.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'company_id' => $company->id,
            ]);
            $companyAdmin->assignRole('company_admin');
        }
    }
}
