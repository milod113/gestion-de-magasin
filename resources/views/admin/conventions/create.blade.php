@extends('layouts.app')

@section('title', 'Créer une Nouvelle Convention')
@section('subtitle', 'Formulaire de création de convention fournisseur')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Enhanced Header -->
    <div class="mb-8">
        <div class="flex flex-col space-y-6">
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('conventions.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300 group">
                            <i class="ti ti-file-contract mr-2 group-hover:scale-110 transition-transform"></i>
                            Conventions
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="ti ti-chevron-right text-gray-400 mx-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Nouvelle convention</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Main Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-500 via-cyan-500 to-emerald-400 rounded-2xl blur opacity-25"></div>
                        <div class="relative bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-4 rounded-2xl shadow-lg">
                            <i class="ti ti-file-medical text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 bg-clip-text text-transparent">
                            Nouvelle Convention
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-cyan-500 rounded-full mr-2 animate-pulse"></span>
                            Associez un fournisseur à une année avec articles, quantités et prix convenus
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <i class="ti ti-calendar text-cyan-400"></i>
                        <span>{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Form Header with Gradient -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-cyan-50/20 to-emerald-50/30 dark:from-blue-900/10 dark:via-cyan-900/10 dark:to-emerald-900/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="ti ti-file-text text-cyan-500 text-xl mr-3"></i>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Formulaire de convention</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Remplissez les détails de la nouvelle convention</p>
                    </div>
                </div>
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-cyan-200 border border-blue-200 dark:border-cyan-800">
                    <i class="ti ti-plus mr-1"></i>Nouveau
                </span>
            </div>
        </div>

        <!-- Form Content -->
        <form action="{{ route('conventions.store') }}" method="POST" class="p-6">
            @csrf

            @if ($errors->any())
                <div class="mb-6 fade-in-up">
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border border-red-200 dark:border-red-700 rounded-xl p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="ti ti-alert-triangle text-red-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-semibold text-red-800 dark:text-red-200">Veuillez corriger les erreurs suivantes :</h3>
                                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-8">
                <!-- Convention Information Card -->
                <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                            <i class="ti ti-info-circle text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informations Générales</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Fournisseur -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-building-warehouse text-cyan-400 mr-2 text-sm"></i>
                                Fournisseur <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <select name="fournisseur_id"
                                        class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300" required>
                                    <option value="">-- Choisir un fournisseur --</option>
                                    @foreach($fournisseurs as $fournisseur)
                                        <option value="{{ $fournisseur->id_fournisseur }}"
                                            {{ old('fournisseur_id') == $fournisseur->id_fournisseur ? 'selected' : '' }}>
                                            {{ $fournisseur->sociéte ?? $fournisseur->nom }} ({{ $fournisseur->code_fournisseur ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <i class="ti ti-user-plus absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('fournisseur_id')
                            <p class="mt-2 text-xs text-red-500 fade-in-up">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Référence -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-hash text-cyan-400 mr-2 text-sm"></i>
                                Référence <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="reference"
                                       value="{{ old('reference') }}"
                                       placeholder="Ex : CONV-2024-001"
                                       class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                <i class="ti ti-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('reference')
                            <p class="mt-2 text-xs text-red-500 fade-in-up">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Année -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-calendar text-cyan-400 mr-2 text-sm"></i>
                                Année <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       name="annee"
                                       value="{{ old('annee', date('Y')) }}"
                                       class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                <i class="ti ti-calendar-time absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('annee')
                            <p class="mt-2 text-xs text-red-500 fade-in-up">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Scope (stock / equipment) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-switch-3 text-cyan-400 mr-2 text-sm"></i>
                                Type de convention <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <select name="scope" id="scopeSelect"
                                        class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                    <option value="stock" {{ old('scope', 'stock') === 'stock' ? 'selected' : '' }}>
                                        Articles de stock (habillement, literie, consommables…)
                                    </option>
                                    <option value="equipment" {{ old('scope') === 'equipment' ? 'selected' : '' }}>
                                        Équipements biomédicaux / immobilier
                                    </option>
                                </select>
                                <i class="ti ti-clipboard-list absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('scope')
                            <p class="mt-2 text-xs text-red-500 fade-in-up">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catégorie de convention - STOCK -->
                        <div id="stockCategoryGroup" class="{{ old('scope', 'stock') === 'stock' ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-category text-cyan-400 mr-2 text-sm"></i>
                                Catégorie (Articles de stock)
                            </label>
                            <div class="relative">
                                <select name="stock_category_id"
                                        class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                    <option value="">-- Choisir une catégorie d’articles --</option>
                                    @foreach($articleCategories as $cat)
                                        <option value="{{ $cat->id_categorie }}"
                                            {{ old('stock_category_id') == $cat->id_categorie ? 'selected' : '' }}>
                                            {{ $cat->designation }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="ti ti-folders absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('stock_category_id')
                            <p class="mt-2 text-xs text-red-500 fade-in-up">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catégorie de convention - EQUIPMENT -->
                        <div id="equipmentCategoryGroup" class="{{ old('scope', 'stock') === 'equipment' ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-medical-cross text-cyan-400 mr-2 text-sm"></i>
                                Catégorie (Équipements biomédicaux)
                            </label>
                            <div class="relative">
                                <select name="equipment_category_id"
                                        class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                    <option value="">-- Choisir une catégorie d’équipement --</option>
                                    @foreach($equipmentCategories as $eCat)
                                        <option value="{{ $eCat->id }}"
                                            {{ old('equipment_category_id') == $eCat->id ? 'selected' : '' }}>
                                            {{ $eCat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="ti ti-stethoscope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('equipment_category_id')
                            <p class="mt-2 text-xs text-red-500 fade-in-up">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date début -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-calendar-event text-cyan-400 mr-2 text-sm"></i>
                                Date de début
                            </label>
                            <div class="relative">
                                <input type="date"
                                       name="date_debut"
                                       value="{{ old('date_debut') }}"
                                       class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                <i class="ti ti-playlist-add absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('date_debut')
                            <p class="mt-2 text-xs text-red-500 fade-in-up">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date fin -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-calendar-due text-cyan-400 mr-2 text-sm"></i>
                                Date de fin
                            </label>
                            <div class="relative">
                                <input type="date"
                                       name="date_fin"
                                       value="{{ old('date_fin') }}"
                                       class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                <i class="ti ti-playlist-x absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('date_fin')
                            <p class="mt-2 text-xs text-red-500 fade-in-up">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-status-change text-cyan-400 mr-2 text-sm"></i>
                                Statut
                            </label>
                            <div class="relative">
                                <select name="statut"
                                        class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                    <option value="brouillon" {{ old('statut', 'brouillon') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                    <option value="actif" {{ old('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="clos" {{ old('statut') == 'clos' ? 'selected' : '' }}>Clos</option>
                                </select>
                                <i class="ti ti-circle-check absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('statut')
                            <p class="mt-2 text-xs text-red-500 fade-in-up">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="ti ti-notes text-cyan-400 mr-2 text-sm"></i>
                            Notes / Observations
                        </label>
                        <div class="relative">
                            <textarea name="notes" rows="3"
                                    class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300"
                                    placeholder="Informations complémentaires, conditions particulières, etc.">{{ old('notes') }}</textarea>
                            <i class="ti ti-message-dots absolute left-3 top-3 transform text-gray-400"></i>
                        </div>
                        @error('notes')
                        <p class="mt-2 text-xs text-red-500 fade-in-up">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- 🔹 CARD STOCK (articles de stock) --}}
                <div id="stock-lines-card" class="{{ old('scope', 'stock') === 'stock' ? '' : 'hidden' }}">
                    <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                                    <i class="ti ti-list text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Articles de la Convention</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        Ajoutez les articles avec quantités et prix convenus
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span class="font-semibold">NB :</span> cette section n’est utilisée que lorsque le type de convention est <span class="font-semibold">Articles de stock</span>.
                                    </p>
                                </div>
                            </div>
                            <div id="item-count" class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-cyan-200">
                                1 article(s)
                            </div>
                        </div>

                        <!-- Category and Article Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                            <!-- Filtre catégorie d'article -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="ti ti-category text-cyan-400 mr-2 text-sm"></i>
                                    Catégorie d’article
                                </label>
                                <div class="relative">
                                    <select id="articleCategoryFilter"
                                            class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                        <option value="">-- Toutes les catégories --</option>
                                        @foreach($articleCategories as $cat)
                                            <option value="{{ $cat->id_categorie }}">
                                                {{ $cat->designation }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="ti ti-forms absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Article -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="ti ti-package text-cyan-400 mr-2 text-sm"></i>
                                    Article <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <select id="article" 
                                            class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                        <option value="">-- Choisir article --</option>
                                        @foreach($articles as $article)
                                            <option value="{{ $article->id_article }}"
                                                    data-ref="{{ $article->ref_article }}"
                                                    data-designation="{{ $article->designation }}"
                                                    data-category-id="{{ $article->categorie->id_categorie ?? '' }}">
                                                {{ $article->ref_article }} - {{ $article->designation }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="ti ti-box absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="ti ti-sort-ascending text-blue-400 mr-2 text-sm"></i>
                                    Quantité <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" id="quantite" min="0" 
                                           class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300 text-center">
                                    <i class="ti ti-numbers absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Prix -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="ti ti-currency-dinar text-cyan-400 mr-2 text-sm"></i>
                                    Prix (DA) <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.01" id="prix" min="0"
                                           class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300 text-center">
                                    <i class="ti ti-coin absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Unité -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="ti ti-ruler-measure text-blue-400 mr-2 text-sm"></i>
                                    Unité
                                </label>
                                <div class="relative">
                                    <input type="text" id="unite" placeholder="PCS, KG..."
                                           class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                    <i class="ti ti-dimensions absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Add Button -->
                        <button type="button" id="addRow" 
                                class="relative group overflow-hidden bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 mb-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-cyan-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="ti ti-plus relative z-10"></i>
                            <span class="relative z-10 font-semibold">Ajouter l'article</span>
                        </button>

                        <!-- Table -->
                        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="detailsTable">
                                <thead class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="ti ti-hash mr-2"></i>Réf Article
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="ti ti-text-spellcheck mr-2"></i>Désignation
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="ti ti-sort-ascending mr-2"></i>Quantité
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="ti ti-currency-dinar mr-2"></i>Prix (DA)
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="ti ti-ruler-measure mr-2"></i>Unité
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <i class="ti ti-settings mr-2"></i>Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="lines-body">
                                    <!-- First row -->
                                    <tr class="line-row fade-in-up hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="hidden" name="articles[0][article_id]" value="{{ old('articles.0.article_id', '') }}">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center mr-3">
                                                    <i class="ti ti-hash text-blue-400 text-sm"></i>
                                                </div>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white" id="ref-0">
                                                    @if(old('articles.0.article_id'))
                                                        @php
                                                            $article = $articles->firstWhere('id_article', old('articles.0.article_id'));
                                                        @endphp
                                                        {{ $article->ref_article ?? '' }}
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-700 dark:text-gray-300" id="designation-0">
                                                @if(old('articles.0.article_id'))
                                                    @php
                                                        $article = $articles->firstWhere('id_article', old('articles.0.article_id'));
                                                    @endphp
                                                    {{ $article->designation ?? '' }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="hidden" name="articles[0][quantite_convenue]" value="{{ old('articles.0.quantite_convenue', '') }}">
                                            <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200">
                                                {{ old('articles.0.quantite_convenue', '0') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="hidden" name="articles[0][prix_convenu]" value="{{ old('articles.0.prix_convenu', '') }}">
                                            <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-cyan-100 to-emerald-100 dark:from-cyan-900/30 dark:to-emerald-900/30 text-cyan-800 dark:text-cyan-200">
                                                {{ number_format(old('articles.0.prix_convenu', 0), 2) }} DA
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="hidden" name="articles[0][unite]" value="{{ old('articles.0.unite', '') }}">
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                {{ old('articles.0.unite', 'PCS') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button type="button" class="remove-row relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                <i class="ti ti-trash relative z-10"></i>
                                                <span class="relative z-10 font-semibold text-sm">Supprimer</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <!-- Empty State -->
                            <div id="emptyState" class="hidden text-center py-12">
                                <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center mb-4">
                                    <i class="ti ti-package text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucun article ajouté</h3>
                                <p class="text-gray-500 dark:text-gray-400">Commencez par ajouter des articles à votre convention</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 🔹 CARD EQUIPMENT (équipements biomédicaux) --}}
                <div id="equipment-lines-card" class="{{ old('scope', 'stock') === 'equipment' ? '' : 'hidden' }}">
                    <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                                    <i class="ti ti-tools text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Équipements de la Convention</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                        Ajoutez les équipements avec quantités et prix convenus
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span class="font-semibold">NB :</span> cette section n’est utilisée que lorsque le type de convention est <span class="font-semibold">Équipements biomédicaux / immobilier</span>.
                                    </p>
                                </div>
                            </div>
                            <div id="equipment-item-count" class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-cyan-200">
                                0 équipement(s)
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                            {{-- Filtre catégorie d’équipement --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="ti ti-category text-cyan-400 mr-2 text-sm"></i>
                                    Catégorie d’équipement
                                </label>
                                <div class="relative">
                                    <select id="equipmentCategoryFilter"
                                            class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                        <option value="">-- Toutes les catégories --</option>
                                        @foreach($equipmentCategories as $eCat)
                                            <option value="{{ $eCat->id }}">
                                                {{ $eCat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="ti ti-folders absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            {{-- Équipement --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="ti ti-device-heart-monitor text-cyan-400 mr-2 text-sm"></i>
                                    Équipement <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <select id="equipmentSelect"
                                            class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                        <option value="">-- Choisir équipement --</option>
                                        @foreach($equipments as $equipment)
                                            <option value="{{ $equipment->id }}"
                                                    data-ref="{{ $equipment->reference ?? $equipment->model ?? $equipment->id }}"
                                                    data-label="{{ $equipment->label ?? $equipment->model ?? '' }}"
                                                    data-category-id="{{ $equipment->category->id ?? '' }}">
                                                {{ $equipment->reference ?? $equipment->model ?? $equipment->id }} - {{ $equipment->label ?? $equipment->model ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="ti ti-tools absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            {{-- Quantité --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="ti ti-sort-ascending text-blue-400 mr-2 text-sm"></i>
                                    Quantité <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" id="equipmentQuantite" min="0"
                                           class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300 text-center">
                                    <i class="ti ti-numbers absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            {{-- Prix --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="ti ti-currency-dinar text-cyan-400 mr-2 text-sm"></i>
                                    Prix (DA) <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.01" id="equipmentPrix" min="0"
                                           class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all durée-300 text-center">
                                    <i class="ti ti-coin absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            {{-- Unité --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="ti ti-ruler-measure text-blue-400 mr-2 text-sm"></i>
                                    Unité
                                </label>
                                <div class="relative">
                                    <input type="text" id="equipmentUnite" placeholder="PCS, unité, lot..."
                                           class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                    <i class="ti ti-dimensions absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="addEquipmentRow"
                                class="relative group overflow-hidden bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 mb-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-cyan-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="ti ti-plus relative z-10"></i>
                            <span class="relative z-10 font-semibold">Ajouter l'équipement</span>
                        </button>

                        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Réf
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Équipement
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Quantité
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Prix (DA)
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Unité
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="equipment-lines-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    {{-- lignes dynamiques équipements --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                <a href="{{ route('conventions.index') }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-gray-600 via-gray-500 to-gray-400 hover:from-gray-700 hover:via-gray-600 hover:to-gray-500 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-x relative z-10"></i>
                    <span class="relative z-10 font-semibold">Annuler</span>
                </a>
                <button type="submit" 
                        class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-check relative z-10"></i>
                    <span class="relative z-10 font-semibold">Enregistrer la convention</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const articleSelect = document.getElementById('article');
    const quantiteInput = document.getElementById('quantite');
    const prixInput = document.getElementById('prix');
    const uniteInput = document.getElementById('unite');
    const addRowBtn = document.getElementById('addRow');
    const detailsTableBody = document.querySelector('#detailsTable tbody');
    const detailsTableWrapper = document.querySelector('#detailsTable').parentElement;
    const emptyState = document.getElementById('emptyState');
    const itemCount = document.getElementById('item-count');
    const articleCategoryFilter = document.getElementById('articleCategoryFilter');

    const scopeSelect = document.getElementById('scopeSelect');
    const stockCategoryGroup = document.getElementById('stockCategoryGroup');
    const equipmentCategoryGroup = document.getElementById('equipmentCategoryGroup');
    const stockLinesCard = document.getElementById('stock-lines-card');
    const equipmentLinesCard = document.getElementById('equipment-lines-card');

    let lineIndex = 1;

    // On garde une copie de toutes les options d'articles
    const allArticleOptions = articleSelect ? Array.from(articleSelect.options) : [];

    // --- Gestion du scope (stock / equipment) ---
    function toggleScope() {
        if (!scopeSelect) return;
        const isStock = scopeSelect.value === 'stock';

        // Groupes de catégories
        if (isStock) {
            stockCategoryGroup.classList.remove('hidden');
            equipmentCategoryGroup.classList.add('hidden');
        } else {
            stockCategoryGroup.classList.add('hidden');
            equipmentCategoryGroup.classList.remove('hidden');
        }

        // Cartes de lignes
        if (isStock) {
            stockLinesCard.classList.remove('hidden');
            equipmentLinesCard.classList.add('hidden');
        } else {
            stockLinesCard.classList.add('hidden');
            equipmentLinesCard.classList.remove('hidden');
        }
    }

    if (scopeSelect) {
        scopeSelect.addEventListener('change', toggleScope);
        toggleScope(); // état initial
    }

    // Initialize with existing rows from old input
    initializeExistingRows();
    updateItemCount();

    function initializeExistingRows() {
        const existingRows = document.querySelectorAll('.line-row');
        if (existingRows.length > 0) {
            lineIndex = existingRows.length;

            document.querySelectorAll('.remove-row').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    removeRow(row);
                });
            });
        }
    }

    function updateItemCount() {
        const items = document.querySelectorAll('.line-row').length;
        itemCount.textContent = `${items} article(s)`;
        
        if (items === 0) {
            emptyState.classList.remove('hidden');
            detailsTableWrapper.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            detailsTableWrapper.classList.remove('hidden');
        }
    }

    function formatCurrency(amount) {
        const num = parseFloat(amount || 0);
        return num.toLocaleString('fr-DZ', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // 🔹 Filtre par catégorie d'article
    if (articleCategoryFilter && articleSelect) {
        articleCategoryFilter.addEventListener('change', function () {
            const selectedCategoryId = this.value;

            // Réinitialiser les options du select article
            articleSelect.innerHTML = '';

            // Toujours remettre l'option placeholder
            const placeholder = allArticleOptions[0].cloneNode(true);
            articleSelect.appendChild(placeholder);

            allArticleOptions.slice(1).forEach(option => {
                const optionCatId = option.dataset.categoryId || '';
                if (!selectedCategoryId || selectedCategoryId === optionCatId) {
                    articleSelect.appendChild(option.cloneNode(true));
                }
            });

            articleSelect.value = '';
        });
    }

    if (addRowBtn) {
        addRowBtn.addEventListener('click', function () {
            const selectedOption = articleSelect.options[articleSelect.selectedIndex];
            const articleId = articleSelect.value;
            const refArticle = selectedOption?.dataset?.ref || '';
            const designation = selectedOption?.dataset?.designation || '';
            const quantite = quantiteInput.value;
            const prix = prixInput.value;
            const unite = uniteInput.value || 'PCS';

            if (!articleId || !quantite || !prix) {
                alert('Veuillez choisir un article, saisir la quantité et le prix');
                return;
            }

            const row = document.createElement('tr');
            row.className = 'line-row fade-in-up hover:bg-gray-50 dark:hover:bg-gray-700/50';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="articles[${lineIndex}][article_id]" value="${articleId}">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center mr-3">
                            <i class="ti ti-hash text-blue-400 text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">${refArticle}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-700 dark:text-gray-300">${designation}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="articles[${lineIndex}][quantite_convenue]" value="${quantite}">
                    <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200">
                        ${quantite}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="articles[${lineIndex}][prix_convenu]" value="${prix}">
                    <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-cyan-100 to-emerald-100 dark:from-cyan-900/30 dark:to-emerald-900/30 text-cyan-800 dark:text-cyan-200">
                        ${formatCurrency(prix)} DA
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="articles[${lineIndex}][unite]" value="${unite}">
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        ${unite}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button type="button" class="remove-row relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-trash relative z-10"></i>
                        <span class="relative z-10 font-semibold text-sm">Supprimer</span>
                    </button>
                </td>
            `;

            detailsTableBody.appendChild(row);
            
            // Clear inputs
            articleSelect.value = '';
            quantiteInput.value = '';
            prixInput.value = '';
            uniteInput.value = '';
            
            lineIndex++;
            updateItemCount();

            row.style.opacity = '0';
            row.style.transform = 'translateY(10px)';
            requestAnimationFrame(() => {
                row.style.transition = 'opacity 0.3s, transform 0.3s';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            });

            row.querySelector('.remove-row').addEventListener('click', function() {
                removeRow(row);
            });
        });
    }

    function removeRow(row) {
        if (document.querySelectorAll('.line-row').length > 1) {
            row.style.opacity = '0';
            row.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                row.remove();
                updateItemCount();
            }, 300);
        } else {
            alert('Au moins un article est requis pour la convention');
        }
    }

    // Auto-select pour la première ligne si old()
    const firstArticleIdInput = document.querySelector('input[name="articles[0][article_id]"]');
    if (firstArticleIdInput && firstArticleIdInput.value && allArticleOptions.length) {
        const option = allArticleOptions.find(o => o.value === firstArticleIdInput.value);
        if (option) {
            articleSelect.value = option.value;
        }
    }

    // ---------- ÉQUIPEMENTS ----------
    const equipmentSelect = document.getElementById('equipmentSelect');
    const equipmentQuantiteInput = document.getElementById('equipmentQuantite');
    const equipmentPrixInput = document.getElementById('equipmentPrix');
    const equipmentUniteInput = document.getElementById('equipmentUnite');
    const addEquipmentRowBtn = document.getElementById('addEquipmentRow');
    const equipmentLinesBody = document.getElementById('equipment-lines-body');
    const equipmentItemCount = document.getElementById('equipment-item-count');
    const equipmentCategoryFilter = document.getElementById('equipmentCategoryFilter');

    let equipmentLineIndex = 0;

    // On garde toutes les options d’équipements
    const allEquipmentOptions = equipmentSelect ? Array.from(equipmentSelect.options) : [];

    function updateEquipmentItemCount() {
        if (!equipmentLinesBody || !equipmentItemCount) return;
        const items = equipmentLinesBody.querySelectorAll('.equipment-line-row').length;
        equipmentItemCount.textContent = `${items} équipement(s)`;
    }

    // Filtre par catégorie d’équipement
    if (equipmentCategoryFilter && equipmentSelect) {
        equipmentCategoryFilter.addEventListener('change', function () {
            const selectedCategoryId = this.value;

            equipmentSelect.innerHTML = '';
            const placeholder = allEquipmentOptions[0].cloneNode(true);
            equipmentSelect.appendChild(placeholder);

            allEquipmentOptions.slice(1).forEach(option => {
                const optionCatId = option.dataset.categoryId || '';
                if (!selectedCategoryId || selectedCategoryId === optionCatId) {
                    equipmentSelect.appendChild(option.cloneNode(true));
                }
            });

            equipmentSelect.value = '';
        });
    }

    if (addEquipmentRowBtn && equipmentSelect && equipmentLinesBody) {
        addEquipmentRowBtn.addEventListener('click', function () {
            const selectedOption = equipmentSelect.options[equipmentSelect.selectedIndex];
            const equipmentId = equipmentSelect.value;
            const ref = selectedOption?.dataset?.ref || '';
            const label = selectedOption?.dataset?.label || '';
            const quantite = equipmentQuantiteInput.value;
            const prix = equipmentPrixInput.value;
            const unite = equipmentUniteInput.value || 'PCS';

            if (!equipmentId || !quantite || !prix) {
                alert('Veuillez choisir un équipement, saisir la quantité et le prix');
                return;
            }

            const row = document.createElement('tr');
            row.className = 'equipment-line-row fade-in-up hover:bg-gray-50 dark:hover:bg-gray-700/50';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="equipments[${equipmentLineIndex}][equipment_id]" value="${equipmentId}">
                    <span class="text-sm font-medium text-gray-900 dark:text-white">${ref}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-700 dark:text-gray-300">${label}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="equipments[${equipmentLineIndex}][quantite_convenue]" value="${quantite}">
                    <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200">
                        ${quantite}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="equipments[${equipmentLineIndex}][prix_convenu]" value="${prix}">
                    <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-cyan-100 to-emerald-100 dark:from-cyan-900/30 dark:to-emerald-900/30 text-cyan-800 dark:text-cyan-200">
                        ${formatCurrency(prix)} DA
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="hidden" name="equipments[${equipmentLineIndex}][unite]" value="${unite}">
                    <span class="text-sm text-gray-700 dark:text-gray-300">${unite}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <button type="button" class="remove-equipment-row relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity durée-300"></div>
                        <i class="ti ti-trash relative z-10"></i>
                        <span class="relative z-10 font-semibold text-sm">Supprimer</span>
                    </button>
                </td>
            `;

            equipmentLinesBody.appendChild(row);

            // reset inputs
            equipmentSelect.value = '';
            equipmentQuantiteInput.value = '';
            equipmentPrixInput.value = '';
            equipmentUniteInput.value = '';

            equipmentLineIndex++;
            updateEquipmentItemCount();

            row.querySelector('.remove-equipment-row').addEventListener('click', function () {
                row.remove();
                updateEquipmentItemCount();
            });
        });
    }

    // Initialiser le compteur équipements
    updateEquipmentItemCount();
});
</script>

@push('styles')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.3s ease-out forwards;
    }

    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
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

    select, input, textarea {
        transition: all 0.2s ease-in-out;
    }

    select:focus, input:focus, textarea:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .dark select:focus, .dark input:focus, .dark textarea:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    @keyframes gradientFlow {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }

    .bg-gradient-text {
        background-size: 200% auto;
        animation: gradientFlow 3s ease-in-out infinite;
    }
</style>
@endpush
@endsection
