<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user', 'department')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $managers = Employee::all();
        return view('employees.create', compact('departments', 'managers'));
    }

    public function store(EmployeeRequest $request)
    {
        // Create user first
        $userData = $request->validated()['user'];
        $userData['password'] = Hash::make($userData['password']);
        $user = User::create($userData);

        // Assign role to user
        $user->assignRole($request->role);
        
        // Then create employee with user_id
        $employeeData = $request->validated()['employee'];
        $employeeData['user_id'] = $user->id;
        $employee = Employee::create($employeeData);
        
        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load('user', 'department', 'manager', 'subordinates', 'contracts', 'careerDevelopments', 'trainings');
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $managers = Employee::where('id', '!=', $employee->id)->get();
        return view('employees.edit', compact('employee', 'departments', 'managers'));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        // Update user data
        $userData = $request->validated()['user'];
        if (empty($userData['password'])) {
            unset($userData['password']);
        } else {
            $userData['password'] = Hash::make($userData['password']);
        }
        
        $employee->user->update($userData);
        
        // Update role if changed
        if ($request->role) {
            $employee->user->syncRoles([$request->role]);
        }
        
        // Update employee data
        $employeeData = $request->validated()['employee'];
        $employee->update($employeeData);
        
        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        // Delete user will cascade to employee due to relationship
        $employee->user->delete();
        
        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
