<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Retraits @if(isset($periode)) du {{ $periode }} @endif</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 20px; }
        h2 { text-align: center; color: #007bff; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .total { font-weight: bold; background-color: #f8f9fa; }
        @media print { button { display: none; } }
    </style>
</head>
<body>
    <h2>Liste des Retraits @if(isset($periode)) du {{ $periode }} @endif</h2>
    <table>
        <thead>
            <tr>
                <th>N° Commande</th>
                <th>Client</th>
                <th>Heure de Retrait</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($commandes as $commande)
                <tr>
                    <td>{{ $commande->numero }}</td>
                    <td>{{ $commande->client }}</td>
                    <td>{{ $commande->heure_retrait }}</td>
                </tr>
            @empty
                <tr><td colspan="3" style="text-align:center;">Aucun retrait pour cette période</td></tr>
            @endforelse
        </tbody>
    </table>
    <script>
        window.onload = function() { window.print(); };
    </script>
</body>
</html>
