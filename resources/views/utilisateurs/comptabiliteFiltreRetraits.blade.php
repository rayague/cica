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
                {{-- {{ route('acceuil') }} --}}
                ">

                <div class="mx-3 sidebar-brand-text">Cica</div>
            </a>

            <!-- Divider -->
            <hr class="my-0 sidebar-divider">

            <nav class="text-white bg-gray-800 sidebar">
                <!-- Nav Item - Tableau de Bord -->
                <li class="nav-item">
                    <a class="nav-link" href="
                    {{ route('acceuil') }}
                    ">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="font-weight-bold">TABLEAU DE BORD</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Nav Item - Accueil -->
                <li class=" nav-item">
                    <a class="nav-link" href="

                    {{ route('acceuil') }}

                    ">
                        <i class="fas fa-fw fa-home"></i>
                        <span class="font-weight-bold">ACCUEIL</span>
                    </a>
                </li>


                <!-- Nav Item - Commandes -->
                <li class="nav-item">
                    <a class="nav-link" href="

                    {{ route('commandes') }}

                    ">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                        <span class="font-weight-bold">COMMANDES</span>
                    </a>
                </li>

                <!-- Nav Item - Profil -->
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('listeCommandes') }}">
                        <i class="fas fa-fw fa-list"></i>
                        <span class="font-weight-bold">LISTE DES COMMANDES</span>
                    </a>
                </li>

                <!-- Nav Item - Profil -->
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('pending') }}">
                        <i class="fas fa-fw fa-clock"></i>
                        <span class="font-weight-bold">EN ATTENTE</span>
                    </a>
                </li>



                <!-- Nav Item - Profil -->
                <li class="bg-yellow-500 nav-item">
                    <a class="nav-link" href="{{ route('comptabilite') }}">
                        <i class="fas fa-fw fa-coins"></i>
                        <span class="font-weight-bold">COMPTABILITE</span>
                    </a>
                </li>
                <!-- Nav Item - Rappels -->
                <li class="nav-item ">
                    <a class="nav-link" href="

                    {{ route('rappels') }}

                    ">
                        <i class="fas fa-fw fa-bell"></i>
                        <span class="font-weight-bold">RETRAITS</span>
                    </a>
                </li>
                                <!-- Nav Item - Factures -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('factures') }}">
                                        <i class="fas fa-fw fa-file-invoice"></i>
                                        <span class="font-weight-bold">FACTURES</span>
                                    </a>
                                </li>
                <!-- Nav Item - Profil -->
                {{-- <li class="nav-item ">
                    <a class="nav-link" href="
                    {{ route('profil') }}
                    ">
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

                    <h3 class="text-xl font-bold text-gray-800">Comptabilité </h3>
                    <a href="{{ route('listeCommandes.print', ['start_date' => request('date_debut', $date_debut ?? now()->toDateString()), 'end_date' => request('date_fin', $date_fin ?? now()->toDateString())]) }}" target="_blank" class="ml-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold text-sm">
                        Imprimer la liste filtrée
                    </a>
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

                <div class="container p-6 mx-auto">
                    <!-- Affichage des erreurs -->
                    @if ($errors->any())
                        <div class="p-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Section du filtre de la période -->
                    <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-700">Filtrer par Période</h2>
                        <form method="GET" action="{{ route('commandes.filtrerComptabilite') }}" class="">
                            <div class="flex flex-row items-center space-x-4">
                                <div>
                                    <label for="date_debut" class="block text-gray-700">Date de Début</label>
                                    <input type="date" name="date_debut" id="date_debut"
                                        value="{{ $date_debut ?? '' }}" class="p-2 border border-gray-300 rounded"
                                        required>
                                </div>
                                <div>
                                    <label for="date_fin" class="block text-gray-700">Date de Fin</label>
                                    <input type="date" name="date_fin" id="date_fin"
                                        value="{{ $date_fin ?? '' }}" class="p-2 border border-gray-300 rounded">
                                </div>
                                <button type="submit"
                                    class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">Filtrer</button>
                            </div>
                        </form>
                    </div>


                    <!-- Section des paiements filtrés -->
                    <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-700">Historique des Paiements</h2>
                        @if ($payments->isNotEmpty())
                            <table class="min-w-full border-collapse bg-gray-50">
                                <thead>
                                    <tr class="text-white bg-green-500">
                                        <th class="px-4 py-2 border border-green-400">Numéro de Facture</th>
                                        <th class="px-4 py-2 border border-green-400">Utilisateur</th>
                                        <th class="px-4 py-2 border border-green-400">Montant</th>
                                        <th class="px-4 py-2 border border-green-400">Moyen de Paiement</th>
                                        <th class="px-4 py-2 border border-green-400">Client</th>
                                        <th class="px-4 py-2 border border-green-400">Action</th>
                                        <th class="px-4 py-2 border border-green-400">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr class="hover:bg-green-50">
                                            <td class="px-4 py-2 border border-green-300">{{ $payment->commande->numero ?? $payment->commande_id }}</td>
                                            <td class="px-4 py-2 border border-green-300">{{ $payment->user->name ?? 'Utilisateur Inconnu' }}</td>
                                            <td class="px-4 py-2 border border-green-300">{{ number_format($payment->amount, 2, ',', ' ') }} F</td>
                                            <td class="px-4 py-2 border border-green-300">
                                                @if($payment->payment_method === 'Validation')
                                                    Validation
                                                @elseif($payment->payment_method === 'Avance initiale')
                                                    {{ $payment->payment_type ?? 'Non spécifié' }}
                                                @elseif(!empty($payment->payment_type))
                                                    {{ $payment->payment_type }}
                                                @else
                                                    Non spécifié
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border border-green-300">{{ $payment->commande->client ?? '' }}</td>
                                            <td class="px-4 py-2 border border-green-300">
                                                @if($payment->payment_method === 'Avance initiale')
                                                    Avance
                                                @else
                                                    {{ $payment->payment_method ?? 'Non spécifié' }}
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border border-green-300">{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Affichage du total des paiements -->
                            <div class="p-4 mt-4 text-lg font-semibold text-right bg-gray-100">
                                <p>Total des paiements : <span
                                        class="font-bold">{{ number_format($montant_total_paiements, 2, ',', ' ') }}
                                        F</span></p>
                            </div>
                        @else
                            <p class="p-3 text-lg font-black text-center text-white bg-orange-400 rounded">Aucun
                                paiement enregistré pour cette période.</p>
                        @endif
                    </div>


                    <!-- Section des notes filtrées -->
                    <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
                        <h2 class="mb-4 text-2xl font-semibold text-gray-700">Historique des Retraits / Notes</h2>
                        @if ($notes->isNotEmpty())
                            <table class="min-w-full border-collapse bg-gray-50">
                                <thead>
                                    <tr class="text-white bg-yellow-500">
                                        <th class="px-4 py-2 border border-yellow-400">Numéro de Facture</th>
                                        <th class="px-4 py-2 border border-yellow-400">Utilisateur</th>
                                        <th class="px-4 py-2 border border-yellow-400">Note</th>
                                        <th class="px-4 py-2 border border-yellow-400">Date</th>
                                        <th class="px-4 py-2 border border-yellow-400">Client</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notes as $note)
                                        <tr class="hover:bg-yellow-50">
                                            <td class="px-4 py-2 border border-yellow-300">{{ $note->commande->numero ?? $note->commande_id }}</td>
                                            <td class="px-4 py-2 border border-yellow-300">{{ $note->user->name ?? 'Utilisateur Inconnu' }}</td>
                                            <td class="px-4 py-2 border border-yellow-300">{{ $note->note }}</td>
                                            <td class="px-4 py-2 border border-yellow-300">{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:i') }}</td>
                                            <td class="px-4 py-2 border border-yellow-300">{{ $note->commande->client ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="p-3 text-lg font-black text-center text-white bg-orange-400 rounded">Aucune note enregistrée pour cette période.</p>
                        @endif
                    </div>

                    <!-- Section des mouvements d'argent -->


                </div>

            </div>






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
