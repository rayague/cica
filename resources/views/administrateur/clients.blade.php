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
    <link href="{{ asset('dashboard-assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
                <li class="nav-item ">
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
                <li class="nav-item">
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
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('utilisateursAdmin') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span class="font-weight-bold">UTILISATEURS</span>
                    </a>
                </li>
                <!-- Nav Item - Clients -->
                <li class="bg-yellow-500 nav-item ">
                    <a class="nav-link" href="{{ route('clientsAdmin') }}">
                        <i class="fas fa-fw fa-user-friends"></i>
                        <span class="font-weight-bold">CLIENTS</span>
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
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                        </li>
                    </ul>
                </nav>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- Page Heading -->
                    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
                        <h1 class="mb-0 text-gray-800 h3 font-bold">Liste des Clients</h1>
                    </div>
                    <!-- DataTales Example -->
                    <div class="mb-4 card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Clients</h6>
                        </div>
                        <div class="card-body">
                            <!-- Barre de recherche -->
                            <form method="GET" action="{{ route('clientsAdmin') }}" class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 items-center">
                                <input type="text" name="search" value="{{ old('search', $search ?? '') }}" placeholder="Rechercher par nom ou numéro..." class="form-control w-full md:w-64" />
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                            </form>
                            <!-- Liste des clients -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nom du client</th>
                                            <th>Numéro</th>
                                            <th>Mot de passe</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($clients as $client)
                                            <tr>
                                                <td>{{ $client->client }}</td>
                                                <td>{{ $client->numero_whatsapp }}</td>
                                                <td>
                                                    @php
                                                        $commande = \App\Models\Commande::where('client', $client->client)->where('numero_whatsapp', $client->numero_whatsapp)->first();
                                                        $plainPassword = session('plain_password_' . $client->numero_whatsapp);
                                                    @endphp
                                                    <span id="password-value-{{ md5($client->numero_whatsapp) }}">
                                                        @if($plainPassword)
                                                            <span style="font-family:monospace">{{ $plainPassword }}</span>
                                                        @elseif($commande && $commande->password_client)
                                                            <span class="password-hidden" style="font-family:monospace">••••••••</span>
                                                        @else
                                                            Non défini
                                                        @endif
                                                    </span>
                                                    @if($commande && $commande->password_client)
                                                        <button type="button" class="btn btn-link p-0 ml-2" onclick="togglePassword('{{ md5($client->numero_whatsapp) }}', '{{ $plainPassword ? $plainPassword : '' }}')" @if(!$plainPassword) disabled style="opacity:0.5;cursor:not-allowed;" @endif>
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#passwordModal-{{ md5($client->client.$client->numero_whatsapp) }}">
                                                        {{ $commande && $commande->password_client ? 'Modifier' : 'Ajouter' }}
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="passwordModal-{{ md5($client->client.$client->numero_whatsapp) }}" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel-{{ md5($client->client.$client->numero_whatsapp) }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" action="{{ route('clientsAdmin.password', ['numero' => $client->numero_whatsapp]) }}">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="passwordModalLabel-{{ md5($client->client.$client->numero_whatsapp) }}">Définir le mot de passe</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-2">
                                                                            <strong>Nom :</strong> {{ $client->client }}<br>
                                                                            <strong>Numéro :</strong> {{ $client->numero_whatsapp }}
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="password-{{ md5($client->client.$client->numero_whatsapp) }}">Mot de passe</label>
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" id="password-{{ md5($client->client.$client->numero_whatsapp) }}" name="password" value="" required minlength="4" placeholder="Au moins 4 caractères">
                                                                                <div class="input-group-append">
                                                                                    <button class="btn btn-secondary" type="button" onclick="generatePassword('{{ md5($client->client.$client->numero_whatsapp) }}')">Générer</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center">Aucun client trouvé.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <script>
                                function generatePassword(id) {
                                    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                                    let pass = '';
                                    for (let i = 0; i < 8; i++) {
                                        pass += chars.charAt(Math.floor(Math.random() * chars.length));
                                    }
                                    document.getElementById('password-' + id).value = pass;
                                }
                                // Affichage d'un message si le mot de passe est trop court
                                document.addEventListener('DOMContentLoaded', function() {
                                    document.querySelectorAll('form[action*="clients_administration/password"]').forEach(function(form) {
                                        form.addEventListener('submit', function(e) {
                                            var input = form.querySelector('input[name="password"]');
                                            if (input.value.length < 4) {
                                                e.preventDefault();
                                                alert('Le mot de passe doit contenir au moins 4 caractères.');
                                                input.focus();
                                            }
                                        });
                                    });
                                });
                            </script>
                            <script>
                                function togglePassword(id, plain) {
                                    const span = document.getElementById('password-value-' + id);
                                    if (!span) return;
                                    if (span.dataset.visible === 'true') {
                                        span.innerHTML = '<span class="password-hidden" style="font-family:monospace">••••••••</span>';
                                        span.dataset.visible = 'false';
                                    } else {
                                        if (plain) {
                                            span.innerHTML = '<span style="font-family:monospace">' + plain + '</span>';
                                            span.dataset.visible = 'true';
                                        }
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright">
                        <span>Copyright &copy; Cica 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    {{-- <a class="rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> --}}
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prêt à partir ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à mettre fin à votre session en cours.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
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
