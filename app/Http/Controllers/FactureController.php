<?php

namespace App\Http\Controllers;

use App\Models\Note;
// use Barryvdh\DomPDF\PDF;
use App\Models\Commande;
// use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class FactureController extends Controller
{

    public function print($id)
    {
        // Récupérer la commande avec ses objets associés
        $commande = Commande::with('objets')->findOrFail($id);
        $notes = Note::where('commande_id', $commande->id)->with('user')->get(); // Vérifie bien la relation avec la table des notes

        // Calculer le total sans réduction
        $originalTotal = $commande->objets->sum(function($objet) {
            return $objet->pivot->quantite * $objet->prix_unitaire;
        });

        // Récupérer le pourcentage de réduction (assurez-vous que la colonne s'appelle bien 'remise' ou 'remise_reduction' dans votre base)
        $remiseReduction = $commande->remise_reduction ?? 0;

        // Calculer le montant de la réduction
        $discountAmount = ($originalTotal * $remiseReduction) / 100;

        // Convertir le logo en base64
        $logoPath = public_path('images/Cica.png');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Générer le PDF en utilisant la vue 'utilisateurs.preview'
        $pdf = Pdf::loadView('utilisateurs.preview', compact('commande', 'originalTotal', 'remiseReduction', 'discountAmount', 'notes', 'logoBase64'));

        // Retourner le PDF pour affichage inline
        return $pdf->stream('facture_' . $commande->numero . '.pdf');
    }

    protected function generatePdf($id)
    {
        $commande = Commande::with('objets')->findOrFail($id);

        $originalTotal = $commande->objets->sum(function($objet) {
            return $objet->pivot->quantite * $objet->prix_unitaire;
        });

        $remiseReduction = $commande->remise_reduction ?? 0;
        $discountAmount = ($originalTotal * $remiseReduction) / 100;

        $notes = \App\Models\Note::where('commande_id', $commande->id)->with('user')->get();
        $logoPath = public_path('images/Cica.png');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Utiliser la vue preview pour le PDF individuel
        return Pdf::loadView('utilisateurs.preview', compact('commande', 'originalTotal', 'remiseReduction', 'discountAmount', 'notes', 'logoBase64'));
    }

    public function stream($id)
    {
        $pdf = $this->generatePdf($id);
        return $pdf->stream('facture_' . $id . '.pdf');
    }

    public function download($id)
    {
        // Récupérer la commande avec ses objets associés
        $commande = \App\Models\Commande::with('objets')->findOrFail($id);
        $notes = \App\Models\Note::where('commande_id', $commande->id)->with('user')->get();

        // Calculer le total sans réduction
        $originalTotal = $commande->objets->sum(function($objet) {
            return $objet->pivot->quantite * $objet->prix_unitaire;
        });

        $remiseReduction = $commande->remise_reduction ?? 0;
        $discountAmount = ($originalTotal * $remiseReduction) / 100;

        $logoPath = public_path('images/Cica.png');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Utiliser la même vue et options que les admins
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('administrateur.preview', compact('commande', 'originalTotal', 'remiseReduction', 'discountAmount', 'notes', 'logoBase64'));

        // Configurer les options du PDF comme pour les admins
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isPhpEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('dpi', 150);
        $pdf->setOption('defaultFont', 'sans-serif');
        $pdf->setOption('margin-top', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('margin-bottom', 0);
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('page-size', 'A4');
        $pdf->setOption('orientation', 'landscape');
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('enable-local-file-access', true);
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 1000);
        $pdf->setOption('no-stop-slow-scripts', true);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('print-media-type', true);
        $pdf->setOption('disable-smart-shrinking', false);
        $pdf->setOption('zoom', 1);
        $pdf->setOption('page-width', '297mm');
        $pdf->setOption('page-height', '210mm');
        $pdf->setOption('footer-right', '');
        $pdf->setOption('footer-left', '');
        $pdf->setOption('footer-center', '');
        $pdf->setOption('header-right', '');
        $pdf->setOption('header-left', '');
        $pdf->setOption('header-center', '');
        $pdf->setOption('footer-spacing', 0);
        $pdf->setOption('header-spacing', 0);
        $pdf->setOption('margin-footer', 0);
        $pdf->setOption('margin-header', 0);

        return $pdf->download('facture_' . $commande->numero . '.pdf');
    }

    // La méthode print initiale peut rediriger vers la page de prévisualisation
    // public function print($id)
    // {
    //     // Afficher la vue de prévisualisation qui contient l'iframe
    //     $commande = Commande::findOrFail($id);
    //     return view('factures.preview', compact('commande'));
    // }

    public function storeNote(Request $request, $commande_id)
    {
        // Validation du champ note
        $request->validate([
            'note' => 'required|string',
        ]);

        // Récupérer la commande avec ses informations
        $commande = Commande::with('objets')->findOrFail($commande_id);
        $user = Auth::user();

        // Préparer un tableau avec des détails importants de la commande
        $commandeDetails = [
            'numero'            => $commande->numero,
            'client'            => $commande->client,
            'numero_whatsapp'   => $commande->numero_whatsapp,
            'date_depot'        => $commande->date_depot,
            'date_retrait'      => $commande->date_retrait,
            'total'             => $commande->total,
            // Vous pouvez ajouter d'autres informations si nécessaire
        ];

        // Enregistrer la note dans la table 'notes'
        $note = Note::create([
            'commande_id'       => $commande->id,
            'user_id'           => $user->id,
            'note'              => $request->input('note'),
            'commande_details'  => $commandeDetails, // Grâce au cast, l'array sera converti en JSON
        ]);

        return redirect()->route('commandes.show', $commande->id)->with('note', $note);
    }

    public function index()
    {
        // Récupérer toutes les commandes (les factures) triées par date de création décroissante
        $factures = Commande::orderBy('created_at', 'desc')->get();

        return view('utilisateurs.factures', compact('factures'));
    }

}
