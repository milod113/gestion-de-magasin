<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Bon de Livraison - {{ $reception->reception_reference }}</title>

    <style>
        @page { margin: 18mm 14mm; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #111; }
        .muted { color: #666; }
        .h1 { font-size: 18px; font-weight: 700; margin: 0; }
        .h2 { font-size: 13px; font-weight: 700; margin: 0 0 6px; }
        .row { display: flex; justify-content: space-between; gap: 12px; }
        .box { border: 1px solid #ddd; border-radius: 8px; padding: 10px 12px; }
        .mt { margin-top: 12px; }
        .mt2 { margin-top: 18px; }
        .w50 { width: 49%; }
        .w100 { width: 100%; }

        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #e7e7e7; padding: 8px 6px; vertical-align: top; }
        th { text-align: left; background: #f6f6f6; font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; }
        td.num { text-align: right; white-space: nowrap; }
        .tag { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 10px; border: 1px solid #ddd; }
        .tag.stock { background: #eef6ff; border-color: #cfe6ff; }
        .tag.eq { background: #f5efff; border-color: #e2d2ff; }

        .total-row td { font-weight: 700; border-top: 2px solid #333; border-bottom: 0; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 10px; color: #777; }
        .footer .line { border-top: 1px solid #ddd; padding-top: 6px; }
    </style>
</head>
<body>

@php
    $conv = $reception->convention ?? null;
    $f = $conv->fournisseur ?? null;
@endphp

<!-- HEADER -->
<div class="row">
    <div>
        <p class="h1">Bon de Livraison</p>
        <p class="muted" style="margin: 4px 0 0;">
            Référence : <strong>{{ $reception->reception_reference }}</strong><br>
            Date : <strong>{{ optional($reception->date_reception)->format('d/m/Y') ?? '-' }}</strong>
        </p>
    </div>

    <div style="text-align:right;">
        <p style="margin:0; font-weight:700;">{{ config('app.name', 'Gestion Magasin') }}</p>
        <p class="muted" style="margin:4px 0 0;">
            Généré le : {{ now()->format('d/m/Y H:i') }}<br>
            Par : {{ $reception->user->name ?? '-' }}
        </p>
    </div>
</div>

<!-- INFO BOXES -->
<div class="row mt2">
    <div class="box w50">
        <p class="h2">Convention</p>
        <p style="margin:0;">
            Réf Convention : <strong>{{ $conv->reference ?? '-' }}</strong><br>
            Fournisseur : <strong>{{ $f->sociéte ?? $f->nom ?? '-' }}</strong>
        </p>
    </div>

    <div class="box w50">
        <p class="h2">Résumé</p>
        <p style="margin:0;">
            Nombre de lignes : <strong>{{ $reception->lignes->count() }}</strong><br>
            Montant total : <strong>{{ number_format($reception->Total, 2, ',', ' ') }} DZD</strong>
        </p>
    </div>
</div>

<!-- TABLE -->
<div class="box mt2 w100">
    <p class="h2" style="margin-bottom:10px;">Détails des items</p>

    <table>
        <thead>
        <tr>
            <th style="width:26px;">#</th>
            <th style="width:70px;">Type</th>
            <th>Désignation</th>
            <th style="width:120px;">Référence</th>
            <th style="width:110px;">N° Série</th>
            <th class="num" style="width:70px;">Qté</th>
            <th class="num" style="width:90px;">PU (DZD)</th>
            <th class="num" style="width:110px;">Sous-total</th>
        </tr>
        </thead>

        <tbody>
        @foreach($reception->lignes as $i => $ligne)
            @php
                $isArticle = $ligne->item_type === 'App\\Models\\Article';
                $isEq = $ligne->item_type === 'App\\Models\\Immobilier\\Equipment';

                $item = $ligne->item; // morphTo
                $designation = $isArticle ? ($item->designation ?? '-') : ($item->label ?? '-');

                // adapte si equipment a un champ code/ref spécifique
                $ref = $isArticle
                    ? ($item->ref_article ?? $ligne->article_reference ?? '-')
                    : ($item->model ?? $item->reference ?? '-');

                $typeLabel = $isArticle ? 'Stock' : ($isEq ? 'Equip.' : '—');
            @endphp

            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    @if($isArticle)
                        <span class="tag stock">Stock</span>
                    @elseif($isEq)
                        <span class="tag eq">Équipement</span>
                    @else
                        <span class="tag">Inconnu</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $designation }}</strong>
                </td>
                <td>{{ $ref }}</td>
                <td>
                    @if($isEq)
                        {{ $ligne->n_serie ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td class="num">{{ $ligne->quantité }}</td>
                <td class="num">{{ number_format($ligne->prix_unitaire, 2, ',', ' ') }}</td>
                <td class="num">{{ number_format($ligne->sous_total, 2, ',', ' ') }}</td>
            </tr>
        @endforeach

        <tr class="total-row">
            <td colspan="7" class="num">TOTAL</td>
            <td class="num">{{ number_format($reception->Total, 2, ',', ' ') }}</td>
        </tr>
        </tbody>
    </table>
</div>

<!-- FOOTER -->
<div class="footer">
    <div class="line">
        Bon de Livraison {{ $reception->reception_reference }} — Page 1
    </div>
</div>

</body>
</html>
