@extends('layouts.app')

@section('title', 'Détails des Livraisons par Service')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur opacity-30"></div>
                        <div class="relative bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 p-3 rounded-xl shadow-lg">
                            <i class="ti ti-chart-bar text-white text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Détails des Livraisons par Service</h2>
                        <p class="mt-1 text-sm text-blue-100">Analyse détaillée des livraisons par service</p>
                    </div>
                </div>
                
                <a href="{{ route('statistiques.details.pdf') }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 hover:from-blue-800 hover:via-cyan-700 hover:to-emerald-600 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-800 via-cyan-700 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-file-download relative z-10"></i>
                    <span class="relative z-10 text-sm font-semibold">Exporter PDF</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <!-- Filter Form -->
            <form method="GET" class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <!-- Month Selection -->
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="ti ti-calendar text-cyan-400 mr-2 text-sm"></i>
                            Mois
                        </label>
                        <div class="relative">
                            <select name="month" id="month" 
                                    class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="ti ti-calendar-time absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Year Selection -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="ti ti-calendar-stats text-cyan-400 mr-2 text-sm"></i>
                            Année
                        </label>
                        <div class="relative">
                            <select name="year" id="year" 
                                    class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                @for($y = date('Y') - 5; $y <= date('Y'); $y++)
                                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                            <i class="ti ti-calendar-event absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Service Selection -->
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="ti ti-building-community text-cyan-400 mr-2 text-sm"></i>
                            Service
                        </label>
                        <div class="relative">
                            <select name="service_id" id="service_id"
                                    class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                <option value="">-- Tous les services --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id_service }}" {{ request('service_id') == $service->id_service ? 'selected' : '' }}>
                                        {{ $service->service_fr }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="ti ti-building-warehouse absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Filter Button -->
                    <div>
                        <button type="submit" 
                                class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 w-full">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="ti ti-filter relative z-10"></i>
                            <span class="relative z-10 text-sm font-semibold">Filtrer</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Delivery Details -->
            @foreach($details as $service => $articles)
            <div class="mb-10 bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                            <i class="ti ti-building-community text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $service }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ count($articles) }} articles livrés</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <i class="ti ti-package mr-2"></i>Article
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <i class="ti ti-sort-ascending mr-2"></i>Quantité
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <i class="ti ti-currency-dinar mr-2"></i>Prix Unitaire
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <i class="ti ti-calculator mr-2"></i>Sous-total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @php $total_service = 0; @endphp
                            @foreach($articles as $article)
                                @php $total_service += $article->sous_total; @endphp
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50/20 hover:via-cyan-50/10 hover:to-emerald-50/20 dark:hover:from-blue-900/5 dark:hover:via-cyan-900/5 dark:hover:to-emerald-900/5 transition-all duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center mr-3">
                                                <i class="ti ti-hash text-blue-400 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $article->designation }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200">
                                            {{ $article->quantité_livré }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right">
                                        {{ number_format($article->prix_unitaire, 2, ',', ' ') }} DA
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-cyan-100 to-emerald-100 dark:from-cyan-900/30 dark:to-emerald-900/30 text-cyan-800 dark:text-cyan-200">
                                            {{ number_format($article->sous_total, 2, ',', ' ') }} DA
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 font-semibold">
                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white text-right">
                                    <i class="ti ti-sum mr-2"></i>Total Service
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 text-white">
                                        {{ number_format($total_service, 2, ',', ' ') }} DA
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach

            <!-- Grand Total -->
            @if(count($details) > 0)
            <div class="mt-8 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10 rounded-xl border border-blue-200 dark:border-blue-800 p-6">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur opacity-20"></div>
                        <div class="relative w-16 h-16 rounded-full bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 flex items-center justify-center shadow-lg">
                            <i class="ti ti-sum text-white text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-1">Total Général</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">
                            @php
                                $grand_total = 0;
                                foreach($details as $service => $articles) {
                                    foreach($articles as $article) {
                                        $grand_total += $article->sous_total;
                                    }
                                }
                            @endphp
                            {{ number_format($grand_total, 2, ',', ' ') }} DA
                        </p>
                        <p class="text-sm text-blue-600 dark:text-blue-300 mt-2">
                            <i class="ti ti-info-circle mr-1"></i>
                            Total de toutes les livraisons pour la période sélectionnée
                        </p>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-12">
                <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center mb-4">
                    <i class="ti ti-package text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune livraison trouvée</h3>
                <p class="text-gray-500 dark:text-gray-400">Aucune donnée de livraison disponible pour la période sélectionnée.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
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
</style>
@endpush