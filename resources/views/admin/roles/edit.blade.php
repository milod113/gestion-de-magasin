@extends('layouts.app')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-xl transition-colors duration-300">
    <!-- Titre -->
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100 flex items-center gap-2">
        <i class="ti ti-edit text-green-500"></i> Modifier le rôle
    </h2>

    <!-- Formulaire -->
    <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <!-- Nom du rôle -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Nom du rôle
            </label>
            <input type="text" name="name" id="name" value="{{ $role->name }}" required
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Description
            </label>
            <textarea name="description" id="description" rows="3"
                      class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                      placeholder="Décrire le rôle">{{ $role->description }}</textarea>
        </div>

        <!-- Permissions -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                Permissions
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($permissions as $permission)
                    <label class="flex items-center space-x-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}
                            class="rounded text-green-600 focus:ring-green-500">
                        <span class="text-gray-900 dark:text-gray-100">{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Bouton -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-lg shadow hover:scale-105 transition">
                <i class="ti ti-device-floppy"></i> Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
