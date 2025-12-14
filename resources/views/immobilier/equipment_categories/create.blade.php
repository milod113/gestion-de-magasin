@extends('layouts.app')

@section('title', 'Nouvelle catégorie d\'équipement')
@section('subtitle', 'Créer une famille pour organiser le parc biomédical')

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
                    <a href="{{ route('immobilier.categories-equipements.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        <i class="fas fa-layer-group mr-1"></i>
                        Catégories
                    </a>
                </li>
                <li class="text-gray-400 dark:text-gray-500">
                    <i class="fas fa-chevron-right"></i>
                </li>
                <li class="text-indigo-600 dark:text-indigo-400 font-medium">
                    <i class="fas fa-plus-circle mr-1"></i>
                    Nouvelle catégorie
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
                            <i class="fas fa-layer-group text-white text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Création de catégorie</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            Définissez une nouvelle famille d'équipements biomédicaux
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('immobilier.categories-equipements.index') }}" 
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
                    <p class="text-sm text-indigo-800 dark:text-indigo-300 font-medium">Total Catégories</p>
                    <p class="text-2xl font-bold text-indigo-900 dark:text-white mt-1">{{ \App\Models\Immobilier\EquipmentCategory::count() }}</p>
                </div>
                <div class="bg-indigo-500/10 p-2 rounded-lg">
                    <i class="fas fa-layer-group text-indigo-600 dark:text-indigo-400"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-800/20 rounded-xl p-4 border border-emerald-100 dark:border-emerald-800/40">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-emerald-800 dark:text-emerald-300 font-medium">Équipements actifs</p>
                    <p class="text-2xl font-bold text-emerald-900 dark:text-white mt-1">
                        {{ \App\Models\Immobilier\Equipment::count() }}
                    </p>
                </div>
                <div class="bg-emerald-500/10 p-2 rounded-lg">
                    <i class="fas fa-microscope text-emerald-600 dark:text-emerald-400"></i>
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
                    <p class="text-sm text-rose-800 dark:text-rose-300 font-medium">Catégories inactives</p>
                    <p class="text-2xl font-bold text-rose-900 dark:text-white mt-1">
                    </p>
                </div>
                <div class="bg-rose-500/10 p-2 rounded-lg">
                    <i class="fas fa-ban text-rose-600 dark:text-rose-400"></i>
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
                        <i class="fas fa-folder-plus text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Informations de la catégorie
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Les champs marqués d'un <span class="text-red-500">*</span> sont obligatoires
                        </p>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                        Nouvelle catégorie
                    </span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('immobilier.categories-equipements.store') }}" class="p-6 space-y-6">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nom de la catégorie <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400 dark:text-gray-500">
                                <i class="fas fa-tag"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full pl-10 pr-4 py-3 rounded-lg border @error('name') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="ex : Respirateurs, Moniteurs multiparamétriques, Défibrillateurs..."
                                   required>
                        </div>
                        @error('name')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Nom complet de la famille d'équipements
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Code <span class="text-gray-400">(optionnel)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400 dark:text-gray-500">
                                <i class="fas fa-hashtag"></i>
                            </span>
                            <input type="text" name="code" value="{{ old('code') }}"
                                   class="w-full pl-10 pr-4 py-3 rounded-lg border @error('code') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="ex : RESP, MONI, PERF, DEFIB...">
                        </div>
                        @error('code')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Code court unique, pratique pour les exports et les statistiques
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section: Description -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-1 h-6 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                        Description
                    </h4>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Description
                    </label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                              placeholder="Décrivez le type d'appareils inclus dans cette catégorie, les services concernés, les spécificités techniques communes, etc.">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="flex items-center text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Section: Configuration -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-1 h-6 bg-gradient-to-b from-blue-500 to-cyan-500 rounded-full"></div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-cog mr-2 text-blue-500"></i>
                        Configuration
                    </h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fréquence de maintenance recommandée
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400 dark:text-gray-500">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input type="number" name="maintenance_frequency" value="{{ old('maintenance_frequency') }}"
                                   class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="ex : 6 (mois)">
                            <span class="absolute right-3 top-3 text-gray-500 dark:text-gray-400">
                                mois
                            </span>
                        </div>
                        @error('maintenance_frequency')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Fréquence recommandée en mois (0 = pas de maintenance préventive)
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Statut
                        </label>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-indigo-600 rounded border-gray-300 dark:border-gray-600 focus:ring-indigo-500 dark:bg-gray-700">
                                </div>
                                <div>
                                    <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300 font-medium cursor-pointer">
                                        Catégorie active
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        Les catégories inactives n'apparaîtront pas dans les nouveaux ajouts
                                    </p>
                                </div>
                            </div>
                        </div>
                        @error('is_active')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Métadonnées -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-1 h-6 bg-gradient-to-b from-emerald-500 to-green-500 rounded-full"></div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-tags mr-2 text-emerald-500"></i>
                        Métadonnées
                    </h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Mots-clés
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400 dark:text-gray-500">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="text" name="keywords" value="{{ old('keywords') }}"
                                   class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="ex : ventilation, monitoring, urgence, bloc opératoire">
                        </div>
                        @error('keywords')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Mots-clés séparés par des virgules pour faciliter la recherche
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Groupe de risque
                        </label>
                        <select name="risk_level" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Sélectionner un niveau</option>
                            <option value="faible" {{ old('risk_level') == 'faible' ? 'selected' : '' }}>Faible</option>
                            <option value="moyen" {{ old('risk_level') == 'moyen' ? 'selected' : '' }}>Moyen</option>
                            <option value="élevé" {{ old('risk_level') == 'élevé' ? 'selected' : '' }}>Élevé</option>
                            <option value="critique" {{ old('risk_level') == 'critique' ? 'selected' : '' }}>Critique</option>
                        </select>
                        @error('risk_level')
                            <div class="flex items-center text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Niveau de risque pour la sécurité des patients
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <p class="flex items-center">
                            <i class="fas fa-shield-alt mr-2 text-indigo-500"></i>
                            Les catégories organisent le parc et facilitent la gestion des maintenances
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                        <a href="{{ route('immobilier.categories-equipements.index') }}" 
                           class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto relative group overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 hover:from-indigo-700 hover:via-purple-600 hover:to-pink-500 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 via-purple-600 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="fas fa-save mr-2 relative z-10"></i>
                            <span class="relative z-10">Enregistrer la catégorie</span>
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
        const nameInput = document.querySelector('input[name="name"]');
        if (nameInput) {
            nameInput.focus();
        }
    });
</script>
@endpush