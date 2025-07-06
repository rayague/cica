<?php

require_once 'vendor/autoload.php';

use App\Models\Notification;
use App\Models\Commande;

// Charger Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Récupérer la première commande
    $commande = Commande::first();
    
    if ($commande) {
        echo "Commande trouvée: {$commande->numero}\n";
        
        // Créer une notification de test
        $notification = Notification::create([
            'commande_id' => $commande->id,
            'user_id' => 1,
            'action' => 'test',
            'changes' => ['test' => 'data'],
            'description' => 'Test notification'
        ]);
        
        echo "Notification créée avec succès! ID: {$notification->id}\n";
        
        // Vérifier qu'elle existe
        $count = Notification::where('commande_id', $commande->id)->count();
        echo "Nombre de notifications pour cette commande: {$count}\n";
        
    } else {
        echo "Aucune commande trouvée\n";
    }
    
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 