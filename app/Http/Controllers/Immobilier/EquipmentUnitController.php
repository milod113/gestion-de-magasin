<?php

namespace App\Http\Controllers\Immobilier;

use App\Http\Controllers\Controller;
use App\Models\Immobilier\EquipmentUnit;
use App\Models\Immobilier\Equipment;
use App\Models\Immobilier\EquipmentCategory;

use Illuminate\Http\Request;

class EquipmentUnitController extends Controller
{
    /**
     * Liste des exemplaires physiques (units)
     */
    public function index(Request $request)
    {
        $query = EquipmentUnit::with(['equipment.category'])
            ->orderBy('inventory_number');

        // 🔍 Recherche globale : inventaire / série / code
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('inventory_number', 'like', '%' . $search . '%')
                  ->orWhere('serial_number', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        // Filtre par modèle d’équipement
        if ($equipmentId = $request->get('equipment_id')) {
            $query->where('equipment_id', $equipmentId);
        }

        // Filtre par statut
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $units = $query->paginate(20)->withQueryString();

        // Pour le filtre / select des modèles d’équipements
        $equipments = Equipment::orderBy('label')->get();

        return view('immobilier.equipment-units.index', compact('units', 'equipments'));
    }

    /**
     * Formulaire de création d’un exemplaire physique
     */
  public function create()
{
    // Modèles d’équipement (ex : Scanner Siemens 64 barrettes)
    $equipments  = Equipment::orderBy('label')->get();

    // Catégories (pour filtrer / info dans le formulaire)
    $categories = EquipmentCategory::orderBy('name')->get();

    return view('immobilier.equipment-units.create', compact('equipments', 'categories'));
}

    /**
     * Enregistrement d’un nouvel exemplaire physique
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'equipment_id'     => ['required', 'exists:equipment,id'],
            'inventory_number' => ['nullable', 'string', 'max:255', 'unique:equipment_units,inventory_number'],
            'serial_number'    => ['nullable', 'string', 'max:255', 'unique:equipment_units,serial_number'],
            'code'             => ['nullable', 'string', 'max:255'],
            'acquisition_date' => ['nullable', 'date'],
            'purchase_price'   => ['nullable', 'numeric', 'min:0'],
            'status'           => ['required', 'string', 'max:50'],
            'notes'            => ['nullable', 'string'],
        ]);

        EquipmentUnit::create($data);

        return redirect()
            ->route('immobilier.equipment-units.index')
            ->with('success', 'Exemplaire d’équipement créé avec succès.');
    }

    /**
     * Détail d’un exemplaire
     */
    public function show(EquipmentUnit $equipmentUnit)
    {
        $equipmentUnit->load('equipment.category');

        return view('immobilier.equipment-units.show', compact('equipmentUnit'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(EquipmentUnit $equipmentUnit)
    {
        $equipments = Equipment::orderBy('label')->get();

        return view('immobilier.equipment-units.edit', [
            'equipmentUnit' => $equipmentUnit,
            'equipments'    => $equipments,
        ]);
    }

    /**
     * Mise à jour d’un exemplaire
     */
    public function update(Request $request, EquipmentUnit $equipmentUnit)
    {
        $data = $request->validate([
            'equipment_id'     => ['required', 'exists:equipment,id'],
            'inventory_number' => [
                'nullable',
                'string',
                'max:255',
                'unique:equipment_units,inventory_number,' . $equipmentUnit->id,
            ],
            'serial_number'    => [
                'nullable',
                'string',
                'max:255',
                'unique:equipment_units,serial_number,' . $equipmentUnit->id,
            ],
            'code'             => ['nullable', 'string', 'max:255'],
            'acquisition_date' => ['nullable', 'date'],
            'purchase_price'   => ['nullable', 'numeric', 'min:0'],
            'status'           => ['required', 'string', 'max:50'],
            'notes'            => ['nullable', 'string'],
        ]);

        $equipmentUnit->update($data);

        return redirect()
            ->route('immobilier.equipment-units.index')
            ->with('success', 'Exemplaire d’équipement mis à jour avec succès.');
    }

    /**
     * Suppression (soft delete) d’un exemplaire
     */
    public function destroy(EquipmentUnit $equipmentUnit)
    {
        $equipmentUnit->delete();

        return redirect()
            ->route('immobilier.equipment-units.index')
            ->with('success', 'Exemplaire d’équipement supprimé avec succès.');
    }
}
