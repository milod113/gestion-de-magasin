@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')
@section('subtitle', 'Liste complète des utilisateurs')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-colors duration-300">
    <!-- Header with Dark Mode Toggle -->
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Tous les Utilisateurs</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $users->total() }} utilisateurs trouvés</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" placeholder="Rechercher..." 
                       class="pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full md:w-64 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400 dark:text-gray-300"></i>
            </div>
            <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg p-2">
                <i class="fas fa-moon dark:hidden"></i>
                <i class="fas fa-sun hidden dark:block"></i>
            </button>
            <a href="{{ route('users.create') }}" class="btn-primary flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Nouvel Utilisateur</span>
            </a>
        </div>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Nom
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Rôles
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500 dark:text-gray-300">
                            @if($user->roles->isNotEmpty())
                                {{ $user->roles->pluck('name')->join(', ') }}
                            @else
                                Aucun rôle
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('users.edit', $user) }}" class="btn-action btn-edit" title="Modifier">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')" class="btn-action btn-delete" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-500 dark:text-gray-400">
            Affichage de <span class="font-medium dark:text-white">{{ $users->firstItem() }}</span> à <span class="font-medium dark:text-white">{{ $users->lastItem() }}</span> sur <span class="font-medium dark:text-white">{{ $users->total() }}</span> utilisateurs
        </div>
        <div class="flex space-x-2">
            @if($users->onFirstPage())
            <button class="btn-pagination disabled" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            @else
            <a href="{{ $users->previousPageUrl() }}" class="btn-pagination">
                <i class="fas fa-chevron-left"></i>
            </a>
            @endif
            
            @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                @if($page == $users->currentPage())
                <span class="btn-pagination bg-blue-500 text-white">{{ $page }}</span>
                @else
                <a href="{{ $url }}" class="btn-pagination">{{ $page }}</a>
                @endif
            @endforeach
            
            @if($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" class="btn-pagination">
                <i class="fas fa-chevron-right"></i>
            </a>
            @else
            <button class="btn-pagination disabled" disabled>
                <i class="fas fa-chevron-right"></i>
            </button>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .btn-primary {
        @apply bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center;
    }
    
    .btn-action {
        @apply w-8 h-8 flex items-center justify-center rounded-full transition-colors duration-200;
    }
    
    .btn-edit {
        @apply bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-200 hover:bg-yellow-200 dark:hover:bg-yellow-800;
    }
    
    .btn-delete {
        @apply bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-800;
    }
    
    .btn-pagination {
        @apply w-8 h-8 flex items-center justify-center rounded-md border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200;
    }
    
    .btn-pagination.disabled {
        @apply opacity-50 cursor-not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
    // Dark mode toggle functionality
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;
    
    if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }
    
    themeToggle.addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
    });
</script>
@endpush
