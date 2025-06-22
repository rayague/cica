<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relevé des Commandes - ETS N'KPA PRESSING</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a365d;
            --secondary-color: #2c5282;
        }

        body {
            font-family: 'Poppins', sans-serif;
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
        <h2>RELEVÉ DES COMMANDES</h2>
        <div class="period">
            @if (isset($start_date) && isset($end_date))
                Période du {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d/m/Y') }}
                au {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d/m/Y') }}
            @else
                Toutes périodes confondues
            @endif
        </div>
    </div>

    <!-- Tableau -->
    <table>
        <thead>
            <tr>
                <th>N° Facture</th>
                <th>Client</th>
                <th>Téléphone</th>
                <th>Date Retrait</th>
                {{-- <th>Montant</th> --}}
                <th>Agent</th>
            </tr>
        </thead>


        <tbody>
            @foreach ($commandes as $commande)
                <tr>
                    <td>{{ $commande->numero }}</td>
                    <td>{{ $commande->client }}</td>
                    <td>{{ $commande->numero_whatsapp }}</td>
                    <td>{{ \Carbon\Carbon::parse($commande->date_retrait)->translatedFormat('d/m/Y H:i') }}</td>
                    {{-- <td style="font-weight: 500;">{{ number_format($commande->total, 2, ',', ' ') }} FCFA</td> --}}
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span class="user-initial">{{ strtoupper(substr($commande->user->name, 0, 1)) }}</span>
                            {{ $commande->user->name }}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        {{-- <tfoot>
            <tr>
                <td colspan="4"></td>
                <td style="font-weight: bold; border-top: 2px solid #000;">
                    Total : {{ number_format($totalMontant, 2, ',', ' ') }} FCFA
                </td>
            </tr>
        </tfoot> --}}
    </table>

    <!-- Total -->
    <div style="text-align: right; margin-top: 1rem; font-size: 0.95em;">
        Nombre total de commandes : <strong>{{ $commandes->count() }}</strong>
    </div>


</body>

</html>
