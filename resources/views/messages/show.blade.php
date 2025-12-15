@extends('layouts.app')

@section('title', $message->sujet)
@section('subtitle', 'Détail du message')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
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
                @if(auth()->id() === $message->recipient_id)
                <a href="{{ route('messages.inbox') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                    <i class="ti ti-inbox mr-1"></i>
                    Boîte de réception
                </a>
                @else
                <a href="{{ route('messages.sent') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                    <i class="ti ti-send mr-1"></i>
                    Messages envoyés
                </a>
                @endif
            </li>
            <li class="flex items-center">
                <i class="ti ti-chevron-right text-gray-400 dark:text-gray-500 mx-1"></i>
                <span class="text-gray-600 dark:text-gray-300 font-medium truncate max-w-xs">
                    <i class="ti ti-mail mr-1"></i>
                    {{ Str::limit($message->sujet, 30) }}
                </span>
            </li>
        </ol>
    </nav>

    <!-- Header avec infos -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl border border-blue-100 dark:border-gray-700 p-6 mb-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-blue-500 to-indigo-500 blur-lg opacity-20"></div>
                    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-500 p-3 rounded-xl shadow-lg">
                        <i class="ti ti-mail text-white text-xl"></i>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white truncate">
                        {{ $message->sujet }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2">
                        <span class="inline-flex items-center gap-1 text-sm text-gray-600 dark:text-gray-300">
                            <i class="ti ti-clock text-sm"></i>
                            {{ $message->created_at->format('d/m/Y à H:i') }}
                        </span>
                        @if($message->is_read && auth()->id() === $message->recipient_id)
                        <span class="inline-flex items-center gap-1 text-sm text-green-600 dark:text-green-400">
                            <i class="ti ti-eye-check text-sm"></i>
                            Lu
                        </span>
                        @endif
                        @if($message->attachments->count())
                        <span class="inline-flex items-center gap-1 text-sm text-blue-600 dark:text-blue-400">
                            <i class="ti ti-paperclip text-sm"></i>
                            {{ $message->attachments->count() }} pièce(s) jointe(s)
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if(auth()->id() === $message->recipient_id && !$message->is_read)
                <form method="POST" action="{{ route('messages.markAsRead', $message) }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="group relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-eye-check relative z-10"></i>
                        <span class="relative z-10">Marquer comme lu</span>
                    </button>
                </form>
                @endif

                <a href="{{ auth()->id() === $message->recipient_id ? route('messages.inbox') : route('messages.sent') }}"
                   class="group relative overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-lg font-medium hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-arrow-left relative z-10"></i>
                    <span class="relative z-10">Retour</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Informations d'envoi -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Carte Expéditeur -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                    <i class="ti ti-user text-white text-sm"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Expéditeur</h3>
            </div>

            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                        @if($message->sender?->avatar)
                            <img src="{{ $message->sender->avatar }}"
                                 alt="{{ $message->sender->name }}"
                                 class="w-12 h-12 rounded-full">
                        @else
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                {{ substr($message->sender?->name ?? '?', 0, 1) }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">
                            {{ $message->sender?->name ?? '—' }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $message->sender?->email ?? '—' }}
                        </p>
                    </div>
                </div>

                @if($message->sender?->roles->count())
                <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Rôle(s)</p>
                    <div class="flex flex-wrap gap-1">
                        @foreach($message->sender->roles as $role)
                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                            <i class="ti ti-badge text-xs"></i>
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Carte Destinataire -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-green-500 to-emerald-400 flex items-center justify-center">
                    <i class="ti ti-user-check text-white text-sm"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Destinataire</h3>
            </div>

            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 flex items-center justify-center">
                        @if($message->recipient?->avatar)
                            <img src="{{ $message->recipient->avatar }}"
                                 alt="{{ $message->recipient->name }}"
                                 class="w-12 h-12 rounded-full">
                        @else
                            <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                {{ substr($message->recipient?->name ?? '?', 0, 1) }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">
                            {{ $message->recipient?->name ?? '—' }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $message->recipient?->email ?? '—' }}
                        </p>
                    </div>
                </div>

                @if($message->recipient?->roles->count())
                <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Rôle(s)</p>
                    <div class="flex flex-wrap gap-1">
                        @foreach($message->recipient->roles as $role)
                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                            <i class="ti ti-badge text-xs"></i>
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(auth()->id() === $message->recipient_id)
                <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Statut</p>
                    @if($message->is_read)
                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                        <i class="ti ti-eye-check text-xs"></i>
                        Lu le {{ $message->read_at?->format('d/m/Y H:i') ?? '-' }}
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300">
                        <i class="ti ti-eye-off text-xs"></i>
                        Non lu
                    </span>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Carte Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-purple-500 to-pink-400 flex items-center justify-center">
                    <i class="ti ti-settings text-white text-sm"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Actions</h3>
            </div>

            <div class="space-y-3">
                <a href="{{ route('messages.create', ['reply' => $message->id]) }}"
                   class="group relative overflow-hidden w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-3 rounded-lg font-medium hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/10 dark:to-cyan-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-corner-up-left relative z-10"></i>
                    <span class="relative z-10">Répondre</span>
                </a>

                <a href=""
                   class="group relative overflow-hidden w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-3 rounded-lg font-medium hover:border-green-300 dark:hover:border-green-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/10 dark:to-emerald-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-share relative z-10"></i>
                    <span class="relative z-10">Transférer</span>
                </a>

                @if(auth()->id() === $message->user_id)
                <form method="POST" action="{{ route('messages.destroy', $message) }}" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.')"
                            class="group relative overflow-hidden w-full bg-gradient-to-r from-red-600 via-orange-500 to-amber-400 hover:from-red-700 hover:via-orange-600 hover:to-amber-500 text-white px-4 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-trash relative z-10"></i>
                        <span class="relative z-10">Supprimer</span>
                    </button>
                </form>
                @endif

                <button onclick="window.print()"
                        class="group relative overflow-hidden w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-3 rounded-lg font-medium hover:border-purple-300 dark:hover:border-purple-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/10 dark:to-pink-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-printer relative z-10"></i>
                    <span class="relative z-10">Imprimer</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Contenu du message -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden mb-6">
        <!-- En-tête du contenu -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-400 flex items-center justify-center">
                    <i class="ti ti-file-text text-white text-sm"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Contenu du message</h3>
            </div>
        </div>

        <!-- Corps du message -->
        <div class="p-6">
            <div class="prose prose-blue dark:prose-invert max-w-none dark:prose-dark">
                <div class="whitespace-pre-wrap text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                    {!! nl2br(e($message->contenu)) !!}
                </div>
            </div>

            <!-- Métadonnées bas -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center gap-1">
                            <i class="ti ti-calendar"></i>
                            Envoyé le {{ $message->created_at->format('d/m/Y à H:i') }}
                        </span>
                        @if($message->created_at != $message->updated_at)
                        <span class="inline-flex items-center gap-1">
                            <i class="ti ti-edit"></i>
                            Modifié le {{ $message->updated_at->format('d/m/Y à H:i') }}
                        </span>
                        @endif
                    </div>

                    <span class="inline-flex items-center gap-1">
                        <i class="ti ti-hash"></i>
                        ID: {{ $message->id }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pièces jointes -->
    @if($message->attachments->count())
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <!-- En-tête des pièces jointes -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="ti ti-paperclip text-white text-sm"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Pièces jointes
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                            {{ $message->attachments->count() }}
                        </span>
                    </h3>
                </div>

                @if($message->attachments->count() > 1)
                <button onclick="downloadAllAttachments()"
                        class="group relative overflow-hidden bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-4 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 text-sm">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-cyan-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="ti ti-download relative z-10"></i>
                    <span class="relative z-10">Tout télécharger</span>
                </button>
                @endif
            </div>
        </div>

        <!-- Liste des fichiers -->
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($message->attachments as $file)
                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition group">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center space-x-4 flex-1 min-w-0">
                            <!-- Icône du fichier -->
                            <div class="shrink-0">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                                    @php
                                        $icon = match(pathinfo($file->original_name, PATHINFO_EXTENSION)) {
                                            'pdf' => 'ti-file-text',
                                            'doc', 'docx' => 'ti-file-word',
                                            'xls', 'xlsx' => 'ti-file-spreadsheet',
                                            'jpg', 'jpeg', 'png', 'gif' => 'ti-photo',
                                            'zip', 'rar' => 'ti-file-zip',
                                            default => 'ti-file'
                                        };
                                    @endphp
                                    <i class="ti {{ $icon }} text-blue-500 text-lg"></i>
                                </div>
                            </div>

                            <!-- Infos du fichier -->
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900 dark:text-white truncate">
                                    {{ $file->original_name }}
                                </h4>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="inline-flex items-center gap-1">
                                        <i class="ti ti-file-text text-xs"></i>
                                        {{ strtoupper($file->mime_type) }}
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <i class="ti ti-ruler-2 text-xs"></i>
                                        {{ formatFileSize($file->size) }}
                                    </span>
                                    @if($file->created_at)
                                    <span class="inline-flex items-center gap-1">
                                        <i class="ti ti-calendar text-xs"></i>
                                        {{ $file->created_at->format('d/m/Y') }}
                                    </span>
                                    @endif
                                </div>

                                <!-- Barre de progression (simulée) -->
                                <div class="mt-3">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-blue-500 to-cyan-400 h-1.5 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ asset('storage/'.$file->path) }}"
                               target="_blank"
                               class="group/action relative overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-lg font-medium hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                <div class="absolute inset-0 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 opacity-0 group-hover/action:opacity-100 transition-opacity duration-300"></div>
                                <i class="ti ti-eye relative z-10"></i>
                                <span class="relative z-10">Prévisualiser</span>
                            </a>

                            <a href="{{ asset('storage/'.$file->path) }}"
                               download="{{ $file->original_name }}"
                               class="group/action relative overflow-hidden bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-cyan-600 opacity-0 group-hover/action:opacity-100 transition-opacity duration-300"></div>
                                <i class="ti ti-download relative z-10"></i>
                                <span class="relative z-10">Télécharger</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    @keyframes slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .animate-slide-in { animation: slide-in 0.3s ease-out forwards; }

    .prose-dark {
        color: #d1d5db;
    }

    .prose-dark h1, .prose-dark h2, .prose-dark h3, .prose-dark h4 {
        color: #f3f4f6;
    }

    .prose-dark a {
        color: #60a5fa;
    }

    .prose-dark code {
        background-color: #374151;
        color: #f3f4f6;
    }
</style>
@endpush

@push('scripts')
<script>
// Télécharger toutes les pièces jointes
function downloadAllAttachments() {
    // Ici vous pouvez implémenter la logique pour télécharger toutes les pièces jointes
    // Par exemple, créer un zip côté serveur ou ouvrir chaque lien dans une nouvelle fenêtre

    @foreach($message->attachments as $file)
        window.open('{{ asset('storage/'.$file->path) }}', '_blank');
    @endforeach

    // Afficher une notification
    showNotification('Téléchargement des fichiers en cours...', 'info');
}

// Afficher une notification
function showNotification(message, type = 'info') {
    const container = document.createElement('div');
    container.className = `fixed bottom-4 right-4 bg-gradient-to-r ${
        type === 'info' ? 'from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 border-blue-200 dark:border-blue-800' :
        type === 'success' ? 'from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border-green-200 dark:border-green-800' :
        'from-yellow-50 to-amber-50 dark:from-yellow-900/30 dark:to-amber-900/30 border-yellow-200 dark:border-yellow-800'
    } border rounded-xl shadow-lg p-4 max-w-sm z-50 animate-slide-in`;

    container.innerHTML = `
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r ${
                type === 'info' ? 'from-blue-400 to-cyan-500' :
                type === 'success' ? 'from-green-400 to-emerald-500' :
                'from-yellow-400 to-amber-500'
            } flex items-center justify-center">
                <i class="ti ti-${type === 'info' ? 'info-circle' : type === 'success' ? 'check' : 'alert-circle'} text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium ${
                    type === 'info' ? 'text-blue-800 dark:text-blue-200' :
                    type === 'success' ? 'text-green-800 dark:text-green-200' :
                    'text-yellow-800 dark:text-yellow-200'
                }">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="ti ti-x"></i>
            </button>
        </div>
    `;

    document.body.appendChild(container);

    // Auto-remove après 5 secondes
    setTimeout(() => {
        if (container.parentNode) {
            container.remove();
        }
    }, 5000);
}

// Prévisualisation d'image
function previewImage(url) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4';
    modal.innerHTML = `
        <div class="relative max-w-4xl max-h-[90vh]">
            <img src="${url}" alt="Preview" class="max-w-full max-h-[90vh] rounded-lg">
            <button onclick="this.parentElement.parentElement.remove()"
                    class="absolute -top-10 right-0 text-white hover:text-gray-300">
                <i class="ti ti-x text-2xl"></i>
            </button>
        </div>
    `;

    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.remove();
        }
    });

    document.body.appendChild(modal);
}

// Copier le contenu du message
function copyMessageContent() {
    const content = document.querySelector('.prose').innerText;
    navigator.clipboard.writeText(content)
        .then(() => showNotification('Contenu copié dans le presse-papier', 'success'))
        .catch(() => showNotification('Erreur lors de la copie', 'error'));
}

// Partage du message
function shareMessage() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $message->sujet }}',
            text: '{{ Str::limit($message->contenu, 100) }}',
            url: window.location.href,
        });
    } else {
        navigator.clipboard.writeText(window.location.href)
            .then(() => showNotification('Lien copié dans le presse-papier', 'success'))
            .catch(() => showNotification('Erreur lors de la copie', 'error'));
    }
}

// Marquer comme important
function toggleImportant() {
    // Implémenter la logique pour marquer comme important
    showNotification('Message marqué comme important', 'success');
}

// Mode sombre automatique pour le contenu
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.querySelector('.prose').classList.add('dark:prose-invert');
}
</script>
@endpush

<?php
// Helper function pour formater la taille des fichiers
if (!function_exists('formatFileSize')) {
    function formatFileSize($bytes, $decimals = 2) {
        $size = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    }
}
?>
