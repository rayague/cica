<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Factures en Attente - CICA NOBLESSE PRESSING</title>
    <style>
        :root {
            --primary-color: #1a365d;
            --secondary-color: #2c5282;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            margin: 1px;
            background: white;
            color: #333;
        }

        .header {
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }

        .header-info {
            text-align: right;
            font-size: 0.9em;
            margin-top: 1rem;
        }

        .title-section {
            text-align: center;
            margin: 2rem 0;
        }

        .title-section h2 {
            font-size: 1.5em;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .period {
            font-size: 1.1em;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            page-break-inside: auto;
        }

        th {
            background-color: var(--primary-color);
            color: white;
            padding: 0.8rem;
            text-align: left;
            font-size: 0.9em;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 0.6rem;
            border-bottom: 1px solid #ddd;
            font-size: 0.85em;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            background-color: #f8fafc;
            font-weight: bold;
        }

        .user-initial {
            background: var(--primary-color);
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 50%;
            font-weight: bold;
        }

        .footer {
            margin-top: 2rem;
            text-align: left;
            font-size: 0.85em;
            padding-top: 1rem;
            border-top: 2px solid #eee;
            page-break-inside: avoid;
        }

        .status-badge {
            padding: 0.3rem 0.6rem;
            border-radius: 0.5rem;
            font-size: 0.8em;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            min-width: 80px;
            border: 1px solid;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
            border-color: #f59e0b;
        }

        .status-partial {
            background-color: #fed7aa;
            color: #c2410c;
            border-color: #ea580c;
        }

        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
            border-color: #10b981;
        }

        .status-other {
            background-color: #e5e7eb;
            color: #374151;
            border-color: #6b7280;
        }

        @media print {
            body {
                margin: 1cm;
            }

            .header-info p:last-child,
            .footer {
                color: #666;
            }

            .no-print {
                display: none;
            }
        }

        @page {
            size: A4 portrait;
            margin: 2cm;

            @bottom-center {
                content: "Page " counter(page) " sur " counter(pages);
                font-size: 0.8em;
                color: #666;
            }
        }
    </style>
</head>

<body>
    <div class="header-info">
        <p style="margin: 0.2rem;">Éditée le : {{ now()->translatedFormat('d/m/Y \à H:i') }}</p>
    </div>

    <!-- Titre principal -->
    <div class="title-section">
        <h2>LISTE DES FACTURES EN ATTENTE</h2>
        <div class="period">
            Toutes les factures non retirées et non validées
        </div>
    </div>

    <!-- Liste des Factures en Attente -->
    @if(isset($commandes) && count($commandes))
        <h3 style="margin-top:2rem; color:#1a365d;">Factures en Attente</h3>
        <table>
            <thead>
                <tr>
                    <th>Numéro de Facture</th>
                    <th>Client</th>
                    <th>Téléphone</th>
                    <th>Date Dépôt</th>
                    <th>Date Retrait</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Créée par</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commandes as $commande)
                    <tr>
                        <td style="text-align: center; font-weight: bold;">{{ $commande->numero }}</td>
                        <td>{{ $commande->client }}</td>
                        <td style="text-align: center;">{{ $commande->numero_whatsapp }}</td>
                        <td style="text-align: center;">{{ \Carbon\Carbon::parse($commande->date_depot)->format('d/m/Y') }}</td>
                        <td style="text-align: center;">{{ \Carbon\Carbon::parse($commande->date_retrait)->format('d/m/Y') }}</td>
                        <td style="text-align: right; font-weight: bold;">{{ number_format($commande->total, 2, ',', ' ') }} FCFA</td>
                        <td style="text-align: center;">
                            @php
                                $statusClass = 'status-other';
                                $statusText = $commande->statut;
                                
                                if (in_array(strtolower($commande->statut), ['non retirée', 'non retiré', 'en attente'])) {
                                    $statusClass = 'status-pending';
                                    $statusText = 'En Attente';
                                } elseif (in_array(strtolower($commande->statut), ['partiellement payé', 'partiellement paye'])) {
                                    $statusClass = 'status-partial';
                                    $statusText = 'Partiellement Payé';
                                } elseif (in_array(strtolower($commande->statut), ['payé - non retiré', 'payé - non retirée', 'paye - non retire'])) {
                                    $statusClass = 'status-paid';
                                    $statusText = 'Payé - Non Retiré';
                                } else {
                                    $statusClass = 'status-other';
                                    $statusText = $commande->statut;
                                }
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>{{ $commande->user->name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="margin-top: 2rem; padding: 1rem; background-color: #fef2f2; border-left: 4px solid #ef4444;">
            <strong>Aucune facture en attente trouvée.</strong>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>CICA NOBLESSE PRESSING</strong></p>
        <p>Document généré automatiquement - Tous droits réservés</p>
    </div>
</body>

</html> 