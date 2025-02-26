<?php
namespace App\Http\Controllers;

use App\Models\CareerDevelopment;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\CareerDevelopmentRequest;

class CareerDevelopmentController extends Controller
{
    public function index()
    {
        $careerDevelopments = CareerDevelopment::with('employee.user')->get();
        return view('career-developments.index', compact('careerDevelopments'));
    }

    public function create()
    {
        $employees = Employee::with('user')->get();
        return view('career-developments.create', compact('employees'));
    }

    public function store(CareerDevelopmentRequest $request)
    {
        CareerDevelopment::create($request->validated());
        
        // Update employee data if it's a salary change or position change
        $employee = Employee::find($request->employee_id);
        if ($request->type === 'Salary Increase') {
            $employee->update(['salary' => $request->new_value]);
        } elseif ($request->type === 'Position Change') {
            $employee->update(['position' => $request->new_value]);
        }
        
        return redirect()->route('career-developments.index')
            ->with('success', 'Career development created successfully.');
    }

    public function show(CareerDevelopment $careerDevelopment)
    {
        return view('career-developments.show', compact('careerDevelopment'));
    }

    public function edit(CareerDevelopment $careerDevelopment)
    {
        $employees = Employee::with('user')->get();
        return view('career-developments.edit', compact('careerDevelopment', 'employees'));
    }

    public function update(CareerDevelopmentRequest $request, CareerDevelopment $careerDevelopment)
    {
        $careerDevelopment->update($request->validated());
        
        return redirect()->route('career-developments.index')
            ->with('success', 'Career development updated successfully.');
    }

    public function destroy(CareerDevelopment $careerDevelopment)
    {
        $careerDevelopment->delete();
        
        return redirect()->route('career-developments.index')
            ->with('success', 'Career development deleted successfully.');
    }
}
