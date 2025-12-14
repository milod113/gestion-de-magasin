@extends('layouts.app')

@section('title', 'Détail de la Convention')
@section('subtitle', "Référence : {$convention->reference}")

@section('content')
@php
    // Séparation des lignes
    $stockLines = $convention->lignes->where('item_type', 'article');
    $equipmentLines = $convention->lignes->where('item_type', 'equipment');

    $nbArticles = $stockLines->count();
    $nbEquipments = $equipmentLines->count();
    $nbLignes = $convention->lignes->count();

    $totalTheoriqueArticles = $stockLines->sum(function($l) {
        return ($l->quantite_convenue ?? 0) * ($l->prix_convenu ?? 0);
    });

    $totalTheoriqueEquipments = $equipmentLines->sum(function($l) {
        return ($l->quantite_convenue ?? 0) * ($l->prix_convenu ?? 0);
    });

    $totalTheorique = $totalTheoriqueArticles + $totalTheoriqueEquipments;
@endphp

<div class="space-y-6">
    <!-- Breadcrumb + Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50/40 via-cyan-50/30 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur-lg opacity-30"></div>
                        <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-3 rounded-xl shadow-lg">
                            <i class="fas fa-file-contract text-white text-xl"></i>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                            Convention
                            <span class="text-sm font-mono px-3 py-1 rounded-full bg-white/70 dark:bg-gray-800/80 border border-cyan-200 dark:border-cyan-700 text-cyan-700 dark:text-cyan-300">
                                {{ $convention->reference }}
                            </span>
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Fournisseur :
                            <span class="font-semibold">
                                {{ $convention->fournisseur->sociéte ?? $convention->fournisseur->nom ?? 'N/A' }}
                            </span>
                            • Année : <span class="font-semibold">{{ $convention->annee }}</span>
                            • Type :
                            <span class="font-semibold">
                                @if($convention->isStockConvention())
                                    Articles de stock
                                @elseif($convention->isEquipmentConvention())
                                    Équipements biomédicaux
                                @else
                                    —
                                @endif
                            </span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('conventions.index') }}"
                       class="px-4 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2">
                        <i class="fas fa-arrow-left text-xs"></i>
                        <span>Retour à la liste</span>
                    </a>
                    <a href="{{ route('conventions.edit', $convention) }}"
                       class="px-4 py-2.5 rounded-lg bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-sm font-semibold hover:from-cyan-600 hover:to-emerald-600 shadow-md hover:shadow-lg flex items-center gap-2">
                        <i class="fas fa-edit text-xs"></i>
                        <span>Modifier</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary section -->
        <div class="px-6 py-5 bg-white dark:bg-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Fournisseur -->
                <div class="rounded-xl border border-gray-100 dark:border-gray-700 bg-gradient-to-br from-white to-cyan-50/40 dark:from-gray-800 dark:to-cyan-900/10 p-4 flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="fas fa-truck text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Fournisseur</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $convention->fournisseur->sociéte ?? $convention->fournisseur->nom ?? 'N/A' }}
                        </p>
                        @if($convention->fournisseur->code_fournisseur ?? false)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Code : {{ $convention->fournisseur->code_fournisseur }}
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Année & période -->
                <div class="rounded-xl border border-gray-100 dark:border-gray-700 bg-gradient-to-br from-white to-emerald-50/40 dark:from-gray-800 dark:to-emerald-900/10 p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Année & période</p>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-700 dark:text-cyan-200 border border-blue-200 dark:border-cyan-700">
                            {{ $convention->annee }}
                        </span>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Période :</p>
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        {{ $convention->date_debut ? \Carbon\Carbon::parse($convention->date_debut)->format('d/m/Y') : '—' }}
                        <span class="mx-1">→</span>
                        {{ $convention->date_fin ? \Carbon\Carbon::parse($convention->date_fin)->format('d/m/Y') : '—' }}
                    </p>
                </div>

                <!-- Statut -->
                @php
                    $s = $convention->statut ?? 'brouillon';
                    $statusColors = [
                        'brouillon' => 'bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-800 dark:text-gray-100 border-gray-200 dark:border-gray-700',
                        'actif'     => 'bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 text-emerald-800 dark:text-emerald-200 border-emerald-200 dark:border-emerald-800',
                        'clos'      => 'bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 text-red-800 dark:text-red-200 border-red-200 dark:border-red-800',
                    ];
                @endphp
                <div class="rounded-xl border border-gray-100 dark:border-gray-700 bg-gradient-to-br from-white to-blue-50/40 dark:from-gray-800 dark:to-blue-900/10 p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Statut</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-full border {{ $statusColors[$s] ?? $statusColors['brouillon'] }}">
                            @if($s === 'actif')
                                <i class="fas fa-circle mr-1 text-[8px] text-emerald-500 animate-pulse"></i>
                                Actif
                            @elseif($s === 'clos')
                                <i class="fas fa-lock mr-1 text-[10px]"></i>
                                Clos
                            @else
                                <i class="fas fa-pencil-alt mr-1 text-[10px]"></i>
                                Brouillon
                            @endif
                        </span>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Créée le {{ $convention->created_at->format('d/m/Y à H:i') }}<br>
                        Dernière mise à jour le {{ $convention->updated_at->format('d/m/Y à H:i') }}
                    </p>
                </div>

                <!-- Statistiques lignes -->
                <div class="rounded-xl border border-gray-100 dark:border-gray-700 bg-gradient-to-br from-white to-cyan-50/40 dark:from-gray-800 dark:to-cyan-900/10 p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Lignes de la convention</p>
                    <div class="mt-2 flex items-center gap-4">
                        <div>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 uppercase">Articles</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $nbArticles }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 uppercase">Équipements</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $nbEquipments }}
                            </p>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Montant théorique max (total)</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ number_format($totalTheorique, 2, ',', ' ') }} DA
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($convention->notes)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-5">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 flex items-center gap-2">
            <span class="w-7 h-7 rounded-full bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                <i class="fas fa-sticky-note text-white text-xs"></i>
            </span>
            Notes internes
        </h3>
        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
            {{ $convention->notes }}
        </p>
    </div>
    @endif

    {{-- TABLEAU ARTICLES DE STOCK --}}
    @if($stockLines->isNotEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Articles de stock</h3>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gradient-to-r from-cyan-100 to-emerald-100 dark:from-cyan-900/30 dark:to-emerald-900/30 text-cyan-800 dark:text-cyan-100 border border-cyan-200 dark:border-cyan-800">
                    {{ $nbArticles }} article(s)
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gradient-to-r from-blue-50/50 via-cyan-50/30 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Réf. Article</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Désignation</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Quantité convenue</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Prix convenu</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Montant théorique</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($stockLines as $ligne)
                        @php
                            $q = $ligne->quantite_convenue ?? 0;
                            $p = $ligne->prix_convenu ?? 0;
                            $m = $q * $p;
                        @endphp
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50/20 hover:via-cyan-50/10 hover:to-emerald-50/20 dark:hover:from-blue-900/5 dark:hover:via-cyan-900/5 dark:hover:to-emerald-900/5 transition-all duration-150">
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <span class="px-2.5 py-1 rounded-full text-xs font-mono bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
                                    {{ $ligne->article->ref_article ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-900 dark:text-white">
                                {{ $ligne->article->designation ?? 'Article supprimé' }}
                            </td>
                            <td class="px-6 py-3 text-sm text-right text-gray-900 dark:text-white">
                                {{ number_format($q, 0, ',', ' ') }}
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $ligne->unite ?? $ligne->article->unité ?? '' }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-right text-gray-900 dark:text-white">
                                {{ number_format($p, 2, ',', ' ') }} DA
                            </td>
                            <td class="px-6 py-3 text-sm text-right text-gray-900 dark:text-white font-semibold">
                                {{ number_format($m, 2, ',', ' ') }} DA
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-900/40">
                    <tr>
                        <th colspan="4" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Total théorique (articles)
                        </th>
                        <th class="px-6 py-3 text-right text-sm font-bold text-gray-900 dark:text-white">
                            {{ number_format($totalTheoriqueArticles, 2, ',', ' ') }} DA
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endif

    {{-- TABLEAU ÉQUIPEMENTS --}}
    @if($equipmentLines->isNotEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-emerald-50/30 via-cyan-50/20 to-blue-50/30 dark:from-emerald-900/10 dark:via-cyan-900/10 dark:to-blue-900/10 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Équipements de la convention</h3>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gradient-to-r from-emerald-100 to-cyan-100 dark:from-emerald-900/30 dark:to-cyan-900/30 text-emerald-800 dark:text-emerald-100 border border-emerald-200 dark:border-emerald-800">
                    {{ $nbEquipments }} équipement(s)
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gradient-to-r from-emerald-50/50 via-cyan-50/30 to-blue-50/30 dark:from-emerald-900/10 dark:via-cyan-900/10 dark:to-blue-900/10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Libellé / Modèle</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Quantité convenue</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Prix convenu</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Montant théorique</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($equipmentLines as $ligne)
                        @php
                            $q = $ligne->quantite_convenue ?? 0;
                            $p = $ligne->prix_convenu ?? 0;
                            $m = $q * $p;
                            $equip = $ligne->equipment;
                        @endphp
                        <tr class="hover:bg-gradient-to-r hover:from-emerald-50/20 hover:via-cyan-50/10 hover:to-blue-50/20 dark:hover:from-emerald-900/5 dark:hover:via-cyan-900/5 dark:hover:to-blue-900/5 transition-all duration-150">
 
                            <td class="px-6 py-3 text-sm text-gray-900 dark:text-white">
                                {{ $equip->label ?? $equip->model ?? 'Équipement supprimé' }}
                            </td>
                            <td class="px-6 py-3 text-sm text-right text-gray-900 dark:text-white">
                                {{ number_format($q, 0, ',', ' ') }}
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $ligne->unite ?? 'PCS' }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-right text-gray-900 dark:text-white">
                                {{ number_format($p, 2, ',', ' ') }} DA
                            </td>
                            <td class="px-6 py-3 text-sm text-right text-gray-900 dark:text-white font-semibold">
                                {{ number_format($m, 2, ',', ' ') }} DA
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-900/40">
                    <tr>
                        <th colspan="4" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                            Total théorique (équipements)
                        </th>
                        <th class="px-6 py-3 text-right text-sm font-bold text-gray-900 dark:text-white">
                            {{ number_format($totalTheoriqueEquipments, 2, ',', ' ') }} DA
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endif

    @if($stockLines->isEmpty() && $equipmentLines->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-8 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Aucune ligne (article ou équipement) n'est encore associée à cette convention.
            </p>
        </div>
    @endif
</div>
@endsection
