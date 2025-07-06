<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes en Attente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 2px solid #007bff;
            margin-bottom: 20px;
        }

        .brand-section {
            text-align: left;
        }

        .brand-section h1 {
            color: #007bff;
            margin-bottom: 5px;
        }

        .invoice-info {
            text-align: right;
        }

        .details-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .detail-block {
            width: 48%;
        }

        .text-green {
            color: #28a745;
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .total {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        ul {
            padding-left: 20px;
        }

        .sub-list {
            margin-top: 5px;
            padding-left: 20px;
            list-style-type: square;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="brand-section">
            <h1>CICA NOBLESSE PRESSING</h1>
        </div>

    </div>

    <h2>Liste des Commandes non retirées</h2>
    <p><strong>Période :</strong> {{ $date_debut }} au {{ $date_fin }}</p>

    <table>
        <thead>
            <tr>
                <th>N° Commande</th>
                <th>Client</th>
                <th>Numéro de Téléphone</th>
                <th>Heure de Retrait</th>
                {{-- <th>Montant</th>
                <th>Statut</th> --}}
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($commandes as $commande)
                @if ($commande->statut === 'non retirée')
                    @php $total += $commande->total; @endphp
                    <tr>
                        <td>{{ $commande->numero }}</td>
                        <td>{{ $commande->client }}</td>
                        <td>{{ $commande->numero_whatsapp }}</td>
                        <td>{{ $commande->heure_retrait }}</td>
                            {{-- <td>{{ number_format($command->total, 2, ',', ' ') }} FCFA</td>
                            <td>{{ $commande->statut }}</td> --}}
                    </tr>
                @endif
            @endforeach
            {{-- <tr class="total">
                <td colspan="3">Total :</td>
                <td>{{ number_format($total, 2, ',', ' ') }} FCFA</td>
                <td></td>
            </tr> --}}
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>
