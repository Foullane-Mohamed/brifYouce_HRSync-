<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view companies')->only('index', 'show');
        $this->middleware('permission:create companies')->only('create', 'store');
        $this->middleware('permission:edit companies')->only('edit', 'update');
        $this->middleware('permission:delete companies')->only('destroy');
    }
    
    public function index()
    {
        $companies = Company::paginate(10);
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies',
            'industry' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048', // 2MB max
        ]);

        $company = Company::create($validated);

        if ($request->hasFile('logo')) {
            $company->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        return redirect()->route('companies.show', $company)
            ->with('success', 'Entreprise créée avec succès.');
    }

    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('companies')->ignore($company->id)],
            'industry' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048', // 2MB max
        ]);

        $company->update($validated);

        if ($request->hasFile('logo')) {
            $company->clearMediaCollection('logo');
            $company->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        return redirect()->route('companies.show', $company)
            ->with('success', 'Entreprise mise à jour avec succès.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')
            ->with('success', 'Entreprise supprimée avec succès.');
    }
}