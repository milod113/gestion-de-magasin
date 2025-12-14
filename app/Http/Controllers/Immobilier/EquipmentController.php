<?php

namespace App\Http\Controllers\Immobilier;

use App\Http\Controllers\Controller;
use App\Models\Immobilier\Equipment;
use App\Models\Immobilier\EquipmentCategory;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    // Liste des équipements (modèles)
    public function index(Request $request)
    {
        // Base query avec relation catégorie
        $query = Equipment::with('category')
            ->orderBy('label');

        // 🔍 Recherche globale (libellé, fabricant, modèle)
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('label', 'like', '%' . $search . '%')
                  ->orWhere('manufacturer', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%');
            });
        }

        // 🔹 Filtre catégorie
        if ($categoryId = $request->get('category_id')) {
            $query->where('equipment_category_id', $categoryId);
        }

        // 🔹 Filtre statut
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Pagination en conservant les filtres dans l’URL
        $equipment = $query->paginate(20)->withQueryString();

        // Pour le select des catégories
        $categories = EquipmentCategory::orderBy('name')->get();

        return view('immobilier.equipment.index', compact('equipment', 'categories'));
    }

    // Formulaire de création
    public function create()
    {
        $categories = EquipmentCategory::orderBy('name')->get();

        return view('immobilier.equipment.create', compact('categories'));
    }

    // Enregistrement d’un modèle d’équipement
    public function store(Request $request)
    {
        $data = $request->validate([
            'equipment_category_id'  => ['required', 'exists:equipment_categories,id'],
            'label'                  => ['required', 'string', 'max:255'],
            'manufacturer'           => ['nullable', 'string', 'max:255'],
            'model'                  => ['nullable', 'string', 'max:255'],
            'status'                 => ['required', 'string', 'max:50'],
            'notes'                  => ['nullable', 'string'],
        ]);

        Equipment::create($data);

        return redirect()
            ->route('immobilier.equipements.index')
            ->with('success', 'Modèle d’équipement créé avec succès.');
    }

    // Détail d’un modèle d’équipement
    public function show(Equipment $equipement)
    {
        $equipement->load('category', 'units'); // 👈 on pourra afficher les exemplaires plus tard

        return view('immobilier.equipment.show', compact('equipement'));
    }

    // Formulaire d’édition
    public function edit(Equipment $equipement)
    {
        $categories = EquipmentCategory::orderBy('name')->get();

        return view('immobilier.equipment.edit', [
            'equipement' => $equipement,
            'categories' => $categories,
        ]);
    }

    // Mise à jour d’un modèle d’équipement
    public function update(Request $request, Equipment $equipement)
    {
        $data = $request->validate([
            'equipment_category_id'  => ['required', 'exists:equipment_categories,id'],
            'label'                  => ['required', 'string', 'max:255'],
            'manufacturer'           => ['nullable', 'string', 'max:255'],
            'model'                  => ['nullable', 'string', 'max:255'],
            'status'                 => ['required', 'string', 'max:50'],
            'notes'                  => ['nullable', 'string'],
        ]);

        $equipement->update($data);

        return redirect()
            ->route('immobilier.equipements.index')
            ->with('success', 'Modèle d’équipement mis à jour avec succès.');
    }

    // Suppression d’un modèle d’équipement
    public function destroy(Equipment $equipement)
    {
        $equipement->delete();

        return redirect()
            ->route('immobilier.equipements.index')
            ->with('success', 'Modèle d’équipement supprimé avec succès.');
    }
}
