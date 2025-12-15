@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Messages</h3>
        <a href="{{ route('messages.create') }}" class="btn btn-primary">Nouveau message</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Sujet</th>
                        <th>Auteur</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($messages as $message)
                    <tr>
                        <td>{{ $message->sujet }}</td>
                        <td>{{ optional($message->user)->name ?? '—' }}</td>
                        <td>{{ $message->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('messages.show', $message) }}">Voir</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('messages.edit', $message) }}">Éditer</a>
                            <form class="d-inline" method="POST" action="{{ route('messages.destroy', $message) }}"
                                  onsubmit="return confirm('Supprimer ce message ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center p-4">Aucun message.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $messages->links() }}
    </div>
</div>
@endsection
