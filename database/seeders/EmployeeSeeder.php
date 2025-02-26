<?php
namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        
        // Create manager and employees for each department
        foreach ($companies as $company) {
            $departments = Department::where('company_id', $company->id)->get();
            
            foreach ($departments as $department) {
                // Create a manager for each department
                $managerUser = User::create([
                    'name' => 'Manager ' . $department->name,
                    'email' => 'manager.' . Str::slug($department->name) . '@' . strtolower(str_replace(' ', '', $company->name)) . '.com',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'company_id' => $company->id,
                ]);
                $managerUser->assignRole('manager');
                
                $manager = Employee::create([
                    'user_id' => $managerUser->id,
                    'department_id' => $department->id,
                    'position' => $department->name . ' Manager',
                    'hire_date' => now()->subMonths(rand(12, 60)),
                    'birth_date' => now()->subYears(rand(30, 55)),
                    'salary' => rand(70000, 120000),
                ]);
                
                // Create 3-7 employees for each department
                $employeeCount = rand(3, 7);
                for ($i = 1; $i <= $employeeCount; $i++) {
                    $employeeUser = User::create([
                        'name' => 'Employee ' . $i . ' ' . $department->name,
                        'email' => 'employee' . $i . '.' . Str::slug($department->name) . '@' . strtolower(str_replace(' ', '', $company->name)) . '.com',
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                        'company_id' => $company->id,
                    ]);
                    $employeeUser->assignRole('employee');
                    
                    Employee::create([
                        'user_id' => $employeeUser->id,
                        'department_id' => $department->id,
                        'manager_id' => $manager->id,
                        'position' => $this->getRandomPosition($department->name),
                        'hire_date' => now()->subMonths(rand(1, 36)),
                        'birth_date' => now()->subYears(rand(22, 60)),
                        'salary' => rand(40000, 90000),
                    ]);
                }
            }
        }
    }
    
    private function getRandomPosition($departmentName)
    {
        $positions = [
            'Human Resources' => ['HR Specialist', 'Recruiter', 'HR Coordinator', 'Benefits Administrator', 'Talent Acquisition Specialist'],
            'Information Technology' => ['Software Developer', 'System Administrator', 'IT Support Specialist', 'Network Engineer', 'Database Administrator'],
            'Finance' => ['Accountant', 'Financial Analyst', 'Payroll Specialist', 'Budget Analyst', 'Tax Specialist'],
            'Marketing' => ['Marketing Specialist', 'Digital Marketing Manager', 'Content Creator', 'SEO Specialist', 'Social Media Manager'],
            'Operations' => ['Operations Analyst', 'Supply Chain Specialist', 'Quality Assurance Specialist', 'Logistics Coordinator', 'Process Improvement Specialist'],
            'Research & Development' => ['Research Scientist', 'Product Developer', 'R&D Engineer', 'Innovation Specialist', 'Technical Writer'],
            'Sales' => ['Sales Representative', 'Account Manager', 'Business Development Specialist', 'Sales Analyst', 'Regional Sales Manager'],
            'Customer Service' => ['Customer Service Representative', 'Support Specialist', 'Client Relations Manager', 'Customer Experience Analyst', 'Technical Support Specialist'],
        ];
        
        if (isset($positions[$departmentName])) {
            return $positions[$departmentName][array_rand($positions[$departmentName])];
        }
        
        // Default positions if department not found in the list
        $defaultPositions = ['Specialist', 'Coordinator', 'Analyst', 'Assistant', 'Associate'];
        return $departmentName . ' ' . $defaultPositions[array_rand($defaultPositions)];
    }
}
