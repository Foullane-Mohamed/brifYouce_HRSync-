<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\Departement;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public function index()
    {
        $employes = Employe::all();
        return view('admin.employes.index', compact('employes'));
    }

    public function create()
    {
        $departements = Departement::all();
        return view('admin.employes.create', compact('departements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employes',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string|max:255',
            'date_recrutement' => 'required|date',
            'type_contrat' => 'required|string|max:50',
            'salaire' => 'required|numeric',
            'departement_id' => 'required|exists:departements,id',
        ]);

        Employe::create($request->all());
        return redirect()->route('employes.index')->with('success', 'Employé créé avec succès.');
    }

    public function edit(Employe $employe)
    {
        $departements = Departement::all();
        return view('admin.employes.edit', compact('employe', 'departements'));
    }

    public function update(Request $request, Employe $employe)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employes,email,' . $employe->id,
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string|max:255',
            'date_recrutement' => 'required|date',
            'type_contrat' => 'required|string|max:50',
            'salaire' => 'required|numeric',
            'departement_id' => 'required|exists:departements,id',
        ]);

        $employe->update($request->all());
        return redirect()->route('employes.index')->with('success', 'Employé mis à jour avec succès.');
    }

    public function destroy(Employe $employe)
    {
        $employe->delete();
        return redirect()->route('employes.index')->with('success', 'Employé supprimé avec succès.');
    }
}

