@extends('layouts.app')

@section('title', 'Gestion des Services')
@section('subtitle', 'Liste complète des services')

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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Gestion des services</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Main Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 rounded-2xl blur opacity-25"></div>
                        <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-4 rounded-2xl shadow-lg">
                            <i class="ti ti-layers text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 bg-clip-text text-transparent">
                            Gestion des Services
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            {{ $services->total() }} services trouvés
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
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="ti ti-list text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Liste des Services</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Gérez tous les services de votre organisation</p>
                    </div>
                </div>
                
                <!-- Quick Search + Create -->
                <div class="flex items-center space-x-3 w-full md:w-auto">
                    <form method="GET" action="{{ route('services.index') }}" class="relative w-full md:w-64">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." 
                               class="pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                        <i class="ti ti-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-300"></i>

                        {{-- keep other filters when quick searching --}}
                        <input type="hidden" name="code" value="{{ request('code') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                    </form>
                    
                    <a href="{{ route('services.create') }}" 
                       class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 whitespace-nowrap">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-plus relative z-10"></i>
                        <span class="relative z-10 font-semibold">Nouveau Service</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50/10 via-cyan-50/5 to-emerald-50/10 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 border-b border-gray-100 dark:border-gray-700">
            <form method="GET" action="{{ route('services.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                {{-- Code Search --}}
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-hash text-blue-400 mr-2 text-sm"></i>
                        Code
                    </label>
                    <input type="text" id="code" name="code" placeholder="Rechercher par code..."
                           value="{{ request('code') }}"
                           class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>

                {{-- French Name Search --}}
                <div>
                    <label for="service_fr" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-abc text-cyan-400 mr-2 text-sm"></i>
                        Nom (Français)
                    </label>
                    <input type="text" id="service_fr" name="service_fr" placeholder="Rechercher en français..."
                           value="{{ request('service_fr') }}"
                           class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>

                {{-- Arabic Name Search --}}
                <div>
                    <label for="service_arab" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-language-arabic text-emerald-400 mr-2 text-sm"></i>
                        Nom (Arabe)
                    </label>
                    <input type="text" id="service_arab" name="service_arab" placeholder="Rechercher en arabe..."
                           value="{{ request('service_arab') }}"
                           class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>

                {{-- Sort Order --}}
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-sort-ascending text-blue-400 mr-2 text-sm"></i>
                        Trier par
                    </label>
                    <select id="sort" name="sort"
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="code_asc" {{ request('sort') == 'code_asc' ? 'selected' : '' }}>Code (A-Z)</option>
                        <option value="code_desc" {{ request('sort') == 'code_desc' ? 'selected' : '' }}>Code (Z-A)</option>
                        <option value="service_fr_asc" {{ request('sort') == 'service_fr_asc' ? 'selected' : '' }}>Nom FR (A-Z)</option>
                        <option value="service_fr_desc" {{ request('sort') == 'service_fr_desc' ? 'selected' : '' }}>Nom FR (Z-A)</option>
                        <option value="service_arab_asc" {{ request('sort') == 'service_arab_asc' ? 'selected' : '' }}>Nom AR (A-Z)</option>
                        <option value="service_arab_desc" {{ request('sort') == 'service_arab_desc' ? 'selected' : '' }}>Nom AR (Z-A)</option>
                        <option value="created_at_desc" {{ request('sort') == 'created_at_desc' || !request('sort') ? 'selected' : '' }}>Plus récent</option>
                        <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Plus ancien</option>
                    </select>
                </div>

                {{-- Results per page --}}
                <div>
                    <label for="per_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-list-numbers text-cyan-400 mr-2 text-sm"></i>
                        Résultats par page
                    </label>
                    <select id="per_page" name="per_page"
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                
                <!-- Filter Buttons -->
                <div class="flex items-end space-x-2 md:col-span-2 lg:col-span-4">
                    <button type="submit" 
                            class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-filter relative z-10"></i>
                        <span class="relative z-10 font-semibold">Appliquer les filtres</span>
                    </button>
                    
                    <a href="{{ route('services.index') }}" 
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
                <thead class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-hash text-blue-400"></i>
                                <span>Code</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-flag text-cyan-400"></i>
                                <span>Nom (Français)</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-language-arabic text-emerald-400"></i>
                                <span>Nom (Arabe)</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-calendar text-blue-400"></i>
                                <span>Créé le</span>
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
                    @foreach($services as $service)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center mr-3">
                                    <i class="ti ti-hash text-blue-400"></i>
                                </div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-white font-mono">
                                    {{ $service->code_service }}
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white font-medium">
                                {{ $service->service_fr }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white font-medium" dir="rtl">
                                {{ $service->service_arab }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ optional($service->created_at)->format('d/m/Y') ?? 'N/A' }}
                            </div>
                            @if($service->created_at)
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ optional($service->created_at)->format('H:i') }}
                            </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('services.show', $service) }}" 
                                   class="relative group overflow-hidden w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-600 dark:text-blue-200 hover:text-white hover:from-blue-600 hover:to-cyan-500 transition-all duration-300"
                                   title="Voir détails">
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <i class="ti ti-eye relative z-10"></i>
                                </a>
                                
                                <a href="{{ route('services.edit', $service) }}" 
                                   class="relative group overflow-hidden w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 text-yellow-600 dark:text-yellow-200 hover:text-white hover:from-yellow-600 hover:to-amber-500 transition-all duration-300"
                                   title="Modifier">
                                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <i class="ti ti-edit relative z-10"></i>
                                </a>
                                
                                <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')" 
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
                    
                    @if($services->count() === 0)
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                    <i class="ti ti-layers-off text-gray-400 text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucun service trouvé</h3>
                                    <p class="text-gray-500 dark:text-gray-400">Essayez de modifier vos critères de recherche</p>
                                    <a href="{{ route('services.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                                        <i class="ti ti-plus mr-2"></i>
                                        Créer un service
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
        @if($services->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50/5 via-cyan-50/5 to-emerald-50/5 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                    <i class="ti ti-file-info mr-2 text-blue-400"></i>
                    Affichage de <span class="font-medium dark:text-white mx-1">{{ $services->firstItem() }}</span> à <span class="font-medium dark:text-white mx-1">{{ $services->lastItem() }}</span> sur <span class="font-medium dark:text-white mx-1">{{ $services->total() }}</span> services
                </div>
                
                @php
                    $queryParams = request()->query();
                @endphp

                <div class="flex items-center space-x-1">
                    @if(!$services->onFirstPage())
                        <a href="{{ $services->appends($queryParams)->url(1) }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-500 hover:text-white hover:border-transparent transition-all duration-300" title="Première page">
                            <i class="ti ti-chevrons-left text-xs"></i>
                        </a>
                    @else
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-chevrons-left text-xs"></i>
                        </span>
                    @endif

                    @if($services->onFirstPage())
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-chevron-left text-xs"></i>
                        </span>
                    @else
                        <a href="{{ $services->appends($queryParams)->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-500 hover:text-white hover:border-transparent transition-all duration-300" title="Page précédente">
                            <i class="ti ti-chevron-left text-xs"></i>
                        </a>
                    @endif

                    <div class="flex space-x-1 mx-2">
                        @foreach($services->getUrlRange(max(1, $services->currentPage() - 2), min($services->lastPage(), $services->currentPage() + 2)) as $page => $url)
                            @if($page == $services->currentPage())
                                <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 text-white text-sm font-medium shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}&{{ http_build_query($queryParams) }}"
                                   class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-500 hover:text-white hover:border-transparent transition-all duration-300">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    @if($services->hasMorePages())
                        <a href="{{ $services->appends($queryParams)->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-500 hover:text-white hover:border-transparent transition-all duration-300" title="Page suivante">
                            <i class="ti ti-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-chevron-right text-xs"></i>
                        </span>
                    @endif

                    @if($services->currentPage() < $services->lastPage())
                        <a href="{{ $services->appends($queryParams)->url($services->lastPage()) }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-500 hover:text-white hover:border-transparent transition-all duration-300" title="Dernière page">
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
        background: linear-gradient(to right, #3b82f6, #06b6d4, #10b981);
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
    .overflow-x-auto::-webkit-scrollbar-thumb { background: linear-gradient(to right, #3b82f6, #06b6d4); border-radius: 10px; }
    .dark .overflow-x-auto::-webkit-scrollbar-track { background: #374151; }
    .dark .overflow-x-auto::-webkit-scrollbar-thumb { background: linear-gradient(to right, #1d4ed8, #0891b2); }
    tr:hover { background: linear-gradient(90deg, rgba(59, 130, 246, 0.05) 0%, rgba(6, 182, 212, 0.05) 100%); }
    .dark tr:hover { background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%); }
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

// Live search functionality for services
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                // Submit the form on search input
                const form = this.closest('form');
                if (form) {
                    form.submit();
                }
            }, 500);
        });
    }
});
</script>
@endpush