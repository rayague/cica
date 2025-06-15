<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $commande->numero }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
            color: #2d3748;
        }

        .sheet-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            page-break-inside: avoid;
        }

        .sheet-table td {
            width: 50%;
            vertical-align: top;
            padding: 2mm;
            page-break-inside: avoid;
        }

        .invoice-column {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 3mm;
            height: 185mm;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #38a169;
            margin-bottom: 2mm;
            padding-bottom: 1mm;
            page-break-inside: avoid;
        }

        .brand-section {
            width: 60%;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-text {
            flex: 1;
        }

        .brand-section h1 {
            font-size: 11px;
            margin: 0 0 1mm 0;
            color: #38a169;
        }

        .brand-section p {
            margin: 0;
            font-size: 9px;
        }

        .invoice-info {
            text-align: right;
            font-size: 9px;
        }

        .invoice-info h2 {
            margin: 0 0 1mm 0;
            font-size: 10px;
        }

        .details-grid {
            display: flex;
            justify-content: space-between;
            background: #f0fdf4;
            border: 1px solid #86efac;
            padding: 6px;
            margin-bottom: 10px;
            width: 97%;
            box-sizing: border-box;
            border-radius: 3px;
        }

        .detail-left, .detail-right {
            flex: 0 0 48%;
        }

        .detail-left {
            border-right: 1px solid #86efac;
            padding-right: 10px;
        }

        .detail-right {
            padding-left: 10px;
            padding-right: 10px;
            text-align: right;
        }

        .detail-title {
            font-weight: 600;
            font-size: 10px;
            color: #166534;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            background: #dcfce7;
            padding: 1px 4px;
            border-radius: 2px;
            display: inline-block;
        }

        .detail-info {
            font-size: 9px;
            color: #166534;
            line-height: 1.1;
            margin-bottom: 1px;
            padding: 0;
        }

        .detail-info:last-child {
            margin-bottom: 0;
        }

        .date-value {
            color: #166534;
            font-weight: 500;
        }

        .items-table {
            width: 100%;
            font-size: 9px;
            border-collapse: collapse;
            margin: 1mm 0;
            page-break-inside: avoid;
        }

        .items-table th {
            background-color: #38a169;
            color: white;
            padding: 1mm;
            text-align: left;
            font-size: 9px;
        }

        .items-table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 1mm;
            font-size: 9px;
        }

        .total-section {
            margin-top: 2mm;
            font-size: 9px;
            page-break-inside: avoid;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            margin: 0.5mm 0;
        }

        .badge {
            padding: 0.5mm 1mm;
            background-color: #edf2f7;
            border-radius: 2px;
            font-weight: bold;
            font-size: 9px;
        }

        .historique-header {
            margin-top: 2mm;
            font-size: 10px;
            font-weight: bold;
        }

        .notes-table {
            width: 100%;
            font-size: 8px;
            border-collapse: collapse;
            margin-top: 1mm;
            page-break-inside: avoid;
        }

        .notes-table th {
            background-color: #38a169;
            color: white;
            padding: 1mm;
            font-size: 8px;
        }

        .notes-table td {
            padding: 1mm;
            border-bottom: 1px solid #e2e8f0;
            font-size: 8px;
        }

        .conditions {
            margin-top: 2mm;
            font-size: 8px;
            page-break-inside: avoid;
        }

        .conditions ul {
            padding-left: 10px;
            margin: 1mm 0;
        }

        .conditions li {
            margin-bottom: 0.5mm;
        }

        @media print {
            body {
                font-size: 9px;
            }

            .invoice-column {
                border: none;
                padding: 0;
                height: auto;
            }

            .sheet-table td {
                padding: 0;
            }

            .sheet-table tr {
                page-break-after: always;
            }

            .sheet-table tr:last-child {
                page-break-after: avoid;
            }
        }
    </style>
</head>

<body>
    <table class="sheet-table">
        <tr>
            @for ($i = 0; $i < 2; $i++)
                <td>
                    <div class="invoice-column">
                        <div class="header">
                            <div class="brand-section">
                                <div class="brand-text">
                                    <h1>CICA NOBLESSE PRESSING</h1>
                                    <p>Annexe Godomey, Zogbo - Bénin</p>
                                    <p>BP 0272 • IFU : 2201300990000</p>
                                    <p>Tél : (+229) 01 97 89 36 99 / 01 96 44 67 50</p>
                                    <p>Whatsapp : (+229) 01 57 08 31 60 / 01 99 10 70 93</p>
                                </div>
                            </div>
                            <div class="invoice-info">
                                <h2>Facture</h2>
                                <p><strong>N° :</strong> {{ $commande->numero }}</p>
                                {{-- <p><strong>Date dépôt :</strong> {{ \Carbon\Carbon::parse($commande->date_depot)->locale('fr')->isoFormat('LL') }}</p> --}}
                                <p><strong>Agent :</strong> {{ $commande->user->name ?? $commande->user_id }}</p>
                            </div>
                        </div>

                        <div class="details-grid">
                            <div class="detail-left">
                                <div class="detail-title">Informations Client</div>
                                <div class="detail-info">{{ $commande->client }}</div>
                                <div class="detail-info">Contact : <span class="date-value">{{ $commande->numero_whatsapp }}</span></div>
                            </div>
                            <div class="detail-right">
                                <div class="detail-title">DATES DE SERVICE</div>
                                <div class="detail-info">Dépôt : <span class="date-value">{{ \Carbon\Carbon::parse($commande->date_depot)->locale('fr')->isoFormat('LL') }}</span></div>
                                <div class="detail-info">Retrait : <span class="date-value">{{ \Carbon\Carbon::parse($commande->date_retrait)->locale('fr')->isoFormat('LL') }}</span></div>
                            </div>
                        </div>

                        <div class="details-grid">
                            <div class="detail-block">
                                <strong> Type de Service</strong>
                                <span class="service-type">
                                    <span class="icon"></span>
                                    {{ $commande->type_lavage }}
                                    @if(strtolower($commande->type_lavage) === 'lavage express')
                                        <span style="color: #dc2626; font-weight: 500;">(Prix x 2)</span>
                                    @endif
                                </span>
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
                                <p style="text-align:center; font-weight:bold; background:#ffd900; color:#000; font-size:7px; padding:1mm; margin:1mm 0;">Aucune note enregistrée</p>
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
                                <li>1. 10 FCFA par jour pour frais de magasinage seront perçus à partir du 10<sup>e</sup> jour après le dépôt.</li>
                                <li>2. Après deux (02) mois, la maison n'est plus responsable des pertes ou avaries. (60 jours).</li>
                                <li>3. En cas de dommages causés aux effets, la responsabilité du pressing est limitée à :
                                    <ul>
                                        <li>- Huit (8) fois le prix du blanchissage pour tout effet non griffé.</li>
                                        <li>- Dix (10) fois le prix du blanchissage pour les linges griffés.</li>
                                        <li>- Une (1) fois le prix du blanchissage pour les draps.</li>
                                    </ul>
                                </li>
                                <li>4. Les synthétiques, boucles, boutons, fermetures, broderies de fil sur Bazin ne sont pas pris en compte.</li>
                                <li>5. Les effets dépourvus d'étiquetage d'entretien ne sont pas garantis.</li>
                            </ul>
                        </div>

                    </div>
                </td>
            @endfor
        </tr>
    </table>
</body>

</html>
