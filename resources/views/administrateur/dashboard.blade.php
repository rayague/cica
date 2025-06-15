<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cica</title>
    <link rel="shortcut icon" href="{{ asset('images/Cica.png') }}" type="image/x-icon">


    <!-- Custom fonts for this template-->
    <link href="{{ asset('dashboard-assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('dashboard-assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>



</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="font-bold sidebar-brand d-flex align-items-center justify-content-center"
                href="
                {{ route('administration') }}
                ">

                <div class="mx-3 sidebar-brand-text">Cica</div>
            </a>

            <!-- Divider -->
            <hr class="my-0 sidebar-divider">
            <nav class="text-white bg-gray-800 sidebar">
                <!-- Nav Item - Tableau de Bord -->
                <li class="nav-item">
                    <a class="nav-link" href="
                    {{ route('administration') }}
                    ">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="font-weight-bold">TABLEAU DE BORD</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Nav Item - Accueil -->
                <li class="nav-item">
                    <a class="nav-link"
                        href="
                    {{ route('administration') }}
                    ">
                        <i class="fas fa-fw fa-home"></i>
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
                <li class="nav-item">
                    <a class="nav-link"
                        href="
                    {{ route('commandesAdmin') }}
                    ">
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
                    <a class="nav-link" href="
                    {{ route('rappelsAdmin') }}
                    ">
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

                    <h3 class="text-xl font-bold text-gray-800">Administration </h3>
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
                <div class="container-fluid px-4">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
                    </div>

                    <!-- Cartes de statistiques -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <!-- Carte des commandes en cours -->
                        <div class="bg-white rounded-lg shadow-lg p-4 hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                    <i class="fas fa-shopping-cart text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-700">Commandes en cours</h3>
                                    <p class="text-2xl font-bold text-blue-600">{{ $commandesEnCours }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Carte des commandes du jour -->
                        <div class="bg-white rounded-lg shadow-lg p-4 hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-500">
                                    <i class="fas fa-calendar-day text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-700">Commandes du jour</h3>
                                    <p class="text-2xl font-bold text-green-600">{{ $commandesDuJour }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Carte des commandes à retirer -->
                        <div class="bg-white rounded-lg shadow-lg p-4 hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                                    <i class="fas fa-box text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-700">À retirer</h3>
                                    <p class="text-2xl font-bold text-yellow-600">{{ $commandesARetirer }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Carte du chiffre d'affaires -->
                        <div class="bg-white rounded-lg shadow-lg p-4 hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                                    <i class="fas fa-money-bill-wave text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-700">Chiffre d'affaires</h3>
                                    <p class="text-2xl font-bold text-purple-600">{{ number_format($chiffreAffaires, 2, ',', ' ') }} FCFA</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dernières commandes -->
                    <div class="bg-white rounded-lg shadow mb-4">
                        <div class="p-4 border-b">
                            <h3 class="text-lg font-semibold text-gray-700">Dernières commandes</h3>
                        </div>
                        <div class="p-4">
                            <div class="overflow-x-auto">
                                <table class="w-full border border-collapse table-auto">
                                    <thead class="text-white bg-blue-500">
                                        <tr>
                                            <th class="px-2 md:px-4 py-2 border border-blue-400">Numéro</th>
                                            <th class="px-2 md:px-4 py-2 border border-blue-400">Client</th>
                                            <th class="px-2 md:px-4 py-2 border border-blue-400">Date de dépôt</th>
                                            <th class="px-2 md:px-4 py-2 border border-blue-400">Date de retrait</th>
                                            <th class="px-2 md:px-4 py-2 border border-blue-400">Total</th>
                                            <th class="px-2 md:px-4 py-2 border border-blue-400">Statut</th>
                                            <th class="px-2 md:px-4 py-2 border border-blue-400">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($dernieresCommandes as $commande)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-2 md:px-4 py-2 border">{{ $commande->numero }}</td>
                                                <td class="px-2 md:px-4 py-2 border">{{ $commande->client }}</td>
                                                <td class="px-2 md:px-4 py-2 border">{{ $commande->created_at->format('d/m/Y') }}</td>
                                                <td class="px-2 md:px-4 py-2 border">{{ $commande->date_retrait ? \Carbon\Carbon::parse($commande->date_retrait)->format('d/m/Y') : '-' }}</td>
                                                <td class="px-2 md:px-4 py-2 border">{{ number_format($commande->total, 2, ',', ' ') }} FCFA</td>
                                                <td class="px-2 md:px-4 py-2 border">
                                                    <span class="px-2 py-1 text-sm font-semibold rounded-full
                                                        @if($commande->statut === 'Non retirée') bg-yellow-100 text-yellow-800
                                                        @elseif($commande->statut === 'Retirée') bg-green-100 text-green-800
                                                        @elseif($commande->statut === 'Partiellement payé') bg-blue-100 text-blue-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                                                        {{ $commande->statut }}
                                                    </span>
                                                </td>
                                                <td class="px-2 md:px-4 py-2 border">
                                                    <a href="{{ route('commandesAdmin.show', $commande->id) }}"
                                                       class="px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                                        Voir
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-4 py-2 text-center text-gray-500 border">
                                                    Aucune commande récente
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Informations de l'utilisateur et de l'agence -->
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Informations de l'utilisateur -->
                        @if (auth()->check())
                            <div class="p-6 bg-white rounded-lg shadow-lg">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-bold text-gray-800">Informations de l'utilisateur</h3>
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-500 text-xl"></i>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-user-tag text-blue-500"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Nom</p>
                                            <p class="text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-envelope text-blue-500"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Email</p>
                                            <p class="text-lg font-semibold text-gray-800">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif

                        <!-- Détails de l'agence -->
                        @if(auth()->user()->agence)
                            <div class="p-6 bg-white rounded-lg shadow-lg">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-bold text-gray-800">Détails de l'agence</h3>
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-building text-green-500 text-xl"></i>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-store text-green-500"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Nom de l'agence</p>
                                            <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->agence->nom }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center mr-4">
                                            <i class="fas fa-map-marker-alt text-green-500"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Adresse</p>
                                            <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->agence->adresse }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- /.container-fluid -->

            <!-- Footer -->
            <footer class="mt-56 bg-white sticky-footer">
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


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('dashboard-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('dashboard-assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('dashboard-assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('dashboard-assets/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('dashboard-assets/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/demo/chart-pie-demo.js') }}"></script>

</body>

</html>
