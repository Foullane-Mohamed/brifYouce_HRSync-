<?php
namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\ContractRequest;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('employee.user')->get();
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $employees = Employee::with('user')->get();
        return view('contracts.create', compact('employees'));
    }

    public function store(ContractRequest $request)
    {
        $contract = Contract::create($request->validated());
        
        if ($request->hasFile('document')) {
            $contract->addMediaFromRequest('document')
                ->toMediaCollection('contracts');
        }
        
        return redirect()->route('contracts.index')
            ->with('success', 'Contract created successfully.');
    }

    public function show(Contract $contract)
    {
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $employees = Employee::with('user')->get();
        return view('contracts.edit', compact('contract', 'employees'));
    }

    public function update(ContractRequest $request, Contract $contract)
    {
        $contract->update($request->validated());
        
        if ($request->hasFile('document')) {
            $contract->clearMediaCollection('contracts');
            $contract->addMediaFromRequest('document')
                ->toMediaCollection('contracts');
        }
        
        return redirect()->route('contracts.index')
            ->with('success', 'Contract updated successfully.');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();
        
        return redirect()->route('contracts.index')
            ->with('success', 'Contract deleted successfully.');
    }
}
