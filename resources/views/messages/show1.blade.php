@extends('layouts.app')

@section('title', $message->sujet)
@section('subtitle', 'Détail du message')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
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
                    {{ \Illuminate\Support\Str::limit($message->sujet, 30) }}
                </span>
            </li>
        </ol>
    </nav>

    <!-- Flash messages -->
    @if (session('success'))
        <div id="success-alert" class="mb-6 animate-slide-in">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border border-green-200 dark:border-green-800 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center">
                            <i class="ti ti-check text-white text-sm"></i>
                        </div>
                        <p class="font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                    </div>
                    <button onclick="document.getElementById('success-alert').remove()"
                            class="text-green-400 hover:text-green-600 dark:hover:text-green-300">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Quick Actions Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-400 flex items-center justify-center">
                        <i class="ti ti-bolt text-white text-sm"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Actions rapides</h3>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('messages.create', ['reply' => $message->id]) }}"
                       class="group relative overflow-hidden w-full bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 text-white px-4 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-corner-up-left relative z-10"></i>
                        <span class="relative z-10">Répondre</span>
                    </a>

                    <a href=""
                       class="group relative overflow-hidden w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-3 rounded-lg font-medium hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/10 dark:to-cyan-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-share relative z-10"></i>
                        <span class="relative z-10">Transférer</span>
                    </a>

                    <button onclick="copyMessageLink()"
                            class="group relative overflow-hidden w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-3 rounded-lg font-medium hover:border-purple-300 dark:hover:border-purple-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/10 dark:to-pink-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="ti ti-link relative z-10"></i>
                        <span class="relative z-10">Copier le lien</span>
                    </button>

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
                </div>
            </div>

            <!-- Message Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-400 flex items-center justify-center">
                        <i class="ti ti-info-circle text-white text-sm"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informations</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Statut</p>
                        @if(auth()->id() === $message->recipient_id)
                            @if($message->is_read)
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm font-medium">
                                <i class="ti ti-eye-check text-xs"></i>
                                Lu
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-sm font-medium">
                                <i class="ti ti-eye-off text-xs"></i>
                                Non lu
                            </span>
                            @endif
                        @else
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm font-medium">
                            <i class="ti ti-send text-xs"></i>
                            Envoyé
                        </span>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Date d'envoi</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">ID du message</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white font-mono">
                            #{{ $message->id }}
                        </p>
                    </div>

                    @if($message->attachments->count())
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Pièces jointes</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $message->attachments->count() }} fichier(s)
                        </p>
                    </div>
                    @endif

                    @if($message->replies->count())
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Réponses</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $message->replies->count() }} réponse(s)
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Header Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-400 flex items-center justify-center">
                                <i class="ti ti-mail text-white text-sm"></i>
                            </div>
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white truncate">
                                {{ $message->sujet }}
                            </h1>
                        </div>

                        <div class="flex items-center gap-2">
                            @if(auth()->id() === $message->recipient_id && !$message->is_read)
                                <form method="POST" action="{{ route('messages.markAsRead', $message) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="group relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 text-white px-4 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 text-sm">
                                        <div class="absolute inset-0 bg-gradient-to-r from-green-700 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <i class="ti ti-eye-check relative z-10"></i>
                                        <span class="relative z-10">Marquer comme lu</span>
                                    </button>
                                </form>
                            @endif

                            <a href="{{ auth()->id() === $message->recipient_id ? route('messages.inbox') : route('messages.sent') }}"
                               class="group relative overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg font-medium hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2 text-sm">
                                <div class="absolute inset-0 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <i class="ti ti-arrow-left relative z-10"></i>
                                <span class="relative z-10">Retour</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Participants -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                        <!-- Sender -->
                        <div class="flex items-center space-x-3 flex-1">
                            <div class="relative">
                                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-blue-500 to-cyan-400 blur opacity-30"></div>
                                <div class="relative w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 flex items-center justify-center">
                                    @if($message->sender?->avatar)
                                        <img src="{{ $message->sender->avatar }}"
                                             alt="{{ $message->sender->name }}"
                                             class="w-12 h-12 rounded-full">
                                    @else
                                        <span class="text-lg font-bold text-white">
                                            {{ substr($message->sender?->name ?? '?', 0, 1) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Expéditeur</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $message->sender?->name ?? '—' }}</p>
                                @if($message->sender?->roles->count())
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $message->sender->roles->pluck('name')->join(', ') }}
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="hidden sm:block">
                            <div class="w-8 h-0.5 bg-gradient-to-r from-blue-400 to-cyan-300"></div>
                        </div>

                        <!-- Recipient -->
                        <div class="flex items-center space-x-3 flex-1">
                            <div class="relative">
                                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-green-500 to-emerald-400 blur opacity-30"></div>
                                <div class="relative w-12 h-12 rounded-full bg-gradient-to-r from-green-600 to-emerald-500 flex items-center justify-center">
                                    @if($message->recipient?->avatar)
                                        <img src="{{ $message->recipient->avatar }}"
                                             alt="{{ $message->recipient->name }}"
                                             class="w-12 h-12 rounded-full">
                                    @else
                                        <span class="text-lg font-bold text-white">
                                            {{ substr($message->recipient?->name ?? '?', 0, 1) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Destinataire</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $message->recipient?->name ?? '—' }}</p>
                                @if($message->recipient?->roles->count())
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $message->recipient->roles->pluck('name')->join(', ') }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Content -->
                <div class="p-6">
                    <div class="prose prose-blue dark:prose-invert max-w-none dark:prose-dark">
                        <div class="whitespace-pre-wrap text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! nl2br(e($message->contenu)) !!}
                        </div>
                    </div>

                    <!-- Message Footer -->
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attachments Section -->
            @if($message->attachments->count())
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                    @foreach($message->attachments as $file)
                        <div class="group relative bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                            <div class="flex items-start space-x-3">
                                <div class="shrink-0">
                                    @php
                                        $icon = match(pathinfo($file->original_name, PATHINFO_EXTENSION)) {
                                            'pdf' => 'ti-file-text',
                                            'doc', 'docx' => 'ti-file-word',
                                            'xls', 'xlsx', 'csv' => 'ti-file-spreadsheet',
                                            'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp' => 'ti-photo',
                                            'zip', 'rar', '7z', 'tar', 'gz' => 'ti-file-zip',
                                            'mp4', 'avi', 'mov', 'wmv' => 'ti-video',
                                            'mp3', 'wav', 'ogg' => 'ti-music',
                                            default => 'ti-file'
                                        };
                                        $color = match(pathinfo($file->original_name, PATHINFO_EXTENSION)) {
                                            'pdf' => 'from-red-500 to-pink-400',
                                            'doc', 'docx' => 'from-blue-500 to-cyan-400',
                                            'xls', 'xlsx', 'csv' => 'from-green-500 to-emerald-400',
                                            'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp' => 'from-purple-500 to-pink-400',
                                            'zip', 'rar', '7z', 'tar', 'gz' => 'from-yellow-500 to-orange-400',
                                            'mp4', 'avi', 'mov', 'wmv' => 'from-red-500 to-orange-400',
                                            'mp3', 'wav', 'ogg' => 'from-indigo-500 to-purple-400',
                                            default => 'from-gray-500 to-gray-400'
                                        };
                                    @endphp
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-r {{ $color }} flex items-center justify-center">
                                        <i class="ti {{ $icon }} text-white text-lg"></i>
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 dark:text-white truncate mb-1">
                                        {{ $file->original_name }}
                                    </h4>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400 mb-2">
                                        <span>{{ strtoupper($file->mime_type) }}</span>
                                        <span>•</span>
                                        <span>{{ formatFileSize($file->size) }}</span>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r {{ $color }} h-1.5 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="absolute right-3 top-3 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <a href="{{ asset('storage/'.$file->path) }}"
                                   target="_blank"
                                   class="w-8 h-8 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 hover:border-blue-300 dark:hover:border-blue-600 transition-colors"
                                   title="Prévisualiser">
                                    <i class="ti ti-eye text-sm"></i>
                                </a>
                                <a href="{{ asset('storage/'.$file->path) }}"
                                   download="{{ $file->original_name }}"
                                   class="w-8 h-8 rounded-lg bg-gradient-to-r {{ $color }} flex items-center justify-center text-white hover:shadow-lg transition-shadow"
                                   title="Télécharger">
                                    <i class="ti ti-download text-sm"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Replies Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-green-500 to-emerald-400 flex items-center justify-center">
                                <i class="ti ti-messages text-white text-sm"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Réponses
                                <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                                    {{ $message->replies->count() }}
                                </span>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($message->replies as $reply)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition group">
                            <div class="flex items-start space-x-4">
                                <!-- Avatar -->
                                <div class="shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-400 flex items-center justify-center">
                                        @if($reply->user?->avatar)
                                            <img src="{{ $reply->user->avatar }}"
                                                 alt="{{ $reply->user->name }}"
                                                 class="w-10 h-10 rounded-full">
                                        @else
                                            <span class="text-sm font-bold text-white">
                                                {{ substr($reply->user?->name ?? '?', 0, 1) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                                {{ $reply->user?->name ?? 'Utilisateur' }}
                                            </h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                <i class="ti ti-clock mr-1"></i>
                                                {{ $reply->created_at?->diffForHumans() }}
                                                ({{ $reply->created_at?->format('d/m/Y H:i') }})
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <button onclick="copyReplyContent({{ $reply->id }})"
                                                    class="w-8 h-8 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400 hover:border-blue-300 dark:hover:border-blue-600 transition-colors"
                                                    title="Copier">
                                                <i class="ti ti-copy text-sm"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="prose prose-sm dark:prose-invert max-w-none">
                                        <div class="whitespace-pre-wrap text-gray-700 dark:text-gray-300">
                                            {!! nl2br(e($reply->contenu)) !!}
                                        </div>
                                    </div>

                                    <!-- Reply Attachments -->
                                    @if($reply->attachments && $reply->attachments->count())
                                        <div class="mt-4 flex flex-wrap gap-2">
                                            @foreach($reply->attachments as $att)
                                                <a href="{{ asset('storage/'.$att->path) }}"
                                                   target="_blank"
                                                   class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-sm transition-all duration-200 group/att">
                                                    <div class="w-6 h-6 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                                                        <i class="ti ti-paperclip text-blue-500 text-xs"></i>
                                                    </div>
                                                    <span class="text-sm text-gray-700 dark:text-gray-200 truncate max-w-xs group-hover/att:text-blue-600 dark:group-hover/att:text-blue-400">
                                                        {{ $att->original_name ?? 'Fichier' }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    </span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center mx-auto mb-3">
                                <i class="ti ti-message-off text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 font-medium">Aucune réponse pour le moment.</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Soyez le premier à répondre à ce message.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Reply Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-400 flex items-center justify-center">
                            <i class="ti ti-edit text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ajouter une réponse</h3>
                    </div>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('messages.reply', $message) }}" enctype="multipart/form-data" id="reply-form">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Votre réponse
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea name="contenu"
                                      rows="5"
                                      required
                                      placeholder="Tapez votre réponse ici..."
                                      class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition resize-none"
                                      oninput="updateCharCount(this)"
                                      maxlength="5000">{{ old('contenu') }}</textarea>
                            <div class="flex justify-between items-center mt-2">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Soyez clair et concis dans votre réponse
                                </p>
                                <span id="char-count" class="text-xs text-gray-400 dark:text-gray-500">0/5000</span>
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pièces jointes (optionnel)
                            </label>

                            <div id="drop-zone"
                                 class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center transition-all duration-300 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 cursor-pointer">
                                <input type="file"
                                       name="attachments[]"
                                       id="file-input"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       multiple>

                                <div class="space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center mx-auto">
                                        <i class="ti ti-cloud-upload text-blue-500 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-700 dark:text-gray-300">
                                            Glissez-déposez vos fichiers ici
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            ou cliquez pour sélectionner
                                        </p>
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                        Formats supportés: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, ZIP
                                        <br>
                                        Taille maximale: 10MB par fichier
                                    </div>
                                </div>
                            </div>

                            <!-- File List -->
                            <div id="file-list" class="mt-4 space-y-2 hidden">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Fichiers sélectionnés :</p>
                                <div id="selected-files" class="space-y-2"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <button type="reset"
                                    class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium">
                                Effacer
                            </button>
                            <button type="submit"
                                    class="group relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-700 hover:to-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                                <i class="ti ti-send text-sm"></i>
                                Envoyer la réponse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

    .prose-dark {
        color: #d1d5db;
    }

    .prose-dark h1, .prose-dark h2, .prose-dark h3, .prose-dark h4 {
        color: #f3f4f6;
    }

    .prose-dark a {
        color: #60a5fa;
    }

    #drop-zone.dragover {
        border-color: #3b82f6;
        background-color: rgba(59, 130, 246, 0.05);
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

    // File upload with drag and drop
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    const fileList = document.getElementById('file-list');
    const selectedFiles = document.getElementById('selected-files');

    if (dropZone && fileInput) {
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop zone when dragging over
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropZone.classList.add('dragover');
        }

        function unhighlight() {
            dropZone.classList.remove('dragover');
        }

        // Handle dropped files
        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        // Handle file input change
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            selectedFiles.innerHTML = '';

            if (files.length > 0) {
                fileList.classList.remove('hidden');

                Array.from(files).forEach((file, index) => {
                    if (file.size > 10 * 1024 * 1024) {
                        showNotification(`Le fichier "${file.name}" dépasse 10MB`, 'error');
                        return;
                    }

                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex items-center justify-between';

                    fileItem.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                                <i class="ti ti-file text-blue-500 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate max-w-[180px]">
                                    ${file.name}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    ${formatBytes(file.size)}
                                </p>
                            </div>
                        </div>
                        <button type="button" onclick="removeFile(${index})" class="text-red-400 hover:text-red-600">
                            <i class="ti ti-x"></i>
                        </button>
                    `;

                    selectedFiles.appendChild(fileItem);
                });
            } else {
                fileList.classList.add('hidden');
            }
        }
    }
});

// Character counter for reply textarea
function updateCharCount(textarea) {
    const charCount = document.getElementById('char-count');
    if (charCount) {
        charCount.textContent = `${textarea.value.length}/5000`;

        if (textarea.value.length > 4500) {
            charCount.classList.remove('text-gray-400', 'dark:text-gray-500');
            charCount.classList.add('text-red-500', 'dark:text-red-400');
        } else {
            charCount.classList.remove('text-red-500', 'dark:text-red-400');
            charCount.classList.add('text-gray-400', 'dark:text-gray-500');
        }
    }
}

// Helper function to format bytes
function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

// Remove file from list
function removeFile(index) {
    const fileInput = document.getElementById('file-input');
    const dt = new DataTransfer();
    const files = fileInput.files;

    Array.from(files).forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });

    fileInput.files = dt.files;

    // Update file list display
    const fileList = document.getElementById('file-list');
    const selectedFiles = document.getElementById('selected-files');

    selectedFiles.innerHTML = '';

    if (dt.files.length > 0) {
        fileList.classList.remove('hidden');

        Array.from(dt.files).forEach((file, i) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item bg-gray-50 dark:bg-gray-700 rounded-lg p-3 flex items-center justify-between';

            fileItem.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-md bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 flex items-center justify-center">
                        <i class="ti ti-file text-blue-500 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate max-w-[180px]">
                            ${file.name}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            ${formatBytes(file.size)}
                        </p>
                    </div>
                </div>
                <button type="button" onclick="removeFile(${i})" class="text-red-400 hover:text-red-600">
                    <i class="ti ti-x"></i>
                </button>
            `;

            selectedFiles.appendChild(fileItem);
        });
    } else {
        fileList.classList.add('hidden');
    }
}

// Copy message link to clipboard
function copyMessageLink() {
    navigator.clipboard.writeText(window.location.href)
        .then(() => showNotification('Lien copié dans le presse-papier', 'success'))
        .catch(() => showNotification('Erreur lors de la copie', 'error'));
}

// Copy reply content to clipboard
function copyReplyContent(replyId) {
    const replyElement = document.querySelector(`[data-reply-id="${replyId}"]`);
    if (!replyElement) return;

    const content = replyElement.textContent;
    navigator.clipboard.writeText(content)
        .then(() => showNotification('Réponse copiée dans le presse-papier', 'success'))
        .catch(() => showNotification('Erreur lors de la copie', 'error'));
}

// Download all attachments
function downloadAllAttachments() {
    showNotification('Préparation du téléchargement...', 'info');

    // In a real implementation, you would make an API call to zip and download all files
    // For now, open each in a new tab
    @foreach($message->attachments as $file)
        setTimeout(() => window.open('{{ asset('storage/'.$file->path) }}', '_blank'), {{ $loop->index * 300 }});
    @endforeach
}

// Show notification
function showNotification(message, type = 'info') {
    const container = document.createElement('div');
    container.className = `fixed bottom-4 right-4 bg-gradient-to-r ${
        type === 'info' ? 'from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 border-blue-200 dark:border-blue-800' :
        type === 'success' ? 'from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border-green-200 dark:border-green-800' :
        'from-red-50 to-orange-50 dark:from-red-900/30 dark:to-orange-900/30 border-red-200 dark:border-red-800'
    } border rounded-xl shadow-lg p-4 max-w-sm z-50 animate-slide-in`;

    container.innerHTML = `
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-r ${
                type === 'info' ? 'from-blue-400 to-cyan-500' :
                type === 'success' ? 'from-green-400 to-emerald-500' :
                'from-red-400 to-orange-500'
            } flex items-center justify-center">
                <i class="ti ti-${type === 'info' ? 'info-circle' : type === 'success' ? 'check' : 'alert-circle'} text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium ${
                    type === 'info' ? 'text-blue-800 dark:text-blue-200' :
                    type === 'success' ? 'text-green-800 dark:text-green-200' :
                    'text-red-800 dark:text-red-200'
                }">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="ti ti-x"></i>
            </button>
        </div>
    `;

    document.body.appendChild(container);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (container.parentNode) {
            container.remove();
        }
    }, 5000);
}
</script>
@endpush

<?php
if (!function_exists('formatFileSize')) {
    function formatFileSize($bytes, $decimals = 2) {
        if ($bytes === null) return '-';
        $size = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen((string)$bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . ($size[$factor] ?? 'B');
    }
}
?>
