<?php
namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\TrainingRequest;

class TrainingController extends Controller
{
    // Previous methods...
    
    public function store(TrainingRequest $request)
    {
        $training = Training::create($request->validated());
        
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $training->addMedia($document)
                    ->toMediaCollection('training_documents');
            }
        }
        
        return redirect()->route('trainings.index')
            ->with('success', 'Training created successfully.');
    }

    public function show(Training $training)
    {
        $training->load('employees.user');
        return view('trainings.show', compact('training'));
    }

    public function edit(Training $training)
    {
        return view('trainings.edit', compact('training'));
    }

    public function update(TrainingRequest $request, Training $training)
    {
        $training->update($request->validated());
        
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $training->addMedia($document)
                    ->toMediaCollection('training_documents');
            }
        }
        
        return redirect()->route('trainings.index')
            ->with('success', 'Training updated successfully.');
    }

    public function destroy(Training $training)
    {
        $training->delete();
        
        return redirect()->route('trainings.index')
            ->with('success', 'Training deleted successfully.');
    }
    
    public function assignEmployees(Request $request, Training $training)
    {
        $request->validate([
            'employees' => 'required|array',
            'employees.*' => 'exists:employees,id'
        ]);
        
        $training->employees()->sync($request->employees);
        
        return redirect()->route('trainings.show', $training)
            ->with('success', 'Employees assigned to training successfully.');
    }
    
    public function updateStatus(Request $request, Training $training, Employee $employee)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed,Failed'
        ]);
        
        $training->employees()->updateExistingPivot($employee->id, [
            'status' => $request->status
        ]);
        
        return redirect()->route('trainings.show', $training)
            ->with('success', 'Training status updated successfully.');
    }
}