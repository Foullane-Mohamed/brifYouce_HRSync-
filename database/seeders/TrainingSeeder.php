<?php
namespace Database\Seeders;

use App\Models\Training;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    public function run(): void
    {
        $trainingData = [
            [
                'name' => 'New Employee Orientation',
                'description' => 'Introduction to company policies, procedures, and culture for all new employees.',
                'start_date' => now()->subMonths(6),
                'end_date' => now()->subMonths(6)->addDays(2),
                'departments' => [], // All departments
            ],
            [
                'name' => 'Leadership Development Program',
                'description' => 'Comprehensive program designed to develop leadership skills for managers and high-potential employees.',
                'start_date' => now()->subMonths(3),
                'end_date' => now()->addMonths(3),
                'departments' => [], // All departments, but only for managers
                'managers_only' => true,
            ],
            [
                'name' => 'Advanced Excel for Business',
                'description' => 'Master advanced Excel functions, formulas, and data analysis techniques for business applications.',
                'start_date' => now()->subMonths(2),
                'end_date' => now()->subMonths(2)->addDays(5),
                'departments' => ['Finance', 'Operations', 'Human Resources'],
            ],
            [
                'name' => 'Digital Marketing Fundamentals',
                'description' => 'Learn the fundamentals of digital marketing including SEO, content marketing, social media, and analytics.',
                'start_date' => now()->subMonths(1),
                'end_date' => now()->subMonths(1)->addDays(14),
                'departments' => ['Marketing', 'Sales'],
            ],
            [
                'name' => 'Cybersecurity Awareness',
                'description' => 'Essential training on recognizing and preventing security threats to protect company data.',
                'start_date' => now()->addWeeks(2),
                'end_date' => now()->addWeeks(2)->addDays(1),
                'departments' => [], // All departments
            ],
            [
                'name' => 'Agile Project Management',
                'description' => 'Introduction to agile methodologies, scrum, and kanban for effective project management.',
                'start_date' => now()->addMonths(1),
                'end_date' => now()->addMonths(1)->addDays(3),
                'departments' => ['Information Technology', 'Research & Development', 'Operations'],
            ],
            [
                'name' => 'Customer Service Excellence',
                'description' => 'Strategies and techniques for delivering exceptional customer service and handling difficult situations.',
                'start_date' => now()->addMonths(2),
                'end_date' => now()->addMonths(2)->addDays(2),
                'departments' => ['Customer Service', 'Sales'],
            ],
            [
                'name' => 'Financial Planning and Analysis',
                'description' => 'Advanced course on financial forecasting, budgeting, and strategic financial analysis.',
                'start_date' => now()->addMonths(3),
                'end_date' => now()->addMonths(3)->addDays(4),
                'departments' => ['Finance'],
            ],
        ];
        
        // Create trainings
        foreach ($trainingData as $trainingInfo) {
            $training = Training::create([
                'name' => $trainingInfo['name'],
                'description' => $trainingInfo['description'],
                'start_date' => $trainingInfo['start_date'],
                'end_date' => $trainingInfo['end_date'],
            ]);
            
            // Assign employees to training
            $departments = !empty($trainingInfo['departments']) 
                ? Department::whereIn('name', $trainingInfo['departments'])->get() 
                : Department::all();
                
            foreach ($departments as $department) {
                $employeeQuery = Employee::where('department_id', $department->id);
                
                // If training is for managers only, filter by position containing "Manager"
                if (isset($trainingInfo['managers_only']) && $trainingInfo['managers_only']) {
                    $employeeQuery->where('position', 'like', '%Manager%');
                }
                
                $employees = $employeeQuery->get();
                
                foreach ($employees as $employee) {
                    // Randomly determine if employee will participate and their status
                    if (rand(0, 10) > 3) { // 70% chance of participation
                        $status = $this->determineTrainingStatus($trainingInfo['start_date'], $trainingInfo['end_date']);
                        $training->employees()->attach($employee->id, ['status' => $status]);
                    }
                }
            }
        }
    }
    
    private function determineTrainingStatus($startDate, $endDate)
    {
        $now = now();
        
        if ($now < $startDate) {
            return 'Pending';
        } elseif ($now >= $startDate && $now <= $endDate) {
            return 'In Progress';
        } else {
            // Training has ended
            return rand(0, 10) > 1 ? 'Completed' : 'Failed'; // 90% completion rate
        }
    }
}