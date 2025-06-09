<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\ObjectController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommandeImageController;

Route::get('/', function () {
    return view('welcome');
});





















// -------------------------------------------------------------- Début de la route concernant l'adminitrateur -----------------------------------------//

Route::middleware('auth')->group(function () {


    // Admin routes
    route::get('/commandes_administration', [AdminController::class, 'commandesAdmin'])->name('commandesAdmin');
    route::get('/rappels_administration', [AdminController::class, 'rappelsAdmin'])->name('rappelsAdmin');
    Route::get('/utilisateurs_administration', [AdminController::class, 'index'])->name('utilisateursAdmin');
    Route::get('/profil_administrateur', [AdminController::class, 'profil'])->name('profilAdmin');
    Route::get('/en_attente_administration', [AdminController::class, 'enAttente'])->name('pendingAdmin');
    Route::get('/comptabilite_administration', [AdminController::class, 'comptabilite'])->name('comptabiliteAdmin');

    Route::get('/liste_des_commandes_administration', [AdminController::class, 'listeCommandes'])->name('listeCommandesAdmin');
    Route::get('/commandes/{id}_administration', [AdminController::class, 'show'])->name('commandesAdmin.show');
    Route::post('/commande/{commande}/objet/{objet}/retirer_administration', [AdminController::class, 'retirerObjet'])->name('commande.retirer');
    Route::post('/commandes/{commande}/retirer-plusieurs_administration', [AdminController::class, 'retirerPlusieursObjets'])->name('commandeAdmin.retirerPlusieurs');
    Route::get('/journalieres_administration', [AdminController::class, 'journalieres'])->name('commandesAdmin.journalieres');
    Route::get('/factures/{commande}/imprimer_administration', [AdminController::class, 'print'])->name('facturesAdmin.print');
    Route::put('/commande/{id}/update-financial_administration', [AdminController::class, 'updateFinancial'])->name('commandeAdmin.updateFinancial');


    // Route::get('/vue/objets', [CommandeController::class, 'index'])->name('objets.index');
    Route::get('/vue/objets/{id}/edit', [AdminController::class, 'editObjets'])->name('objets.edit');
    Route::put('/vue/objets/{id}', [AdminController::class, 'updateObjets'])->name('objets.update');
    Route::delete('/vue/objets/{id}', [AdminController::class, 'destroyObjets'])->name('objets.destroy');


    // Route::get('/agence/modifier', [AgenceController::class, 'edit'])->name('modifierAgence');
// Route::get('/agence/modifier', [AgenceController::class, 'edit'])->name('modifierAgence');
    Route::get('/modification_agence_administration', [AdminController::class, 'modificationAgence'])->name('pageModificationAgence');
    Route::get('/modification_profil_administration', [ProfileController::class, 'edit'])->name('pageModificationProfil');
    Route::get('/journalieres_administration', [AdminController::class, 'journalieres'])->name('commandesAdmin.journalieres');
    Route::get('/factures/{commande}/imprimer_administration', [FactureController::class, 'print'])->name('facturesAdmin.print');
    Route::get('/impression_liste_commandes_administration', [AdminController::class, 'printListeCommandes'])->name('listeCommandesAdmin.print');
    Route::get('/impression_liste_commandes_en_attente_administration', [AdminController::class, 'printListeCommandesPending'])->name('listeCommandesPendingAdmin.print');
    Route::get('/impression_liste_commandes_retiree_administration', [AdminController::class, 'printListeCommandesRetraits'])->name('listeCommandesRetraitsAdmin.print');
    Route::get('/impression_liste_commandes_comptabilite_administration', [AdminController::class, 'printListeCommandesComptabilite'])->name('listeCommandesComptabiliteAdmin.print');
    Route::put('/commande/{commande}/update-financial_admin', [AdminController::class, 'updateFinancial'])->name('commandeAdmin.updateFinancial');







    // ----------------------------------------Les routes qui font les memes choses que les utilisateurs ------------------------------------------------------//



    // Users routes

    // Liste des commandes en attente

    Route::get('/commandes_en_attente/filtrer_administration', [AdminController::class, 'filtrerPending'])->name('commandesAdmin.filtrerPending');
    Route::get('/retrait/commandes/filtrer_administration', [AdminController::class, 'RetraitsFiltrer'])->name('commandesAdmin.filtrerRetrait');
    Route::get('/Comptabilite/commandes/filtrer_administration', [AdminController::class, 'ComptabiliteFiltrer'])->name('commandesAdmin.filtrerComptabilite');
    Route::get('/commandes/retrait_administration', [AdminController::class, 'retraitPending'])->name('commandesAdmin.retraitPending');


    Route::post('/retirer_administration', [AdminController::class, 'submit'])->name('retirersAdmin.submit');
    Route::post('/facture/{commande}/notes_administration', [AdminController::class, 'storeNote'])->name('notesAdmin.store');

    // Afficher le PDF en mode streaming (prévisualisation)
    Route::get('/factures/{id}/stream_administration', [AdminController::class, 'stream'])->name('facturesAdmin.stream');

    // Télécharger le PDF
    Route::get('/factures/{id}/download_administration', [AdminController::class, 'download'])->name('facturesAdmin.download');


    Route::put('/commandes/{id}/valider_administration', [AdminController::class, 'valider'])->name('commandesAdmin.valider');


    Route::get('/liste_des_commandes_administration', [AdminController::class, 'listeCommandes'])->name('listeCommandesAdmin');
    // Route::get('/commandes/{id}_administration', [AdminController::class, 'show'])->name('commandesAdmin.show');
    Route::post('/commande/{commande}/objet/{objet}/retirer_administration', [AdminController::class, 'retirerObjet'])->name('commandeAdmin.retirer');
    Route::post('/commandes/{commande}/retirer-plusieurs_administration', [AdminController::class, 'retirerPlusieursObjets'])->name('commandeAdmin.retirerPlusieurs');


    Route::get('/journalieres_administration', [AdminController::class, 'journalieres'])->name('commandesAdmin.journalieres');
    Route::get('/factures/{commande}/imprimer_administration', [AdminController::class, 'print'])->name('facturesAdmin.print');
    // Route::put('/commande/{commande}/update-financial_administration', [AdminController::class, 'updateFinancialAdmin'])->name('commandeAdmin.updateFinancial');

    Route::post('store', [AdminController::class, 'storeCommandeAdmin'])->name('commandesAdmin.store');


    Route::prefix('commandes')->group(function () {
        // Route pour afficher le formulaire de création de commande
        Route::get('create', [AdminController::class, 'create'])->name('commandesAdmin.create');

        // Route pour stocker la commande
        Route::post('store', [AdminController::class, 'store'])->name('commandesAdmin.store');

        // Route pour afficher la liste des commandes (si nécessaire)
        Route::get('index', [AdminController::class, 'index'])->name('commandesAdmin.index');
    });





});





// -------------------------------------------------------------- Fin de la route concernant l'adminitrateur -----------------------------------------//








































// -------------------------------------------------------------- Début de la route concernant les utilisateurs -----------------------------------------//

Route::middleware('auth')->group(function () {

    // Users routes
    Route::get('/dashboard', [ViewsController::class, 'dashboard'])->name('dashboard');
    Route::get('/commandes/recherche', [CommandeController::class, 'recherche'])->name('commandes.recherche');
    Route::get('/commandes/recherche_administration', [AdminController::class, 'recherche'])->name('commandesAdmin.recherche');
    Route::get('/commandes_retirees/recherche', [CommandeController::class, 'rechercheRetrait'])->name('commandesRetrait.recherche');
    Route::get('/commandes_retirees/recherche_administration', [AdminController::class, 'rechercheRetrait'])->name('commandesRetraitAdmin.recherche');


    route::get('/commandes', [ViewsController::class, 'commandes'])->name('commandes');
    route::get('/rappels', [ViewsController::class, 'rappels'])->name('rappels');
    Route::get('/details_retraits/{id}', [ViewsController::class, 'detailsRetrait'])->name('retrait.details');
    route::get('/créations', [ViewsController::class, 'creations'])->name('creationObjets');
    route::get('/profil', [ViewsController::class, 'profil'])->name('profil');
    route::get('/statistiques', [ViewsController::class, 'statistiques'])->name('statistiques');
    route::get('/historiques', [ViewsController::class, 'historiques'])->name('historiques');
    route::get('/acceuil', [ViewsController::class, 'acceuil'])->name('acceuil');
    Route::get('/objets/create', [ObjectController::class, 'create'])->name('objets.create');
    Route::get('/objets/liste', [ObjectController::class, 'objetsList'])->name('objets.show');
    Route::post('/objets', [ObjectController::class, 'store'])->name('objets.store');
    Route::get('/en_attente', [ViewsController::class, 'enAttente'])->name('pending');
    Route::get('/comptabilite', [ViewsController::class, 'comptabilite'])->name('comptabilite');
    Route::get('/retrait/{commande}', [ViewsController::class, 'pageRetrait'])->name('faireRetrait');

    // Liste des commandes en attente

    Route::get('/commandes_en_attente/filtrer', [CommandeController::class, 'filtrerPending'])->name('commandes.filtrerPending');
    Route::get('/retrait/commandes/filtrer', [CommandeController::class, 'RetraitsFiltrer'])->name('commandes.filtrerRetrait');
    Route::get('/retrait/commandes/filtrer_administration', [AdminController::class, 'RetraitsFiltrer'])->name('commandesAdmin.filtrerRetrait');
    Route::get('/Comptabilite/commandes/filtrer', [CommandeController::class, 'ComptabiliteFiltrer'])->name('commandes.filtrerComptabilite');
    Route::get('/commandes/retrait', [CommandeController::class, 'retraitPending'])->name('commandes.retraitPending');
    Route::get('/impression_liste_commandes_retiree', [AdminController::class, 'printListeCommandesRetraits'])->name('listeCommandesRetraits.print');
    Route::get('/impression_liste_commandes_en_attente', [CommandeController::class, 'printListeCommandesPending'])->name('listeCommandesPending.print');
    Route::get('/impression_liste_commandes', [CommandeController::class, 'printListeCommandes'])->name('listeCommandes.print');





    Route::post('/retirer', [FactureController::class, 'submit'])->name('retirers.submit');
    Route::post('/commandes/{commande}/notes', [CommandeController::class, 'storeNote'])->name('notes.store');

    // Afficher le PDF en mode streaming (prévisualisation)
    Route::get('/factures/{id}/stream', [FactureController::class, 'stream'])->name('factures.stream');

    // Télécharger le PDF
    Route::get('/factures/{id}/download', [FactureController::class, 'download'])->name('factures.download');


    Route::put('/commandes/{id}/valider', [CommandeController::class, 'valider'])->name('commandes.valider');


    Route::get('/liste_des_commandes', [CommandeController::class, 'listeCommandes'])->name('listeCommandes');
    Route::get('/commandes/{id}', [CommandeController::class, 'show'])->name('commandes.show');
    Route::delete('/commandes/{id}/delete', [AdminController::class, 'destroyCommande'])->name('commandesAdmin.destroy');
    Route::post('/commande/{commande}/objet/{objet}/retirer', [CommandeController::class, 'retirerObjet'])->name('commande.retirer');
    Route::post('/commandes/{commande}/retirer-plusieurs', [CommandeController::class, 'retirerPlusieursObjets'])->name('commande.retirerPlusieurs');


    // Route::get('/agence/modifier', [AgenceController::class, 'edit'])->name('modifierAgence');
// Route::get('/agence/modifier', [AgenceController::class, 'edit'])->name('modifierAgence');
    Route::get('/modification_agence', [AgenceController::class, 'modificationAgence'])->name('pageModificationAgence');
    Route::get('/modification_profil', [ProfileController::class, 'edit'])->name('pageModificationProfil');
    Route::get('/journalieres', [CommandeController::class, 'journalieres'])->name('commandes.journalieres');
    Route::get('/factures/{commande}/imprimer', [FactureController::class, 'print'])->name('factures.print');
    Route::put('/commande/{commande}/update-financial', [CommandeController::class, 'updateFinancial'])->name('commande.updateFinancial');


    // Route::middleware(['auth'])->group(function () {
// Afficher la liste des utilisateurs
// Route::get('/utilisateurs', [AdminController::class, 'index'])->name('users.index');

    // Ajouter un utilisateur
    Route::get('/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'store'])->name('admin.users.store');


    // Supprimer un utilisateur
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});





// -------------------------------------------------------------- Fin de la route concernant les utilisateurs -----------------------------------------//


















Route::prefix('commandes')->group(function () {
    // Route pour afficher le formulaire de création de commande
    Route::get('create', [CommandeController::class, 'create'])->name('commandes.create');

    // Route pour stocker la commande
    Route::post('store', [CommandeController::class, 'store'])->name('commandes.store');

    // Route pour afficher la liste des commandes (si nécessaire)
    Route::get('index', [CommandeController::class, 'index'])->name('commandes.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/commandes/{commande}/images', [CommandeImageController::class, 'store'])->name('commande.images.store');
Route::delete('/commande-images/{image}', [CommandeImageController::class, 'destroy'])->name('commande.images.destroy');
Route::post('/commande-images/{image}', [CommandeImageController::class, 'update'])->name('commande.images.update');

// Routes pour la gestion des images
Route::post('/commandes/images', [CommandeController::class, 'storeImage'])->name('images.store');
Route::post('/commandes/images/{id}', [CommandeController::class, 'updateImage'])->name('images.update');
Route::delete('/commandes/images/{id}', [CommandeController::class, 'deleteImage'])->name('images.delete');

require __DIR__ . '/auth.php';
