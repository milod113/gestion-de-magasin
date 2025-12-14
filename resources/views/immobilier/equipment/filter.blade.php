@extends('layouts.app')

@section('title', 'Filtrer les Articles par Catégorie')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">Filtrer les Articles</h2>

    <div class="mb-4">
        <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
        <select id="categorie" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">-- Sélectionner une catégorie --</option>
            @foreach($categories as $categorie)
                <option value="{{ $categorie->id_categorie }}">{{ $categorie->designation }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="article" class="block text-sm font-medium text-gray-700">Article</label>
        <select id="article" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">-- Sélectionner un article --</option>
        </select>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#categorie').on('change', function () {
        let categorieId = $(this).val();

        if (categorieId) {
            $.ajax({
                url: '/api/articles-by-categorie',
                type: 'GET',
                data: { categorie_id: categorieId },
                success: function (data) {
                    $('#article').empty().append('<option value="">-- Sélectionner un article --</option>');
                    $.each(data, function (key, article) {
                        $('#article').append('<option value="' + article.id + '">' + article.designation + '</option>');
                    });
                },
                error: function (xhr) {
                    alert('Erreur lors du chargement des articles');
                }
            });
        } else {
            $('#article').empty().append('<option value="">-- Sélectionner un article --</option>');
        }
    });
</script>
@endpush
