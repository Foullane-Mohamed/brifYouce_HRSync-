<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hierarchie;
use App\Models\Employe;
use Illuminate\Http\Request;

class HierarchieController extends Controller
{
    public function index()
    {
        $hierarchies = Hierarchie::all();
        return view('admin.hierarchies.index', compact('hierarchies'));
    }

    public function create()
    {
        $employes = Employe::all();
        return view('admin.hierarchies.create', compact('employes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'manager_id' => 'required|exists:employes,id',
            'position' => 'required|string|max:255',
            'date_ajout' => 'required|date',
        ]);

        Hierarchie::create($request->all());
        return redirect()->route('hierarchies.index')->with('success', 'Hiérarchie créée avec succès.');
    }

    public function edit(Hierarchie $hierarchie)
    {
        $employes = Employe::all();
        return view('admin.hierarchies.edit', compact('hierarchie', 'employes'));
    }

    public function update(Request $request, Hierarchie $hierarchie)
    {
        $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'manager_id' => 'required|exists:employes,id',
            'position' => 'required|string|max:255',
            'date_ajout' => 'required|date',
        ]);

        $hierarchie->update($request->all());
        return redirect()->route('hierarchies.index')->with('success', 'Hiérarchie mise à jour avec succès.');
    }

    public function destroy(Hierarchie $hierarchie)
    {
        $hierarchie->delete();
        return redirect()->route('hierarchies.index')->with('success', 'Hiérarchie supprimée avec succès.');
    }
}
