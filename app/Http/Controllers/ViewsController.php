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
use Illuminate\Support\Facades\Request as RequestFacade;

class ViewsController extends Controller
{

    public function acceuil()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer les commandes en cours (non retirées)
        $commandesEnCours = Commande::where('user_id', $user->id)
            ->where(function($query) {
                $query->where('statut', 'Non retirée')
                      ->orWhere('statut', 'Non retiré')
                      ->orWhere('statut', 'Partiellement payé')
                      ->orWhere('statut', 'Payé - Non retiré');
            })
            ->count();

        // Récupérer les commandes du jour
        $commandesDuJour = Commande::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Récupérer les commandes à retirer (statut "Non retirée")
        $commandesARetirer = Commande::where('user_id', $user->id)
            ->where('statut', 'Non retirée')
            ->count();

        // Calculer le chiffre d'affaires du jour
        $chiffreAffaires = Commande::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        // Récupérer les dernières commandes
        $dernieresCommandes = Commande::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Retourner la vue avec toutes les variables
        return view('utilisateurs.dashboard', compact(
            'commandesEnCours',
            'commandesDuJour',
            'commandesARetirer',
            'chiffreAffaires',
            'dernieresCommandes'
        ));
    }

    public function dashboard()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer les commandes en cours (non retirées)
        $commandesEnCours = Commande::where('user_id', $user->id)
            ->where(function($query) {
                $query->where('statut', 'Non retirée')
                      ->orWhere('statut', 'Non retiré')
                      ->orWhere('statut', 'Partiellement payé')
                      ->orWhere('statut', 'Payé - Non retiré');
            })
            ->count();

        // Récupérer les commandes du jour
        $commandesDuJour = Commande::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Récupérer les commandes à retirer (statut "Non retirée")
        $commandesARetirer = Commande::where('user_id', $user->id)
            ->where('statut', 'Non retirée')
            ->count();

        // Calculer le chiffre d'affaires du jour
        $chiffreAffaires = Commande::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        // Récupérer les dernières commandes
        $dernieresCommandes = Commande::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Retourner la vue avec toutes les variables
        return view('utilisateurs.dashboard', compact(
            'commandesEnCours',
            'commandesDuJour',
            'commandesARetirer',
            'chiffreAffaires',
            'dernieresCommandes'
        ));
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
        $user = Auth::user();

        // 2) Récupérer les commandes
        $commandes = Commande::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // 3) Calculer les totaux des commandes
        $totalVentes = $commandes->sum('total');
        $totalAvances = $commandes->sum('avance');
        $totalReste = $totalVentes - $totalAvances;
        $totalCommandes = $commandes->count();
        $totalCommandesPayees = $commandes->where('statut', 'Payé')->count();
        $totalCommandesNonPayees = $commandes->where('statut', 'Non payé')->count();
        $totalCommandesPartiellementPayees = $commandes->where('statut', 'Partiellement payé')->count();
        $totalRetraits = $commandes->where('statut', 'Retiré')->count();
        $soldeTotal = $totalVentes - $totalAvances;

        // 4) Récupérer les notes (retraits) pour aujourd'hui uniquement
        $notes = Note::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();

        // 5) Récupérer les paiements pour aujourd'hui uniquement
        $payments = CommandePayment::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();

        // 6) Calculer le montant total des paiements
        $montant_total_paiements = $payments->sum('amount');

        // 7) Créer la collection des transactions
        $transactions = collect();

        // Ajouter les paiements comme transactions
        foreach ($payments as $payment) {
            $transactions->push([
                'date' => $payment->created_at,
                'type' => 'Entrée',
                'montant' => $payment->amount,
                'description' => 'Paiement - ' . ($payment->payment_method ?? 'Non spécifié'),
                'commande_id' => $payment->commande_id,
                'user' => $payment->user->name ?? 'Utilisateur Inconnu',
                'payment_method' => $payment->payment_method ?? 'Non spécifié',
                'payment_type' => $payment->payment_type ?? 'Non spécifié',
                'statut' => 'Payé'
            ]);
        }

        // Ajouter les retraits comme transactions
        foreach ($notes as $note) {
            // On suppose que le montant du retrait est dans la note
            $montant = floatval(preg_replace('/[^0-9.]/', '', $note->note));
            if ($montant > 0) {
                $transactions->push([
                    'date' => $note->created_at,
                    'type' => 'Sortie',
                    'montant' => -$montant,
                    'description' => 'Retrait - ' . $note->note,
                    'commande_id' => $note->commande_id,
                    'user' => $note->user->name ?? 'Utilisateur Inconnu',
                    'payment_method' => 'Retrait',
                    'payment_type' => 'Retrait',
                    'statut' => 'Retiré'
                ]);
            }
        }

        // Trier les transactions par date
        $transactions = $transactions->sortByDesc('date');

        // Convertir la collection en pagination
        $page = request()->get('page', 1);
        $perPage = 10;
        $transactions = new \Illuminate\Pagination\LengthAwarePaginator(
            $transactions->forPage($page, $perPage),
            $transactions->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // 8) Retourner la vue avec les données
        return view('utilisateurs.comptabilite', compact(
            'commandes',
            'totalVentes',
            'totalAvances',
            'totalReste',
            'totalCommandes',
            'totalCommandesPayees',
            'totalCommandesNonPayees',
            'totalCommandesPartiellementPayees',
            'totalRetraits',
            'soldeTotal',
            'notes',
            'payments',
            'montant_total_paiements',
            'transactions'
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
