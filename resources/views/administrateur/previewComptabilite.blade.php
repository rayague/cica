<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Comptabilité et Retraits</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { text-align: right; font-weight: bold; margin-top: 10px;}
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <h1>Rapport de Comptabilité</h1>
    <p>Période du {{ \Carbon\Carbon::parse($date_debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($date_fin)->format('d/m/Y') }}</p>

    <h2>Historique des Paiements</h2>
    @if($payments->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Numéro de Facture</th>
                    <th>Client</th>
                    <th>Utilisateur</th>
                    <th>Montant</th>
                    <th>Moyen de Paiement</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->commande->numero ?? 'N/A' }}</td>
                        <td>{{ $payment->commande->client ?? 'N/A' }}</td>
                        <td>{{ $payment->user->name ?? 'N/A' }}</td>
                        <td>{{ number_format($payment->amount, 0, ',', ' ') }} F</td>
                        <td>{{ $payment->payment_type ?? 'N/A' }}</td>
                        <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total">Total des paiements : {{ number_format($montant_total_paiements, 0, ',', ' ') }} F</div>
    @else
        <p>Aucun paiement pour cette période.</p>
    @endif

    <hr style="margin: 40px 0;">

    <h2>Historique des Retraits / Notes</h2>
    @if($notes->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Numéro de Facture</th>
                    <th>Client</th>
                    <th>Utilisateur</th>
                    <th>Montant</th>
                    <th>Moyen de Paiement</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notes as $note)
                    <tr>
                        <td>{{ $note->commande->numero ?? 'N/A' }}</td>
                        <td>{{ $note->commande->client ?? 'N/A' }}</td>
                        <td>{{ $note->user->name ?? 'N/A' }}</td>
                        <td>{{ $note->note }}</td>
                        <td>Retrait</td>
                        <td>Retrait</td>
                        <td>{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune note pour cette période.</p>
    @endif

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.close()">Fermer</button>
    </div>
</body>
</html>
