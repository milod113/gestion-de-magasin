<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CategorieController extends Controller
{

    public function show($id)
{
    // Récupérer la catégorie avec ses articles liés (relation 'articles')
    $categorie = Categorie::with('articles')->findOrFail($id);

    // Passer la catégorie à la vue
    return view('admin.categorie.show', compact('categorie'));
}

    // Affiche la liste paginée des catégories
    public function index()
    {
        $categories = Categorie::paginate(10);
        return view('admin.categorie.index', compact('categories'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('admin.categorie.create');
    }

 

public function store(Request $request)
{
    $request->validate([
        'designation' => 'nullable|string|max:255',
    'description' => 'nullable|string', // Pas de max pour texte long, ou max très élevé si besoin

        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // ✅ new rule
    ]);

    $data = $request->only(['designation','description']);

    // ✅ Handle image upload
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('categories', 'public');
    }

    Categorie::create($data);

    return redirect()->route('categories.index')
        ->with('success', 'Catégorie ajoutée avec succès.');
}

public function edit($id)
{
    $categorie = Categorie::findOrFail($id);
    return view('admin.categorie.edit', compact('categorie'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'designation' => 'nullable|string|max:255',
    'description' => 'nullable|string', // Pas de max pour texte long, ou max très élevé si besoin

        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // ✅ same rule
    ]);

    $categorie = Categorie::findOrFail($id);
    $data = $request->only(['designation','description']);

    // ✅ Handle image replacement
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($categorie->image && Storage::disk('public')->exists($categorie->image)) {
            Storage::disk('public')->delete($categorie->image);
        }
        $data['image'] = $request->file('image')->store('categories', 'public');
    }

    $categorie->update($data);

    return redirect()->route('categories.index')
        ->with('success', 'Catégorie mise à jour avec succès.');
}

    // Supprime une catégorie
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();

        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}
