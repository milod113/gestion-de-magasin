@extends('layouts.app')

@section('title', 'Gestion des Fournisseurs')
@section('subtitle', 'Liste complète de tous vos partenaires fournisseurs')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-colors duration-300 border border-gray-100 dark:border-gray-700">
    <!-- Header with Stats and Actions -->
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-red-50/30 via-orange-50/20 to-amber-50/30 dark:from-red-900/10 dark:via-orange-900/10 dark:to-amber-900/10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <!-- Icon with brand gradient -->
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-red-500 via-orange-500 to-amber-400 blur-lg opacity-30"></div>
                    <div class="relative bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 p-3 rounded-xl shadow-lg">
                        <i class="fas fa-truck text-white text-xl"></i>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Fournisseurs</h2>
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total :</span>
                            <span class="text-lg font-bold bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">{{ $fournisseurs->total() }}</span>
                        </div>
                        <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Affichage :</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ $fournisseurs->firstItem() }}-{{ $fournisseurs->lastItem() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Search -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="relative">
                        <input type="text" 
                               placeholder="Rechercher un fournisseur..." 
                               class="pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent w-full md:w-64 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-300 hover:border-orange-300 dark:hover:border-orange-600">
                        <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 dark:text-gray-300"></i>
                    </div>
                </div>
                
                <!-- New Supplier Button -->
                <a href="{{ route('fournisseurs.create') }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 hover:from-red-700 hover:via-orange-600 hover:to-amber-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-plus-circle relative z-10 text-lg"></i>
                    <span class="relative z-10 font-semibold">Nouveau Fournisseur</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-red-50/50 via-orange-50/30 to-amber-50/30 dark:from-red-900/10 dark:via-orange-900/10 dark:to-amber-900/10">
                <tr>
                    @foreach(['Code', 'Société', 'Contact', 'Email'] as $column)
                        <th scope="col" class="px-6 py-4 text-left">
                            <button class="flex items-center space-x-2 group">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ $column }}</span>
                                @if(in_array($column, ['Code', 'Société']))
                                <div class="p-1 rounded group-hover:bg-gray-100 dark:group-hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-sort text-gray-400 group-hover:text-amber-500 transition-colors"></i>
                                </div>
                                @endif
                            </button>
                        </th>
                    @endforeach
                    <th scope="col" class="px-6 py-4 text-right">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</span>
                    </th>
                </tr>
            </thead>
            
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($fournisseurs as $fournisseur)
                <tr class="hover:bg-gradient-to-r hover:from-red-50/20 hover:via-orange-50/10 hover:to-amber-50/20 dark:hover:from-red-900/5 dark:hover:via-orange-900/5 dark:hover:to-amber-900/5 transition-all duration-200 group">
                    
                    <!-- Code -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 rounded-full bg-gradient-to-r from-red-500 to-orange-400"></div>
                            <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
                                {{ $fournisseur->code_fournisseur }}
                            </span>
                        </div>
                    </td>
                    
                    <!-- Société -->
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                            {{ $fournisseur->sociéte }}
                        </div>
                    </td>
                    
                    <!-- Contact -->
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 dark:text-white font-medium">
                            {{ $fournisseur->nom }}
                        </div>
                    </td>
                    
                    <!-- Email -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="mailto:{{ $fournisseur->email }}" 
                           class="group/email text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium flex items-center space-x-2">
                            <i class="fas fa-envelope text-blue-400 group-hover/email:text-blue-600 dark:group-hover/email:text-blue-300"></i>
                            <span>{{ $fournisseur->email }}</span>
                        </a>
                    </td>
                    
                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-end space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <!-- Edit Button -->
                            <a href="{{ route('fournisseurs.edit', $fournisseur) }}" 
                               class="relative group/edit p-2 rounded-lg bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 hover:from-amber-100 hover:to-yellow-100 dark:hover:from-amber-800/30 dark:hover:to-yellow-800/30 transition-all duration-300 shadow-sm hover:shadow-md">
                                <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-yellow-400 rounded-lg blur opacity-0 group-hover/edit:opacity-20 transition-opacity duration-300"></div>
                                <i class="fas fa-pencil-alt text-amber-600 dark:text-amber-400 relative z-10"></i>
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-800 dark:bg-gray-900 text-white text-xs rounded opacity-0 group-hover/edit:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                    Modifier
                                </div>
                            </a>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('fournisseurs.destroy', $fournisseur) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')"
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
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 flex items-center justify-center">
                                <i class="fas fa-truck text-2xl text-amber-500"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aucun fournisseur trouvé</h3>
                                <p class="text-gray-500 dark:text-gray-400 mt-1">Commencez par créer votre premier fournisseur</p>
                            </div>
                            <a href="{{ route('fournisseurs.create') }}" 
                               class="mt-4 bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 hover:from-red-700 hover:via-orange-600 hover:to-amber-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                <i class="fas fa-plus-circle"></i>
                                <span>Créer un fournisseur</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($fournisseurs->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-medium dark:text-white">{{ $fournisseurs->firstItem() }}</span>
                -
                <span class="font-medium dark:text-white">{{ $fournisseurs->lastItem() }}</span>
                sur
                <span class="font-medium dark:text-white">{{ $fournisseurs->total() }}</span>
                fournisseurs
            </div>
            
            <div class="flex items-center space-x-2">
                <!-- Previous Page -->
                @if($fournisseurs->onFirstPage())
                <button class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 text-gray-400 cursor-not-allowed bg-gray-50 dark:bg-gray-800">
                    <i class="fas fa-chevron-left"></i>
                </button>
                @else
                <a href="{{ $fournisseurs->previousPageUrl() }}" 
                   class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-amber-300 dark:hover:border-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-yellow-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <i class="fas fa-chevron-left text-gray-600 dark:text-gray-300 group-hover:text-amber-600 dark:group-hover:text-amber-400 relative z-10"></i>
                </a>
                @endif
                
                <!-- Page Numbers -->
                @foreach($fournisseurs->getUrlRange(max(1, $fournisseurs->currentPage() - 2), min($fournisseurs->lastPage(), $fournisseurs->currentPage() + 2)) as $page => $url)
                    @if($page == $fournisseurs->currentPage())
                    <span class="relative w-9 h-9 flex items-center justify-center rounded-lg bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 text-white font-medium shadow-lg">
                        {{ $page }}
                    </span>
                    @else
                    <a href="{{ $url }}" 
                       class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-amber-300 dark:hover:border-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-yellow-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <span class="text-gray-700 dark:text-gray-300 group-hover:text-amber-600 dark:group-hover:text-amber-400 font-medium relative z-10">{{ $page }}</span>
                    </a>
                    @endif
                @endforeach
                
                <!-- Next Page -->
                @if($fournisseurs->hasMorePages())
                <a href="{{ $fournisseurs->nextPageUrl() }}" 
                   class="group relative w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-700 hover:border-amber-300 dark:hover:border-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-yellow-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <i class="fas fa-chevron-right text-gray-600 dark:text-gray-300 group-hover:text-amber-600 dark:group-hover:text-amber-400 relative z-10"></i>
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
    
    /* Email hover effect */
    .group\/email:hover {
        text-decoration: underline;
        text-decoration-thickness: 2px;
        text-underline-offset: 2px;
    }
    
    /* Supplier code badge */
    .supplier-code {
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        letter-spacing: 0.05em;
    }
    
    /* Smooth transitions for all interactive elements */
    select, input, button, a {
        transition: all 0.2s ease-in-out;
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

    // Quick search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[type="text"]');
        const rows = document.querySelectorAll('tbody tr');
        
        if (searchInput && rows.length > 0) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                
                rows.forEach(row => {
                    if (row.querySelector('td[colspan]')) return; // Skip empty state row
                    
                    const cells = row.querySelectorAll('td');
                    let found = false;
                    
                    cells.forEach((cell, index) => {
                        if (index < 4 && cell.textContent.toLowerCase().includes(searchTerm)) {
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

    // Tooltip persistence for action buttons
    document.addEventListener('DOMContentLoaded', function() {
        const actionButtons = document.querySelectorAll('.group\\/edit, .group\\/delete');
        
        actionButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                const tooltip = this.querySelector('.absolute');
                if (tooltip) {
                    tooltip.classList.remove('opacity-0');
                    tooltip.classList.add('opacity-100');
                }
            });
            
            button.addEventListener('mouseleave', function() {
                const tooltip = this.querySelector('.absolute');
                if (tooltip) {
                    tooltip.classList.remove('opacity-100');
                    tooltip.classList.add('opacity-0');
                }
            });
        });
    });

    // Email click enhancement
    document.addEventListener('DOMContentLoaded', function() {
        const emailLinks = document.querySelectorAll('a[href^="mailto:"]');
        
        emailLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.stopPropagation();
                // Add visual feedback
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });
    });
</script>
@endpush