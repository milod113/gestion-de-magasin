{{-- resources/views/immobilier/equipment/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modifier un équipement')
@section('subtitle', 'Mettre à jour les informations et le statut de l’équipement')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-indigo-50/40 via-purple-50/30 to-pink-50/40 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-400 blur-lg opacity-30"></div>
                        <div class="relative bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 p-2.5 rounded-xl shadow-lg">
                            <i class="fas fa-edit text-white text-lg"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                            Modifier l'équipement
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">
                            N° série : <span class="font-mono font-semibold">{{ $equipement->serial_number }}</span>
                        </p>
                    </div>
                </div>
                <a href="{{ route('immobilier.equipements.index') }}" 
                   class="text-sm text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center space-x-1">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour à la liste</span>
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('immobilier.equipements.update', $equipement) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Identification -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Numéro de série <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-400 dark:text-gray-500">
                            <i class="fas fa-barcode"></i>
                        </span>
                        <input type="text" name="serial_number" value="{{ old('serial_number', $equipement->serial_number) }}"
                               class="w-full pl-9 pr-3 py-2.5 rounded-lg border @error('serial_number') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-gray-50 dark:bg-gray-700/60 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               required>
                    </div>
                    @error('serial_number')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Numéro d'inventaire interne
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-400 dark:text-gray-500">
                            <i class="fas fa-hashtag"></i>
                        </span>
                        <input type="text" name="inventory_number" value="{{ old('inventory_number', $equipement->inventory_number) }}"
                               class="w-full pl-9 pr-3 py-2.5 rounded-lg border @error('inventory_number') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    @error('inventory_number')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Libellé de l'équipement
                    </label>
                    <input type="text" name="label" value="{{ old('label', $equipement->label) }}"
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('label')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select name="equipment_category_id"
                            class="w-full px-3 py-2.5 rounded-lg border @error('equipment_category_id') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('equipment_category_id', $equipement->equipment_category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('equipment_category_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Fabricant & modèle -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Fabricant
                    </label>
                    <input type="text" name="manufacturer" value="{{ old('manufacturer', $equipement->manufacturer) }}"
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('manufacturer')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Modèle constructeur
                    </label>
                    <input type="text" name="model" value="{{ old('model', $equipement->model) }}"
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('model')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Acquisition -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Date d'acquisition
                    </label>
                    <input type="date" name="acquisition_date" value="{{ old('acquisition_date', optional($equipement->acquisition_date)->format('Y-m-d')) }}"
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('acquisition_date')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Prix d'acquisition (DZD)
                    </label>
                    <input type="number" step="0.01" min="0" name="purchase_price" value="{{ old('purchase_price', $equipement->purchase_price) }}"
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('purchase_price')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Statut <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                            class="w-full px-3 py-2.5 rounded-lg border @error('status') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @foreach([
                            'en_service' => 'En service',
                            'en_panne' => 'En panne',
                            'en_maintenance' => 'En maintenance',
                            'hors_service' => 'Hors service'
                        ] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $equipement->status) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Notes / remarques
                </label>
                <textarea name="notes" rows="3"
                          class="w-full px-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                          placeholder="Informations complémentaires : historique, incidents, spécificités...">{{ old('notes', $equipement->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                <form action="{{ route('immobilier.equipements.destroy', $equipement) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet équipement ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 text-sm rounded-lg border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors flex items-center space-x-2">
                        <i class="fas fa-trash-alt"></i>
                        <span>Supprimer</span>
                    </button>
                </form>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('immobilier.equipements.index') }}" 
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="relative group overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 hover:from-indigo-700 hover:via-purple-600 hover:to-pink-500 text-white px-5 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 via-purple-600 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-save relative z-10"></i>
                        <span class="relative z-10">Enregistrer les modifications</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
