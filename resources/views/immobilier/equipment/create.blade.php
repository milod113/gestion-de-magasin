{{-- resources/views/immobilier/equipment/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Nouvel équipement')
@section('subtitle', 'Enregistrer un nouvel équipement biomédical')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Breadcrumb Navigation -->
    <div class="mb-6">
        <nav class="mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        <i class="fas fa-home mr-1"></i>
                        Tableau de bord
                    </a>
                </li>
                <li class="text-gray-400 dark:text-gray-500">
                    <i class="fas fa-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('immobilier.equipements.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        <i class="fas fa-microscope mr-1"></i>
                        Équipements
                    </a>
                </li>
                <li class="text-gray-400 dark:text-gray-500">
                    <i class="fas fa-chevron-right"></i>
                </li>
                <li class="text-indigo-600 dark:text-indigo-400 font-medium">
                    <i class="fas fa-plus-circle mr-1"></i>
                    Nouvel équipement
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-400 blur-lg opacity-30"></div>
                        <div class="relative bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 p-3 rounded-xl shadow-lg">
                            <i class="fas fa-plus text-white text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Enregistrement d'équipement</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            Renseignez les informations du modèle d'équipement biomédical
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('immobilier.equipements.index') }}" 
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/30 dark:to-indigo-800/20 rounded-xl p-4 border border-indigo-100 dark:border-indigo-800/40">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-indigo-800 dark:text-indigo-300 font-medium">Total Équipements</p>
                    <p class="text-2xl font-bold text-indigo-900 dark:text-white mt-1">{{ \App\Models\Immobilier\Equipment::count() }}</p>
                </div>
                <div class="bg-indigo-500/10 p-2 rounded-lg">
                    <i class="fas fa-microscope text-indigo-600 dark:text-indigo-400"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-800/20 rounded-xl p-4 border border-emerald-100 dark:border-emerald-800/40">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-emerald-800 dark:text-emerald-300 font-medium">En service</p>
                    <p class="text-2xl font-bold text-emerald-900 dark:text-white mt-1">
                        {{ \App\Models\Immobilier\Equipment::where('status', 'en_service')->count() }}
                    </p>
                </div>
                <div class="bg-emerald-500/10 p-2 rounded-lg">
                    <i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-800/20 rounded-xl p-4 border border-amber-100 dark:border-amber-800/40">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-amber-800 dark:text-amber-300 font-medium">En maintenance</p>
                    <p class="text-2xl font-bold text-amber-900 dark:text-white mt-1">
                        {{ \App\Models\Immobilier\Equipment::where('status', 'en_maintenance')->count() }}
                    </p>
                </div>
                <div class="bg-amber-500/10 p-2 rounded-lg">
                    <i class="fas fa-tools text-amber-600 dark:text-amber-400"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-rose-50 to-rose-100 dark:from-rose-900/30 dark:to-rose-800/20 rounded-xl p-4 border border-rose-100 dark:border-rose-800/40">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-rose-800 dark:text-rose-300 font-medium">Hors service</p>
                    <p class="text-2xl font-bold text-rose-900 dark:text-white mt-1">
                        {{ \App\Models\Immobilier\Equipment::where('status', 'hors_service')->count() }}
                    </p>
                </div>
                <div class="bg-rose-500/10 p-2 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-rose-600 dark:text-rose-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <!-- Form Header -->
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-indigo-50/40 via-purple-50/30 to-pink-50/40 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-2 rounded-lg">
                        <i class="fas fa-cube text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Informations du modèle d'équipement
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Les informations spécifiques à chaque exemplaire (numéro de série, etc.) seront ajoutées ultérieurement
                        </p>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                        Nouveau modèle
                    </span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('immobilier.equipements.store') }}" class="p-6 space-y-6">
            @csrf

            <!-- Section: Identification -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-1 h-6 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-fingerprint mr-2 text-indigo-500"></i>
                        Identification
                    </h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Libellé de l'équipement <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="label" value="{{ old('label') }}"
                               class="w-full px-4 py-3 rounded-lg border @error('label') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="ex : Scanner Siemens 64 barrettes"
                               required>
                        @error('label')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Nom complet du modèle d'équipement
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section: Catégorie -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-1 h-6 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                        Catégorisation
                    </h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Catégorie <span class="text-red-500">*</span>
                        </label>
                        <select name="equipment_category_id"
                                class="w-full px-4 py-3 rounded-lg border @error('equipment_category_id') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('equipment_category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipment_category_id')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Fabricant & modèle -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-1 h-6 bg-gradient-to-b from-pink-500 to-rose-500 rounded-full"></div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-industry mr-2 text-pink-500"></i>
                        Fabricant & Modèle
                    </h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fabricant <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="manufacturer" value="{{ old('manufacturer') }}"
                               class="w-full px-4 py-3 rounded-lg border @error('manufacturer') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="ex : Siemens, Dräger, GE, Philips..."
                               required>
                        @error('manufacturer')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Modèle constructeur <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="model" value="{{ old('model') }}"
                               class="w-full px-4 py-3 rounded-lg border @error('model') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="ex : SOMATOM Perspective 64, Evita 4, V60..."
                               required>
                        @error('model')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Statut -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-1 h-6 bg-gradient-to-b from-blue-500 to-cyan-500 rounded-full"></div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-cog mr-2 text-blue-500"></i>
                        Statut général
                    </h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Statut <span class="text-red-500">*</span>
                        </label>
                        <select name="status"
                                class="w-full px-4 py-3 rounded-lg border @error('status') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @foreach([
                                'en_service' => 'En service',
                                'en_panne' => 'En panne',
                                'en_maintenance' => 'En maintenance',
                                'hors_service' => 'Hors service'
                            ] as $value => $label)
                                <option value="{{ $value }}" {{ old('status', 'en_service') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Notes -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-1 h-6 bg-gradient-to-b from-amber-500 to-orange-500 rounded-full"></div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-sticky-note mr-2 text-amber-500"></i>
                        Informations complémentaires
                    </h4>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Notes / spécifications techniques
                    </label>
                    <textarea name="notes" rows="4"
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                              placeholder="Spécifications techniques, options installées, informations importantes, etc.">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="flex items-center text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <p class="flex items-center">
                            <i class="fas fa-info-circle mr-2 text-indigo-500"></i>
                            Après création du modèle, vous pourrez ajouter des exemplaires avec numéros de série
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                        <a href="{{ route('immobilier.equipements.index') }}" 
                           class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto relative group overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 hover:from-indigo-700 hover:via-purple-600 hover:to-pink-500 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 via-purple-600 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="fas fa-save mr-2 relative z-10"></i>
                            <span class="relative z-10">Enregistrer le modèle</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labelInput = document.querySelector('input[name="label"]');
        if (labelInput) {
            labelInput.focus();
        }
    });
</script>
@endpush