<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('company')->get();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('departments.create', compact('companies'));
    }

    public function store(DepartmentRequest $request)
    {
        Department::create($request->validated());
        
        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load('employees', 'company');
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $companies = Company::all();
        return view('departments.edit', compact('department', 'companies'));
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());
        
        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        
        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
