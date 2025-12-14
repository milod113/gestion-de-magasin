@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                Gestion des Rôles
            </h1>
            <p class="text-gray-400 mt-2">Détails du rôle système</p>
        </div>

        <!-- Role Details Card -->
        <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-700/50 overflow-hidden transition-all duration-300 hover:shadow-purple-500/10 hover:border-gray-600/70">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-gray-900 to-gray-800/80 px-6 py-5 border-b border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-xl bg-gradient-to-br from-blue-500/20 to-purple-600/20 border border-blue-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ $role->name }}</h2>
                            <p class="text-gray-400">Détails du rôle système</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <span class="px-3 py-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full text-xs font-medium text-white shadow-lg">
                            {{ $role->permissions->count() }} Permission(s)
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <!-- Description Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-white mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Description du rôle
                    </h3>
                    <div class="bg-gray-900/50 rounded-xl p-4 border border-gray-700/50">
                        <p class="text-gray-300">
                            {{ $role->description ?? 'Aucune description définie pour ce rôle.' }}
                        </p>
                    </div>
                </div>

                <!-- Permissions Section -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Permissions associées
                    </h3>
                    
                    @if($role->permissions->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($role->permissions as $permission)
                                <div class="bg-gray-900/40 rounded-lg p-3 border border-gray-700/50 hover:border-green-500/30 transition-colors duration-200 flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-green-500 mr-3"></div>
                                    <span class="text-gray-200 font-medium">{{ $permission->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-900/40 rounded-xl p-6 text-center border border-gray-700/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <p class="text-gray-400">Aucune permission attribuée à ce rôle.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Footer -->
            <div class="px-6 py-4 bg-gray-900/30 border-t border-gray-700/50 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Créé le {{ $role->created_at->format('d/m/Y') }}
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.roles.index') }}" 
                       class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-gray-200 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-gray-700/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à la liste
                    </a>
                    <a href="{{ route('admin.roles.edit', $role->id) }}" 
                       class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier le rôle
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Info Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Users with this role -->
            <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl p-6 border border-gray-700/50">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    Utilisateurs avec ce rôle
                </h3>
                <div class="flex items-center justify-center py-8">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        <p class="text-gray-400">Information non disponible</p>
                    </div>
                </div>
            </div>

            <!-- Role Activity -->
            <div class="bg-gray-800/50 backdrop-blur-lg rounded-2xl p-6 border border-gray-700/50">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Activité récente
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center text-sm text-gray-400">
                        <div class="h-2 w-2 rounded-full bg-blue-500 mr-3"></div>
                        <span>Rôle modifié il y a 2 jours</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-400">
                        <div class="h-2 w-2 rounded-full bg-green-500 mr-3"></div>
                        <span>Permission ajoutée il y a 1 semaine</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-400">
                        <div class="h-2 w-2 rounded-full bg-purple-500 mr-3"></div>
                        <span>Rôle créé le {{ $role->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom scrollbar for dark mode */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #1f2937;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #4b5563;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }
    
    /* Smooth transitions for all interactive elements */
    * {
        transition: color 0.2s ease, background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }
</style>
@endsection