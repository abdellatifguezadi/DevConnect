<!-- Navigation -->
@vite('resources/css/app.css')
<nav class="fixed top-0 w-full bg-gray-900 text-white z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo et Recherche -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-400">&lt;DevConnect/&gt;</a>
                <div class="relative">
                    <input type="text" 
                           placeholder="Rechercher des développeurs, des posts..." 
                           class="bg-gray-800 pl-10 pr-4 py-2 rounded-lg w-96 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-700 transition-all duration-200"
                    >
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            
            <!-- Menu de Navigation -->
            <div class="flex items-center space-x-6">
                <!-- Accueil -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 hover:text-blue-400" title="Accueil">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </a>

                <!-- Messages -->
                <a href="#" class="flex items-center space-x-1 hover:text-blue-400 relative" title="Messages">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-blue-500 rounded-full w-2 h-2"></span>
                </a>

                <!-- Notifications -->
                <a href="#" class="flex items-center space-x-1 hover:text-blue-400 relative" title="Notifications">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 rounded-full w-2 h-2"></span>
                </a>

                <!-- Nouveau Post -->
                <button 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200"
                    onclick="// Ajoutez ici la logique pour créer un nouveau post"
                >
                    Nouveau Post
                </button>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2">
                        <div class="h-8 w-8 rounded-full overflow-hidden">
                            <img src="https://avatar.iran.liara.run/public/boy" alt="Profile" class="w-full h-full object-cover"/>
                        </div>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-gray-700">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Mon Profil</a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav> 