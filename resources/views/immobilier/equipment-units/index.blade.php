@extends('layouts.app')

@section('title', 'Exemplaires physiques')
@section('subtitle', 'Liste des équipements avec numéro d’inventaire et numéro de série')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-colors duration-300 border border-gray-100 dark:border-gray-700">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-indigo-50/30 via-purple-50/20 to-pink-50/30 dark:from-indigo-900/10 dark:via-purple-900/10 dark:to-pink-900/10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-400 blur-lg opacity-30"></div>
                    <div class="relative bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 p-3 rounded-xl shadow-lg">
                        <i class="fas fa-barcode text-white text-xl"></i>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Exemplaires physiques</h2>
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total exemplaires :</span>
                            <span class="text-lg font-bold bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 bg-clip-text text-transparent">
                                {{ $units->total() }}
                            </span>
                        </div>
                        <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle"></i>
                            <span>Recherche par n° inventaire, n° série ou code</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('immobilier.equipment-units.index') }}" 
                      class="flex flex-col md:flex-row items-stretch md:items-center gap-2">
                    
                    <!-- Search -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <div class="relative">
                            <input type="text"
                                   name="q"
                                   value="{{ request('q') }}"
                                   placeholder="Rechercher (inventaire, série, code)..."
                                   class="pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full md:w-72 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300 hover:border-purple-300 dark:hover:border-purple-600">
                            <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 dark:text-gray-300"></i>
                        </div>
                    </div>
                    
                    <!-- Equipment Filter -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <select name="equipment_id"
                                class="relative pr-10 py-2.5 pl-3 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full md:w-56 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300 hover:border-purple-300 dark:hover:border-purple-600 appearance-none">
                            <option value="">Tous les modèles</option>
                            @foreach($equipments as $eq)
                                <option value="{{ $eq->id }}"
                                    {{ (string)request('equipment_id') === (string)$eq->id ? 'selected' : '' }}>
                                    {{ $eq->label ?? 'Sans libellé' }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 dark:text-gray-300 pointer-events-none"></i>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <select name="status"
                                class="relative pr-10 py-2.5 pl-3 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full md:w-48 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300 hover:border-purple-300 dark:hover:border-purple-600 appearance-none">
                            <option value="">Tous les statuts</option>
                            @foreach([
                                'en_service' => 'En service',
                                'en_panne' => 'En panne',
                                'en_maintenance' => 'En maintenance',
                                'hors_service' => 'Hors service'
                            ] as $value => $label)
                                <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-filter absolute right-3 top-3.5 text-gray-400 dark:text-gray-300 pointer-events-none"></i>
                    </div>
                    
                    <!-- Filter Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="relative group overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 hover:from-indigo-700 hover:via-purple-600 hover:to-pink-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 via-purple-600 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="fas fa-filter relative z-10"></i>
                            <span class="relative z-10 font-semibold">Filtrer</span>
                        </button>
                        
                        <a href="{{ route('immobilier.equipment-units.index') }}"
                           class="relative group px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-800 transition-all duration-300 flex items-center space-x-2">
                            <i class="fas fa-redo"></i>
                            <span>Réinitialiser</span>
                        </a>
                    </div>
                </form>
                
                <!-- New Unit Button -->
                <a href="{{ route('immobilier.equipment-units.create') }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 hover:from-indigo-700 hover:via-purple-600 hover:to-pink-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 via-purple-600 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-plus-circle relative z-10 text-lg"></i>
                    <span class="relative z-10 font-semibold">Nouvel exemplaire</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-indigo-50/50 via-purple-50/30 to-pink-50/30 dark:from-indigo-900/10 dark:via-purple-900/10 dark:to-pink-900/10">
                <tr>
                    @foreach(['N° Inventaire', 'N° Série', 'Code', 'Modèle', 'Catégorie', 'Statut'] as $column)
                        <th scope="col" class="px-6 py-4 text-left">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                {{ $column }}
                            </span>
                        </th>
                    @endforeach
                    <th scope="col" class="px-6 py-4 text-right">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</span>
                    </th>
                </tr>
            </thead>
            
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($units as $unit)
                <tr class="hover:bg-gradient-to-r hover:from-indigo-50/20 hover:via-purple-50/10 hover:to-pink-50/20 dark:hover:from-indigo-900/5 dark:hover:via-purple-900/5 dark:hover:to-pink-900/5 transition-all duration-200 group">
                    
                    <!-- Inventory -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full bg-gradient-to-r from-indigo-500 to-purple-400"></div>
                            <div class="text-sm font-bold text-gray-900 dark:text-white font-mono">
                                {{ $unit->inventory_number ?? '—' }}
                            </div>
                        </div>
                    </td>
                    
                    <!-- Serial -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-barcode text-xs text-gray-400"></i>
                            <span class="text-sm font-medium text-gray-900 dark:text-white font-mono">
                                {{ $unit->serial_number ?? '—' }}
                            </span>
                        </div>
                    </td>
                    
                    <!-- Code -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        {{ $unit->code ?? '—' }}
                    </td>
                    
                    <!-- Equipment model -->
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $unit->equipment->label ?? 'Modèle inconnu' }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center space-x-2">
                            @if(optional($unit->equipment)->manufacturer)
                                <span><i class="fas fa-industry mr-1"></i>{{ $unit->equipment->manufacturer }}</span>
                            @endif
                            @if(optional($unit->equipment)->model)
                                <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-[11px] text-gray-700 dark:text-gray-200">
                                    Modèle : {{ $unit->equipment->model }}
                                </span>
                            @endif
                        </div>
                    </td>
                    
                    <!-- Category -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if(optional($unit->equipment)->category)
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 rounded-md bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 flex items-center justify-center">
                                    <i class="fas fa-layer-group text-indigo-400 text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $unit->equipment->category->name }}
                                </span>
                            </div>
                        @else
                            <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-500 dark:text-gray-400">
                                Non catégorisé
                            </span>
                        @endif
                    </td>
                    
                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $status = $unit->status;
                            $statusLabels = [
                                'en_service' => ['label' => 'En service', 'color' => 'from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 text-emerald-800 dark:text-emerald-200 border-emerald-200 dark:border-emerald-800', 'icon' => 'fa-check-circle'],
                                'en_panne' => ['label' => 'En panne', 'color' => 'from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 text-red-800 dark:text-red-200 border-red-200 dark:border-red-800', 'icon' => 'fa-bolt'],
                                'en_maintenance' => ['label' => 'En maintenance', 'color' => 'from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 text-amber-800 dark:text-amber-200 border-amber-200 dark:border-amber-800', 'icon' => 'fa-tools'],
                                'hors_service' => ['label' => 'Hors service', 'color' => 'from-gray-100 to-gray-200 dark:from-gray-700/50 dark:to-gray-800/50 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600', 'icon' => 'fa-ban'],
                            ];
                            $s = $statusLabels[$status] ?? $statusLabels['en_service'];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-gradient-to-r {{ $s['color'] }} border">
                            <i class="fas {{ $s['icon'] }} mr-1.5"></i> {{ $s['label'] }}
                        </span>
                    </td>
                    
                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-end space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <!-- View -->
                            <a href="{{ route('immobilier.equipment-units.show', $unit) }}" 
                               class="relative group/view p-2 rounded-lg bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 hover:from-indigo-100 hover:to-purple-100 dark:hover:from-indigo-800/30 dark:hover:to-purple-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-lg blur opacity-0 group-hover/view:opacity-20 transition-opacity duration-300"></div>
                                <i class="fas fa-eye text-indigo-600 dark:text-indigo-400 relative z-10"></i>
                            </a>
                            
                            <!-- Edit -->
                            <a href="{{ route('immobilier.equipment-units.edit', $unit) }}" 
                               class="relative group/edit p-2 rounded-lg bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 hover:from-purple-100 hover:to-pink-100 dark:hover:from-purple-800/30 dark:hover:to-pink-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-400 rounded-lg blur opacity-0 group-hover/edit:opacity-20 transition-opacity duration-300"></div>
                                <i class="fas fa-pencil-alt text-purple-600 dark:text-purple-400 relative z-10"></i>
                            </a>
                            
                            <!-- Delete -->
                            <form action="{{ route('immobilier.equipment-units.destroy', $unit) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Supprimer cet exemplaire ?')"
                                        class="relative group/delete p-2 rounded-lg bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 hover:from-red-100 hover:to-rose-100 dark:hover:from-red-800/30 dark:hover:to-rose-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-rose-400 rounded-lg blur opacity-0 group-hover/delete:opacity-20 transition-opacity duration-300"></div>
                                    <i class="fas fa-trash text-red-600 dark:text-red-400 relative z-10"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 flex items-center justify-center">
                                <i class="fas fa-barcode text-2xl text-indigo-500"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aucun exemplaire enregistré</h3>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">Ajoutez vos premiers numéros d’inventaire et de série.</p>
                            </div>
                            <a href="{{ route('immobilier.equipment-units.create') }}" 
                               class="mt-4 bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 hover:from-indigo-700 hover:via-purple-600 hover:to-pink-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                <i class="fas fa-plus-circle"></i>
                                <span>Ajouter un exemplaire</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($units->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-medium dark:text-white">{{ $units->firstItem() }}</span>
                -
                <span class="font-medium dark:text-white">{{ $units->lastItem() }}</span>
                sur
                <span class="font-medium dark:text-white">{{ $units->total() }}</span>
                exemplaires
            </div>
            
            <div class="flex items-center space-x-2">
                @if($units->onFirstPage())
                    <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 text-gray-400 cursor-not-allowed bg-gray-50 dark:bg-gray-800">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                @else
                    <a href="{{ $units->previousPageUrl() }}" 
                       class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <i class="fas fa-chevron-left text-gray-600 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 relative z-10"></i>
                    </a>
                @endif

                @foreach($units->getUrlRange(max(1, $units->currentPage() - 2), min($units->lastPage(), $units->currentPage() + 2)) as $page => $url)
                    @if($page == $units->currentPage())
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

                @if($units->hasMorePages())
                    <a href="{{ $units->nextPageUrl() }}" 
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
</div>

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
        from { transform: translateX(100%); opacity: 0; }
        to   { transform: translateX(0);    opacity: 1; }
    }
    .animate-slide-in { animation: slide-in 0.3s ease-out forwards; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ['notification', 'error-notification'].forEach(id => {
            const el = document.getElementById(id);
            if (el) setTimeout(() => el.remove(), 5000);
        });
    });
</script>
@endpush
