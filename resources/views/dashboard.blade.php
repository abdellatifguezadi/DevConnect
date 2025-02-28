<x-app-layout>
    <div class="bg-[#f3f2ef] min-h-screen pt-24">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
                <!-- Profil Card - Left Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="relative h-24 bg-[#a0b4b7]">
                            <img src="{{ $user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-20 h-20 rounded-full border-4 border-white"
                                alt="{{ $user->name }}">
                        </div>
                        <div class="pt-14 p-4 text-center">
                            <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-600 mt-1">{{ $user->profile?->title ?? 'Développeur' }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($user->skills as $skill)
                                <span class="px-2 py-1 bg-{{ $skill->category }}-100 text-{{ $skill->category }}-800 rounded-full text-xs">
                                    {{ $skill->name }}
                                </span>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-4 border-t">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Connections</span>
                                    <span class="text-blue-600 font-medium">{{ $connectionsCount }}</span>
                                </div>
                                <div class="flex justify-between text-sm mt-2">
                                    <span class="text-gray-500">Posts</span>
                                    <span class="text-blue-600 font-medium">{{ $postsCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trending Section -->
                    <div class="bg-white rounded-lg shadow mt-4 p-4">
                        <h3 class="text-base font-semibold mb-3">Tendances pour vous</h3>
                        <div class="space-y-2">
                            @foreach($trendingTags as $tag)
                            <a href="#" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded">
                                <span class="text-gray-600">#{{ $tag->name }}</span>
                                <span class="text-gray-400 text-sm">{{ number_format($tag->posts_count) }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Content - Center -->
                <div class="lg:col-span-2">
                    <!-- Create Post -->
                    <div class="bg-white rounded-lg shadow p-4 mb-4">
                        <div class="flex items-start space-x-4">
                            <img src="{{ auth()->user()->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                class="w-12 h-12 rounded-full"
                                alt="{{ auth()->user()->name }}">
                            <button onclick="document.getElementById('create-post').click()"
                                class="flex-grow text-left px-4 py-3 rounded-full border border-gray-300 hover:bg-gray-100 text-gray-500">
                                Commencer un post
                            </button>
                        </div>
                        <div class="flex justify-between mt-4 pt-2 border-t">
                            <button class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg text-gray-600">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Photo</span>
                            </button>
                            <button type="button"
                                onclick="document.getElementById('video-input').click()"
                                class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 p-2 rounded-md hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Vidéo</span>
                            </button>
                            <button type="button"
                                @click="showCodeEditor = true"
                                class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 p-2 rounded-md hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                <span>Code</span>
                            </button>
                        </div>
                    </div>

                    <!-- Posts Feed -->
                    <div class="space-y-4">
                        @foreach($posts as $post)
                        <div class="bg-white rounded-lg shadow">
                            <div class="p-4">
                                <!-- Post Header -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $post->user->profile->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                            alt="{{ $post->user->name }}"
                                            class="w-12 h-12 rounded-full" />
                                        <div>
                                            <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                            <p class="text-gray-500 text-sm">{{ $post->user->profile->title ?? '' }}</p>
                                            <p class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        @if(auth()->id() !== $post->user_id)
                                        @php
                                        $connectionStatus = auth()->user()->getConnectionStatus($post->user);
                                        @endphp

                                        @if(!$connectionStatus)
                                        <form action="{{ route('connections.send', $post->user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-full hover:shadow-lg transition duration-200">
                                                Se connecter
                                            </button>
                                        </form>
                                        @elseif($connectionStatus->status === 'pending')
                                        @if($connectionStatus->requester_id === auth()->id())
                                        <form action="{{ route('connections.cancel', $connectionStatus) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded-full hover:bg-gray-600 transition duration-200">
                                                Annuler la demande
                                            </button>
                                        </form>
                                        @else
                                        <div class="flex space-x-2">
                                            <form action="{{ route('connections.accept', $connectionStatus) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-full hover:bg-green-600 transition duration-200">
                                                    Accepter
                                                </button>
                                            </form>
                                            <form action="{{ route('connections.reject', $connectionStatus) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition duration-200">
                                                    Refuser
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                        @if($post->user_id === auth()->id())
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                </svg>
                                            </button>
                                            <div x-show="open"
                                                @click.away="open = false"
                                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                                <button @click="$dispatch('open-modal', 'edit-post-{{ $post->id }}')"
                                                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                    Modifier
                                                </button>
                                                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Post Content -->
                                <div class="mt-4">
                                    <p class="text-gray-700">{{ $post->content }}</p>

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
                                <!-- Post Actions - Une seule fois -->
                                <div class="mt-4 flex items-center space-x-4 pt-4 border-t">
                                    <button class="like-button flex items-center space-x-1" data-post-id="{{ $post->id }}">
                                        <svg class="w-5 h-5 {{ $post->isLikedByUser(auth()->user()) ? 'text-blue-500' : 'text-gray-500' }}"
                                            fill="{{ $post->isLikedByUser(auth()->user()) ? 'currentColor' : 'none' }}"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                        <span class="like-count">{{ $post->likes_count }}</span>
                                    </button>

                                    <button class="flex items-center space-x-1 text-gray-500 hover:text-blue-500"
                                        onclick="document.getElementById('comments-{{ $post->id }}').classList.toggle('hidden')"
                                        data-post-id="{{ $post->id }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span class="comment-count">{{ $post->comments_count }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-base font-semibold mb-3">Suggestions de connexion</h3>
                        <!-- Add connection suggestions here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@if(session('success'))
<div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg"
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 3000)">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg"
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 3000)">
    {{ session('error') }}
</div>
@endif

<script>
    function toggleEditComment(commentId) {
        const editComment = document.getElementById(`edit-comment-${commentId}`);
        if (editComment.style.display === "none" || editComment.style.display === "") {
            editComment.style.display = "block";
        } else {
            editComment.style.display = "none";
        }
    }
</script>