@extends('layouts.app')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-xl transition-colors duration-300">
    <!-- Titre -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
            <i class="ti ti-key text-indigo-500"></i> Gestion des Permissions
        </h2>
        <a href="{{ route('admin.permissions.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg shadow hover:scale-105 transition">
            <i class="ti ti-plus"></i> Nouvelle permission
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow">
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
            <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-6 py-3">Nom</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                        {{ $permission->name }}
                    </td>
                    <td class="px-6 py-4 flex justify-end gap-2">
                        <a href="{{ route('admin.permissions.edit', $permission) }}" 
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-yellow-500 text-white text-sm font-medium rounded-lg shadow hover:scale-105 transition">
                            <i class="ti ti-edit"></i> Éditer
                        </a>
                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Supprimer cette permission ?')">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:scale-105 transition">
                                <i class="ti ti-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $permissions->links() }}
    </div>
</div>
@endsection
