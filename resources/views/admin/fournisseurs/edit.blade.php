@extends('layouts.app')

@section('title', 'Modifier un Fournisseur')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Form Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Modifier Fournisseur</h1>
            </div>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Modifiez les informations du fournisseur</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-400 p-4 mx-6 mt-4 rounded">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 dark:text-red-400 mt-0.5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div>
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
        <form action="{{ route('fournisseurs.update', $fournisseur->id_fournisseur) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <!-- Informations de Base Card -->
                <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Informations de Base
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Code Fournisseur -->
                        <div>
                            <label for="code_fournisseur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Code Fournisseur <span class="text-red-500">*</span></label>
                            <input type="text" id="code_fournisseur" name="code_fournisseur" value="{{ old('code_fournisseur', $fournisseur->code_fournisseur) }}" required
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                placeholder="FRN-001">
                        </div>

                        <!-- Société -->
                        <div>
                            <label for="sociéte" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Société</label>
                            <input type="text" id="sociéte" name="sociéte" value="{{ old('sociéte', $fournisseur->sociéte) }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                placeholder="Nom de la société">
                        </div>

                        <!-- Nom -->
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du contact</label>
                            <input type="text" id="nom" name="nom" value="{{ old('nom', $fournisseur->nom) }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                placeholder="Nom complet">
                        </div>

                        <!-- Raison Sociale -->
                        <div>
                            <label for="raison_sociale" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Raison Sociale</label>
                            <input type="text" id="raison_sociale" name="raison_sociale" value="{{ old('raison_sociale', $fournisseur->raison_sociale) }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                placeholder="Raison sociale">
                        </div>
                    </div>
                </div>

                <!-- Coordonnées Card -->
                <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Coordonnées
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email', $fournisseur->email) }}"
                                    class="block w-full pl-10 rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                    placeholder="contact@exemple.com">
                            </div>
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <label for="télephone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <input type="text" id="télephone" name="télephone" value="{{ old('télephone', $fournisseur->télephone) }}"
                                    class="block w-full pl-10 rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                    placeholder="023 45 67 89">
                            </div>
                        </div>

                        <!-- Mobile -->
                        <div>
                            <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mobile</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="text" id="mobile" name="mobile" value="{{ old('mobile', $fournisseur->mobile) }}"
                                    class="block w-full pl-10 rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                    placeholder="055 12 34 56">
                            </div>
                        </div>

                        <!-- Fax -->
                        <div>
                            <label for="fax" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fax</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                </div>
                                <input type="text" id="fax" name="fax" value="{{ old('fax', $fournisseur->fax) }}"
                                    class="block w-full pl-10 rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                    placeholder="023 45 67 88">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Adresse Card -->
                <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Adresse
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Adresse -->
                        <div class="md:col-span-2">
                            <label for="adresse" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse</label>
                            <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $fournisseur->adresse) }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                placeholder="Rue, numéro">
                        </div>

                        <!-- Ville -->
                        <div>
                            <label for="ville" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ville</label>
                            <input type="text" id="ville" name="ville" value="{{ old('ville', $fournisseur->ville) }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                placeholder="Nom de la ville">
                        </div>
                    </div>
                </div>

                <!-- Informations Juridiques Card -->
                <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Informations Juridiques
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NIF -->
                        <div>
                            <label for="NIF" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIF</label>
                            <input type="text" id="NIF" name="NIF" value="{{ old('NIF', $fournisseur->NIF) }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                placeholder="Numéro d'identification fiscale">
                        </div>

                        <!-- NIS -->
                        <div>
                            <label for="NIS" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIS</label>
                            <input type="text" id="NIS" name="NIS" value="{{ old('NIS', $fournisseur->NIS) }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                placeholder="Numéro d'identification statistique">
                        </div>

                        <!-- RC -->
                        <div>
                            <label for="RC" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">RC</label>
                            <input type="text" id="RC" name="RC" value="{{ old('RC', $fournisseur->RC) }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                placeholder="Registre de commerce">
                        </div>

                        <!-- Numéro de Compte -->
                        <div>
                            <label for="n_compte" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Numéro de Compte</label>
                            <input type="text" id="n_compte" name="n_compte" value="{{ old('n_compte', $fournisseur->n_compte) }}"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                                placeholder="Numéro de compte bancaire">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('fournisseurs.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Annuler
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection