<?php
namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Engineering Department
        Department::create([
            'name' => 'Engineering',
            'code' => 'ENG',
            'description' => 'Software Development and Engineering',
            'manager_id' => User::where('employee_id', 'EMP001')->first()->id,
        ]);

        // Create HR Department
        Department::create([
            'name' => 'Human Resources',
            'code' => 'HR',
            'description' => 'Human Resources Management',
            'manager_id' => User::where('employee_id', 'HR001')->first()->id,
        ]);

        // Create Marketing Department
        Department::create([
            'name' => 'Marketing',
            'code' => 'MKT',
            'description' => 'Marketing and Sales',
            'manager_id' => User::where('employee_id', 'EMP002')->first()->id,
        ]);
    }
}
