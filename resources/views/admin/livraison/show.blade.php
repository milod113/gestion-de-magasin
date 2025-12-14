@extends('layouts.app')

@section('title', 'Détails Livraison - ' . $commande->ref_commande)
@section('subtitle', 'Informations complètes sur la livraison')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Enhanced Header -->
    <div class="mb-8">
        <div class="flex flex-col space-y-6">
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('commandes.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300 group">
                            <i class="ti ti-layout-grid mr-2 group-hover:scale-110 transition-transform"></i>
                            Commandes
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <i class="ti ti-chevron-right text-gray-400 mx-1"></i>
                        <a href="{{ route('commandes.show', $commande->id_commande) }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300">
                            Commande {{ $commande->ref_commande }}
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="ti ti-chevron-right text-gray-400 mx-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Détails livraison</span>
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
                            <i class="ti ti-truck-delivery text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 bg-clip-text text-transparent">
                            Détails Livraison
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Commande : <span class="ml-2 font-semibold text-blue-600 dark:text-blue-400 font-mono">#{{ $commande->ref_commande }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    @if($commande->livraisons->count() > 0)
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800 flex items-center">
                        <i class="ti ti-check mr-1.5"></i>
                        Livrée
                    </span>
                    @else
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-200 border border-amber-200 dark:border-amber-800 flex items-center">
                        <i class="ti ti-clock mr-1.5"></i>
                        En attente
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Header with Gradient -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="ti ti-package text-blue-500 text-xl mr-3"></i>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Résumé de la livraison</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Informations complètes sur la livraison</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        <i class="ti ti-calendar mr-1"></i>
                        {{ optional($commande->livraison)->date_livraison ? $commande->livraison->date_livraison->format('d/m/Y') : '—' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <!-- Delivery Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Date de commande -->
                <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center mr-4">
                            <i class="ti ti-calendar text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Date de commande</p>
                            <p class="text-lg font-semibold text-gray-800 dark:text-white">
                                {{ $commande->date_commande ? $commande->date_commande->format('d/m/Y') : '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Date de livraison -->
                <div class="bg-gradient-to-r from-green-50/20 via-emerald-50/10 to-lime-50/20 dark:from-green-900/5 dark:via-emerald-900/5 dark:to-lime-900/5 rounded-xl border border-green-100 dark:border-green-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-green-500 to-emerald-400 flex items-center justify-center mr-4">
                            <i class="ti ti-calendar-check text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Date de livraison</p>
                            <p class="text-lg font-semibold text-gray-800 dark:text-white">
                                {{ optional($commande->livraison)->date_livraison ? $commande->livraison->date_livraison->format('d/m/Y') : '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Livré par -->
                <div class="bg-gradient-to-r from-purple-50/20 via-pink-50/10 to-rose-50/20 dark:from-purple-900/5 dark:via-pink-900/5 dark:to-rose-900/5 rounded-xl border border-purple-100 dark:border-purple-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-purple-500 to-pink-400 flex items-center justify-center mr-4">
                            <i class="ti ti-user text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Livré par</p>
                            <p class="text-lg font-semibold text-gray-800 dark:text-white">
                                {{ $commande->livraisons->first()->livré_par ?? '—' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Information -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="ti ti-building-hospital text-white text-sm"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informations du service</h3>
                </div>
                <div class="bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center mr-3">
                            <i class="ti ti-building text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-lg font-medium text-gray-800 dark:text-white">
                                {{ $commande->service->service_fr ?? 'Non spécifié' }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                <i class="ti ti-hash mr-1"></i>
                                Code service : {{ $commande->service_code ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles Table -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-400 flex items-center justify-center">
                            <i class="ti ti-packages text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Détails des articles</h3>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200">
                            {{ $commande->lignes->count() }} article(s)
                        </span>
                        @if($commande->livraisons->count() > 0)
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-800 dark:text-green-200">
                            {{ $commande->livraisons->sum(function($livraison) { return $livraison->lignes->sum('quantité_livré'); }) }} livré(s)
                        </span>
                        @endif
                    </div>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="ti ti-package mr-2 text-blue-400"></i>
                                        Article
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="ti ti-hash mr-2 text-cyan-400"></i>
                                        Référence
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="ti ti-shopping-cart mr-2 text-indigo-400"></i>
                                        Commandé
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="ti ti-truck-delivery mr-2 text-green-400"></i>
                                        Livré
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="ti ti-circle-check mr-2 text-purple-400"></i>
                                        Statut
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($commande->lignes as $ligneCommande)
                                @php
                                    $qteLivree = $commande->livraisons
                                        ->flatMap->lignes
                                        ->where('artc_ref', $ligneCommande->article_reference)
                                        ->sum('quantité_livré');
                                    $statusClass = $qteLivree >= $ligneCommande->quantité 
                                        ? 'bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800'
                                        : ($qteLivree > 0 
                                            ? 'bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-200 border border-amber-200 dark:border-amber-800'
                                            : 'bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700');
                                    $statusText = $qteLivree >= $ligneCommande->quantité ? 'Complet' : ($qteLivree > 0 ? 'Partiel' : 'En attente');
                                    $statusIcon = $qteLivree >= $ligneCommande->quantité ? 'ti-check' : ($qteLivree > 0 ? 'ti-alert-circle' : 'ti-clock');
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center mr-3">
                                                <i class="ti ti-package text-blue-400 text-sm"></i>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $ligneCommande->article->designation ?? '—' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700 dark:text-gray-300 font-mono">
                                            {{ $ligneCommande->article_reference }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $ligneCommande->quantité }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white mr-2">
                                                {{ $qteLivree }}
                                            </div>
                                            @if($qteLivree > 0)
                                            <div class="h-1.5 w-16 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-green-500 to-emerald-400 rounded-full" 
                                                     style="width: {{ min(($qteLivree / $ligneCommande->quantité) * 100, 100) }}%">
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1.5 text-xs font-medium rounded-full {{ $statusClass }} flex items-center w-fit">
                                            <i class="ti {{ $statusIcon }} mr-1.5"></i>
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Livraisons History -->
            @if($commande->livraisons->count() > 0)
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-400 flex items-center justify-center">
                        <i class="ti ti-history text-white text-sm"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Historique des livraisons</h3>
                </div>
                <div class="space-y-4">
                    @foreach($commande->livraisons as $livraison)
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/30 dark:to-gray-800/30 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/20 flex items-center justify-center">
                                    <i class="ti ti-truck-delivery text-green-400"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        Livraison du {{ $livraison->date_livraison->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Livré par : {{ $livraison->livré_par }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                <span class="px-2 py-1 rounded-md bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                                    {{ $livraison->lignes->sum('quantité_livré') }} article(s)
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
                <a href="{{ route('commandes.index') }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-gray-600 via-gray-500 to-gray-400 hover:from-gray-700 hover:via-gray-600 hover:to-gray-500 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 w-full sm:w-auto justify-center">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-arrow-left relative z-10"></i>
                    <span class="relative z-10 font-semibold">Retour aux commandes</span>
                </a>
                
                @if($commande->livraisons->count() > 0)
                <button onclick="window.print()"
                        class="relative group overflow-hidden bg-gradient-to-r from-indigo-600 to-purple-500 hover:from-indigo-700 hover:to-purple-600 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 w-full sm:w-auto justify-center">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-download relative z-10"></i>
                    <span class="relative z-10 font-semibold">Télécharger le bon</span>
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        body {
            background: white !important;
            color: black !important;
        }
        
        .bg-gradient-to-r, .dark\\:bg-gray-800, .dark\\:text-white {
            background: white !important;
            color: black !important;
        }
        
        .border, .shadow-lg, .rounded-xl {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }
        
        .bg-gradient-to-r {
            background: #f3f4f6 !important;
        }
        
        .bg-clip-text {
            color: black !important;
            background: none !important;
            -webkit-background-clip: initial !important;
            -webkit-text-fill-color: initial !important;
        }
    }
</style>
@endsection

@push('styles')
<style>
    /* Enhanced hover effects */
    .hover-lift:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
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
    
    /* Progress bar animation */
    @keyframes progress {
        from { width: 0%; }
        to { width: var(--progress-width); }
    }
    
    .progress-bar {
        animation: progress 1s ease-out forwards;
    }
</style>
@endpush

@push('scripts')
<script>
    // Progress bar animation
    document.addEventListener('DOMContentLoaded', function() {
        const progressBars = document.querySelectorAll('.bg-gradient-to-r.from-green-500.to-emerald-400');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 1s ease-out';
                bar.style.width = width;
            }, 100);
        });
    });

    // Print functionality
    function printDelivery() {
        const printContent = document.querySelector('.bg-white.rounded-xl.shadow-lg');
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Bon de Livraison - ${document.title}</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .print-header { text-align: center; margin-bottom: 30px; }
                    .print-header h1 { color: #3b82f6; margin-bottom: 10px; }
                    .print-section { margin-bottom: 20px; }
                    .print-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                    .print-table th, .print-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    .print-table th { background-color: #f3f4f6; }
                    .status-badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; }
                    .status-complete { background: #d1fae5; color: #065f46; }
                    .status-partial { background: #fef3c7; color: #92400e; }
                    .status-pending { background: #f3f4f6; color: #374151; }
                </style>
            </head>
            <body>
                <div class="print-header">
                    <h1>Bon de Livraison</h1>
                    <p>Référence commande: {{ $commande->ref_commande }}</p>
                    <p>Date: ${new Date().toLocaleDateString('fr-FR')}</p>
                </div>
                ${printContent.innerHTML}
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    }

    // Initialize progress bars
    document.querySelectorAll('.bg-gradient-to-r.from-green-500.to-emerald-400').forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.transition = 'width 1s ease-out';
            bar.style.width = width;
        }, 100);
    });
</script>
@endpush