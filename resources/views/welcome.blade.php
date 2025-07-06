<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- TITRE POUR LE SEO -->
    <title>Cica - Service de lavage professionnel par Ray Ague</title>

    <!-- DESCRIPTION LONGUE POUR GOOGLE -->
    <meta name="description"
        content="Cica est un service de lavage professionnel, rapide et efficace, conçu pour faciliter l'entretien de vos vêtements. Développé par Ray Ague, Cica garantit une propreté impeccable avec un service fiable et accessible en ligne. Essayez notre service dès aujourd'hui !">

    <!-- MOTS-CLÉS POUR GOOGLE -->
    <meta name="keywords"
        content="Lavage, pressing, blanchisserie, nettoyage, vêtements, service de lavage, lavage professionnel, Ray Ague, Cica, lessive écologique">

    <!-- NOM DE L'AUTEUR -->
    <meta name="author" content="Ray Ague">

    <!-- GOOGLE INDEXATION -->
    <meta name="robots" content="index, follow">

    <!-- OPEN GRAPH POUR FACEBOOK ET WHATSAPP -->
    <meta property="og:title" content="Cica - Service de lavage par Ray Ague">
    <meta property="og:description"
        content="Besoin d'un service de lavage rapide et efficace ? Cica, développé par Ray Ague, est la solution parfaite !">
    <meta property="og:image" content="{{ asset('images/Cica.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">

    <!-- TWITTER CARD POUR LE PARTAGE SUR TWITTER -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Cica - Lavage Professionnel">
    <meta name="twitter:description"
        content="Ray Ague présente Cica : un service de lavage rapide et fiable pour tous vos vêtements.">
    <meta name="twitter:image" content="{{ asset('images/Cica.png') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/Cica.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Configuration Tailwind personnalisée -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'dancing': ['Dancing Script', 'cursive'],
                    }
                }
            }
        }
    </script>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="w-full overflow-x-hidden font-sans bg-gradient-to-r from-sky-700 to-sky-950">

    <header
        class="flex flex-row justify-between w-11/12 p-2 mx-auto mt-4 mb-10 font-extrabold rounded-md shadow-lg bg-white/10 backdrop-blur-sm">
        <span class="text-2xl italic font-black text-sky-300 font-dancing">Cica</span>
        @if (Route::has('login'))
            <nav class="flex justify-end space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="rounded-md bg-sky-500 px-4 py-2 text-white ring-1 ring-transparent transition hover:bg-sky-600 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-300">
                        Tableau de bord
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-md bg-sky-500 px-4 py-2 text-white ring-1 ring-transparent transition hover:bg-sky-600 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-300">
                        Connexion
                    </a>
                @endauth
            </nav>
        @endif
    </header>

    <div id="custom-toast"
        class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 hidden px-4 py-3 text-center text-white rounded-lg shadow-lg cursor-pointer bg-sky-600/80 backdrop-blur-sm max-w-md">
        ⚠️ Cette application est conçue uniquement pour un usage local. <br />
        📲 Pour en savoir plus ou discuter avec l'auteur, écrivez-lui directement sur
        <a href="https://wa.me/22960932967" target="_blank"
            class="font-semibold text-white underline hover:text-sky-200">
            WhatsApp
        </a> 💬.
    </div>

    <main class="container mx-auto px-4 pb-20">
        <p class="my-8 text-3xl md:text-5xl font-black text-center text-white">
            Découvrez les fonctionnalités de <span class="text-sky-300">Cica</span>
        </p>

        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 max-w-6xl mx-auto">

            <!-- Production des Factures -->
            <div class="flex flex-col p-6 text-center rounded-lg shadow-lg bg-sky-200/10 backdrop-blur-sm hover:bg-sky-200/20 transition-all hover:transform hover:scale-105">
                <div class="mb-4 text-4xl text-sky-300">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <h2 class="mb-4 text-xl font-semibold text-sky-300">Produire les Factures</h2>
                <p class="text-white/90">Générez automatiquement des factures précises pour chaque commande sans erreur,
                    avec tous les détails nécessaires.</p>
            </div>

            <!-- Envoi via WhatsApp -->
            <div class="flex flex-col p-6 text-center rounded-lg shadow-lg bg-sky-200/10 backdrop-blur-sm hover:bg-sky-200/20 transition-all hover:transform hover:scale-105">
                <div class="mb-4 text-4xl text-sky-300">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h2 class="mb-4 text-xl font-semibold text-sky-300">Envoi via WhatsApp</h2>
                <p class="text-white/90">Envoyez chaque facture de manière sécurisée à vos clients via WhatsApp pour un
                    règlement rapide et efficace.</p>
            </div>

            <!-- Gestion des Commandes -->
            <div class="flex flex-col p-6 text-center rounded-lg shadow-lg bg-sky-200/10 backdrop-blur-sm hover:bg-sky-200/20 transition-all hover:transform hover:scale-105">
                <div class="mb-4 text-4xl text-sky-300">
                    <i class="fas fa-tasks"></i>
                </div>
                <h2 class="mb-4 text-xl font-semibold text-sky-300">Gestion des Commandes</h2>
                <p class="text-white/90">Suivez l'état de chaque commande et mettez à jour les
                    informations pour un service impeccable.</p>
            </div>

            <!-- Historique des Transactions -->
            <div class="flex flex-col p-6 text-center rounded-lg shadow-lg bg-sky-200/10 backdrop-blur-sm hover:bg-sky-200/20 transition-all hover:transform hover:scale-105">
                <div class="mb-4 text-4xl text-sky-300">
                    <i class="fas fa-history"></i>
                </div>
                <h2 class="mb-4 text-xl font-semibold text-sky-300">Historique des Transactions</h2>
                <p class="text-white/90">Accédez à l'historique complet de toutes vos commandes et transactions pour une
                    gestion facile et transparente.</p>
            </div>

            <!-- Notifications et Rappels -->
            <div class="flex flex-col p-6 text-center rounded-lg shadow-lg bg-sky-200/10 backdrop-blur-sm hover:bg-sky-200/20 transition-all hover:transform hover:scale-105">
                <div class="mb-4 text-4xl text-sky-300">
                    <i class="fas fa-bell"></i>
                </div>
                <h2 class="mb-4 text-xl font-semibold text-sky-300">Notifications et Rappels</h2>
                <p class="text-white/90">Recevez des notifications et restez
                    informé des mises à jour de commande.</p>
            </div>

            <!-- Support Client -->
            <div class="flex flex-col p-6 text-center rounded-lg shadow-lg bg-sky-200/10 backdrop-blur-sm hover:bg-sky-200/20 transition-all hover:transform hover:scale-105">
                <div class="mb-4 text-4xl text-sky-300">
                    <i class="fas fa-headset"></i>
                </div>
                <h2 class="mb-4 text-xl font-semibold text-sky-300">Support Client 24/7</h2>
                <p class="text-white/90">Bénéficiez d'un support client disponible à tout moment pour répondre à vos questions.</p>
            </div>

        </div>
    </main>

    <footer class="fixed bottom-0 w-full p-2 text-xs font-semibold text-center text-white bg-sky-700 backdrop-blur-md shadow-lg tracking-wide" style="font-family: 'Montserrat', sans-serif;">
            Developed by Ray Ague, with Project Manager and Business Developer Abdalah KH AGUESSY-VOGNON.
    </footer>

    <script>
        function showToast() {
            const toast = document.getElementById('custom-toast');
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 15000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const loginBtn = document.getElementById('login-btn');
            if (loginBtn) {
                loginBtn.addEventListener('click', (e) => {
                    showToast();
                });
            }
        });
    </script>
</body>

</html>
