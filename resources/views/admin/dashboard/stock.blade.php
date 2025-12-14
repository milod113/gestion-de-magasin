@extends('layouts.app')

@section('title', 'Tableau de bord Stock')
@section('subtitle', 'Vue globale sur le stock, les entrées et sorties')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl space-y-8">

    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-5 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur opacity-30"></div>
                        <div class="relative bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 p-3 rounded-xl shadow-lg">
                            <i class="ti ti-package text-white text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Tableau de bord Stock</h1>
                        <p class="text-blue-100 text-sm mt-1">Vue globale sur le stock, les entrées et sorties</p>
                    </div>
                </div>
                <div class="hidden sm:flex items-center space-x-2 text-sm text-blue-100">
                    <i class="ti ti-calendar"></i>
                    <span>{{ now()->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total Articles -->
        <div class="bg-gradient-to-br from-white to-blue-50/50 dark:from-gray-800 dark:to-blue-900/10 rounded-xl border border-blue-100 dark:border-blue-900/30 p-5 shadow-lg hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ti ti-packages text-white text-sm"></i>
                </div>
                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-cyan-200">
                    Total
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Articles</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalArticles }}</p>
            <div class="mt-2 h-1 w-full bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full"></div>
        </div>

        <!-- Total Stock -->
        <div class="bg-gradient-to-br from-white to-cyan-50/50 dark:from-gray-800 dark:to-cyan-900/10 rounded-xl border border-cyan-100 dark:border-cyan-900/30 p-5 shadow-lg hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-cyan-500 to-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ti ti-archive text-white text-sm"></i>
                </div>
                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-gradient-to-r from-cyan-100 to-emerald-100 dark:from-cyan-900/30 dark:to-emerald-900/30 text-cyan-800 dark:text-emerald-200">
                    Unités
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Stock total</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalStock,0,',',' ') }}</p>
            <div class="mt-2 h-1 w-full bg-gradient-to-r from-cyan-500 to-emerald-400 rounded-full"></div>
        </div>

        <!-- Stock Value -->
        <div class="bg-gradient-to-br from-white to-emerald-50/50 dark:from-gray-800 dark:to-emerald-900/10 rounded-xl border border-emerald-100 dark:border-emerald-900/30 p-5 shadow-lg hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-emerald-500 to-green-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ti ti-currency-dinar text-white text-sm"></i>
                </div>
                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 text-emerald-800 dark:text-emerald-200">
                    Valeur
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Valeur stock</p>
            <p class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">
                {{ number_format($stockValue ?? 0, 2, ',', ' ') }} DA
            </p>
            <div class="mt-2 h-1 w-full bg-gradient-to-r from-emerald-500 to-green-400 rounded-full"></div>
        </div>

        <!-- Low Stock -->
        <div class="bg-gradient-to-br from-white to-amber-50/50 dark:from-gray-800 dark:to-amber-900/10 rounded-xl border border-amber-100 dark:border-amber-900/30 p-5 shadow-lg hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-amber-500 to-yellow-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ti ti-alert-triangle text-white text-sm"></i>
                </div>
                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-200">
                    <i class="ti ti-arrow-down-right text-xs mr-1"></i>Faible
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Stock faible (&lt;10)</p>
            <p class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $lowStockCount }}</p>
            <div class="mt-2 h-1 w-full bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full"></div>
        </div>

        <!-- Out of Stock -->
        <div class="bg-gradient-to-br from-white to-red-50/50 dark:from-gray-800 dark:to-red-900/10 rounded-xl border border-red-100 dark:border-red-900/30 p-5 shadow-lg hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-red-500 to-orange-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="ti ti-x text-white text-sm"></i>
                </div>
                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 text-red-800 dark:text-red-200">
                    <i class="ti ti-ban text-xs mr-1"></i>Rupture
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">En rupture</p>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $outOfStockCount }}</p>
            <div class="mt-2 h-1 w-full bg-gradient-to-r from-red-500 to-orange-400 rounded-full"></div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Stock by category --}}
        <div class="bg-gradient-to-br from-white to-blue-50/30 dark:from-gray-800 dark:to-blue-900/10 rounded-2xl border border-blue-100 dark:border-blue-900/30 shadow-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="ti ti-category text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Stock par catégorie</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Répartition des articles par catégorie</p>
                    </div>
                </div>
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-cyan-200">
                    {{ $stockByCategory->count() }} catégories
                </span>
            </div>
            <canvas id="stockCategoryChart" height="120"></canvas>
        </div>

        {{-- Monthly receptions --}}
        <div class="bg-gradient-to-br from-white to-emerald-50/30 dark:from-gray-800 dark:to-emerald-900/10 rounded-2xl border border-emerald-100 dark:border-emerald-900/30 shadow-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-emerald-500 to-green-400 flex items-center justify-center">
                        <i class="ti ti-trending-up text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Réceptions</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Évolution sur 6 derniers mois</p>
                    </div>
                </div>
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 text-emerald-800 dark:text-emerald-200">
                    {{ number_format($monthlyReceptions->sum('total'), 0, ',', ' ') }} DA
                </span>
            </div>
            <canvas id="receptionsChart" height="120"></canvas>
        </div>
    </div>

    {{-- Movements + Low stock --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Entries vs Exits --}}
        <div class="bg-gradient-to-br from-white to-cyan-50/30 dark:from-gray-800 dark:to-cyan-900/10 rounded-2xl border border-cyan-100 dark:border-cyan-900/30 shadow-xl p-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-cyan-500 to-emerald-400 flex items-center justify-center">
                    <i class="ti ti-exchange text-white text-sm"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Mouvements</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">30 derniers jours</p>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Entries -->
                <div class="rounded-xl border border-emerald-100 dark:border-emerald-900/30 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/10 dark:to-green-900/10 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-500 to-green-400 flex items-center justify-center">
                                <i class="ti ti-arrow-bar-to-down text-white text-xs"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Entrées</span>
                        </div>
                        <span class="text-xl font-bold text-emerald-600 dark:text-emerald-400">
                            {{ number_format($entries30,0,',',' ') }}
                        </span>
                    </div>
                    <div class="mt-2 h-1.5 w-full bg-gradient-to-r from-emerald-500 to-green-400 rounded-full"></div>
                </div>

                <!-- Exits -->
                <div class="rounded-xl border border-red-100 dark:border-red-900/30 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/10 dark:to-orange-900/10 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-red-500 to-orange-400 flex items-center justify-center">
                                <i class="ti ti-arrow-bar-to-up text-white text-xs"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Sorties</span>
                        </div>
                        <span class="text-xl font-bold text-red-600 dark:text-red-400">
                            {{ number_format($exits30,0,',',' ') }}
                        </span>
                    </div>
                    <div class="mt-2 h-1.5 w-full bg-gradient-to-r from-red-500 to-orange-400 rounded-full"></div>
                </div>

                <!-- Balance -->
                @php
                    $balance = $entries30 - $exits30;
                    $isPositive = $balance >= 0;
                @endphp
                <div class="rounded-xl border {{ $isPositive ? 'border-emerald-100 dark:border-emerald-900/30' : 'border-red-100 dark:border-red-900/30' }} bg-gradient-to-r {{ $isPositive ? 'from-emerald-50 to-green-50 dark:from-emerald-900/10 dark:to-green-900/10' : 'from-red-50 to-orange-50 dark:from-red-900/10 dark:to-orange-900/10' }} p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r {{ $isPositive ? 'from-emerald-500 to-green-400' : 'from-red-500 to-orange-400' }} flex items-center justify-center">
                                <i class="ti ti-arrows-exchange {{ $isPositive ? '' : 'rotate-90' }} text-white text-xs"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Balance</span>
                        </div>
                        <span class="text-xl font-bold {{ $isPositive ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ number_format($balance,0,',',' ') }}
                        </span>
                    </div>
                    <div class="mt-2 h-1.5 w-full bg-gradient-to-r {{ $isPositive ? 'from-emerald-500 to-green-400' : 'from-red-500 to-orange-400' }} rounded-full"></div>
                </div>
            </div>
        </div>

        {{-- Low stock table --}}
        <div class="bg-gradient-to-br from-white to-amber-50/30 dark:from-gray-800 dark:to-amber-900/10 rounded-2xl border border-amber-100 dark:border-amber-900/30 shadow-xl p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-amber-500 to-yellow-400 flex items-center justify-center">
                        <i class="ti ti-alert-circle text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Articles en stock faible</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Stock inférieur à 10 unités</p>
                    </div>
                </div>
                <a href="{{ route('articles.index') }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-external-link relative z-10 text-sm"></i>
                    <span class="relative z-10 text-sm font-semibold">Voir tout</span>
                </a>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                <i class="ti ti-hash mr-2"></i>Réf
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                <i class="ti ti-text-spellcheck mr-2"></i>Désignation
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                <i class="ti ti-category mr-2"></i>Catégorie
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                <i class="ti ti-sort-ascending mr-2"></i>Stock
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($lowStockArticles as $a)
                        <tr class="hover:bg-gradient-to-r hover:from-amber-50/20 hover:via-yellow-50/10 hover:to-orange-50/20 dark:hover:from-amber-900/5 dark:hover:via-yellow-900/5 dark:hover:to-orange-900/5 transition-all duration-150">
                            <td class="px-6 py-3 whitespace-nowrap">
                                <span class="text-sm font-mono font-medium text-gray-900 dark:text-white">
                                    {{ $a->ref_article }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <span class="text-sm text-gray-900 dark:text-white">{{ $a->designation }}</span>
                            </td>
                            <td class="px-6 py-3">
                                <span class="text-xs px-2.5 py-1 rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200">
                                    {{ $a->categorie->designation ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <span class="px-3 py-1.5 text-sm font-bold rounded-full bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-200">
                                    {{ $a->quantite_en_stock }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/20 dark:to-green-900/20 flex items-center justify-center">
                                        <i class="ti ti-check text-emerald-500 text-xl"></i>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">Aucun article en stock faible</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Tous les stocks sont au-dessus du seuil minimum 🎉</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Last movements --}}
    <div class="bg-gradient-to-br from-white to-blue-50/30 dark:from-gray-800 dark:to-blue-900/10 rounded-2xl border border-blue-100 dark:border-blue-900/30 shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                    <i class="ti ti-history text-white text-sm"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Derniers mouvements</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Activité récente du stock</p>
                </div>
            </div>
            <a href="#" 
               class="relative group overflow-hidden bg-gradient-to-r from-gray-600 via-gray-500 to-gray-400 hover:from-gray-700 hover:via-gray-600 hover:to-gray-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <i class="ti ti-clock relative z-10 text-sm"></i>
                <span class="relative z-10 text-sm font-semibold">Historique complet</span>
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <i class="ti ti-calendar mr-2"></i>Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <i class="ti ti-package mr-2"></i>Article
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <i class="ti ti-exchange mr-2"></i>Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <i class="ti ti-sort-ascending mr-2"></i>Quantité
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            <i class="ti ti-currency-dinar mr-2"></i>Prix
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($lastMovements as $m)
                    <tr class="hover:bg-gradient-to-r hover:from-blue-50/20 hover:via-cyan-50/10 hover:to-emerald-50/20 dark:hover:from-blue-900/5 dark:hover:via-cyan-900/5 dark:hover:to-emerald-900/5 transition-all duration-150">
                        <td class="px-6 py-3 whitespace-nowrap">
                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                {{ optional($m->date_changement)->format('d/m/Y H:i') ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $m->article->designation ?? $m->article_reference ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full
                                {{ $m->type_mouvement == 'Entrée' 
                                    ? 'bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 text-emerald-800 dark:text-emerald-200' 
                                    : 'bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 text-red-800 dark:text-red-200' }}">
                                <i class="ti ti-{{ $m->type_mouvement == 'Entrée' ? 'arrow-bar-to-down' : 'arrow-bar-to-up' }} mr-1 text-xs"></i>
                                {{ $m->type_mouvement }}
                            </span>
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-900 dark:text-gray-200">
                                {{ $m->quantite }}
                            </span>
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                {{ number_format($m->prix ?? 0, 2, ',', ' ') }} DA
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Stock by category bar chart with gradient
    const catLabels = @json($stockByCategory->pluck('designation'));
    const catStocks = @json($stockByCategory->pluck('stock_total'));
    
    const stockCategoryChart = new Chart(document.getElementById('stockCategoryChart'), {
        type: 'bar',
        data: {
            labels: catLabels,
            datasets: [{
                label: 'Stock total',
                data: catStocks,
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1,
                borderRadius: 6,
                hoverBackgroundColor: 'rgb(14, 165, 233)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(30, 41, 59, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#0ea5e9',
                    borderWidth: 1,
                    cornerRadius: 6
                }
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(148, 163, 184, 0.1)' },
                    ticks: { color: '#64748b' }
                },
                x: { 
                    grid: { display: false },
                    ticks: { 
                        color: '#64748b',
                        maxRotation: 45
                    }
                }
            }
        }
    });

    // Monthly receptions line chart with gradient
    const monthsLabels = @json($monthlyReceptions->pluck('label'));
    const monthsTotals = @json($monthlyReceptions->pluck('total'));
    
    const receptionsChart = new Chart(document.getElementById('receptionsChart'), {
        type: 'line',
        data: {
            labels: monthsLabels,
            datasets: [{
                label: 'Total réceptions (DA)',
                data: monthsTotals,
                tension: 0.4,
                fill: {
                    target: 'origin',
                    above: 'rgba(16, 185, 129, 0.1)'
                },
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: 'rgb(16, 185, 129)',
                borderWidth: 3,
                pointBackgroundColor: 'rgb(16, 185, 129)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                tooltip: {
                    backgroundColor: 'rgba(30, 41, 59, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#10b981',
                    borderWidth: 1,
                    cornerRadius: 6,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y.toLocaleString('fr-FR')} DA`;
                        }
                    }
                }
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(148, 163, 184, 0.1)' },
                    ticks: { 
                        color: '#64748b',
                        callback: function(value) {
                            return value.toLocaleString('fr-FR') + ' DA';
                        }
                    }
                },
                x: { 
                    grid: { color: 'rgba(148, 163, 184, 0.1)' },
                    ticks: { color: '#64748b' }
                }
            }
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(to right, #2563eb, #06b6d4, #10b981);
        border-radius: 4px;
    }
    .dark .overflow-x-auto::-webkit-scrollbar-track {
        background: #374151;
    }
    .dark .overflow-x-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(to right, #1d4ed8, #0891b2, #059669);
    }
    
    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Gradient text animation */
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    .gradient-text {
        background-size: 200% auto;
        animation: gradientShift 3s ease-in-out infinite;
    }
</style>
@endpush