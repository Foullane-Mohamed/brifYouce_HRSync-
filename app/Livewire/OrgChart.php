<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Department;

class OrgChart extends Component
{
    public $company;
    public $departments = [];
    public $selectedDepartment = null;
    public $employees = [];
    public $hierarchyData = [];
    
    protected $listeners = ['refreshOrgChart' => '$refresh'];
    
    public function mount()
    {
        $this->company = auth()->user()->company;
        $this->loadDepartments();
        $this->loadEmployees();
        $this->buildHierarchy();
    }
    
    public function loadDepartments()
    {
        $this->departments = Department::where('company_id', $this->company->id)
            ->get()
            ->toArray();
    }
    
    public function loadEmployees()
    {
        $query = Employee::where('company_id', $this->company->id)
            ->with('user:id,name,email')
            ->with('department:id,name');
            
        if ($this->selectedDepartment) {
            $query->where('department_id', $this->selectedDepartment);
        }
        
        $this->employees = $query->get()->toArray();
    }
    
    public function buildHierarchy()
    {
        // Get root employees (those without managers)
        $rootEmployees = collect($this->employees)->filter(function ($employee) {
            return $employee['manager_id'] === null;
        });
        
        // Build hierarchy
        $this->hierarchyData = $rootEmployees->map(function ($employee) {
            return $this->buildEmployeeHierarchy($employee);
        })->toArray();
    }
    
    private function buildEmployeeHierarchy($employee)
    {
        $subordinates = collect($this->employees)->filter(function ($subordinate) use ($employee) {
            return $subordinate['manager_id'] === $employee['id'];
        });
        
        $hierarchyData = [
            'id' => $employee['id'],
            'name' => $employee['user']['name'],
            'position' => $employee['position'],
            'department' => $employee['department'] ? $employee['department']['name'] : 'N/A',
            'email' => $employee['user']['email'],
            'children' => []
        ];
        
        if ($subordinates->count() > 0) {
            $hierarchyData['children'] = $subordinates->map(function ($subordinate) {
                return $this->buildEmployeeHierarchy($subordinate);
            })->toArray();
        }
        
        return $hierarchyData;
    }
    
    public function filterByDepartment($departmentId = null)
    {
        $this->selectedDepartment = $departmentId;
        $this->loadEmployees();
        $this->buildHierarchy();
    }
    
    public function render()
    {
        return view('livewire.org-chart');
    }
}