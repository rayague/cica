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
use App\Models\CommandeImage;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class CommandeController extends Controller
{
    public function create()
    {
        // Récupérer les objets disponibles
        $objets = Objets::all();

        // Générer un numéro de commande unique
        $annee = Carbon::now()->year;
        $prefixe = " ";

        // Trouver le dernier numéro de commande
        $dernierNumero = Commande::where('numero', 'like', $prefixe . '%')
            ->latest('created_at')
            ->first();

        // Générer le prochain numéro de commande
        if ($dernierNumero) {
            $dernierNum = (int) substr($dernierNumero->numero, -4);
            $nouveauNum = str_pad($dernierNum + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nouveauNum = '0001';
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
                'heure_retrait' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'],
                'type_lavage' => 'required|string',
                'objets' => 'required|array',
                'objets.*.id' => 'required|exists:objets,id',
                'objets.*.quantite' => 'required|integer|min:1',
                'objets.*.description' => 'nullable|string',
                'avance_client' => 'nullable|numeric|min:0',
                'remise_reduction' => 'nullable|in:0,5,10,15,20,25,30',
            ]);

            // Générer un numéro de commande unique
            $annee = Carbon::now()->year;
            $prefixe = " ";

            // Trouver le dernier numéro de commande
            $dernierNumero = Commande::where('numero', 'like', $prefixe . '%')
                ->latest('created_at')
                ->first();

            // Générer le prochain numéro de commande
            if ($dernierNumero) {
                $dernierNum = (int) substr($dernierNumero->numero, -4);
                $nouveauNum = str_pad($dernierNum + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $nouveauNum = '0001';
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

            // Si une avance client est fournie, créer un enregistrement de paiement
            if ($avanceClient > 0) {
                CommandePayment::create([
                    'commande_id' => $commande->id,
                    'user_id' => Auth::id(),
                    'amount' => $avanceClient,
                    'payment_method' => 'Avance initiale',
                    'payment_type' => $request->input('payment_type', 'Espèce'),
                ]);

                // Mettre à jour le statut de la commande selon les nouvelles règles
                if ($soldeRestant == 0) {
                    $commande->update(['statut' => 'Payé - Non retiré']);
                } elseif ($avanceClient > 0) {
                    $commande->update(['statut' => 'Partiellement payé']);
                }
            }

            if ($soldeRestant > 0) {
                // Vérifier s'il existe déjà une avance pour cette commande
                $avanceExistante = \App\Models\CommandePayment::where('commande_id', $commande->id)
                    ->where('payment_method', 'Avance initiale')
                    ->exists();
                if (!$avanceExistante) {
                    CommandePayment::create([
                        'commande_id' => $commande->id,
                        'user_id' => Auth::id(),
                        'amount' => $soldeRestant,
                        'payment_method' => 'Validation',
                        'payment_type' => 'Validation',
                    ]);
                }
            }

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

        // Vérifier si le solde est déjà à zéro
        if ($commande->solde_restant <= 0) {
            return redirect()->back()->with('error', 'Le solde de cette commande est déjà à zéro. Aucune mise à jour n\'est nécessaire.');
        }

        // Valider les données du formulaire
        $request->validate([
            'montant_paye' => [
                'required',
                'numeric',
                'min:0',
                'max:' . $commande->solde_restant,
            ],
            'payment_method' => 'nullable|string',
            'payment_type' => 'required|string|in:Espèce,Mobile Money',
        ], [
            'montant_paye.required' => 'Le montant de l\'avance est requis.',
            'montant_paye.numeric' => 'Le montant doit être un nombre.',
            'montant_paye.min' => 'Le montant ne peut pas être négatif.',
            'montant_paye.max' => 'Le montant de l\'avance ne peut pas dépasser le solde restant de ' . number_format($commande->solde_restant, 2, ',', ' ') . ' FCFA',
            'payment_type.required' => 'Le moyen de paiement est requis.',
            'payment_type.in' => 'Le moyen de paiement doit être Espèce ou Mobile Money.',
        ]);

        $montantPaye = floatval($request->input('montant_paye'));
        $paymentMethod = $request->input('payment_method') ?? null;
        $paymentType = $request->input('payment_type');

        // Vérifier une dernière fois que le montant ne dépasse pas le solde restant
        if ($montantPaye > $commande->solde_restant) {
            return redirect()->back()->with('error', 'Le montant de l\'avance ne peut pas dépasser le solde restant.');
        }

        // Créer un enregistrement de paiement via le modèle CommandePayment
        CommandePayment::create([
            'commande_id' => $commande->id,
            'user_id' => Auth::id(),
            'amount' => $montantPaye,
            'payment_method' => $paymentMethod,
            'payment_type' => $paymentType,
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
            $dernierNum = (int) substr($dernierNumero->numero, -4);
            $nouveauNum = str_pad($dernierNum + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nouveauNum = '0001';
        }

        // Combiné pour avoir le numéro complet de la commande
        $numeroCommande = $prefixe . $nouveauNum;

        // Passer la variable $numeroCommande et les objets à la vue
        return view('utilisateurs.commandes', compact('objets', 'numeroCommande'));
    }

    public function listeCommandes()
    {
        // Récupérer uniquement les commandes du jour
        $commandes = Commande::with(['objets', 'payments'])
            ->whereDate('date_depot', now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $objets = \App\Models\Objets::all();

        return view('utilisateurs.listeCommandes', [
            'commandes' => $commandes,
            'objets' => $objets
        ]);
    }

    public function show($id)
    {
        $commande = Commande::with(['objets', 'payments', 'images'])->findOrFail($id);

        // Calculer les totaux
        $originalTotal = $commande->original_total ?? $commande->total;
        $discountAmount = $commande->discount_amount ?? 0;
        $remiseReduction = $commande->remise_reduction ?? 0;

        // Récupérer les notes associées à cette commande
        $notes = Note::where('commande_id', $id)->orderBy('created_at', 'desc')->get();

        return view('utilisateurs.commandesDetails', compact('commande', 'originalTotal', 'discountAmount', 'remiseReduction', 'notes'));
    }

    public function edit($id)
    {
        $commande = Commande::with(['objets', 'payments', 'images'])->findOrFail($id);
        $objets = Objets::all();

        // Calculer les totaux
        $originalTotal = $commande->original_total ?? $commande->total;
        $discountAmount = $commande->discount_amount ?? 0;
        $remiseReduction = $commande->remise_reduction ?? 0;

        return view('utilisateurs.editFacture', compact('commande', 'objets', 'originalTotal', 'discountAmount', 'remiseReduction'));
    }

    public function update(Request $request, $id)
    {
        try {
            $commande = Commande::findOrFail($id);

            // Validation des données (sans total, statut, heure_retrait, type_lavage et objets)
            $request->validate([
                'client' => 'required|string',
                'numero_whatsapp' => 'required|string',
                'date_depot' => 'required|date',
                'date_retrait' => 'required|date',
                'avance_client' => 'nullable|numeric|min:0',
                'remise_reduction' => 'nullable|in:0,5,10,15,20,25,30',
            ]);

            // Récupérer les anciennes valeurs pour comparer
            $oldValues = [
                'client' => $commande->client,
                'numero_whatsapp' => $commande->numero_whatsapp,
                'date_depot' => $commande->date_depot,
                'date_retrait' => $commande->date_retrait,
                'avance_client' => $commande->avance_client,
                'remise_reduction' => $commande->remise_reduction,
            ];

            // Nouvelles valeurs (seulement les champs modifiables)
            $newValues = [
                'client' => $request->client,
                'numero_whatsapp' => $request->numero_whatsapp,
                'date_depot' => $request->date_depot,
                'date_retrait' => $request->date_retrait,
                'avance_client' => $request->avance_client ?? 0,
                'remise_reduction' => $request->remise_reduction ?? 0,
            ];

            // Détecter les changements
            $changes = [];
            $descriptions = [];

            foreach ($newValues as $field => $newValue) {
                if ($oldValues[$field] != $newValue) {
                    $changes[$field] = [
                        'old' => $oldValues[$field],
                        'new' => $newValue
                    ];

                    // Créer une description lisible
                    $fieldNames = [
                        'client' => 'Nom du client',
                        'numero_whatsapp' => 'Numéro WhatsApp',
                        'date_depot' => 'Date de dépôt',
                        'date_retrait' => 'Date de retrait',
                        'avance_client' => 'Avance client',
                        'remise_reduction' => 'Remise'
                    ];

                    $descriptions[] = "{$fieldNames[$field]}: {$oldValues[$field]} → {$newValue}";
                }
            }

            // Mettre à jour les informations de base de la commande (seulement les champs modifiables)
            $commande->update($newValues);

            // Recalculer le solde restant
            $soldeRestant = max(0, $commande->total - ($request->avance_client ?? 0));
            $commande->update(['solde_restant' => $soldeRestant]);

            // Créer la notification si il y a des changements
            if (!empty($changes)) {
                Notification::create([
                    'commande_id' => $commande->id,
                    'user_id' => Auth::user()->id,
                    'action' => 'modification',
                    'changes' => json_encode($changes),
                    'description' => "Facture #{$commande->numero} modifiée par " . Auth::user()->name
                ]);
            }

            return redirect()->route('factures')->with('success', 'Facture mise à jour avec succès.');

        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            \Log::error('Erreur lors de la mise à jour de la facture: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    public function history($id)
    {
        $commande = Commande::with(['notifications.user'])->findOrFail($id);
        $notifications = $commande->notifications()->orderBy('created_at', 'desc')->get();

        return view('utilisateurs.factureHistory', compact('commande', 'notifications'));
    }

    public function destroy($id)
    {
        // Vérifier si l'utilisateur est administrateur
        if (!Auth::user()->is_admin) {
            return redirect()->route('factures')->with('error', 'Accès refusé. Seuls les administrateurs peuvent supprimer des factures.');
        }

        $commande = Commande::findOrFail($id);

        // Créer une notification avant la suppression
        Notification::create([
            'commande_id' => $commande->id,
            'user_id' => Auth::user()->id,
            'action' => 'suppression',
            'changes' => json_encode([
                'message' => 'Facture supprimée par l\'utilisateur',
                'facture_numero' => $commande->numero,
                'facture_client' => $commande->client,
                'facture_total' => $commande->total
            ]),
            'description' => "Facture #{$commande->numero} supprimée par " . Auth::user()->name
        ]);

        // Supprimer les relations
        $commande->objets()->detach();
        $commande->payments()->delete();
        $commande->images()->delete();

        // Supprimer la commande
        $commande->delete();

        return redirect()->route('factures')->with('success', 'Facture supprimée avec succès.');
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
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        // Récupérer toutes les commandes dont la date de retrait est comprise entre les dates sélectionnées
        $commandes = Commande::whereBetween('date_retrait', [$validated['start_date'], $validated['end_date']])
            ->orderBy('created_at', 'desc')
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

        // Récupérer le solde restant avant la mise à jour
        $soldeRestant = $commande->solde_restant;

        // Mettre à jour le statut de la commande
        $commande->update([
            'statut' => 'Retiré',
            'solde_restant' => 0, // Mettre à jour le solde restant à 0 car la facture est validée
            'avance_client' => $commande->total // Mettre à jour l'avance client au montant total
        ]);

        // Toujours enregistrer le paiement de validation s'il reste un solde
        if ($soldeRestant > 0) {
            CommandePayment::create([
                'commande_id' => $commande->id,
                'user_id' => Auth::id(),
                'amount' => $soldeRestant,
                'payment_method' => 'Validation',
                'payment_type' => 'Validation',
            ]);
        }

        // Rediriger vers la page précédente avec un message de succès
        return redirect()->back()->with('success', 'La facture a été validée avec succès.');
    }

    public function printListeCommandes(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date') ?? now()->format('Y-m-d');

        // Récupérer toutes les commandes dont la date de retrait est comprise entre les dates sélectionnées
        $commandes = Commande::whereBetween('date_retrait', [$start_date, $end_date])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalMontant = $commandes->sum('total');

        // Récupérer les paiements et les notes sur la période
        $payments = \App\Models\CommandePayment::whereBetween('created_at', [$start_date, $end_date])->get();
        $notes = \App\Models\Note::whereHas('commande', function($q) use ($start_date, $end_date) {
            $q->whereBetween('date_retrait', [$start_date, $end_date]);
        })->get();

        $pdf = Pdf::loadView('utilisateurs.previewListeCommandes', compact('commandes', 'start_date', 'end_date', 'totalMontant', 'payments', 'notes'));

        return $pdf->stream('liste_commandes.pdf');
    }

    public function filtrerPending(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin', today()->toDateString());

        $commandes = Commande::whereBetween('date_retrait', [$date_debut, $date_fin])
            ->whereIn('statut', ['Non retirée', 'non retirée', 'Partiellement payé', 'Payé - Non retiré'])
            ->get();

        $montant_total = $commandes->sum('total');
        $objets = Objets::all();

        return view('utilisateurs.listeCommandesFiltrePending', compact('commandes', 'date_debut', 'date_fin', 'montant_total', 'objets'));
    }

    public function printListeCommandesPending(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        // Récupérer toutes les commandes avec la date de retrait dans la période sélectionnée
        $query = Commande::with('user')
            ->whereBetween('date_retrait', [$date_debut, $date_fin]);

        $commandes = $query->orderBy('created_at', 'desc')->get();

        // Calculer le montant total
        $totalMontant = $commandes->sum('total');

        $pdf = Pdf::loadView('utilisateurs.previewListePending', compact('commandes', 'date_debut', 'date_fin', 'totalMontant'));

        return $pdf->stream('liste_commandes_pending.pdf');
    }

    public function retraitsFiltrer(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin', today()->toDateString());

        // Filtrer uniquement les commandes validées/retirées avec tri par updated_at
        $query = Commande::where(function($q) {
                $q->where('statut', 'Retiré')
                  ->orWhere('statut', 'Validée')
                  ->orWhere('statut', 'validé')
                  ->orWhere('statut', 'retiré')
                  ->orWhere('statut', 'retirée')
                  ->orWhere('statut', 'Validé');
            })
            ->whereBetween('updated_at', [$date_debut . ' 00:00:00', $date_fin . ' 23:59:59'])
            ->orderBy('updated_at', 'desc');

        // Exécuter la requête
        $commandes = $query->get();

        // Calculer le total
        $total = $commandes->sum('total');

        $objets = Objets::all();

        $message = $commandes->isEmpty()
            ? "Aucune commande trouvée pour la période sélectionnée."
            : null;

        return view('utilisateurs.rappelsRecherche', compact('commandes', 'objets', 'message', 'total', 'date_debut', 'date_fin'));
    }

    public function printListeCommandesRetraits(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin', today()->toDateString());

        // Filtrer uniquement les commandes validées/retirées avec tri par updated_at
        $query = Commande::where(function($q) {
                $q->where('statut', 'Retiré')
                  ->orWhere('statut', 'Validée')
                  ->orWhere('statut', 'validé')
                  ->orWhere('statut', 'retiré')
                  ->orWhere('statut', 'retirée')
                  ->orWhere('statut', 'Validé');
            })
            ->whereBetween('updated_at', [$date_debut . ' 00:00:00', $date_fin . ' 23:59:59'])
            ->orderBy('updated_at', 'desc');

        $commandes = $query->get();

        // Générer le PDF
        $pdf = Pdf::loadView('utilisateurs.previewListeRetraits', compact('commandes', 'date_debut', 'date_fin'));

        // Télécharger ou afficher dans le navigateur
        return $pdf->stream('liste_commandes_retraits.pdf'); // Pour afficher directement
        // return $pdf->download('liste_commandes_pending.pdf'); // Pour télécharger
    }

    public function ComptabiliteFiltrer(Request $request)
    {
        // Récupérer la période demandée dans la requête
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin', today()->toDateString());

        // Récupérer les commandes de l'utilisateur filtrées par la période
        $commandes = Commande::whereBetween('date_retrait', [$date_debut, $date_fin])
            ->where('statut', 'retirée')
            ->get();

        // Calculer le montant total des commandes dans la période
        $montant_total = $commandes->sum('total');

        // Récupérer les paiements et les notes de l'utilisateur (triés par ordre décroissant)
        $payments = CommandePayment::whereBetween('created_at', [$date_debut, $date_fin]) // Filtrer les paiements dans la période
            ->orderBy('created_at', 'desc')
            ->get();

        $notes = Note::whereBetween('created_at', [$date_debut, $date_fin]) // Filtrer les notes dans la période
            ->orderBy('created_at', 'desc')
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

        // Trier les mouvements par date (ordre décroissant)
        $mouvements = $mouvements->sortByDesc('date');

        $montant_total_paiements = $payments->sum('amount'); // Calcul du total des montants
        // Récupérer les objets associés à l'utilisateur
        $objets = Objets::all();

        // Passer les données à la vue
        return view('utilisateurs.comptabiliteFiltreRetraits', compact(
            'commandes',
            'payments',
            'notes',
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
        // on récupère la chaîne tapée
        // (si vous gardez name="client", remplacez 'search' par 'client' ici)
        $search = $request->input('client');

        // on commence la requête : commandes de TOUS les utilisateurs
        $commandes = Commande::when($search, function ($query, $search) {
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
        $search = $request->input('client');

        // Requête de base pour les commandes de TOUS les utilisateurs avec statut "Retiré" ou "retirée"
        $query = Commande::where(function($q) {
                $q->where('statut', 'Retiré')
                  ->orWhere('statut', 'Validée')
                  ->orWhere('statut', 'validé')
                  ->orWhere('statut', 'retiré')
                  ->orWhere('statut', 'retirée')
                  ->orWhere('statut', 'Validé');
            });

        // Si une recherche est effectuée, ajouter les conditions de recherche
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('client', 'like', "%{$search}%")
                    ->orWhere('numero_whatsapp', 'like', "%{$search}%")
                    ->orWhere('numero', 'like', "%{$search}%");
            });
        }

        // Exécuter la requête
        $commandes = $query->orderBy('updated_at', 'desc')->get();

        // Calculer le total
        $total = $commandes->sum('total');

        $objets = Objets::all();

        $message = $commandes->isEmpty()
            ? "Aucun résultat pour « {$search} »."
            : null;

        return view('utilisateurs.rappelsRecherche', compact('commandes', 'objets', 'message', 'search', 'total'));
    }

    public function storeNote(Request $request, Commande $commande)
    {
        $request->validate([
            'note' => 'required|string|max:500',
        ]);

        $note = new Note();
        $note->commande_id = $commande->id;
        $note->user_id = Auth::id();
        $note->note = $request->note;
        $note->save();

        return redirect()->back()->with('success', 'Note ajoutée avec succès !');
    }

    public function storeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'commande_id' => 'required|exists:commandes,id'
        ]);

        $image = $request->file('image');
        $path = $image->store('public/commande-images');

        $commandeImage = new CommandeImage();
        $commandeImage->commande_id = $request->commande_id;
        $commandeImage->image_path = str_replace('public/', '', $path);
        $commandeImage->original_name = $image->getClientOriginalName();
        $commandeImage->save();

        return response()->json(['success' => true]);
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $image = CommandeImage::findOrFail($id);

        // Supprimer l'ancienne image
        if ($image->image_path) {
            Storage::delete('public/' . $image->image_path);
        }

        // Sauvegarder la nouvelle image
        $newImage = $request->file('image');
        $path = $newImage->store('public/commande-images');

        $image->image_path = str_replace('public/', '', $path);
        $image->original_name = $newImage->getClientOriginalName();
        $image->save();

        return response()->json(['success' => true]);
    }

    public function deleteImage($id)
    {
        $image = CommandeImage::findOrFail($id);

        // Supprimer le fichier
        if ($image->image_path) {
            Storage::delete('public/' . $image->image_path);
        }

        // Supprimer l'enregistrement
        $image->delete();

        return response()->json(['success' => true]);
    }

    }
