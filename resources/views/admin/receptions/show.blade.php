@extends('layouts.app')

@section('title', 'Détails Réception')
@section('subtitle', 'Informations complètes sur la réception')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300">
    <!-- Header with Gradient -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur-lg opacity-30"></div>
                    <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-3 rounded-xl shadow-lg">
                        <i class="ti ti-truck-delivery text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Bon de Livraison</h3>
                    <div class="flex items-center space-x-4 mt-1">
                        <p class="text-sm font-mono text-gray-600 dark:text-gray-300">
                            Réf: {{ $reception->reception_reference }}
                        </p>
                        <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Date: {{ optional($reception->date_reception)->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('receptions.index') }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-gray-600 via-gray-500 to-gray-400 hover:from-gray-700 hover:via-gray-600 hover:to-gray-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-arrow-left relative z-10"></i>
                    <span class="relative z-10 font-semibold">Retour</span>
                </a>
                
                <a href="{{ route('receptions.edit', $reception->id_reception) }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-edit relative z-10"></i>
                    <span class="relative z-10 font-semibold">Modifier</span>
                </a>
                
                <form action="{{ route('receptions.destroy', $reception->id_reception) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="relative group overflow-hidden bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 hover:from-red-700 hover:via-orange-600 hover:to-amber-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réception ?')">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-trash relative z-10"></i>
                        <span class="relative z-10 font-semibold">Supprimer</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Reception Details -->
    <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Information Générale Card -->
            <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="ti ti-file-invoice text-white text-sm"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Informations générales</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date Réception -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-6 h-6 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                                <i class="ti ti-calendar text-blue-400 text-xs"></i>
                            </div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Date Réception</h4>
                        </div>
                        <p class="text-gray-800 dark:text-white font-medium">
                            {{ optional($reception->date_reception)->format('d/m/Y') ?? '-' }}
                        </p>
                    </div>

                    <!-- Convention -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-6 h-6 rounded-md bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-cyan-900/30 dark:to-blue-900/30 flex items-center justify-center">
                                <i class="ti ti-file-description text-cyan-400 text-xs"></i>
                            </div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Convention</h4>
                        </div>
                        <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-cyan-900/30 dark:to-blue-900/30 text-cyan-800 dark:text-cyan-200 border border-cyan-200 dark:border-cyan-800">
                            {{ $reception->convention->reference ?? '-' }}
                        </span>
                    </div>

                    <!-- Fournisseur (via convention) -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-6 h-6 rounded-md bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 flex items-center justify-center">
                                <i class="ti ti-building-warehouse text-purple-400 text-xs"></i>
                            </div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Fournisseur</h4>
                        </div>

                        @php
                            $f = $reception->convention->fournisseur ?? null;
                        @endphp

                        @if($f)
                            <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 text-purple-800 dark:text-purple-200 border border-purple-200 dark:border-purple-800">
                                {{ $f->sociéte ?? $f->nom }}
                            </span>
                        @else
                            <span class="text-gray-500 dark:text-gray-400">-</span>
                        @endif
                    </div>

                    <!-- Utilisateur -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-6 h-6 rounded-md bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 flex items-center justify-center">
                                <i class="ti ti-user text-green-400 text-xs"></i>
                            </div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Utilisateur</h4>
                        </div>
                        @if($reception->user)
                            <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800">
                                {{ $reception->user->name }}
                            </span>
                        @else
                            <span class="text-gray-500 dark:text-gray-400">-</span>
                        @endif
                    </div>

                    <!-- Total -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-6 h-6 rounded-md bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 flex items-center justify-center">
                                <i class="ti ti-currency-dollar text-emerald-400 text-xs"></i>
                            </div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Montant Total</h4>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">
                                {{ number_format($reception->Total, 2, ',', ' ') }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">DZD</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles Section -->
            <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-green-500 to-emerald-400 flex items-center justify-center">
                            <i class="ti ti-packages text-white text-sm"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Articles reçus</h4>
                    </div>
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
                        {{ $reception->lignes->count() }} article(s)
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <th class="px-6 py-3 text-left">#</th>
                                <th class="px-6 py-3 text-left">Article</th>
                                <th class="px-6 py-3 text-left">Quantité</th>
                                <th class="px-6 py-3 text-left">Prix Unitaire</th>
                                <th class="px-6 py-3 text-left">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($reception->lignes as $index => $ligne)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800 dark:text-white">
                                            {{ $ligne->article->designation ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $ligne->article_reference ?? '' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800">
                                            {{ $ligne->quantité }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                            {{ number_format($ligne->prix_unitaire, 2, ',', ' ') }} DZD
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">
                                            {{ number_format($ligne->sous_total, 2, ',', ' ') }} DZD
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                                <i class="ti ti-package-off text-gray-400"></i>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 dark:text-gray-400">
                                                    Aucun article reçu
                                                </p>
                                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                    Les articles apparaîtront ici
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if($reception->lignes->count() > 0)
                            <tfoot>
                                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 border-t border-gray-200 dark:border-gray-700">
                                    <td colspan="4" class="px-6 py-4 text-right text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Total général:
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-lg font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">
                                            {{ number_format($reception->Total, 2, ',', ' ') }} DZD
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-6">
            <!-- Summary Card -->
            <div class="bg-gradient-to-br from-blue-50 via-white to-emerald-50 dark:from-blue-900/10 dark:via-gray-800 dark:to-emerald-900/10 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 flex items-center justify-center">
                        <i class="ti ti-chart-bar text-white text-sm"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Résumé</h4>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Valeur totale</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">
                            {{ number_format($reception->Total, 2, ',', ' ') }} DZD
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Nombre d'articles</p>
                        <p class="text-xl font-bold text-gray-800 dark:text-white">
                            {{ $reception->lignes->count() }}
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Statut</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-800 dark:text-green-200">
                                <i class="ti ti-check mr-1"></i>
                                Reçu
                            </span>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Type</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200">
                                <i class="ti ti-truck mr-1"></i>
                                Livraison
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-purple-500 to-pink-400 flex items-center justify-center">
                        <i class="ti ti-history text-white text-sm"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Historique</h4>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 mt-2 rounded-full bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">Créée le</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ optional($reception->created_at)->format('d/m/Y H:i') ?? '-' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 mt-2 rounded-full bg-gradient-to-r from-emerald-500 to-green-400"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">Réceptionnée le</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ optional($reception->date_reception)->format('d/m/Y') ?? '-' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 mt-2 rounded-full bg-gradient-to-r from-purple-500 to-pink-400"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">Dernière mise à jour</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ optional($reception->updated_at)->format('d/m/Y H:i') ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-gradient-to-br from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Actions rapides</h4>
                
                <div class="space-y-3">
                    <button onclick="window.print()" 
                            class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 text-gray-800 dark:text-gray-200 px-4 py-3 rounded-lg font-medium shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2">
                        <i class="ti ti-printer"></i>
                        <span>Imprimer le bon</span>
                    </button>
                    
                    <button onclick="shareReception()"
                            class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 text-gray-800 dark:text-gray-200 px-4 py-3 rounded-lg font-medium shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2">
                        <i class="ti ti-share"></i>
                        <span>Partager</span>
                    </button>
                    
                    <a href="#"
                       class="block w-full bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 text-center">
                        Générer le PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div id="notification" class="fixed top-4 right-4 z-50 animate-slide-in">
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border border-green-200 dark:border-green-800 rounded-xl shadow-lg p-4 max-w-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center">
                <i class="ti ti-check text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('notification').remove()" class="text-green-400 hover:text-green-600 dark:hover:text-green-300">
                <i class="ti ti-x"></i>
            </button>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div id="error-notification" class="fixed top-4 right-4 z-50 animate-slide-in">
    <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/30 dark:to-orange-900/30 border border-red-200 dark:border-red-800 rounded-xl shadow-lg p-4 max-w-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-red-400 to-orange-500 flex items-center justify-center">
                <i class="ti ti-exclamation-circle text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
            <button onclick="document.getElementById('error-notification').remove()" class="text-red-400 hover:text-red-600 dark:hover:text-red-300">
                <i class="ti ti-x"></i>
            </button>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    @keyframes slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-slide-in { animation: slide-in 0.3s ease-out forwards; }
    * { transition: all 0.2s ease-in-out; }
    .gradient-text { background-clip: text; -webkit-background-clip: text; color: transparent; }
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notifications = ['notification', 'error-notification'];
    notifications.forEach(id => {
        const element = document.getElementById(id);
        if (element) setTimeout(() => element.remove(), 5000);
    });
});

// Share reception functionality
function shareReception() {
    if (navigator.share) {
        navigator.share({
            title: 'Bon de Livraison {{ $reception->reception_reference }}',
            text: 'Détails du bon de livraison : {{ $reception->reception_reference }}',
            url: window.location.href,
        }).catch(() => {});
    } else {
        navigator.clipboard.writeText(window.location.href)
            .then(() => alert('Lien copié dans le presse-papier !'))
            .catch(() => {});
    }
}
</script>
@endpush
