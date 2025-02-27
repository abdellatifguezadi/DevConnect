<x-app-layout>
    <div class="min-h-screen bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="relative h-64 sm:h-96">
                    @if($user->profile && $user->profile->cover_image)
                    <img src="{{ asset($user->profile->cover_image) }}"
                        class="w-full h-full object-cover"
                        alt="Cover image"
                        onerror="this.onerror=null; this.src=''; this.parentElement.classList.add('bg-gradient-to-br', 'from-indigo-500', 'to-purple-600')">
                    @else
                    <div class="h-full bg-gradient-to-br from-indigo-500 to-purple-600"></div>
                    @endif
                </div>

                <div class="relative px-6 pb-8 -mt-16">
                    <div class="flex flex-col items-center">

                        <div class="relative">
                            <img src="{{ $user->profile?->avatar  ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                class="w-32 h-32 rounded-full border-4 border-white shadow-xl object-cover bg-white"
                                alt="{{ $user->name }}">
                            <div class="absolute bottom-2 right-2 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>

                        <div class="mt-4 text-center">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-lg text-indigo-600">{{ $user->profile?->title ?? 'Développeur' }}</p>
                            <p class="mt-2 text-gray-600 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                {{ $user->profile?->location ?? 'Non spécifié' }}
                            </p>
                        </div>

                        @if(auth()->id() === $user->id)
                        <button onclick="openEditProfile()"
                            class="mt-6 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Modifier le profil
                        </button>
                        @endif
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-4 max-w-lg mx-auto">
                        <div class="bg-gray-50 rounded-xl p-6 text-center">
                            <span class="block text-3xl font-bold text-indigo-600">{{ $postsCount }}</span>
                            <span class="text-gray-600">Publications</span>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-6 text-center">
                            <span class="block text-3xl font-bold text-indigo-600">{{ $connectionsCount }}</span>
                            <span class="text-gray-600">Connexions</span>
                        </div>
                    </div>

                    <div class="mt-8 bg-gray-50 rounded-xl p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">À propos</h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $user->profile?->bio ?? 'Aucune bio disponible' }}
                        </p>
                    </div>

                    <div class="mt-8 bg-gray-50 rounded-xl p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Compétences</h2>
                        <div class="flex flex-wrap gap-2">
                            @forelse($userSkills as $skill)
                            <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                                {{ $skill->name }}
                                @if($skill->pivot->years_experience)
                                <span class="ml-2 text-xs text-indigo-600">{{ $skill->pivot->years_experience }} ans</span>
                                @endif
                            </span>
                            @empty
                            <span class="text-gray-500">Aucune compétence ajoutée</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center space-x-4">
                        @if($user->profile?->github_url)
                        <a href="{{ $user->profile->github_url }}" target="_blank"
                            class="p-3 bg-gray-900 text-white rounded-full hover:bg-gray-800 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                        @endif

                        @if($user->profile?->linkedin_url)
                        <a href="{{ $user->profile->linkedin_url }}" target="_blank"
                            class="p-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        @endif

                        @if($user->profile?->website_url)
                        <a href="{{ $user->profile->website_url }}" target="_blank"
                            class="p-3 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9-3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Publications</h2>
                <div class="space-y-6">
                    @forelse($posts as $post)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="p-6">
                        
                            <div class="flex items-center space-x-4">
                                <img src="{{ $post->user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                    class="w-12 h-12 rounded-full object-cover"
                                    alt="{{ $post->user->name }}">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $post->user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-gray-800">{{ $post->content }}</p>
                                @if($post->image)
                                <img src="{{ asset($post->image) }}"
                                    alt="Post image"
                                    class="mt-4 rounded-lg w-full object-cover max-h-96">
                                @endif
                            </div>

                            <div class="mt-4 flex items-center justify-between border-t pt-4">
                                <div class="flex space-x-4">
                                    <form action="{{ route('posts.like', $post) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center space-x-2 {{ $post->likes()->where('user_id', auth()->id())->exists() ? 'text-indigo-600' : 'text-gray-500' }} hover:text-indigo-600 transition-colors">
                                            <svg class="w-5 h-5"
                                                fill="{{ $post->likes()->where('user_id', auth()->id())->exists() ? 'currentColor' : 'none' }}"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            <span>{{ $post->likes_count ?? 0 }}</span>
                                        </button>
                                    </form>
                                    <button onclick="toggleComments('{{ $post->id }}')"
                                        class="flex items-center space-x-2 text-gray-500 hover:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span>{{ $post->comments_count ?? 0 }}</span>
                                    </button>
                                </div>
                                @if(auth()->id() === $post->user_id)
                                <div class="flex space-x-2">
                                    <button onclick="openEditPost('{{ $post->id }}', '{{ $post->content }}')"
                                        class="text-blue-600 hover:text-blue-800">
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
                                            class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>

                            <div id="comments-{{ $post->id }}" class="mt-4 hidden">
                                <div class="space-y-4">
                                    @if($post->comments)
                                    @foreach($post->comments->whereNull('parent_id') as $comment)
                                    <div class="flex space-x-3 bg-gray-50 p-3 rounded-lg">
                                        <img src="{{ $comment->user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                            class="w-8 h-8 rounded-full object-cover"
                                            alt="{{ $comment->user->name }}">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <h4 class="text-sm font-semibold text-gray-900">{{ $comment->user->name }}</h4>
                                                <div class="flex items-center space-x-2">
                                                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                                    @if(auth()->id() === $comment->user_id)
                                                    <button onclick="toggleEditComment('{{ $comment->id }}')"
                                                        class="text-blue-600 hover:text-blue-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-700 mt-1">{{ $comment->content }}</p>

                                            @foreach($comment->replies as $reply)
                                            <div class="ml-8 mt-2 flex space-x-3 bg-gray-100 p-3 rounded-lg" id="reply-{{ $reply->id }}">
                                                <img src="{{ $reply->user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                                    class="w-6 h-6 rounded-full object-cover"
                                                    alt="{{ $reply->user->name }}">
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <h4 class="text-sm font-semibold text-gray-900">{{ $reply->user->name }}</h4>
                                                        <div class="flex items-center space-x-2">
                                                            <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                                            @if(auth()->id() === $reply->user_id)
                                                            <button onclick="editReply('{{ $reply->id }}', '{{ $reply->content }}')"
                                                                class="text-blue-600 hover:text-blue-800">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </button>
                                                            <form action="{{ route('comments.replies.destroy', ['comment' => $comment->id, 'reply' => $reply->id]) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <p class="text-sm text-gray-700 mt-1">{{ $reply->content }}</p>
                                                </div>
                                            </div>
                                            @endforeach

                                            <form action="{{ route('comments.reply', $comment) }}" method="POST" class="mt-2 ml-8 flex space-x-2">
                                                @csrf
                                                <div class="flex-1 flex space-x-2">
                                                    <img src="{{ auth()->user()->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                                        class="w-6 h-6 rounded-full object-cover"
                                                        alt="{{ auth()->user()->name }}">
                                                    <input type="text" name="content"
                                                        class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                        placeholder="Répondre à ce commentaire...">
                                                </div>
                                                <button type="submit"
                                                    class="px-3 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition-colors">
                                                    Répondre
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif

                                    <!-- Formulaire pour ajouter un commentaire -->
                                    <form action="{{ route('comments.store', $post) }}" method="POST" class="flex space-x-2">
                                        @csrf
                                        <img src="{{ auth()->user()->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                            class="w-8 h-8 rounded-full object-cover"
                                            alt="{{ auth()->user()->name }}">
                                        <div class="flex-1">
                                            <input type="text" name="content"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Ajouter un commentaire...">
                                            <button type="submit"
                                                class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                                Commenter
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-xl shadow p-6 text-center text-gray-500">
                        Aucune publication pour le moment
                    </div>
                    @endforelse
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

        let currentPostId = null;

        function openEditPost(postId, content) {
            currentPostId = postId;
            document.getElementById('editPostContent').value = content;
            document.getElementById('editPostForm').action = `/posts/${postId}`;
            document.getElementById('editPostModal').classList.remove('hidden');
        }

        function closeEditPost() {
            document.getElementById('editPostModal').classList.add('hidden');
            currentPostId = null;
        }


        window.onclick = function(event) {
            const editPostModal = document.getElementById('editPostModal');
            const editProfileModal = document.getElementById('editProfileModal');

            if (event.target == editPostModal) {
                closeEditPost();
            }
            if (event.target == editProfileModal) {
                closeEditProfile();
            }
        }

        function editReply(replyId, content) {

            document.getElementById(`reply-content-${replyId}`).classList.add('hidden');

            document.getElementById(`reply-edit-form-${replyId}`).classList.remove('hidden');
        }

        function cancelEditReply(replyId) {

            document.getElementById(`reply-content-${replyId}`).classList.remove('hidden');

            document.getElementById(`reply-edit-form-${replyId}`).classList.add('hidden');
        }
    </script>
</x-app-layout>