<?php

namespace Database\Seeders;

use App\Models\CareerDevelopment;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class CareerDevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        
        foreach ($employees as $employee) {
            // Only create career developments for employees who have been with the company for a while
            if ($employee->hire_date && $employee->hire_date->diffInMonths(now()) >= 12) {
                $developmentCount = rand(1, 3); // Random number of career developments
                
                for ($i = 0; $i < $developmentCount; $i++) {
                    $developmentType = $this->getRandomDevelopmentType();
                    $date = $employee->hire_date->copy()->addMonths(rand(6, $employee->hire_date->diffInMonths(now())));
                    
                    // Generate appropriate previous and new values based on development type
                    list($previousValue, $newValue) = $this->generateDevelopmentValues($developmentType, $employee);
                    
                    CareerDevelopment::create([
                        'employee_id' => $employee->id,
                        'type' => $developmentType,
                        'previous_value' => $previousValue,
                        'new_value' => $newValue,
                        'date' => $date,
                        'description' => $this->generateDevelopmentDescription($developmentType, $previousValue, $newValue),
                    ]);
                    
                    // Update employee record for relevant development types
                    if ($developmentType === 'Position Change') {
                        $employee->position = $newValue;
                    } elseif ($developmentType === 'Salary Increase') {
                        $employee->salary = floatval($newValue);
                    }
                }
                
                // Save any changes to employee
                $employee->save();
            }
        }
    }
    
    private function getRandomDevelopmentType()
    {
        $types = ['Promotion', 'Salary Increase', 'Training', 'Position Change'];
        $weights = [2, 5, 1, 2]; // Weighted probabilities
        
        $totalWeight = array_sum($weights);
        $rand = rand(1, $totalWeight);
        
        $runningTotal = 0;
        for ($i = 0; $i < count($types); $i++) {
            $runningTotal += $weights[$i];
            if ($rand <= $runningTotal) {
                return $types[$i];
            }
        }
        
        return $types[0]; // Default to Promotion
    }
    
    private function generateDevelopmentValues($type, $employee)
    {
        switch ($type) {
            case 'Promotion':
                $previousPosition = $employee->position;
                $newPosition = $this->generatePromotedPosition($previousPosition);
                return [$previousPosition, $newPosition];
                
            case 'Salary Increase':
                $previousSalary = $employee->salary;
                $increasePercentage = rand(3, 15) / 100; // 3-15% increase
                $newSalary = round($previousSalary * (1 + $increasePercentage), 2);
                return [$previousSalary, $newSalary];
                
            case 'Training':
                $trainingOptions = ['Leadership Training', 'Technical Certification', 'Professional Development Course', 'Industry Conference', 'Specialized Workshop'];
                $training = $trainingOptions[array_rand($trainingOptions)];
                return ['None', $training];
                
            case 'Position Change':
                $previousPosition = $employee->position;
                $newPosition = $this->generateAlternativePosition($employee->department->name ?? '');
                return [$previousPosition, $newPosition];
                
            default:
                return ['', ''];
        }
    }
    
    private function generatePromotedPosition($currentPosition)
    {
        // Remove existing seniority levels
        $position = str_replace(['Junior ', 'Senior ', 'Lead ', 'Chief '], '', $currentPosition);
        
        if (str_contains($currentPosition, 'Junior')) {
            return $position; // Remove Junior prefix
        } elseif (str_contains($currentPosition, 'Manager')) {
            return 'Senior ' . $currentPosition; // Senior Manager
        } elseif (str_contains($currentPosition, 'Director')) {
            return 'Executive ' . $currentPosition; // Executive Director
        } else {
            $prefixes = ['Senior ', 'Lead ', 'Manager of '];
            return $prefixes[array_rand($prefixes)] . $position;
        }
    }
    
    private function generateAlternativePosition($departmentName)
    {
        $positions = [
            'Human Resources' => ['HR Business Partner', 'Talent Development Specialist', 'Employee Relations Manager', 'HRIS Specialist', 'Compensation Analyst'],
            'Information Technology' => ['Cloud Architect', 'DevOps Engineer', 'Security Analyst', 'UX Designer', 'Product Owner'],
            'Finance' => ['Treasury Analyst', 'Risk Manager', 'Finance Business Partner', 'Reporting Specialist', 'Financial Controller'],
            'Marketing' => ['Brand Manager', 'Growth Hacker', 'Product Marketing Specialist', 'Market Research Analyst', 'Campaign Manager'],
            'Operations' => ['Business Analyst', 'Operations Manager', 'Process Improvement Lead', 'Facilities Coordinator', 'Safety Manager'],
            'Research & Development' => ['UX Researcher', 'Data Scientist', 'Product Designer', 'Quality Engineer', 'Technical Lead'],
            'Sales' => ['Key Account Manager', 'Sales Operations Specialist', 'Inside Sales Representative', 'Solution Consultant', 'Channel Manager'],
            'Customer Service' => ['Customer Success Manager', 'Service Delivery Manager', 'Client Advocate', 'Quality Assurance Specialist', 'Knowledge Base Manager'],
        ];
        
        if (isset($positions[$departmentName])) {
            return $positions[$departmentName][array_rand($positions[$departmentName])];
        }
        
        // Default positions if department not found
        $defaultPositions = ['Specialist', 'Coordinator', 'Analyst', 'Manager', 'Lead'];
        return $defaultPositions[array_rand($defaultPositions)] . ' (' . $departmentName . ')';
    }
    
    private function generateDevelopmentDescription($type, $previousValue, $newValue)
    {
        switch ($type) {
            case 'Promotion':
                return "Promoted from $previousValue to $newValue in recognition of outstanding performance and contribution to the team.";
                
            case 'Salary Increase':
                $increasePercentage = round((floatval($newValue) - floatval($previousValue)) / floatval($previousValue) * 100, 1);
                return "Salary increased by $increasePercentage% from $previousValue to $newValue as part of annual compensation review.";
                
            case 'Training':
                return "Completed $newValue to enhance skills and knowledge in relevant area.";
                
            case 'Position Change':
                return "Role changed from $previousValue to $newValue to better align with departmental needs and employee career goals.";
                
            default:
                return "Career development event recorded.";
        }
    }
}
