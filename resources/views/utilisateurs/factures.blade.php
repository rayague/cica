<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cica - Factures</title>
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
                <li class="bg-yellow-500 nav-item">
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

                    <h3 class="text-xl font-bold text-gray-800">Factures</h3>

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
                        <h1 class="h3 mb-0 text-gray-800">Liste des Factures</h1>
                        <div class="text-sm text-gray-500">
                            Total: {{ $factures->count() }} factures
            </div>
        </div>

                    <!-- Liste des factures -->
                    <div class="bg-white rounded-lg shadow-lg mb-6">
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-bold text-gray-800">
                                    <i class="fas fa-file-invoice mr-2 text-blue-600"></i>
                                    Toutes les factures
                                </h3>
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    {{ $factures->count() }} facture(s) au total
            </div>
            </div>
        </div>
                        <div class="p-6">
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse table-auto">
                                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                                        <tr>
                                            <th class="px-4 py-3 text-left border-b border-blue-500 font-semibold">
                                                <i class="fas fa-hashtag mr-2"></i>Numéro
                                            </th>
                                            <th class="px-4 py-3 text-left border-b border-blue-500 font-semibold">
                                                <i class="fas fa-user mr-2"></i>Client
                                            </th>
                                            <th class="px-4 py-3 text-left border-b border-blue-500 font-semibold">
                                                <i class="fas fa-clock mr-2"></i>Créée le
                                            </th>
                                            <th class="px-4 py-3 text-center border-b border-blue-500 font-semibold">
                                                <i class="fas fa-cogs mr-2"></i>Actions
                                            </th>
                </tr>
            </thead>
                                    <tbody class="bg-white">
                                        @forelse ($factures as $facture)
                                            <tr class="hover:bg-blue-50 transition-all duration-200 border-b border-gray-100">
                                                <td class="px-4 py-4 font-semibold text-blue-600">
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">
                                                        {{ $facture->numero }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="font-medium text-gray-900">{{ $facture->client }}</div>
                                                    @if($facture->numero_whatsapp)
                                                        <div class="text-sm text-gray-500">
                                                            <i class="fab fa-whatsapp mr-1 text-green-500"></i>
                                                            {{ $facture->numero_whatsapp }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="text-gray-900">
                                                        <i class="fas fa-calendar mr-1 text-purple-500"></i>
                                                        {{ \Carbon\Carbon::parse($facture->created_at)->format('d/m/Y') }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($facture->created_at)->format('H:i') }}
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <a href="{{ route('factures.edit', $facture->id) }}"
                                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200"
                                                            title="Modifier la facture">
                                                            <i class="fas fa-edit mr-1"></i>
                                                            Modifier
                                                        </a>
                                                        @if(Auth::user()->is_admin)
                                                        <button onclick="deleteFacture({{ $facture->id }})"
                                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors duration-200"
                                                            title="Supprimer la facture">
                                                            <i class="fas fa-trash mr-1"></i>
                                                            Supprimer
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-12 text-center">
                                                    <div class="flex flex-col items-center justify-center">
                                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                            <i class="fas fa-file-invoice text-3xl text-gray-400"></i>
                                                        </div>
                                                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Aucune facture trouvée</h3>
                                                        <p class="text-gray-500">Les factures apparaîtront ici une fois créées</p>
                                                    </div>
                                                </td>
                    </tr>
                                        @endforelse
            </tbody>
        </table>
                            </div>
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
    </div>

    <!-- Modal de déconnexion -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
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

    <!-- Scripts -->
    <script src="{{ asset('dashboard-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Script pour supprimer les factures -->
    <script>
        function deleteFacture(factureId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette facture ? Cette action est irréversible.')) {
                // Créer un formulaire temporaire pour la suppression
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/commandes/${factureId}/delete`;

                // Ajouter le token CSRF
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Ajouter la méthode DELETE
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                // Soumettre le formulaire
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
