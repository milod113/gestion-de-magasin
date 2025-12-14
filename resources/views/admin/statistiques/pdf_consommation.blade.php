<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques de Consommation</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h4, .header h5 {
            margin: 0;
            line-height: 1.4;
        }
        .header h4 {
            font-weight: bold;
        }
        .divider {
            border-top: 2px solid #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #ddd;
        }
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .footer {
            position: fixed;
            bottom: 10px;
            text-align: right;
            font-size: 10px;
        }
        h3.service-title {
            margin-top: 30px;
            margin-bottom: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <!-- Official Header -->
    <div class="header">
        <h4>La République Algérienne Démocratique et Populaire</h4>
        <h4>Ministère de la Santé</h4>
        <h4>Centre Hospitalo Universitaire Damerdji Heddam</h4>
        <h5>Direction des Moyens et Matériel</h5>
        <h5>Sous Direction de l'Économat</h5>
        <div class="divider"></div>
        <h3>Statistiques de Consommation</h3>
        @if($mois || $annee)
            <p>Période :
                @if($mois) {{ \Carbon\Carbon::create()->month($mois)->locale('fr')->monthName }} @endif
                @if($annee) {{ $annee }} @endif
            </p>
        @endif
    </div>

    <!-- Loop through each service -->
    @foreach($stats as $serviceName => $articles)
        <h3 class="service-title">{{ $serviceName }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Prix unitaire (DZD)</th>
                    <th>Quantité livrée</th>
                    <th>Sous-total (DZD)</th>
                </tr>
            </thead>
            <tbody>
                @php $totalService = 0; @endphp
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->designation }}</td>
                        <td>{{ number_format($article->prix_unitaire, 2, ',', ' ') }}</td>
                        <td>{{ $article->qte_livree }}</td>
                        <td>{{ number_format($article->sous_total, 2, ',', ' ') }}</td>
                    </tr>
                    @php $totalService += $article->sous_total; @endphp
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total {{ $serviceName }}</td>
                    <td>{{ number_format($totalService, 2, ',', ' ') }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach

    <!-- Footer -->
    <div class="footer">
        Imprimé le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
