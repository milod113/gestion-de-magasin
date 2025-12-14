@extends('layouts.app')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-xl transition-colors duration-300">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100 flex items-center gap-2">
        <i class="ti ti-plus text-blue-500"></i> Créer un rôle
    </h2>

    <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Nom du rôle -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Nom du rôle
            </label>
            <input type="text" name="name" id="name" required
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
        </div>

        <!-- Description du rôle -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Description du rôle
            </label>
            <textarea name="description" id="description" rows="3" placeholder="Décrivez ce rôle..."
                      class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
        </div>

        <!-- Permissions -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Permissions
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($permissions as $permission)
                    <label class="flex items-center gap-2 p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 cursor-pointer hover:shadow-md transition">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                               class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700">
                        <span class="text-gray-800 dark:text-gray-200 text-sm font-medium">
                            {{ $permission->name }}
                        </span>
                    </label>
                @endforeach
            </div>
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
