<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/Cica.png') }}" type="image/x-icon">


    <title>Cica</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('dashboard-assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <!-- Custom styles for this template-->
    <link href="{{ asset('dashboard-assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="font-bold sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ route('administration') }}">
                <div class="mx-3 sidebar-brand-text">Cica</div>
            </a>

            <!-- Divider -->
            <hr class="my-0 sidebar-divider">

            <nav class="text-white bg-gray-800 sidebar">
                <!-- Nav Item - Tableau de Bord -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="font-weight-bold">TABLEAU DE BORD</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Nav Item - Accueil -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration') }}">
                        <i class="text-white fas fa-fw fa-home"></i>
                        <span class="font-weight-bold">ACCUEIL</span>
                    </a>
                </li>

                <!-- Nav Item - Création d'Objets -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('creationObjets') }}">
                        <i class="fas fa-fw fa-plus-square"></i>
                        <span class="font-weight-bold">CRÉER OBJETS & PRIX</span>
                    </a>
                </li>

                <!-- Nav Item - Commandes -->
                <li class="bg-yellow-500 nav-item">
                    <a class="nav-link" href="{{ route('commandesAdmin') }}">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                        <span class="font-weight-bold">COMMANDES</span>
                    </a>
                </li>

                <!-- Nav Item - Liste des Commandes -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listeCommandesAdmin') }}">
                        <i class="fas fa-fw fa-list"></i>
                        <span class="font-weight-bold">LISTE DES COMMANDES</span>
                    </a>
                </li>

                <!-- Nav Item - En Attente -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pendingAdmin') }}">
                        <i class="fas fa-fw fa-clock"></i>
                        <span class="font-weight-bold">EN ATTENTE</span>
                    </a>
                </li>

                <!-- Nav Item - Comptabilité -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('comptabiliteAdmin') }}">
                        <i class="fas fa-fw fa-coins"></i>
                        <span class="font-weight-bold">COMPTABILITE</span>
                    </a>
                </li>

                <!-- Nav Item - Retraits -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rappelsAdmin') }}">
                        <i class="fas fa-fw fa-bell"></i>
                        <span class="font-weight-bold">RETRAITS</span>
                    </a>
                </li>

                <!-- Nav Item - Utilisateurs -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('utilisateursAdmin') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span class="font-weight-bold">UTILISATEURS</span>
                    </a>
                </li>

                <!-- Nav Item - Déconnexion -->
                <li class="nav-item hover:bg-red-500">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="font-weight-bold">DÉCONNEXION</span>
                    </a>
                </li>
            </nav>




            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="border-0 rounded-circle" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="mb-4 bg-white shadow navbar navbar-expand navbar-light topbar static-top">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="mr-3 btn btn-link d-md-none rounded-circle">
                        <i class="fa fa-bars"></i>
                    </button>

                    <h3 class="text-xl font-bold text-gray-800">Commandes </h3>
                    <!-- Topbar Navbar -->
                    <ul class="ml-auto navbar-nav">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="p-3 shadow dropdown-menu dropdown-menu-right animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="mr-auto form-inline w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="border-0 form-control bg-light small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <h3 class="nav-link dropdown-toggle">

                                <img class="img-profile rounded-circle" src="{{ asset('images/image4.jpg') }}">
                            </h3>

                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <!-- Détails de la commande -->
                <div class="p-4 md:p-6 mx-2 md:mx-4 mb-6 bg-white rounded-lg shadow-md">
                    <h2 class="mb-4 md:mb-6 text-xl md:text-2xl font-semibold text-gray-800">Détails de la commande</h2>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-4 md:space-y-6">
                        <!-- Informations générales -->
                        <div class="flex flex-col md:flex-row justify-between gap-2">
                            <strong>Numéro de Commande:</strong>
                            <span>{{ $commande->numero }}</span>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-2">
                            <strong>Client:</strong>
                            <span>{{ $commande->client }}</span>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-2">
                            <strong>Numéro WhatsApp:</strong>
                            <span>{{ $commande->numero_whatsapp }}</span>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-2">
                            <strong>Date de Dépôt:</strong>
                            <span>{{ \Carbon\Carbon::parse($commande->date_depot)->locale('fr')->isoFormat('LL') }}</span>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-2">
                            <strong>Date de Retrait:</strong>
                            <span>{{ \Carbon\Carbon::parse($commande->date_retrait)->locale('fr')->isoFormat('LL') }}</span>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-2">
                            <strong>Type de Lavage:</strong>
                            <span class="px-2 py-1 text-white rounded-md {{ strtolower($commande->type_lavage) === 'lavage express' ? 'bg-yellow-500' : 'bg-blue-500' }}">
                                {{ $commande->type_lavage }}
                            </span>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex flex-wrap gap-4 mt-6">


                            {{-- @if($commande->statut !== 'validée')
                                <button type="button" class="px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600" onclick="validerFacture()">
                                    <i class="fas fa-check"></i> Valider la facture
                                </button>
                            @endif --}}

                            <!-- Bouton de test pour la modale -->

                        </div>

                        <!-- Section des avances cumulées -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="mb-4 text-lg font-semibold text-gray-800">Avances cumulées</h4>
                            <div class="space-y-3">
                                @if($commande->payments && $commande->payments->count() > 0)
                                    @foreach($commande->payments as $index => $payment)
                                        <div class="flex justify-between items-center p-3 bg-white rounded-md shadow-sm">
                                            <div class="flex items-center">
                                                <span class="px-3 py-1 mr-3 text-sm font-medium text-blue-600 bg-blue-100 rounded-full">
                                                    Avance {{ $index + 1 }}
                                                </span>
                                                <span class="text-gray-600">{{ $payment->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <span class="text-lg font-semibold text-green-600">
                                                {{ number_format($payment->amount, 2, ',', ' ') }} FCFA
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="p-3 text-center text-gray-500 bg-white rounded-md shadow-sm">
                                        Aucune avance enregistrée
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Liste des objets -->
                        <div class="mt-6 md:mt-8">
                            <h3 class="text-xl md:text-2xl font-black mb-4">Commandes:</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full border border-collapse table-auto">
                                <thead class="text-white bg-blue-500">
                                    <tr>
                                            <th class="px-2 md:px-4 py-2 border border-blue-400">Objet</th>
                                            <th class="px-2 md:px-4 py-2 border border-blue-400">Quantité</th>
                                            <th class="px-2 md:px-4 py-2 border border-blue-400">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($commande->objets as $objet)
                                        <tr class="border-b">
                                                <td class="px-2 md:px-4 py-2 border border-blue-400">{{ $objet->nom }}</td>
                                                <td class="px-2 md:px-4 py-2 border border-blue-400">{{ $objet->pivot->quantite }}</td>
                                                <td class="px-2 md:px-4 py-2 border border-blue-400">{{ $objet->pivot->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tableau des notes (retraits) -->
                    <div class="mt-6 md:mt-8">
                        <h3 class="mb-4 text-lg md:text-xl font-semibold">Historique des Retraits / Notes</h3>
                        @if ($notes->isNotEmpty())
                            <div class="overflow-x-auto">
                            <table class="w-full border border-collapse table-auto">
                                <thead class="text-white bg-yellow-500">
                                    <tr>
                                            <th class="px-2 md:px-4 py-2 border border-yellow-400">Numéro de Facture</th>
                                            <th class="px-2 md:px-4 py-2 border border-yellow-400">Utilisateur</th>
                                            <th class="px-2 md:px-4 py-2 border border-yellow-400">Note</th>
                                            <th class="px-2 md:px-4 py-2 border border-yellow-400">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notes as $note)
                                        <tr class="hover:bg-blue-50">
                                                <td class="px-2 md:px-4 py-2 border border-yellow-300">{{ $commande->numero }}</td>
                                                <td class="px-2 md:px-4 py-2 border border-yellow-300">{{ $note->user->name ?? $note->user_id }}</td>
                                                <td class="px-2 md:px-4 py-2 border border-yellow-300">{{ $note->note }}</td>
                                                <td class="px-2 md:px-4 py-2 border border-yellow-300">{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        @else
                            <p class="p-3 text-base md:text-lg font-black text-center text-white bg-orange-400 rounded">Aucune note enregistrée pour cette commande.</p>
                        @endif
                    </div>

                    <!-- Bilan Financier -->
                    <div class="p-4 mt-6 md:mt-8 bg-gray-200 rounded">
                        <h3 class="mb-4 text-lg md:text-xl font-semibold">Bilan Financier</h3>
                        <div class="space-y-2">
                            <div class="flex flex-col md:flex-row justify-between gap-2">
                                <span><strong>Total sans réduction :</strong></span>
                            <span>{{ number_format($originalTotal, 2, ',', ' ') }} FCFA</span>
                        </div>

                        @if ($remiseReduction > 0)
                                <div class="flex flex-col md:flex-row justify-between gap-2">
                                    <span><strong>Réduction appliquée ({{ $remiseReduction }}%) :</strong></span>
                                <span>{{ number_format($discountAmount, 2, ',', ' ') }} FCFA</span>
                            </div>
                                <div class="flex flex-col md:flex-row justify-between gap-2">
                                <span><strong>Calcul :</strong></span>
                                <span class="p-1 text-white bg-green-500 rounded">
                                    {{ number_format($originalTotal, 2, ',', ' ') }} FCFA x {{ $remiseReduction }}% =
                                    {{ number_format($discountAmount, 2, ',', ' ') }} FCFA
                                </span>
                            </div>
                        @else
                                <div class="flex flex-col md:flex-row justify-between gap-2">
                                    <span><strong>Réduction :</strong></span>
                                <span class="p-1 text-white bg-green-500 rounded">Aucune réduction appliquée</span>
                            </div>
                        @endif

                            <div class="flex flex-col md:flex-row justify-between gap-2">
                                <span><strong>Total final :</strong></span>
                            <span>{{ number_format($commande->total, 2, ',', ' ') }} FCFA</span>
                        </div>
                            <div class="flex flex-col md:flex-row justify-between gap-2">
                                <span><strong>Avances cumulées :</strong></span>
                            <span>{{ number_format($commande->avance_client, 2, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex flex-col md:flex-row justify-between gap-2">
                                <span><strong>Solde restant :</strong></span>
                                <span>{{ number_format($commande->solde_restant, 2, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex flex-col md:flex-row justify-between gap-2">
                                <span><strong>Statut :</strong></span>
                                <span class="{{ $commande->statut === 'Non retirée' ? 'bg-red-500 rounded p-2 text-white' : 'bg-green-500 rounded p-2 text-white' }}">
                                    {{ $commande->statut }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire de mise à jour des entrées d'argent -->
                    @if($commande->solde_restant > 0)
                    <div class="p-4 mt-6 md:mt-8 bg-gray-200 rounded">
                        <h3 class="mb-4 text-lg md:text-xl font-semibold">Mettre à jour les entrées d'argent</h3>
                        <form action="{{ route('commande.updateFinancial', $commande->id) }}" method="POST"
                            class="flex flex-col md:flex-row items-start md:items-center gap-4">
                            @csrf
                            @method('PUT')
                            <div class="w-full md:w-auto">
                                <label for="montant_paye" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nouvelle avance :
                                </label>
                                <input type="number" name="montant_paye" id="montant_paye" step="0.01"
                                    min="0" max="{{ $commande->solde_restant }}"
                                    class="w-full md:w-32 p-2 border rounded-md" required placeholder="montant"
                                    oninvalid="this.setCustomValidity('Le montant ne peut pas dépasser {{ number_format($commande->solde_restant, 2, ',', ' ') }} FCFA')"
                                    oninput="this.setCustomValidity('')">
                            </div>
                            <div class="w-full md:w-auto">
                            <select name="payment_method" id="payment_method"
                                    class="w-full md:w-48 p-2 bg-white border rounded-md">
                                <option value="">Choisir</option>
                                <option value="Avance">Avance</option>
                                <option value="Retrait">Retrait</option>
                            </select>
                            </div>
                            <div class="w-full md:w-auto">
                                <select name="payment_type" id="payment_type"
                                    class="w-full md:w-48 p-2 bg-white border rounded-md">
                                    <option value="">Moyen de paiement</option>
                                    <option value="Espèce">Espèce</option>
                                    <option value="Mobile Money">Mobile Money</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full md:w-auto px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                Mettre à jour
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="p-4 mt-6 md:mt-8 bg-gray-200 rounded">
                        <h3 class="mb-4 text-lg md:text-xl font-semibold text-gray-600">Mettre à jour les entrées d'argent</h3>
                        <p class="text-gray-600">Le solde de cette commande est déjà à zéro. Aucune mise à jour n'est nécessaire.</p>
                    </div>
                    @endif

                    <!-- Section des images -->
                    <div class="p-4 md:p-6 mx-2 md:mx-4 mb-6 bg-white rounded-lg shadow-md">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
                            <h3 class="text-xl md:text-2xl font-black">Images de la commande</h3>
                            <button type="button" id="addImageBtn" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                <i class="fas fa-plus"></i> Ajouter une image
                            </button>
                            <input type="file" id="imageInput" accept="image/*" style="display: none;">
                        </div>

                        <!-- Zone d'affichage des images -->
                        <div id="imagesContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($commande->images as $image)
                                <div class="relative group border rounded-lg p-2" data-image-id="{{ $image->id }}">
                                    <div class="w-full h-48 bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="{{ $image->original_name }}"
                                             class="w-full h-full object-cover"
                                             onerror="console.log('Erreur de chargement de l\'image:', this.src); this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                                    </div>
                                    <div class="absolute top-2 right-2 flex gap-2 bg-black bg-opacity-50 p-2 rounded-lg">
                                        <button type="button" class="updateImageBtn p-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors" onclick="editImage({{ $image->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="deleteImageBtn p-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors" onclick="deleteImage({{ $image->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2 text-center text-sm text-gray-600">
                                        {{ $image->original_name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Modal pour modifier une image -->
                    <div class="modal fade" id="editImageModal" tabindex="-1" aria-labelledby="editImageModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editImageModalLabel">Modifier l'image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editImageForm" enctype="multipart/form-data">
                                            @csrf
                                        <input type="hidden" id="editImageId" name="image_id">
                                        <div class="mb-3">
                                            <label for="editImageInput" class="form-label">Nouvelle image</label>
                                            <input type="file" class="form-control" id="editImageInput" name="image" accept="image/*" required>
                                            </div>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col md:flex-row flex-wrap items-center justify-between gap-4 mt-6 md:mt-8">
                        <!-- Bouton WhatsApp -->
                        <button type="button"
                           onclick="sendWhatsAppMessage()"
                           class="w-full md:w-auto flex items-center justify-center px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Envoyer par WhatsApp
                        </button>

                        <!-- Bouton Retrait -->
                        @if($commande->statut === 'Validée' || $commande->statut === 'Payé' || $commande->statut === 'retiré' || $commande->statut === 'Retiré' || $commande->solde_restant == 0)
                            <div class="w-full md:w-auto px-4 py-2 text-white bg-red-500 rounded-md">
                                Cette commande est validée. Aucun retrait n'est possible.
                            </div>
                        @else
                              <button type="button"
                                class="px-4 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600"
                                data-bs-toggle="modal"
                                data-bs-target="#retraitModal">
                                <i class="fas fa-box mr-2"></i>
                                Faire un retrait / Ajouter une note
                            </button>
                        @endif

                        <!-- Bouton Imprimer -->
                        <a href="{{ route('factures.print', $commande->id) }}"
                           target="_blank"
                           class="w-full md:w-auto px-4 py-2 text-white bg-purple-500 rounded-md hover:bg-purple-600">
                            <i class="fas fa-print mr-2"></i>
                            Imprimer
                        </a>
                    </div>

                <!-- Boutons de navigation -->
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mx-2 md:mx-4 my-6 md:my-10">
                    <a href="{{ route('listeCommandesAdmin') }}"
                            class="px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700">
                            <i class="mr-2 fas fa-arrow-left"></i>Retour
                    </a>
                        @if($commande->statut === 'Non retirée' || $commande->statut === 'Non retiré' || $commande->statut === 'Partiellement payé')
                    <form action="{{ route('commandesAdmin.valider', $commande->id) }}" method="POST"
                                onsubmit="return confirm('Voulez-vous vraiment valider cette facture ?');"
                                class="w-full md:w-auto">
                        @csrf
                        @method('PUT')
                                <button type="submit" class="w-full p-2 text-white bg-green-500 rounded-md hover:bg-green-600">
                            Valider la facture
                        </button>
                    </form>
                        @else
                            <div class="w-full md:w-auto p-2 text-white bg-red-500 rounded-md text-center">
                                Cette commande est déjà validée et ne peut plus être modifiée
                            </div>
                        @endif
                </div>

            </div>
            <!-- /.container-fluid -->

            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="my-auto text-center copyright">
                        Copyrignt © <span class="text-yellow-500"
                            style="font-family: 'Dancing Script', cursive;">Cica</span> Ray
                        Ague.
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

            </div>
            <!-- /.container-fluid -->

            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->
        <!-- Modal de confirmation de déconnexion -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Prêt à quitter ?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à quitter votre session.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="rounded scroll-to-top" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    {{-- <script>
        function addObjectField() {
            const container = document.getElementById('objects-container');
            const div = document.createElement('div');
            div.classList.add('flex', 'gap-4', 'mb-2');
            div.innerHTML = `
            <select name="objets[0][id]" class="w-full p-2 mt-1 border rounded-md">
@foreach ($objets as $objet)
                                                <option value="{{ $objet->id }}">{{ $objet->nom }}</option>
                                            @endforeach
            </select>
            <input type="number" class="w-20 p-2 mt-1 border rounded-md" name="objets[0][quantite]" placeholder="Qté" min="1" required>
          `;
            container.appendChild(div);
        }
    </script> --}}
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('dashboard-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('dashboard-assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('dashboard-assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Scripts pour la gestion des images -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du formulaire de mise à jour financière
            const form = document.querySelector('form[action*="updateFinancial"]');
            const montantInput = document.getElementById('montant_paye');
            const soldeRestant = {{ $commande->solde_restant }};

            if (form && montantInput) {
                form.setAttribute('novalidate', true);

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const montant = parseFloat(montantInput.value);

                    if (montant > soldeRestant) {
                        alert('Le montant ne peut pas dépasser ' + new Intl.NumberFormat('fr-FR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(soldeRestant) + ' FCFA');
                        return;
                    }

                    if (montant <= 0) {
                        alert('Le montant doit être supérieur à 0');
                        return;
                    }

                    form.submit();
                });

                montantInput.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = 0;
                    }
                });
            }

            // Gestion des images
            const addImageBtn = document.getElementById('addImageBtn');
            const imageInput = document.getElementById('imageInput');
            const imagesContainer = document.getElementById('imagesContainer');
            const maxImages = 10;

            if (addImageBtn && imageInput) {
                addImageBtn.addEventListener('click', () => {
                    const currentImages = document.querySelectorAll('#imagesContainer > div').length;
                    if (currentImages >= maxImages) {
                        alert('Maximum 10 images autorisées par commande');
                        return;
                    }
                    imageInput.click();
                });

                imageInput.addEventListener('change', async (e) => {
                    const file = e.target.files[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    try {
                        const response = await fetch(`/commandes/{{ $commande->id }}/images`, {
                            method: 'POST',
                            body: formData
                        });

                        const data = await response.json();
                        if (!response.ok) throw new Error(data.error || 'Erreur lors de l\'upload');

                        location.reload();
                    } catch (error) {
                        alert(error.message);
                    }
                });
            }

            // Initialisation de la modale de retrait
            const retraitModalElement = document.getElementById('retraitModal');
            if (retraitModalElement) {
                const retraitModal = new bootstrap.Modal(retraitModalElement);

                // Gestionnaire d'événement pour le bouton de retrait
                const retraitButton = document.querySelector('[data-bs-target="#retraitModal"]');
                if (retraitButton) {
                    retraitButton.addEventListener('click', function() {
                        retraitModal.show();
                    });
                }
            }
        });

        // Gestion du formulaire de modification d'image
        document.getElementById('editImageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const imageId = document.getElementById('editImageId').value;

            // Vérifier si une image a été sélectionnée
            const imageInput = document.getElementById('editImageInput');
            if (!imageInput.files || !imageInput.files[0]) {
                alert('Veuillez sélectionner une image');
                return;
            }

            // Ajouter l'image au FormData
            formData.append('image', imageInput.files[0]);

            // Ajouter le token CSRF
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('_token', token);

            fetch(`/commandes/images/${imageId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erreur lors de la modification de l\'image');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la modification de l\'image');
            });
        });

        // Fonction pour supprimer une image
        function deleteImage(imageId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(`/commandes/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression de l\'image');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de la suppression de l\'image');
                });
            }
        }

        // Fonction pour éditer une image
        function editImage(imageId) {
            document.getElementById('editImageId').value = imageId;
            // Réinitialiser le formulaire
            document.getElementById('editImageForm').reset();
            const editModal = new bootstrap.Modal(document.getElementById('editImageModal'));
            editModal.show();
        }

        // --- Ajout de la fonction WhatsApp pour l'administration ---
        function sendWhatsAppMessage() {
            @php
                $clientName = $commande->client;
                $orderNumber = $commande->numero;
                $totalAmount = number_format($commande->total, 2, ',', ' ') . ' FCFA';
                $depositDate = \Carbon\Carbon::parse($commande->date_depot)->locale('fr')->isoFormat('LL');
                $pickupDate = \Carbon\Carbon::parse($commande->date_retrait)->locale('fr')->isoFormat('LL');
                $whatsAppNumber = $commande->numero_whatsapp;
                $baseUrl = config('app.url');
            @endphp

            const clientName = @json($clientName);
            const orderNumber = @json($orderNumber);
            const totalAmount = @json($totalAmount);
            const depositDate = @json($depositDate);
            const pickupDate = @json($pickupDate);

            // 1. Correction du format du numéro WhatsApp
            let whatsAppNumber = @json($whatsAppNumber);
            whatsAppNumber = whatsAppNumber.replace(/\D/g, ''); // Garder seulement les chiffres
            if (whatsAppNumber.length === 8) {
                whatsAppNumber = '229' + whatsAppNumber; // Ajouter l'indicatif du Bénin si absent
            }

            // 2. Correction de l'URL pour qu'elle soit publique
            const baseUrl = @json($baseUrl);
            const previewUrl = `${baseUrl}/preview/{{ $commande->id }}`;

            const message = `Bonjour ${clientName},\nVotre reçu pour la commande *${orderNumber}* est prêt.\n- *Montant Total:* ${totalAmount}\n- *Date de Dépôt:* ${depositDate}\n- *Date de Retrait:* ${pickupDate}\nVous pouvez consulter les détails et télécharger votre reçu ici : ${previewUrl}\nMerci d'avoir choisi CICA !`;

            const encodedMessage = encodeURIComponent(message);
            const whatsappUrl = `https://api.whatsapp.com/send?phone=${whatsAppNumber}&text=${encodedMessage}`;

            window.open(whatsappUrl, '_blank');
        }
        // --- Fin ajout WhatsApp ---
    </script>

    <!-- Modal pour faire un retrait / ajouter une note -->
    <div class="modal fade" id="retraitModal" tabindex="-1" aria-labelledby="retraitModalLabel" aria-hidden="true" style="z-index: 99999;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="retraitModalLabel">Faire un retrait / Ajouter une note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('notes.store', ['commande' => $commande->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="facture_id" class="form-label">Numéro de la facture</label>
                            <input type="text" id="facture_id" value="{{ $commande->numero }}" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="client_name" class="form-label">Nom du Client</label>
                            <input type="text" id="client_name" value="{{ $commande->client }}" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Libellé du retrait</label>
                            <textarea id="note" name="note" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Valider le retrait</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
