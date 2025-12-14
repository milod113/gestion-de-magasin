@extends('layouts.app')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-xl transition-colors duration-300">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100 flex items-center gap-2">
        <i class="ti ti-lock-cog text-blue-500"></i> Gestion des Rôles
    </h2>

    <a href="{{ route('admin.roles.create') }}" 
       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg shadow hover:scale-105 transition">
        <i class="ti ti-plus"></i> Nouveau rôle
    </a>

    <div class="overflow-x-auto mt-6">
        <table class="w-full border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    <th class="p-3 text-left">Nom</th>
                    <th class="p-3 text-left">Permissions</th>
                    <th class="p-3 text-center">Actions</th>
                    <th class="p-3 text-center">Voir</th> <!-- Nouvelle colonne -->

                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <td class="p-3 text-gray-800 dark:text-gray-100 font-semibold">{{ $role->name }}</td>
                    <td class="p-3">
                        @foreach($role->permissions as $permission)
                            <span class="inline-block px-3 py-1 mb-1 text-sm bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-full">
                                {{ $permission->name }}
                            </span>
                        @endforeach
                    </td>
                           <!-- Bouton show -->
        <td class="p-3 text-center">
            <a href="{{ route('admin.roles.show', $role) }}" 
               class="px-3 py-1 text-sm bg-green-500 hover:bg-green-600 text-white rounded-lg transition">
                <i class="ti ti-eye"></i> Voir
            </a>
        </td>
                    <td class="p-3 text-center flex justify-center gap-2">
                        <a href="{{ route('admin.roles.edit', $role) }}" 
                           class="px-3 py-1 text-sm bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                            <i class="ti ti-edit"></i> Éditer
                        </a>
                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Supprimer ce rôle ?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 text-white rounded-lg transition">
                                <i class="ti ti-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $roles->links('pagination::tailwind') }}
    </div>
</div>
@endsection
