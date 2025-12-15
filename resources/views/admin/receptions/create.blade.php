@extends('layouts.app')

@section('title', 'Créer une nouvelle Réception')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">

<form action="{{ route('receptions.store') }}" method="POST">
@csrf

{{-- ================= BASIC INFO ================= --}}
<div class="bg-white rounded-xl shadow p-6 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium mb-2">Date réception *</label>
            <input type="date" name="date_reception" required
                   class="w-full rounded-lg border px-3 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Référence *</label>
            <input type="text" name="reception_reference" required
                   class="w-full rounded-lg border px-3 py-2.5">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-2">Convention *</label>
            <select id="convention_id" name="convention_id" required
                    class="w-full rounded-lg border px-3 py-2.5">
                <option value="">-- Choisir une convention --</option>
                @foreach($conventions as $c)
                    <option value="{{ $c->id }}">
                        {{ $c->reference }}
                        @if($c->fournisseur)
                            - {{ $c->fournisseur->nom ?? $c->fournisseur->societe }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

    </div>
</div>

{{-- ================= LIGNES ================= --}}
<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between mb-4">
        <h3 class="text-lg font-semibold">Items à recevoir</h3>
        <button type="button" id="add-ligne"
                class="bg-green-600 text-white px-4 py-2 rounded-lg">
            + Ajouter
        </button>
    </div>

    <div id="ligne-container" class="space-y-4"></div>

    <div class="mt-4 text-sm text-gray-600">
        <span id="item-count">0 article(s)</span>
    </div>
</div>

{{-- ================= ACTIONS ================= --}}
<div class="flex justify-end gap-3 mt-6">
    <a href="{{ route('receptions.index') }}"
       class="bg-gray-500 text-white px-6 py-2 rounded-lg">Annuler</a>

    <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg">
        Enregistrer
    </button>
</div>

</form>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    const routeTemplate = "{{ route('conventions.items', ['convention' => '__ID__']) }}";

    let index = 0;
    const container = document.getElementById('ligne-container');
    const addBtn = document.getElementById('add-ligne');
    const conventionSelect = document.getElementById('convention_id');
    const countEl = document.getElementById('item-count');

    function updateCount(){
        countEl.textContent = `${container.children.length} article(s)`;
    }

    function isEquipmentValue(v){
        return v && v.startsWith('equipment|');
    }

    function sync(ligne){
        const sel = ligne.querySelector('.item-select');
        const t = ligne.querySelector('.item-type');
        const i = ligne.querySelector('.item-id');

        if (!sel.value) { t.value=''; i.value=''; return; }

        const [type,id] = sel.value.split('|');

        t.value = (type === 'article')
            ? 'App\\Models\\Article'
            : 'App\\Models\\Immobilier\\Equipment';

        i.value = id;
    }

    function toggleSerialField(ligne){
        const sel = ligne.querySelector('.item-select');
        const wrap = ligne.querySelector('.serial-wrap');
        const input = ligne.querySelector('.n-serie');

        if (!wrap || !input) return;

        if (isEquipmentValue(sel.value)) {
            wrap.classList.remove('hidden');
            input.required = true;
        } else {
            wrap.classList.add('hidden');
            input.required = false;
            input.value = '';
        }
    }

    function setQteConvenue(ligne, value){
        const qc = ligne.querySelector('.qte-convenue');
        if (qc) qc.value = value ?? '';
    }

    function addLine(it = null, items = []) {

        const div = document.createElement('div');
        div.className = 'border rounded-lg p-4';

        const options = items.map(x =>
            `<option value="${x.type}|${x.id}">${x.label}</option>`
        ).join('');

        div.innerHTML = `
        <div class="grid grid-cols-12 gap-4 items-end">

            <div class="col-span-12 md:col-span-4">
                <label class="text-sm font-medium">Item *</label>
                <select name="lignes[${index}][item_key]"
                        class="item-select w-full border rounded px-2 py-2" required>
                    <option value="">-- Choisir --</option>
                    ${options}
                </select>
                <input type="hidden" name="lignes[${index}][item_type]" class="item-type">
                <input type="hidden" name="lignes[${index}][item_id]" class="item-id">
            </div>

            <div class="col-span-6 md:col-span-2">
                <label class="text-sm font-medium">Qté convenue</label>
                <input type="number" class="qte-convenue w-full border rounded px-2 py-2 bg-gray-100" readonly>
            </div>

            <div class="col-span-6 md:col-span-2">
                <label class="text-sm font-medium">Quantité reçue *</label>
                <input type="number" name="lignes[${index}][quantité]"
                       min="1" value="${it?.qty_convenue ?? ''}"
                       class="w-full border rounded px-2 py-2" required>
            </div>

            <div class="col-span-6 md:col-span-2">
                <label class="text-sm font-medium">Prix *</label>
                <input type="number" step="0.01" min="0"
                       name="lignes[${index}][prix_unitaire]"
                       value="${it?.price ?? ''}"
                       class="w-full border rounded px-2 py-2" required>
            </div>

            <div class="col-span-12 md:col-span-2 text-right">
                <button type="button" class="remove bg-red-600 text-white px-3 py-2 rounded">
                    Supprimer
                </button>
            </div>

            <div class="col-span-12 serial-wrap hidden">
                <label class="text-sm font-medium">N° Série (équipement)</label>
                <input type="text"
                       name="lignes[${index}][n_serie]"
                       class="n-serie w-full border rounded px-2 py-2">
            </div>

        </div>
        `;

        container.appendChild(div);

        const sel = div.querySelector('.item-select');

        if (it) {
            sel.value = `${it.type}|${it.id}`;
            setQteConvenue(div, it.qty_convenue);

            // 🔥 FORCER L’ACTIVATION
            sync(div);
            toggleSerialField(div);
        }

        sel.addEventListener('change', () => {
            sync(div);
            toggleSerialField(div);

            const chosen = items.find(x => `${x.type}|${x.id}` === sel.value);
            setQteConvenue(div, chosen?.qty_convenue ?? '');
        });

        div.querySelector('.remove').onclick = () => {
            div.remove();
            updateCount();
        };

        index++;
        updateCount();
    }

    async function loadItems(id){
        const url = routeTemplate.replace('__ID__', id);
        const res = await fetch(url);
        const data = await res.json();
        return data.items ?? [];
    }

    conventionSelect.addEventListener('change', async e => {
        container.innerHTML = '';
        index = 0;

        if (!e.target.value) {
            addLine();
            return;
        }

        const items = await loadItems(e.target.value);

        if (!items.length) addLine();
        else items.forEach(it => addLine(it, items));
    });

    addBtn.onclick = async () => {
        let items = [];
        if (conventionSelect.value)
            items = await loadItems(conventionSelect.value);
        addLine(null, items);
    };

    addLine();
});
</script>

@endsection
