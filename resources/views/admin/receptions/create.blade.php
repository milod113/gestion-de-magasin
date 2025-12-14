@extends('layouts.app')

@section('title', 'Créer une nouvelle Réception')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Enhanced Header -->
    <div class="mb-8">
        <div class="flex flex-col space-y-6">
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('receptions.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300 group">
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Réceptions
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Nouvelle réception</span>
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
                            <i class="ti ti-truck-delivery text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 bg-clip-text text-transparent">
                            Nouvelle Réception
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Créez un nouveau bon de livraison
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <i class="ti ti-calendar text-blue-400"></i>
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
                    <i class="ti ti-file-invoice text-blue-500 text-xl mr-3"></i>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Formulaire de réception</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Remplissez les détails de la nouvelle réception</p>
                    </div>
                </div>
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
                    Nouveau
                </span>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border-l-4 border-red-500 dark:border-red-400 p-4 mx-6 mt-4 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="ti ti-alert-circle text-red-500 dark:text-red-400 text-xl mt-0.5 mr-3"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Veuillez corriger les erreurs suivantes :</h3>
                        <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Content -->
        <form action="{{ route('receptions.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-8">
                <!-- Basic Information Card -->
                <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                            <i class="ti ti-calendar text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informations de Base</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date de réception -->
                        <div>
                            <label for="date_reception" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-calendar-event text-blue-400 mr-2 text-sm"></i>
                                Date de réception <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="date" name="date_reception" id="date_reception" 
                                       class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300"
                                       value="{{ old('date_reception') }}" required>
                                <i class="ti ti-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('date_reception') 
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <i class="ti ti-info-circle mr-1"></i> {{ $message }}
                                </p> 
                            @enderror
                        </div>

                        <!-- Référence réception -->
                        <div>
                            <label for="reception_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-hash text-blue-400 mr-2 text-sm"></i>
                                Référence <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="reception_reference" id="reception_reference" 
                                       class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300"
                                       value="{{ old('reception_reference') }}" placeholder="REC-2024-" required>
                                <i class="ti ti-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('reception_reference') 
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <i class="ti ti-info-circle mr-1"></i> {{ $message }}
                                </p> 
                            @enderror
                        </div>

                        <!-- ✅ Convention (instead of fournisseur) -->
                        <div class="md:col-span-2">
                            <label for="convention_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-file-description text-blue-400 mr-2 text-sm"></i>
                                Convention <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <select name="convention_id" id="convention_id" 
                                        class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300"
                                        required>
                                    <option value="">-- Choisir une convention --</option>
                                    @foreach($conventions as $convention)
                                        <option value="{{ $convention->id }}"
                                            {{ old('convention_id') == $convention->id ? 'selected' : '' }}>
                                            {{ $convention->reference }}
                                            @if($convention->fournisseur)
                                                - {{ $convention->fournisseur->sociéte ?? $convention->fournisseur->nom }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <i class="ti ti-notebook absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('convention_id') 
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <i class="ti ti-info-circle mr-1"></i> {{ $message }}
                                </p> 
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Lignes de réception Card -->
                <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-green-500 to-emerald-400 flex items-center justify-center">
                                <i class="ti ti-packages text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Articles à recevoir</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Ajoutez les articles de cette réception</p>
                            </div>
                        </div>
                        <button type="button" id="add-ligne" 
                                class="relative group overflow-hidden bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="ti ti-plus relative z-10"></i>
                            <span class="relative z-10 font-semibold">Ajouter un article</span>
                        </button>
                    </div>

                    <div id="ligne-container" class="space-y-4">
                        <!-- Initial ligne item -->
                        <div class="ligne-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                            <div class="grid grid-cols-12 gap-4 items-end">
                                <div class="col-span-12 md:col-span-5">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                        <i class="ti ti-package text-blue-400 mr-2 text-sm"></i>
                                        Article <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select name="lignes[0][article_reference]" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5" required>
                                        <option value="">-- Choisir un article --</option>
                                        @foreach($articles as $article)
                                            <option value="{{ $article->ref_article }}">{{ $article->designation }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-6 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                        <i class="ti ti-sort-ascending text-green-400 mr-2 text-sm"></i>
                                        Quantité <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="number" name="lignes[0][quantité]" placeholder="0" min="1" 
                                           class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 text-center" required>
                                </div>
                                <div class="col-span-6 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                        <i class="ti ti-currency-dollar text-emerald-400 mr-2 text-sm"></i>
                                        Prix unitaire <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="number" name="lignes[0][prix_unitaire]" placeholder="0.00" step="0.01" min="0" 
                                           class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5" required>
                                </div>
                                <div class="col-span-12 md:col-span-3 flex justify-end">
                                    <button type="button" class="remove-ligne relative group overflow-hidden bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 hover:from-red-700 hover:via-orange-600 hover:to-amber-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                        <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <i class="ti ti-trash relative z-10"></i>
                                        <span class="relative z-10 font-semibold">Supprimer</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <i class="ti ti-info-circle text-blue-400 mr-2"></i>
                                Vous pouvez ajouter plusieurs articles
                            </p>
                            <div id="item-count" class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200">
                                1 article(s)
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                <a href="{{ route('receptions.index') }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-gray-600 via-gray-500 to-gray-400 hover:from-gray-700 hover:via-gray-600 hover:to-gray-500 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-x relative z-10"></i>
                    <span class="relative z-10 font-semibold">Annuler</span>
                </a>
                <button type="submit" 
                        class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-check relative z-10"></i>
                    <span class="relative z-10 font-semibold">Enregistrer la réception</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let index = 1;
    const container = document.getElementById('ligne-container');
    const addBtn = document.getElementById('add-ligne');
    const itemCount = document.getElementById('item-count');

    function updateItemCount() {
        const items = container.querySelectorAll('.ligne-item').length;
        itemCount.textContent = `${items} article(s)`;
    }

    addBtn.addEventListener('click', () => {
        const ligne = document.createElement('div');
        ligne.classList.add('ligne-item', 'bg-white', 'dark:bg-gray-800', 'rounded-xl', 'border', 'border-gray-200', 'dark:border-gray-700', 'p-4', 'hover:border-blue-300', 'dark:hover:border-blue-600', 'transition-all', 'duration-300');
        ligne.innerHTML = `
            <div class="grid grid-cols-12 gap-4 items-end">
                <div class="col-span-12 md:col-span-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-package text-blue-400 mr-2 text-sm"></i>
                        Article <span class="text-red-500 ml-1">*</span>
                    </label>
                    <select name="lignes[${index}][article_reference]" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5" required>
                        <option value="">-- Choisir un article --</option>
                        @foreach($articles as $article)
                            <option value="{{ $article->ref_article }}">{{ $article->designation }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-sort-ascending text-green-400 mr-2 text-sm"></i>
                        Quantité <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="number" name="lignes[${index}][quantité]" placeholder="0" min="1" 
                           class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5 text-center" required>
                </div>
                <div class="col-span-6 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                        <i class="ti ti-currency-dollar text-emerald-400 mr-2 text-sm"></i>
                        Prix unitaire <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="number" name="lignes[${index}][prix_unitaire]" placeholder="0.00" step="0.01" min="0" 
                           class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm py-2.5" required>
                </div>
                <div class="col-span-12 md:col-span-3 flex justify-end">
                    <button type="button" class="remove-ligne relative group overflow-hidden bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 hover:from-red-700 hover:via-orange-600 hover:to-amber-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-trash relative z-10"></i>
                        <span class="relative z-10 font-semibold">Supprimer</span>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(ligne);
        index++;
        updateItemCount();

        ligne.querySelector('.remove-ligne').addEventListener('click', () => {
            ligne.remove();
            updateItemCount();
        });
    });

    document.querySelectorAll('.remove-ligne').forEach(button => {
        button.addEventListener('click', e => {
            e.target.closest('.ligne-item').remove();
            updateItemCount();
        });
    });

    updateItemCount();

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.classList && node.classList.contains('ligne-item')) {
                    node.style.opacity = '0';
                    node.style.transform = 'translateY(10px)';
                    requestAnimationFrame(() => {
                        node.style.transition = 'opacity 0.3s, transform 0.3s';
                        node.style.opacity = '1';
                        node.style.transform = 'translateY(0)';
                    });
                }
            });
        });
    });

    observer.observe(container, { childList: true });
});
</script>

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in-up { animation: fadeInUp 0.3s ease-out forwards; }

    input:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .dark input:focus, .dark select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .gradient-border {
        position: relative;
        border: 2px solid transparent;
        background: linear-gradient(white, white) padding-box,
                    linear-gradient(to right, #3b82f6, #06b6d4, #10b981) border-box;
        border-radius: 0.5rem;
    }

    .dark .gradient-border {
        background: linear-gradient(#1f2937, #1f2937) padding-box,
                    linear-gradient(to right, #3b82f6, #06b6d4, #10b981) border-box;
    }

    * {
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>
@endpush
@endsection
