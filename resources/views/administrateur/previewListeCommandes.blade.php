<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relevé de Comptabilité - CICA NOBLESSE PRESSING</title>
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
        }

        td {
            padding: 0.6rem;
            border-bottom: 1px solid #ddd;
            font-size: 0.85em;
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
    </div>

    <!-- Titre principal -->
    <div class="title-section">
        <h2>RELEVÉ DE COMPTABILITÉ</h2>
        <div class="period">
            @if (isset($start_date) && isset($end_date))
                Période du {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d/m/Y') }}
                au {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d/m/Y') }}
            @else
                Toutes périodes confondues
            @endif
        </div>
    </div>

    <!-- Historique des Paiements -->
    @if(isset($payments) && count($payments))
        <h3 style="margin-top:2rem; color:#1a365d;">Historique des Paiements</h3>
    <table>
        <thead>
            <tr>
                    <th>Numéro de Facture</th>
                    <th>Utilisateur</th>
                    <th>Montant</th>
                    <th>Action</th>
                    <th>Date</th>
                <th>Client</th>
            </tr>
        </thead>
        <tbody>
                @foreach ($payments as $payment)
                <tr>
                        <td>{{ $payment->commande->numero ?? $payment->commande_id }}</td>
                        <td>{{ $payment->user->name ?? 'Utilisateur Inconnu' }}</td>
                        <td>{{ number_format($payment->amount, 2, ',', ' ') }} F</td>
                        <td>{{ $payment->payment_method ?? 'Non spécifié' }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $payment->commande->client ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Historique des Retraits / Notes -->
    @if(isset($notes) && count($notes))
        <h3 style="margin-top:2rem; color:#1a365d;">Historique des Retraits / Notes</h3>
        <table>
            <thead>
                <tr>
                    <th>Numéro de Facture</th>
                    <th>Utilisateur</th>
                    <th>Note</th>
                    <th>Date</th>
                    <th>Client</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notes as $note)
                    <tr>
                        <td>{{ $note->commande->numero ?? $note->commande_id }}</td>
                        <td>{{ $note->user->name ?? 'Utilisateur Inconnu' }}</td>
                        <td>{{ $note->note }}</td>
                        <td>{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $note->commande->client ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</body>

</html>
