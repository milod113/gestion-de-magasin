@extends('layouts.app')

@section('title', 'Ajouter une Catégorie')
@section('subtitle', 'Créer une nouvelle catégorie d\'articles')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Enhanced Header -->
    <div class="mb-8">
        <div class="flex flex-col space-y-6">
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-purple-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300 group">
                            <i class="ti ti-home mr-2 group-hover:scale-110 transition-transform"></i>
                            Tableau de bord
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ti ti-chevron-right text-gray-400 mx-1"></i>
                            <a href="{{ route('categories.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-purple-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300">
                                Gestion des catégories
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="ti ti-chevron-right text-gray-400 mx-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Nouvelle catégorie</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Main Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-purple-500 via-indigo-500 to-blue-400 rounded-2xl blur opacity-25"></div>
                        <div class="relative bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 p-4 rounded-2xl shadow-lg">
                            <i class="ti ti-tag-plus text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 bg-clip-text text-transparent">
                            Nouvelle Catégorie
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-2 animate-pulse"></span>
                            Créez une nouvelle catégorie pour vos articles
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Container -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Header with Gradient -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50/30 via-indigo-50/20 to-blue-50/30 dark:from-purple-900/10 dark:via-indigo-900/10 dark:to-blue-900/10">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-purple-500 to-indigo-400 flex items-center justify-center">
                    <i class="ti ti-edit text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Formulaire de création</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Remplissez les informations de la catégorie</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column - Basic Information -->
                    <div class="space-y-6">
                        <!-- Card Container -->
                        <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 flex items-center justify-center">
                                    <i class="ti ti-info-circle text-purple-600 dark:text-purple-300"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informations de base</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Détails essentiels de la catégorie</p>
                                </div>
                            </div>
                            
                            <!-- Designation Field -->
                            <div class="space-y-2">
                                <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                    <i class="ti ti-tag text-purple-400 mr-2 text-sm"></i>
                                    Désignation*
                                </label>
                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 rounded-xl blur opacity-0 group-hover:opacity-20 transition duration-300"></div>
                                    <input type="text" id="designation" name="designation" required
                                        class="relative w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 dark:placeholder-gray-500"
                                        placeholder="Ex: Informatique, Mobilier, Équipement...">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="ti ti-asterisk text-xs text-red-400"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Champ obligatoire. Nom unique pour la catégorie.</p>
                            </div>
                            
                            <!-- Description Field -->
                            <div class="space-y-2 mt-6">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                    <i class="ti ti-align-left text-indigo-400 mr-2 text-sm"></i>
                                    Description
                                </label>
                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 rounded-xl blur opacity-0 group-hover:opacity-20 transition duration-300"></div>
                                    <textarea id="description" name="description" rows="4"
                                        class="relative w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 dark:placeholder-gray-500 resize-none"
                                        placeholder="Décrivez brièvement cette catégorie..."></textarea>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Optionnel. Description détaillée de la catégorie.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Image Upload -->
                    <div class="space-y-6">
                        <!-- Image Upload Card -->
                        <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                                    <i class="ti ti-photo text-blue-600 dark:text-blue-300"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Image de la catégorie</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Téléchargez une image représentative</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <!-- Image Preview -->
                                <div id="imagePreview" class="hidden">
                                    <div class="relative group">
                                        <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 rounded-xl blur opacity-20"></div>
                                        <div class="relative">
                                            <img id="previewImage" class="w-full h-48 object-cover rounded-lg border-2 border-white dark:border-gray-700 shadow-lg">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-lg"></div>
                                            <button type="button" id="removeImage" class="absolute top-3 right-3 bg-gradient-to-r from-red-500 to-orange-500 text-white p-2 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                                <i class="ti ti-x text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-center">Image sélectionnée</p>
                                </div>
                                
                                <!-- Upload Box -->
                                <div id="uploadBox">
                                    <label for="image" class="block">
                                        <div class="relative group cursor-pointer">
                                            <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 rounded-xl blur opacity-0 group-hover:opacity-30 transition duration-300"></div>
                                            <div class="relative flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                                <div class="flex flex-col items-center justify-center p-6 text-center">
                                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-100 to-indigo-100 dark:from-purple-900/30 dark:to-indigo-900/30 flex items-center justify-center mb-3">
                                                        <i class="ti ti-cloud-upload text-xl text-purple-600 dark:text-purple-300"></i>
                                                    </div>
                                                    <p class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        Cliquez pour télécharger
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        ou glissez-déposez votre image
                                                    </p>
                                                    <div class="mt-3 px-3 py-1 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-full">
                                                        <p class="text-xs text-gray-600 dark:text-gray-300">
                                                            PNG, JPG, JPEG (Max. 2MB)
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="image" name="image" type="file" class="hidden" accept="image/*">
                                    </label>
                                </div>
                                
                                <!-- Upload Error -->
                                <div id="uploadError" class="hidden">
                                    <div class="flex items-center p-3 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-r from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 flex items-center justify-center mr-3">
                                            <i class="ti ti-alert-circle text-red-600 dark:text-red-300 text-sm"></i>
                                        </div>
                                        <p id="errorMessage" class="text-sm text-red-700 dark:text-red-300"></p>
                                    </div>
                                </div>
                                
                                <!-- Upload Guidelines -->
                                <div class="mt-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800/30 dark:to-gray-900/30 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                        <i class="ti ti-info-circle text-blue-400 mr-2"></i>
                                        Recommandations
                                    </h4>
                                    <ul class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                                        <li class="flex items-start">
                                            <i class="ti ti-circle-check text-green-400 mr-2 mt-0.5 text-xs"></i>
                                            <span>Dimensions optimales : 800x600 pixels</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="ti ti-circle-check text-green-400 mr-2 mt-0.5 text-xs"></i>
                                            <span>Format carré recommandé</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="ti ti-circle-check text-green-400 mr-2 mt-0.5 text-xs"></i>
                                            <span>Utilisez des images claires et professionnelles</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <i class="ti ti-info-circle text-blue-400 mr-2"></i>
                            <span>Les champs marqués d'un * sont obligatoires</span>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('categories.index') }}" 
                               class="relative group overflow-hidden bg-gradient-to-r from-gray-600 via-gray-500 to-gray-400 hover:from-gray-700 hover:via-gray-600 hover:to-gray-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                <div class="absolute inset-0 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <i class="ti ti-x relative z-10"></i>
                                <span class="relative z-10 font-semibold">Annuler</span>
                            </a>
                            
                            <button type="submit"
                                    class="relative group overflow-hidden bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-400 hover:from-purple-700 hover:via-indigo-600 hover:to-blue-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-700 via-indigo-600 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <i class="ti ti-device-floppy relative z-10"></i>
                                <span class="relative z-10 font-semibold">Créer la catégorie</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if ($errors->any())
<div id="error-notification" class="fixed top-4 right-4 z-50 animate-slide-in">
    <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/30 dark:to-orange-900/30 border border-red-200 dark:border-red-800 rounded-xl shadow-lg p-4 max-w-sm">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-red-400 to-orange-500 flex items-center justify-center">
                <i class="ti ti-alert-circle text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-red-800 dark:text-red-200 mb-1">Veuillez corriger les erreurs suivantes :</p>
                <ul class="text-xs text-red-700 dark:text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-start">
                            <i class="ti ti-circle-x text-red-400 mr-2 mt-0.5 text-xs"></i>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
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
    @keyframes slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-slide-in { animation: slide-in 0.3s ease-out forwards; }
    
    input, textarea {
        transition: all 0.2s ease;
    }
    
    input:focus, textarea:focus {
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
    
    .dark input:focus, .dark textarea:focus {
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
    }
    
    #uploadBox label:hover div {
        border-color: #8b5cf6;
    }
    
    .dark #uploadBox label:hover div {
        border-color: #a78bfa;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image upload preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const uploadBox = document.getElementById('uploadBox');
    const removeImage = document.getElementById('removeImage');
    const uploadError = document.getElementById('uploadError');
    const errorMessage = document.getElementById('errorMessage');

    // Drag and drop functionality
    const uploadArea = uploadBox.querySelector('label');
    
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
        uploadArea.querySelector('div > div').classList.add('border-purple-400', 'dark:border-purple-500');
    }

    function unhighlight() {
        uploadArea.querySelector('div > div').classList.remove('border-purple-400', 'dark:border-purple-500');
    }

    uploadArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    imageInput.addEventListener('change', function(event) {
        handleFiles(event.target.files);
    });

    function handleFiles(files) {
        const file = files[0];
        
        if (file) {
            // Validate file type and size
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (!validTypes.includes(file.type)) {
                errorMessage.textContent = 'Format de fichier non supporté. Veuillez télécharger une image JPEG ou PNG.';
                uploadError.classList.remove('hidden');
                return;
            }
            
            if (file.size > maxSize) {
                errorMessage.textContent = 'La taille du fichier ne doit pas dépasser 2MB.';
                uploadError.classList.remove('hidden');
                return;
            }
            
            uploadError.classList.add('hidden');
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.classList.remove('hidden');
                uploadBox.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    removeImage.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.classList.add('hidden');
        uploadBox.classList.remove('hidden');
    });

    // Auto-remove error notifications
    const errorNotification = document.getElementById('error-notification');
    if (errorNotification) {
        setTimeout(() => errorNotification.remove(), 8000);
    }
});
</script>
@endpush