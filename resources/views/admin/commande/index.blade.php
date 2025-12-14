@extends('layouts.app')

@section('title', 'Gestion des Commandes')
@section('subtitle', 'Liste complète des commandes')

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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Gestion des commandes</span>
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
                            <i class="ti ti-shopping-cart text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 bg-clip-text text-transparent">
                            Gestion des Commandes
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            {{ $commandes->total() }} commandes trouvées
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <i class="ti ti-calendar text-blue-400"></i>
                        <span>{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <i class="ti ti-chart-bar text-cyan-400"></i>
                        <span>{{ $commandes->count() }} sur {{ $commandes->total() }}</span>
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
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Liste des Commandes</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Gérez toutes les commandes de matériel</p>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="Rechercher..." 
                               class="pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full md:w-64 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                        <i class="ti ti-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-300"></i>
                    </div>
                    
                    <a href="{{ route('commandes.create') }}" 
                       class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-plus relative z-10"></i>
                        <span class="relative z-10 font-semibold">Nouvelle Commande</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50/10 via-cyan-50/5 to-emerald-50/10 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 border-b border-gray-100 dark:border-gray-700">
            <form method="GET" action="{{ route('commandes.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Reference search -->
                <div>
                    <label for="ref_commande" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-hash text-blue-400 mr-2 text-sm"></i>
                        Référence
                    </label>
                    <input type="text" id="ref_commande" name="ref_commande" placeholder="Référence commande"
                           value="{{ request('ref_commande') }}"
                           class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                
                <!-- Date search -->
                <div>
                    <label for="date_commande" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-calendar text-blue-400 mr-2 text-sm"></i>
                        Date spécifique
                    </label>
                    <input type="date" id="date_commande" name="date_commande" value="{{ request('date_commande') }}"
                           class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                </div>
                
                <!-- Month filter -->
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-calendar-month text-cyan-400 mr-2 text-sm"></i>
                        Mois
                    </label>
                    <select id="month" name="month" 
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="">Tous les mois</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->locale('fr')->monthName }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <!-- Year filter -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-calendar-year text-emerald-400 mr-2 text-sm"></i>
                        Année
                    </label>
                    <select id="year" name="year" 
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="">Toutes les années</option>
                        @for ($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
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
                    
                    <a href="{{ route('commandes.index') }}" 
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
                                <span>Référence</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-calendar text-cyan-400"></i>
                                <span>Date</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-building text-blue-400"></i>
                                <span>Service</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-category text-emerald-400"></i>
                                <span>Type</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-user text-purple-400"></i>
                                <span>Bénéficiaire</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="ti ti-circle-check text-green-400"></i>
                                <span>État</span>
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
                    @foreach($commandes as $commande)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center mr-3">
                                    <i class="ti ti-file-invoice text-blue-400"></i>
                                </div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">#{{ $commande->ref_commande }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-md bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center mr-2">
                                    <i class="ti ti-building-hospital text-gray-600 dark:text-gray-300 text-xs"></i>
                                </div>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $commande->service->service_fr ?? 'N/A' }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1.5 text-xs font-medium rounded-full 
                                {{ $commande->type_bon_commande === 'normal' 
                                    ? 'bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800' 
                                    : 'bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-200 border border-amber-200 dark:border-amber-800' }}">
                                <i class="ti ti-{{ $commande->type_bon_commande === 'normal' ? 'file-text' : 'file-alert' }} mr-1"></i>
                                {{ $commande->type_bon_commande === 'normal' ? 'Normal' : 'Décharge' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white">
                                @if($commande->beneficiare)
                                    <div class="flex items-center">
                                        <i class="ti ti-user-circle text-gray-400 mr-2 text-sm"></i>
                                        {{ $commande->beneficiare }}
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($commande->etat_commande == 0)
                                <span class="px-3 py-1.5 text-xs font-medium rounded-full 
                                    bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 flex items-center">
                                    <i class="ti ti-clock mr-1.5"></i>
                                    En attente
                                </span>
                            @elseif($commande->etat_commande == 1)
                                <span class="px-3 py-1.5 text-xs font-medium rounded-full 
                                    bg-gradient-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 text-yellow-800 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-800 flex items-center">
                                    <i class="ti ti-circle-check mr-1.5"></i>
                                    Validée
                                </span>
                            @elseif($commande->etat_commande == 2)
                                <span class="px-3 py-1.5 text-xs font-medium rounded-full 
                                    bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800 flex items-center">
                                    <i class="ti ti-truck-delivery mr-1.5"></i>
                                    Livrée
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- View Button -->
                                @if($commande->etat_commande == 2)
                                    <a href="{{ route('livraisons.show', $commande->ref_commande) }}" 
                                       class="relative group overflow-hidden w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-600 dark:text-blue-200 hover:text-white hover:from-blue-600 hover:to-cyan-500 transition-all duration-300"
                                       title="Voir Livraison">
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <i class="ti ti-eye relative z-10"></i>
                                    </a>
                                @elseif($commande->etat_commande == 1)
                                    <a href="{{ route('commandes.show', $commande) }}" 
                                       class="relative group overflow-hidden w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-600 dark:text-blue-200 hover:text-white hover:from-blue-600 hover:to-cyan-500 transition-all duration-300"
                                       title="Voir Commande">
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <i class="ti ti-eye relative z-10"></i>
                                    </a>
                                @endif
                                
                                <!-- Edit Button -->
                                <a href="{{ route('commandes.edit', $commande) }}" 
                                   class="relative group overflow-hidden w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 text-yellow-600 dark:text-yellow-200 hover:text-white hover:from-yellow-600 hover:to-amber-500 transition-all duration-300"
                                   title="Modifier">
                                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <i class="ti ti-edit relative z-10"></i>
                                </a>

                                <!-- Delivery Button -->
                                @if($commande->etat_commande == 1)
                                    <a href="{{ route('livraisons.create', ['commande_ref' => $commande->ref_commande]) }}" 
                                       class="relative group overflow-hidden w-8 h-8 flex items-center justify-center rounded-lg bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-600 dark:text-green-200 hover:text-white hover:from-green-600 hover:to-emerald-500 transition-all duration-300"
                                       title="Créer Livraison">
                                        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <i class="ti ti-truck relative z-10"></i>
                                    </a>
                                @endif
                                
                                <!-- Delete Button -->
                                <form action="{{ route('commandes.destroy', $commande) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')" 
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
                    
                    <!-- Empty State -->
                    @if($commandes->count() === 0)
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                    <i class="ti ti-shopping-cart-off text-gray-400 text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune commande trouvée</h3>
                                    <p class="text-gray-500 dark:text-gray-400">Commencez par créer une nouvelle commande</p>
                                    <a href="{{ route('commandes.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                                        <i class="ti ti-plus mr-2"></i>
                                        Créer une commande
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
        @if($commandes->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50/5 via-cyan-50/5 to-emerald-50/5 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                    <i class="ti ti-file-info mr-2 text-blue-400"></i>
                    Affichage de <span class="font-medium dark:text-white mx-1">{{ $commandes->firstItem() }}</span> à <span class="font-medium dark:text-white mx-1">{{ $commandes->lastItem() }}</span> sur <span class="font-medium dark:text-white mx-1">{{ $commandes->total() }}</span> commandes
                </div>
                
                <div class="flex items-center space-x-1">
                    <!-- First Page -->
                    @if(!$commandes->onFirstPage())
                        <a href="{{ $commandes->url(1) }}" 
                           class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-500 hover:text-white hover:border-transparent transition-all duration-300"
                           title="Première page">
                            <i class="ti ti-chevrons-left text-xs"></i>
                        </a>
                    @else
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-chevrons-left text-xs"></i>
                        </span>
                    @endif

                    <!-- Previous Page -->
                    @if($commandes->onFirstPage())
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-chevron-left text-xs"></i>
                        </span>
                    @else
                        <a href="{{ $commandes->previousPageUrl() }}" 
                           class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-500 hover:text-white hover:border-transparent transition-all duration-300"
                           title="Page précédente">
                            <i class="ti ti-chevron-left text-xs"></i>
                        </a>
                    @endif

                    <!-- Page Numbers -->
                    <div class="flex space-x-1 mx-2">
                        @foreach($commandes->getUrlRange(max(1, $commandes->currentPage() - 2), min($commandes->lastPage(), $commandes->currentPage() + 2)) as $page => $url)
                            @if($page == $commandes->currentPage())
                                <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 text-white text-sm font-medium shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" 
                                   class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-500 hover:text-white hover:border-transparent transition-all duration-300">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    <!-- Next Page -->
                    @if($commandes->hasMorePages())
                        <a href="{{ $commandes->nextPageUrl() }}" 
                           class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-500 hover:text-white hover:border-transparent transition-all duration-300"
                           title="Page suivante">
                            <i class="ti ti-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-chevron-right text-xs"></i>
                        </span>
                    @endif

                    <!-- Last Page -->
                    @if($commandes->currentPage() < $commandes->lastPage())
                        <a href="{{ $commandes->url($commandes->lastPage()) }}" 
                           class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-500 hover:text-white hover:border-transparent transition-all duration-300"
                           title="Dernière page">
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
@endsection

@push('styles')
<style>
    /* Enhanced hover effects */
    .hover-lift:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    /* Gradient text utility */
    .gradient-text {
        background: linear-gradient(to right, #3b82f6, #06b6d4, #10b981);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Smooth transitions */
    * {
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
    
    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(to right, #3b82f6, #06b6d4);
        border-radius: 10px;
    }
    
    .dark .overflow-x-auto::-webkit-scrollbar-track {
        background: #374151;
    }
    
    .dark .overflow-x-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(to right, #1d4ed8, #0891b2);
    }
    
    /* Table row highlight */
    tr:hover {
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.05) 0%, rgba(6, 182, 212, 0.05) 100%);
    }
    
    .dark tr:hover {
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
    }
</style>
@endpush