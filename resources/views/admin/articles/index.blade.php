@extends('layouts.app')

@section('title', 'Gestion des Articles')
@section('subtitle', 'Liste complète des articles en stock')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-colors duration-300 border border-gray-100 dark:border-gray-700">
    <!-- Header with Stats and Actions -->
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <!-- Icon with brand gradient -->
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur-lg opacity-30"></div>
                    <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-3 rounded-xl shadow-lg">
                        <i class="fas fa-boxes text-white text-xl"></i>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Articles</h2>
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total :</span>
                            <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">{{ $articles->total() }}</span>
                        </div>
                        <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                      
                        <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
  
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('articles.index') }}" 
                      class="flex flex-col md:flex-row items-stretch md:items-center gap-2">
                    
                    <!-- Search -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Rechercher un article..."
                                   class="pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent w-full md:w-64 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600">
                            <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 dark:text-gray-300"></i>
                        </div>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <select name="category_id"
                                class="relative pr-10 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent w-full md:w-56 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600 appearance-none">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id_categorie }}"
                                    {{ (string)request('category_id') === (string)$cat->id_categorie ? 'selected' : '' }}>
                                    {{ $cat->designation }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 dark:text-gray-300 pointer-events-none"></i>
                    </div>
                    
                    <!-- Stock Filter -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <select name="stock"
                                class="relative pr-10 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent w-full md:w-48 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600 appearance-none">
                            <option value="">Tous les stocks</option>
                            <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Stock faible</option>
                            <option value="medium" {{ request('stock') === 'medium' ? 'selected' : '' }}>Stock moyen</option>
                            <option value="high" {{ request('stock') === 'high' ? 'selected' : '' }}>Bon stock</option>
                            <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Rupture</option>
                        </select>
                        <i class="fas fa-filter absolute right-3 top-3.5 text-gray-400 dark:text-gray-300 pointer-events-none"></i>
                    </div>
                    
                    <!-- Filter Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="relative group overflow-hidden bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-600 hover:to-emerald-600 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="fas fa-filter relative z-10"></i>
                            <span class="relative z-10 font-semibold">Filtrer</span>
                        </button>
                        
                        <a href="{{ route('articles.index') }}"
                           class="relative group px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-800 transition-all duration-300 flex items-center space-x-2">
                            <i class="fas fa-redo"></i>
                            <span>Réinitialiser</span>
                        </a>
                    </div>
                </form>
                
                <!-- New Article Button -->
                <a href="{{ route('articles.create') }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-plus-circle relative z-10 text-lg"></i>
                    <span class="relative z-10 font-semibold">Article</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-blue-50/50 via-cyan-50/30 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
                <tr>
                    @foreach(['Référence', 'Désignation', 'Stock', 'Unité', 'Prix', 'Catégorie'] as $column)
                        <th scope="col" class="px-6 py-4 text-left">
                            <button class="flex items-center space-x-2 group">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ $column }}</span>
                                @if(in_array($column, ['Référence', 'Stock', 'Prix']))
                                <div class="p-1 rounded group-hover:bg-gray-100 dark:group-hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-sort text-gray-400 group-hover:text-cyan-500 transition-colors"></i>
                                </div>
                                @endif
                            </button>
                        </th>
                    @endforeach
                    <th scope="col" class="px-6 py-4 text-right">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</span>
                    </th>
                </tr>
            </thead>
            
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($articles as $article)
                <tr class="hover:bg-gradient-to-r hover:from-blue-50/20 hover:via-cyan-50/10 hover:to-emerald-50/20 dark:hover:from-blue-900/5 dark:hover:via-cyan-900/5 dark:hover:to-emerald-900/5 transition-all duration-200 group">
                    
                    <!-- Référence -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                            <div class="text-sm font-bold text-gray-900 dark:text-white font-mono">
                                {{ $article->ref_article }}
                            </div>
                        </div>
                    </td>
                    
                    <!-- Désignation -->
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $article->designation }}
                        </div>
                        @if($article->description)
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate max-w-xs">
                                {{ Str::limit($article->description, 50) }}
                            </div>
                        @endif
                    </td>
                    
                    <!-- Stock -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $article->quantite_en_stock }}
                            </div>
                            @if($article->quantite_en_stock < 10)
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Faible
                                </span>
                            @elseif($article->quantite_en_stock < 50)
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-200 border border-amber-200 dark:border-amber-800">
                                    <i class="fas fa-info-circle mr-1"></i> Moyen
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-800">
                                    <i class="fas fa-check-circle mr-1"></i> Bon
                                </span>
                            @endif
                        </div>
                        @if($article->quantite_en_stock == 0)
                        <div class="text-xs text-red-600 dark:text-red-400 font-medium mt-1">
                            Rupture de stock
                        </div>
                        @endif
                    </td>
                    
                    <!-- Unité -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-800 dark:text-white shadow-sm">
                            <i class="fas fa-weight mr-1"></i>{{ $article->unité }}
                        </span>
                    </td>
                    
                    <!-- Prix -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <div class="text-lg font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">
                                {{ number_format($article->prix, 2) }}
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">DZD</span>
                        </div>
                        @if($article->quantite_en_stock > 0)
                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                            Valeur: {{ number_format($article->prix * $article->quantite_en_stock, 2) }} DH
                        </div>
                        @endif
                    </td>
                    
                    <!-- Catégorie -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($article->categorie)
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                                    <i class="fas fa-folder text-blue-400 text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $article->categorie->designation }}
                                </span>
                            </div>
                        @else
                            <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-500 dark:text-gray-400">
                                <i class="fas fa-times-circle mr-1"></i> Non catégorisé
                            </span>
                        @endif
                    </td>
                    
                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-end space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <!-- View Button -->
                            <a href="{{ route('articles.show', $article->id_article) }}" 
                               class="relative group/view p-2 rounded-lg bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 hover:from-blue-100 hover:to-cyan-100 dark:hover:from-blue-800/30 dark:hover:to-cyan-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-lg blur opacity-0 group-hover/view:opacity-20 transition-opacity duration-300"></div>
                                <i class="fas fa-eye text-blue-600 dark:text-blue-400 relative z-10"></i>
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 dark:bg-gray-900 text-white text-xs rounded opacity-0 group-hover/view:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                    Voir détails
                                </div>
                            </a>
                            
                            <!-- Edit Button -->
                            <a href="{{ route('articles.edit', $article) }}" 
                               class="relative group/edit p-2 rounded-lg bg-gradient-to-r from-cyan-50 to-emerald-50 dark:from-cyan-900/20 dark:to-emerald-900/20 hover:from-cyan-100 hover:to-emerald-100 dark:hover:from-cyan-800/30 dark:hover:to-emerald-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-lg blur opacity-0 group-hover/edit:opacity-20 transition-opacity duration-300"></div>
                                <i class="fas fa-pencil-alt text-cyan-600 dark:text-cyan-400 relative z-10"></i>
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 dark:bg-gray-900 text-white text-xs rounded opacity-0 group-hover/edit:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                    Modifier
                                </div>
                            </a>
                            
                            <!-- Stock Movement Button -->
                            <button type="button"
                                    onclick="showStockMovement('{{ $article->id_article }}', '{{ $article->designation }}')"
                                    class="relative group/move p-2 rounded-lg bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 hover:from-emerald-100 hover:to-green-100 dark:hover:from-emerald-800/30 dark:hover:to-green-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-green-400 rounded-lg blur opacity-0 group-hover/move:opacity-20 transition-opacity duration-300"></div>
                                <i class="fas fa-exchange-alt text-emerald-600 dark:text-emerald-400 relative z-10"></i>
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 dark:bg-gray-900 text-white text-xs rounded opacity-0 group-hover/move:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                    Mouvement
                                </div>
                            </button>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')"
                                        class="relative group/delete p-2 rounded-lg bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 hover:from-red-100 hover:to-orange-100 dark:hover:from-red-800/30 dark:hover:to-orange-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-orange-400 rounded-lg blur opacity-0 group-hover/delete:opacity-20 transition-opacity duration-300"></div>
                                    <i class="fas fa-trash text-red-600 dark:text-red-400 relative z-10"></i>
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 dark:bg-gray-900 text-white text-xs rounded opacity-0 group-hover/delete:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                        Supprimer
                                    </div>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center">
                                <i class="fas fa-boxes text-2xl text-blue-500"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aucun article trouvé</h3>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">Commencez par créer votre premier article</p>
                            </div>
                            <a href="{{ route('articles.create') }}" 
                               class="mt-4 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                <i class="fas fa-plus-circle"></i>
                                <span>Créer un article</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($articles->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-medium dark:text-white">{{ $articles->firstItem() }}</span>
                -
                <span class="font-medium dark:text-white">{{ $articles->lastItem() }}</span>
                sur
                <span class="font-medium dark:text-white">{{ $articles->total() }}</span>
                articles
            </div>
            
            <div class="flex items-center space-x-2">
                <!-- Previous Page -->
                @if($articles->onFirstPage())
                <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 text-gray-400 cursor-not-allowed bg-gray-50 dark:bg-gray-800">
                    <i class="fas fa-chevron-left"></i>
                </button>
                @else
                <a href="{{ $articles->previousPageUrl() }}" 
                   class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-cyan-300 dark:hover:border-cyan-600 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <i class="fas fa-chevron-left text-gray-600 dark:text-gray-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 relative z-10"></i>
                </a>
                @endif
                
                <!-- Page Numbers -->
                @foreach($articles->getUrlRange(max(1, $articles->currentPage() - 2), min($articles->lastPage(), $articles->currentPage() + 2)) as $page => $url)
                    @if($page == $articles->currentPage())
                    <span class="relative w-9 h-9 flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 text-white font-medium shadow-lg">
                        {{ $page }}
                    </span>
                    @else
                    <a href="{{ $url }}" 
                       class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-cyan-300 dark:hover:border-cyan-600 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <span class="text-gray-700 dark:text-gray-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 font-medium relative z-10">{{ $page }}</span>
                    </a>
                    @endif
                @endforeach
                
                <!-- Next Page -->
                @if($articles->hasMorePages())
                <a href="{{ $articles->nextPageUrl() }}" 
                   class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-cyan-300 dark:hover:border-cyan-600 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <i class="fas fa-chevron-right text-gray-600 dark:text-gray-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 relative z-10"></i>
                </a>
                @else
                <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 text-gray-400 cursor-not-allowed bg-gray-50 dark:bg-gray-800">
                    <i class="fas fa-chevron-right"></i>
                </button>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Stock Movement Modal (Hidden by default) -->
<div id="stockMovementModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-exchange-alt text-cyan-500 mr-2"></i>
                    Mouvement de stock
                </h3>
                <button onclick="closeStockMovementModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="stockMovementForm" method="POST" action="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Article
                        </label>
                        <input type="text" id="articleName" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400" readonly>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Type
                            </label>
                            <select name="type" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                                <option value="entree">Entrée</option>
                                <option value="sortie">Sortie</option>
                                <option value="ajustement">Ajustement</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Quantité
                            </label>
                            <input type="number" name="quantity" min="1" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Motif
                        </label>
                        <textarea name="reason" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent" placeholder="Raison du mouvement..."></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" onclick="closeStockMovementModal()" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white rounded-lg font-medium hover:shadow-lg transition-shadow">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div id="notification" class="fixed top-4 right-4 z-50 animate-slide-in">
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border border-green-200 dark:border-green-800 rounded-xl shadow-lg p-4 max-w-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center">
                <i class="fas fa-check text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('notification').remove()" class="text-green-400 hover:text-green-600 dark:hover:text-green-300">
                <i class="fas fa-times"></i>
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
                <i class="fas fa-exclamation text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
            <button onclick="document.getElementById('error-notification').remove()" class="text-red-400 hover:text-red-600 dark:hover:text-red-300">
                <i class="fas fa-times"></i>
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
    
    .animate-slide-in {
        animation: slide-in 0.3s ease-out forwards;
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
    
    /* Modal animation */
    @keyframes modal-fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Smooth transitions for all interactive elements */
    select, input, button, a {
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

    // Quick search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        const rows = document.querySelectorAll('tbody tr');
        
        if (searchInput && rows.length > 0) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                
                rows.forEach(row => {
                    if (row.querySelector('td[colspan]')) return; // Skip empty state row
                    
                    const cells = row.querySelectorAll('td');
                    let found = false;
                    
                    cells.forEach((cell, index) => {
                        if (index < 6 && cell.textContent.toLowerCase().includes(searchTerm)) {
                            found = true;
                        }
                    });
                    
                    if (found) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });

    // Stock level color coding
    document.addEventListener('DOMContentLoaded', function() {
        const stockCells = document.querySelectorAll('td:nth-child(3)');
        
        stockCells.forEach(cell => {
            const stockText = cell.querySelector('.text-lg')?.textContent;
            if (stockText) {
                const stockValue = parseInt(stockText);
                const badge = cell.querySelector('.rounded-full');
                
                if (badge) {
                    if (stockValue === 0) {
                        badge.classList.add('stock-out');
                    } else if (stockValue < 10) {
                        badge.classList.add('stock-low');
                    } else if (stockValue < 50) {
                        badge.classList.add('stock-medium');
                    } else {
                        badge.classList.add('stock-high');
                    }
                }
            }
        });
    });

    // Stock movement modal functions
    function showStockMovement(articleId, articleName) {
        const modal = document.getElementById('stockMovementModal');
        const form = document.getElementById('stockMovementForm');
        const articleNameInput = document.getElementById('articleName');
        
        // Set form action and article name
        form.action = `/articles/${articleId}/stock-movement`;
        articleNameInput.value = articleName;
        
        // Show modal
        modal.classList.remove('hidden');
        modal.style.animation = 'modal-fade-in 0.3s ease-out forwards';
    }

    function closeStockMovementModal() {
        const modal = document.getElementById('stockMovementModal');
        modal.classList.add('hidden');
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
    });

    // Tooltip persistence for action buttons
    document.addEventListener('DOMContentLoaded', function() {
        const actionButtons = document.querySelectorAll('.group\\/view, .group\\/edit, .group\\/move, .group\\/delete');
        
        actionButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                const tooltip = this.querySelector('.absolute');
                if (tooltip) {
                    tooltip.classList.remove('opacity-0');
                    tooltip.classList.add('opacity-100');
                }
            });
            
            button.addEventListener('mouseleave', function() {
                const tooltip = this.querySelector('.absolute');
                if (tooltip) {
                    tooltip.classList.remove('opacity-100');
                    tooltip.classList.add('opacity-0');
                }
            });
        });
    });

    // Export functionality
    function exportArticles(format) {
        const form = document.querySelector('form[method="GET"]');
        const exportForm = document.createElement('form');
        exportForm.method = 'GET';
        exportForm.action = '{{ route("articles.export") }}';
        
        // Clone search parameters
        const inputs = form.querySelectorAll('input[name], select[name]');
        inputs.forEach(input => {
            const clone = input.cloneNode();
            if (input.type !== 'submit' && input.name) {
                clone.value = input.value;
                exportForm.appendChild(clone);
            }
        });
        
        // Add export format
        const formatInput = document.createElement('input');
        formatInput.type = 'hidden';
        formatInput.name = 'format';
        formatInput.value = format;
        exportForm.appendChild(formatInput);
        
        document.body.appendChild(exportForm);
        exportForm.submit();
        document.body.removeChild(exportForm);
    }
</script>
@endpush