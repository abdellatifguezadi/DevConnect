<nav class="fixed top-0 w-full bg-gray-900 text-white z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo et Recherche -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-400">&lt;DevConnect/&gt;</a>
                <div class="relative hidden md:block">
                    <input type="text"
                        id="search-input"
                        placeholder="Rechercher des développeurs, des posts..."
                        class="bg-gray-800 pl-10 pr-4 py-2 rounded-lg w-64 lg:w-96 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-700 transition-all duration-200">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <!-- Résultats de recherche -->
                    <div id="search-results" class="absolute mt-1 w-full bg-white rounded-lg shadow-lg z-50 overflow-hidden hidden"></div>
                </div>
            </div>

            <!-- Menu Hamburger pour mobile -->
            <button class="md:hidden text-gray-400 hover:text-white focus:outline-none" id="mobile-menu-button">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Menu de Navigation - Desktop -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Accueil -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 hover:text-blue-400" title="Accueil">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>

                <!-- Messages -->
                <a href="{{ route('chat.index') }}" class="flex items-center space-x-1 hover:text-blue-400 relative" title="Messages">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-blue-500 rounded-full w-2 h-2"></span>
                </a>
<!-- 
                <a href="{{ route('chat.index') }}" class="text-gray-500 hover:text-gray-700">
                    {{-- <span class="sr-only">View messages</span> --}}
                    <i class="fas fa-comment-alt text-xl"></i>
                </a> -->

                <!-- Connexions -->
                <a href="{{ route('connections.index') }}" class="flex items-center space-x-1 hover:text-blue-400" title="Mes connexions">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </a>

                <!-- Offres d'emploi -->
                <a href="{{ route('job-offers.index') }}" class="flex items-center space-x-1 hover:text-blue-400" title="Offres d'emploi">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </a>

                <!-- Demandes de connexion -->
                <a href="{{ route('connections.pending') }}" class="flex items-center space-x-1 hover:text-blue-400 relative" title="Demandes de connexion">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    @php
                    $pendingConnections = auth()->user()->connections()
                    ->where('status', 'pending')
                    ->where('requested_id', auth()->id())
                    ->count();
                    @endphp
                    @if($pendingConnections > 0)
                    <!-- <span class="absolute -top-1 -right-1 bg-red-500 rounded-full w-2 h-2"></span> -->
                    @endif
                </a>

                <!-- Notifications -->
                <div class="relative z-50">
                    <button id="notification-bell-button" class="relative p-1 text-white hover:text-blue-400 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0h-6" />
                        </svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                        <span id="notification-unread-indicator" class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
                        @endif
                    </button>

                    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 transition-all duration-100 text-gray-900">
                        <div class="max-h-96 overflow-y-auto" id="notification-list">
                            <!-- notifications here -->
                        </div>

                        <div id="mark-all-container" class="hidden border-t border-gray-100 mt-2">
                            <button id="mark-all-read" class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-50">
                                Mark all as read
                            </button>
                        </div>
                    </div>
                </div>
                


                <!-- Profile Dropdown -->
                <div class="relative dropdown-container" id="dropdown-profile">
                    <button onclick="toggleProfileDropdown()" class="flex items-center space-x-2">
                        <div class="h-8 w-8 rounded-full overflow-hidden">
                            <img src="{{ auth()->user()->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                alt="Profile"
                                class="w-full h-full object-cover" />
                        </div>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdown-menu-profile"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-gray-700 hidden">
                        <a href="{{ route('profile.show', ['user' => auth()->id()]) }}" class="block px-4 py-2 hover:bg-gray-100">Mon Profil</a>

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

    <!-- Menu Mobile -->
    <div class="md:hidden hidden bg-gray-800" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Barre de recherche mobile -->
            <div class="relative px-3 py-2">
                <input type="text"
                    id="mobile-search-input"
                    placeholder="Rechercher..."
                    class="bg-gray-700 pl-10 pr-4 py-2 rounded-lg w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="w-5 h-5 text-gray-400 absolute left-6 top-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <div id="mobile-search-results" class="absolute mt-1 w-full bg-white rounded-lg shadow-lg z-50 overflow-hidden hidden left-0"></div>
            </div>

            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md">
                Accueil
            </a>
            <a href="{{ route('chat.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md">
                Messages
            </a>
            <a href="{{ route('connections.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md">
                Mes connexions
            </a>
            <a href="{{ route('connections.pending') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md">
                Demandes de connexion
                @if($pendingConnections > 0)
                <span class="inline-block ml-2 w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
            </a>
            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md">
                Notifications
            </a>
            <a href="{{ route('profile.show', ['user' => auth()->id()]) }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md">
                Mon Profil
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" class="text-gray-300 hover:bg-gray-700 hover:text-white block w-full text-left px-3 py-2 rounded-md">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        const mobileSearchInput = document.getElementById('mobile-search-input');
        const mobileSearchResults = document.getElementById('mobile-search-results');
        let searchTimeout;

        // Desktop search functionality
        if (searchInput && searchResults) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);

                const query = this.value.trim();

                if (query === '') {
                    searchResults.innerHTML = '';
                    searchResults.classList.add('hidden');
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetchSearchResults(query, searchResults);
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });
        }

        // Mobile search functionality
        if (mobileSearchInput && mobileSearchResults) {
            mobileSearchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);

                const query = this.value.trim();

                if (query === '') {
                    mobileSearchResults.innerHTML = '';
                    mobileSearchResults.classList.add('hidden');
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetchSearchResults(query, mobileSearchResults);
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!mobileSearchInput.contains(e.target) && !mobileSearchResults.contains(e.target)) {
                    mobileSearchResults.classList.add('hidden');
                }
            });
        }

        function fetchSearchResults(query, resultsElement) {
            if (query.length < 2) return;

            fetch(`/search/users?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data.users, data.hashtags || [], data.languages || [], resultsElement);
                })
                .catch(error => console.error('Erreur:', error));
        }

        function displaySearchResults(users, hashtags, languages, resultsElement) {
            resultsElement.innerHTML = '';

            if (!users) users = [];
            if (!hashtags) hashtags = [];
            if (!languages) languages = [];

            if (users.length === 0 && hashtags.length === 0 && languages.length === 0) {
                resultsElement.innerHTML = '<div class="px-4 py-3 text-gray-500">Aucun résultat trouvé</div>';
                resultsElement.classList.remove('hidden');
                return;
            }

            const resultsList = document.createElement('div');
            resultsList.className = 'max-h-[70vh] overflow-y-auto';

            if (hashtags && hashtags.length > 0) {
                const hashtagsSection = document.createElement('div');
                hashtagsSection.innerHTML = '<div class="px-4 py-2 bg-gray-100 font-medium text-gray-700">Hashtags</div>';
                resultsList.appendChild(hashtagsSection);

                hashtags.forEach(hashtag => {
                    const hashtagElement = document.createElement('a');
                    hashtagElement.href = hashtag.url;
                    hashtagElement.className = 'flex items-center px-4 py-3 hover:bg-gray-100 border-b border-gray-100';

                    hashtagElement.innerHTML = `
                        <div class="flex items-center">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 mr-4">
                                <span class="text-blue-500 font-bold">#</span>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">#${hashtag.name}</div>
                                <div class="text-sm text-gray-500">${hashtag.posts_count} publication${hashtag.posts_count > 1 ? 's' : ''}</div>
                            </div>
                        </div>
                    `;

                    resultsList.appendChild(hashtagElement);
                });
            }

            if (languages && languages.length > 0) {
                const languagesSection = document.createElement('div');
                languagesSection.innerHTML = '<div class="px-4 py-2 bg-gray-100 font-medium text-gray-700">Langages de programmation</div>';
                resultsList.appendChild(languagesSection);

                languages.forEach(language => {
                    const languageElement = document.createElement('a');
                    languageElement.href = language.url;
                    languageElement.className = 'flex items-center px-4 py-3 hover:bg-gray-100 border-b border-gray-100';

                    languageElement.innerHTML = `
                        <div class="flex items-center">
                            <div>
                                <div class="font-medium text-gray-900">${language.name}</div>
                                <div class="text-sm text-gray-500">${language.posts_count} publication${language.posts_count > 1 ? 's' : ''}</div>
                            </div>
                        </div>
                    `;
                    resultsList.appendChild(languageElement);
                });
            }

            if (users.length > 0) {

                if (hashtags && hashtags.length > 0) {
                    const usersSection = document.createElement('div');
                    usersSection.innerHTML = '<div class="px-4 py-2 bg-gray-100 font-medium text-gray-700">Utilisateurs</div>';
                    resultsList.appendChild(usersSection);
                }


                users.forEach(user => {
                    const userElement = document.createElement('a');
                    userElement.href = user.url;
                    userElement.className = 'flex items-center px-4 py-3 hover:bg-gray-100 border-b border-gray-100 last:border-0';

                    userElement.innerHTML = `
                        <div class="mr-4">
                            <img src="${user.avatar}" class="w-10 h-10 rounded-full object-cover" alt="${user.name}">
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">${user.name}</div>
                            <div class="text-sm text-gray-500">${user.title}</div>
                        </div>
                    `;

                    resultsList.appendChild(userElement);
                });
            }

            resultsElement.appendChild(resultsList);
            resultsElement.classList.remove('hidden');
        }
    });

    function toggleProfileDropdown() {
        const dropdownMenu = document.getElementById('dropdown-menu-profile');
        if (dropdownMenu) {
            dropdownMenu.classList.toggle('hidden');

            // Close dropdown when clicking outside
            document.addEventListener('click', function closeProfileDropdown(event) {
                const container = document.getElementById('dropdown-profile');
                if (container && !container.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                    document.removeEventListener('click', closeProfileDropdown);
                }
            });
        }
    }
</script>

<!-- Formulaire de création de post (modal) -->
<div id="create-post-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto z-50">
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white w-full max-w-md mx-auto rounded-2xl shadow-xl p-8">
            <h2 class="text-lg font-medium text-gray-900 mb-6">
                Créer un nouveau post
            </h2>
            <button id="close-create-post-btn-x" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mt-6">
                    <textarea name="content" rows="4"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Que souhaitez-vous partager ?"></textarea>
                </div>

                <div class="mt-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Photos</label>
                        <input type="file" name="images[]" multiple accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-violet-700
                            hover:file:bg-violet-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vidéos</label>
                        <input type="file" name="videos[]" multiple accept="video/*"
                            class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-violet-700
                            hover:file:bg-violet-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Langage de programmation</label>
                        <input type="text" name="language"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Spécifiez le langage">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Code</label>
                        <textarea name="code_snippet" rows="6"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono"
                            placeholder="Collez votre code ici..."></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" id="close-create-post-btn" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Publier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('create-post-modal');
        const closeBtn = document.getElementById('close-create-post-btn');
        const closeBtnX = document.getElementById('close-create-post-btn-x');

        function closeModal() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        if (closeBtnX) {
            closeBtnX.addEventListener('click', closeModal);
        }

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>

<!-- Notification Dropdown JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationBellButton = document.getElementById('notification-bell-button');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationList = document.getElementById('notification-list');
        const markAllContainer = document.getElementById('mark-all-container');
        const markAllReadButton = document.getElementById('mark-all-read');
        const notificationIndicator = document.getElementById('notification-unread-indicator');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        let notificationsLoaded = false;
        
        // Toggle notification dropdown
        if (notificationBellButton && notificationDropdown) {
            notificationBellButton.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
                
                
                if (!notificationDropdown.classList.contains('hidden') && !notificationsLoaded) {
                    loadNotifications();
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (notificationDropdown && !notificationDropdown.classList.contains('hidden') 
                    && !notificationBellButton.contains(e.target) 
                    && !notificationDropdown.contains(e.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });
        }
        
        // Écouter les événements de notification Pusher
        document.addEventListener('notification.received', function(event) {
            const { type, data } = event.detail;
            
            
            if (notificationIndicator) {
                notificationIndicator.classList.remove('hidden');
            }
            
         
            notificationsLoaded = false;
        });
        
        // Ajouter une notification au dropdown
        function addNotificationToDropdown(data, type) {
            if (!notificationList) return;
            
            let icon = 'fa-bell';
            let iconColor = 'text-gray-500';
            let message = 'Nouvelle notification';
            
            // Déterminer le type d'icône et le message
            if (type === 'like') {
                icon = 'fa-heart';
                iconColor = 'text-red-500';
                message = `${data.author} a liké: ${data.title}`;
            } else if (type === 'comment') {
                icon = 'fa-comment';
                iconColor = 'text-blue-500';
                message = `${data.author}: ${data.content}`;
            } else if (type === 'post') {
                icon = 'fa-file-alt';
                iconColor = 'text-green-500';
                message = `${data.author} a publié: ${data.title}`;
            }
            
            // Créer l'élément de notification
            const notificationItem = document.createElement('div');
            notificationItem.className = 'px-4 py-3 hover:bg-gray-100 border-b border-gray-100 bg-blue-50';
            notificationItem.innerHTML = `
                <div class="flex items-start">
                    <div class="mr-3">
                        <i class="fas ${icon} ${iconColor}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800 font-medium">
                            ${message}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            ${new Date().toLocaleString()}
                        </p>
                    </div>
                    <button class="mark-as-read-btn text-xs text-blue-500 hover:text-blue-700"
                        data-id="new-notification">
                        Marquer comme lu
                    </button>
                </div>
            `;
            
            // Insérer au début de la liste
            if (notificationList.firstChild) {
                notificationList.insertBefore(notificationItem, notificationList.firstChild);
            } else {
                notificationList.appendChild(notificationItem);
            }
            
            
            markAllContainer.classList.remove('hidden');
            
           
            const markAsReadBtn = notificationItem.querySelector('.mark-as-read-btn');
            markAsReadBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationItem.classList.remove('bg-blue-50');
                notificationItem.classList.add('bg-white');
                this.remove();
            });
            
          
            if (notificationIndicator) {
                notificationIndicator.classList.remove('hidden');
            }
        }
        
       
        function loadNotifications() {
           
            notificationList.innerHTML = '<div class="px-4 py-3 text-center text-gray-500">Chargement...</div>';

            fetch('/notifications/get', {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                displayNotifications(data);
                notificationsLoaded = true;
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
                notificationList.innerHTML = `<div class="px-4 py-3 text-center text-red-500">Erreur de chargement: ${error.message}</div>`;
            });
        }
        

        function displayNotifications(data) {
            if (!data || data.length === 0) {
                notificationList.innerHTML = '<div class="px-4 py-3 text-center text-gray-500">Pas de notifications</div>';
                markAllContainer.classList.add('hidden');
                return;
            }
            
            let html = '';
            data.forEach(notification => {
                const isRead = notification.read_at !== null;
                let notificationData;
                
                try {
                    notificationData = typeof notification.data === 'string' 
                        ? JSON.parse(notification.data) 
                        : notification.data;
                } catch (e) {
                    console.error('Error parsing notification data:', e);
                    notificationData = { message: 'Notification' };
                }
                
                let icon = 'fas fa-bell';
                let bgColor = isRead ? 'bg-white' : 'bg-blue-50';

                if (notification.type.includes('LikeNotification')) {
                    icon = 'fas fa-heart text-red-500';
                } else if (notification.type.includes('CommentNotification') || notification.type.includes('commentNotification')) {
                    icon = 'fas fa-comment text-blue-500';
                } else if (notification.type.includes('PostCreatedNotification')) {
                    icon = 'fas fa-file-alt text-green-500';
                }
                
                html += `
                <div class="px-4 py-3 hover:bg-gray-100 border-b border-gray-100 ${bgColor}" 
                     data-notification-id="${notification.id}">
                    <div class="flex items-start">
                        <div class="mr-3">
                            <i class="${icon}"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800 font-medium">
                                ${notificationData.message || 'Nouvelle notification'}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                ${new Date(notification.created_at).toLocaleString()}
                            </p>
                        </div>
                        ${!isRead ? 
                            `<button class="mark-as-read-btn text-xs text-blue-500 hover:text-blue-700"
                                data-id="${notification.id}">
                                Marquer comme lu
                            </button>` : ''
                        }
                    </div>
                </div>`;
            });
            
            notificationList.innerHTML = html;

            const hasUnread = data.some(notification => notification.read_at === null);
            if (hasUnread) {
                markAllContainer.classList.remove('hidden');
            } else {
                markAllContainer.classList.add('hidden');
            }

            document.querySelectorAll('.mark-as-read-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const id = this.getAttribute('data-id');
                    markAsRead(id);
                });
            });

            document.querySelectorAll('[data-notification-id]').forEach(item => {
                item.addEventListener('click', function() {
                    const id = this.getAttribute('data-notification-id');
                    markAsRead(id);

                });
            });
        }
        
        // Mark a notification as read
        function markAsRead(id) {
            fetch(`/notifications/mark-as-read/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                
                    updateUnreadIndicator();
                }
            })
            .catch(error => console.error('Error marking notification as read:', error));
        }

        if (markAllReadButton) {
            markAllReadButton.addEventListener('click', function() {
                fetch('/notifications/mark-all-as-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        loadNotifications();

                        if (notificationIndicator) {
                            notificationIndicator.classList.add('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error marking all notifications as read:', error));
            });
        }

        function updateUnreadIndicator() {
            fetch('/notifications/count', {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.count > 0) {
                    if (notificationIndicator) {
                        notificationIndicator.classList.remove('hidden');
                    }
                } else {
                    if (notificationIndicator) {
                        notificationIndicator.classList.add('hidden');
                    }
                }
            })
            .catch(error => console.error('Error getting notification count:', error));
        }
        
        // Appeler updateUnreadIndicator au chargement de la page
        updateUnreadIndicator();
        
        // Listen for new pusher notifications
        ['test.notification', 'like.notification', 'comment.notification'].forEach(event => {
            document.addEventListener(event, function() {
                updateUnreadIndicator();
                notificationsLoaded = false;
            });
        });
    });
</script>