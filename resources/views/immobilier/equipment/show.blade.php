{{-- resources/views/immobilier/equipment/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails équipement')
@section('subtitle', 'Fiche complète de l’équipement et son historique')

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-indigo-50/40 via-purple-50/30 to-pink-50/40 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-start space-x-4">
                    <div class="relative mt-1">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-400 blur-lg opacity-30"></div>
                        <div class="relative bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 p-3 rounded-xl shadow-lg">
                            <i class="fas fa-procedures text-white text-xl"></i>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $equipement->label ?? 'Équipement sans libellé' }}
                        </h2>
                        <div class="mt-2 flex flex-wrap items-center gap-3 text-sm">
                            {{-- Ces champs peuvent rester si tu utilises encore inventory_number/serial_number sur le modèle.
                                 Si tout est passé sur EquipmentUnit, tu peux supprimer ce bloc. --}}
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-500 dark:text-gray-400">N° série (modèle) :</span>
                                <span class="font-mono font-semibold text-gray-900 dark:text-white">
                                    {{ $equipement->serial_number ?? '—' }}
                                </span>
                            </div>
                            @if($equipement->inventory_number)
                                <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-500 dark:text-gray-400">N° inventaire (modèle) :</span>
                                    <span class="font-mono text-gray-900 dark:text-white">
                                        {{ $equipement->inventory_number }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                            @if($equipement->manufacturer)
                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700">
                                    <i class="fas fa-industry mr-1"></i> {{ $equipement->manufacturer }}
                                </span>
                            @endif
                            @if($equipement->model)
                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700">
                                    <i class="fas fa-microchip mr-1"></i> Modèle : {{ $equipement->model }}
                                </span>
                            @endif
                            @if($equipement->category)
                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-200">
                                    <i class="fas fa-layer-group mr-1"></i> {{ $equipement->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-stretch md:items-end gap-3 w-full md:w-auto">
                    @php
                        $status = $equipement->status;
                        $statusLabels = [
                            'en_service' => ['label' => 'En service', 'color' => 'from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 text-emerald-800 dark:text-emerald-200 border-emerald-200 dark:border-emerald-800', 'icon' => 'fa-check-circle'],
                            'en_panne' => ['label' => 'En panne', 'color' => 'from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 text-red-800 dark:text-red-200 border-red-200 dark:border-red-800', 'icon' => 'fa-bolt'],
                            'en_maintenance' => ['label' => 'En maintenance', 'color' => 'from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-200 border-amber-200 dark:border-amber-800', 'icon' => 'fa-tools'],
                            'hors_service' => ['label' => 'Hors service', 'color' => 'from-gray-100 to-gray-200 dark:from-gray-700/50 dark:to-gray-800/50 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600', 'icon' => 'fa-ban'],
                        ];
                        $s = $statusLabels[$status] ?? $statusLabels['en_service'];

                        $interventions = $equipement->maintenanceInterventions ?? collect();
                        $contracts = $equipement->maintenanceContracts ?? collect();
                        $lastIntervention = $interventions->sortByDesc('performed_at')->first();

                        $units = $equipement->units ?? collect();
                    @endphp

                    <div class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r {{ $s['color'] }} border">
                        <i class="fas {{ $s['icon'] }} mr-1.5"></i> {{ $s['label'] }}
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('immobilier.equipements.edit', $equipement) }}"
                           class="relative group overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 hover:from-indigo-700 hover:via-purple-600 hover:to-pink-500 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 via-purple-600 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="fas fa-edit relative z-10"></i>
                            <span class="relative z-10">Modifier</span>
                        </a>

                        <a href="{{ route('immobilier.equipements.index') }}"
                           class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center space-x-1">
                            <i class="fas fa-arrow-left"></i>
                            <span>Retour</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Info -->
        <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Info principale -->
            <div class="lg:col-span-2 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Acquisition (modèle) -->
                    <div class="bg-gray-50 dark:bg-gray-900/40 rounded-lg p-4 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                Acquisition (modèle)
                            </span>
                            <i class="fas fa-calendar-alt text-indigo-400"></i>
                        </div>
                        <div class="text-sm text-gray-900 dark:text-white">
                            @if($equipement->acquisition_date)
                                {{ $equipement->acquisition_date->format('d/m/Y') }}
                            @else
                                <span class="text-gray-400 dark:text-gray-500">Non renseignée</span>
                            @endif
                        </div>
                        @if($equipement->purchase_price)
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Prix type : <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($equipement->purchase_price, 2, ',', ' ') }} DZD
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Contrats -->
                    <div class="bg-gray-50 dark:bg-gray-900/40 rounded-lg p-4 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                Contrats actifs
                            </span>
                            <i class="fas fa-file-contract text-purple-400"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $contracts->count() }}
                        </div>
                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Contrats de maintenance / garantie liés.
                        </div>
                    </div>

                    <!-- Interventions -->
                    <div class="bg-gray-50 dark:bg-gray-900/40 rounded-lg p-4 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                Interventions
                            </span>
                            <i class="fas fa-tools text-pink-400"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $interventions->count() }}
                        </div>
                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            @if($lastIntervention && $lastIntervention->performed_at)
                                Dernière : {{ $lastIntervention->performed_at->format('d/m/Y') }}
                            @else
                                Aucune intervention enregistrée.
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="bg-gray-50 dark:bg-gray-900/40 rounded-lg p-4 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center">
                                <i class="fas fa-sticky-note text-indigo-500"></i>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                Notes & remarques
                            </h3>
                        </div>
                    </div>
                    <div class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed">
                        @if($equipement->notes)
                            {{ $equipement->notes }}
                        @else
                            <span class="text-gray-400 dark:text-gray-500">Aucune note pour cet équipement.</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right: Résumé + métadonnées -->
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-900/40 rounded-lg p-4 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 flex items-center space-x-2">
                        <i class="fas fa-info-circle text-indigo-500"></i>
                        <span>Informations système</span>
                    </h3>
                    <dl class="space-y-2 text-xs text-gray-600 dark:text-gray-300">
                        <div class="flex justify-between">
                            <dt>Créé le</dt>
                            <dd class="font-medium">
                                {{ $equipement->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Dernière mise à jour</dt>
                            <dd class="font-medium">
                                {{ $equipement->updated_at?->format('d/m/Y H:i') ?? '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-indigo-50 dark:bg-indigo-900/30 rounded-lg p-4 border border-indigo-100 dark:border-indigo-700">
                    <div class="flex items-start space-x-3">
                        <div class="mt-0.5">
                            <i class="fas fa-lightbulb text-indigo-500"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                Astuce de traçabilité
                            </h4>
                            <p class="mt-1 text-xs text-gray-700 dark:text-gray-200">
                                Utilisez le <span class="font-mono font-semibold">n° de série</span> des exemplaires
                                pour retrouver rapidement une unité dans le module “Parc biomédical”.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- NOUVELLE CARTE : liste des exemplaires physiques (EquipmentUnit) --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gradient-to-r from-indigo-50/40 via-purple-50/30 to-pink-50/40 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20">
            <div class="flex items-center space-x-2">
                <span class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center">
                    <i class="fas fa-barcode text-indigo-500"></i>
                </span>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                        Exemplaires / Unités physiques
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Chaque ligne correspond à un appareil physique (n° inventaire / n° série).
                    </p>
                </div>
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ $units->count() }} unité(s)
            </div>
        </div>

        @if($units->isEmpty())
            <div class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Aucun exemplaire physique n’est encore enregistré pour ce modèle.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-900/40">
                        <tr class="text-left text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            <th class="px-6 py-3">N° inventaire</th>
                            <th class="px-6 py-3">N° série</th>
                            <th class="px-6 py-3">Acquisition</th>
                            <th class="px-6 py-3">Prix</th>
                            <th class="px-6 py-3">Statut</th>
                            <th class="px-6 py-3">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($units as $unit)
                            @php
                                $uStatus = $unit->status ?? 'en_service';
                                $uLabels = [
                                    'en_service'     => ['label' => 'En service',     'class' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200'],
                                    'en_panne'       => ['label' => 'En panne',       'class' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-200'],
                                    'en_maintenance' => ['label' => 'En maintenance', 'class' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-200'],
                                    'hors_service'   => ['label' => 'Hors service',   'class' => 'bg-gray-50 text-gray-700 dark:bg-gray-700/50 dark:text-gray-200'],
                                ];
                                $us = $uLabels[$uStatus] ?? $uLabels['en_service'];
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                                <!-- N° inventaire -->
                                <td class="px-6 py-3 align-top">
                                    <span class="font-mono text-xs text-gray-900 dark:text-gray-100">
                                        {{ $unit->inventory_number ?? '—' }}
                                    </span>
                                </td>
                                <!-- N° série -->
                                <td class="px-6 py-3 align-top">
                                    <span class="font-mono text-xs text-gray-900 dark:text-gray-100">
                                        {{ $unit->serial_number ?? '—' }}
                                    </span>
                                </td>
                                <!-- Date acquisition -->
                                <td class="px-6 py-3 align-top text-gray-800 dark:text-gray-100">
                                    @if($unit->acquisition_date)
                                        {{ $unit->acquisition_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">—</span>
                                    @endif
                                </td>
                                <!-- Prix -->
                                <td class="px-6 py-3 align-top text-gray-800 dark:text-gray-100">
                                    @if($unit->purchase_price)
                                        {{ number_format($unit->purchase_price, 2, ',', ' ') }} DZD
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">—</span>
                                    @endif
                                </td>
                                <!-- Statut -->
                                <td class="px-6 py-3 align-top">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium {{ $us['class'] }}">
                                        {{ $us['label'] }}
                                    </span>
                                </td>
                                <!-- Notes -->
                                <td class="px-6 py-3 align-top text-xs text-gray-700 dark:text-gray-200 max-w-xs">
                                    @if($unit->notes)
                                        {{ \Illuminate\Support\Str::limit($unit->notes, 80) }}
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Contracts & Interventions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Maintenance Contracts -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gradient-to-r from-indigo-50/40 via-purple-50/30 to-pink-50/40 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20">
                <div class="flex items-center space-x-2">
                    <span class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center">
                        <i class="fas fa-file-contract text-indigo-500"></i>
                    </span>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Contrats liés</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Contrats de maintenance, de garantie ou de location.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-4">
                @if($contracts->isEmpty())
                    <div class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                        Aucun contrat de maintenance n’est lié à cet équipement.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($contracts as $contract)
                            <div class="border border-gray-100 dark:border-gray-700 rounded-lg p-3 bg-gray-50/60 dark:bg-gray-900/40">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $contract->contract_number ?? 'Contrat sans numéro' }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            Type : {{ ucfirst($contract->type ?? 'maintenance') }}
                                        </div>
                                    </div>
                                    <div class="text-xs text-right">
                                        @if($contract->start_date)
                                            <div class="text-gray-600 dark:text-gray-300">
                                                du {{ \Illuminate\Support\Carbon::parse($contract->start_date)->format('d/m/Y') }}
                                            </div>
                                        @endif
                                        @if($contract->end_date)
                                            <div class="text-gray-600 dark:text-gray-300">
                                                au {{ \Illuminate\Support\Carbon::parse($contract->end_date)->format('d/m/Y') }}
                                            </div>
                                        @else
                                            <div class="text-gray-400 dark:text-gray-500">Sans date de fin</div>
                                        @endif
                                    </div>
                                </div>
                                @if($contract->amount)
                                    <div class="mt-2 text-xs text-gray-600 dark:text-gray-300">
                                        Montant : <span class="font-semibold">
                                            {{ number_format($contract->amount, 2, ',', ' ') }} DZD
                                        </span>
                                    </div>
                                @endif
                                @if($contract->description)
                                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        {{ \Illuminate\Support\Str::limit($contract->description, 120) }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Interventions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gradient-to-r from-indigo-50/40 via-purple-50/30 to-pink-50/40 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20">
                <div class="flex items-center space-x-2">
                    <span class="w-8 h-8 rounded-full bg-gradient-to-r from-pink-100 to-rose-100 dark:from-pink-900/40 dark:to-rose-900/40 flex items-center justify-center">
                        <i class="fas fa-tools text-pink-500"></i>
                    </span>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Historique des interventions</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Pannes, maintenances préventives et contrôles.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-4">
                @if($interventions->isEmpty())
                    <div class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                        Aucune intervention enregistrée pour cet équipement.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                                    <th class="py-2 pr-4">Date</th>
                                    <th class="py-2 pr-4">Type</th>
                                    <th class="py-2 pr-4">Statut</th>
                                    <th class="py-2 pr-4">Technicien</th>
                                    <th class="py-2 pr-4 text-right">Coût</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($interventions->sortByDesc('performed_at') as $intervention)
                                    @php
                                        $t = $intervention->type ?? 'corrective';
                                        $typeLabels = [
                                            'preventive' => ['label' => 'Préventive', 'class' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200'],
                                            'corrective' => ['label' => 'Corrective', 'class' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-200'],
                                            'controle'   => ['label' => 'Contrôle',   'class' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-200'],
                                        ];
                                        $tt = $typeLabels[$t] ?? $typeLabels['corrective'];

                                        $st = $intervention->status ?? 'terminee';
                                        $statusInterLabels = [
                                            'planifiee' => ['label' => 'Planifiée', 'class' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-200'],
                                            'en_cours'  => ['label' => 'En cours',  'class' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-200'],
                                            'terminee'  => ['label' => 'Terminée',  'class' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200'],
                                            'annulee'   => ['label' => 'Annulée',   'class' => 'bg-gray-50 text-gray-700 dark:bg-gray-700/50 dark:text-gray-200'],
                                        ];
                                        $si = $statusInterLabels[$st] ?? $statusInterLabels['terminee'];
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                                        <td class="py-2 pr-4 text-gray-800 dark:text-gray-100">
                                            {{ $intervention->performed_at ? \Illuminate\Support\Carbon::parse($intervention->performed_at)->format('d/m/Y') : '—' }}
                                        </td>
                                        <td class="py-2 pr-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium {{ $tt['class'] }}">
                                                {{ $tt['label'] }}
                                            </span>
                                        </td>
                                        <td class="py-2 pr-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium {{ $si['class'] }}">
                                                {{ $si['label'] }}
                                            </span>
                                        </td>
                                        <td class="py-2 pr-4 text-gray-700 dark:text-gray-200">
                                            {{ $intervention->technician_name ?? 'Non renseigné' }}
                                        </td>
                                        <td class="py-2 pr-4 text-right text-gray-700 dark:text-gray-200">
                                            @if($intervention->cost)
                                                {{ number_format($intervention->cost, 2, ',', ' ') }} DZD
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div id="notification" class="fixed top-4 right-4 z-50 animate-slide-in">
    <div class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/30 dark:to-green-900/30 border border-emerald-200 dark:border-emerald-800 rounded-xl shadow-lg p-4 max-w-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-400 to-green-500 flex items-center justify-center">
                <i class="fas fa-check text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('notification').remove()" class="text-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div id="error-notification" class="fixed top-4 right-4 z-50 animate-slide-in">
    <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/30 dark:to-rose-900/30 border border-red-200 dark:border-red-800 rounded-xl shadow-lg p-4 max-w-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-red-400 to-rose-500 flex items-center justify-center">
                <i class="fas fa-exclamation text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
            <button onclick="document.getElementById('error-notification').remove()" class="text-red-400 hover:text-red-600 dark:hover:text-red-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .animate-slide-in {
        animation: slide-in 0.3s ease-out forwards;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ['notification', 'error-notification'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                setTimeout(() => el.remove(), 5000);
            }
        });
    });
</script>
@endpush
