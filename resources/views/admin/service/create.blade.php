@extends('layouts.app')

@section('title', 'Créer un Nouveau Service')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-colors duration-300">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Créer un Nouveau Service</h2>
    </div>

    <div class="p-6">
        <form action="{{ route('services.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Code Service -->
                <div>
                    <label for="code_service" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Code du Service <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code_service" id="code_service" required
                           class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                           value="{{ old('code_service') }}">
                    @error('code_service')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Service FR -->
                <div>
                    <label for="service_fr" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nom (Français) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="service_fr" id="service_fr" required
                           class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                           value="{{ old('service_fr') }}">
                    @error('service_fr')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Service AR -->
                <div class="md:col-span-2">
                    <label for="service_arab" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nom (Arabe) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="service_arab" id="service_arab" required dir="rtl"
                           class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-right"
                           value="{{ old('service_arab') }}">
                    @error('service_arab')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('services.index') }}" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i> Annuler
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-primary {
        @apply bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center;
    }
    
    .btn-secondary {
        @apply bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center;
    }
</style>
@endpush