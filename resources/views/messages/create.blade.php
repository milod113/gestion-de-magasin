@extends('layouts.app')

@section('title', 'Nouveau Message')
@section('subtitle', 'Rédiger et envoyer un nouveau message')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                    <i class="ti ti-home mr-1"></i>
                    Dashboard
                </a>
            </li>
            <li class="flex items-center">
                <i class="ti ti-chevron-right text-gray-400 dark:text-gray-500 mx-1"></i>
                <a href="{{ route('messages.inbox') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                    <i class="ti ti-mail mr-1"></i>
                    Messages
                </a>
            </li>
            <li class="flex items-center">
                <i class="ti ti-chevron-right text-gray-400 dark:text-gray-500 mx-1"></i>
                <span class="text-gray-600 dark:text-gray-300 font-medium">
                    <i class="ti ti-pencil mr-1"></i>
                    Nouveau Message
                </span>
            </li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-xl border border-blue-100 dark:border-gray-700 p-6 mb-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-blue-500 to-indigo-500 blur-lg opacity-20"></div>
                    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-500 p-3 rounded-lg shadow-lg">
                        <i class="ti ti-pencil text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Rédiger un nouveau message</h1>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">
                        Envoyez un message à vos collègues avec des pièces jointes
                    </p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('messages.inbox') }}"
                   class="group relative overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-lg font-medium hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-mail relative z-10"></i>
                    <span class="relative z-10">Boîte de réception</span>
                </a>

                <a href="{{ route('messages.sent') }}"
                   class="group relative overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-lg font-medium hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-send relative z-10"></i>
                    <span class="relative z-10">Messages envoyés</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Messages d'alerte -->
    @if (session('success'))
    <div id="success-alert" class="mb-6 animate-slide-in">
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border border-green-200 dark:border-green-800 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center">
                        <i class="ti ti-check text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                        <p class="text-sm text-green-600 dark:text-green-400">Le message a été envoyé avec succès</p>
                    </div>
                </div>
                <button onclick="document.getElementById('success-alert').remove()"
                        class="text-green-400 hover:text-green-600 dark:hover:text-green-300">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div id="error-alert" class="mb-6 animate-slide-in">
        <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/30 dark:to-orange-900/30 border border-red-200 dark:border-red-800 rounded-xl p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-red-400 to-orange-500 flex items-center justify-center">
                        <i class="ti ti-alert-circle text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="font-medium text-red-800 dark:text-red-200">Veuillez corriger les erreurs suivantes :</p>
                        <ul class="mt-1 text-sm text-red-600 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center space-x-1">
                                    <i class="ti ti-point text-xs"></i>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button onclick="document.getElementById('error-alert').remove()"
                        class="text-red-400 hover:text-red-600 dark:hover:text-red-300">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Formulaire principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Carte du formulaire -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <!-- En-tête de la carte -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-500 flex items-center justify-center">
                            <i class="ti ti-pencil text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Composer votre message</h3>
                    </div>
                </div>

                <!-- Corps du formulaire -->
                <div class="p-6">
                    <form method="POST" action="{{ route('messages.store') }}" enctype="multipart/form-data" id="message-form">
                        @csrf

                        <!-- Destinataire -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-user mr-2 text-blue-500"></i>
                                Destinataire
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <select name="recipient_id"
                                        class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all duration-200 appearance-none"
                                        required>
                                    <option value="">-- Sélectionner un utilisateur --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                                @selected(old('recipient_id') == $user->id)
                                                class="py-2">
                                            {{ $user->name }}
                                            @if($user->roles->count())
                                                <span class="text-gray-500 dark:text-gray-400">
                                                    ({{ $user->roles->pluck('name')->join(', ') }})
                                                </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">
                                                    (aucun rôle)
                                                </span>
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                    <i class="ti ti-users"></i>
                                </div>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                    <i class="ti ti-chevron-down"></i>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Sélectionnez le destinataire de votre message
                            </p>
                        </div>

                        <!-- Sujet -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-tag mr-2 text-blue-500"></i>
                                Sujet
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="sujet"
                                       value="{{ old('sujet') }}"
                                       class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all duration-200"
                                       placeholder="Entrez le sujet de votre message"
                                       required>
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                    <i class="ti ti-heading"></i>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Un sujet clair aide le destinataire à comprendre rapidement le contenu
                            </p>
                        </div>

                        <!-- Contenu -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-message-circle mr-2 text-blue-500"></i>
                                Contenu du message
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <textarea name="contenu"
                                          rows="8"
                                          class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all duration-200"
                                          placeholder="Rédigez votre message ici..."
                                          required>{{ old('contenu') }}</textarea>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Soyez clair et concis dans votre message
                                </p>
                                <span id="char-count" class="text-sm text-gray-400 dark:text-gray-500">0 caractères</span>
                            </div>
                        </div>

                        <!-- Pièces jointes -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-paperclip mr-2 text-blue-500"></i>
                                Pièces jointes
                            </label>

                            <!-- Zone de dépôt -->
                            <div id="drop-zone"
                                 class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center transition-all duration-300 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 cursor-pointer">
                                <input type="file"
                                       name="attachments[]"
                                       id="file-input"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       multiple>

                                <div class="space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 flex items-center justify-center mx-auto">
                                        <i class="ti ti-cloud-upload text-blue-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-700 dark:text-gray-300">
                                            Glissez-déposez vos fichiers ici
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            ou cliquez pour sélectionner
                                        </p>
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                        Formats supportés: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, ZIP
                                        <br>
                                        Taille maximale: 10MB par fichier
                                    </div>
                                </div>
                            </div>

                            <!-- Liste des fichiers sélectionnés -->
                            <div id="file-list" class="mt-4 space-y-2 hidden">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Fichiers sélectionnés :</p>
                                <div id="selected-files" class="space-y-2"></div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit"
                                    class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-500 hover:from-blue-700 hover:via-indigo-600 hover:to-purple-600 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2 flex-1">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <i class="ti ti-send relative z-10"></i>
                                <span class="relative z-10 font-semibold">Envoyer le message</span>
                            </button>

                            <a href="{{ route('messages.inbox') }}"
                               class="group relative overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg font-medium hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2 flex-1">
                                <div class="absolute inset-0 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <i class="ti ti-x relative z-10"></i>
                                <span class="relative z-10">Annuler</span>
                            </a>

                            <button type="button"
                                    onclick="saveAsDraft()"
                                    class="group relative overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg font-medium hover:border-yellow-300 dark:hover:border-yellow-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2 flex-1">
                                <div class="absolute inset-0 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/10 dark:to-amber-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <i class="ti ti-device-floppy relative z-10"></i>
                                <span class="relative z-10">Sauvegarder comme brouillon</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar d'aide -->
        <div class="space-y-6">
            <!-- Conseils -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-green-500 to-emerald-400 flex items-center justify-center">
                        <i class="ti ti-bulb text-white text-sm"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Conseils d'écriture</h4>
                </div>

                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <i class="ti ti-check text-green-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Sujet clair</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Un bon sujet résume l'essentiel</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <i class="ti ti-check text-green-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Message structuré</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Utilisez des paragraphes courts</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <i class="ti ti-check text-green-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Pièces jointes</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Nommez les fichiers clairement</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <i class="ti ti-check text-green-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Relecture</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Relisez avant d'envoyer</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="ti ti-info-circle text-white text-sm"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Informations</h4>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Destinataires disponibles</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ count($users) }}</p>
                    </div>

                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Limitations</p>
                        <ul class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                            <li class="flex items-center space-x-1">
                                <i class="ti ti-file-text text-gray-400"></i>
                                <span>Taille max par fichier: 10MB</span>
                            </li>
                            <li class="flex items-center space-x-1">
                                <i class="ti ti-files text-gray-400"></i>
                                <span>Nombre max de fichiers: 5</span>
                            </li>
                            <li class="flex items-center space-x-1">
                                <i class="ti ti-clock text-gray-400"></i>
                                <span>Brouillons conservés 30 jours</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Aperçu rapide -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-purple-500 to-pink-400 flex items-center justify-center">
                        <i class="ti ti-eye text-white text-sm"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Aperçu</h4>
                </div>

                <div class="space-y-3">
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center mx-auto mb-2">
                            <i class="ti ti-mail text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Votre message apparaîtra ici après rédaction
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @keyframes slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-slide-in { animation: slide-in 0.3s ease-out forwards; }

    #drop-zone.dragover {
        border-color: #3b82f6;
        background-color: rgba(59, 130, 246, 0.05);
    }

    .file-item {
        transition: all 0.2s ease;
    }

    .file-item:hover {
        transform: translateX(4px);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts
    setTimeout(() => {
        const alerts = ['success-alert', 'error-alert'];
        alerts.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.remove();
        });
    }, 5000);

    // Character counter for textarea
    const textarea = document.querySelector('textarea[name="contenu"]');
    const charCount = document.getElementById('char-count');

    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length + ' caractères';
        });
        // Initial count
        charCount.textContent = textarea.value.length + ' caractères';
    }

    // File upload with drag and drop
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    const fileList = document.getElementById('file-list');
    const selectedFiles = document.getElementById('selected-files');

    if (dropZone && fileInput) {
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop zone when dragging over
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropZone.classList.add('dragover');
        }

        function unhighlight() {
            dropZone.classList.remove('dragover');
        }

        // Handle dropped files
        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        // Handle file input change
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            selectedFiles.innerHTML = '';

            if (files.length > 0) {
                fileList.classList.remove('hidden');

                Array.from(files).forEach((file, index) => {
                    if (file.size > 10 * 1024 * 1024) {
                        showError(`Le fichier "${file.name}" dépasse 10MB`);
                        return;
                    }

                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex items-center justify-between';

                    fileItem.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-md bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 flex items-center justify-center">
                                <i class="ti ti-file text-blue-500 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate max-w-[180px]">
                                    ${file.name}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    ${formatBytes(file.size)}
                                </p>
                            </div>
                        </div>
                        <button type="button" onclick="removeFile(${index})" class="text-red-400 hover:text-red-600">
                            <i class="ti ti-x"></i>
                        </button>
                    `;

                    selectedFiles.appendChild(fileItem);
                });
            } else {
                fileList.classList.add('hidden');
            }
        }

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
    }
});

// Remove file from list
function removeFile(index) {
    const fileInput = document.getElementById('file-input');
    const dt = new DataTransfer();
    const files = fileInput.files;

    Array.from(files).forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });

    fileInput.files = dt.files;

    // Update file list display
    handleFiles(fileInput.files);
}

// Helper function for file display
function handleFiles(files) {
    const fileList = document.getElementById('file-list');
    const selectedFiles = document.getElementById('selected-files');

    selectedFiles.innerHTML = '';

    if (files.length > 0) {
        fileList.classList.remove('hidden');

        Array.from(files).forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex items-center justify-between';

            fileItem.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-md bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 flex items-center justify-center">
                        <i class="ti ti-file text-blue-500 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate max-w-[180px]">
                            ${file.name}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            ${formatBytes(file.size)}
                        </p>
                    </div>
                </div>
                <button type="button" onclick="removeFile(${index})" class="text-red-400 hover:text-red-600">
                    <i class="ti ti-x"></i>
                </button>
            `;

            selectedFiles.appendChild(fileItem);
        });
    } else {
        fileList.classList.add('hidden');
    }
}

function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function showError(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-3 mb-3';
    alertDiv.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="ti ti-alert-circle text-red-500"></i>
            <span class="text-sm text-red-700 dark:text-red-300">${message}</span>
        </div>
    `;

    const form = document.getElementById('message-form');
    form.insertBefore(alertDiv, form.firstChild);

    setTimeout(() => alertDiv.remove(), 5000);
}

function saveAsDraft() {
    // You can implement draft saving logic here
    const form = document.getElementById('message-form');
    const formData = new FormData(form);

    // Add draft flag
    formData.append('draft', 'true');

    // For now, just show a message
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/30 dark:to-amber-900/30 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 shadow-lg z-50 animate-slide-in';
    toast.innerHTML = `
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-yellow-400 to-amber-500 flex items-center justify-center">
                <i class="ti ti-device-floppy text-white text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Brouillon sauvegardé</p>
                <p class="text-xs text-yellow-600 dark:text-yellow-400">Votre message a été sauvegardé comme brouillon</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-yellow-400 hover:text-yellow-600">
                <i class="ti ti-x"></i>
            </button>
        </div>
    `;

    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>
@endpush
