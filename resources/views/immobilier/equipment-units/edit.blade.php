@extends('layouts.app')

@section('title', 'Modifier exemplaire')
@section('subtitle', 'Mise à jour des informations de l’exemplaire physique')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-indigo-50/40 via-purple-50/30 to-pink-50/30 dark:from-indigo-900/10 dark:via-purple-900/10 dark:to-pink-900/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-400 blur-lg opacity-30"></div>
                        <div class="relative bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 p-3 rounded-xl shadow-lg">
                            <i class="fas fa-barcode text-white text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Modifier l’exemplaire</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            N° inventaire : <span class="font-mono font-semibold">{{ $equipmentUnit->inventory_number ?? '—' }}</span> • 
                            N° série : <span class="font-mono font-semibold">{{ $equipmentUnit->serial_number ?? '—' }}</span>
                        </p>
                    </div>
                </div>
                <a href="{{ route('immobilier.equipment-units.index') }}"
                   class="px-4 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xs"></i>
                    <span>Retour à la liste</span>
                </a>
            </div>
        </div>

        <form action="{{ route('immobilier.equipment-units.update', $equipmentUnit) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg">
                    <p class="font-semibold text-sm mb-1">Veuillez corriger les erreurs suivantes :</p>
                    <ul class="text-sm list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Equipment -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Modèle d’équipement <span class="text-red-500">*</span>
                    </label>
                    <select name="equipment_id"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">-- Sélectionner un modèle --</option>
                        @foreach($equipments as $eq)
                            <option value="{{ $eq->id }}" {{ old('equipment_id', $equipmentUnit->equipment_id) == $eq->id ? 'selected' : '' }}>
                                {{ $eq->label ?? 'Sans libellé' }} 
                                @if($eq->manufacturer || $eq->model)
                                    ({{ $eq->manufacturer }} {{ $eq->model }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Statut <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @foreach([
                            'en_service' => 'En service',
                            'en_panne' => 'En panne',
                            'en_maintenance' => 'En maintenance',
                            'hors_service' => 'Hors service'
                        ] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $equipmentUnit->status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Inventory number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        N° d’inventaire
                    </label>
                    <input type="text" name="inventory_number" value="{{ old('inventory_number', $equipmentUnit->inventory_number) }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Serial number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        N° de série
                    </label>
                    <input type="text" name="serial_number" value="{{ old('serial_number', $equipmentUnit->serial_number) }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Code interne -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Code interne
                    </label>
                    <input type="text" name="code" value="{{ old('code', $equipmentUnit->code) }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Acquisition date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Date d’acquisition
                    </label>
                    <input type="date" name="acquisition_date" value="{{ old('acquisition_date', optional($equipmentUnit->acquisition_date)->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Purchase price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Prix d’acquisition (DZD)
                    </label>
                    <input type="number" step="0.01" min="0" name="purchase_price" value="{{ old('purchase_price', $equipmentUnit->purchase_price) }}"
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Notes / remarques
                </label>
                <textarea name="notes" rows="3"
                          class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2.5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('notes', $equipmentUnit->notes) }}</textarea>
            </div>

            <!-- Footer -->
            <div class="pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <form action="{{ route('immobilier.equipment-units.destroy', $equipmentUnit) }}" method="POST" onsubmit="return confirm('Supprimer cet exemplaire ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2.5 rounded-lg border border-red-200 dark:border-red-700 text-sm text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 flex items-center gap-2">
                        <i class="fas fa-trash"></i>
                        <span>Supprimer</span>
                    </button>
                </form>

                <div class="flex space-x-3">
                    <a href="{{ route('immobilier.equipment-units.index') }}"
                       class="px-5 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Annuler
                    </a>
                    <button type="submit"
                            class="relative group overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 hover:from-indigo-700 hover:via-purple-600 hover:to-pink-500 text-white px-5 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 via-purple-600 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-save relative z-10"></i>
                        <span class="relative z-10 font-semibold">Enregistrer les modifications</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
