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
        <nav class="flex justify-end space-x-4">
            <a href="{{ url('/') }}"
                class="rounded-md bg-sky-500 px-4 py-2 text-white ring-1 ring-transparent transition hover:bg-sky-600 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-300">
                Accueil
            </a>
        </nav>
    </header>

    <main class="container mx-auto px-4 pb-20">
        <div class="max-w-md mx-auto">
            <div class="p-8 text-center rounded-lg shadow-lg bg-sky-200/10 backdrop-blur-sm">
                <h1 class="mb-8 text-3xl font-black text-white">
                    Connexion à <span class="text-sky-300">Cica</span>
                </h1>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-4 text-sm text-white bg-green-500/80 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-sky-300 mb-2">
                            Identifiant
                        </label>
                        <input id="email"
                               class="w-full px-4 py-3 border border-sky-300/30 rounded-lg bg-white/10 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent backdrop-blur-sm"
                               type="text"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="Email, nom ou téléphone">
                        @error('email')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-sky-300 mb-2">
                            Mot de passe
                        </label>
                        <input id="password"
                               class="w-full px-4 py-3 border border-sky-300/30 rounded-lg bg-white/10 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-sky-300 focus:border-transparent backdrop-blur-sm"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="Votre mot de passe">
                        @error('password')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-center mt-6">
                        <button type="submit"
                                class="w-full px-6 py-3 font-bold text-white bg-sky-500 rounded-lg ring-1 ring-transparent transition hover:bg-sky-600 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-300">
                            Se connecter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="fixed bottom-0 w-full p-2 text-xs font-semibold text-center text-white bg-sky-700 backdrop-blur-md shadow-lg tracking-wide" style="font-family: 'Montserrat', sans-serif;">
        <span class="text-white font-weight-bold">
            Developed by <span class="text-sky-300">Ray Ague</span>
        </span>
        <br>
        <small class="text-white">
            Project Manager and Business Development Analyst: <span class="text-sky-300 font-weight-bold">Abdalah KH AGUESSY-VOGNON</span>
        </small>
    </footer>

</body>

</html>
