@extends('layouts.app')

@section('title', 'Nouvelle Livraison')
@section('subtitle', 'Création d\'une nouvelle livraison')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Enhanced Header -->
    <div class="mb-8">
        <div class="flex flex-col space-y-6">
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('commandes.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300 group">
                            <i class="ti ti-layout-grid mr-2 group-hover:scale-110 transition-transform"></i>
                            Commandes
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <i class="ti ti-chevron-right text-gray-400 mx-1"></i>
                        <a href="{{ route('commandes.show', $commande->id_commande) }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300">
                            Commande {{ $commande->ref_commande }}
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="ti ti-chevron-right text-gray-400 mx-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Nouvelle livraison</span>
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
                            Nouvelle Livraison
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Commande : <span class="ml-2 font-semibold text-blue-600 dark:text-blue-400">{{ $commande->ref_commande }}</span>
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
                    <i class="ti ti-package text-blue-500 text-xl mr-3"></i>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Formulaire de livraison</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Remplissez les détails de la nouvelle livraison</p>
                    </div>
                </div>
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
                    <i class="ti ti-plus mr-1"></i>Nouveau
                </span>
            </div>
        </div>

        <form action="{{ route('livraisons.store') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="commande_ref" value="{{ $commande->ref_commande }}">

            <div class="space-y-8">
                <!-- Basic Information Card -->
                <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                            <i class="ti ti-calendar text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informations de la Livraison</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date de Livraison -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-calendar-event text-blue-400 mr-2 text-sm"></i>
                                Date de Livraison <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="date" name="date_livraison" 
                                       class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300" required>
                                <i class="ti ti-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Livré Par -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-user text-blue-400 mr-2 text-sm"></i>
                                Livré Par
                            </label>
                            <div class="relative">
                                <input type="text" value="{{ auth()->user()->name }}" 
                                       class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm bg-gray-50 dark:bg-gray-700/50 text-gray-800 dark:text-gray-200 sm:text-sm transition-all duration-300" readonly>
                                <i class="ti ti-user-check absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles Commandés Card -->
                <div class="bg-gradient-to-r from-blue-50/20 via-cyan-50/10 to-emerald-50/20 dark:from-blue-900/5 dark:via-cyan-900/5 dark:to-emerald-900/5 rounded-xl border border-blue-100 dark:border-blue-900/30 p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-green-500 to-emerald-400 flex items-center justify-center">
                                <i class="ti ti-packages text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Articles Commandés</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Sélectionnez les articles à livrer</p>
                            </div>
                        </div>
                        <div id="item-count" class="px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 text-blue-800 dark:text-blue-200">
                            0 article(s)
                        </div>
                    </div>

                    <!-- Selection Form -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Article -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-package text-blue-400 mr-2 text-sm"></i>
                                Article
                            </label>
                            <div class="relative">
                                <select id="article" 
                                        class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300">
                                    <option value="">-- Choisir un article --</option>
                                    @foreach($commande->lignes as $ligne)
                                        <option value="{{ $ligne->article->ref_article }}"
                                            data-designation="{{ $ligne->article->designation }}"
                                            data-quantite-commandee="{{ $ligne->quantité }}">
                                            {{ $ligne->article->designation }} (Cmd: {{ $ligne->quantité }})
                                        </option>
                                    @endforeach
                                </select>
                                <i class="ti ti-box absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Quantité Livrée -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <i class="ti ti-sort-ascending text-green-400 mr-2 text-sm"></i>
                                Quantité Livrée
                            </label>
                            <div class="relative">
                                <input type="number" id="quantite" min="1" 
                                       class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 dark:bg-gray-700 dark:text-white sm:text-sm transition-all duration-300 text-center">
                                <i class="ti ti-numbers absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <small id="quantite-max" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-xs text-gray-500 dark:text-gray-400 hidden"></small>
                            </div>
                        </div>

                        <!-- Add Button -->
                        <div class="flex items-end">
                            <button type="button" id="addRow" 
                                    class="relative group overflow-hidden bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 w-full">
                                <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <i class="ti ti-plus relative z-10"></i>
                                <span class="relative z-10 font-semibold">Ajouter</span>
                            </button>
                        </div>
                    </div>

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
                                        <i class="ti ti-shopping-cart mr-2"></i>Quantité Commandée
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        <i class="ti ti-truck-delivery mr-2"></i>Quantité Livrée
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        <i class="ti ti-settings mr-2"></i>Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"></tbody>
                        </table>
                        
                        <!-- Empty State -->
                        <div id="emptyState" class="text-center py-12">
                            <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center mb-4">
                                <i class="ti ti-package-off text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucun article ajouté</h3>
                            <p class="text-gray-500 dark:text-gray-400">Commencez par ajouter des articles à livrer</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                <a href="{{ url()->previous() }}" 
                   class="relative group overflow-hidden bg-gradient-to-r from-gray-600 via-gray-500 to-gray-400 hover:from-gray-700 hover:via-gray-600 hover:to-gray-500 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-x relative z-10"></i>
                    <span class="relative z-10 font-semibold">Annuler</span>
                </a>
                <button type="submit" 
                        class="relative group overflow-hidden bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 hover:from-blue-700 hover:via-cyan-600 hover:to-emerald-500 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-cyan-600 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-check relative z-10"></i>
                    <span class="relative z-10 font-semibold">Enregistrer la livraison</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const articleSelect = document.getElementById('article');
    const quantiteInput = document.getElementById('quantite');
    const quantiteMaxLabel = document.getElementById('quantite-max');
    const detailsTable = document.querySelector('#detailsTable tbody');
    const addRowBtn = document.getElementById('addRow');
    const emptyState = document.getElementById('emptyState');
    const itemCount = document.getElementById('item-count');
    
    // Update item count
    function updateItemCount() {
        const items = detailsTable.querySelectorAll('tr').length;
        itemCount.textContent = `${items} article(s)`;
        
        if (items === 0) {
            emptyState.classList.remove('hidden');
            detailsTable.parentElement.querySelector('thead').classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            detailsTable.parentElement.querySelector('thead').classList.remove('hidden');
        }
    }
    
    // Update max quantity when article is selected
    articleSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const quantiteCommandee = selectedOption.dataset.quantiteCommandee || 0;
        
        quantiteInput.max = quantiteCommandee;
        quantiteInput.value = '';
        
        if (selectedOption.value) {
            quantiteMaxLabel.textContent = `Max: ${quantiteCommandee}`;
            quantiteMaxLabel.classList.remove('hidden');
        } else {
            quantiteMaxLabel.classList.add('hidden');
        }
    });
    
    // Add row to table
    addRowBtn.addEventListener('click', function() {
        const articleRef = articleSelect.value;
        const selectedOption = articleSelect.options[articleSelect.selectedIndex];
        const designation = selectedOption?.dataset?.designation || '';
        const quantiteCommandee = selectedOption?.dataset?.quantiteCommandee || 0;
        const quantite = quantiteInput.value;
        
        if (!articleRef || !quantite) {
            alert('Sélectionnez un article et indiquez la quantité.');
            return;
        }
        
        if (parseInt(quantite) > parseInt(quantiteCommandee)) {
            alert('La quantité livrée ne peut pas dépasser la quantité commandée.');
            return;
        }
        
        // Check if article already exists in table
        const existingRow = detailsTable.querySelector(`input[value="${articleRef}"]`);
        if (existingRow) {
            alert('Cet article a déjà été ajouté à la livraison.');
            return;
        }
        
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700/50 fade-in-up';
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="hidden" name="lignes[${articleRef}][article_ref]" value="${articleRef}">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/20 flex items-center justify-center mr-3">
                        <i class="ti ti-hash text-blue-400 text-sm"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">${articleRef}</span>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-700 dark:text-gray-300">${designation}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-700 dark:text-gray-300">
                    ${quantiteCommandee}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="hidden" name="lignes[${articleRef}][quantite_livree]" value="${quantite}">
                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-800 dark:text-green-200">
                    ${quantite}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <button type="button" class="remove-row relative group overflow-hidden bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 hover:from-red-700 hover:via-orange-600 hover:to-amber-500 text-white px-4 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-trash relative z-10"></i>
                    <span class="relative z-10 font-semibold text-sm">Supprimer</span>
                </button>
            </td>
        `;
        
        detailsTable.appendChild(row);
        quantiteInput.value = '';
        articleSelect.value = '';
        quantiteMaxLabel.classList.add('hidden');
        updateItemCount();
        
        // Add animation
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        requestAnimationFrame(() => {
            row.style.transition = 'opacity 0.3s, transform 0.3s';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        });
    });
    
    // Remove row from table
    detailsTable.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
            const row = e.target.closest('tr');
            row.style.opacity = '0';
            row.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                row.remove();
                updateItemCount();
            }, 300);
        }
    });
    
    // Initialize
    updateItemCount();
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

    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(to right, #3b82f6, #06b6d4);
        border-radius: 4px;
    }

    .dark .overflow-x-auto::-webkit-scrollbar-track {
        background: #374151;
    }

    .dark .overflow-x-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(to right, #1d4ed8, #0891b2);
    }

    /* Smooth transitions */
    select, input {
        transition: all 0.2s ease-in-out;
    }

    select:focus, input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .dark select:focus, .dark input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
</style>
@endpush
@endsection