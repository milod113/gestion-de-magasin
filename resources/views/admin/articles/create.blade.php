@extends('layouts.app')

@section('title', 'Ajouter un Article')
@section('subtitle', 'Créer un nouvel article dans le stock')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 border border-gray-100 dark:border-gray-700">
        <!-- Form Header -->
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-red-50/40 via-orange-50/30 to-amber-50/30 dark:from-red-900/20 dark:via-orange-900/20 dark:to-amber-900/20">
            <div class="flex items-center space-x-4">
                <!-- Icon with brand gradient -->
                <div class="relative">
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-red-500 via-orange-500 to-amber-400 blur-lg opacity-30"></div>
                    <div class="relative bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 p-3 rounded-xl shadow-lg">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Nouvel Article</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Remplissez les détails du nouvel article</p>
                </div>
            </div>
        </div>
        
        <!-- Form Content -->
        <div class="p-6">
            <form action="{{ route('articles.store') }}" method="POST" class="space-y-8" enctype="multipart/form-data">
                @csrf
                
                <!-- Image Upload Section -->
                <div class="space-y-4">
                    <label class="block text-lg font-semibold text-gray-900 dark:text-white flex items-center space-x-3">
                        <div class="w-2 h-8 rounded-full bg-gradient-to-b from-red-500 to-orange-400"></div>
                        <span>Image de l'article</span>
                    </label>
                    
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 rounded-2xl blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        
                        <div class="relative">
                            <input id="image-upload" name="image" type="file" accept="image/*" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <div class="h-40 rounded-xl border-3 border-dashed border-gray-300 dark:border-gray-600 bg-gradient-to-br from-gray-50 to-gray-100/50 dark:from-gray-800/50 dark:to-gray-900/50 overflow-hidden transition-all duration-300 group-hover:border-orange-400 group-hover:shadow-lg flex items-center justify-center">
                                <img id="image-preview" src="" alt="" class="hidden h-full w-full object-cover">
                                
                                <div id="upload-placeholder" class="text-center p-6 space-y-4">
                                    <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-amber-500"></i>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Glissez-déposez ou cliquez</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 mt-1">Format JPEG, PNG, WEBP - Max 5MB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Reference Field -->
                    <div class="space-y-3">
                        <label for="ref_article" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-hashtag text-red-500"></i>
                                <span>Référence*</span>
                            </span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-fingerprint text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <input type="text" id="ref_article" name="ref_article" required
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:text-white transition-all duration-300 hover:border-orange-300 dark:hover:border-orange-600"
                                    placeholder="REF-001">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Designation Field -->
                    <div class="space-y-3">
                        <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-tag text-orange-500"></i>
                                <span>Désignation*</span>
                            </span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <input type="text" id="designation" name="designation" required
                                class="relative block w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:text-white transition-all duration-300 hover:border-orange-300 dark:hover:border-orange-600"
                                placeholder="Nom de l'article">
                        </div>
                    </div>
                    
                    <!-- Quantity Field -->
                    <div class="space-y-3">
                        <label for="quantite_en_stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-boxes text-amber-500"></i>
                                <span>Quantité en stock*</span>
                            </span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-layer-group text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <input type="number" id="quantite_en_stock" name="quantite_en_stock" required
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:text-white transition-all duration-300 hover:border-orange-300 dark:hover:border-orange-600"
                                    placeholder="0" min="0">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Unit Field -->
                    <div class="space-y-3">
                        <label for="unité" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-balance-scale text-red-500"></i>
                                <span>Unité*</span>
                            </span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-ruler text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <input type="text" id="unité" name="unité" required
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:text-white transition-all duration-300 hover:border-orange-300 dark:hover:border-orange-600"
                                    placeholder="kg, L, pièce...">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Price Field -->
                    <div class="space-y-3">
                        <label for="prix" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-money-bill-wave text-orange-500"></i>
                                <span>Prix*</span>
                            </span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-dollar-sign text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <input type="number" id="prix" name="prix" required step="0.01" min="0"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:text-white transition-all duration-300 hover:border-orange-300 dark:hover:border-orange-600"
                                    placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">DH</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Category Field -->
                    <div class="space-y-3">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-sitemap text-amber-500"></i>
                                <span>Catégorie*</span>
                            </span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="relative">
                                <select id="category_id" name="category_id" required
                                    class="block w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:text-white transition-all duration-300 hover:border-orange-300 dark:hover:border-orange-600 appearance-none">
                                    <option value="" disabled selected class="text-gray-500 dark:text-gray-400">Sélectionnez une catégorie</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id_categorie }}">{{ $categorie->designation }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400 dark:text-gray-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Field -->
                <div class="space-y-3">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center space-x-2">
                        <i class="fas fa-align-left text-red-500"></i>
                        <span>Description</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 rounded-lg blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <textarea id="description" name="description" rows="4"
                            class="relative block w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:text-white transition-all duration-300 hover:border-orange-300 dark:hover:border-orange-600 resize-y"
                            placeholder="Description détaillée de l'article..."></textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <!-- Cancel Button -->
                    <a href="{{ route('articles.index') }}"
                        class="group relative overflow-hidden px-6 py-3 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 dark:hover:from-gray-700 dark:hover:to-gray-800 transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center space-x-2 w-full sm:w-auto justify-center">
                        <i class="fas fa-times text-gray-500 dark:text-gray-400 group-hover:text-red-500 transition-colors"></i>
                        <span class="font-semibold">Annuler</span>
                    </a>
                    
                    <!-- Submit Button -->
                    <button type="submit"
                        class="group relative overflow-hidden bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 hover:from-red-700 hover:via-orange-600 hover:to-amber-500 text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 w-full sm:w-auto justify-center">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-save relative z-10 text-lg"></i>
                        <span class="relative z-10">Enregistrer l'article</span>
                    </button>
                </div>
            </form>
        </div>
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
    
    /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
        width: 8px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    
    .dark textarea::-webkit-scrollbar-track {
        background: #1f2937;
    }
    
    .dark textarea::-webkit-scrollbar-thumb {
        background: #4b5563;
    }
    
    /* File upload area animation */
    #upload-placeholder {
        transition: all 0.3s ease;
    }
    
    .group:hover #upload-placeholder {
        transform: scale(1.02);
    }
    
    /* Required field indicator */
    label span:after {
        content: " *";
        color: #ef4444;
    }
    
    /* Input focus glow effect */
    input:focus, select:focus, textarea:focus {
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
    }
    
    .dark input:focus, .dark select:focus, .dark textarea:focus {
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.3);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageUpload = document.getElementById('image-upload');
    const imagePreview = document.getElementById('image-preview');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const uploadArea = imageUpload.closest('.group');

    imageUpload.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Le fichier est trop volumineux (max 5MB)');
                this.value = '';
                return;
            }

            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Format de fichier non supporté. Utilisez JPEG, PNG ou WEBP.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                uploadPlaceholder.classList.add('hidden');
                uploadArea.classList.add('border-green-400', 'dark:border-green-600');
                
                // Add success animation
                uploadArea.style.animation = 'pulse 2s';
                setTimeout(() => {
                    uploadArea.style.animation = '';
                }, 2000);
            }
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        uploadArea.classList.add('border-orange-400', 'dark:border-orange-600', 'bg-gradient-to-br', 'from-orange-50', 'to-amber-50', 'dark:from-orange-900/10', 'dark:to-amber-900/10');
    }

    function unhighlight() {
        uploadArea.classList.remove('border-orange-400', 'dark:border-orange-600', 'bg-gradient-to-br', 'from-orange-50', 'to-amber-50', 'dark:from-orange-900/10', 'dark:to-amber-900/10');
    }

    uploadArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        imageUpload.files = files;
        imageUpload.dispatchEvent(new Event('change'));
    }

    // Auto-hide notifications after 5 seconds
    const notifications = ['notification', 'error-notification'];
    notifications.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            setTimeout(() => {
                if (element) element.remove();
            }, 5000);
        }
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('border-red-500', 'dark:border-red-500');
                isValid = false;
                
                // Add shake animation
                field.style.animation = 'shake 0.5s';
                setTimeout(() => {
                    field.style.animation = '';
                }, 500);
            } else {
                field.classList.remove('border-red-500', 'dark:border-red-500');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires (*)');
        }
    });

    // Remove red border when user starts typing
    form.querySelectorAll('[required]').forEach(field => {
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('border-red-500', 'dark:border-red-500');
            }
        });
    });

    // Price field formatting
    const priceField = document.getElementById('prix');
    priceField.addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
});
</script>
@endpush