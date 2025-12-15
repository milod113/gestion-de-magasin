@extends('layouts.app')

@section('title', 'Boîte de réception')
@section('subtitle', 'Messages reçus et gérés')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
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
                <span class="text-gray-600 dark:text-gray-300 font-medium">
                    <i class="ti ti-mail mr-1"></i>
                    Boîte de réception
                </span>
            </li>
        </ol>
    </nav>

    <!-- Header avec statistiques -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl border border-blue-100 dark:border-gray-700 p-6 mb-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 to-indigo-500 blur-lg opacity-20"></div>
                    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-500 p-3 rounded-xl shadow-lg">
                        <i class="ti ti-inbox text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Boîte de réception</h1>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">
                        {{ $messages->total() }} message(s) -
                        @php
                            $unreadCount = $messages->where('is_read', false)->count();
                        @endphp
                        <span class="font-semibold {{ $unreadCount ? 'text-red-500 dark:text-red-400' : 'text-green-500 dark:text-green-400' }}">
                            {{ $unreadCount }} non lu(s)
                        </span>
                    </p>
                </div>
            </div>

            <a href="{{ route('messages.create') }}"
               class="group relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-500 hover:from-blue-700 hover:via-indigo-600 hover:to-purple-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <i class="ti ti-plus relative z-10 text-sm"></i>
                <span class="relative z-10">Nouveau message</span>
            </a>
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

    <!-- Filtres et Recherche -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 mb-6 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <!-- Barre de recherche -->
            <div class="flex-1">
                <form method="GET" action="{{ route('messages.inbox') }}" class="relative">
                    <div class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Rechercher dans les messages..."
                               class="w-full pl-12 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all duration-200"
                               autocomplete="off">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <i class="ti ti-search"></i>
                        </div>
                        @if(request('search'))
                        <button type="button"
                                onclick="clearSearch()"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="ti ti-x"></i>
                        </button>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Filtres rapides -->
            <div class="flex items-center gap-3">
                <!-- Filtre statut -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:border-blue-400 dark:hover:border-blue-500 transition-colors">
                        <i class="ti ti-filter text-gray-500 dark:text-gray-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ request('status') == 'unread' ? 'Non lus' : (request('status') == 'read' ? 'Lus' : 'Tous') }}
                        </span>
                        <i class="ti ti-chevron-down text-xs"></i>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg z-50 overflow-hidden">
                        <a href="{{ route('messages.inbox', ['status' => '', 'search' => request('search')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-mail mr-2"></i>
                            Tous les messages
                        </a>
                        <a href="{{ route('messages.inbox', ['status' => 'unread', 'search' => request('search')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-circle text-red-500 mr-2"></i>
                            Non lus seulement
                        </a>
                        <a href="{{ route('messages.inbox', ['status' => 'read', 'search' => request('search')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-circle-check text-green-500 mr-2"></i>
                            Lus seulement
                        </a>
                    </div>
                </div>

                <!-- Filtre date -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:border-blue-400 dark:hover:border-blue-500 transition-colors">
                        <i class="ti ti-calendar text-gray-500 dark:text-gray-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ request('date') == 'today' ? 'Aujourd\'hui' : (request('date') == 'week' ? '7 derniers jours' : 'Toute période') }}
                        </span>
                        <i class="ti ti-chevron-down text-xs"></i>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg z-50 overflow-hidden">
                        <a href="{{ route('messages.inbox', ['date' => '', 'search' => request('search'), 'status' => request('status')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-clock mr-2"></i>
                            Toute période
                        </a>
                        <a href="{{ route('messages.inbox', ['date' => 'today', 'search' => request('search'), 'status' => request('status')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-sun mr-2 text-yellow-500"></i>
                            Aujourd'hui
                        </a>
                        <a href="{{ route('messages.inbox', ['date' => 'week', 'search' => request('search'), 'status' => request('status')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-calendar-week mr-2 text-blue-500"></i>
                            7 derniers jours
                        </a>
                        <a href="{{ route('messages.inbox', ['date' => 'month', 'search' => request('search'), 'status' => request('status')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-calendar-month mr-2 text-purple-500"></i>
                            30 derniers jours
                        </a>
                    </div>
                </div>

                <!-- Bouton effacer filtres -->
                @if(request('search') || request('status') || request('date'))
                <a href="{{ route('messages.inbox') }}"
                   class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium text-gray-700 dark:text-gray-300">
                    <i class="ti ti-filter-off"></i>
                    Effacer
                </a>
                @endif
            </div>
        </div>

        <!-- Filtres actifs -->
        @if(request('search') || request('status') || request('date'))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Filtres actifs :</span>

                @if(request('search'))
                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                    <i class="ti ti-search text-xs"></i>
                    "{{ request('search') }}"
                    <a href="{{ route('messages.inbox', array_merge(request()->except('search'), ['search' => ''])) }}"
                       class="text-blue-400 hover:text-blue-600 dark:hover:text-blue-200 ml-1">
                        <i class="ti ti-x text-xs"></i>
                    </a>
                </span>
                @endif

                @if(request('status'))
                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-sm">
                    <i class="ti ti-filter text-xs"></i>
                    {{ request('status') == 'unread' ? 'Non lus' : 'Lus' }}
                    <a href="{{ route('messages.inbox', array_merge(request()->except('status'), ['status' => ''])) }}"
                       class="text-green-400 hover:text-green-600 dark:hover:text-green-200 ml-1">
                        <i class="ti ti-x text-xs"></i>
                    </a>
                </span>
                @endif

                @if(request('date'))
                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm">
                    <i class="ti ti-calendar text-xs"></i>
                    {{ request('date') == 'today' ? 'Aujourd\'hui' : (request('date') == 'week' ? '7 derniers jours' : '30 derniers jours') }}
                    <a href="{{ route('messages.inbox', array_merge(request()->except('date'), ['date' => ''])) }}"
                       class="text-purple-400 hover:text-purple-600 dark:hover:text-purple-200 ml-1">
                        <i class="ti ti-x text-xs"></i>
                    </a>
                </span>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Liste des messages -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- En-tête de la liste -->
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Bouton sélection multiple -->
                    <button id="select-all"
                            type="button"
                            class="w-5 h-5 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 flex items-center justify-center text-blue-600 dark:text-blue-400 hover:border-blue-400 dark:hover:border-blue-500 transition-colors">
                        <i class="ti ti-check text-xs hidden"></i>
                    </button>

                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                        {{ $messages->total() }} message(s) trouvé(s)
                        @if($messages->where('is_read', false)->count() > 0)
                            <span class="text-red-500 dark:text-red-400 ml-2">
                                ({{ $messages->where('is_read', false)->count() }} non lu(s))
                            </span>
                        @endif
                    </p>
                </div>

                <!-- Actions groupées -->
                <div class="flex items-center gap-2" id="bulk-actions" style="display: none;">
                    <button onclick="markSelectedAsRead()"
                            class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800/50 transition-colors text-sm">
                        <i class="ti ti-eye-check text-xs"></i>
                        Marquer comme lu
                    </button>
                    <button onclick="deleteSelected()"
                            class="flex items-center gap-2 px-3 py-1.5 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-100 dark:hover:bg-red-800/50 transition-colors text-sm">
                        <i class="ti ti-trash text-xs"></i>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>

        <!-- Liste des messages -->
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($messages as $message)
                <div class="message-item p-5 hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition group"
                     data-id="{{ $message->id }}"
                     data-read="{{ $message->is_read ? 'true' : 'false' }}">
                    <div class="flex items-start gap-4">
                        <!-- Checkbox de sélection -->
                        <div class="pt-1">
                            <input type="checkbox"
                                   class="message-checkbox w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-blue-600 dark:text-blue-400 focus:ring-blue-500 dark:focus:ring-blue-600"
                                   value="{{ $message->id }}">
                        </div>

                        <!-- Avatar expéditeur -->
                        <div class="shrink-0">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r
                                {{ $message->is_read ? 'from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700' : 'from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30' }}
                                flex items-center justify-center">
                                @if($message->sender?->avatar)
                                    <img src="{{ $message->sender->avatar }}"
                                         alt="{{ $message->sender->name }}"
                                         class="w-10 h-10 rounded-full">
                                @else
                                    <span class="text-sm font-semibold
                                        {{ $message->is_read ? 'text-gray-600 dark:text-gray-400' : 'text-blue-600 dark:text-blue-400' }}">
                                        {{ substr($message->sender?->name ?? '?', 0, 1) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Contenu du message -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="font-bold text-gray-900 dark:text-white truncate
                                        {{ !$message->is_read ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }}">
                                        {{ $message->sujet }}
                                    </h3>

                                    <!-- Badges -->
                                    <div class="flex items-center gap-2">
                                        @if(!$message->is_read)
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300">
                                            <i class="ti ti-circle-filled text-[6px]"></i>
                                            Non lu
                                        </span>
                                        @endif

                                        @if($message->attachments?->count())
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                            <i class="ti ti-paperclip text-xs"></i>
                                            {{ $message->attachments->count() }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <span class="text-xs text-gray-500 dark:text-gray-400 shrink-0">
                                    {{ $message->created_at?->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            <!-- Extrait -->
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2 line-clamp-2
                                {{ !$message->is_read ? 'font-medium' : '' }}">
                                {{ \Illuminate\Support\Str::limit($message->contenu, 150) }}
                            </p>

                            <!-- Métadonnées -->
                            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2">
                                <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="ti ti-user text-xs"></i>
                                    <span class="font-medium text-gray-700 dark:text-gray-200">
                                        {{ $message->sender?->name ?? 'Expéditeur inconnu' }}
                                    </span>
                                </span>

                                @if($message->sender?->roles->count())
                                <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="ti ti-badge text-xs"></i>
                                    {{ $message->sender->roles->pluck('name')->join(', ') }}
                                </span>
                                @endif

                                <!-- Actions rapides -->
                                <div class="flex items-center gap-2 ml-auto">
                                    <a href="{{ route('messages.show', $message) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-medium transition-colors opacity-0 group-hover:opacity-100">
                                        <i class="ti ti-eye text-xs"></i>
                                        Lire
                                    </a>

                                    @if(!$message->is_read)
                                    <form method="POST" action="{{ route('messages.markAsRead', $message) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-800/50 text-blue-700 dark:text-blue-300 text-xs font-medium transition-colors opacity-0 group-hover:opacity-100">
                                            <i class="ti ti-eye-check text-xs"></i>
                                            Marquer lu
                                        </button>
                                    </form>
                                    @endif

                                    <form method="POST" action="{{ route('messages.destroy', $message) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Supprimer ce message ?')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-800/50 text-red-700 dark:text-red-300 text-xs font-medium transition-colors opacity-0 group-hover:opacity-100">
                                            <i class="ti ti-trash text-xs"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- État vide -->
                <div class="p-12 text-center">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-inbox text-gray-400 text-2xl"></i>
                    </div>
                    @if(request('search') || request('status') || request('date'))
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            Aucun message trouvé
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">
                            Essayez de modifier vos filtres ou votre recherche
                        </p>
                        <a href="{{ route('messages.inbox') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                            <i class="ti ti-filter-off"></i>
                            Effacer tous les filtres
                        </a>
                    @else
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            Boîte de réception vide
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">
                            Lorsque vous recevez des messages, ils apparaîtront ici
                        </p>
                        <a href="{{ route('messages.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-700 hover:to-indigo-600 text-white rounded-lg transition-colors text-sm font-medium">
                            <i class="ti ti-plus"></i>
                            Écrire votre premier message
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($messages->hasPages())
        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Affichage de {{ $messages->firstItem() ?? 0 }} à {{ $messages->lastItem() ?? 0 }}
                    sur {{ $messages->total() }} message(s)
                </div>
                <div class="flex justify-center">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
        @endif
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

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .message-item {
        transition: all 0.2s ease;
    }

    .message-item:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    /* Style pour messages non lus */
    .message-item[data-read="false"] {
        background: rgba(59, 130, 246, 0.03);
    }

    .message-item[data-read="false"]:hover {
        background: rgba(59, 130, 246, 0.08);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success alert
    setTimeout(() => {
        const alert = document.getElementById('success-alert');
        if (alert) alert.remove();
    }, 5000);

    // Gestion de la sélection multiple
    const selectAllBtn = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.message-checkbox');
    const bulkActions = document.getElementById('bulk-actions');
    const messageItems = document.querySelectorAll('.message-item');

    // Toggle select all
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            const isChecked = this.classList.contains('selected');

            checkboxes.forEach(checkbox => {
                checkbox.checked = !isChecked;
            });

            if (!isChecked) {
                this.classList.add('selected');
                this.innerHTML = '<i class="ti ti-check text-xs"></i>';
            } else {
                this.classList.remove('selected');
                this.innerHTML = '';
            }

            toggleBulkActions();
        });
    }

    // Gestion des cases à cocher individuelles
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkActions);
    });

    // Toggle bulk actions
    function toggleBulkActions() {
        const selectedCount = document.querySelectorAll('.message-checkbox:checked').length;

        if (selectedCount > 0) {
            bulkActions.style.display = 'flex';
            selectAllBtn.classList.add('selected');
            selectAllBtn.innerHTML = '<i class="ti ti-check text-xs"></i>';
        } else {
            bulkActions.style.display = 'none';
            selectAllBtn.classList.remove('selected');
            selectAllBtn.innerHTML = '';
        }
    }

    // Effacer la recherche
    window.clearSearch = function() {
        const url = new URL(window.location.href);
        url.searchParams.delete('search');
        window.location.href = url.toString();
    };
});

// Marquer les sélectionnés comme lus
function markSelectedAsRead() {
    const selectedIds = Array.from(document.querySelectorAll('.message-checkbox:checked'))
        .map(cb => cb.value);

    if (selectedIds.length === 0) return;

    // Ici, vous devrez envoyer une requête AJAX
    // Pour l'exemple, on affiche une confirmation
    if (confirm(`Marquer ${selectedIds.length} message(s) comme lu ?`)) {
        // Envoyer une requête POST
        fetch('{{ route("messages.bulkMarkAsRead") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: selectedIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors du traitement');
        });
    }
}

// Supprimer les sélectionnés
function deleteSelected() {
    const selectedIds = Array.from(document.querySelectorAll('.message-checkbox:checked'))
        .map(cb => cb.value);

    if (selectedIds.length === 0) return;

    if (confirm(`Supprimer ${selectedIds.length} message(s) ? Cette action est irréversible.`)) {
        // Envoyer une requête DELETE
        fetch('{{ route("messages.bulkDelete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ids: selectedIds,
                _method: 'DELETE'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la suppression');
        });
    }
}

// Marquer comme lu au clic (si non lu)
document.addEventListener('click', function(e) {
    const messageItem = e.target.closest('.message-item[data-read="false"]');
    if (messageItem && !e.target.closest('a, button, form, .message-checkbox')) {
        const messageId = messageItem.dataset.id;

        fetch(`/messages/${messageId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageItem.dataset.read = 'true';
                messageItem.classList.remove('bg-blue-50', 'dark:bg-blue-900/10');
                messageItem.querySelectorAll('.text-blue-600, .text-blue-400, .font-medium')
                    .forEach(el => el.classList.remove('text-blue-600', 'text-blue-400', 'font-medium'));

                // Mettre à jour le badge non lu
                const unreadBadge = messageItem.querySelector('.bg-red-100');
                if (unreadBadge) unreadBadge.remove();
            }
        });
    }
});

// Recherche en temps réel (optionnel)
let searchTimeout;
const searchInput = document.querySelector('input[name="search"]');
if (searchInput) {
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            this.closest('form').submit();
        }, 500);
    });
}
</script>
@endpush
