<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{ asset('images/Cica.png') }}" type="image/x-icon">


    <title>Cica</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('dashboard-assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

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
                href="{{ route('acceuil') }}">
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
                <li class=" nav-item">
                    <a class="nav-link" href="{{ route('administration') }}">
                        <i class=" fas fa-fw fa-home"></i>
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
                    <a class="nav-link" href="{{ route('commandesAdmin') }}">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                        <span class="font-weight-bold">COMMANDES</span>
                    </a>
                </li>

                <!-- Nav Item - Profil -->
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('listeCommandesAdmin') }}">
                        <i class="fas fa-fw fa-list"></i>
                        <span class="font-weight-bold">LISTE DES COMMANDES</span>
                    </a>
                </li>

                <!-- Nav Item - Profil -->
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('pendingAdmin') }}">
                        <i class="fas fa-fw fa-clock"></i>
                        <span class="font-weight-bold">EN ATTENTE</span>
                    </a>
                </li>



                <!-- Nav Item - Profil -->
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('comptabiliteAdmin') }}">
                        <i class="fas fa-fw fa-coins"></i>
                        <span class="font-weight-bold">COMPTABILITE</span>
                    </a>
                </li>
                <!-- Nav Item - Rappels -->
                <li class="bg-yellow-500 nav-item">
                    <a class="nav-link" href="{{ route('rappelsAdmin') }}">
                        <i class="fas fa-fw fa-bell"></i>
                        <span class="font-weight-bold">RETRAITS</span>
                    </a>
                </li>

                <!-- Nav Item - Utilisateurs -->
                <li class=" nav-item">
                    <a class="nav-link"
                        href="

                                    {{ route('utilisateursAdmin') }}

                                    ">
                        <i class="fas fa-fw fa-users"></i>
                        <span class="font-weight-bold">UTILISATEURS</span>
                    </a>
                </li>

                <!-- Nav Item - Profil -->
                {{-- <li class="nav-item ">
                    <a class="nav-link" href="{{ route('profil') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span class="font-weight-bold">PROFIL</span>
                    </a>
                </li> --}}

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

                    <h3 class="text-xl font-bold text-gray-800 flex items-center justify-between">
                        Rappels
                        <a href="{{ route('admin.rappels.imprimer') }}" target="_blank" class="ml-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold text-sm">
                            🖨️ Imprimer les retraits du jour
                        </a>
                    </h3>
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
                <div class="container p-6 mx-auto">
                    <h1 class="mb-8 text-3xl font-bold text-center text-gray-800">
                        Commandes validées pour aujourd'hui
                    </h1>
                    <!-- Formulaire de filtre -->

                    <div class="p-4 mb-6 space-y-6 bg-white rounded-lg shadow">

                        <form method="GET" action="{{ route('commandes.filtrerRetrait') }}">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date de début</label>
                                    <input type="date" name="date_debut" value="{{ request('date_debut') }}"
                                        class="px-3 py-2 border rounded-lg" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date de fin</label>
                                    <input type="date" name="date_fin"
                                        value="{{ request('date_fin', today()->toDateString()) }}"
                                        class="px-3 py-2 border rounded-lg">
                                </div>
                                <div class="self-end">
                                    <button type="submit"
                                        class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                        Filtrer
                                    </button>
                                </div>
                            </div>
                        </form>


                        <div class="mb-6">
                            <form method="GET" action="{{ route('commandesRetraitAdmin.recherche') }}" class="mb-4">
                                <div class="flex items-center gap-2">
                                    <input type="text" name="client" placeholder="Rechercher un client..."
                                        class="px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        value="{{ request('client') }}" required>
                                    <button type="submit"
                                        class="px-4 py-2 font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                                        Rechercher
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if ($commandes->isEmpty())
                        <div class="p-6 text-center text-gray-600 bg-gray-100 rounded-lg shadow">
                            <p>Aucune commande validée pour aujourd'hui.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($commandes as $commande)
                                <div class="p-6 transition duration-200 bg-white rounded-lg shadow-md hover:shadow-xl">
                                    <h2 class="mb-3 text-xl font-semibold text-gray-700">
                                        Commande #{{ $commande->numero }}
                                    </h2>
                                    <p class="mb-1 text-gray-600">
                                        <span class="font-medium">Client :</span> {{ $commande->client }}
                                    </p>
                                    <p class="mb-1 text-gray-600">
                                        <span class="font-medium">Date de retrait :</span>
                                        {{ \Carbon\Carbon::parse($commande->date_retrait)->locale('fr')->isoFormat('LL') }}
                                    </p>
                                    <p class="mb-4 text-gray-600">
                                        <span class="font-medium">Total :</span>
                                        {{ number_format($commande->total, 2, ',', ' ') }} FCFA
                                    </p>
                                    <div class="text-center space-y-2">
                                        <a href="{{ route('commandesAdmin.show', $commande->id) }}"
                                            class="inline-block px-6 py-2 text-white transition duration-200 bg-blue-500 rounded-md hover:bg-blue-600">
                                            Voir les détails
                                        </a>
                                        <br>
                                        <a href="https://wa.me/{{ ltrim(preg_replace('/[^0-9]/', '', $commande->numero_whatsapp), '0') }}?text={{ urlencode('Bonjour ' . $commande->client . ', merci pour votre confiance ! Votre commande #' . $commande->numero . ' a été retirée avec succès. À bientôt chez CICA NOBLESSE PRESSING !') }}"
                                            target="_blank"
                                            class="inline-block px-6 py-2 text-white transition duration-200 bg-green-500 rounded-md hover:bg-green-600">
                                            <i class="fab fa-whatsapp mr-2"></i> Remercier
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <!-- /.container-fluid -->




            </div>
            <!-- End of Main Content -->

             <!-- Footer -->
             <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <div class="row">
                            <div class="col-12">
                                <span class="text-dark font-weight-bold">
                                    Developed by <span class="text-primary">Ray Ague</span>
                                </span>
                                <br>
                                <small class="text-dark">
                                    Project Manager and Business Development Analyst: <span class="text-primary font-weight-bold">Abdalah KH AGUESSY-VOGNON</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

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
