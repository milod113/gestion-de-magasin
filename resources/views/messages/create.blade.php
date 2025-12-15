@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Nouveau message</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('messages.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Sujet</label>
                    <input type="text" name="sujet" class="form-control" value="{{ old('sujet') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contenu</label>
                    <textarea name="contenu" rows="6" class="form-control" required>{{ old('contenu') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pièces jointes</label>
                    <input type="file" name="attachments[]" class="form-control" multiple>
                    <small class="text-muted">Tu peux sélectionner plusieurs fichiers.</small>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit">Enregistrer</button>
                    <a href="{{ route('messages.index') }}" class="btn btn-light">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
