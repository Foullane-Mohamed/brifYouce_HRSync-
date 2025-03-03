<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view departments')->only('index', 'show');
        $this->middleware('permission:create departments')->only('create', 'store');
        $this->middleware('permission:edit departments')->only('edit', 'update');
        $this->middleware('permission:delete departments')->only('destroy');
    }
    
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $departments = Department::with(['company', 'manager'])->paginate(10);
        } else {
            $companyId = auth()->user()->company_id;
            $departments = Department::where('company_id', $companyId)
                ->with(['company', 'manager'])
                ->paginate(10);
        }
        
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $companies = Company::all();
        $managers = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['manager', 'hr', 'admin']);
        })->get();
        
        return view('departments.create', compact('companies', 'managers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $department = Department::create($validated);
        
        return redirect()->route('departments.show', $department)
            ->with('success', 'Département créé avec succès.');
    }

    public function show(Department $department)
    {
        $department->load(['company', 'manager', 'employees.user']);
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $companies = Company::all();
        $managers = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['manager', 'hr', 'admin']);
        })->get();
        
        return view('departments.edit', compact('department', 'companies', 'managers'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $department->update($validated);
        
        return redirect()->route('departments.show', $department)
            ->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        
        return redirect()->route('departments.index')
            ->with('success', 'Département supprimé avec succès.');
    }
}