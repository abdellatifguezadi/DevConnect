<x-app-layout>



    <div class="py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden">
                <div class="h-80 relative overflow-hidden">
                    @if($user->profile && $user->profile->cover_image)
                        <img src="{{ asset($user->profile->cover_image) }}"
                            class="absolute inset-0 w-full h-full object-cover"
                            alt="Cover image"
                            onerror="this.onerror=null; this.src=''; this.parentElement.classList.add('bg-gradient-to-r', 'from-blue-600', 'via-purple-500', 'to-pink-500');">
                    @else
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-500 to-pink-500"></div>
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                </div>
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <rect width="100" height="100" fill="none" stroke="white" stroke-width="0.5" />
                    </svg>
                </div>
            </div>

            <div class="relative px-8 pb-8">
                <div class="flex flex-col md:flex-row items-center md:items-end -mt-20 mb-8">
                    <div class="relative">
                        <img src="{{ $user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                            class="w-40 h-40 rounded-full border-4 border-white shadow-xl object-cover"
                            alt="{{ $user->name }}">
                        <div class="absolute bottom-0 right-0 bg-green-500 w-5 h-5 rounded-full border-4 border-white"></div>
                    </div>
                    <div class="md:ml-8 mt-4 md:mt-0 text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-xl text-gray-600">{{ $user->profile?->title ?? 'Développeur' }}</p>
                        <p class="text-gray-500 flex items-center justify-center md:justify-start mt-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $user->profile?->location ?? 'Non spécifié' }}
                        </p>
                    </div>
                    @if(auth()->id() === $user->id)
                    <div class="md:ml-auto mt-4 md:mt-0">
                        <button onclick="openEditProfile()"
                            class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-full font-semibold transform transition hover:scale-105 hover:shadow-lg">
                            Modifier le profil
                        </button>
                    </div>
                    @endif
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-2">
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h2 class="text-lg font-semibold mb-4">À propos</h2>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $user->profile?->bio ?? 'Aucune bio disponible' }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h2 class="text-lg font-semibold mb-4">Statistiques</h2>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Publications</span>
                                    <span class="text-2xl font-bold text-blue-600">{{ $postsCount }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Connexions</span>
                                    <span class="text-2xl font-bold text-green-600">{{ $connectionsCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Liens sociaux -->
                <div class="mt-8 flex justify-center space-x-6">
                    @if($user->profile?->github_url)
                    <a href="{{ $user->profile->github_url }}" target="_blank"
                        class="transform transition hover:scale-110">
                        <div class="bg-gray-900 text-white p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </div>
                    </a>
                    @endif
                    @if($user->profile?->linkedin_url)
                    <a href="{{ $user->profile->linkedin_url }}" target="_blank"
                        class="transform transition hover:scale-110">
                        <div class="bg-blue-700 text-white p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </div>
                    </a>
                    @endif
                    @if($user->profile?->website_url)
                    <a href="{{ $user->profile->website_url }}" target="_blank"
                        class="transform transition hover:scale-110">
                        <div class="bg-indigo-600 text-white p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9-3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                    </a>
                    @endif
                </div>
                <!-- Section des publications -->
                <div class="mt-8">
                    <h2 class="text-2xl font-bold mb-6 text-gray-900">Publications</h2>
                    <div class="space-y-6">
                        @foreach($posts as $post)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:shadow-xl">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $post->user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                            class="w-12 h-12 rounded-full border-2 border-gray-200">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $post->user->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    @if(auth()->id() === $post->user_id)
                                    <div class="flex space-x-2">
                                        <button onclick="openEditPost({{ $post->id }})"
                                            class="text-gray-400 hover:text-blue-600 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-800 leading-relaxed">{{ $post->content }}</p>
                                    <!-- Media display section -->
                                    <div class="mt-4">
                                        @if($post->media)
                                        @if(isset($post->media['images']))
                                        <div class="grid grid-cols-1 gap-4">
                                            @foreach($post->media['images'] as $image)
                                            <img src="{{ $image }}"
                                                alt="Post image"
                                                class="rounded-lg max-h-96 w-auto">
                                            @endforeach
                                        </div>
                                        @endif

                                        @if(isset($post->media['videos']))
                                        <div class="grid grid-cols-1 gap-4">
                                            @foreach($post->media['videos'] as $video)
                                            <video controls class="rounded-lg max-h-96 w-full">
                                                <source src="{{ $video }}" type="video/mp4">
                                                Votre navigateur ne supporte pas la lecture de vidéos.
                                            </video>
                                            @endforeach
                                        </div>
                                        @endif
                                        @endif

                                        @if($post->code_snippet)
                                        <div class="mt-4 bg-gray-900 rounded-xl p-4 overflow-x-auto">
                                            <pre class="text-gray-100"><code>{{ $post->code_snippet }}</code></pre>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Actions sur le post -->
                                <div class="mt-6 flex items-center justify-between">
                                    <div class="flex space-x-4">
                                        <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-600 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                            </svg>
                                            <span>{{ $post->likes_count }}</span>
                                        </button>
                                        <button onclick="toggleComments({{ $post->id }})"
                                            class="flex items-center space-x-2 text-gray-500 hover:text-blue-600 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03 8 9 8s9-3.582 9-8z" />
                                            </svg>
                                            <span>{{ $post->comments_count }}</span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Section commentaires -->
                                <div id="comments-{{ $post->id }}" class="mt-6 hidden">
                                    <div class="space-y-4">
                                        @foreach($post->comments as $comment)
                                        <div class="flex space-x-3 bg-gray-50 p-4 rounded-xl">
                                            <img src="{{ $comment->user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                                class="w-10 h-10 rounded-full border-2 border-gray-200">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="font-semibold text-gray-900">{{ $comment->user->name }}</h4>
                                                    <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="mt-1 text-gray-700">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="flex items-center justify-between">
                                            <!-- Formulaire nouveau commentaire -->
                                            <form action="{{ route('comments.store', $post) }}" method="POST">
                                                @csrf
                                                <div class="flex space-x-3">
                                                    <img src="{{ auth()->user()->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                                        class="w-10 h-10 rounded-full border-2 border-gray-200">
                                                    <div class="flex-1">
                                                        <input type="text" name="content"
                                                            class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-full focus:outline-none focus:border-blue-500"
                                                            placeholder="Ajouter un commentaire...">
                                                    </div>
                                                    <button type="submit"
                                                        class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">
                                                        Envoyer
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Modification Profil -->
    <div id="editProfileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto">
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white w-full max-w-md rounded-lg shadow-xl p-6 overflow-y-auto max-h-[90vh]">
                <div class="text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Modifier le profil</h3>
                    <button onclick="closeEditProfile()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <!-- Le reste du formulaire reste identique -->
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Titre professionnel</label>
                            <input type="text" name="title" value="{{ $user->profile?->title }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                            <textarea name="bio" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $user->profile?->bio }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">GitHub URL</label>
                            <input type="url" name="github_url" value="{{ $user->profile?->github_url }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" value="{{ $user->profile?->linkedin_url }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Site Web</label>
                            <input type="url" name="website_url" value="{{ $user->profile?->website_url }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Localisation</label>
                            <input type="text" name="location" value="{{ $user->profile?->location }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Avatar</label>
                            <input type="file" name="avatar" accept="image/*"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Image de couverture</label>
                            <input type="file" name="cover_image" accept="image/*"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeEditProfile()"
                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                                Annuler
                            </button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openEditProfile() {
            document.getElementById('editProfileModal').classList.remove('hidden');
        }

        function closeEditProfile() {
            document.getElementById('editProfileModal').classList.add('hidden');
        }

        function toggleComments(postId) {
            const commentsSection = document.getElementById(`comments-${postId}`);
            commentsSection.classList.toggle('hidden');
        }

        // Fermer le modal si on clique en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('editProfileModal');
            if (event.target == modal) {
                closeEditProfile();
            }
        }
    </script>
</x-app-layout>