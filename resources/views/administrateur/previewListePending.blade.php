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
    </style>
</head>

<body>
    <div class="header">
        <div class="brand-section">
            <h1>CICA NOBLESSE PRESSING</h1>
        </div>

    </div>

    <h2 style="text-align: center; color: #007bff;">Liste des Commandes en Attente</h2>
    <p><strong>Période :</strong> {{ $date_debut }} au {{ $date_fin }}</p>

    @if(isset($commandes) && count($commandes) > 0)
        <table>
            <thead>
                <tr>
                    <th>N° Commande</th>
                    <th>Nom du Client</th>
                    <th>Numéro de Téléphone</th>
                    <th>Date de Retrait</th>
                    <th>Heure de Retrait</th>
                    <th>Montant de la Facture</th>
                    <th>Statut</th>
                    <th>Utilisateur</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commandes as $commande)
                    <tr>
                        <td>{{ $commande->numero }}</td>
                        <td>{{ $commande->client }}</td>
                        <td>{{ $commande->numero_whatsapp }}</td>
                        <td>{{ \Carbon\Carbon::parse($commande->date_retrait)->format('d/m/Y') }}</td>
                        <td>{{ $commande->heure_retrait }}</td>
                        <td>{{ number_format($commande->total, 2, ',', ' ') }} FCFA</td>
                        <td>{{ $commande->statut }}</td>
                        <td>{{ $commande->user->name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; padding: 10px; background-color: #f8f9fa; border-left: 4px solid #007bff;">
            <strong>Total des commandes : {{ number_format($totalMontant, 2, ',', ' ') }} FCFA</strong>
        </div>
        
        <div style="margin-top: 10px; padding: 10px; background-color: #e7f3ff; border-left: 4px solid #007bff;">
            <strong>Nombre total de commandes : {{ $commandes->count() }}</strong>
        </div>
    @else
        <div style="margin-top: 20px; padding: 15px; background-color: #f8d7da; border-left: 4px solid #dc3545; color: #721c24;">
            <strong>Aucune commande trouvée pour la période sélectionnée.</strong>
        </div>
    @endif


</body>

</html>
