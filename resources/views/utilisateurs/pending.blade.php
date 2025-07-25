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
                <li class="bg-yellow-500 nav-item">
                    <a class="nav-link" href="{{ route('pending') }}">
                        <i class="fas fa-fw fa-clock"></i>
                        <span class="font-weight-bold">EN ATTENTE</span>
                    </a>
                </li>



                <!-- Nav Item - Profil -->
                <li class="nav-item">
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

                    <h3 class="text-xl font-bold text-gray-800">En attente </h3>
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
                    <!-- Affichage des erreurs -->
                    @if ($errors->any())
                        <div class="p-4 mb-6 text-red-700 bg-red-100 border-l-4 border-red-500 rounded shadow">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    <h1 class="mb-6 text-3xl font-bold text-gray-800 flex items-center justify-between">
                        @php
                            $date_debut = request('date_debut', today()->toDateString());
                            $date_fin = request('date_fin', today()->toDateString());
                            $periode = $date_debut === $date_fin ? "pour le " . \Carbon\Carbon::parse($date_debut)->format('d/m/Y') : "du " . \Carbon\Carbon::parse($date_debut)->format('d/m/Y') . " au " . \Carbon\Carbon::parse($date_fin)->format('d/m/Y');
                        @endphp
                        Commandes en attente {{ $periode }}
                        <a href="{{ route('listeCommandesPending.print', ['date_debut' => $date_debut, 'date_fin' => $date_fin]) }}" target="_blank" class="ml-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold text-sm">
                            🖨️ Imprimer les factures en attente
                        </a>
                    </h1>
                    <div class="space-y-8">
                        <!-- Formulaire de filtre -->
                        <form method="GET" action="{{ route('commandes.filtrerPending') }}"
                            class="p-4 mb-6 bg-white rounded-lg shadow">
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

                        <div class="space-y-8">
                            <!-- Tableau des retraits d'aujourd'hui -->
                            <div class="p-6 rounded-lg shadow-sm bg-blue-50">
                                <h2 class="pb-2 mb-4 text-2xl font-bold text-blue-800 border-b-2 border-blue-300">
                                    📅 Retraits prévus {{ $periode }}
                                </h2>

                                @if ($commandes->whereBetween('date_retrait', [$date_debut, $date_fin])->isEmpty())
                                    <div class="p-4 text-center bg-white rounded-md">
                                        <p class="text-gray-600">Aucun retrait prévu {{ $periode }}</p>
                                    </div>
                                @else
                                    <div class="overflow-x-auto rounded-lg shadow">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-blue-600">
                                                <tr>
                                                    <th
                                                        class="px-4 py-3 text-sm font-semibold text-left text-white uppercase">
                                                        N° Commande</th>
                                                    <th
                                                        class="px-4 py-3 text-sm font-semibold text-left text-white uppercase">
                                                        Client</th>
                                                    <th
                                                        class="px-4 py-3 text-sm font-semibold text-left text-white uppercase">
                                                        Heure retrait</th>
                                                    <th
                                                        class="px-4 py-3 text-sm font-semibold text-left text-white uppercase">
                                                        Montant</th>
                                                    <th
                                                        class="px-4 py-3 text-sm font-semibold text-left text-white uppercase">
                                                        Statut</th>
                                                    <th
                                                        class="px-4 py-3 text-sm font-semibold text-center text-white uppercase">
                                                        Actions</th>
                                                    <!-- Nouvelle colonne Rappeler -->
                                                    <th
                                                        class="px-4 py-3 text-sm font-semibold text-center text-white uppercase">
                                                        Rappeler</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($commandes->whereBetween('date_retrait', [$date_debut, $date_fin]) as $commande)
                                                    <tr class="transition-colors hover:bg-blue-50">
                                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                            {{ $commande->numero }}
                                                        </td>
                                                        <td class="px-4 py-3 text-sm text-gray-600">
                                                            {{ $commande->client }}
                                                        </td>
                                                        <td class="px-4 py-3 text-sm text-gray-600">
                                                            {{ \Carbon\Carbon::parse($commande->heure_retrait)->format('H:i') }}
                                                        </td>
                                                        <td class="px-4 py-3 text-sm font-semibold text-blue-600">
                                                            {{ number_format($commande->total, 2, ',', ' ') }} FCFA
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                                {{ $commande->statut === 'Validée'
                                                                    ? 'bg-green-100 text-green-800'
                                                                    : ($commande->statut === 'Non retirée'
                                                                        ? 'bg-red-100 text-red-800'
                                                                        : 'bg-gray-100 text-gray-800') }}">
                                                                {{ $commande->statut }}
                                                            </span>
                                                        </td>
                                                        <td class="px-4 py-3 text-center">
                                                            <a href="{{ route('commandes.show', $commande->id) }}"
                                                                class="text-blue-600 transition-colors hover:text-blue-900">
                                                                <svg class="inline w-5 h-5" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                Voir Plus
                                                            </a>
                                                        </td>
                                                        <!-- Nouvelle colonne Rappeler -->
                                                        <td class="px-4 py-3 text-center">
                                                            @php
                                                                $whatsappNumber = $commande->numero_whatsapp;
                                                                $message = rawurlencode(
                                                                    "Bonjour M./Mme " . ($commande->client ?? '') . ",\n\n" .
                                                                    "Votre commande du " . \Carbon\Carbon::parse($commande->date_depot)->format('d/m/Y') . " (facture n° " . str_pad($commande->id, 4, '0', STR_PAD_LEFT) . ") est déjà prête !\nVous pouvez passer pour le retrait à tout moment.\n\n" .
                                                                    "📄 Pour consulter ou télécharger cette facture (et toutes les autres), rendez-vous sur :\n" .
                                                                    "👉 https://mesfactures.cicanoblessepressing.com/\n" .
                                                                    "(Accès rapide avec votre numéro de téléphone.)\n\n" .
                                                                    "⚠️ Important : Passé un délai de 2 mois  après la date prévue de retrait,\nCICA NOBLESSE PRESSING ne pourra être tenu responsable d’éventuels désagréments, pertes ou altérations concernant les vêtements non retirés.\n\n" .
                                                                    "Merci d’avoir choisi CICA NOBLESSE PRESSING.\nNous restons à votre disposition pour toute demande complémentaire !"
                                                                );
                                                            @endphp
                                                            @if ($whatsappNumber)
                                                                <a href="https://api.whatsapp.com/send?phone=229{{ ltrim(preg_replace('/[^0-9]/', '', $whatsappNumber), '0') }}&text={{ $message }}" target="_blank" class="px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                                                                    Rappeler
                                                                </a>
                                                            @else
                                                                <span class="text-gray-500">Pas de Numéro</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <!-- Bouton "Retrait" (commenté dans le code d'origine) -->
                            {{--
                            <div class="flex justify-end mt-4">
                                <a href="{{ route('commandes.retraitPending') }}" class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                                    ➕ Effectuer un Retrait
                                </a>
                            </div>
                            --}}
                        </div>


                    </div>
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
