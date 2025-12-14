<?php

namespace App\Http\Controllers\Immobilier;

use App\Http\Controllers\Controller;
use App\Models\Immobilier\EquipmentCategory;
use Illuminate\Http\Request;

class EquipmentCategoryController extends Controller
{
 

public function index(Request $request)
{
    // On commence par une query de base
    $query = EquipmentCategory::query();

    // 🔍 Recherche par nom / code / description
    if ($search = $request->get('q')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('code', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    // Tri + pagination (en gardant les filtres dans l’URL)
    $categories = $query
        ->orderBy('name')
        ->paginate(15)
        ->withQueryString();

    return view('immobilier.equipment_categories.index', compact('categories'));
}


    // Formulaire de création
    public function create()
    {
        return view('immobilier.equipment_categories.create');
    }

    // Enregistrement en base
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:50', 'unique:equipment_categories,code'],
            'description' => ['nullable', 'string'],
        ]);

        EquipmentCategory::create($data);

        return redirect()
            ->route('immobilier.categories-equipements.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    // Affichage d'une catégorie (optionnel pour l’instant)
public function show(EquipmentCategory $categories_equipement, Request $request)
{
    $category = $categories_equipement;

    // Base query : modèles d'équipement de cette catégorie
    $query = $category->equipment()
        ->withCount('units')      // => $equipment->units_count dans la vue
        ->orderBy('label');       // ou ->orderBy('model') selon ton choix

    // (optionnel) petit filtre recherche
    if ($search = $request->get('q')) {
        $query->where(function ($q) use ($search) {
            $q->where('label', 'like', "%{$search}%")
              ->orWhere('manufacturer', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%");
        });
    }

    $equipment = $query
        ->paginate(15)
        ->withQueryString();

    return view('immobilier.equipment_categories.show', compact('category', 'equipment'));
}


    // Formulaire d'édition
    public function edit(EquipmentCategory $categories_equipement)
    {
        $category = $categories_equipement;

        return view('immobilier.equipment_categories.edit', compact('category'));
    }

    
    // Mise à jour
    public function update(Request $request, EquipmentCategory $categories_equipement)
    {
        $category = $categories_equipement;

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'code'        => [
                'nullable',
                'string',
                'max:50',
                'unique:equipment_categories,code,' . $category->id,
            ],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($data);

        return redirect()
            ->route('immobilier.categories-equipements.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    // Suppression
    public function destroy(EquipmentCategory $categories_equipement)
    {
        $categories_equipement->delete();

        return redirect()
            ->route('immobilier.categories-equipements.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
