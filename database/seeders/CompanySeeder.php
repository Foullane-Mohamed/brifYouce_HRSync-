<?php
namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Create demo companies
        $companies = [
            [
                'name' => 'Acme Corporation',
                'email' => 'info@acmecorp.com',
                'phone' => '+1-555-123-4567',
                'address' => '123 Main St, New York, NY 10001',
            ],
            [
                'name' => 'Globex Industries',
                'email' => 'contact@globex.com',
                'phone' => '+1-555-987-6543',
                'address' => '456 Tech Blvd, San Francisco, CA 94107',
            ],
            [
                'name' => 'Stark Enterprises',
                'email' => 'info@starkent.com',
                'phone' => '+1-555-789-0123',
                'address' => '789 Innovation Drive, Boston, MA 02115',
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}