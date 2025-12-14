@extends('layouts.app')

@section('title', 'Détails Fournisseur')
@section('subtitle', 'Informations complètes du fournisseur')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Enhanced Header -->
    <div class="mb-8">
        <div class="flex flex-col space-y-6">
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300 group">
                            <i class="ti ti-home mr-2 group-hover:scale-110 transition-transform"></i>
                            Tableau de bord
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ti ti-chevron-right text-gray-400 mx-1"></i>
                            <a href="{{ route('fournisseurs.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all duration-300">
                                Gestion des fournisseurs
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="ti ti-chevron-right text-gray-400 mx-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Détails fournisseur</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Main Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-500 via-purple-500 to-pink-400 rounded-2xl blur opacity-25"></div>
                        <div class="relative bg-gradient-to-r from-blue-600 via-purple-500 to-pink-400 p-4 rounded-2xl shadow-lg">
                            <i class="ti ti-building-warehouse text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-purple-500 to-pink-400 bg-clip-text text-transparent">
                            Détails Fournisseur
                        </h1>
                        <div class="flex items-center space-x-4 mt-2">
                            <div class="flex items-center space-x-2">
                                <span class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $fournisseur->code_fournisseur }}
                                </span>
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200">
                                    CODE
                                </span>
                            </div>
                            <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                            <div class="flex items-center space-x-2">
                                <i class="ti ti-building text-purple-400"></i>
                                <span class="text-lg text-gray-600 dark:text-gray-400">{{ $fournisseur->sociéte }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <i class="ti ti-calendar text-blue-400"></i>
                        <span>{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Header with Gradient -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50/30 via-purple-50/20 to-pink-50/30 dark:from-blue-900/10 dark:via-purple-900/10 dark:to-pink-900/10">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-purple-400 flex items-center justify-center">
                    <i class="ti ti-info-circle text-white text-sm"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Informations générales</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Détails complets du fournisseur</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Company Information Card -->
                <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 flex items-center justify-center">
                            <i class="ti ti-building text-blue-600 dark:text-blue-300"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informations société</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Détails de l'entreprise</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Code</label>
                            <div class="flex items-center space-x-2">
                                <div class="px-3 py-1.5 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-lg">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white font-mono">{{ $fournisseur->code_fournisseur ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Raison sociale</label>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $fournisseur->raison_sociale ?? '—' }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Société</label>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $fournisseur->sociéte ?? '—' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 flex items-center justify-center">
                            <i class="ti ti-user text-green-600 dark:text-green-300"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Contact</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Informations de contact</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nom</label>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $fournisseur->nom ?? '—' }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Adresse</label>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                <div class="flex items-start space-x-2">
                                    <i class="ti ti-map-pin text-gray-400 mt-0.5"></i>
                                    <span>
                                        {{ $fournisseur->adresse ?? '—' }}
                                        @if($fournisseur->ville)
                                            <br><span class="text-gray-500 dark:text-gray-400">{{ $fournisseur->ville }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Details Card -->
                <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-cyan-900/30 dark:to-blue-900/30 flex items-center justify-center">
                            <i class="ti ti-phone text-cyan-600 dark:text-cyan-300"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Coordonnées</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Moyens de contact</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Téléphone</label>
                            <div class="flex items-center space-x-2">
                                <div class="p-2 rounded-lg bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                                    <i class="ti ti-phone-call text-gray-600 dark:text-gray-300"></i>
                                </div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $fournisseur->télephone ?? '—' }}
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Mobile</label>
                            <div class="flex items-center space-x-2">
                                <div class="p-2 rounded-lg bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                                    <i class="ti ti-device-mobile text-gray-600 dark:text-gray-300"></i>
                                </div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $fournisseur->mobile ?? '—' }}
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                            <div class="flex items-center space-x-2">
                                <div class="p-2 rounded-lg bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                                    <i class="ti ti-mail text-gray-600 dark:text-gray-300"></i>
                                </div>
                                <div class="text-sm font-medium">
                                    @if($fournisseur->email)
                                        <a href="mailto:{{ $fournisseur->email }}" 
                                           class="text-blue-600 dark:text-blue-400 hover:underline hover:text-blue-700 dark:hover:text-blue-300">
                                            {{ $fournisseur->email }}
                                        </a>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">—</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Information Card -->
                <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 flex items-center justify-center">
                            <i class="ti ti-currency-dollar text-emerald-600 dark:text-emerald-300"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informations financières</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Identifiants légaux</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">NIS</label>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $fournisseur->NIS ?? '—' }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">NIF</label>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $fournisseur->NIF ?? '—' }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">RC</label>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $fournisseur->RC ?? '—' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Information Card -->
                <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 flex items-center justify-center">
                            <i class="ti ti-wallet text-yellow-600 dark:text-yellow-300"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Informations bancaires</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Coordonnées bancaires</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">N° Compte</label>
                            <div class="flex items-center space-x-2">
                                <div class="p-2 rounded-lg bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                                    <i class="ti ti-credit-card text-gray-600 dark:text-gray-300"></i>
                                </div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white font-mono">
                                    {{ $fournisseur->n_compte ?? '—' }}
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Fax</label>
                            <div class="flex items-center space-x-2">
                                <div class="p-2 rounded-lg bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                                    <i class="ti ti-printer text-gray-600 dark:text-gray-300"></i>
                                </div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $fournisseur->fax ?? '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 flex items-center justify-center">
                            <i class="ti ti-chart-bar text-purple-600 dark:text-purple-300"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Statistiques</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Activité du fournisseur</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-3 rounded-lg bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">0</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Conventions</div>
                            </div>
                            <div class="text-center p-3 rounded-lg bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">0</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Réceptions</div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Statut :</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200">
                                    Actif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions Section -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <i class="ti ti-calendar text-blue-400 mr-2"></i>
                        <span>Créé le : {{ optional($fournisseur->created_at)->format('d/m/Y à H:i') ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('fournisseurs.edit', $fournisseur->id_fournisseur) }}" 
                           class="relative group overflow-hidden bg-gradient-to-r from-yellow-600 via-amber-500 to-orange-400 hover:from-yellow-700 hover:via-amber-600 hover:to-orange-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-700 via-amber-600 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="ti ti-edit relative z-10"></i>
                            <span class="relative z-10 font-semibold">Modifier</span>
                        </a>
                        
                        <form action="{{ route('fournisseurs.destroy', $fournisseur->id_fournisseur) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ? Cette action est irréversible.')" 
                                    class="relative group overflow-hidden bg-gradient-to-r from-red-600 via-orange-500 to-pink-400 hover:from-red-700 hover:via-orange-600 hover:to-pink-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-orange-600 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <i class="ti ti-trash relative z-10"></i>
                                <span class="relative z-10 font-semibold">Supprimer</span>
                            </button>
                        </form>
                        
                        <a href="{{ route('fournisseurs.index') }}" 
                           class="relative group overflow-hidden bg-gradient-to-r from-gray-600 via-gray-500 to-gray-400 hover:from-gray-700 hover:via-gray-600 hover:to-gray-500 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                            <div class="absolute inset-0 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <i class="ti ti-arrow-left relative z-10"></i>
                            <span class="relative z-10 font-semibold">Retour</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    @keyframes slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-slide-in { animation: slide-in 0.3s ease-out forwards; }
    
    .gradient-text {
        background: linear-gradient(to right, #3b82f6, #8b5cf6, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    * {
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
    
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .dark .card-hover:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notifications = ['notification', 'error-notification'];
    notifications.forEach(id => {
        const element = document.getElementById(id);
        if (element) setTimeout(() => element.remove(), 5000);
    });
    
    // Add hover effects to cards
    const cards = document.querySelectorAll('.bg-gradient-to-br');
    cards.forEach(card => {
        card.classList.add('card-hover');
    });
});
</script>
@endpush