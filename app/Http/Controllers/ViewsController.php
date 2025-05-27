<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\Objets;
use App\Models\Objects;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Models\CommandePayment;
use Illuminate\Support\Facades\Auth;

class ViewsController extends Controller
{

    public function acceuil()
    {
        // // Récupérer les horaires existants
        // $horaire = Horaire::first();
        // $hours = OpeningHour::all();


        // Logique spécifique pour la page des commandes (si nécessaire)
        return view('utilisateurs.dashboard'); // Retourne la vue 'commandes.blade.php'
    }
    public function commandes()
    {
        // Récupérer les objets disponibles
        $objets = Objets::all();

        // Générer un numéro de commande unique
        $annee = Carbon::now()->year;
        $prefixe = "Facture-" . $annee . "-";

        // Trouver le dernier numéro de commande
        $dernierNumero = Commande::where('numero', 'like', $prefixe . '%')
            ->latest('created_at')
            ->first();

        //    Générer le prochain numéro de commande
        if ($dernierNumero) {
            $dernierNum = (int) substr($dernierNumero->numero, -3);
            $nouveauNum = str_pad($dernierNum + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nouveauNum = '001';
        }

        //    Combiné pour avoir le numéro complet de la commande
        $numeroCommande = $prefixe . $nouveauNum;

        //    Passer la variable $numeroCommande et les objets à la vue
        return view('utilisateurs.commandes', compact('objets'));
    }



    // public function rappels()
    // {
    //     $today = Carbon::today()->toDateString();
    //     $commandes = Commande::whereDate('date_retrait', $today)
    //                     ->with(['objets', 'user']) // charger les relations si nécessaire
    //                     ->get();

    //     return view('utilisateurs.rappels', compact('commandes'));
    // }


    public function creations()
    {
        // Logique spécifique pour la page des créations (si nécessaire)
        return view('administrateur.creationObjets '); // Retourne la vue 'creations.blade.php'
    }

    public function profil()
    {
        // Logique spécifique pour la page du profil (si nécessaire)
        return view('utilisateurs.profil'); // Retourne la vue 'profil.blade.php'
    }

    public function historiques()
    {
        // Logique spécifique pour la page des historiques (si nécessaire)
        return view('utilisateurs.historiques'); // Retourne la vue 'historiques.blade.php'
    }

    public function detailsRetrait($id)
    {
        // Récupère le retrait avec ses relations
        // $retrait = Retrait::with(['commande.objets', 'user'])->findOrFail($id);

        // Retourne la vue avec le retrait
        return view('utilisateurs.detailsRetraits', );
    }

    public function enAttente()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer toutes les commandes de l'utilisateur qui sont en attente
        $commandes = Commande::where('user_id', $user->id)
            ->where(function($query) {
                $query->where('statut', 'Non retirée')
                      ->orWhere('statut', 'Non retiré')
                      ->orWhere('statut', 'Partiellement payé')
                      ->orWhere('statut', 'Payé - Non retiré');
            })
            ->orderBy('date_retrait', 'asc')  // Trier par date de retrait croissante
            ->get();

        // Passer les commandes à la vue 'utilisateurs.pending'
        return view('utilisateurs.pending', compact('commandes'));
    }

    public function comptabilite()
    {
        // 1) Récupérer l'ID de l'utilisateur connecté
        $userId = Auth::id();

        // 2) Définir la date d'aujourd'hui
        $today = Carbon::today()->toDateString();

        // 3) Charger les commandes de l'utilisateur créées aujourd'hui
        $commandes = Commande::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->get();

        // Calculer le montant total des commandes
        $total = $commandes->sum('total');

        // 5) Charger les paiements de l'utilisateur réalisés aujourd'hui
        $payments = CommandePayment::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->get();

        // 6) Charger les notes de l'utilisateur créées aujourd'hui
        $notes = Note::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->get();

        // Calculer le montant total des paiements
        $montant_total_paiements = $payments->sum('amount');

        // Récupérer tous les mouvements d'argent (paiements et retraits)
        $mouvements = collect();

        // Ajouter les paiements comme mouvements positifs
        foreach ($payments as $payment) {
            $mouvements->push([
                'date' => $payment->created_at,
                'type' => 'Entrée',
                'montant' => $payment->amount,
                'description' => 'Paiement - ' . ($payment->payment_method ?? 'Non spécifié'),
                'commande_id' => $payment->commande_id,
                'user' => $payment->user->name ?? 'Utilisateur Inconnu'
            ]);
        }

        // Ajouter les retraits comme mouvements négatifs
        foreach ($notes as $note) {
            // On suppose que le montant du retrait est dans la note
            $montant = floatval(preg_replace('/[^0-9.]/', '', $note->note));
            if ($montant > 0) {
                $mouvements->push([
                    'date' => $note->created_at,
                    'type' => 'Sortie',
                    'montant' => -$montant,
                    'description' => 'Retrait - ' . $note->note,
                    'commande_id' => $note->commande_id,
                    'user' => $note->user->name ?? 'Utilisateur Inconnu'
                ]);
            }
        }

        // Trier les mouvements par date
        $mouvements = $mouvements->sortBy('date');

        // 7) Retourner la vue avec les données
        return view('utilisateurs.comptabilite', compact(
            'commandes',
            'payments',
            'notes',
            'userId',
            'montant_total_paiements',
            'mouvements',
            'total'
        ));
    }





    public function rappels($commandeId = null)
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = Auth::id();

        // Date d'aujourd'hui
        $today = Carbon::today()->toDateString();

        if ($commandeId) {
            // On ne charge la commande que si elle est retirée, appartient à l'utilisateur
            // ET si sa date_retrait est aujourd'hui
            $commandes = Commande::where('id', $commandeId)
                ->where('user_id', $userId)
                ->where('statut', 'Retiré')
                ->whereDate('date_retrait', $today)
                ->with('objets')
                ->get();

            // Notes associées à cette commande, créées aujourd'hui
            $notes = Note::where('commande_id', $commandeId)
                ->whereDate('created_at', $today)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Toutes les commandes retirées pour cet utilisateur dont le retrait est aujourd'hui
            $commandes = Commande::where('user_id', $userId)
                ->where('statut', 'Retiré')
                ->whereDate('date_retrait', $today)
                ->get();

            // Toutes les notes de l'utilisateur créées aujourd'hui
            $notes = Note::where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('utilisateurs.rappels', compact('commandes', 'notes'));
    }



    public function pageRetrait(Commande $commande)
    {
        return view('utilisateurs.faireRetrait', [
            'commande' => $commande
        ]);
    }






}
