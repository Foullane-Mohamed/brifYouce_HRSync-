<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrgChart extends Component
{
    public $activeDepartment = null;
    public $departments = [];
    public $companyId = null;
    
    public function mount()
    {
        $user = Auth::user();
        
        // Si l'utilisateur est un admin d'entreprise, limiter aux départements de son entreprise
        if ($user->hasRole('company_admin')) {
            $this->companyId = $user->company_id;
        }
        
        $this->loadDepartments();
    }
    
    public function loadDepartments()
    {
        $query = Department::with(['company']);
        
        if ($this->companyId) {
            $query->where('company_id', $this->companyId);
        }
        
        $this->departments = $query->get();
    }
    
    public function toggleDepartment($departmentId)
    {
        if ($this->activeDepartment === $departmentId) {
            $this->activeDepartment = null;
        } else {
            $this->activeDepartment = $departmentId;
        }
    }
    
    public function getEmployeesByDepartment($departmentId)
    {
        // Récupérer tous les employés de premier niveau (sans manager) dans le département
        $topEmployees = Employee::with(['user', 'subordinates.user', 'subordinates.subordinates.user'])
            ->where('department_id', $departmentId)
            ->whereNull('manager_id')
            ->get();
            
        return $topEmployees;
    }
    
    public function render()
    {
        return view('livewire.org-chart', [
            'departments' => $this->departments,
        ]);
    }
}