@extends('layouts.app')

@section('title', 'Gestion des Services')
@section('subtitle', 'Liste complète des services')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-colors duration-300 border border-gray-100 dark:border-gray-700">
    <!-- Header with Stats and Actions -->
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <!-- Icon with brand gradient -->
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur-lg opacity-30"></div>
                    <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-3 rounded-xl shadow-lg">
                        <i class="fas fa-layer-group text-white text-xl"></i>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Services</h2>
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total :</span>
                            <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">
                                {{ $services->total() }}
                            </span>
                        </div>
                        <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Affichage :</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ $services->firstItem() }}-{{ $services->lastItem() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Search -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="relative">
                        <input type="text" placeholder="Rechercher un service..." 
                               class="pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent w-full md:w-64 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600">
                        <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 dark:text-gray-300"></i>
                    </div>
                </div>
                
                <!-- New Service Button -->
                <a href="{{ route('services.create') }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-plus-circle relative z-10 text-lg"></i>
                    <span class="relative z-10 font-semibold">Nouveau Service</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-blue-50/50 via-cyan-50/30 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left">
                        <button class="flex items-center space-x-2 group">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Code</span>
                            <div class="p-1 rounded group-hover:bg-gray-100 dark:group-hover:bg-gray-700 transition-colors">
                                <i class="fas fa-sort text-gray-400 group-hover:text-cyan-500 transition-colors"></i>
                            </div>
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-4 text-left">
                        <button class="flex items-center space-x-2 group">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nom (Français)</span>
                            <div class="p-1 rounded group-hover:bg-gray-100 dark:group-hover:bg-gray-700 transition-colors">
                                <i class="fas fa-sort text-gray-400 group-hover:text-cyan-500 transition-colors"></i>
                            </div>
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-4 text-left">
                        <button class="flex items-center space-x-2 group">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nom (Arabe)</span>
                            <div class="p-1 rounded group-hover:bg-gray-100 dark:group-hover:bg-gray-700 transition-colors">
                                <i class="fas fa-sort text-gray-400 group-hover:text-cyan-500 transition-colors"></i>
                            </div>
                        </button>
                    </th>
                    <th scope="col" class="px-6 py-4 text-right">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($services as $service)
                <tr class="hover:bg-gradient-to-r hover:from-blue-50/20 hover:via-cyan-50/10 hover:to-emerald-50/20 dark:hover:from-blue-900/5 dark:hover:via-cyan-900/5 dark:hover:to-emerald-900/5 transition-all duration-200 group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                            <div class="text-sm font-bold text-gray-900 dark:text-white font-mono">{{ $service->code_service }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $service->service_fr }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 dark:text-white font-medium" dir="rtl">{{ $service->service_arab }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-end space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <!-- Edit Button -->
                            <a href="{{ route('services.edit', $service) }}" 
                               class="relative group/edit p-2 rounded-lg bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 hover:from-cyan-100 hover:to-blue-100 dark:hover:from-cyan-800/30 dark:hover:to-blue-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-lg blur opacity-0 group-hover/edit:opacity-20 transition-opacity duration-300"></div>
                                <i class="fas fa-pencil-alt text-cyan-600 dark:text-cyan-400 relative z-10"></i>
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 dark:bg-gray-900 text-white text-xs rounded opacity-0 group-hover/edit:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                    Modifier
                                </div>
                            </a>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')"
                                        class="relative group/delete p-2 rounded-lg bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 hover:from-red-100 hover:to-orange-100 dark:hover:from-red-800/30 dark:hover:to-orange-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-orange-400 rounded-lg blur opacity-0 group-hover/delete:opacity-20 transition-opacity duration-300"></div>
                                    <i class="fas fa-trash text-red-600 dark:text-red-400 relative z-10"></i>
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 dark:bg-gray-900 text-white text-xs rounded opacity-0 group-hover/delete:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                        Supprimer
                                    </div>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center">
                                <i class="fas fa-layer-group text-2xl text-cyan-500"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aucun service trouvé</h3>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">Commencez par créer votre premier service</p>
                            </div>
                            <a href="{{ route('services.create') }}" 
                               class="mt-4 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                <i class="fas fa-plus-circle"></i>
                                <span>Créer un service</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($services->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-medium dark:text-white">{{ $services->firstItem() }}</span>
                -
                <span class="font-medium dark:text-white">{{ $services->lastItem() }}</span>
                sur
                <span class="font-medium dark:text-white">{{ $services->total() }}</span>
                services
            </div>
            
            <div class="flex items-center space-x-2">
                <!-- Previous Page -->
                @if($services->onFirstPage())
                <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 text-gray-400 cursor-not-allowed bg-gray-50 dark:bg-gray-800">
                    <i class="fas fa-chevron-left"></i>
                </button>
                @else
                <a href="{{ $services->previousPageUrl() }}" 
                   class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-cyan-300 dark:hover:border-cyan-600 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <i class="fas fa-chevron-left text-gray-600 dark:text-gray-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 relative z-10"></i>
                </a>
                @endif
                
                <!-- Page Numbers -->
                @foreach($services->getUrlRange(max(1, $services->currentPage() - 2), min($services->lastPage(), $services->currentPage() + 2)) as $page => $url)
                    @if($page == $services->currentPage())
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
                
                <!-- Next Page -->
                @if($services->hasMorePages())
                <a href="{{ $services->nextPageUrl() }}" 
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

<!-- Success/Error Messages -->
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
    /* Animations */
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
    
    /* Custom focus styles */
    .focus-ring-brand:focus {
        outline: none;
        /* Tailwind-like ring color for brand (cyan-ish) */
        box-shadow: 0 0 0 2px rgba(6, 182, 212, 0.5);
    }
    
    /* Gradient text (brand identity: blue → cyan → emerald) */
    .text-gradient-brand {
        background: linear-gradient(135deg, #2563eb 0%, #06b6d4 50%, #22c55e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide notifications after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = ['notification', 'error-notification'];
        notifications.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                setTimeout(() => {
                    if (element) element.remove();
                }, 5000);
            }
        });
    });

    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[type="text"][placeholder*="Rechercher"]');
        const rows = document.querySelectorAll('tbody tr');
        
        if (searchInput && rows.length > 0) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let found = false;
                    
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(searchTerm)) {
                            found = true;
                        }
                    });
                    
                    if (found) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });

    // Enhanced hover effects for table rows (keep actions visible on hover)
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                const actions = this.querySelector('.opacity-0');
                if (actions) {
                    actions.classList.remove('opacity-0');
                    actions.classList.add('opacity-100');
                }
            });
            
            row.addEventListener('mouseleave', function() {
                const actions = this.querySelector('.opacity-100');
                if (actions && !actions.matches(':hover')) {
                    actions.classList.remove('opacity-100');
                    actions.classList.add('opacity-0');
                }
            });
        });
    });
</script>
@endpush
