@extends('layouts.app')

@section('title', 'Détail de l’exemplaire')
@section('subtitle', 'Traçabilité détaillée de l’exemplaire d’équipement')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-indigo-50/40 via-purple-50/30 to-pink-50/30 dark:from-indigo-900/10 dark:via-purple-900/10 dark:to-pink-900/10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-400 blur-lg opacity-30"></div>
                        <div class="relative bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 p-3 rounded-xl shadow-lg">
                            <i class="fas fa-barcode text-white text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex flex-wrap items-center gap-2">
                            Exemplaire
                            <span class="text-sm font-mono px-3 py-1 rounded-full bg-white/80 dark:bg-gray-800/80 border border-indigo-200 dark:border-indigo-700 text-indigo-700 dark:text-indigo-300">
                                {{ $equipmentUnit->inventory_number ?? 'N° inventaire non renseigné' }}
                            </span>
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            N° série : 
                            <span class="font-mono font-semibold">
                                {{ $equipmentUnit->serial_number ?? 'Non renseigné' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('immobilier.equipment-units.index') }}"
                       class="px-4 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2">
                        <i class="fas fa-arrow-left text-xs"></i>
                        <span>Retour à la liste</span>
                    </a>
                    <a href="{{ route('immobilier.equipment-units.edit', $equipmentUnit) }}"
                       class="px-4 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 text-white text-sm font-semibold hover:from-indigo-700 hover:via-purple-600 hover:to-pink-500 shadow-md hover:shadow-lg flex items-center gap-2">
                        <i class="fas fa-edit text-xs"></i>
                        <span>Modifier</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="px-6 py-5 bg-white dark:bg-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Modèle -->
                <div class="rounded-xl border border-gray-100 dark:border-gray-700 bg-gradient-to-br from-white to-indigo-50/40 dark:from-gray-800 dark:to-indigo-900/10 p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Modèle d’équipement</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ optional($equipmentUnit->equipment)->label ?? 'Modèle inconnu' }}
                    </p>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        @if(optional($equipmentUnit->equipment)->manufacturer)
                            <span class="mr-2"><i class="fas fa-industry mr-1"></i>{{ $equipmentUnit->equipment->manufacturer }}</span>
                        @endif
                        @if(optional($equipmentUnit->equipment)->model)
                            <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-[11px] text-gray-700 dark:text-gray-200">
                                Modèle : {{ $equipmentUnit->equipment->model }}
                            </span>
                        @endif
                    </p>
                </div>

                <!-- Catégorie -->
                <div class="rounded-xl border border-gray-100 dark:border-gray-700 bg-gradient-to-br from-white to-purple-50/40 dark:from-gray-800 dark:to-purple-900/10 p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Catégorie</p>
                    @if(optional(optional($equipmentUnit->equipment)->category))
                        <div class="flex items-center space-x-2 mt-1">
                            <div class="w-7 h-7 rounded-md bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 flex items-center justify-center">
                                <i class="fas fa-layer-group text-indigo-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $equipmentUnit->equipment->category->name }}
                                </p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Non catégorisé</p>
                    @endif
                </div>

                <!-- Statut -->
                @php
                    $status = $equipmentUnit->status;
                    $statusLabels = [
                        'en_service' => ['label' => 'En service', 'color' => 'from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 text-emerald-800 dark:text-emerald-200 border-emerald-200 dark:border-emerald-800', 'icon' => 'fa-check-circle'],
                        'en_panne' => ['label' => 'En panne', 'color' => 'from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 text-red-800 dark:text-red-200 border-red-200 dark:border-red-800', 'icon' => 'fa-bolt'],
                        'en_maintenance' => ['label' => 'En maintenance', 'color' => 'from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-200 border-amber-200 dark:border-amber-800', 'icon' => 'fa-tools'],
                        'hors_service' => ['label' => 'Hors service', 'color' => 'from-gray-100 to-gray-200 dark:from-gray-700/50 dark:to-gray-800/50 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600', 'icon' => 'fa-ban'],
                    ];
                    $s = $statusLabels[$status] ?? $statusLabels['en_service'];
                @endphp
                <div class="rounded-xl border border-gray-100 dark:border-gray-700 bg-gradient-to-br from-white to-pink-50/40 dark:from-gray-800 dark:to-pink-900/10 p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Statut</p>
                    <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r {{ $s['color'] }} border">
                        <i class="fas {{ $s['icon'] }} mr-1.5"></i> {{ $s['label'] }}
                    </span>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Créé le {{ $equipmentUnit->created_at->format('d/m/Y H:i') }}<br>
                        Dernière mise à jour le {{ $equipmentUnit->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Details -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
            <span class="w-7 h-7 rounded-full bg-gradient-to-r from-indigo-500 to-purple-400 flex items-center justify-center">
                <i class="fas fa-list text-white text-xs"></i>
            </span>
            Détails de l’exemplaire
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">N° d’inventaire</p>
                    <p class="mt-1 font-mono text-gray-900 dark:text-white">
                        {{ $equipmentUnit->inventory_number ?? 'Non renseigné' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">N° de série</p>
                    <p class="mt-1 font-mono text-gray-900 dark:text-white">
                        {{ $equipmentUnit->serial_number ?? 'Non renseigné' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Code interne</p>
                    <p class="mt-1 text-gray-900 dark:text-white">
                        {{ $equipmentUnit->code ?? 'Non renseigné' }}
                    </p>
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Date d’acquisition</p>
                    <p class="mt-1 text-gray-900 dark:text-white">
                        @if($equipmentUnit->acquisition_date)
                            {{ $equipmentUnit->acquisition_date->format('d/m/Y') }}
                        @else
                            Non renseignée
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Prix d’acquisition</p>
                    <p class="mt-1 text-gray-900 dark:text-white">
                        @if($equipmentUnit->purchase_price)
                            {{ number_format($equipmentUnit->purchase_price, 2, ',', ' ') }} DZD
                        @else
                            Non renseigné
                        @endif
                    </p>
                </div>
            </div>
        </div>

        @if($equipmentUnit->notes)
            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-2">Notes / remarques</p>
                <p class="text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line">
                    {{ $equipmentUnit->notes }}
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
