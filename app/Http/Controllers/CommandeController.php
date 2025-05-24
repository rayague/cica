<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\Objets;
use App\Models\Objects;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Models\CommandePayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    public function create()
    {
        // Récupérer les objets disponibles
        $objets = Objets::all();

        // Générer un numéro de commande unique
        $annee = Carbon::now()->year;
        $prefixe = "ETS-NKPA-" . $annee . "-";

        // Trouver le dernier numéro de commande
        $dernierNumero = Commande::where('numero', 'like', $prefixe . '%')
            ->latest('created_at')
            ->first();

        // Générer le prochain numéro de commande
        if ($dernierNumero) {
            $dernierNum = (int) substr($dernierNumero->numero, -3);
            $nouveauNum = str_pad($dernierNum + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nouveauNum = '001';
        }

        // Combiné pour avoir le numéro complet de la commande
        $numeroCommande = $prefixe . $nouveauNum;

        // Passer la variable $numeroCommande et les objets à la vue
        return view('utilisateurs.commandes', compact('objets', 'numeroCommande'));
    }

    public function store(Request $request)
    {
        try {
            // Vérifier si l'utilisateur est authentifié
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Veuillez vous connecter pour effectuer une commande.');
            }

            // Validation des données
            $request->validate([
                'client' => 'required|string',
                'numero_whatsapp' => 'required|string',
                'date_retrait' => 'required|date',
                'heure_retrait' => 'required|date_format:H:i',
                'type_lavage' => 'required|string',
                'objets' => 'required|array',
                'objets.*.id' => 'required|exists:objets,id',
                'objets.*.quantite' => 'required|integer|min:1',
                'objets.*.description' => 'required|string',
                'avance_client' => 'nullable|numeric|min:0',
                'remise_reduction' => 'nullable|in:0,5,10,15,20,25,30',
            ]);

            // Générer un numéro de commande unique
            $annee = Carbon::now()->year;
            $prefixe = "ETS-NKPA-" . $annee . "-";

            // Trouver le dernier numéro de commande
            $dernierNumero = Commande::where('numero', 'like', $prefixe . '%')
                ->latest('created_at')
                ->first();

            // Générer le prochain numéro de commande
            if ($dernierNumero) {
                $dernierNum = (int) substr($dernierNumero->numero, -3);
                $nouveauNum = str_pad($dernierNum + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $nouveauNum = '001';
            }

            // Combiné pour avoir le numéro complet de la commande
            $numeroCommande = $prefixe . $nouveauNum;

            // Création de la commande
            $commande = Commande::create([
                'user_id' => Auth::user()->id,
                'numero' => $numeroCommande,
                'client' => $request->client,
                'numero_whatsapp' => $request->numero_whatsapp,
                'date_depot' => Carbon::now()->toDateString(),
                'date_retrait' => $request->date_retrait,
                'heure_retrait' => $request->heure_retrait,
                'type_lavage' => $request->type_lavage,
                'avance_client' => $request->avance_client ?? 0,
                'remise_reduction' => $request->remise_reduction ?? 0,
                'statut' => 'Non retirée'
            ]);

            // Calculer le total initial (sans réduction)
            $totalCommande = 0;
            foreach ($request->objets as $objetData) {
                $objet = Objets::findOrFail($objetData['id']);
                $quantite = $objetData['quantite'];
                $totalCommande += $objet->prix_unitaire * $quantite;

                // Attacher l'objet à la commande
                $commande->objets()->attach($objetData['id'], [
                    'quantite' => $quantite,
                    'description' => $objetData['description'],
                ]);
            }

            // Conserver le total initial avant réduction
            $originalTotal = $totalCommande;

            // Calcul de la réduction
            $remiseReduction = $request->remise_reduction ?? 0;
            $discountAmount = 0;
            if ($remiseReduction > 0) {
                $discountAmount = $totalCommande * ($remiseReduction / 100);
                $totalCommande = $totalCommande - $discountAmount;
            }

            // Si le type de lavage est "Lavage express", doubler les montants
            if (strtolower($request->type_lavage) === 'lavage express') {
                $totalCommande *= 2;
                $originalTotal *= 2;
                $discountAmount *= 2;
            }

            // Calculer les informations financières
            $avanceClient = $request->avance_client ?? 0;
            $soldeRestant = max(0, $totalCommande - $avanceClient);

            // Mettre à jour la commande avec le total final et le solde restant
            $commande->update([
                'total' => $totalCommande,
                'solde_restant' => $soldeRestant,
                'original_total' => $originalTotal,
                'discount_amount' => $discountAmount,
                'remise_reduction' => $remiseReduction,
            ]);

            return redirect()->route('commandes.show', $commande->id)
                ->with('success', 'Commande validée avec succès!')
                ->with([
                    'originalTotal' => $originalTotal,
                    'discountAmount' => $discountAmount,
                    'remiseReduction' => $remiseReduction,
                ]);

        } catch (\Exception $e) {
            // En cas d'erreur, supprimer la commande si elle a été créée
            if (isset($commande)) {
                $commande->delete();
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de la commande. Veuillez réessayer.');
        }
    }

    public function updateFinancial(Request $request, Commande $commande)
    {
        // Vérifier que l'utilisateur connecté est bien celui qui a créé la commande
        if (Auth::id() !== $commande->user_id) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Non autorisé'], 403);
            }
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à mettre à jour cette commande.');
        }

        // Valider les données du formulaire
        $request->validate([
            'montant_paye' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
        ]);

        $montantPaye = floatval($request->input('montant_paye'));
        $paymentMethod = $request->input('payment_method') ?? null;

        // Créer un enregistrement de paiement via le modèle CommandePayment
        CommandePayment::create([
            'commande_id' => $commande->id,
            'user_id' => Auth::id(),
            'amount' => $montantPaye,
            'payment_method' => $paymentMethod,
        ]);

        // Rafraîchir l'instance de commande et recharger la relation payments
        $commande->refresh();
        $commande->load('payments');

        // Calculer le cumul des avances versées
        $totalAvance = $commande->payments->sum('amount');

        // Mettre à jour l'avance client et recalculer le solde restant
        $commande->avance_client = $totalAvance;
        $commande->solde_restant = max(0, $commande->total - $totalAvance);

        // Mettre à jour le statut de la commande selon les nouvelles règles
        if ($commande->solde_restant == 0) {
            $commande->statut = 'Payé - Non retiré';
        } elseif ($commande->avance_client > 0) {
            $commande->statut = 'Partiellement payé';
        } else {
            $commande->statut = 'Non retiré';
        }

        // Sauvegarder les modifications
        $commande->save();

        return redirect()->back()->with('success', 'Les informations financières ont été mises à jour avec succès.');
    }

    public function index()
    {
        // Récupérer les objets disponibles
        $objets = Objets::all();

        // Générer un numéro de commande unique
        $annee = Carbon::now()->year;
        $prefixe = "ETS-" . $annee . "-";

        // Trouver le dernier numéro de commande
        $dernierNumero = Commande::where('numero', 'like', $prefixe . '%')
            ->latest('created_at')
            ->first();

        // Générer le prochain numéro de commande
        if ($dernierNumero) {
            $dernierNum = (int) substr($dernierNumero->numero, -3);
            $nouveauNum = str_pad($dernierNum + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nouveauNum = '001';
        }

        // Combiné pour avoir le numéro complet de la commande
        $numeroCommande = $prefixe . $nouveauNum;

        // Passer la variable $numeroCommande et les objets à la vue
        return view('utilisateurs.commandes', compact('objets', 'numeroCommande'));
    }

    public function listeCommandes()
    {
        $userId = Auth::id(); // Récupérer l'ID de l'utilisateur connecté

        $commandes = Commande::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today()) // Filtrer par date du jour
            ->get();

        $objets = Objets::all();

        return view('utilisateurs.listeCommandes', compact('commandes', 'objets'));
    }

    public function show($id)
    {
        // Récupérer la commande avec ses objets associés
        $commande = Commande::with('objets')->findOrFail($id);

        // Récupérer la note relative à la commande
        $notes = Note::where('commande_id', $commande->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        // Calcul du total initial sans réduction
        $originalTotal = 0;
        foreach ($commande->objets as $objet) {
            $originalTotal += $objet->prix_unitaire * $objet->pivot->quantite;
        }
        if (strtolower($commande->type_lavage) === 'lavage express') {
            $originalTotal *= 2;
        }

        // Récupérer le pourcentage de réduction et calculer le montant de la réduction
        $remiseReduction = (float) $commande->remise_reduction;
        $discountAmount = 0;
        if ($remiseReduction > 0) {
            $discountAmount = $originalTotal * ($remiseReduction / 100);
        }
        $finalTotal = $originalTotal - $discountAmount;

        return view('utilisateurs.commandesDetails', compact(
            'commande',
            'notes',
            'originalTotal',
            'discountAmount',
            'remiseReduction',
            'finalTotal'
        ));
    }

    public function completerPaiement(Request $request, Commande $commande)
    {
        // Validation : on s'assure que l'utilisateur fournit un montant additionnel positif
        $request->validate([
            'montant_additionnel' => 'required|numeric|min:0'
        ]);

        $montantAdditionnel = $request->input('montant_additionnel');

        // Mettre à jour le montant remis : on ajoute le montant additionnel à la valeur existante
        $nouveauMontantRemis = $commande->montant_remis + $montantAdditionnel;
        $commande->update([
            'montant_remis' => $nouveauMontantRemis,
            'user_id' => Auth::id(), // Stocker l'utilisateur qui effectue l'opération
        ]);

        // Recharger la commande avec ses objets et retraits
        $commande->load('objets', 'retraits');

        // Recalculer le coût total de la commande
        $totalCommande = $commande->objets->sum(function ($objet) {
            return $objet->prix_unitaire * $objet->pivot->quantite;
        });

        // Recalculer le total des retraits déjà effectués
        $totalRetraits = $commande->retraits->sum('cout');

        // Calculer les indicateurs financiers
        $soldeRestant = $nouveauMontantRemis - $totalRetraits;
        $resteAPayer = max(0, $totalCommande - $nouveauMontantRemis);

        // Mettre à jour la commande avec les nouveaux indicateurs financiers
        $commande->update([
            'cout_total_commande' => $totalCommande,
            'total_retraits' => $totalRetraits,
            'solde_restant' => $soldeRestant,
            'reste_a_payer' => $resteAPayer,
        ]);

        return redirect()->route('commandes.show', $commande->id)
            ->with('success', 'Montant additionnel enregistré. Le solde a été mis à jour.');
    }

    // Méthode pour afficher les commandes journalières
    public function journalieres(Request $request)
    {
        $userId = Auth::id(); // Récupérer l'ID de l'utilisateur connecté

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $commandes = Commande::where('user_id', $userId) // Filtrer par utilisateur
            ->whereBetween('date_depot', [$validated['start_date'], $validated['end_date']])
            ->orderBy('date_depot')
            ->get();

        // Retourner la vue avec les commandes filtrées
        return view('utilisateurs.commandesJournalieres', [
            'commandes' => $commandes,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date']
        ]);
    }

    public function valider($id)
    {
        // Récupérer la commande
        $commande = Commande::findOrFail($id);

        // Mettre à jour le statut de la commande
        $commande->update([
            'statut' => 'Retiré',
            'solde_restant' => 0, // Mettre à jour le solde restant à 0 car la facture est validée
            'avance_client' => $commande->total // Mettre à jour l'avance client au montant total
        ]);

        // Rediriger vers la page précédente avec un message de succès
        return redirect()->back()->with('success', 'La facture a été validée avec succès.');
    }

    public function printListeCommandes(Request $request)
    {
        $userId = Auth::id(); // 🔐 Utilisateur connecté

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date') ?? now()->format('Y-m-d');

        $commandes = Commande::where('user_id', $userId)
            ->whereBetween('date_depot', [$start_date, $end_date]) // 👈 ici !
            ->orderBy('date_depot')
            ->get();

        $totalMontant = $commandes->sum('total');

        $pdf = Pdf::loadView('utilisateurs.previewListeCommandes', compact('commandes', 'start_date', 'end_date', 'totalMontant'));

        return $pdf->stream('liste_commandes.pdf');
    }

    public function printListeCommandesPending(Request $request)
    {
        $userId = Auth::id();

        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin') ?? now()->format('Y-m-d');

        $commandes = Commande::where('user_id', $userId)
            ->whereBetween('date_retrait', [$date_debut, $date_fin])
            ->where('statut', 'non retirée')
            ->orderBy('date_retrait')
            ->get();

        $pdf = Pdf::loadView('utilisateurs.previewListePending', compact('commandes', 'date_debut', 'date_fin'));

        return $pdf->stream('liste_commandes_pending.pdf');
    }

    public function filtrerPending(Request $request)
    {
        $userId = Auth::id(); // Récupérer l'ID de l'utilisateur connecté
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin', today()->toDateString());

        $commandes = Commande::where('user_id', $userId) // Filtrer par utilisateur
            ->whereBetween('date_retrait', [$date_debut, $date_fin])
            ->get();

        $montant_total = $commandes->sum('total');

        // Si $objets est nécessaire, ajoute-le ici (remplace par la bonne requête)
        $objets = Objets::all();

        return view('utilisateurs.listeCommandesFiltrePending', compact('commandes', 'date_debut', 'date_fin', 'montant_total', 'objets'));
    }

    public function retraitsFiltrer(Request $request)
    {
        $userId = Auth::id(); // Récupérer l'ID de l'utilisateur connecté
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin', today()->toDateString());

        $commandes = Commande::where('user_id', $userId) // Filtrer par utilisateur
            ->whereBetween('date_retrait', [$date_debut, $date_fin])
            ->where('statut', 'retirée')
            ->get();

        $montant_total = $commandes->sum('total');

        // Si $objets est nécessaire, ajoute-le ici (remplace par la bonne requête)
        $objets = Objets::all();

        return view('utilisateurs.listeCommandesFiltreRetraits', compact('commandes', 'date_debut', 'date_fin', 'montant_total', 'objets'));
    }

    public function printListeCommandesRetraits(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin') ?? now()->format('Y-m-d');

        $commandes = Commande::whereBetween('date_retrait', [$date_debut, $date_fin])
            ->where('statut', 'non retirée')
            ->orderBy('date_retrait')
            ->get();

        // Générer le PDF
        $pdf = Pdf::loadView('utilisateurs.previewListeRetraits', compact('commandes', 'date_debut', 'date_fin'));

        // Télécharger ou afficher dans le navigateur
        return $pdf->stream('liste_commandes_retraits.pdf'); // Pour afficher directement
        // return $pdf->download('liste_commandes_pending.pdf'); // Pour télécharger
    }

    public function ComptabiliteFiltrer(Request $request)
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = Auth::id();

        // Récupérer la période demandée dans la requête
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin', today()->toDateString());

        // Récupérer les commandes de l'utilisateur filtrées par la période
        $commandes = Commande::where('user_id', $userId)
            ->whereBetween('date_retrait', [$date_debut, $date_fin])
            ->where('statut', 'retirée')
            ->get();

        // Calculer le montant total des commandes dans la période
        $montant_total = $commandes->sum('total');

        // Récupérer les paiements et les notes de l'utilisateur
        $payments = CommandePayment::where('user_id', $userId)
            ->whereBetween('created_at', [$date_debut, $date_fin]) // Filtrer les paiements dans la période
            ->get();

        $notes = Note::where('user_id', $userId)
            ->whereBetween('created_at', [$date_debut, $date_fin]) // Filtrer les notes dans la période
            ->get();

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
            // Vous devrez adapter cette partie selon votre structure de données
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

        $montant_total_paiements = $payments->sum('amount'); // Calcul du total des montants
        // Récupérer les objets associés à l'utilisateur
        $objets = Objets::all();

        // Passer les données à la vue
        return view('utilisateurs.comptabiliteFiltreRetraits', compact(
            'commandes',
            'payments',
            'notes',
            'userId',
            'date_debut',
            'date_fin',
            'montant_total',
            'objets',
            'montant_total_paiements',
            'mouvements'
        ));
    }

    public function recherche(Request $request)
    {
        $userId = Auth::id();

        // on récupère la chaîne tapée
        // (si vous gardez name="client", remplacez 'search' par 'client' ici)
        $search = $request->input('client');

        // on commence la requête : commandes de l'utilisateur
        $commandes = Commande::where('user_id', $userId)
            // si search n'est pas vide, on ajoute le filtre multi-colonnes
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('client', 'like', "%{$search}%")
                        ->orWhere('numero_whatsapp', 'like', "%{$search}%")
                        ->orWhere('numero', 'like', "%{$search}%");
                });
            })
            ->get();

        $objets = Objets::all();

        $message = $commandes->isEmpty()
            ? "Aucun résultat pour « {$search} »."
            : null;

        return view('utilisateurs.listeCommandes', compact('commandes', 'objets', 'message', 'search'));
    }

    public function rechercheRetrait(Request $request)
    {
        $userId = Auth::id();

        // on récupère la chaîne tapée
        // (si vous gardez name="client", remplacez 'search' par 'client' ici)
        $search = $request->input('client');

        // on commence la requête : commandes de l'utilisateur
        $commandes = Commande::where('user_id', $userId)
            // si search n'est pas vide, on ajoute le filtre multi-colonnes
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('client', 'like', "%{$search}%")
                        ->orWhere('numero_whatsapp', 'like', "%{$search}%")
                        ->orWhere('numero', 'like', "%{$search}%");
                });
            })
            ->get();

        $objets = Objets::all();

        $message = $commandes->isEmpty()
            ? "Aucun résultat pour « {$search} »."
            : null;

        return view('utilisateurs.rappelsRecherche', compact('commandes', 'objets', 'message', 'search'));
    }
}
