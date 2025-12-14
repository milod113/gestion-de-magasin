@extends('layouts.app')

@section('title', 'Modifier un Article')
@section('subtitle', 'Mettre à jour les détails de l\'article')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300">
    <!-- Header Section -->
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
        <div class="flex items-center space-x-4">
            <div class="relative">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 blur-lg opacity-30"></div>
                <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-3 rounded-xl shadow-lg">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Modifier l'article</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Mise à jour des détails de <span class="font-medium text-blue-600 dark:text-blue-400">{{ $article->designation }}</span></p>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <form action="{{ route('articles.update', $article) }}" method="POST" class="space-y-8" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Basic Information Card -->
            <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="fas fa-info-circle text-white text-sm"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informations de base</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Reference Field -->
                    <div class="relative group">
                        <label for="ref_article" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 flex items-center">
                            <i class="fas fa-barcode text-blue-500 mr-2 text-xs"></i>
                            Référence *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <input type="text" id="ref_article" name="ref_article" required
                                class="relative block w-full px-4 py-3 border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600"
                                value="{{ old('ref_article', $article->ref_article) }}">
                        </div>
                        @error('ref_article')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Designation Field -->
                    <div class="relative group">
                        <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 flex items-center">
                            <i class="fas fa-tag text-cyan-500 mr-2 text-xs"></i>
                            Désignation *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <input type="text" id="designation" name="designation" required
                                class="relative block w-full px-4 py-3 border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600"
                                value="{{ old('designation', $article->designation) }}">
                        </div>
                        @error('designation')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Category Field -->
                    <div class="relative group">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 flex items-center">
                            <i class="fas fa-folder text-emerald-500 mr-2 text-xs"></i>
                            Catégorie *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <select id="category_id" name="category_id" required
                                class="relative block w-full px-4 py-3 border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600 appearance-none pr-10">
                                <option value="" disabled>Choisir une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id_categorie }}" 
                                        {{ (old('category_id', $article->category_id) == $categorie->id_categorie) ? 'selected' : '' }}>
                                        {{ $categorie->designation }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 dark:text-gray-500"></i>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Unit Field -->
                    <div class="relative group">
                        <label for="unité" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 flex items-center">
                            <i class="fas fa-weight text-blue-400 mr-2 text-xs"></i>
                            Unité *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <input type="text" id="unité" name="unité" required
                                class="relative block w-full px-4 py-3 border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600"
                                value="{{ old('unité', $article->unité) }}">
                        </div>
                        @error('unité')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Pricing & Stock Card -->
            <div class="bg-gradient-to-r from-cyan-50/20 via-blue-50/10 to-emerald-50/20 dark:from-cyan-900/5 dark:via-blue-900/5 dark:to-emerald-900/5 rounded-xl border border-cyan-100 dark:border-cyan-900/30 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-400 flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-sm"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Prix & Stock</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Price Field -->
                    <div class="relative group">
                        <label for="prix" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 flex items-center">
                            <i class="fas fa-money-bill-wave text-emerald-500 mr-2 text-xs"></i>
                            Prix *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="relative flex items-center">
                                <input type="number" id="prix" name="prix" required step="0.01" min="0"
                                    class="relative block w-full px-4 py-3 border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600"
                                    value="{{ old('prix', $article->prix) }}">
                                <span class="absolute right-3 text-gray-500 dark:text-gray-400">DH</span>
                            </div>
                        </div>
                        @error('prix')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Stock Quantity Field -->
                    <div class="relative group">
                        <label for="quantite_en_stock" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 flex items-center">
                            <i class="fas fa-boxes text-cyan-500 mr-2 text-xs"></i>
                            Quantité en stock *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <input type="number" id="quantite_en_stock" name="quantite_en_stock" required min="0"
                                class="relative block w-full px-4 py-3 border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600"
                                value="{{ old('quantite_en_stock', $article->quantite_en_stock) }}">
                        </div>
                        @error('quantite_en_stock')
                            <p class="mt-2 text-sm text-red-500 dark:text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Stock Status Indicator -->
                    <div class="md:col-span-2">
                        <div class="flex items-center justify-between p-4 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 border border-gray-200 dark:border-gray-700">
                            <div>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">État du stock</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Basé sur la quantité saisie</p>
                            </div>
                            <div id="stock-status" class="flex items-center">
                                <!-- This will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Information Card -->
            <div class="bg-gradient-to-r from-emerald-50/20 via-cyan-50/10 to-blue-50/20 dark:from-emerald-900/5 dark:via-cyan-900/5 dark:to-blue-900/5 rounded-xl border border-emerald-100 dark:border-emerald-900/30 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-emerald-500 to-green-400 flex items-center justify-center">
                        <i class="fas fa-file-alt text-white text-sm"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informations supplémentaires</h3>
                </div>
                
                <!-- Description Field -->
                <div class="relative group">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 flex items-center">
                        <i class="fas fa-align-left text-blue-500 mr-2 text-xs"></i>
                        Description
                    </label>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <textarea id="description" name="description" rows="4"
                            class="relative block w-full px-4 py-3 border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300 hover:border-cyan-300 dark:hover:border-cyan-600 resize-none">{{ old('description', $article->description) }}</textarea>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Description optionnelle de l'article</p>
                        <span id="description-counter" class="text-xs text-gray-500 dark:text-gray-400">0/500</span>
                    </div>
                    @error('description')
                        <p class="mt-2 text-sm text-red-500 dark:text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Image Upload Field -->
                <div class="mt-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 flex items-center">
                        <i class="fas fa-image text-cyan-500 mr-2 text-xs"></i>
                        Image de l'article
                    </label>
                    
                    @if($article->image)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Image actuelle :</p>
                        <div class="relative w-32 h-32 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                            <img src="{{ asset('storage/' . $article->image) }}" 
                                 alt="{{ $article->designation }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                        <div class="mt-2 flex items-center space-x-2">
                            <a href="{{ asset('storage/' . $article->image) }}" 
                               target="_blank"
                               class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                                <i class="fas fa-external-link-alt mr-1 text-xs"></i> Voir en grand
                            </a>
                            <label class="text-sm text-gray-600 dark:text-gray-400">
                                <input type="checkbox" name="remove_image" value="1" class="mr-1">
                                Supprimer l'image
                            </label>
                        </div>
                    </div>
                    @endif
                    
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <div class="relative">
                            <input type="file" id="image" name="image" accept="image/*"
                                class="relative block w-full px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-300 hover:border-cyan-400 dark:hover:border-cyan-600 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gradient-to-r file:from-blue-50 file:to-cyan-50 dark:file:from-blue-900/20 dark:file:to-cyan-900/20 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-gradient-to-r hover:file:from-blue-100 hover:file:to-cyan-100">
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Formats acceptés : JPG, PNG, GIF, WebP. Taille max : 5MB</p>
                    @error('image')
                        <p class="mt-2 text-sm text-red-500 dark:text-red-400 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                    
                    <!-- Image Preview -->
                    <div id="image-preview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Prévisualisation :</p>
                        <div class="w-32 h-32 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                            <img id="preview-image" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('articles.show', $article) }}" 
                   class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition-colors duration-300">
                    <i class="fas fa-eye"></i>
                    <span>Voir les détails</span>
                </a>
                
                <div class="flex space-x-3">
                    <a href="{{ route('articles.index') }}"
                       class="relative group overflow-hidden px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-800 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-400 to-gray-300 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <i class="fas fa-times relative z-10"></i>
                        <span class="relative z-10 font-medium">Annuler</span>
                    </a>
                    
                    <button type="submit"
                        class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-save relative z-10"></i>
                        <span class="relative z-10 font-semibold">Mettre à jour</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
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
    
    /* Custom file input styling */
    input[type="file"]::file-selector-button {
        background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 50%, #10b981 100%);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }
    
    input[type="file"]::file-selector-button:hover {
        background: linear-gradient(135deg, #2563eb 0%, #0891b2 50%, #059669 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    /* Smooth transitions */
    * {
        transition: all 0.2s ease-in-out;
    }
    
    /* Stock status badges */
    .stock-status-low {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        color: #dc2626;
    }
    
    .dark .stock-status-low {
        background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);
        color: #fca5a5;
    }
    
    .stock-status-medium {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        color: #d97706;
    }
    
    .dark .stock-status-medium {
        background: linear-gradient(135deg, #78350f 0%, #92400e 100%);
        color: #fbbf24;
    }
    
    .stock-status-high {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #059669;
    }
    
    .dark .stock-status-high {
        background: linear-gradient(135deg, #064e3b 0%, #047857 100%);
        color: #34d399;
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

    // Stock status indicator
    function updateStockStatus() {
        const stockInput = document.getElementById('quantite_en_stock');
        const stockStatus = document.getElementById('stock-status');
        
        if (!stockInput || !stockStatus) return;
        
        const quantity = parseInt(stockInput.value) || 0;
        
        let statusText = '';
        let statusClass = '';
        let statusIcon = '';
        
        if (quantity === 0) {
            statusText = 'Rupture de stock';
            statusClass = 'stock-status-low';
            statusIcon = 'fas fa-times-circle';
        } else if (quantity < 10) {
            statusText = 'Stock faible';
            statusClass = 'stock-status-low';
            statusIcon = 'fas fa-exclamation-triangle';
        } else if (quantity < 50) {
            statusText = 'Stock moyen';
            statusClass = 'stock-status-medium';
            statusIcon = 'fas fa-info-circle';
        } else {
            statusText = 'Bon stock';
            statusClass = 'stock-status-high';
            statusIcon = 'fas fa-check-circle';
        }
        
        stockStatus.innerHTML = `
            <i class="${statusIcon} mr-2"></i>
            <span class="px-3 py-1 text-xs font-bold rounded-full ${statusClass}">
                ${statusText} (${quantity})
            </span>
        `;
    }

    // Description character counter
    function updateDescriptionCounter() {
        const descriptionInput = document.getElementById('description');
        const counter = document.getElementById('description-counter');
        
        if (descriptionInput && counter) {
            const length = descriptionInput.value.length;
            counter.textContent = `${length}/500`;
            
            if (length > 500) {
                counter.classList.add('text-red-500', 'dark:text-red-400');
                counter.classList.remove('text-gray-500', 'dark:text-gray-400');
            } else {
                counter.classList.remove('text-red-500', 'dark:text-red-400');
                counter.classList.add('text-gray-500', 'dark:text-gray-400');
            }
        }
    }

    // Image preview
    function setupImagePreview() {
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('image-preview');
        const previewImage = document.getElementById('preview-image');
        
        if (imageInput && previewContainer && previewImage) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.classList.add('hidden');
                }
            });
        }
    }

    // Price formatting
    function formatPrice() {
        const priceInput = document.getElementById('prix');
        if (priceInput) {
            priceInput.addEventListener('blur', function() {
                const value = parseFloat(this.value);
                if (!isNaN(value)) {
                    this.value = value.toFixed(2);
                }
            });
        }
    }

    // Initialize all functions
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize stock status
        updateStockStatus();
        document.getElementById('quantite_en_stock').addEventListener('input', updateStockStatus);
        
        // Initialize description counter
        updateDescriptionCounter();
        document.getElementById('description').addEventListener('input', updateDescriptionCounter);
        
        // Initialize image preview
        setupImagePreview();
        
        // Initialize price formatting
        formatPrice();
        
        // Add gradient focus effect
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-blue-500/20');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-blue-500/20');
            });
        });
        
        // Form validation on submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500', 'dark:border-red-500');
                    } else {
                        field.classList.remove('border-red-500', 'dark:border-red-500');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires (*)');
                }
            });
        }
    });

    // Auto-format reference to uppercase
    document.getElementById('ref_article').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });

    // Auto-format unit
    document.getElementById('unité').addEventListener('input', function(e) {
        const commonUnits = ['KG', 'L', 'M', 'PCE', 'UNITE', 'PAQUET', 'CARTON'];
        const value = this.value.toUpperCase();
        
        // Auto-complete common units
        if (commonUnits.some(unit => unit.startsWith(value) && value.length >= 2)) {
            const matchingUnit = commonUnits.find(unit => unit.startsWith(value));
            this.value = matchingUnit;
        }
    });
</script>
@endpush