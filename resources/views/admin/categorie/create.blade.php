@extends('layouts.app')

@section('title', 'Ajouter une Catégorie')
@section('subtitle', 'Créer une nouvelle catégorie d\'articles')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Nouvelle Catégorie</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Définissez une nouvelle catégorie pour vos articles</p>
    </div>
    
    <div class="p-6">
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
  <div class="space-y-6">
    <!-- Designation Field -->
    <div>
        <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Désignation*</label>
        <div class="relative">
            <input type="text" id="designation" name="designation" required
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200"
                placeholder="Nom de la catégorie">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <i class="ti ti-tag text-gray-400 dark:text-gray-500"></i>
            </div>
        </div>
    </div>

    <!-- Description Field -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
        <textarea id="description" name="description" rows="3"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200"
            placeholder="Description de la catégorie"></textarea>
    </div>
</div>

                <!-- Right Column - Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image de la catégorie</label>
                    <div class="mt-1 flex flex-col items-center">
                        <!-- Image Preview -->
                        <div id="imagePreview" class="mb-4 hidden">
                            <div class="relative group">
                                <img id="previewImage" class="h-48 w-full object-cover rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                                <button type="button" id="removeImage" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <i class="ti ti-x text-sm"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Upload Box -->
                        <div id="uploadBox" class="w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center">
                                    <i class="ti ti-cloud-upload text-3xl text-gray-400 mb-2"></i>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PNG, JPG (Max. 2MB)
                                    </p>
                                </div>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*">
                            </label>
                        </div>
                        
                        <!-- Upload Error -->
                        <p id="uploadError" class="mt-1 text-xs text-red-500 hidden"></p>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('categories.index') }}" class="btn-secondary">
                    <i class="ti ti-x mr-2"></i> Annuler
                </a>
                <button type="submit" class="btn-primary">
                    <i class="ti ti-device-floppy mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

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

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (file) {
                // Validate file type and size
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!validTypes.includes(file.type)) {
                    uploadError.textContent = 'Format de fichier non supporté. Veuillez télécharger une image JPEG ou PNG.';
                    uploadError.classList.remove('hidden');
                    return;
                }
                
                if (file.size > maxSize) {
                    uploadError.textContent = 'La taille du fichier ne doit pas dépasser 2MB.';
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
        });

        removeImage.addEventListener('click', function() {
            imageInput.value = '';
            imagePreview.classList.add('hidden');
            uploadBox.classList.remove('hidden');
        });
    });
</script>
@endpush

@push('styles')
<style>
    .btn-primary {
        @apply bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center;
    }
    
    .btn-secondary {
        @apply bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center;
    }
    
    .form-control {
        @apply block w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100;
    }
    
    textarea.form-control {
        @apply min-h-[100px];
    }
    
    #uploadBox:hover {
        @apply border-indigo-300 dark:border-indigo-500;
    }
</style>
@endpush