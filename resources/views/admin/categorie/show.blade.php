@extends('layouts.app')

@section('title', 'Détails de la catégorie')
@section('subtitle', 'Informations complètes sur la catégorie')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300">
    <!-- Header Section with Gradient -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur-lg opacity-30"></div>
                    <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-3 rounded-xl shadow-lg">
                        <i class="ti ti-category-filled text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $categorie->designation }}</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">ID: {{ $categorie->id_categorie }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('categories.edit', $categorie) }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-edit relative z-10"></i>
                    <span class="relative z-10 font-semibold">Modifier</span>
                </a>
                
                <form action="{{ route('categories.destroy', $categorie) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="relative group overflow-hidden bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 hover:from-red-700 hover:via-orange-600 hover:to-amber-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-trash relative z-10"></i>
                        <span class="relative z-10 font-semibold">Supprimer</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Category Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image Section -->
            <div class="relative overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10"></div>
                @if($categorie->image)
                    <img src="{{ asset('storage/' . $categorie->image) }}" 
                         alt="Image de la catégorie {{ $categorie->designation }}"
                         class="relative w-full h-64 object-contain p-8 transform group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute bottom-4 right-4 px-3 py-1 rounded-full bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 text-white text-xs font-medium shadow-lg">
                        <i class="ti ti-photo mr-1"></i> Image
                    </div>
                @else
                    <div class="relative w-full h-64 flex flex-col items-center justify-center text-gray-400">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-100 via-cyan-100 to-emerald-100 dark:from-blue-900/20 dark:via-cyan-900/20 dark:to-emerald-900/20 flex items-center justify-center mb-3">
                            <i class="ti ti-photo text-3xl text-blue-400"></i>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Aucune image disponible</p>
                    </div>
                @endif
            </div>

            <!-- Description Section -->
            <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="ti ti-file-description text-white text-sm"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Description</h2>
                </div>
                <div class="prose prose-blue dark:prose-invert max-w-none">
                    @if($categorie->description)
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $categorie->description }}
                        </p>
                    @else
                        <div class="text-center py-6">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center mx-auto mb-3">
                                <i class="ti ti-info-circle text-gray-400"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 italic">Aucune description disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Stats & Articles -->
        <div class="space-y-6">
            <!-- Stats Card -->
            <div class="bg-gradient-to-br from-blue-50 via-white to-emerald-50 dark:from-blue-900/10 dark:via-gray-800 dark:to-emerald-900/10 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 flex items-center justify-center">
                        <i class="ti ti-chart-bar text-white text-sm"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Statistiques</h2>
                </div>
                
                <div class="space-y-6">
                    <div class="relative">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Nombre d'articles</p>
                            <span class="text-xs font-semibold px-2 py-1 rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200">
                                {{ $categorie->articles->count() }}
                            </span>
                        </div>
                        <div class="h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 via-cyan-400 to-emerald-400 rounded-full" 
                                 style="width: {{ min(100, ($categorie->articles->count() / 10) * 100) }}%"></div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 rounded-lg bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/10 dark:to-cyan-900/10 border border-blue-100 dark:border-blue-900/30">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">En stock</p>
                            <p class="text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">
                                {{ $categorie->articles->where('quantite_en_stock', '>', 0)->count() }}
                            </p>
                        </div>
                        <div class="text-center p-3 rounded-lg bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/10 dark:to-green-900/10 border border-emerald-100 dark:border-emerald-900/30">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Stock total</p>
                            <p class="text-xl font-bold bg-gradient-to-r from-emerald-600 to-green-500 bg-clip-text text-transparent">
                                {{ $categorie->articles->sum('quantite_en_stock') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Dernière mise à jour</p>
                        <div class="flex items-center space-x-2">
                            <i class="ti ti-calendar text-blue-400"></i>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">
                                {{ $categorie->updated_at ? $categorie->updated_at->format('d/m/Y H:i') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Associated Articles -->
            <div class="bg-gradient-to-br from-cyan-50 via-white to-blue-50 dark:from-cyan-900/10 dark:via-gray-800 dark:to-blue-900/10 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-400 flex items-center justify-center">
                            <i class="ti ti-package text-white text-sm"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Articles associés</h2>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-cyan-900/30 dark:to-blue-900/30 text-cyan-800 dark:text-cyan-200">
                        {{ $categorie->articles->count() }}
                    </span>
                </div>
                
                @if($categorie->articles->count() > 0)
                    <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                        @foreach($categorie->articles->take(10) as $article)
                            <a href="{{ route('articles.show', $article->id_article) }}" 
                               class="group relative p-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transition-all duration-300 flex items-center">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-50/30 to-cyan-50/30 dark:from-blue-900/10 dark:to-cyan-900/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                <div class="relative flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center overflow-hidden">
                                        @if($article->image)
                                            <img src="{{ asset('storage/' . $article->image) }}" 
                                                 alt="{{ $article->designation }}"
                                                 class="h-full w-full object-cover">
                                        @else
                                            <i class="ti ti-package text-blue-400"></i>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="relative ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 truncate">
                                        {{ $article->designation }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Réf: {{ $article->ref_article ?? 'N/A' }}
                                        </p>
                                        <div class="flex items-center space-x-1">
                                            @if($article->quantite_en_stock < 10)
                                                <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                                <span class="text-xs text-red-600 dark:text-red-400 font-semibold">
                                                    {{ $article->quantite_en_stock }}
                                                </span>
                                            @elseif($article->quantite_en_stock < 50)
                                                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                                <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold">
                                                    {{ $article->quantite_en_stock }}
                                                </span>
                                            @else
                                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold">
                                                    {{ $article->quantite_en_stock }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="relative ml-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <i class="ti ti-chevron-right text-blue-400"></i>
                                </div>
                            </a>
                        @endforeach
                        
                        @if($categorie->articles->count() > 10)
                            <div class="text-center pt-4">
                                <a href="{{ route('articles.index', ['category_id' => $categorie->id_categorie]) }}" 
                                   class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 inline-flex items-center">
                                    Voir tous les {{ $categorie->articles->count() }} articles
                                    <i class="ti ti-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center mx-auto mb-4">
                            <i class="ti ti-package-off text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Aucun article</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Cette catégorie ne contient aucun article</p>
                        <a href="{{ route('articles.create') }}" 
                           class="inline-flex items-center px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 text-white font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                            <i class="ti ti-plus mr-2"></i>
                            Créer un article
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="mt-6">
    <a href="{{ route('categories.index') }}" 
       class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 shadow-sm hover:shadow-md">
        <i class="ti ti-arrow-left mr-2"></i>
        Retour à la liste
    </a>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div id="notification" class="fixed top-4 right-4 z-50 animate-slide-in">
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border border-green-200 dark:border-green-800 rounded-xl shadow-lg p-4 max-w-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center">
                <i class="ti ti-check text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('notification').remove()" class="text-green-400 hover:text-green-600 dark:hover:text-green-300">
                <i class="ti ti-x"></i>
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
                <i class="ti ti-exclamation-circle text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
            <button onclick="document.getElementById('error-notification').remove()" class="text-red-400 hover:text-red-600 dark:hover:text-red-300">
                <i class="ti ti-x"></i>
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
    
    /* Custom scrollbar */
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    
    .dark .overflow-y-auto::-webkit-scrollbar-track {
        background: #374151;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #3b82f6, #06b6d4);
        border-radius: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #2563eb, #0891b2);
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

    // Image hover effect
    document.addEventListener('DOMContentLoaded', function() {
        const imageContainer = document.querySelector('.group img');
        if (imageContainer) {
            const container = imageContainer.closest('.group');
            container.addEventListener('mouseenter', function() {
                const badge = this.querySelector('.absolute.bottom-4');
                if (badge) {
                    badge.classList.add('scale-110');
                }
            });
            
            container.addEventListener('mouseleave', function() {
                const badge = this.querySelector('.absolute.bottom-4');
                if (badge) {
                    badge.classList.remove('scale-110');
                }
            });
        }
    });
</script>
@endpush