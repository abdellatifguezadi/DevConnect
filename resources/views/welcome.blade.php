<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevConnect - Réseau Social pour Développeurs</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fira-code:400,600|instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .code-bg {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400' viewBox='0 0 800 800'%3E%3Cg fill='none' stroke='%23e2e2e2' stroke-width='1'%3E%3Cpath d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63'/%3E%3Cpath d='M-31 229L237 261 390 382 603 493 308.5 537.5 101.5 381.5M370 905L295 764'/%3E%3Cpath d='M520 660L578 842 731 737 840 599 603 493 520 660 295 764 309 538 390 382 539 269 769 229 577.5 41.5 370 105 295 -36 126.5 79.5 237 261 102 382 40 599 -69 737 127 880'/%3E%3Cpath d='M520-140L578.5 42.5 731-63M603 493L539 269 237 261 370 105M902 382L539 269M390 382L102 382'/%3E%3Cpath d='M-222 42L126.5 79.5 370 105 539 269 577.5 41.5 927 80 769 229 902 382 603 493 731 737M295-36L577.5 41.5M578 842L295 764M40-201L127 80M102 382L-261 269'/%3E%3C/g%3E%3Cg fill='%23e4e4e4'%3E%3Ccircle cx='769' cy='229' r='5'/%3E%3Ccircle cx='539' cy='269' r='5'/%3E%3Ccircle cx='603' cy='493' r='5'/%3E%3Ccircle cx='731' cy='737' r='5'/%3E%3Ccircle cx='520' cy='660' r='5'/%3E%3Ccircle cx='309' cy='538' r='5'/%3E%3Ccircle cx='295' cy='764' r='5'/%3E%3Ccircle cx='40' cy='599' r='5'/%3E%3Ccircle cx='102' cy='382' r='5'/%3E%3Ccircle cx='127' cy='80' r='5'/%3E%3Ccircle cx='370' cy='105' r='5'/%3E%3Ccircle cx='578' cy='42' r='5'/%3E%3Ccircle cx='237' cy='261' r='5'/%3E%3Ccircle cx='390' cy='382' r='5'/%3E%3C/g%3E%3C/svg%3E");
        }

        .syntax-highlight {
            font-family: 'Fira Code', monospace;
            position: relative;
            overflow: hidden;
        }

        .syntax-highlight::before {
            content: "1\A2\A3\A4\A5\A6\A7\A8\A9\A10";
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            color: #6b7280;
            white-space: pre;
            padding: 1rem 0.5rem 1rem 0;
            background-color: rgba(15, 23, 42, 0.8);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            text-align: right;
            user-select: none;
        }

        .dark .syntax-highlight::before {
            background-color: rgba(15, 23, 42, 0.3);
        }

        .syntax-content {
            padding-left: 3.5rem;
            overflow-x: auto;
        }

        .text-gradient {
            background: linear-gradient(to right, #4f46e5, #8b5cf6, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-gradient {
            background: linear-gradient(to right, #4f46e5, #8b5cf6);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(to right, #4338ca, #7c3aed);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }
    </style>
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Header Section -->
    <header class="relative bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">Dev<span class="text-gray-800 dark:text-white">Connect</span></h1>
            </div>

            <div>
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                    Dashboard
                </a>
                @else
                <div class="flex space-x-4 items-center">
                    <a href="{{ route('login') }}" class="relative inline-block py-2.5 px-5 text-gray-700 dark:text-white font-medium overflow-hidden bg-transparent border border-indigo-400 rounded-md transition hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-indigo-600">
                        <span class="relative">Se connecter</span>
                    </a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="relative inline-block py-2.5 px-5 text-white font-medium overflow-hidden bg-indigo-500 rounded-md shadow-md transition-all duration-300 hover:shadow-lg hover:bg-indigo-600 hover:scale-105">
                        <span class="relative">S'inscrire</span>
                    </a>
                    @endif
                </div>
                @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-white dark:bg-gray-800 pt-8 pb-16 md:pb-24">
        <div class="code-bg absolute inset-0 opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Connectez-vous avec des <span class="text-gradient">développeurs</span> passionnés
                    </h2>
                    <p class="mt-6 text-lg text-gray-600 dark:text-gray-300">
                        DevConnect est une plateforme conçue pour les développeurs qui souhaitent partager leur code, leurs connaissances et se connecter avec d'autres professionnels du développement.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        @guest
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('register') }}" class="relative inline-block py-3 px-8 text-white font-medium overflow-hidden bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:scale-105">
                                <span class="relative">Rejoindre la communauté</span>
                            </a>
                            <a href="{{ route('login') }}" class="relative inline-block py-3 px-8 font-medium overflow-hidden bg-white dark:bg-gray-800 border border-indigo-300 dark:border-indigo-700 rounded-lg shadow-sm transition hover:shadow-md hover:border-indigo-500">
                                <span class="relative bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-500">Se connecter</span>
                            </a>
                        </div>
                        @else
                        <a href="{{ url('/dashboard') }}" class="relative inline-block py-3 px-8 text-white font-medium overflow-hidden bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:scale-105">
                            <span class="relative">Accéder à mon tableau de bord</span>
                        </a>
                        @endguest
                    </div>
                </div>

                <div class="syntax-highlight bg-slate-900 text-white rounded-lg p-4 shadow-xl">
                    <div class="syntax-content">
                        <pre><code><span class="text-purple-400">class</span> <span class="text-yellow-300">DevConnect</span> {
  <span class="text-purple-400">constructor</span>() {
    <span class="text-blue-300">this</span>.<span class="text-green-300">developers</span> = [];
    <span class="text-blue-300">this</span>.<span class="text-green-300">technologies</span> = [<span class="text-orange-300">"JavaScript"</span>, <span class="text-orange-300">"PHP"</span>, <span class="text-orange-300">"Python"</span>];
    <span class="text-blue-300">this</span>.<span class="text-green-300">connections</span> = <span class="text-blue-400">0</span>;
  }
    
  <span class="text-purple-400">connect</span>(<span class="text-blue-400">developer</span>) {
    <span class="text-blue-300">this</span>.<span class="text-green-300">developers</span>.push(<span class="text-blue-400">developer</span>);
    <span class="text-blue-300">this</span>.<span class="text-green-300">connections</span>++;
    <span class="text-purple-400">return</span> <span class="text-orange-300">"Bienvenue sur DevConnect!"</span>;
  }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-gray-100 dark:bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Pourquoi rejoindre DevConnect</h2>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Partagez votre code</h3>
                    <p class="mt-3 text-gray-600 dark:text-gray-300">Publiez des extraits de code, posez des questions techniques et obtenez des retours d'autres développeurs.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Construisez votre réseau</h3>
                    <p class="mt-3 text-gray-600 dark:text-gray-300">Connectez-vous avec des développeurs qui partagent vos intérêts et élargissez votre réseau professionnel.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Améliorez vos compétences</h3>
                    <p class="mt-3 text-gray-600 dark:text-gray-300">Développez vos compétences techniques en interagissant avec d'autres professionnels et en découvrant de nouvelles technologies.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-indigo-600 text-white py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-3xl font-bold mb-6">Prêt à rejoindre la communauté ?</h2>
            <p class="text-lg mb-8">Créez un compte dès maintenant et commencez à partager vos connaissances et à vous connecter avec d'autres développeurs.</p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-white text-indigo-600 font-medium rounded-lg shadow-md hover:bg-gray-100 hover:shadow-lg transition-all">
                Créer un compte gratuitement
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid gap-8 md:grid-cols-2">
            <div>
                <h2 class="text-2xl font-bold text-white mb-4">DevConnect</h2>
                <p class="mb-4">Un réseau social exclusivement pour développeurs.</p>
                <p>&copy; {{ date('Y') }} DevConnect. Tous droits réservés.</p>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-3">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-indigo-400">Accueil</a></li>
                        <li><a href="#" class="hover:text-indigo-400">À propos</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Confidentialité</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Conditions d'utilisation</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-3">Communauté</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-indigo-400">GitHub</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Twitter</a></li>
                        <li><a href="#" class="hover:text-indigo-400">Discord</a></li>
                        <li><a href="#" class="hover:text-indigo-400">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>