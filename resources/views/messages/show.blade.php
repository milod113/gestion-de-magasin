@extends('layouts.app')

@section('title', $message->sujet)
@section('subtitle', 'Détail du message')

@section('content')
<div x-data="{ replyOpen: false }" x-cloak class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

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
        <div class="mb-6">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border border-green-200 dark:border-green-800 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center">
                            <i class="ti ti-check text-white text-sm"></i>
                        </div>
                        <p class="font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.closest('.mb-6').remove()"
                            class="text-green-400 hover:text-green-600 dark:hover:text-green-300">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6">
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl p-4 shadow-sm">
                <p class="font-semibold text-red-700 dark:text-red-200 mb-2">Erreurs :</p>
                <ul class="list-disc pl-5 text-red-700 dark:text-red-200 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Header -->
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

                        @if(auth()->id() === $message->recipient_id)
                            @if($message->is_read)
                                <span class="inline-flex items-center gap-1 text-sm text-green-600 dark:text-green-400">
                                    <i class="ti ti-eye-check text-sm"></i>
                                    Lu
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-sm text-yellow-600 dark:text-yellow-400">
                                    <i class="ti ti-eye-off text-sm"></i>
                                    Non lu
                                </span>
                            @endif
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

                <!-- Reply trigger -->
                <button type="button"
                        @click="replyOpen = true"
                        class="group relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-700 hover:to-indigo-600 text-white px-4 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                    <i class="ti ti-corner-up-left relative z-10"></i>
                    <span class="relative z-10">Répondre</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-400 flex items-center justify-center">
                    <i class="ti ti-file-text text-white text-sm"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Contenu du message</h3>
            </div>
        </div>

        <div class="p-6">
            <div class="whitespace-pre-wrap text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                {!! nl2br(e($message->contenu)) !!}
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400">
                    <span class="inline-flex items-center gap-1">
                        <i class="ti ti-calendar"></i>
                        Envoyé le {{ $message->created_at->format('d/m/Y à H:i') }}
                    </span>

                    <span class="inline-flex items-center gap-1">
                        <i class="ti ti-hash"></i>
                        ID: {{ $message->id }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Attachments (Message) -->
    @if($message->attachments->count())
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center">
                        <i class="ti ti-paperclip text-white text-sm"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Pièces jointes (message)
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                            {{ $message->attachments->count() }}
                        </span>
                    </h3>
                </div>
            </div>

            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($message->attachments as $file)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <div class="flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="font-medium text-gray-900 dark:text-white truncate">{{ $file->original_name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $file->mime_type }} • {{ formatFileSize($file->size) }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ asset('storage/'.$file->path) }}" target="_blank"
                                   class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow text-sm">
                                    <i class="ti ti-eye mr-1"></i> Voir
                                </a>
                                <a href="{{ asset('storage/'.$file->path) }}" download="{{ $file->original_name }}"
                                   class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-500 text-white hover:shadow text-sm">
                                    <i class="ti ti-download mr-1"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Replies -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden mb-6">
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

                <!-- Reply trigger (top right) -->
                <button type="button"
                        @click="replyOpen = true"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:shadow text-sm font-medium text-gray-700 dark:text-gray-200">
                    <i class="ti ti-plus"></i>
                    Ajouter une réponse
                </button>
            </div>
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($message->replies as $reply)
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white">
                                {{ $reply->user?->name ?? 'Utilisateur' }}
                                <span class="text-sm text-gray-500 dark:text-gray-400 font-normal">
                                    • {{ $reply->created_at?->format('d/m/Y H:i') }}
                                </span>
                            </p>

                            <div class="mt-2 whitespace-pre-wrap text-gray-700 dark:text-gray-300">
                                {!! nl2br(e($reply->contenu)) !!}
                            </div>

                            @if($reply->attachments && $reply->attachments->count())
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach($reply->attachments as $att)
                                        <a href="{{ asset('storage/'.$att->path) }}" target="_blank"
                                           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-200 hover:shadow">
                                            <i class="ti ti-paperclip"></i>
                                            <span class="truncate max-w-xs">{{ $att->original_name ?? 'Fichier' }}</span>
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
                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-3">
                        <i class="ti ti-message text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 font-medium">Aucune réponse pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ===========================
         Reply Modal
    ============================ -->
    <div x-show="replyOpen" x-transition.opacity class="fixed inset-0 bg-black/50 z-40" @click="replyOpen=false"></div>

    <div x-show="replyOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden" @click.stop>

            <!-- Modal header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="ti ti-corner-up-left"></i>
                    Répondre
                </h3>

                <button type="button" @click="replyOpen=false"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="ti ti-x text-xl"></i>
                </button>
            </div>

            <!-- Modal form -->
            <form method="POST"
                  action="{{ route('messages.reply', $message) }}"
                  enctype="multipart/form-data"
                  class="p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Votre réponse</label>
                    <textarea name="contenu" rows="5" required
                              class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                              placeholder="Écrivez votre réponse ici...">{{ old('contenu') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pièces jointes (réponse)</label>
                    <input type="file" name="attachments[]" multiple
                           class="block w-full text-sm text-gray-600 dark:text-gray-300
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100
                                  dark:file:bg-blue-900/30 dark:file:text-blue-300">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max 10MB par fichier.</p>
                </div>

                <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="replyOpen=false"
                            class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        Annuler
                    </button>

                    <button type="submit"
                            class="group relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-700 hover:to-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition flex items-center gap-2">
                        <i class="ti ti-send text-sm"></i>
                        Envoyer la réponse
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    .prose-dark { color: #d1d5db; }
</style>
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
