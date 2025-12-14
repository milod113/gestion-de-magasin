@extends('layouts.app')

@section('title', 'Gestion des Catégories')
@section('subtitle', 'Liste complète des catégories d\'articles')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Enhanced Header -->
    <div class="mb-8">
        <div class="flex flex-col space-y-6">
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300 group">
                            <i class="ti ti-home mr-2 group-hover:scale-110 transition-transform"></i>
                            Tableau de bord
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="ti ti-chevron-right text-gray-400 mx-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Gestion des catégories</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Main Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-purple-500 via-indigo-500 to-blue-400 rounded-2xl blur opacity-25"></div>
                        <div class="relative bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 p-4 rounded-2xl shadow-lg">
                            <i class="ti ti-tags text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 bg-clip-text text-transparent">
                            Gestion des Catégories
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-2 animate-pulse"></span>
                            {{ $categories->total() }} catégories trouvées
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <i class="ti ti-calendar text-blue-400"></i>
                        <span>{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Header with Gradient -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50/30 via-indigo-50/20 to-blue-50/30 dark:from-purple-900/10 dark:via-indigo-900/10 dark:to-blue-900/10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-purple-500 to-indigo-400 flex items-center justify-center">
                        <i class="ti ti-list text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Liste des Catégories</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Gérez toutes les catégories d'articles</p>
                    </div>
                </div>
                
                <!-- Quick Search + Create -->
                <div class="flex items-center space-x-3 w-full md:w-auto">
                    <form method="GET" action="{{ route('categories.index') }}" class="relative w-full md:w-64">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher une catégorie..." 
                               class="pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                        <i class="ti ti-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-300"></i>
                    </form>
                    
                    <a href="{{ route('categories.create') }}" 
                       class="relative group overflow-hidden bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 hover:from-purple-700 hover:via-indigo-600 hover:to-blue-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 whitespace-nowrap">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-700 via-indigo-600 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-plus relative z-10"></i>
                        <span class="relative z-10 font-semibold">Nouvelle Catégorie</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Filter Section (Simplified for categories) -->
        <div class="px-6 py-4 bg-gradient-to-r from-purple-50/10 via-indigo-50/5 to-blue-50/10 dark:from-purple-900/5 dark:via-indigo-900/5 dark:to-blue-900/5 border-b border-gray-100 dark:border-gray-700">
            <form method="GET" action="{{ route('categories.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-search text-purple-400 mr-2 text-sm"></i>
                        Recherche
                    </label>
                    <input type="text" id="search" name="search" placeholder="Rechercher par désignation..."
                           value="{{ request('search') }}"
                           class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-sort-ascending text-indigo-400 mr-2 text-sm"></i>
                        Trier par
                    </label>
                    <select id="sort" name="sort"
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                        <option value="id_desc" {{ request('sort') == 'id_desc' ? 'selected' : '' }}>ID (Décroissant)</option>
                        <option value="id_asc" {{ request('sort') == 'id_asc' ? 'selected' : '' }}>ID (Croissant)</option>
                        <option value="designation_asc" {{ request('sort') == 'designation_asc' ? 'selected' : '' }}>Désignation (A-Z)</option>
                        <option value="designation_desc" {{ request('sort') == 'designation_desc' ? 'selected' : '' }}>Désignation (Z-A)</option>
                    </select>
                </div>

                <!-- Results per page -->
                <div>
                    <label for="per_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-list-numbers text-blue-400 mr-2 text-sm"></i>
                        Résultats par page
                    </label>
                    <select id="per_page" name="per_page"
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                
                <!-- Filter Buttons -->
                <div class="flex items-end space-x-2 md:col-span-2 lg:col-span-4">
                    <button type="submit" 
                            class="relative group overflow-hidden bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 hover:from-purple-700 hover:via-indigo-600 hover:to-blue-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-700 via-indigo-600 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-filter relative z-10"></i>
                        <span class="relative z-10 font-semibold">Appliquer les filtres</span>
                    </button>
                    
                    <a href="{{ route('categories.index') }}" 
                       class="relative group overflow-hidden bg-gradient-to-r from-gray-600 via-gray-500 to-gray-400 hover:from-gray-700 hover:via-gray-600 hover:to-gray-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-refresh relative z-10"></i>
                        <span class="relative z-10 font-semibold">Réinitialiser</span>
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-hash text-purple-400"></i>
                                <span>ID</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-tag text-indigo-400"></i>
                                <span>Désignation</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-calendar text-blue-400"></i>
                                <span>Date de création</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center justify-end space-x-1">
                                <i class="ti ti-settings text-gray-400"></i>
                                <span>Actions</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($categories as $categorie)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 flex items-center justify-center mr-3">
                                    <i class="ti ti-id text-purple-400"></i>
                                </div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-white font-mono">
                                    #{{ $categorie->id_categorie }}
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gradient-to-r from-indigo-100 to-blue-100 dark:from-indigo-900/30 dark:to-blue-900/30 flex items-center justify-center mr-3">
                                    <i class="ti ti-tag text-indigo-600 dark:text-indigo-300"></i>
                                </div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $categorie->designation }}
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ optional($categorie->created_at)->format('d/m/Y') ?? 'N/A' }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('categories.show', $categorie->id_categorie) }}" 
                                   class="relative group overflow-hidden w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-600 dark:text-blue-200 hover:text-white hover:from-blue-600 hover:to-cyan-500 transition-all duration-300"
                                   title="Voir détails">
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <i class="ti ti-eye relative z-10"></i>
                                </a>
                                
                                <a href="{{ route('categories.edit', $categorie) }}" 
                                   class="relative group overflow-hidden w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 text-yellow-600 dark:text-yellow-200 hover:text-white hover:from-yellow-600 hover:to-amber-500 transition-all duration-300"
                                   title="Modifier">
                                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <i class="ti ti-edit relative z-10"></i>
                                </a>
                                
                                <form action="{{ route('categories.destroy', $categorie) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')" 
                                            class="relative group overflow-hidden w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 text-red-600 dark:text-red-200 hover:text-white hover:from-red-600 hover:to-orange-500 transition-all duration-300"
                                            title="Supprimer">
                                        <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <i class="ti ti-trash relative z-10"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if($categories->count() === 0)
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                    <i class="ti ti-tag-off text-gray-400 text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune catégorie trouvée</h3>
                                    <p class="text-gray-500 dark:text-gray-400">Commencez par créer une nouvelle catégorie</p>
                                    <a href="{{ route('categories.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                                        <i class="ti ti-plus mr-2"></i>
                                        Créer une catégorie
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gradient-to-r from-purple-50/5 via-indigo-50/5 to-blue-50/5 dark:from-purple-900/5 dark:via-indigo-900/5 dark:to-blue-900/5">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                    <i class="ti ti-file-info mr-2 text-purple-400"></i>
                    Affichage de <span class="font-medium dark:text-white mx-1">{{ $categories->firstItem() }}</span> à <span class="font-medium dark:text-white mx-1">{{ $categories->lastItem() }}</span> sur <span class="font-medium dark:text-white mx-1">{{ $categories->total() }}</span> catégories
                </div>
                
                @php
                    $queryParams = request()->query();
                @endphp

                <div class="flex items-center space-x-1">
                    @if(!$categories->onFirstPage())
                        <a href="{{ $categories->appends($queryParams)->url(1) }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-500 hover:text-white hover:border-transparent transition-all duration-300" title="Première page">
                            <i class="ti ti-chevrons-left text-xs"></i>
                        </a>
                    @else
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-chevrons-left text-xs"></i>
                        </span>
                    @endif

                    @if($categories->onFirstPage())
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-chevron-left text-xs"></i>
                        </span>
                    @else
                        <a href="{{ $categories->appends($queryParams)->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-500 hover:text-white hover:border-transparent transition-all duration-300" title="Page précédente">
                            <i class="ti ti-chevron-left text-xs"></i>
                        </a>
                    @endif

                    <div class="flex space-x-1 mx-2">
                        @foreach($categories->getUrlRange(max(1, $categories->currentPage() - 2), min($categories->lastPage(), $categories->currentPage() + 2)) as $page => $url)
                            @if($page == $categories->currentPage())
                                <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 text-white text-sm font-medium shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}&{{ http_build_query($queryParams) }}"
                                   class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-500 hover:text-white hover:border-transparent transition-all duration-300">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    @if($categories->hasMorePages())
                        <a href="{{ $categories->appends($queryParams)->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-500 hover:text-white hover:border-transparent transition-all duration-300" title="Page suivante">
                            <i class="ti ti-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-chevron-right text-xs"></i>
                        </span>
                    @endif

                    @if($categories->currentPage() < $categories->lastPage())
                        <a href="{{ $categories->appends($queryParams)->url($categories->lastPage()) }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-500 hover:text-white hover:border-transparent transition-all duration-300" title="Dernière page">
                            <i class="ti ti-chevrons-right text-xs"></i>
                        </a>
                    @else
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-chevrons-right text-xs"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
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
    .hover-lift:hover { transform: translateY(-2px); transition: all 0.3s ease; }
    .gradient-text {
        background: linear-gradient(to right, #8b5cf6, #6366f1, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    * {
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
    .overflow-x-auto::-webkit-scrollbar { height: 6px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: linear-gradient(to right, #8b5cf6, #6366f1); border-radius: 10px; }
    .dark .overflow-x-auto::-webkit-scrollbar-track { background: #374151; }
    .dark .overflow-x-auto::-webkit-scrollbar-thumb { background: linear-gradient(to right, #7c3aed, #4f46e5); }
    tr:hover { background: linear-gradient(90deg, rgba(139, 92, 246, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%); }
    .dark tr:hover { background: linear-gradient(90deg, rgba(139, 92, 246, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%); }
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
</script>
@endpush