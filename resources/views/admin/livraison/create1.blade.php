@extends('layouts.app')

@section('title', 'Nouvelle Livraison11')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Nouvelle Livraison pour la commande {{ $commande->ref_commande }}</h2>

    <form action="{{ route('livraisons.store') }}" method="POST" class="space-y-6">
        @csrf

        <input type="hidden" name="commande_ref" value="{{ $commande->ref_commande }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block mb-1">Date de Livraison</label>
                <input type="date" name="date_livraison" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block mb-1">Livré Par</label>
                <input type="text" value="{{ auth()->user()->name }}" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
            </div>
        </div>

        {{-- Articles commandés --}}
        <div class="bg-gray-50 p-4 rounded">
            <h3 class="font-bold mb-4">Articles Commandés</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block mb-1">Article</label>
                    <select id="article" class="w-full border rounded px-3 py-2">
                        <option value="">-- Choisir un article --</option>
                        @foreach($commande->lignes as $ligne)
                            <option value="{{ $ligne->article->ref_article }}"
                                data-designation="{{ $ligne->article->designation }}">
                                {{ $ligne->article->designation }} (Cmd: {{ $ligne->quantité }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-1">Quantité Livrée</label>
                    <input type="number" id="quantite" min="1" class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex items-end">
                    <button type="button" id="addRow" class="px-4 py-2 bg-green-600 text-white rounded">Ajouter</button>
                </div>
            </div>

            <table class="w-full border" id="detailsTable">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Réf</th>
                        <th class="p-2 border">Désignation</th>
                        <th class="p-2 border">Quantité Livrée</th>
                        <th class="p-2 border">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
        </div>
    </form>
</div>

<script>
document.getElementById('addRow').addEventListener('click', function() {
    let articleSelect = document.getElementById('article');
    let articleRef = articleSelect.value;
    let designation = articleSelect.options[articleSelect.selectedIndex]?.dataset?.designation;
    let quantite = document.getElementById('quantite').value;

    if (!articleRef || !quantite) {
        alert('Sélectionnez un article et indiquez la quantité.');
        return;
    }

    let row = `
        <tr>
            <td class="border p-2">
                <input type="hidden" name="lignes[${articleRef}][article_ref]" value="${articleRef}">
                ${articleRef}
            </td>
            <td class="border p-2">${designation}</td>
            <td class="border p-2">
                <input type="hidden" name="lignes[${articleRef}][quantite_livree]" value="${quantite}">
                ${quantite}
            </td>
            <td class="border p-2">
                <button type="button" class="removeRow px-2 py-1 bg-red-600 text-white rounded">Supprimer</button>
            </td>
        </tr>
    `;

    document.querySelector('#detailsTable tbody').insertAdjacentHTML('beforeend', row);
    document.getElementById('quantite').value = '';
});

document.querySelector('#detailsTable tbody').addEventListener('click', function(e) {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }
});
</script>
@endsection
