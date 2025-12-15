@extends('layouts.app')

@section('title', 'Messages envoyés')
@section('subtitle', 'Historique de vos messages envoyés')

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
                <a href="{{ route('messages.inbox') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                    <i class="ti ti-mail mr-1"></i>
                    Messages
                </a>
            </li>
            <li class="flex items-center">
                <i class="ti ti-chevron-right text-gray-400 dark:text-gray-500 mx-1"></i>
                <span class="text-gray-600 dark:text-gray-300 font-medium">
                    <i class="ti ti-send mr-1"></i>
                    Messages envoyés
                </span>
            </li>
        </ol>
    </nav>

    <!-- Header avec statistiques -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl border border-green-100 dark:border-gray-700 p-6 mb-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-green-500 to-emerald-500 blur-lg opacity-20"></div>
                    <div class="relative bg-gradient-to-r from-green-600 to-emerald-500 p-3 rounded-xl shadow-lg">
                        <i class="ti ti-send text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Messages envoyés</h1>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">
                        {{ $messages->total() }} message(s) envoyé(s)
                        @php
                            $withAttachments = $messages->filter(fn($msg) => $msg->attachments?->count() > 0)->count();
                        @endphp
                        @if($withAttachments > 0)
                            <span class="font-semibold text-blue-500 dark:text-blue-400">
                                • {{ $withAttachments }} avec pièce(s) jointe(s)
                            </span>
                        @endif
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

                <a href="{{ route('messages.create') }}"
                   class="group relative overflow-hidden bg-gradient-to-r from-green-600 via-emerald-500 to-teal-500 hover:from-green-700 hover:via-emerald-600 hover:to-teal-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-700 via-emerald-600 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-plus relative z-10 text-sm"></i>
                    <span class="relative z-10">Nouveau message</span>
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
                <form method="GET" action="{{ route('messages.sent') }}" class="relative">
                    <div class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Rechercher dans les messages envoyés..."
                               class="w-full pl-12 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-600 dark:focus:border-green-600 transition-all duration-200"
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
                <!-- Filtre destinataire -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:border-green-400 dark:hover:border-green-500 transition-colors">
                        <i class="ti ti-users text-gray-500 dark:text-gray-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ request('recipient') ? 'Filtré' : 'Destinataire' }}
                        </span>
                        <i class="ti ti-chevron-down text-xs"></i>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg z-50 overflow-hidden max-h-60 overflow-y-auto">
                        <a href="{{ route('messages.sent', ['recipient' => '', 'search' => request('search')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-users mr-2"></i>
                            Tous les destinataires
                        </a>
                        @php
                            $recipients = $messages->pluck('recipient')->filter()->unique();
                        @endphp
                        @foreach($recipients as $recipient)
                            @if($recipient)
                            <a href="{{ route('messages.sent', ['recipient' => $recipient->id, 'search' => request('search')]) }}"
                               class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                                <i class="ti ti-user mr-2"></i>
                                {{ $recipient->name }}
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Filtre date -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:border-green-400 dark:hover:border-green-500 transition-colors">
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
                        <a href="{{ route('messages.sent', ['date' => '', 'search' => request('search'), 'recipient' => request('recipient')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-clock mr-2"></i>
                            Toute période
                        </a>
                        <a href="{{ route('messages.sent', ['date' => 'today', 'search' => request('search'), 'recipient' => request('recipient')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-sun mr-2 text-yellow-500"></i>
                            Aujourd'hui
                        </a>
                        <a href="{{ route('messages.sent', ['date' => 'week', 'search' => request('search'), 'recipient' => request('recipient')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-calendar-week mr-2 text-green-500"></i>
                            7 derniers jours
                        </a>
                        <a href="{{ route('messages.sent', ['date' => 'month', 'search' => request('search'), 'recipient' => request('recipient')]) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class="ti ti-calendar-month mr-2 text-emerald-500"></i>
                            30 derniers jours
                        </a>
                    </div>
                </div>

                <!-- Bouton effacer filtres -->
                @if(request('search') || request('recipient') || request('date'))
                <a href="{{ route('messages.sent') }}"
                   class="flex items-center gap-2 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium text-gray-700 dark:text-gray-300">
                    <i class="ti ti-filter-off"></i>
                    Effacer
                </a>
                @endif
            </div>
        </div>

        <!-- Filtres actifs -->
        @if(request('search') || request('recipient') || request('date'))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Filtres actifs :</span>

                @if(request('search'))
                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-sm">
                    <i class="ti ti-search text-xs"></i>
                    "{{ request('search') }}"
                    <a href="{{ route('messages.sent', array_merge(request()->except('search'), ['search' => ''])) }}"
                       class="text-green-400 hover:text-green-600 dark:hover:text-green-200 ml-1">
                        <i class="ti ti-x text-xs"></i>
                    </a>
                </span>
                @endif

                @if(request('recipient'))
                    @php
                        $recipient = \App\Models\User::find(request('recipient'));
                    @endphp
                    @if($recipient)
                    <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                        <i class="ti ti-user text-xs"></i>
                        À: {{ $recipient->name }}
                        <a href="{{ route('messages.sent', array_merge(request()->except('recipient'), ['recipient' => ''])) }}"
                           class="text-blue-400 hover:text-blue-600 dark:hover:text-blue-200 ml-1">
                            <i class="ti ti-x text-xs"></i>
                        </a>
                    </span>
                    @endif
                @endif

                @if(request('date'))
                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full text-sm">
                    <i class="ti ti-calendar text-xs"></i>
                    {{ request('date') == 'today' ? 'Aujourd\'hui' : (request('date') == 'week' ? '7 derniers jours' : '30 derniers jours') }}
                    <a href="{{ route('messages.sent', array_merge(request()->except('date'), ['date' => ''])) }}"
                       class="text-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-200 ml-1">
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
                            class="w-5 h-5 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 flex items-center justify-center text-green-600 dark:text-green-400 hover:border-green-400 dark:hover:border-green-500 transition-colors">
                        <i class="ti ti-check text-xs hidden"></i>
                    </button>

                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                        {{ $messages->total() }} message(s) envoyé(s)
                        @if($messages->filter(fn($msg) => $msg->attachments?->count() > 0)->count() > 0)
                            <span class="text-blue-500 dark:text-blue-400 ml-2">
                                ({{ $messages->filter(fn($msg) => $msg->attachments?->count() > 0)->count() }} avec pièce(s) jointe(s))
                            </span>
                        @endif
                    </p>
                </div>

                <!-- Actions groupées -->
                <div class="flex items-center gap-2" id="bulk-actions" style="display: none;">
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
                     data-id="{{ $message->id }}">
                    <div class="flex items-start gap-4">
                        <!-- Checkbox de sélection -->
                        <div class="pt-1">
                            <input type="checkbox"
                                   class="message-checkbox w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-green-600 dark:text-green-400 focus:ring-green-500 dark:focus:ring-green-600"
                                   value="{{ $message->id }}">
                        </div>

                        <!-- Icône envoyé -->
                        <div class="shrink-0">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 flex items-center justify-center">
                                <i class="ti ti-send text-green-500 dark:text-green-400 text-sm"></i>
                            </div>
                        </div>

                        <!-- Contenu du message -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="font-bold text-gray-900 dark:text-white truncate">
                                        {{ $message->sujet }}
                                    </h3>

                                    <!-- Badges -->
                                    <div class="flex items-center gap-2">
                                        @if($message->attachments?->count())
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                            <i class="ti ti-paperclip text-xs"></i>
                                            {{ $message->attachments->count() }}
                                        </span>
                                        @endif

@if($message->is_read)
    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">
        <i class="ti ti-eye-check text-xs"></i>
        Lu
    </span>
@else
    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
        <i class="ti ti-eye-off text-xs"></i>
        Non lu
    </span>
@endif

                                    </div>
                                </div>

                                <span class="text-xs text-gray-500 dark:text-gray-400 shrink-0">
                                    {{ $message->created_at?->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            <!-- Extrait -->
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2 line-clamp-2">
                                {{ \Illuminate\Support\Str::limit($message->contenu, 150) }}
                            </p>

                            <!-- Métadonnées -->
                            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2">
                                <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="ti ti-user-check text-xs"></i>
                                    <span class="font-medium text-gray-700 dark:text-gray-200">
                                        À: {{ $message->recipient?->name ?? 'Destinataire inconnu' }}
                                    </span>
                                </span>

                                @if($message->recipient?->roles->count())
                                <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="ti ti-badge text-xs"></i>
                                    {{ $message->recipient->roles->pluck('name')->join(', ') }}
                                </span>
                                @endif

                                <!-- Actions rapides -->
                                <div class="flex items-center gap-2 ml-auto">
                                    <a href="{{ route('messages.show', $message) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-medium transition-colors opacity-0 group-hover:opacity-100">
                                        <i class="ti ti-eye text-xs"></i>
                                        Voir
                                    </a>

                                    <a href=""
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-800/50 text-blue-700 dark:text-blue-300 text-xs font-medium transition-colors opacity-0 group-hover:opacity-100">
                                        <i class="ti ti-share text-xs"></i>
                                        Transférer
                                    </a>

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
                        <i class="ti ti-send text-gray-400 text-2xl"></i>
                    </div>
                    @if(request('search') || request('recipient') || request('date'))
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            Aucun message trouvé
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">
                            Essayez de modifier vos filtres ou votre recherche
                        </p>
                        <a href="{{ route('messages.sent') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium">
                            <i class="ti ti-filter-off"></i>
                            Effacer tous les filtres
                        </a>
                    @else
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                            Aucun message envoyé
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">
                            Les messages que vous envoyez apparaîtront ici
                        </p>
                        <a href="{{ route('messages.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 text-white rounded-lg transition-colors text-sm font-medium">
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
        background: rgba(16, 185, 129, 0.05);
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

// Supprimer les sélectionnés

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

// Prévisualisation du message
function previewMessage(id) {
    // Vous pouvez implémenter une modal de prévisualisation ici
    window.location.href = `/messages/${id}`;
}
</script>
@endpush
