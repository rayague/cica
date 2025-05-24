<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $commande->numero }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        @page {
            size: 297mm 210mm;
            margin: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
            color: #2d3748;
            width: 297mm;
            height: 210mm;
            position: relative;
        }

        .invoice-column {
            padding: 10mm;
            width: 277mm;
            height: 190mm;
            box-sizing: border-box;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #38a169;
            margin-bottom: 3mm;
            padding-bottom: 2mm;
        }

        .brand-section {
            width: 60%;
        }

        .brand-section h1 {
            font-size: 11px;
            margin: 0 0 1mm 0;
            color: #38a169;
        }

        .brand-section p {
            margin: 0;
            font-size: 8px;
        }

        .invoice-info {
            text-align: right;
            font-size: 8px;
        }

        .invoice-info h2 {
            margin: 0 0 1mm 0;
            font-size: 9px;
        }

        .details-grid {
            display: flex;
            justify-content: space-between;
            background: #f0fdf4;
            border: 1px solid #c6f6d5;
            padding: 3mm;
            border-radius: 3px;
            margin-bottom: 3mm;
        }

        .detail-block {
            width: 48%;
            font-size: 8px;
        }

        .detail-block h4 {
            margin: 0 0 1mm 0;
            font-size: 9px;
            color: #38a169;
            text-transform: uppercase;
        }

        .items-table {
            width: 100%;
            font-size: 7px;
            border-collapse: collapse;
            margin: 2mm 0;
        }

        .items-table th {
            background-color: #38a169;
            color: white;
            padding: 1mm;
            text-align: left;
        }

        .items-table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 1mm;
        }

        .total-section {
            margin-top: 3mm;
            font-size: 8px;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            margin: 0.5mm 0;
        }

        .badge {
            padding: 0.5mm 2mm;
            background-color: #edf2f7;
            border-radius: 2px;
            font-weight: bold;
        }

        .historique-header {
            margin-top: 4mm;
            font-size: 8px;
            font-weight: bold;
        }

        .notes-table {
            width: 100%;
            font-size: 7px;
            border-collapse: collapse;
            margin-top: 1mm;
        }

        .notes-table th {
            background-color: #38a169;
            color: white;
            padding: 1mm;
        }

        .notes-table td {
            padding: 1mm;
            border-bottom: 1px solid #e2e8f0;
        }

        .conditions {
            margin-top: 4mm;
            font-size: 7px;
        }

        .conditions ul {
            padding-left: 10px;
            margin: 1mm 0;
        }

        @media print {
            body {
                width: 297mm;
                height: 210mm;
            }
            .invoice-column {
                width: 277mm;
                height: 190mm;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-column">
        <div class="header">
            <div class="brand-section">
                <h1>CICA NOBLESSE PRESSING</h1>
                <p>Annexe Godomey, Zogbo - Bénin</p>
                <p>0272 BP 81 • IFU : 2201300990000</p>
                <p>Tél : (+229) 97 89 36 99 / 96 44 67 50</p>
            </div>
            <div class="invoice-info">
                <h2>Facture</h2>
                <p><strong>N° :</strong> {{ $commande->numero }}</p>
                <p><strong>Date dépôt :</strong><br>{{ \Carbon\Carbon::parse($commande->date_depot)->locale('fr')->isoFormat('LL') }}</p>
                <p><strong>Agent :</strong> {{ $commande->user->name ?? $commande->user_id }}</p>
            </div>
        </div>

        <div class="details-grid">
            <div class="detail-block">
                <strong>CLIENT :</strong>
                {{ $commande->client }}<br>
                WhatsApp : {{ $commande->numero_whatsapp }}
            </div>
            <div class="detail-block">
                <strong>DATES</strong><br>
                Dépôt : {{ \Carbon\Carbon::parse($commande->date_depot)->isoFormat('LL') }}<br>
                Retrait : {{ \Carbon\Carbon::parse($commande->date_retrait)->isoFormat('LL') }}
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Objet</th>
                    <th>Qté</th>
                    <th>Description</th>
                    <th>Prix U.</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commande->objets as $objet)
                    <tr>
                        <td>{{ $objet->nom }}</td>
                        <td>{{ $objet->pivot->quantite }}</td>
                        <td>{{ $objet->pivot->description }}</td>
                        <td>{{ number_format($objet->prix_unitaire, 2, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($objet->pivot->quantite * $objet->prix_unitaire, 2, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="historique">
            <h3 class="historique-header">Historique Retraits / Notes</h3>
            @if ($notes->isNotEmpty())
                <table class="notes-table">
                    <thead>
                        <tr>
                            <th>Facture</th>
                            <th>Utilisateur</th>
                            <th>Note</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notes as $note)
                            <tr>
                                <td>{{ $commande->numero }}</td>
                                <td>{{ $note->user->name ?? $note->user_id }}</td>
                                <td>{{ $note->note }}</td>
                                <td>{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align:center; font-weight:bold; background:#ffd900; color:#fff;">Aucune note enregistrée</p>
            @endif
        </div>

        <div class="total-section">
            <h4 class="total-title">Récapitulatif de la commande</h4>
            <div class="total-line">
                <span class="label">Total brut :</span>
                <span class="value">{{ number_format($originalTotal, 2, ',', ' ') }} FCFA</span>
            </div>

            @if ($remiseReduction > 0)
                <div class="total-line">
                    <span class="label">Remise ({{ $remiseReduction }}%) :</span>
                    <span class="value text-red">-{{ number_format($discountAmount, 2, ',', ' ') }} FCFA</span>
                </div>
            @endif

            <div class="total-line total-net">
                <span class="label">Total net :</span>
                <span class="value">{{ number_format($commande->total, 2, ',', ' ') }} FCFA</span>
            </div>

            <div class="total-line">
                <span class="label">Avance versée :</span>
                <span class="value">{{ number_format($commande->avance_client, 2, ',', ' ') }} FCFA</span>
            </div>

            <div class="total-line solde">
                <span class="label">Solde à payer :</span>
                <span class="badge">{{ number_format($commande->solde_restant, 2, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <div class="conditions">
            <strong>Conditions :</strong>
            <ul>
                <li>10 FCFA/jour après 10<sup>e</sup> jour.</li>
                <li>Responsabilité limitée après 60 jours.</li>
                <li>Indemnités selon barème en cas d'avaries.</li>
            </ul>
        </div>

        @if(Auth::user()->is_admin)
        <div class="mt-4">
            <form action="{{ route('commandesAdmin.destroy', $commande->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800">
                    Supprimer la facture
                </button>
            </form>
        </div>
        @endif
    </div>
</body>

</html>
