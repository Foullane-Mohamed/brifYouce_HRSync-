<?php
namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(CompanyRequest $request)
    {
        $company = Company::create($request->validated());
        
        if ($request->hasFile('logo')) {
            $company->addMediaFromRequest('logo')
                ->toMediaCollection('logos');
        }
        
        return redirect()->route('companies.index')
            ->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        $company->load('departments', 'employees.user');
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());
        
        if ($request->hasFile('logo')) {
            $company->clearMediaCollection('logos');
            $company->addMediaFromRequest('logo')
                ->toMediaCollection('logos');
        }
        
        return redirect()->route('companies.index')
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        
        return redirect()->route('companies.index')
            ->with('success', 'Company deleted successfully.');
    }
}