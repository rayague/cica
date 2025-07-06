<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cica - Modifier la Facture</title>
    <link rel="shortcut icon" href="{{ asset('images/Cica.png') }}" type="image/x-icon">

    <!-- Custom fonts -->
    <link href="{{ asset('dashboard-assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('dashboard-assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>

<body id="page-top" class="bg-gray-100">
    <!-- Page Wrapper -->
    <div id="wrapper" class="flex">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="font-bold sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('acceuil') }}">
                <div class="mx-3 sidebar-brand-text">Cica</div>
            </a>

            <!-- Divider -->
            <hr class="my-0 sidebar-divider">

            <nav class="text-white bg-gray-800 sidebar">
                <!-- Nav Item - Tableau de Bord -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('acceuil') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="font-weight-bold">TABLEAU DE BORD</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Nav Item - Accueil -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('acceuil') }}">
                        <i class="fas fa-fw fa-home"></i>
                        <span class="font-weight-bold">ACCUEIL</span>
                    </a>
                </li>

                <!-- Nav Item - Commandes -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('commandes') }}">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                        <span class="font-weight-bold">COMMANDES</span>
                    </a>
                </li>

                <!-- Nav Item - Liste des Commandes -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listeCommandes') }}">
                        <i class="fas fa-fw fa-list"></i>
                        <span class="font-weight-bold">LISTE DES COMMANDES</span>
                    </a>
                </li>

                <!-- Nav Item - En Attente -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pending') }}">
                        <i class="fas fa-fw fa-clock"></i>
                        <span class="font-weight-bold">EN ATTENTE</span>
                    </a>
                </li>

                <!-- Nav Item - Comptabilité -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('comptabilite') }}">
                        <i class="fas fa-fw fa-coins"></i>
                        <span class="font-weight-bold">COMPTABILITE</span>
                    </a>
                </li>

                <!-- Nav Item - Retraits -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rappels') }}">
                        <i class="fas fa-fw fa-bell"></i>
                        <span class="font-weight-bold">RETRAITS</span>
                    </a>
                </li>

                <!-- Nav Item - Factures -->
                <li class="nav-item bg-yellow-500">
                    <a class="nav-link" href="{{ route('factures') }}">
                        <i class="fas fa-fw fa-file-invoice"></i>
                        <span class="font-weight-bold">FACTURES</span>
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

            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="border-0 rounded-circle" id="sidebarToggle"></button>
            </div>
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="flex-1">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="mb-4 bg-white shadow navbar navbar-expand navbar-light topbar static-top">
                    <!-- Sidebar Toggle -->
                    <button id="sidebarToggleTop" class="mr-3 btn btn-link d-md-none rounded-circle">
                        <i class="fa fa-bars"></i>
                    </button>

                    <h3 class="text-xl font-bold text-gray-800">Modifier la Facture</h3>

                    <!-- Topbar Navbar -->
                    <ul class="ml-auto navbar-nav">
                        <!-- User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <h3 class="nav-link dropdown-toggle">
                                <img class="img-profile rounded-circle" src="{{ asset('images/image4.jpg') }}">
                            </h3>
                        </li>
                    </ul>
                </nav>

                <!-- Begin Page Content -->
                <div class="container-fluid px-4">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Modifier la Facture</h1>
                        <p class="text-gray-600">Numéro de facture: {{ $commande->numero }}</p>
                    </div>

                    <!-- Formulaire d'édition -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('factures.update', $commande->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Informations client -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="client" class="block text-sm font-medium text-gray-700 mb-2">Nom du client</label>
                                    <input type="text" id="client" name="client" value="{{ $commande->client }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="numero_whatsapp" class="block text-sm font-medium text-gray-700 mb-2">Numéro WhatsApp</label>
                                    <input type="text" id="numero_whatsapp" name="numero_whatsapp" value="{{ $commande->numero_whatsapp }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <!-- Dates et heures -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <div>
                                    <label for="date_depot" class="block text-sm font-medium text-gray-700 mb-2">Date de dépôt</label>
                                    <input type="date" id="date_depot" name="date_depot" value="{{ $commande->date_depot }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="date_retrait" class="block text-sm font-medium text-gray-700 mb-2">Date de retrait</label>
                                    <input type="date" id="date_retrait" name="date_retrait" value="{{ $commande->date_retrait }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Heure de retrait (non modifiable)</label>
                                    <input type="time" value="{{ $commande->heure_retrait }}" readonly
                                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                                </div>
                            </div>

                            <!-- Type de lavage et statut -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de lavage (non modifiable)</label>
                                    <input type="text" value="{{ $commande->type_lavage }}" readonly
                                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut (non modifiable)</label>
                                    <input type="text" value="{{ $commande->statut }}" readonly
                                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                                </div>
                            </div>

                            <!-- Informations financières -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <div>
                                    <label for="avance_client" class="block text-sm font-medium text-gray-700 mb-2">Avance client</label>
                                    <input type="number" step="0.01" id="avance_client" name="avance_client" value="{{ $commande->avance_client }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="remise_reduction" class="block text-sm font-medium text-gray-700 mb-2">Remise (%)</label>
                                    <select id="remise_reduction" name="remise_reduction"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="0" {{ $commande->remise_reduction == 0 ? 'selected' : '' }}>0%</option>
                                        <option value="5" {{ $commande->remise_reduction == 5 ? 'selected' : '' }}>5%</option>
                                        <option value="10" {{ $commande->remise_reduction == 10 ? 'selected' : '' }}>10%</option>
                                        <option value="15" {{ $commande->remise_reduction == 15 ? 'selected' : '' }}>15%</option>
                                        <option value="20" {{ $commande->remise_reduction == 20 ? 'selected' : '' }}>20%</option>
                                        <option value="25" {{ $commande->remise_reduction == 25 ? 'selected' : '' }}>25%</option>
                                        <option value="30" {{ $commande->remise_reduction == 30 ? 'selected' : '' }}>30%</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Total (non modifiable)</label>
                                    <input type="number" step="0.01" value="{{ $commande->total }}" readonly
                                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                                </div>
                            </div>

                            <!-- Objets de la commande -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Objets de la commande (non modifiables)</h3>
                                <div class="space-y-4">
                                    @foreach($commande->objets as $index => $objet)
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Objet</label>
                                                <input type="text" value="{{ $objet->nom }}" readonly 
                                                       class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                                                <input type="number" value="{{ $objet->pivot->quantite }}" readonly
                                                       class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Prix unitaire</label>
                                                <input type="number" step="0.01" value="{{ $objet->prix_unitaire }}" readonly 
                                                       class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                                <input type="text" value="{{ $objet->pivot->description }}" readonly
                                                       class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                                <a href="{{ route('factures') }}"
                                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    Annuler
                                </a>
                                <button type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prêt à partir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à terminer votre session actuelle.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('dashboard-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('dashboard-assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('dashboard-assets/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
