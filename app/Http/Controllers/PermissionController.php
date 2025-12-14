<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // Liste des permissions
  public function index()
{
    $permissions = Permission::paginate(10); // 10 par page
    return view('admin.permissions.index', compact('permissions'));
}


    // Formulaire de création
    public function create()
    {
        return view('admin.permissions.create');
    }

    // Enregistrer une permission
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web', // obligatoire pour Spatie
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission créée avec succès');
    }

    // Formulaire d’édition
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    // Mettre à jour une permission
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission mise à jour');
    }

    // Supprimer une permission
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission supprimée');
    }
}
