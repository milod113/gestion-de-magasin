@extends('layouts.app')

@section('title', 'Détails catégorie d’équipement')
@section('subtitle', 'Famille du parc biomédical et équipements associés')

@section('content')
<div class="space-y-6">
    <!-- Header catégorie -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-indigo-50/40 via-purple-50/30 to-pink-50/40 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-start space-x-4">
                    <div class="relative mt-1">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-400 blur-lg opacity-30"></div>
                        <div class="relative bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 p-3 rounded-xl shadow-lg">
                            <i class="fas fa-layer-group text-white text-xl"></i>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $category->name }}
                        </h2>
                        <div class="mt-2 flex flex-wrap items-center gap-3 text-sm">
                            @if($category->code)
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-500 dark:text-gray-400">Code :</span>
                                    <span class="px-3 py-1 text-xs font-mono font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                                        {{ $category->code }}
                                    </span>
                                </div>
                            @endif

                            <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>

                            <div class="flex items-center space-x-2">
                                <span class="text-gray-500 dark:text-gray-400">Modèles d’équipements :</span>
                                <span class="text-lg font-bold bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 bg-clip-text text-transparent">
                                    {{ $equipment->total() }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-2 text-sm text-gray-700 dark:text-gray-200">
                            @if($category->description)
                                {{ $category->description }}
                            @else
                                <span class="text-gray-400 dark:text-gray-500">Aucune description fournie pour cette catégorie.</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:items-end gap-3 w-full md:w-auto">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('immobilier.categories-equipements.edit', $category) }}"
                           class="relative group overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 hover:from-indigo-700 hover:via-purple-600 hover:to-pink-500 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 via-purple-600 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="fas fa-edit relative z-10"></i>
                            <span class="relative z-10">Modifier</span>
                        </a>

                        <a href="{{ route('immobilier.categories-equipements.index') }}"
                           class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center space-x-1">
                            <i class="fas fa-arrow-left"></i>
                            <span>Retour</span>
                        </a>
                    </div>

                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        Créée le
                        <span class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $category->created_at?->format('d/m/Y H:i') ?? '—' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des équipements (modèles) de cette catégorie -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <!-- Header liste -->
        <div class="px-6 py-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gradient-to-r from-indigo-50/40 via-purple-50/30 to-pink-50/40 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20">
            <div class="flex items-center space-x-2">
                <span class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center">
                    <i class="fas fa-procedures text-indigo-500"></i>
                </span>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                        Modèles d’équipements de la catégorie « {{ $category->name }} »
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Chaque ligne correspond à un modèle d’équipement (Scanner, moniteur, table d’OP, etc.).
                    </p>
                </div>
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ $equipment->total() }} modèle(s)
            </div>
        </div>

        @if($equipment->isEmpty())
            <div class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Aucun modèle d’équipement n’est encore associé à cette catégorie.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gradient-to-r from-indigo-50/50 via-purple-50/30 to-pink-50/30 dark:from-indigo-900/10 dark:via-purple-900/10 dark:to-pink-900/10">
                        <tr class="text-left text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            <th class="px-6 py-3">Libellé / Modèle</th>
                            <th class="px-6 py-3">Fabricant</th>
                            <th class="px-6 py-3">Nb d’exemplaires</th>
                            <th class="px-6 py-3">Statut</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($equipment as $equipement)
                            @php
                                $status = $equipement->status;
                                $statusLabels = [
                                    'en_service'      => ['label' => 'En service',      'class' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200'],
                                    'en_panne'        => ['label' => 'En panne',        'class' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-200'],
                                    'en_maintenance'  => ['label' => 'En maintenance',  'class' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-200'],
                                    'hors_service'    => ['label' => 'Hors service',    'class' => 'bg-gray-50 text-gray-700 dark:bg-gray-700/50 dark:text-gray-200'],
                                ];
                                $s = $statusLabels[$status] ?? $statusLabels['en_service'];
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                                <!-- Libellé / modèle -->
                                <td class="px-6 py-3 align-top">
                                    <div class="text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $equipement->label ?? 'Équipement sans libellé' }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex flex-wrap gap-2">
                                        @if($equipement->model)
                                            <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-[11px] text-gray-700 dark:text-gray-200">
                                                Modèle : {{ $equipement->model }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Fabricant -->
                                <td class="px-6 py-3 align-top text-gray-800 dark:text-gray-100">
                                    {{ $equipement->manufacturer ?? '—' }}
                                </td>

                                <!-- Nombre d’exemplaires -->
                                <td class="px-6 py-3 align-top">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-200">
                                        <i class="fas fa-barcode mr-1.5 text-xs"></i>
                                        {{ $equipement->units_count ?? 0 }} exemplaire(s)
                                    </span>
                                </td>

                                <!-- Statut global du modèle -->
                                <td class="px-6 py-3 align-top">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium {{ $s['class'] }}">
                                        {{ $s['label'] }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-3 align-top text-right">
                                    <a href="{{ route('immobilier.equipements.show', $equipement) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 transition-colors">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($equipment->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-medium dark:text-white">{{ $equipment->firstItem() }}</span>
                            -
                            <span class="font-medium dark:text-white">{{ $equipment->lastItem() }}</span>
                            sur
                            <span class="font-medium dark:text-white">{{ $equipment->total() }}</span>
                            modèles
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            @if($equipment->onFirstPage())
                                <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 text-gray-400 cursor-not-allowed bg-gray-50 dark:bg-gray-800">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                            @else
                                <a href="{{ $equipment->previousPageUrl() }}" 
                                   class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                                    <i class="fas fa-chevron-left text-gray-600 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 relative z-10"></i>
                                </a>
                            @endif

                            @foreach($equipment->getUrlRange(max(1, $equipment->currentPage() - 2), min($equipment->lastPage(), $equipment->currentPage() + 2)) as $page => $url)
                                @if($page == $equipment->currentPage())
                                    <span class="relative w-9 h-9 flex items-center justify-center rounded-lg bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 text-white font-medium shadow-lg">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-300">
                                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                                        <span class="text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 font-medium relative z-10">{{ $page }}</span>
                                    </a>
                                @endif
                            @endforeach

                            @if($equipment->hasMorePages())
                                <a href="{{ $equipment->nextPageUrl() }}" 
                                   class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                                    <i class="fas fa-chevron-right text-gray-600 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 relative z-10"></i>
                                </a>
                            @else
                                <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 text-gray-400 cursor-not-allowed bg-gray-50 dark:bg-gray-800">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
