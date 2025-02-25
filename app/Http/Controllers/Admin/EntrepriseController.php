<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    public function index()
    {
        $entreprises = Entreprise::all();
        return view('admin.entreprises.index', compact('entreprises'));
    }

    public function create()
    {
        return view('admin.entreprises.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'secteur' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:entreprises',
            'telephone' => 'required|string|max:20',
            'date_inscription' => 'required|date',
        ]);

        Entreprise::create($request->all());
        return redirect()->route('entreprises.index')->with('success', 'Entreprise créée avec succès.');
    }

    public function edit(Entreprise $entreprise)
    {
        return view('admin.entreprises.edit', compact('entreprise'));
    }

    public function update(Request $request, Entreprise $entreprise)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'secteur' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:entreprises,email,' . $entreprise->id,
            'telephone' => 'required|string|max:20',
            'date_inscription' => 'required|date',
        ]);

        $entreprise->update($request->all());
        return redirect()->route('entreprises.index')->with('success', 'Entreprise mise à jour avec succès.');
    }

    public function destroy(Entreprise $entreprise)
    {
        $entreprise->delete();
        return redirect()->route('entreprises.index')->with('success', 'Entreprise supprimée avec succès.');
    }
}

