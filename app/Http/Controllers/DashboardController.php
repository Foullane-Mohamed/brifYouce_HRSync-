<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Contract;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Admin or company admin dashboard
        if ($user->hasRole(['admin', 'company_admin'])) {
            // Get company specific data if company admin
            $companyId = null;
            if ($user->hasRole('company_admin')) {
                $companyId = $user->company_id;
            }
            
            $stats = $this->getAdminStats($companyId);
            return view('dashboard.admin', compact('stats'));
        }
        
        // Manager dashboard
        if ($user->hasRole('manager')) {
            $manager = $user->employee;
            $stats = $this->getManagerStats($manager);
            return view('dashboard.manager', compact('stats'));
        }
        
        // Employee dashboard
        $employee = $user->employee;
        
        // Add a check to handle cases where no employee exists
        if (!$employee) {
            // Redirect or show an error view
            return view('dashboard.no-employee');
        }
        
        $stats = $this->getEmployeeStats($employee);
        return view('dashboard.employee', compact('stats'));
    }
    
    private function getAdminStats($companyId = null)
    {
        $employeeQuery = Employee::query();
        $departmentQuery = Department::query();
        $contractQuery = Contract::query();
        $trainingQuery = Training::query();
        
        if ($companyId) {
            $employeeQuery->whereHas('user', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
            $departmentQuery->where('company_id', $companyId);
            $contractQuery->whereHas('employee.user', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }
        
        return [
            'total_employees' => $employeeQuery->count(),
            'total_departments' => $departmentQuery->count(),
            'active_contracts' => $contractQuery->whereNull('end_date')->orWhere('end_date', '>=', now())->count(),
            'expiring_contracts' => $contractQuery->whereBetween('end_date', [now(), now()->addMonth()])->count(),
            'ongoing_trainings' => $trainingQuery->whereDate('end_date', '>=', now())->count(),
            'recent_hires' => $employeeQuery->whereDate('hire_date', '>=', now()->subMonths(3))->count(),
        ];
    }
    
    private function getManagerStats($manager)
    {
        if (!$manager) {
            return [
                'team_size' => 0,
                'department_size' => 0,
                'active_team_contracts' => 0,
                'team_trainings' => 0,
            ];
        }

        return [
            'team_size' => $manager->subordinates()->count(),
            'department_size' => $manager->department ? $manager->department->employees()->count() : 0,
            'active_team_contracts' => Contract::whereHas('employee', function ($q) use ($manager) {
                $q->where('manager_id', $manager->id);
            })->whereNull('end_date')->orWhere('end_date', '>=', now())->count(),
            'team_trainings' => Training::whereHas('employees', function ($q) use ($manager) {
                $q->where('manager_id', $manager->id);
            })->whereDate('end_date', '>=', now())->count(),
        ];
    }
    
    private function getEmployeeStats($employee)
    {
        if (!$employee) {
            return [
                'active_contracts' => 0,
                'career_developments' => 0,
                'ongoing_trainings' => 0,
                'completed_trainings' => 0,
            ];
        }

        return [
            'active_contracts' => $employee->contracts()->whereNull('end_date')->orWhere('end_date', '>=', now())->count(),
            'career_developments' => $employee->careerDevelopments()->count(),
            'ongoing_trainings' => $employee->trainings()->wherePivot('status', '!=', 'Completed')->wherePivot('status', '!=', 'Failed')->count(),
            'completed_trainings' => $employee->trainings()->wherePivot('status', 'Completed')->count(),
        ];
    }
}