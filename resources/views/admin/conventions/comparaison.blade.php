@extends('layouts.app')

@section('title', 'Comparaison Convention / Livraisons')
@section('subtitle', 'Suivi des quantités livrées par rapport aux quantités convenues')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur-lg opacity-30"></div>
                    <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-3 rounded-xl shadow-lg">
                        <i class="ti ti-arrows-left-right text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Comparaison Convention / Livraisons
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Convention <span class="font-semibold">{{ $convention->reference }}</span> –
                        Fournisseur :
                        <span class="font-semibold">{{ $convention->fournisseur->sociéte ?? $convention->fournisseur->nom }}</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center space-x-2">
                        <span>
                            Année : <span class="font-medium">{{ $convention->annee }}</span>
                        </span>
                        @if($convention->date_debut || $convention->date_fin)
                            <span class="w-px h-4 bg-gray-300 dark:bg-gray-600"></span>
                            <span>
                                Période :
                                <span class="font-medium">
                                    {{ $convention->date_debut ? \Carbon\Carbon::parse($convention->date_debut)->format('d/m/Y') : '–' }}
                                    →
                                    {{ $convention->date_fin ? \Carbon\Carbon::parse($convention->date_fin)->format('d/m/Y') : '–' }}
                                </span>
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Stats globales -->
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="px-4 py-3 rounded-xl bg-white/80 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 shadow-sm">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Taux global</p>
                    <p class="text-xl font-bold bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 bg-clip-text text-transparent">
                        {{ $stats['taux_global'] }}%
                    </p>
                    <div class="mt-2 w-full h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                        <div class="h-1.5 rounded-full bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400"
                             style="width: {{ min(100, $stats['taux_global']) }}%"></div>
                    </div>
                </div>

                <div class="px-4 py-3 rounded-xl bg-white/80 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 shadow-sm">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Articles</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $stats['total_articles'] }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Qte conv. : <span class="font-medium">{{ $stats['total_qte_convenue'] }}</span><br>
                        Qte livrée : <span class="font-medium text-emerald-600 dark:text-emerald-400">{{ $stats['total_qte_livree'] }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-blue-50/50 via-cyan-50/30 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        Article
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        Qté convenue
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        Qté livrée
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        Reste
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        Avancement
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($lignes as $ligne)
                    @php
                        $taux = $ligne->taux;
                    @endphp
                    <tr class="hover:bg-gradient-to-r hover:from-blue-50/20 hover:via-cyan-50/10 hover:to-emerald-50/20 dark:hover:from-blue-900/5 dark:hover:via-cyan-900/5 dark:hover:to-emerald-900/5 transition-colors duration-200">
                        <!-- Article -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                                    <i class="ti ti-package text-blue-500 text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $ligne->article->ref_article ?? '—' }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $ligne->article->designation ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Qte convenue -->
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ $ligne->qte_convenue }}
                            </span>
                        </td>

                        <!-- Qte livrée -->
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                {{ $ligne->qte_livree }}
                            </span>
                        </td>

                        <!-- Reste -->
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-medium {{ $ligne->reste > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                {{ $ligne->reste }}
                            </span>
                        </td>

                        <!-- Avancement -->
                        <td class="px-6 py-4">
                            <div class="flex flex-col space-y-1">
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>{{ $taux }}%</span>
                                    @if($ligne->reste <= 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-[11px] font-medium">
                                            <i class="ti ti-check mr-1 text-[11px]"></i>Complet
                                        </span>
                                    @elseif($taux == 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-[11px] font-medium">
                                            Non commencé
                                        </span>
                                    @endif
                                </div>
                                <div class="w-full h-2 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                    <div class="h-2 rounded-full bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400"
                                         style="width: {{ min(100, $taux) }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center">
                                    <i class="ti ti-info-circle text-blue-500 text-2xl"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    Aucun article trouvé pour cette convention
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Ajoutez des articles à la convention pour voir la comparaison avec les livraisons.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex justify-between items-center">
        <a href="{{ route('conventions.index') }}"
           class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <i class="ti ti-arrow-left mr-2"></i>
            Retour aux conventions
        </a>

        <div class="text-xs text-gray-500 dark:text-gray-400">
            Mise à jour basée sur les réceptions du fournisseur sur la période de la convention.
        </div>
    </div>
</div>
@endsection
