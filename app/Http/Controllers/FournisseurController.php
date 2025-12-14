<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
 public function index()
{
    $fournisseurs = Fournisseur::paginate(10); // Adjust the number as needed
    return view('admin.fournisseurs.index', compact('fournisseurs'));
}

    public function create()
    {
        return view('admin.fournisseurs.create');
    }

  public function store(Request $request)
{
    $request->validate([
        'code_fournisseur' => 'required|unique:fournisseurs,code_fournisseur',
        'sociéte' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'adresse' => 'required|string|max:500',
        'ville' => 'required|string|max:255',
        'télephone' => 'nullable|string|max:15',
        'mobile' => 'nullable|string|max:15',
        'fax' => 'nullable|string|max:15',
        'NIS' => 'nullable|string|max:50',
        'NIF' => 'nullable|string|max:50',
        'RC' => 'nullable|string|max:50',
        'raison_sociale' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:50',
        'n_compte' => 'nullable|string|max:50',
    ]);

    Fournisseur::create($request->all());

    return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur créé avec succès.');
}

    public function edit($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        return view('admin.fournisseurs.edit', compact('fournisseur'));
    }

  public function update(Request $request, $id)
{
    $fournisseur = Fournisseur::findOrFail($id);

    $request->validate([
        'code_fournisseur' => 'required|unique:fournisseurs,code_fournisseur,' . $id . ',id_fournisseur',
        'sociéte' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'adresse' => 'required|string|max:500',
        'ville' => 'required|string|max:255',
        'télephone' => 'nullable|string|max:15',
        'mobile' => 'nullable|string|max:15',
        'fax' => 'nullable|string|max:15',
        'NIS' => 'nullable|string|max:50',
        'NIF' => 'nullable|string|max:50',
        'RC' => 'nullable|string|max:50',
        'raison_sociale' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:50',
        'n_compte' => 'nullable|string|max:50',
    ]);

    $fournisseur->update($request->all());

    return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur mis à jour avec succès.');
}

    public function destroy($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();

        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur supprimé avec succès.');
    }
}
