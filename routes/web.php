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
    // Routes administratives
    Route::get('/administration', [AdminController::class, 'acceuil'])->name('administration');
    Route::get('/commandes_administration', [AdminController::class, 'commandesAdmin'])->name('commandesAdmin');
    Route::get('/rappels_administration', [AdminController::class, 'rappelsAdmin'])->name('rappelsAdmin');
    Route::get('/utilisateurs_administration', [AdminController::class, 'index'])->name('utilisateursAdmin');
    Route::get('/profil_administrateur', [AdminController::class, 'profil'])->name('profilAdmin');
    Route::get('/en_attente_administration', [AdminController::class, 'enAttente'])->name('pendingAdmin');
    Route::get('/comptabilite_administration', [AdminController::class, 'comptabilite'])->name('comptabiliteAdmin');
    Route::get('/créations', [ViewsController::class, 'creations'])->name('creationObjets');
    Route::get('/objets/create', [ObjectController::class, 'create'])->name('objets.create');
    Route::get('/objets/liste', [ObjectController::class, 'objetsList'])->name('objets.show');
    Route::post('/objets', [ObjectController::class, 'store'])->name('objets.store');
    Route::get('/vue/objets/{id}/edit', [AdminController::class, 'editObjets'])->name('objets.edit');
    Route::put('/vue/objets/{id}', [AdminController::class, 'updateObjets'])->name('objets.update');
    Route::delete('/vue/objets/{id}', [AdminController::class, 'destroyObjets'])->name('objets.destroy');

    // Routes de gestion des commandes admin
    Route::prefix('commandes')->group(function () {
        // Routes spécifiques (sans paramètres) en premier
        Route::get('recherche_administration', [AdminController::class, 'recherche'])->name('commandesAdmin.recherche');
        Route::get('create', [AdminController::class, 'create'])->name('commandesAdmin.create');
        Route::post('/', [AdminController::class, 'storeCommandeAdmin'])->name('commandesAdmin.store');
        Route::get('index', [AdminController::class, 'index'])->name('commandesAdmin.index');

        // Routes avec paramètres ensuite
        Route::get('{id}_administration', [AdminController::class, 'show'])->name('commandesAdmin.show');
        Route::post('{commande}/objet/{objet}/retirer_administration', [AdminController::class, 'retirerObjet'])->name('commandeAdmin.retirer');
        Route::post('{commande}/retirer-plusieurs_administration', [AdminController::class, 'retirerPlusieursObjets'])->name('commandeAdmin.retirerPlusieurs');
        Route::put('{id}/valider_administration', [AdminController::class, 'valider'])->name('commandesAdmin.valider');
        Route::put('{id}/update-financial_administration', [AdminController::class, 'updateFinancial'])->name('commandeAdmin.updateFinancial');
    });

    Route::get('/liste_des_commandes_administration', [AdminController::class, 'listeCommandes'])->name('listeCommandesAdmin');
    Route::get('/journalieres_administration', [AdminController::class, 'journalieres'])->name('commandesAdmin.journalieres');
    Route::get('/factures/{commande}/imprimer_administration', [AdminController::class, 'print'])->name('facturesAdmin.print');

    // Routes de modification admin
    Route::get('/modification_agence_administration', [AdminController::class, 'modificationAgence'])->name('pageModificationAgenceAdmin');
    Route::get('/modification_profil_administration', [ProfileController::class, 'edit'])->name('pageModificationProfil');

    // Routes d'impression admin
    Route::get('/impression_liste_commandes_administration', [AdminController::class, 'printListeCommandes'])->name('listeCommandesAdmin.print');
    Route::get('/impression_liste_commandes_en_attente_administration', [AdminController::class, 'printListeCommandesPending'])->name('listeCommandesPendingAdmin.print');
    Route::get('/impression_liste_commandes_retiree_administration', [AdminController::class, 'printListeCommandesRetraits'])->name('listeCommandesRetraitsAdmin.print');
    Route::get('/impression_liste_commandes_comptabilite_administration', [AdminController::class, 'printListeCommandesComptabilite'])->name('listeCommandesComptabiliteAdmin.print');
    Route::get('/impression_factures_en_attente_administration', [AdminController::class, 'printEnAttente'])->name('commandesAdmin.printEnAttente');

    // Routes de filtrage admin
    Route::get('/commandes_en_attente/filtrer_administration', [AdminController::class, 'filtrerPending'])->name('commandesAdmin.filtrerPending');
    Route::get('/retrait/commandes/filtrer_administration', [AdminController::class, 'retraitsFiltrer'])->name('commandesAdmin.filtrerRetrait');
    Route::get('/Comptabilite/commandes/filtrer_administration', [AdminController::class, 'ComptabiliteFiltrer'])->name('commandesAdmin.filtrerComptabilite');
    Route::get('/commandes/retrait_administration', [AdminController::class, 'retraitPending'])->name('commandesAdmin.retraitPending');

    // Routes de gestion des factures admin
    Route::post('/retirer_administration', [AdminController::class, 'submit'])->name('retirersAdmin.submit');
    Route::post('/facture/{commande}/notes_administration', [AdminController::class, 'storeNote'])->name('notesAdmin.store');
    Route::get('/factures/{id}/stream_administration', [AdminController::class, 'stream'])->name('facturesAdmin.stream');
    Route::get('/factures/{id}/download_administration', [AdminController::class, 'download'])->name('facturesAdmin.download');
    // Route::get('/factures/{id}/download', [CommandeController::class, 'download'])->name('factures.download');

    // Routes de gestion des utilisateurs admin
    Route::get('/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

    // Routes de gestion du message de facture
    Route::post('/admin/facture-message', [AdminController::class, 'storeFactureMessage'])->name('admin.facture-message.store');
    Route::delete('/admin/facture-message', [AdminController::class, 'deleteFactureMessage'])->name('admin.facture-message.delete');

    Route::get('/retraits_administration', [AdminController::class, 'rappelsAdmin'])->name('retraitsAdmin');
    Route::get('/factures_administration', [AdminController::class, 'factures'])->name('facturesAdmin');
    Route::get('/notifications_administration', [AdminController::class, 'notifications'])->name('notificationsAdmin');
    Route::get('/admin/factures/{id}/edit', [AdminController::class, 'editFacture'])->name('admin.factures.edit');
    Route::put('/admin/factures/{id}', [AdminController::class, 'updateFacture'])->name('admin.factures.update');
    Route::delete('/admin/factures/{id}/delete-permanent', [AdminController::class, 'deleteFacturePermanently'])->name('admin.factures.delete-permanent');
    Route::get('/clients_administration', [App\Http\Controllers\AdminController::class, 'clients'])->name('clientsAdmin');
    Route::post('/clients_administration/password/{numero}', [App\Http\Controllers\AdminController::class, 'setClientPassword'])->name('clientsAdmin.password');


});





// -------------------------------------------------------------- Fin de la route concernant l'adminitrateur -----------------------------------------//







































// -------------------------------------------------------------- Début de la route concernant les utilisateurs -----------------------------------------//

Route::middleware(['auth'])->group(function () {
    // Routes utilisateurs
    Route::get('/dashboard', [ViewsController::class, 'dashboard'])->name('dashboard');
    Route::get('/commandes', [ViewsController::class, 'commandes'])->name('commandes');
    Route::get('/rappels', [ViewsController::class, 'rappels'])->name('rappels');
    Route::get('/profil', [ViewsController::class, 'profil'])->name('profil');
    Route::get('/statistiques', [ViewsController::class, 'statistiques'])->name('statistiques');
    Route::get('/historiques', [ViewsController::class, 'historiques'])->name('historiques');
    Route::get('/acceuil', [ViewsController::class, 'acceuil'])->name('acceuil');
    Route::get('/en_attente', [ViewsController::class, 'enAttente'])->name('pending');
    Route::get('/comptabilite', [ViewsController::class, 'comptabilite'])->name('comptabilite');
    Route::get('/factures', [FactureController::class, 'index'])->name('factures');
    Route::get('/retrait/{commande}', [ViewsController::class, 'pageRetrait'])->name('faireRetrait');
    Route::get('/details_retraits/{id}', [ViewsController::class, 'detailsRetrait'])->name('retrait.details');

    // Routes de recherche utilisateurs
    Route::get('/commandes/recherche', [CommandeController::class, 'recherche'])->name('commandes.recherche');
    Route::get('/commandes_retirees/recherche', [CommandeController::class, 'rechercheRetrait'])->name('commandesRetrait.recherche');
    Route::get('/commandes_retirees/recherche_administration', [AdminController::class, 'rechercheRetrait'])->name('commandesRetraitAdmin.recherche');

    // Routes de filtrage utilisateurs
    Route::get('/commandes_en_attente/filtrer', [CommandeController::class, 'filtrerPending'])->name('commandes.filtrerPending');
    Route::get('/retrait/commandes/filtrer', [CommandeController::class, 'RetraitsFiltrer'])->name('commandes.filtrerRetrait');
    Route::get('/Comptabilite/commandes/filtrer', [CommandeController::class, 'ComptabiliteFiltrer'])->name('commandes.filtrerComptabilite');
    Route::get('/commandes/retrait', [CommandeController::class, 'retraitPending'])->name('commandes.retraitPending');

    // Routes d'impression utilisateurs
    Route::get('/impression_liste_commandes_retiree', [CommandeController::class, 'printListeCommandesRetraits'])->name('listeCommandesRetraits.print');
    Route::get('/impression_liste_commandes_en_attente', [CommandeController::class, 'printListeCommandesPending'])->name('listeCommandesPending.print');
    Route::get('/impression_liste_commandes', [CommandeController::class, 'printListeCommandes'])->name('listeCommandes.print');

    // Routes de gestion des factures utilisateurs
    Route::post('/retirer', [FactureController::class, 'submit'])->name('retirers.submit');
    Route::post('/commandes/{commande}/notes', [CommandeController::class, 'storeNote'])->name('notes.store');
    Route::get('/factures/{id}/stream', [FactureController::class, 'stream'])->name('factures.stream');
    Route::get('/factures/{id}/download', [FactureController::class, 'download'])->name('factures.download');

    // Routes de validation utilisateurs
    Route::put('/commandes/{id}/valider', [CommandeController::class, 'valider'])->name('commandes.valider');

    // Routes de gestion des commandes utilisateurs
    Route::get('/liste_des_commandes', [CommandeController::class, 'listeCommandes'])->name('listeCommandes');
    Route::get('/commandes/{id}', [CommandeController::class, 'show'])->name('commandes.show');
    Route::get('/factures/{id}/edit', [CommandeController::class, 'edit'])->name('factures.edit');
    Route::put('/factures/{id}', [CommandeController::class, 'update'])->name('factures.update');
    Route::get('/factures/{id}/history', [CommandeController::class, 'history'])->name('factures.history');
    Route::delete('/commandes/{id}/delete', [CommandeController::class, 'destroy'])->name('commandes.delete');
    Route::post('/commande/{commande}/objet/{objet}/retirer', [CommandeController::class, 'retirerObjet'])->name('commande.retirer');
    Route::post('/commandes/{commande}/retirer-plusieurs', [CommandeController::class, 'retirerPlusieursObjets'])->name('commande.retirerPlusieurs');



    // Routes de modification utilisateurs
    Route::get('/modification_agence', [AgenceController::class, 'modificationAgence'])->name('pageModificationAgence');
    Route::get('/modification_profil', [ProfileController::class, 'edit'])->name('pageModificationProfil');
    Route::get('/journalieres', [CommandeController::class, 'journalieres'])->name('commandes.journalieres');
    Route::get('/factures/{commande}/imprimer', [FactureController::class, 'print'])->name('factures.print');
    Route::put('/commande/{commande}/update-financial', [CommandeController::class, 'updateFinancial'])->name('commande.updateFinancial');

    // Routes de profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');





    Route::prefix('commandes')->group(function () {
    // Route pour afficher le formulaire de création de commande
    Route::get('create', [CommandeController::class, 'create'])->name('commandes.create');

    // Route pour stocker la commande
    Route::post('store', [CommandeController::class, 'store'])->name('commandes.store');

    // Route pour afficher la liste des commandes (si nécessaire)
    Route::get('index', [CommandeController::class, 'index'])->name('commandes.index');
});

Route::post('/commandes/{commande}/images', [CommandeImageController::class, 'store'])->name('commande.images.store');
Route::delete('/commande-images/{image}', [CommandeImageController::class, 'destroy'])->name('commande.images.destroy');
Route::post('/commande-images/{image}', [CommandeImageController::class, 'update'])->name('commande.images.update');

// Routes pour la gestion des images
Route::post('/commandes/images', [CommandeController::class, 'storeImage'])->name('images.store');
Route::post('/commandes/images/{id}', [CommandeController::class, 'updateImage'])->name('images.update');
Route::delete('/commandes/images/{id}', [CommandeController::class, 'deleteImage'])->name('images.delete');
});





// -------------------------------------------------------------- Fin de la route concernant les utilisateurs -----------------------------------------//




















require __DIR__ . '/auth.php';

Route::get('/imprimer_comptabilite', [AdminController::class, 'printComptabilite'])->name('comptabilite.print');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/profile-admin', [AdminController::class, 'profilAdmin'])->name('profilAdmin');
});

// Route publique pour les factures PDF (accessible sans authentification)
Route::get('/factures/{commande}/pdf', [FactureController::class, 'publicPrint'])->name('factures.public');

Route::get('/rappels/imprimer', [\App\Http\Controllers\ViewsController::class, 'rappelsImpression'])->name('rappels.imprimer');

Route::get('/admin/rappels/imprimer', [\App\Http\Controllers\AdminController::class, 'rappelsImpressionAdmin'])->name('admin.rappels.imprimer');
