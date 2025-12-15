@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Inbox</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Messages reçus</p>
        </div>

        <a href="{{ route('messages.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
            <i class="ti ti-plus text-sm"></i>
            Nouveau message
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-200 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700/50">
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                {{ $messages->total() }} message(s)
            </p>
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700/50">
            @forelse($messages as $message)
                <div class="p-5 hover:bg-gray-50/70 dark:hover:bg-gray-700/30 transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-gray-900 dark:text-gray-100 truncate">
                                    {{ $message->sujet }}
                                </h3>

                                @if($message->attachments?->count())
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                        <i class="ti ti-paperclip text-xs"></i>
                                        {{ $message->attachments->count() }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 line-clamp-2">
                                {{ \Illuminate\Support\Str::limit($message->contenu, 120) }}
                            </p>

                            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-500 dark:text-gray-400">
                                <span class="inline-flex items-center gap-1">
                                    <i class="ti ti-user text-xs"></i>
                                    De: <span class="font-semibold text-gray-700 dark:text-gray-200">
                                        {{ $message->sender?->name ?? '—' }}
                                    </span>
                                </span>

                                <span class="inline-flex items-center gap-1">
                                    <i class="ti ti-clock text-xs"></i>
                                    {{ $message->created_at?->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('messages.show', $message) }}"
                               class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition text-sm">
                                <i class="ti ti-eye text-sm"></i>
                                Voir
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="text-gray-400 mb-2">
                        <i class="ti ti-inbox text-4xl"></i>
                    </div>
                    <p class="text-gray-700 dark:text-gray-200 font-semibold">Aucun message reçu.</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Quand quelqu’un t’envoie un message, il apparaîtra ici.</p>
                </div>
            @endforelse
        </div>

        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700/50">
            {{ $messages->links() }}
        </div>
    </div>
</div>
@endsection
