<?php
namespace Database\Seeders;

use App\Models\Department;
use App\Models\Company;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // Get all companies
        $companies = Company::all();

        // Departments to create for each company
        $departmentTemplates = [
            [
                'name' => 'Human Resources',
                'description' => 'Responsible for recruiting, onboarding, training, and employee relations.'
            ],
            [
                'name' => 'Information Technology',
                'description' => 'Manages all technology infrastructure, software development, and technical support.'
            ],
            [
                'name' => 'Finance',
                'description' => 'Handles accounting, budgeting, financial reporting, and treasury functions.'
            ],
            [
                'name' => 'Marketing',
                'description' => 'Responsible for brand management, advertising, market research, and promotional activities.'
            ],
            [
                'name' => 'Operations',
                'description' => 'Oversees daily business activities, production, and quality assurance.'
            ],
            [
                'name' => 'Research & Development',
                'description' => 'Focused on innovation, product development, and technological advancement.'
            ],
            [
                'name' => 'Sales',
                'description' => 'Handles direct sales activities, client relationships, and revenue generation.'
            ],
            [
                'name' => 'Customer Service',
                'description' => 'Provides support to customers, handles inquiries, and resolves issues.'
            ],
        ];

        // Create departments for each company
        foreach ($companies as $company) {
            foreach ($departmentTemplates as $departmentData) {
                Department::create([
                    'company_id' => $company->id,
                    'name' => $departmentData['name'],
                    'description' => $departmentData['description'],
                ]);
            }
        }
    }
}