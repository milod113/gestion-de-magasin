<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Consommation par Service</title>
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
        <h3>Consommation par Service</h3>
        @if(!empty($mois) || !empty($annee))
            <p>Période :
                @if(!empty($mois)) {{ \Carbon\Carbon::create()->month($mois)->locale('fr')->monthName }} @endif
                @if(!empty($annee)) {{ $annee }} @endif
            </p>
        @endif
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Total Consommation (DA)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stats as $stat)
                <tr>
                    <td>{{ $stat->service_nom }}</td>
                    <td>{{ number_format($stat->total_consommation, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td>Total Global</td>
                <td>{{ number_format($totalGlobal, 2, ',', ' ') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Imprimé le {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
