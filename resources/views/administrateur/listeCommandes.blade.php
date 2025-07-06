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
                <li class=" nav-item">
                    <a class="nav-link" href="{{ route('creationObjets') }}">
                        <i class="fas fa-fw fa-plus-square"></i>
                        <span class="font-weight-bold">CRÉER OBJETS & PRIX</span>
                    </a>
                </li>

                <!-- Nav Item - Commandes -->
                <li class=" nav-item">
                    <a class="nav-link" href="{{ route('commandesAdmin') }}">
                        <i class="fas fa-fw fa-shopping-cart"></i>
                        <span class="font-weight-bold">COMMANDES</span>
                    </a>
                </li>

                <!-- Nav Item - Profil -->
                <li class="bg-yellow-500 nav-item ">
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
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('rappelsAdmin') }}">
                        <i class="fas fa-fw fa-bell"></i>
                        <span class="font-weight-bold">RETRAITS</span>
                    </a>
                </li>

                <!-- Nav Item - Utilisateurs -->
                <li class="nav-item ">
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
                <!-- Begin Page Content -->
                <div class="container-fluid">

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

                    <h2 class="mb-4 text-2xl font-bold text-blue-700">Liste des Factures Journalières</h2>

                    <!-- Filtre par date -->
                    <div class="mb-6">
                        <form action="{{ route('commandesAdmin.journalieres') }}" method="GET"
                            class="flex flex-col gap-4 md:flex-row md:items-center md:space-x-4">
                            <div class="flex flex-col gap-2 md:flex-row md:items-center">
                                <label for="start_date" class="font-semibold text-gray-600">Du :</label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ old('start_date', request('start_date')) }}" required
                                    class="px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    max="{{ now()->toDateString() }}">
                            </div>

                            <div class="flex flex-col gap-2 md:flex-row md:items-center">
                                <label for="end_date" class="font-semibold text-gray-600">Au :</label>
                                <input type="date" name="end_date" id="end_date"
                                    value="{{ old('end_date', request('end_date') ?? now()->toDateString()) }}"
                                    class="px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    max="{{ now()->toDateString() }}">
                            </div>

                            <button type="submit"
                                class="self-start px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Filtrer
                            </button>
                        </form>
                    </div>
                    <div class="mb-6">
                        <form method="GET" action="{{ route('commandesAdmin.recherche') }}" class="mb-4">
                            <div class="flex items-center gap-2">
                                <input type="text" name="client" placeholder="Rechercher un client..."
                                    class="px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ request('client') }}">
                                <button type="submit"
                                    class="px-4 py-2 font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                                    Rechercher
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                        <table class="w-full border border-blue-400 rounded-lg overflow-hidden">
                            <thead class="text-white bg-blue-600">
                                <tr>
                                    <th class="px-6 py-3 border-b-2 border-blue-400 text-left">Numéro</th>
                                    <th class="px-6 py-3 border-b-2 border-blue-400 text-left">Client</th>
                                    <th class="px-6 py-3 border-b-2 border-blue-400 text-left">Date de Dépôt</th>
                                    <th class="px-6 py-3 border-b-2 border-blue-400 text-left">Date de Retrait</th>
                                    <th class="px-6 py-3 border-b-2 border-blue-400 text-left">Total</th>
                                    <th class="px-6 py-3 border-b-2 border-blue-400 text-left">Statut</th>
                                    <th class="px-6 py-3 border-b-2 border-blue-400 text-center">Voir</th>
                                    <th class="px-6 py-3 border-b-2 border-blue-400 text-center">Notifier</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($commandes as $commande)
                                    <tr class="{{ $loop->even ? 'bg-blue-50' : 'bg-white' }} hover:bg-blue-100 transition-colors">
                                        <td class="px-6 py-3 border-b border-blue-200">{{ $commande->numero }}</td>
                                        <td class="px-6 py-3 border-b border-blue-200">{{ $commande->client }}</td>
                                        <td class="px-6 py-3 border-b border-blue-200">
                                            {{ \Carbon\Carbon::parse($commande->date_depot)->locale('fr')->isoFormat('LL') }}
                                        </td>
                                        <td class="px-6 py-3 border-b border-blue-200">
                                            {{ \Carbon\Carbon::parse($commande->date_retrait)->locale('fr')->isoFormat('LL') }}
                                        </td>
                                        <td class="px-6 py-3 border-b border-blue-200">
                                            {{ number_format($commande->total, 2, ',', ' ') }} FCFA
                                        </td>
                                        <td class="px-6 py-3 border-b border-blue-200">
                                            <span class="px-2 items-center justify-center flex py-1 text-white rounded-md {{
                                                $commande->statut === 'En route' ? 'bg-yellow-500' :
                                                ($commande->statut === 'Retiré' ? 'bg-red-500' : 'bg-green-500')
                                            }}">
                                                {{ $commande->statut }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 border-b border-blue-200 text-center">
                                            <a href="{{ route('commandesAdmin.show', $commande->id) }}"
                                                class="p-2 font-semibold text-white bg-green-500 rounded hover:bg-green-700">
                                                Voir
                                            </a>
                                        </td>
                                        <td class="px-6 py-3 border-b border-blue-200 text-center">
                                            <a href="https://wa.me/{{ ltrim(preg_replace('/[^0-9]/', '', $commande->numero_whatsapp), '0') }}?text={{ urlencode('Bonjour ' . $commande->client . ",\nVotre commande N°" . $commande->numero . " est déjà prête et vous attend chez CICA NOBLESSE PRESSING. Vous pouvez passer la retirer dès maintenant. Merci et à bientôt !") }}"
                                                target="_blank"
                                                class="p-2 font-semibold text-white bg-orange-500 rounded hover:bg-orange-700"
                                                title="Notifier le client sur WhatsApp">
                                                Notifier
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                            Aucune facture enregistrée aujourd'hui.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>




                    <div class="flex items-center justify-between my-6">
                        <!-- Bouton d'impression -->
                        <a href="{{ route('commandesAdmin') }}"
                            class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-green-700">
                            Créer une nouvelle commande
                        </a>

                        <div class="text-gray-600">
                            <p><strong>{{ $commandes->count() }}</strong> factures affichées</p>
                        </div>

                    </div>
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



    <script>
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
    </script>
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
