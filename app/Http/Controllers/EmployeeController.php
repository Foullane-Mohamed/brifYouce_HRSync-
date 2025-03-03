<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view employees')->only('index', 'show');
        $this->middleware('permission:create employees')->only('create', 'store');
        $this->middleware('permission:edit employees')->only('edit', 'update');
        $this->middleware('permission:delete employees')->only('destroy');
    }
    
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $employees = Employee::with(['user', 'department', 'company'])->paginate(10);
        } else {
            $companyId = auth()->user()->company_id;
            $employees = Employee::where('company_id', $companyId)
                ->with(['user', 'department'])
                ->paginate(10);
        }
        
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $managers = Employee::all();
        $companies = Company::all();
        
        return view('employees.create', compact('departments', 'managers', 'companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string|max:20',
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'birth_date' => 'nullable|date',
            'hire_date' => 'required|date',
            'position' => 'required|string|max:255',
            'contract_type' => 'required|string|in:CDI,CDD,Freelance,Stage',
            'salary' => 'nullable|numeric',
            'status' => 'required|string|in:active,inactive,on_leave',
            'manager_id' => 'nullable|exists:employees,id',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'contract_document' => 'nullable|file|max:10240',
        ]);

        DB::beginTransaction();
        
        try {
            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'] ?? null,
                'company_id' => $validated['company_id'],
                'status' => $validated['status'] === 'active',
            ]);
            
            // Assign default role
            $user->assignRole('employee');
            
            // Create employee
            $employee = Employee::create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'] ?? null,
                'company_id' => $validated['company_id'],
                'birth_date' => $validated['birth_date'] ?? null,
                'hire_date' => $validated['hire_date'],
                'position' => $validated['position'],
                'contract_type' => $validated['contract_type'],
                'salary' => $validated['salary'] ?? null,
                'status' => $validated['status'],
                'manager_id' => $validated['manager_id'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);
            
            // Add media if provided
            if ($request->hasFile('avatar')) {
                $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
            }
            
            if ($request->hasFile('contract_document')) {
                $employee->addMediaFromRequest('contract_document')
                    ->toMediaCollection('contracts');
            }
            
            DB::commit();
            
            return redirect()->route('employees.show', $employee)
                ->with('success', 'Employé créé avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Employee $employee)
    {
        $employee->load(['user', 'department', 'company', 'manager', 'careerEvents']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $managers = Employee::where('id', '!=', $employee->id)->get();
        $companies = Company::all();
        
        return view('employees.edit', compact('employee', 'departments', 'managers', 'companies'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user_id,
            'phone' => 'nullable|string|max:20',
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'birth_date' => 'nullable|date',
            'hire_date' => 'required|date',
            'position' => 'required|string|max:255',
            'contract_type' => 'required|string|in:CDI,CDD,Freelance,Stage',
            'salary' => 'nullable|numeric',
            'status' => 'required|string|in:active,inactive,on_leave',
            'manager_id' => 'nullable|exists:employees,id',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'contract_document' => 'nullable|file|max:10240',
        ]);

        DB::beginTransaction();
        
        try {
            // Update user
            $employee->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'company_id' => $validated['company_id'],
                'status' => $validated['status'] === 'active',
            ]);
            
            // Update employee
            $employee->update([
                'department_id' => $validated['department_id'] ?? null,
                'company_id' => $validated['company_id'],
                'birth_date' => $validated['birth_date'] ?? null,
                'hire_date' => $validated['hire_date'],
                'position' => $validated['position'],
                'contract_type' => $validated['contract_type'],
                'salary' => $validated['salary'] ?? null,
                'status' => $validated['status'],
                'manager_id' => $validated['manager_id'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);
            
            // Update media if provided
            if ($request->hasFile('avatar')) {
                $employee->user->clearMediaCollection('avatar');
                $employee->user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
            }
            
            if ($request->hasFile('contract_document')) {
                $employee->addMediaFromRequest('contract_document')
                    ->toMediaCollection('contracts');
            }
            
            DB::commit();
            
            return redirect()->route('employees.show', $employee)
                ->with('success', 'Employé mis à jour avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Employee $employee)
    {
        DB::beginTransaction();
        
        try {
            $user = $employee->user;
            $employee->delete();
            $user->delete();
            
            DB::commit();
            
            return redirect()->route('employees.index')
                ->with('success', 'Employé supprimé avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    public function orgChart()
    {
        $companyId = auth()->user()->company_id;
        $rootEmployees = Employee::where('company_id', $companyId)
            ->whereNull('manager_id')
            ->with('user')
            ->get();
            
        return view('employees.org-chart', compact('rootEmployees'));
    }
}