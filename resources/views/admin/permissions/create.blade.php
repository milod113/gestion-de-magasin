@extends('layouts.app')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-xl transition-colors duration-300">
    <!-- Titre -->
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100 flex items-center gap-2">
        <i class="ti ti-key text-indigo-500"></i> Créer une permission
    </h2>

    <!-- Formulaire -->
<form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
        @csrf

        <!-- Nom de la permission -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Nom de la permission
            </label>
            <input type="text" name="name" id="name" required
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        </div>

        <!-- Bouton -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg shadow hover:scale-105 transition">
                <i class="ti ti-device-floppy"></i> Créer
            </button>
        </div>
    </form>
</div>
@endsection
