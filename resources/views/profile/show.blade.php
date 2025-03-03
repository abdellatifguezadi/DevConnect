<x-app-layout>
    <div class="min-h-screen bg-[#f3f2ef]">
        <div class="max-w-[1128px] mx-auto px-4">
            <!-- Background Card -->
            <div class="bg-white rounded-lg shadow mt-4 mb-4">
                <!-- Cover Image -->
                <div class="relative h-[200px]">
                    @if($user->profile && $user->profile->cover_image)
                    <img src="{{ asset($user->profile->cover_image) }}"
                        class="w-full h-full object-cover rounded-t-lg"
                        alt="Cover image"
                        onerror="this.onerror=null; this.src=''; this.parentElement.classList.add('bg-[#a0b4b7]')">
                    @else
                    <div class="h-full bg-[#a0b4b7] rounded-t-lg"></div>
                    @endif
                </div>

                <div class="px-6 pb-4">
                    <!-- Profile Section -->
                    <div class="relative flex justify-between">
                        <!-- Avatar -->
                        <div class="relative -mt-[100px]">
                            <img src="{{ $user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                class="w-[152px] h-[152px] rounded-full border-4 border-white"
                                alt="{{ $user->name }}">
                        </div>

                        <!-- Edit Button -->
                        @if(auth()->id() === $user->id)
                        <button onclick="openEditProfile()"
                            class="mt-4 px-4 py-1.5 border border-[#0a66c2] text-[#0a66c2] font-medium rounded-full hover:bg-[#0a66c2]/10">
                            <i class="fas fa-pencil-alt mr-2"></i>
                            Modifier le profil
                        </button>
                        @endif
                    </div>

                    <!-- User Info -->
                    <div class="mt-4">
                        <h1 class="text-[24px] font-semibold text-gray-900">{{ $user->name }}</h1>
                        <h2 class="text-[16px] text-gray-600 mt-1">{{ $user->profile?->title ?? 'Développeur' }}</h2>
                        <p class="text-gray-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $user->profile?->location ?? 'Non spécifié' }}
                            @if($connectionsCount > 0)
                            <span class="mx-1">•</span>
                            <span>{{ $connectionsCount }} connexions</span>
                            @endif
                        </p>

                        <!-- Connection Buttons -->
                        @if(auth()->id() !== $user->id)
                        @php
                        $connectionStatus = auth()->user()->getConnectionStatus($user);
                        @endphp

                        @if(!$connectionStatus)
                        <form action="{{ route('connections.send', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Se connecter
                            </button>
                        </form>
                        @elseif($connectionStatus->status === 'pending')
                        @if($connectionStatus->requester_id === auth()->id())
                        <form action="{{ route('connections.cancel', $connectionStatus) }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler la demande
                            </button>
                        </form>
                        @else
                        <div class="flex space-x-2 mt-4">
                            <form action="{{ route('connections.accept', $connectionStatus) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Accepter
                                </button>
                            </form>
                            <form action="{{ route('connections.reject', $connectionStatus) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Refuser
                                </button>
                            </form>
                        </div>
                        @endif
                        @elseif($connectionStatus->status === 'accepted')
                        <form action="{{ route('connections.remove', $connectionStatus) }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Retirer la connexion
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-[minmax(0,3fr)_minmax(0,1fr)] gap-4">
                <div class="space-y-4">
                    <!-- About Section -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">À propos</h2>
                        <p class="text-gray-700 whitespace-pre-line">
                            {{ $user->profile?->bio ?? 'Aucune bio disponible' }}
                        </p>
                    </div>

                    <!-- Experience Section -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Compétences</h2>
                        <div class="flex flex-wrap gap-2">
                            @forelse($userSkills as $skill)
                            <span class="px-3 py-1.5 bg-[#f3f2ef] text-gray-700 rounded-full text-sm font-medium">
                                {{ $skill->name }}
                                @if($skill->pivot->years_experience)
                                <span class="text-gray-500">({{ $skill->pivot->years_experience }} ans)</span>
                                @endif
                            </span>
                            @empty
                            <p class="text-gray-500">Aucune compétence ajoutée</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Posts Section -->
                    <div class="space-y-4">
                        @forelse($posts as $post)
                        <div class="bg-white rounded-lg shadow">
                            <div class="p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ $post->user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                            class="w-12 h-12 rounded-full"
                                            alt="{{ $post->user->name }}">
                                        <div class="ml-3">
                                            <p class="font-semibold text-gray-900">{{ $post->user->name }}</p>
                                            <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    @if(auth()->id() === $post->user_id)
                                    <div class="flex space-x-2">
                                        <button onclick="openEditPost('{{ $post->id }}', '{{ $post->content }}', '{{ $post->language->name }}', '{{ $post->code_snippet }}')"
                                            class="text-gray-400 hover:text-blue-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?')"
                                                class="text-gray-400 hover:text-red-600 transition-colors">
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
                                    <p class="text-gray-800">{{ $post->content }}</p>
                                    @if($post->media)
                                    @if(isset($post->media['images']))
                                    <div class="mt-4">
                                        @foreach($post->media['images'] as $image)
                                        <img src="{{ $image }}" alt="Post image" class="rounded-lg max-h-96 w-auto">
                                        @endforeach
                                    </div>
                                    @endif

                                    @if(isset($post->media['videos']))
                                    <div class="mt-4">
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
                                    <div class="mt-4 bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200">
                                        @if($post->programming_language)
                                        <div class="text-xs text-gray-400 mb-2">{{ strtoupper($post->programming_language) }}</div>
                                        @endif
                                        <pre><code>{{ $post->code_snippet }}</code></pre>
                                    </div>
                                    @endif

                                    @if($post->hashtags->count() > 0)
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach($post->hashtags as $hashtag)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                            #{{ $hashtag->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>

                                <div class="mt-4 flex items-center space-x-4">
                                    <button class="flex items-center space-x-1 text-gray-500 hover:text-blue-500 like-button" data-post-id="{{ $post->id }}">
                                        <svg class="w-5 h-5 {{ $post->likes()->where('user_id', auth()->id())->exists() ? 'text-blue-500' : 'text-gray-500' }}"
                                            fill="{{ $post->likes()->where('user_id', auth()->id())->exists() ? 'currentColor' : 'none' }}"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <span class="like-count">{{ $post->likes_count }}</span>
                                    </button>

                                    <button class="flex items-center space-x-1 text-gray-500 hover:text-blue-500" onclick="document.getElementById('comments-{{ $post->id }}').classList.toggle('hidden')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span class="comment-count" data-post-id="{{ $post->id }}">{{ $post->comments_count }}</span>
                                    </button>
                                </div>

                                <div id="comments-{{ $post->id }}" class="mt-4 hidden">
                                    <div class="comments-list">
                                        @foreach($post->comments as $comment)
                                        <x-comment :comment="$comment" />
                                        @endforeach
                                    </div>

                                    <form action="{{ route('comments.store', $post) }}" method="POST" class="comment-form mt-4" data-post-id="{{ $post->id }}">
                                        @csrf
                                        <div class="flex items-start space-x-2">
                                            <img src="{{ auth()->user()->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                                alt="Avatar"
                                                class="w-8 h-8 rounded-full">
                                            <div class="flex-1">
                                                <textarea name="content"
                                                    placeholder="Ajouter un commentaire..."
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    rows="2"></textarea>
                                                <button type="submit"
                                                    class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                                                    Commenter
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                            Aucune publication pour le moment
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-4">
                    <!-- Social Links -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="font-semibold mb-4">Profils sociaux</h3>
                        <div class="space-y-3">
                            @if($user->profile?->linkedin_url)
                            <a href="{{ $user->profile->linkedin_url }}" target="_blank"
                                class="flex items-center text-gray-600 hover:text-[#0a66c2]">
                                <i class="fab fa-linkedin mr-2"></i>
                                LinkedIn
                            </a>
                            @endif
                            @if($user->profile?->github_url)
                            <a href="{{ $user->profile->github_url }}" target="_blank"
                                class="flex items-center text-gray-600 hover:text-gray-900">
                                <i class="fab fa-github mr-2"></i>
                                GitHub
                            </a>
                            @endif
                            @if($user->profile?->website_url)
                            <a href="{{ $user->profile->website_url }}" target="_blank"
                                class="flex items-center text-gray-600 hover:text-[#0a66c2]">
                                <i class="fas fa-globe mr-2"></i>
                                Site web
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Stats Card -->
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Publications</span>
                                <span class="font-semibold">{{ $postsCount }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Connexions</span>
                                <span class="font-semibold">{{ $connectionsCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editProfileModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto z-50">
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white w-full max-w-md rounded-2xl shadow-xl p-8 overflow-y-auto max-h-[90vh]">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Modifier le profil</h3>
                    <button onclick="closeEditProfile()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <x-edit-profile-form :user="$user" :userSkills="$userSkills" />
                </div>
            </div>
        </div>
    </div>

    <div id="editPostModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto z-50">
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white w-full max-w-md rounded-2xl shadow-xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Modifier la publication</h3>
                <button onclick="closeEditPost()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <x-edit-post-form />
            </div>
        </div>
    </div>

    <script>
        function toggleEditComment(commentId) {
            const editComment = document.getElementById(`edit-comment-${commentId}`);
            if (editComment.style.display === "none" || editComment.style.display === "") {
                editComment.style.display = "block";
            } else {
                editComment.style.display = "none";
            }
        }

        function openEditPost(postId, content, language, codeSnippet) {
            const modal = document.getElementById('editPostModal');
            const form = document.getElementById('editPostForm');
            const contentTextarea = document.getElementById('editPostContent');
            const languageInput = document.getElementById('editPostLanguage');
            const codeSnippetTextarea = document.getElementById('editPostCodeSnippet');

            form.action = `/posts/${postId}`;
            contentTextarea.value = content;

            if (languageInput) {
                languageInput.value = language || '';
            }

            if (codeSnippetTextarea && codeSnippet) {
                codeSnippetTextarea.value = codeSnippet;
            }

            modal.classList.remove('hidden');
        }

        function closeEditPost() {
            const modal = document.getElementById('editPostModal');
            modal.classList.add('hidden');
        }

        function openEditProfile() {
            const modal = document.getElementById('editProfileModal');
            modal.classList.remove('hidden');
        }

        function closeEditProfile() {
            const modal = document.getElementById('editProfileModal');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>