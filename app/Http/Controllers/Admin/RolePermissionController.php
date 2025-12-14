<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        $permissions = Permission::all();
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

  


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name',
        'permissions' => 'array'
    ]);

    $role = Role::create([
        'name' => $request->name,
        'guard_name' => 'web',
        'description' => $request->description
    ]);

    if ($request->has('permissions')) {
        // ⚡ On récupère les objets Permission via leurs IDs
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);
    }

    return redirect()->route('admin.roles.index')->with('success', 'Rôle créé avec succès');
}
public function show(Role $role)
{
    // Charge les permissions liées au rôle
    $role->load('permissions');

    // Retourne la vue show.blade.php
    return view('admin.roles.show', compact('role'));
}

public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        'permissions' => 'array',
    ]);

    $role->update([
        'name' => $request->name,
        'description' => $request->description,
        'guard_name' => 'web',
    ]);

    // ⚡ Correction ici : convertir les IDs en objets Permission
    $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();
    $role->syncPermissions($permissions);

    return redirect()->route('admin.roles.index')->with('success', 'Rôle mis à jour avec succès.');
}



    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }



    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Rôle supprimé.');
    }
}
