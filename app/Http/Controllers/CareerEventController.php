<?php

namespace App\Http\Controllers;

use App\Models\CareerEvent;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CareerEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view career events')->only('index', 'show');
        $this->middleware('permission:create career events')->only('create', 'store');
        $this->middleware('permission:edit career events')->only('edit', 'update');
        $this->middleware('permission:delete career events')->only('destroy');
    }

    public function index()
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr')) {
            $careerEvents = CareerEvent::with(['employee.user', 'creator'])
                ->latest()
                ->paginate(10);
        } else {
            // Managers can only see events of their subordinates
            $employeeId = auth()->user()->employee->id ?? null;
            
            if ($employeeId) {
                $subordinateIds = Employee::where('manager_id', $employeeId)->pluck('id')->toArray();
                $careerEvents = CareerEvent::whereIn('employee_id', $subordinateIds)
                    ->orWhere('employee_id', $employeeId)
                    ->with(['employee.user', 'creator'])
                    ->latest()
                    ->paginate(10);
            } else {
                $careerEvents = collect([]);
            }
        }
        
        return view('career-events.index', compact('careerEvents'));
    }

    public function create(Employee $employee = null)
    {
        $employees = Employee::with('user')->get();
        return view('career-events.create', compact('employees', 'employee'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:promotion,salary_change,training',
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'previous_salary' => 'nullable|numeric|required_if:type,salary_change',
            'new_salary' => 'nullable|numeric|required_if:type,salary_change',
            'previous_position' => 'nullable|string|max:255|required_if:type,promotion',
            'new_position' => 'nullable|string|max:255|required_if:type,promotion',
            'document' => 'nullable|file|max:10240',
        ]);
        
        $validated['created_by'] = Auth::id();
        
        $careerEvent = CareerEvent::create($validated);
        
        // Handle document upload
        if ($request->hasFile('document')) {
            $careerEvent->addMediaFromRequest('document')
                ->toMediaCollection('documents');
        }
        
        // Update employee salary or position if relevant
        $employee = Employee::find($validated['employee_id']);
        
        if ($validated['type'] === 'salary_change' && isset($validated['new_salary'])) {
            $employee->update(['salary' => $validated['new_salary']]);
        }
        
        if ($validated['type'] === 'promotion' && isset($validated['new_position'])) {
            $employee->update(['position' => $validated['new_position']]);
        }
        
        return redirect()->route('career-events.show', $careerEvent)
            ->with('success', 'Événement de carrière créé avec succès.');
    }

    public function show(CareerEvent $careerEvent)
    {
        $careerEvent->load(['employee.user', 'creator']);
        return view('career-events.show', compact('careerEvent'));
    }

    public function edit(CareerEvent $careerEvent)
    {
        $employees = Employee::with('user')->get();
        return view('career-events.edit', compact('careerEvent', 'employees'));
    }

    public function update(Request $request, CareerEvent $careerEvent)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:promotion,salary_change,training',
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'previous_salary' => 'nullable|numeric|required_if:type,salary_change',
            'new_salary' => 'nullable|numeric|required_if:type,salary_change',
            'previous_position' => 'nullable|string|max:255|required_if:type,promotion',
            'new_position' => 'nullable|string|max:255|required_if:type,promotion',
            'document' => 'nullable|file|max:10240',
        ]);
        
        $careerEvent->update($validated);
        
        // Handle document upload
        if ($request->hasFile('document')) {
            $careerEvent->addMediaFromRequest('document')
                ->toMediaCollection('documents');
        }
        
        return redirect()->route('career-events.show', $careerEvent)
            ->with('success', 'Événement de carrière mis à jour avec succès.');
    }

    public function destroy(CareerEvent $careerEvent)
    {
        $careerEvent->delete();
        return redirect()->route('career-events.index')
            ->with('success', 'Événement de carrière supprimé avec succès.');
    }
}