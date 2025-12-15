<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Livraison - {{ $reception->reception_reference }}</title>
    <style>
        /* PDF Styles - Optimisé pour l'impression */
        @page {
            margin: 20mm;
            size: A4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }

        .container {
            max-width: 210mm;
            margin: 0 auto;
        }

        /* Header */
        .header {
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company-info {
            float: right;
            text-align: right;
            font-size: 10px;
        }

        .logo-section {
            display: inline-block;
            margin-bottom: 10px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #3b82f6;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .document-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 10px 0;
        }

        /* Grid system for PDF */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 10px;
        }

        .col-4 {
            flex: 0 0 33.333%;
            max-width: 33.333%;
            padding: 0 10px;
        }

        .col-8 {
            flex: 0 0 66.667%;
            max-width: 66.667%;
            padding: 0 10px;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0 10px;
        }

        /* Cards */
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            background: #fff;
        }

        .card-header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 8px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title {
            font-size: 14px;
            font-weight: bold;
            color: #374151;
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .table th {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            color: #374151;
        }

        .table td {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            font-size: 11px;
        }

        .table tr:nth-child(even) {
            background: #f9fafb;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: 500;
            border-radius: 4px;
            border: 1px solid;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
            border-color: #a7f3d0;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
            border-color: #bfdbfe;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
            border-color: #fde68a;
        }

        /* Text styles */
        .text-primary {
            color: #3b82f6;
        }

        .text-success {
            color: #10b981;
        }

        .text-danger {
            color: #ef4444;
        }

        .text-muted {
            color: #6b7280;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-lg {
            font-size: 14px;
        }

        .text-xl {
            font-size: 16px;
        }

        .text-2xl {
            font-size: 20px;
        }

        /* Spacing */
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .mb-5 { margin-bottom: 20px; }
        .mb-6 { margin-bottom: 24px; }

        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .mt-4 { margin-top: 16px; }

        .p-3 { padding: 12px; }
        .p-4 { padding: 16px; }

        /* Flex utilities */
        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .gap-4 { gap: 16px; }

        /* Width utilities */
        .w-100 { width: 100%; }

        /* Page breaks */
        .page-break {
            page-break-before: always;
        }

        /* Footer */
        .footer {
            border-top: 1px solid #e5e7eb;
            margin-top: 30px;
            padding-top: 15px;
            font-size: 10px;
            color: #6b7280;
        }

        .signature-section {
            margin-top: 40px;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 5px;
            text-align: center;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(0, 0, 0, 0.1);
            z-index: -1;
            font-weight: bold;
            pointer-events: none;
        }

        /* QR Code section */
        .qr-section {
            text-align: center;
            margin: 20px 0;
        }

        /* Print-specific */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <div class="watermark">
        BON DE LIVRAISON
    </div>

    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="company-info">
                <div class="font-bold text-lg">{{ config('app.name', 'Votre Société') }}</div>
                <div>Adresse: 123 Rue Principale, Ville</div>
                <div>Tél: +213 123 456 789</div>
                <div>Email: contact@societe.dz</div>
                <div>Site: www.societe.dz</div>
            </div>

            <div class="logo-section">
                <div class="logo">
                fff BL
                </div>
                <div class="text-muted">Document officiel de réception</div>
            </div>

            <div style="clear: both;"></div>

           <div class="document-title text-center mb-2">
    BON DE LIVRAISON N° {{ $reception->reception_reference }}
</div>

      <div class="text-center mb-4" style="font-size:12px;">
    <span class="font-bold">Date de réception:</span>
    <span>{{ optional($reception->date_reception)->format('d/m/Y') ?? 'Non spécifiée' }}</span>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <span class="font-bold">Date d'émission:</span>
    <span>{{ date('d/m/Y H:i') }}</span>
</div>
        </div>

        <!-- Document Information -->
        <div class="row mb-6">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Informations générales</span>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-2">
                                <span class="font-bold">Référence:</span>
                                <span class="badge badge-info">{{ $reception->reception_reference }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="font-bold">Convention:</span>
                                <span>{{ $reception->convention->reference ?? '-' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="font-bold">Fournisseur:</span>
                                @php
                                    $f = $reception->convention->fournisseur ?? null;
                                @endphp
                                <span>{{ $f ? ($f->sociéte ?? $f->nom) : '-' }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <span class="font-bold">Utilisateur:</span>
                                <span>{{ $reception->user->name ?? '-' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="font-bold">Statut:</span>
                                <span class="badge badge-success">Reçu</span>
                            </div>
                            <div class="mb-2">
                                <span class="font-bold">Montant total:</span>
                                <span class="text-success font-bold">{{ number_format($reception->Total, 2, ',', ' ') }} DZD</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Résumé</span>
                    </div>
                    <div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Nombre d'articles:</span>
                            <span class="font-bold">{{ $reception->lignes->count() }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Valeur totale:</span>
                            <span class="font-bold text-success">{{ number_format($reception->Total, 2, ',', ' ') }} DZD</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Créé le:</span>
                            <span>{{ optional($reception->created_at)->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Mis à jour le:</span>
                            <span>{{ optional($reception->updated_at)->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="card mb-6">
            <div class="card-header">
                <span class="card-title">Articles reçus ({{ $reception->lignes->count() }} ligne(s))</span>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Désignation</th>
                        <th>Référence</th>
                        <th>N° Série</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reception->lignes as $i => $ligne)
                        @php
                            $isArticle = $ligne->item_type === 'App\\Models\\Article';
                            $isEquipment = $ligne->item_type === 'App\\Models\\Immobilier\\Equipment';

                            $designation = $isArticle
                                ? ($ligne->item->designation ?? '-')
                                : ($ligne->item->label ?? '-');

                            $reference = $isArticle
                                ? ($ligne->item->ref_article ?? $ligne->article_reference ?? '-')
                                : ($ligne->item->model ?? $ligne->item->reference ?? '-');

                            $typeLabel = $isArticle ? 'Stock' : ($isEquipment ? 'Équipement' : 'Inconnu');
                        @endphp

                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                @if($isArticle)
                                    <span class="badge badge-info">Stock</span>
                                @elseif($isEquipment)
                                    <span class="badge badge-warning">Équipement</span>
                                @else
                                    <span>Inconnu</span>
                                @endif
                            </td>
                            <td>{{ $designation }}</td>
                            <td>{{ $reference }}</td>
                            <td>{{ $isEquipment ? ($ligne->n_serie ?? '-') : '-' }}</td>
                            <td class="text-center">
                                <span class="badge badge-success">{{ $ligne->quantité }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted p-4">
                                Aucun article reçu
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($reception->lignes->count() > 0)
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right font-bold">Total des articles:</td>
                            <td class="text-center font-bold">
                                {{ $reception->lignes->sum('quantité') }}
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        <!-- Additional Information -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Observations & Notes</span>
                    </div>
                    <div style="min-height: 100px;">
                        <!-- Space for notes -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Signatures -->
        <div class="signature-section">
            <div class="row">
                <div class="col-4">
                    <div class="signature-line">
                        Fournisseur
                    </div>
                </div>
                <div class="col-4">
                    <div class="signature-line">
                        Responsable Réception
                    </div>
                </div>
                <div class="col-4">
                    <div class="signature-line">
                        Responsable Stock
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="row">
                <div class="col-6">
                    <div class="font-bold">Document généré le: {{ date('d/m/Y H:i') }}</div>
                    <div>ID Réception: {{ $reception->id_reception }}</div>
                </div>
                <div class="col-6 text-right">
                    <div>Page 1/1</div>
                    <div class="text-muted">Ce document est un original numérique</div>
                    <div class="text-muted">Validité: {{ date('d/m/Y', strtotime('+1 year')) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Section (optional) -->
    @if(config('app.qr_code_enabled', false))
    <div class="page-break"></div>
    <div class="container">
        <div class="qr-section">
            <h3>Scan pour vérification</h3>
            <!-- You can add QR code generation here -->
            <div style="margin: 20px 0;">
                [QR Code would be here]
            </div>
            <div class="text-muted">
                Scannez ce code pour vérifier l'authenticité du document
            </div>
        </div>
    </div>
    @endif
</body>
</html>
