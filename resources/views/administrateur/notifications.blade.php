<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cica - Administration - Notifications</title>
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
            <a class="font-bold sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('administration') }}">
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

                <!-- Nav Item - Factures -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('facturesAdmin') }}">
                        <i class="fas fa-fw fa-file-invoice"></i>
                        <span class="font-weight-bold">FACTURES</span>
                    </a>
                </li>

                <!-- Nav Item - Notifications -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('notificationsAdmin') }}">
                        <i class="fas fa-fw fa-history"></i>
                        <span class="font-weight-bold">NOTIFICATIONS</span>
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

                    <h3 class="text-xl font-bold text-gray-800">Administration - Notifications</h3>

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
                <div class="container-fluid px-4 mb-5">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Historique des Modifications</h1>
                        <a href="{{ route('facturesAdmin') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-file-invoice fa-sm text-white-50"></i> Retour aux Factures
                        </a>
                    </div>

                    <!-- Liste des notifications -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Historique des Modifications de Factures</h3>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date/Heure
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Utilisateur
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Facture
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Détails
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($notifications as $notification)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $notification->created_at->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full" src="{{ asset('images/image4.jpg') }}" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $notification->user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $notification->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Facture #{{ $notification->commande->numero }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Client: {{ $notification->commande->client }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($notification->action == 'modification') bg-blue-100 text-blue-800
                                                    @elseif($notification->action == 'suppression') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst($notification->action) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <div class="max-w-xs">
                                                    @if($notification->action == 'modification')
                                                        <div class="text-sm">
                                                            <strong>Champs modifiés:</strong>
                                                        </div>
                                                        @if($notification->changes)
                                                            @php
                                                                $changes = json_decode($notification->changes, true);
                                                            @endphp
                                                            @if(is_array($changes))
                                                                <ul class="mt-1 text-xs text-gray-600 list-disc list-inside">
                                                                    @foreach($changes as $field => $values)
                                                                        @if(isset($values['old']) && isset($values['new']))
                                                                            <li>
                                                                                <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong>
                                                                                <span class="line-through text-red-600">{{ $values['old'] }}</span>
                                                                                →
                                                                                <span class="text-green-600">{{ $values['new'] }}</span>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <div class="text-xs text-gray-500 mt-1">
                                                                    {{ $changes }}
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="text-xs text-gray-500 mt-1">
                                                                Aucun détail disponible
                                                            </div>
                                                        @endif
                                                    @elseif($notification->action == 'suppression')
                                                        <div class="text-sm text-red-600">
                                                            <i class="fas fa-trash mr-1"></i>
                                                            Facture supprimée définitivement
                                                        </div>
                                                        @if($notification->changes)
                                                            @php
                                                                $changes = json_decode($notification->changes, true);
                                                            @endphp
                                                            @if(is_array($changes) && isset($changes['message']))
                                                                <div class="text-xs text-gray-600 mt-1">
                                                                    {{ $changes['message'] }}
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                Aucune notification trouvée
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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