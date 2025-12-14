@extends('layouts.app')

@section('title', 'Détails de l\'article')
@section('subtitle', 'Informations complètes sur l\'article')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300">
    <!-- Product Header with Gradient -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur-lg opacity-30"></div>
                    <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-3 rounded-xl shadow-lg">
                        <i class="ti ti-package text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $article->designation }}</h3>
                    <div class="flex items-center space-x-4 mt-1">
                        <p class="text-sm font-mono text-gray-600 dark:text-gray-300">Réf: {{ $article->ref_article }}</p>
                        <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">SKU: {{ $article->ref_article }}</p>
                    </div>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('articles.edit', $article->id_article) }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-edit relative z-10"></i>
                    <span class="relative z-10 font-semibold">Modifier</span>
                </a>
                
                <form action="{{ route('articles.destroy', $article->id_article) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="relative group overflow-hidden bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 hover:from-red-700 hover:via-orange-600 hover:to-amber-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-trash relative z-10"></i>
                        <span class="relative z-10 font-semibold">Supprimer</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description Card -->
            <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="ti ti-file-description text-white text-sm"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Description</h4>
                </div>
                <div class="prose prose-blue dark:prose-invert max-w-none">
                    @if($article->description)
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $article->description }}
                        </p>
                    @else
                        <div class="text-center py-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center mx-auto mb-3">
                                <i class="ti ti-info-circle text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 italic">Aucune description disponible</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-6 h-6 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                            <i class="ti ti-category text-blue-400 text-xs"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Catégorie</h4>
                    </div>
                    @if($article->categorie)
                        <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 text-indigo-800 dark:text-indigo-200 border border-indigo-200 dark:border-indigo-800">
                            {{ $article->categorie->designation }}
                        </span>
                    @else
                        <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-500 dark:text-gray-400">
                            Non catégorisé
                        </span>
                    @endif
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-6 h-6 rounded-md bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 flex items-center justify-center">
                            <i class="ti ti-currency-dollar text-emerald-400 text-xs"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Prix</h4>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">
                            {{ number_format($article->prix, 2) }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">DZD</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-6 h-6 rounded-md bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-cyan-900/30 dark:to-blue-900/30 flex items-center justify-center">
                            <i class="ti ti-packages text-cyan-400 text-xs"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Quantité en stock</h4>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $article->quantite_en_stock }}
                        </span>
                        @if($article->quantite_en_stock < 10)
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-800">
                                Faible
                            </span>
                        @elseif($article->quantite_en_stock < 50)
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-200 border border-amber-200 dark:border-amber-800">
                                Moyen
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-800">
                                Bon
                            </span>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-6 h-6 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                            <i class="ti ti-weight text-blue-400 text-xs"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Unité</h4>
                    </div>
                    <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-800 dark:text-white shadow-sm">
                        {{ $article->unité ?? 'N/A' }}
                    </span>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-6 h-6 rounded-md bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 flex items-center justify-center">
                            <i class="ti ti-calendar-plus text-purple-400 text-xs"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Créé le</h4>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="ti ti-calendar text-blue-400"></i>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ $article->created_at ? $article->created_at->format('d/m/Y H:i') : 'N/A' }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-6 h-6 rounded-md bg-gradient-to-r from-orange-100 to-red-100 dark:from-orange-900/30 dark:to-red-900/30 flex items-center justify-center">
                            <i class="ti ti-calendar-stats text-orange-400 text-xs"></i>
                        </div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Dernière mise à jour</h4>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="ti ti-history text-cyan-400"></i>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ $article->updated_at ? $article->updated_at->format('d/m/Y H:i') : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image and Stats -->
        <div class="space-y-6">
            <!-- Product Image Card -->
            <div class="relative overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10"></div>
                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" 
                         alt="{{ $article->designation }}"
                         class="relative w-full h-64 object-contain p-8 transform group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute bottom-4 right-4 px-3 py-1 rounded-full bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 text-white text-xs font-medium shadow-lg">
                        <i class="ti ti-photo mr-1"></i> Image produit
                    </div>
                @else
                    <div class="relative w-full h-64 flex flex-col items-center justify-center text-gray-400">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-100 via-cyan-100 to-emerald-100 dark:from-blue-900/20 dark:via-cyan-900/20 dark:to-emerald-900/20 flex items-center justify-center mb-3">
                            <i class="ti ti-photo text-3xl text-blue-400"></i>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Aucune image disponible</p>
                    </div>
                @endif
            </div>

            <!-- Quick Stats Card -->
            <div class="bg-gradient-to-br from-blue-50 via-white to-emerald-50 dark:from-blue-900/10 dark:via-gray-800 dark:to-emerald-900/10 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 flex items-center justify-center">
                        <i class="ti ti-chart-bar text-white text-sm"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Statistiques d'inventaire</h4>
                </div>
                
                <div class="space-y-6">
                    <div class="relative">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Valeur du stock</span>
                            <span class="text-sm font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">
                                {{ number_format($article->prix * $article->quantite_en_stock, 2) }} DH
                            </span>
                        </div>
                        <div class="h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 rounded-full" 
                                 style="width: {{ min(($article->quantite_en_stock / 100) * 100, 100) }}%">
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Statut du stock</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $article->quantite_en_stock > 0 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' }}">
                                <i class="ti ti-{{ $article->quantite_en_stock > 0 ? 'check' : 'x' }} mr-1"></i>
                                {{ $article->quantite_en_stock > 0 ? 'En stock' : 'Rupture' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $article->quantite_en_stock }} unités disponibles
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 rounded-lg bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/10 dark:to-cyan-900/10 border border-blue-100 dark:border-blue-900/30">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock critique</p>
                            <p class="text-lg font-bold bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">
                                {{ $article->quantite_en_stock < 10 ? 'Oui' : 'Non' }}
                            </p>
                        </div>
                        <div class="text-center p-3 rounded-lg bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/10 dark:to-green-900/10 border border-emerald-100 dark:border-emerald-900/30">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Niveau de sécurité</p>
                            <p class="text-lg font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">
                                {{ $article->quantite_en_stock >= 50 ? 'Élevé' : ($article->quantite_en_stock >= 10 ? 'Moyen' : 'Faible') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Movement Button -->
            <div class="text-center">
                <button type="button" onclick="showStockMovementModal()"
                        class="w-full bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2">
                    <i class="ti ti-exchange"></i>
                    <span>Effectuer un mouvement de stock</span>
                </button>
            </div>
        </div>
    </div>

<!-- Stock Movements Header + Filter -->
<div class="flex items-center justify-between mb-4">
    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">
        Historique des mouvements de stock
    </h4>

    <form method="GET" class="flex items-center space-x-2">
        <label for="type_mouvement" class="text-sm text-gray-600 dark:text-gray-300">
            Filtrer par type :
        </label>

        <select id="type_mouvement"
                name="type_mouvement"
                class="border rounded-lg px-3 py-1 text-sm bg-white dark:bg-gray-800 dark:border-gray-700"
                onchange="this.form.submit()">
            <option value="" {{ request('type_mouvement') == '' ? 'selected' : '' }}>Tous les mouvements</option>
            <option value="ENTREE" {{ request('type_mouvement') == 'ENTREE' ? 'selected' : '' }}>Entrée</option>
            <option value="SORTIE" {{ request('type_mouvement') == 'SORTIE' ? 'selected' : '' }}>Sortie</option>
            <option value="AJUSTEMENT" {{ request('type_mouvement') == 'AJUSTEMENT' ? 'selected' : '' }}>Ajustement</option>
        </select>
    </form>
</div>

<!-- Stock Movements Table -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead>
            <tr class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                <th class="px-4 py-2 text-left">Date</th>
                <th class="px-4 py-2 text-left">Type</th>
                <th class="px-4 py-2 text-left">Quantité</th>
                <th class="px-4 py-2 text-left">Stock après</th>
                <th class="px-4 py-2 text-left">Raison</th>
                <th class="px-4 py-2 text-left">Utilisateur</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($article->histories as $history)
                <tr class="text-sm text-gray-600 dark:text-gray-300">
                    {{-- Date --}}
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($history->date_changement)->format('d/m/Y H:i') }}
                    </td>

                    {{-- Type de mouvement --}}
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            @if($history->type_mouvement === 'ENTREE')
                                bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200
                            @elseif($history->type_mouvement === 'SORTIE')
                                bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-200
                            @elseif($history->type_mouvement === 'AJUSTEMENT')
                                bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-200
                            @else
                                bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200
                            @endif
                        ">
                            {{ $history->type_mouvement }}
                        </span>
                    </td>

                    {{-- Quantité du mouvement --}}
                    <td class="px-4 py-2">
                        {{ $history->quantite }}
                    </td>

                    {{-- Stock après --}}
                    <td class="px-4 py-2">
                        {{ $history->stock_apres ?? '—' }}
                    </td>

                    {{-- Raison / description --}}
                    <td class="px-4 py-2">
                        {{ $history->description ?? '—' }}
                    </td>

                    {{-- Utilisateur --}}
                    <td class="px-4 py-2">
                        {{ $history->utilisateur ?? '—' }}
                    </td>
                </tr>
            @empty
                <tr class="text-sm text-gray-600 dark:text-gray-300">
                    <td colspan="6" class="px-4 py-8 text-center">
                        <div class="flex flex-col items-center justify-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                <i class="ti ti-archive text-gray-400"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">
                                    Aucun mouvement de stock enregistré
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    Les mouvements de stock apparaîtront ici
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


</div>

<!-- Stock Movement Modal -->
<div id="stockMovementModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4 animate-modal-in">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="ti ti-exchange text-cyan-500 mr-2"></i>
                    Nouveau mouvement de stock
                </h3>
                <button onclick="closeStockMovementModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="ti ti-x"></i>
                </button>
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
    /* Animations */
    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes modal-in {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .animate-slide-in {
        animation: slide-in 0.3s ease-out forwards;
    }
    
    .animate-modal-in {
        animation: modal-in 0.3s ease-out forwards;
    }
    
    /* Stock indicator colors */
    .stock-low {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    }
    
    .dark .stock-low {
        background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
    }
    
    .stock-medium {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    }
    
    .dark .stock-medium {
        background: linear-gradient(135deg, #78350f 0%, #92400e 100%);
    }
    
    .stock-high {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    }
    
    .dark .stock-high {
        background: linear-gradient(135deg, #064e3b 0%, #047857 100%);
    }
    
    /* Smooth transitions */
    * {
        transition: all 0.2s ease-in-out;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide notifications after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = ['notification', 'error-notification'];
        notifications.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                setTimeout(() => {
                    if (element) element.remove();
                }, 5000);
            }
        });
    });

    // Stock movement modal functions
    function showStockMovementModal() {
        const modal = document.getElementById('stockMovementModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeStockMovementModal() {
        const modal = document.getElementById('stockMovementModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('stockMovementModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeStockMovementModal();
                }
            });
        }
        
        // Escape key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeStockMovementModal();
            }
        });
    });

    // Share product functionality
    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $article->designation }}',
                text: 'Découvrez cet article : {{ $article->designation }}',
                url: window.location.href,
            })
            .then(() => console.log('Successful share'))
            .catch((error) => console.log('Error sharing:', error));
        } else {
            // Fallback: copy to clipboard
            navigator.clipboard.writeText(window.location.href)
                .then(() => {
                    alert('Lien copié dans le presse-papier !');
                })
                .catch(err => {
                    console.error('Failed to copy: ', err);
                });
        }
    }

    // Image hover effect
    document.addEventListener('DOMContentLoaded', function() {
        const imageContainer = document.querySelector('.group img');
        if (imageContainer) {
            const container = imageContainer.closest('.group');
            container.addEventListener('mouseenter', function() {
                const badge = this.querySelector('.absolute.bottom-4');
                if (badge) {
                    badge.classList.add('scale-110');
                }
            });
            
            container.addEventListener('mouseleave', function() {
                const badge = this.querySelector('.absolute.bottom-4');
                if (badge) {
                    badge.classList.remove('scale-110');
                }
            });
        }
    });
</script>
@endpush