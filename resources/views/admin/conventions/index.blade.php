@extends('layouts.app')

@section('title', 'Gestion des Conventions')
@section('subtitle', 'Liste des marchés / conventions par fournisseur')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-colors duration-300 border border-gray-100 dark:border-gray-700">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <!-- Icon -->
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur-lg opacity-30"></div>
                    <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-3 rounded-xl shadow-lg">
                        <i class="fas fa-file-contract text-white text-xl"></i>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Conventions</h2>
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total :</span>
                            <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">
                                {{ $conventions->total() }}
                            </span>
                        </div>
                        <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Affichage :</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ $conventions->firstItem() }}-{{ $conventions->lastItem() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters + New button -->
            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <form method="GET" action="{{ route('conventions.index') }}" class="flex flex-col md:flex-row gap-2">
                    <!-- Search -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Référence / fournisseur..."
                                   class="pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent w-full md:w-64 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600">
                            <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 dark:text-gray-300"></i>
                        </div>
                    </div>

                    <!-- Year -->
                    <div class="relative group">
                        <input type="number"
                               name="annee"
                               value="{{ request('annee') }}"
                               placeholder="Année"
                               class="px-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent w-full md:w-28 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600 text-center">
                    </div>

                    <!-- Status -->
                    <div class="relative">
                        <select name="statut"
                                class="pl-3 pr-8 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600">
                            <option value="">Tous les statuts</option>
                            <option value="brouillon" {{ request('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                            <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="clos" {{ request('statut') == 'clos' ? 'selected' : '' }}>Clos</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-2 top-3 text-xs text-gray-400 pointer-events-none"></i>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit"
                                class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="fas fa-filter relative z-10 text-xs"></i>
                            <span class="relative z-10 text-sm font-semibold">Filtrer</span>
                        </button>

                        <a href="{{ route('conventions.index') }}"
                           class="px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-800 transition-all duration-300 flex items-center space-x-2">
                            <i class="fas fa-undo text-xs"></i>
                            <span class="text-sm">Réinitialiser</span>
                        </a>
                    </div>
                </form>

                <!-- New -->
                <a href="{{ route('conventions.create') }}"
                   class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-file-medical-alt relative z-10 text-lg"></i>
                    <span class="relative z-10 font-semibold text-sm">Nouvelle Convention</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-blue-50/50 via-cyan-50/30 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Référence</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Année</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Fournisseur</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Période</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Articles</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($conventions as $convention)
                    @php
                        $statusColors = [
                            'brouillon' => 'bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-800 dark:text-gray-100 border-gray-200 dark:border-gray-700',
                            'actif'     => 'bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 text-emerald-800 dark:text-emerald-200 border-emerald-200 dark:border-emerald-800',
                            'clos'      => 'bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 text-red-800 dark:text-red-200 border-red-200 dark:border-red-800',
                        ];
                    @endphp
                    <tr class="hover:bg-gradient-to-r hover:from-blue-50/20 hover:via-cyan-50/10 hover:to-emerald-50/20 dark:hover:from-blue-900/5 dark:hover:via-cyan-900/5 dark:hover:to-emerald-900/5 transition-all duration-200 group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-2 rounded-full bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                                <a href="{{ route('conventions.show', $convention) }}"
                                   class="text-sm font-bold text-gray-900 dark:text-white hover:text-cyan-600 dark:hover:text-cyan-400">
                                    {{ $convention->reference }}
                                </a>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-700 dark:text-cyan-200 border border-blue-200 dark:border-cyan-700">
                                {{ $convention->annee }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $convention->fournisseur->sociéte ?? $convention->fournisseur->nom ?? 'N/A' }}
                            </div>
                            @if($convention->fournisseur->code_fournisseur ?? false)
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $convention->fournisseur->code_fournisseur }}
                            </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                            @if($convention->date_debut || $convention->date_fin)
                                <div>
                                    {{ $convention->date_debut ? \Carbon\Carbon::parse($convention->date_debut)->format('d/m/Y') : '—' }}
                                    <span class="mx-1">→</span>
                                    {{ $convention->date_fin ? \Carbon\Carbon::parse($convention->date_fin)->format('d/m/Y') : '—' }}
                                </div>
                                @if($convention->date_fin)
                                    @php
                                        $end = \Carbon\Carbon::parse($convention->date_fin);
                                        $now = now();
                                    @endphp
                                    @if($end->isPast())
                                        <span class="text-xs text-red-500">Expirée</span>
                                    @elseif($end->diffInDays($now) <= 30)
                                        <span class="text-xs text-amber-500">Expire bientôt</span>
                                    @endif
                                @endif
                            @else
                                <span class="text-xs text-gray-400">Non définie</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @php $s = $convention->statut ?? 'brouillon'; @endphp
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
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                            <span class="px-2.5 py-1 text-xs rounded-full bg-gradient-to-r from-cyan-100 to-emerald-100 dark:from-cyan-900/30 dark:to-emerald-900/30 text-cyan-800 dark:text-cyan-100 border border-cyan-200 dark:border-cyan-800">
                                {{ $convention->lignes_count ?? $convention->lignes()->count() }} article(s)
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <!-- Show -->
                                <a href="{{ route('conventions.show', $convention) }}"
                                   class="relative group/view p-2 rounded-lg bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 hover:from-blue-100 hover:to-cyan-100 dark:hover:from-blue-800/30 dark:hover:to-cyan-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-lg blur opacity-0 group-hover/view:opacity-20 transition-opacity duration-300"></div>
                                    <i class="fas fa-eye text-blue-600 dark:text-blue-400 relative z-10"></i>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('conventions.edit', $convention) }}"
                                   class="relative group/edit p-2 rounded-lg bg-gradient-to-r from-cyan-50 to-emerald-50 dark:from-cyan-900/20 dark:to-emerald-900/20 hover:from-cyan-100 hover:to-emerald-100 dark:hover:from-cyan-800/30 dark:hover:to-emerald-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-lg blur opacity-0 group-hover/edit:opacity-20 transition-opacity duration-300"></div>
                                    <i class="fas fa-pencil-alt text-cyan-600 dark:text-cyan-400 relative z-10"></i>
                                </a>




                                <!-- Delete -->
                                <form action="{{ route('conventions.destroy', $convention) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Supprimer cette convention ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="relative group/delete p-2 rounded-lg bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 hover:from-red-100 hover:to-orange-100 dark:hover:from-red-800/30 dark:hover:to-orange-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                        <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-orange-400 rounded-lg blur opacity-0 group-hover/delete:opacity-20 transition-opacity duration-300"></div>
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
                                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center">
                                    <i class="fas fa-file-contract text-2xl text-cyan-500"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aucune convention trouvée</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">Commencez par créer votre première convention.</p>
                                </div>
                                <a href="{{ route('conventions.create') }}"
                                   class="mt-4 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Créer une convention</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($conventions->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium dark:text-white">{{ $conventions->firstItem() }}</span>
                    -
                    <span class="font-medium dark:text-white">{{ $conventions->lastItem() }}</span>
                    sur
                    <span class="font-medium dark:text-white">{{ $conventions->total() }}</span>
                    conventions
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Prev -->
                    @if($conventions->onFirstPage())
                        <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 text-gray-400 cursor-not-allowed bg-gray-50 dark:bg-gray-800">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    @else
                        <a href="{{ $conventions->previousPageUrl() }}"
                           class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-cyan-300 dark:hover:border-cyan-600 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 transition-all duration-300">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <i class="fas fa-chevron-left text-gray-600 dark:text-gray-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 relative z-10"></i>
                        </a>
                    @endif

                    <!-- Pages -->
                    @foreach($conventions->getUrlRange(max(1, $conventions->currentPage() - 2), min($conventions->lastPage(), $conventions->currentPage() + 2)) as $page => $url)
                        @if($page == $conventions->currentPage())
                            <span class="relative w-9 h-9 flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 text-white font-medium shadow-lg">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-cyan-300 dark:hover:border-cyan-600 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 transition-all duration-300">
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                                <span class="text-gray-700 dark:text-gray-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 font-medium relative z-10">{{ $page }}</span>
                            </a>
                        @endif
                    @endforeach

                    <!-- Next -->
                    @if($conventions->hasMorePages())
                        <a href="{{ $conventions->nextPageUrl() }}"
                           class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-cyan-300 dark:hover:border-cyan-600 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 transition-all duration-300">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <i class="fas fa-chevron-right text-gray-600 dark:text-gray-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 relative z-10"></i>
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

<!-- Notifications -->
@if(session('success'))
    <div id="notification" class="fixed top-4 right-4 z-50 animate-slide-in">
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border border-green-200 dark:border-green-800 rounded-xl shadow-lg p-4 max-w-sm">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('notification').remove()" class="text-green-400 hover:text-green-600 dark:hover:text-green-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div id="error-notification" class="fixed top-4 right-4 z-50 animate-slide-in">
        <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/30 dark:to-orange-900/30 border border-red-200 dark:border-red-800 rounded-xl shadow-lg p-4 max-w-sm">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-red-400 to-orange-500 flex items-center justify-center">
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
    to   { transform: translateX(0); opacity: 1; }
}
.animate-slide-in { animation: slide-in 0.3s ease-out forwards; }

select, input, button, a {
    transition: all 0.2s ease-in-out;
}

/* Custom scrollbar for table */
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