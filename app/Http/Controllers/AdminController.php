<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Objets;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CommandePayment;
use App\Models\FactureMessage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    // Concernant les objets


    // Afficher le formulaire d'édition d'un objet
    public function editObjets($id)
    {
        $objet = Objets::findOrFail($id); // Récupérer l'objet par son ID
        return view('administrateur.modifierObjets', compact('objet'));
    }

    // Mettre à jour un objet
    public function updateObjets(Request $request, $id)
    {
        $objet = Objets::findOrFail($id); // Récupérer l'objet par son ID

        // Valider les données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric',
        ]);

        // Mettre à jour l'objet
        $objet->update($validatedData);

        // Rediriger avec un message de succès
        return redirect()->route('objets.show')->with('success', 'Objet mis à jour avec succès.');
    }

    // Supprimer un objet
    public function destroyObjets($id)
    {
        $objet = Objets::findOrFail($id); // Récupérer l'objet par son ID
        $objet->delete(); // Supprimer l'objet

        // Rediriger avec un message de succès
        return redirect()->route('objets.show')->with('success', 'Objet supprimé avec succès.');
    }



    //________________________Fin de la gestion des objets _______________________________________







    public function index()
    {
        $users = User::all(); // Récupérer tous les utilisateurs
        return view('administrateur.utilisateurs', compact('users')); // Passer les utilisateurs à la vue
    }

    public function create()
    {
        return view('administrateur.create');  // Afficher la vue avec le formulaire
    }

    public function profilAdmin()
    {
        return view('administrateur.profileAdmin');  // Afficher la vue avec le formulaire
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);  // Trouver l'utilisateur par son ID
        $user->delete();  // Supprimer l'utilisateur

        // Rediriger vers la liste des utilisateurs avec un message de succès
        return redirect()->route('objets.show')->with('success', 'Utilisateur supprimé avec succès');
    }

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Assurez-vous que le mot de passe est confirmé
        ]);

        // Créer un nouvel utilisateur
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->save();  // Sauvegarder dans la base de données

        // Rediriger avec un message de succès
        return redirect()->route('utilisateursAdmin')->with('success', 'Utilisateur créé avec succès.');
    }


















    // Tout ce qui se trouve dans le controller ViewController


    public function acceuil()
    {
        $user = Auth::user();

        // Récupérer uniquement les commandes de l'administrateur connecté
        $commandesEnCours = Commande::where('user_id', $user->id)
            ->whereIn('statut', ['Non retirée', 'Non retiré', 'Partiellement payé', 'Payé - Non retiré'])
            ->count();

        $commandesDuJour = Commande::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $commandesARetirer = Commande::where('user_id', $user->id)
            ->where('statut', 'Non retirée')
            ->count();

        $chiffreAffaires = Commande::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        $dernieresCommandes = Commande::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Récupérer le message de facture actif
        $factureMessage = FactureMessage::getActiveMessage();
        $factureMessage = $factureMessage ? $factureMessage->message : null;

        return view('administrateur.dashboard', compact(
            'commandesEnCours',
            'commandesDuJour',
            'commandesARetirer',
            'chiffreAffaires',
            'dernieresCommandes',
            'factureMessage'
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
        return view('administrateur.dashboard', compact(
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
        $prefixe = "ETS-NKPA-" . $annee . "-";

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
        return view('administrateur.commandes', compact('objets'));
    }




    // il faut trier par utilisateur

    public function detailsRetraitAdmin($id)
    {
        // Récupère le retrait avec ses relations
        // $retrait = Retrait::with(['commande.objets', 'user'])->findOrFail($id);

        // Retourne la vue avec le retrait
        return view('administrateur.detailsRetraits', );
    }




    // il faut trier par utilisateur

    public function enAttente()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Définir la date d'aujourd'hui au format 'YYYY-MM-DD'
        $today = Carbon::today()->toDateString();

        // Récupérer toutes les commandes de l'utilisateur dont la date de retrait est aujourd'hui
        $commandes = Commande::where('user_id', $user->id)
            ->whereDate('date_retrait', $today)
            ->get();

        // Passer les commandes à la vue 'administrateur.pending'
        return view('administrateur.enAttente', compact('commandes'));
    }



    // il faut trier par utilisateur

    public function comptabilite()
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = Auth::id();

        // Définir la date d'aujourd'hui
        $today = Carbon::today()->toDateString();

        // Récupérer les commandes de l'utilisateur connecté pour aujourd'hui
        $commandes = Commande::where('user_id', $userId)
            ->whereDate('date_depot', $today)
            ->get();

        // Calculer le montant total des commandes
        $total = $commandes->sum('total');

        // Récupérer les paiements associés à cet utilisateur pour aujourd'hui
        $payments = CommandePayment::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->get();

        // Calculer le montant total des paiements
        $montant_total_paiements = $payments->sum('amount');

        // Récupérer les notes associées à cet utilisateur pour aujourd'hui
        $notes = Note::where('user_id', $userId)
            ->whereDate('created_at', $today)
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

        // Retourner la vue avec les données, même si aucune commande n'est trouvée
        return view('administrateur.comptabilite', compact(
            'commandes',
            'payments',
            'notes',
            'userId',
            'total',
            'montant_total_paiements',
            'mouvements'
        ));
    }




    // il faut trier par utilisateur

    public function rappelsAdmin($commandeId = null)
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = Auth::id();

        if ($commandeId) {
            // Récupérer la commande validée pour l'utilisateur connecté
            $commandes = Commande::where('id', $commandeId)
                ->where('statut', 'validée')
                ->where('user_id', $userId)
                ->with('objets') // Charger la relation objets
                ->get();

            // Récupérer les notes associées à cette commande
            $notes = Note::where('commande_id', $commandeId)
                ->with('user') // Récupérer l'utilisateur associé à la note
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Récupérer toutes les commandes validées pour l'utilisateur connecté
            $commandes = Commande::where('statut', 'validée')
                ->where('user_id', $userId)
                ->get();

            // Récupérer toutes les notes de l'utilisateur connecté
            $notes = Note::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Retourner la vue avec les données
        return view('administrateur.retraits', compact('commandes', 'notes'));
    }




    // il faut trier par utilisateur

    public function pageRetrait()
    {
        $user = Auth::user(); // Récupérer l'utilisateur connecté

        // Récupérer uniquement les commandes du client connecté
        $commandes = Commande::where('client_id', $user->id)->get();

        return view('administrateur.faireRetrait', compact('commandes'));
    }


























    // ---------------------------------- Tout ce qui se trouve dans le controller Facture -----------------------------------------------------------------------//

    public function print($id)
    {
        // Récupérer la commande avec ses objets associés
        $commande = Commande::with('objets')->findOrFail($id);
        $notes = Note::where('commande_id', $commande->id)->with('user')->get();

        // Calculer le total sans réduction
        $originalTotal = $commande->objets->sum(function($objet) {
            return $objet->pivot->quantite * $objet->prix_unitaire;
        });

        // Récupérer le pourcentage de réduction
        $remiseReduction = $commande->remise_reduction ?? 0;

        // Calculer le montant de la réduction
        $discountAmount = ($originalTotal * $remiseReduction) / 100;

        // Générer le PDF avec les options spécifiques
        $pdf = PDF::loadView('administrateur.preview', compact('commande', 'originalTotal', 'remiseReduction', 'discountAmount', 'notes'));

        // Configurer les options du PDF
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

        // Retourner le PDF pour affichage inline
        return $pdf->stream('facture_' . $commande->numero . '.pdf');
    }

    protected function generatePdf($id)
    {
        $commande = Commande::with('objets')->findOrFail($id);

        $originalTotal = $commande->objets->sum(function ($objet) {
            return $objet->pivot->quantite * $objet->prix_unitaire;
        });

        $remiseReduction = $commande->remise_reduction ?? 0;
        $discountAmount = ($originalTotal * $remiseReduction) / 100;

        // Générer le PDF en utilisant la vue 'administrateur.factures'
        return Pdf::loadView('administrateur.factures', compact('commande', 'originalTotal', 'remiseReduction', 'discountAmount'));
    }

    public function stream($id)
    {
        $pdf = $this->generatePdf($id);
        return $pdf->stream('facture_' . $id . '.pdf');
    }

    public function download($id)
    {
        $pdf = $this->generatePdf($id);
        return $pdf->stream('facture_' . $id . '.pdf');
    }

    // La méthode print initiale peut rediriger vers la page de prévisualisation
    // public function print($id)
    // {
    //     // Afficher la vue de prévisualisation qui contient l'iframe
    //     $commande = Commande::findOrFail($id);
    //     return view('factures.preview', compact('commande'));
    // }



    // il faut trier par utilisateur

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
            'numero' => $commande->numero,
            'client' => $commande->client,
            'numero_whatsapp' => $commande->numero_whatsapp,
            'date_depot' => $commande->date_depot,
            'date_retrait' => $commande->date_retrait,
            'total' => $commande->total,
            // Vous pouvez ajouter d'autres informations si nécessaire
        ];

        // Enregistrer la note dans la table 'notes'
        $note = Note::create([
            'commande_id' => $commande->id,
            'user_id' => $user->id,
            'note' => $request->input('note'),
            'commande_details' => $commandeDetails, // Grâce au cast, l'array sera converti en JSON
        ]);

        return redirect()->route('commandes.show', $commande->id)->with('note', $note);
    }



    // ---------------------------------- Fin de tout ce qui se trouve dans le controller Facture -----------------------------------------------------------------------//























    // ---------------------------------- Tout ce qui se trouve dans le controller Commande Controller -----------------------------------------------------------------------//


    public function commandesAdmin()
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
        return view('administrateur.commandes', compact('objets', 'numeroCommande'));
    }


    // public function commandesAdmin()
    // {

    //     return view('administrateur.commandes');

    // }


    public function storeCommandeAdmin(Request $request)
    {
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

        // Générer automatiquement le numéro de facture
        $numeroCommande = 'FC-' . str_pad(Commande::count() + 1, 5, '0', STR_PAD_LEFT);

        // Création de la commande
        $commande = Commande::create([
            'user_id' => Auth::user()->id,
            'numero' => $numeroCommande,
            'client' => $request->client,
            'numero_whatsapp' => $request->numero_whatsapp,
            'date_depot' => \Carbon\Carbon::now()->toDateString(),
            'date_retrait' => $request->date_retrait,
            'heure_retrait' => $request->heure_retrait,
            'type_lavage' => $request->type_lavage,
            'avance_client' => $request->avance_client ?? 0,
            'remise_reduction' => $request->remise_reduction ?? 0,
        ]);

        // Calculer le total initial (sans réduction)
        $totalCommande = 0;
        foreach ($request->objets as $objetData) {
            $objet = Objets::find($objetData['id']);
            $quantite = $objetData['quantite'];
            $totalCommande += $objet->prix_unitaire * $quantite;
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
                'payment_type' => 'Espèce',
            ]);

            // Mettre à jour le statut de la commande selon les nouvelles règles
            if ($soldeRestant == 0) {
                $commande->update(['statut' => 'Payé - Non retiré']);
            } elseif ($avanceClient > 0) {
                $commande->update(['statut' => 'Partiellement payé']);
            }
        }

        // Redirection vers la page de détail de la commande en passant les données de réduction
        return redirect()->route('commandesAdmin.show', $commande->id)
            ->with('success', 'Commande validée avec succès!')
            ->with([
                'originalTotal' => $originalTotal,
                'discountAmount' => $discountAmount,
                'remiseReduction' => $remiseReduction,
            ]);
    }


    public function updateFinancial(Request $request, Commande $commande)
    {
        // Vérifier que l'utilisateur connecté est bien celui qui a créé la commande
        if (Auth::id() !== $commande->user_id) {
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

        // Rafraîchir l'instance de commande et recharger la relation payments pour obtenir les paiements actualisés
        $commande->refresh();
        $commande->load('payments');

        // Calculer le cumul des avances versées
        $totalAvance = $commande->payments->sum('amount');

        // Mettre à jour l'avance client et recalculer le solde restant (total de la commande - cumul des avances)
        $commande->avance_client = $totalAvance;
        $commande->solde_restant = max(0, $commande->total - $totalAvance);

        // Mettre à jour le statut de la commande : "Payé" si le solde restant est 0, sinon "Partiellement payé"
        $commande->statut = ($commande->solde_restant == 0) ? 'Payé' : 'Partiellement payé';

        // Sauvegarder les modifications dans la base de données
        $commande->save();

        // Retourner un message indiquant le résultat du paiement
        if ($commande->solde_restant > 0) {
            return redirect()->back()->with('success', 'Le paiement a été mis à jour. Il manque '
                . number_format($commande->solde_restant, 2) . ' FCFA pour solder la commande.');
        } else {
            return redirect()->back()->with('success', 'La commande est entièrement payée.');
        }
    }









    // il faut trier par utilisateur

    public function listeCommandes()
    {
        $user = Auth::user(); // Récupérer l'utilisateur connecté
        $today = Carbon::today()->toDateString(); // Date d'aujourd'hui au format YYYY-MM-DD

        $commandes = Commande::where('user_id', $user->id)
            ->whereDate('date_depot', $today) // Filtrer uniquement les commandes d'aujourd'hui
            ->orderBy('created_at', 'desc')
            ->get();

        $objets = Objets::all();

        return view('administrateur.listeCommandes', compact('commandes', 'objets'));
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

        return view('administrateur.commandesDetails', compact(
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
        ]);

        // Recharger la commande avec ses objets et retraits
        $commande->load('objets', 'retraits');

        // Recalculer le coût total de la commande
        $totalCommande = $commande->objecsts->sum(function ($objet) {
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

        return redirect()->route('commandesAdmin.show', $commande->id)
            ->with('success', 'Montant additionnel enregistré. Le solde a été mis à jour.');
    }


    // Méthode pour afficher les commandes journalières
    public function journalieres(Request $request)
    {
        $user = Auth::user(); // Récupérer l'utilisateur connecté

        // Récupérer les dates de début et de fin de la requête, ou utiliser aujourd'hui par défaut
        $start_date = $request->input('start_date', Carbon::today()->toDateString());
        $end_date = $request->input('end_date', Carbon::today()->toDateString());

        // Valider les dates
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $commandes = Commande::where('user_id', $user->id) // Filtrer par utilisateur
            ->whereBetween('date_depot', [$start_date, $end_date]) // Filtrer par période
            ->orderBy('date_depot')
            ->get();

        return view('administrateur.commandesJournalieres', [
            'commandes' => $commandes,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    public function valider($id)
    {
        // Récupérer la commande
        $commande = Commande::findOrFail($id);

        // Mettre à jour le statut de la commande
        $commande->update([
            'statut' => 'Validée', // Vous pouvez changer cette valeur selon vos besoins
        ]);

        // Rediriger vers la page précédente avec un message de succès
        return redirect()->back()->with('success', 'La facture a été validée avec succès.');
    }



    // Assurez-vous que la méthode printListeCommandes récupère bien les dates
    // public function printListeCommandes(Request $request)
    // {
    //     $start_date = $request->input('start_date');
    //     $end_date = $request->input('end_date') ?? now()->format('Y-m-d');

    //     $commandes = Commande::whereBetween('date_retrait', [$start_date, $end_date])
    //         ->orderBy('date_retrait')
    //         ->get();

    //     return view('administrateur.previewListeCommandes', compact('commandes', 'start_date', 'end_date'));
    // }



    // il faut trier par utilisateur

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

        // Générer le PDF
        $pdf = Pdf::loadView('administrateur.previewListeCommandes', compact('commandes', 'start_date', 'end_date', 'totalMontant'));

        // Télécharger ou afficher dans le navigateur
        return $pdf->stream('liste_commandes.pdf'); // Pour télécharger
        // return $pdf->stream('liste_commandes.pdf'); // Pour afficher directement
    }


    // il faut trier par utilisateur

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

        // Générer le PDF
        $pdf = Pdf::loadView('administrateur.previewListePending', compact('commandes', 'date_debut', 'date_fin'));

        // Télécharger ou afficher dans le navigateur
        return $pdf->stream('liste_commandes_pending.pdf'); // Pour afficher directement
        // return $pdf->download('liste_commandes_pending.pdf'); // Pour télécharger
    }









    // il faut trier par utilisateur

    public function filtrerPending(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin', today()->toDateString());

        $user = Auth::user(); // Récupérer l'utilisateur connecté

        $commandes = Commande::where('user_id', $user->id) // Filtrer par utilisateur
            ->whereBetween('date_retrait', [$date_debut, $date_fin])
            ->get();

        $montant_total = $commandes->sum('total');
        $objets = Objets::all();

        return view('administrateur.listeCommandesFiltrePending', compact('commandes', 'date_debut', 'date_fin', 'montant_total', 'objets'));
    }

    public function retraitsFiltrer(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin', today()->toDateString());

        $user = Auth::user(); // Récupérer l'utilisateur connecté

        $commandes = Commande::where('user_id', $user->id) // Filtrer par utilisateur
            ->whereBetween('date_retrait', [$date_debut, $date_fin])
            ->where('statut', 'retirée')
            ->get();

        $montant_total = $commandes->sum('total');
        $objets = Objets::all();

        return view('administrateur.listeCommandesFiltreRetraits', compact('commandes', 'date_debut', 'date_fin', 'montant_total', 'objets'));
    }

    public function printListeCommandesRetraits(Request $request)
    {
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin') ?? now()->format('Y-m-d');

        $user = Auth::user(); // Récupérer l'utilisateur connecté

        $commandes = Commande::where('user_id', $user->id) // Filtrer par utilisateur
            ->whereBetween('date_retrait', [$date_debut, $date_fin])
            ->where('statut', 'non retirée')
            ->orderBy('date_retrait')
            ->get();

        $pdf = Pdf::loadView('administrateur.previewListeRetraits', compact('commandes', 'date_debut', 'date_fin'));

        return $pdf->stream('liste_commandes_retraits.pdf');
    }

    public function ComptabiliteFiltrer(Request $request)
    {
        $userId = Auth::id();

        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin', today()->toDateString());

        $commandes = Commande::where('user_id', $userId)
            ->whereBetween('date_retrait', [$date_debut, $date_fin])
            ->where('statut', 'retirée')
            ->get();

        $montant_total = $commandes->sum('total');

        $payments = CommandePayment::where('user_id', $userId)
            ->whereBetween('created_at', [$date_debut, $date_fin])
            ->get();

        $notes = Note::where('user_id', $userId)
            ->whereBetween('created_at', [$date_debut, $date_fin])
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

        $montant_total_paiements = $payments->sum('amount');
        $objets = Objets::all();

        return view('administrateur.comptabiliteFiltreRetraits', compact(
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


    // ---------------------------------- Fin de tout ce qui se trouve dans le controller Commande Controller -----------------------------------------------------------------------//



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

        return view('administrateur.listeCommandes', compact('commandes', 'objets', 'message', 'search'));
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

        return view('administrateur.rappelsRecherche', compact('commandes', 'objets', 'message', 'search'));
    }

    public function destroyCommande($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();

        return redirect()->back()->with('success', 'Commande supprimée avec succès.');
    }

    /**
     * Gérer le message de facture
     */
    public function storeFactureMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Désactiver tous les messages existants
        FactureMessage::where('is_active', true)->update(['is_active' => false]);

        // Créer le nouveau message
        FactureMessage::create([
            'message' => $request->message,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Message de facture enregistré avec succès.');
    }

    /**
     * Supprimer le message de facture
     */
    public function deleteFactureMessage()
    {
        FactureMessage::where('is_active', true)->update(['is_active' => false]);

        return redirect()->back()->with('success', 'Message de facture supprimé avec succès.');
    }

}
