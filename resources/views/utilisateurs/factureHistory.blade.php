<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cica - Historique des Modifications</title>
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

                    <h3 class="text-xl font-bold text-gray-800">Historique des Modifications</h3>

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
                        <h1 class="h3 mb-0 text-gray-800">Historique des Modifications</h1>
                        <p class="text-gray-600">Facture: {{ $commande->numero }} - Client: {{ $commande->client }}</p>
                    </div>

                    <!-- Historique des modifications -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        @if($notifications->count() > 0)
                            <div class="space-y-6">
                                @foreach($notifications as $notification)
                                    <div class="border-l-4 border-blue-500 pl-4 py-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    @if($notification->action == 'update')
                                                        <i class="fas fa-edit text-blue-600"></i>
                                                    @elseif($notification->action == 'delete')
                                                        <i class="fas fa-trash text-red-600"></i>
                                                    @else
                                                        <i class="fas fa-plus text-green-600"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">
                                                        @if($notification->action == 'update')
                                                            Modification de la facture
                                                        @elseif($notification->action == 'delete')
                                                            Suppression de la facture
                                                        @else
                                                            Création de la facture
                                                        @endif
                                                    </h4>
                                                    <p class="text-sm text-gray-600">
                                                        Par {{ $notification->user->name }} le {{ $notification->created_at->format('d/m/Y à H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <h5 class="font-medium text-gray-900 mb-2">Modifications apportées :</h5>
                                            <p class="text-gray-700">{{ $notification->description }}</p>
                                            
                                            @if($notification->action == 'update' && isset($notification->changes['fields']))
                                                <div class="mt-4">
                                                    <h6 class="font-medium text-gray-900 mb-2">Détails des changements :</h6>
                                                    <div class="space-y-2">
                                                        @foreach($notification->changes['fields'] as $field => $change)
                                                            <div class="flex items-center space-x-2 text-sm">
                                                                <span class="text-gray-600">{{ ucfirst($field) }}:</span>
                                                                <span class="text-red-500 line-through">{{ $change['old'] }}</span>
                                                                <i class="fas fa-arrow-right text-gray-400"></i>
                                                                <span class="text-green-600 font-medium">{{ $change['new'] }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($notification->action == 'update' && isset($notification->changes['objets']))
                                                <div class="mt-4">
                                                    <h6 class="font-medium text-gray-900 mb-2">Modifications des objets :</h6>
                                                    <div class="space-y-3">
                                                        @foreach($notification->changes['objets'] as $objetChange)
                                                            <div class="border-l-2 border-gray-200 pl-3">
                                                                <p class="font-medium text-gray-800">{{ $objetChange['objet'] }}</p>
                                                                @if(isset($objetChange['quantite']))
                                                                    <p class="text-sm text-gray-600">
                                                                        Quantité: {{ $objetChange['quantite']['old'] }} → {{ $objetChange['quantite']['new'] }}
                                                                    </p>
                                                                @endif
                                                                @if(isset($objetChange['description']))
                                                                    <p class="text-sm text-gray-600">
                                                                        Description: {{ $objetChange['description']['old'] }} → {{ $objetChange['description']['new'] }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune modification</h3>
                                <p class="text-gray-600">Cette facture n'a pas encore été modifiée.</p>
                            </div>
                        @endif
                        
                        <!-- Bouton retour -->
                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('factures') }}" 
                               class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors duration-200">
                                Retour aux factures
                            </a>
                        </div>
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