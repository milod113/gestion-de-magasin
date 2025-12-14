@extends('layouts.app')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-xl">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Modifier la permission</h2>

    <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom de la permission</label>
            <input type="text" name="name" value="{{ $permission->name }}" required
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-3">
        </div>

        <button class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg shadow hover:scale-105">
            Mettre à jour
        </button>
    </form>
</div>
@endsection
