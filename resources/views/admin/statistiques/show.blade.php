@extends('layouts.app')

@section('title', 'Statistiques de Consommation')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Modern Card Container -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-800 transition-all duration-300 hover:shadow-2xl">
        <!-- Gradient Header with Glass Effect -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5 backdrop-blur-sm">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-white/10 backdrop-blur-md mr-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Statistiques de Consommation</h2>
                        <p class="mt-1 text-sm text-indigo-100 opacity-90">Analyse détaillée des consommations par service et période</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button onclick="window.print()" class="glass-button">
                        <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Exporter
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <!-- Modern Filter Card -->
 <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-5 mb-8 border border-gray-200 dark:border-gray-700">
    <form method="GET" action="{{ route('statistiques.consommation') }}">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            
            <!-- Month Select -->
            <div>
                <label for="mois" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mois</label>
                <div class="relative">
                    <select name="mois" id="mois" 
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 
                               text-gray-900 dark:text-gray-100 px-3 py-2 focus:outline-none focus:ring-2 
                               focus:ring-blue-500">
                        <option value="">Tous les mois</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('mois') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->locale('fr')->monthName }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Year Select -->
            <div>
                <label for="annee" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Année</label>
                <div class="relative">
                    <select name="annee" id="annee" 
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 
                               text-gray-900 dark:text-gray-100 px-3 py-2 focus:outline-none focus:ring-2 
                               focus:ring-blue-500">
                        <option value="">Toutes les années</option>
                        @foreach(range(date('Y'), date('Y') - 5) as $y)
                            <option value="{{ $y }}" {{ request('annee') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service Select -->
            <div>
                <label for="service_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Service</label>
                <div class="relative">
                    <select name="service_id" id="service_id" 
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 
                               text-gray-900 dark:text-gray-100 px-3 py-2 focus:outline-none focus:ring-2 
                               focus:ring-blue-500">
                        <option value="">Tous les services</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id_service }}" {{ request('service_id') == $service->id_service ? 'selected' : '' }}>
                                {{ $service->service_fr }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3">
                <button type="submit" 
                    class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Appliquer
                </button>
                <a href="{{ route('statistiques.consommation.pdf', request()->all()) }}" target="_blank" 
                    class="flex items-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    PDF
                </a>
            </div>

        </div>
    </form>
</div>


            <!-- Statistics Table -->
            <div class="overflow-hidden rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Service</span>
                                    <button class="ml-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                        </svg>
                                    </button>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Période</span>
                                    <button class="ml-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                        </svg>
                                    </button>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Montant</span>
                                    <button class="ml-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                        </svg>
                                    </button>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($stats as $stat)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mr-4">
                                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $stat->service_nom }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">{{ $stat->mois }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        {{ number_format($stat->total_consommation, 2, ',', ' ') }} DZD
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Aucune donnée disponible</h3>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Essayez de modifier vos critères de recherche</p>
                                    <button type="button" onclick="window.location.href='{{ route('statistiques.consommation') }}'" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Réinitialiser les filtres
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary Card -->
            @if($stats->count() > 0)
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Card -->
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900 dark:to-indigo-800 rounded-xl p-5 border border-indigo-100 dark:border-indigo-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-lg bg-white/30 dark:bg-indigo-700 backdrop-blur-sm mr-4">
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-indigo-800 dark:text-indigo-200">Total Général</h3>
                            <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-100">
                                {{ number_format($stats->sum('total_consommation'), 2, ',', ' ') }} DZD
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Average Card -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-xl p-5 border border-blue-100 dark:border-blue-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-lg bg-white/30 dark:bg-blue-700 backdrop-blur-sm mr-4">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Moyenne par Service</h3>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">
                                {{ number_format($stats->avg('total_consommation'), 2, ',', ' ') }} DZD
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Services Count -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl p-5 border border-purple-100 dark:border-purple-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-lg bg-white/30 dark:bg-purple-700 backdrop-blur-sm mr-4">
                            <svg class="h-6 w-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-purple-800 dark:text-purple-200">Services Actifs</h3>
                            <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">
                                {{ $stats->unique('service_id')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Modern Select Input */
    .modern-select {
        @apply block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 transition-all duration-200 shadow-sm;
    }

    /* Primary Button */
    .primary-button {
        @apply inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200;
    }

    /* Secondary Button */
    .secondary-button {
        @apply inline-flex items-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg shadow-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200;
    }

    /* Glass Effect Button */
    .glass-button {
        @apply inline-flex items-center px-4 py-2 border border-white/20 text-sm font-medium rounded-lg shadow-sm text-white bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white/50 backdrop-blur-sm transition-all duration-200;
    }

    /* Table Row Hover */
    tr {
        @apply transition-colors duration-150;
    }

    /* Card Hover Effect */
    .hover-scale {
        @apply transition-transform duration-300 hover:scale-[1.02];
    }
</style>
@endpush

@push('scripts')
<script>
    // Dark mode toggle functionality would be here
    // You can reuse your existing dark mode script
</script>
@endpush

@endsection