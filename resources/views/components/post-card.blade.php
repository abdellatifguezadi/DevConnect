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
                <div class="relative dropdown-container" id="dropdown-{{ $post->id }}">
                    <button onclick="toggleDropdown('{{ $post->id }}')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                    <div id="dropdown-menu-{{ $post->id }}" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                        <button onclick="openEditPost('{{ $post->id }}', '{{ addslashes($post->content) }}', '{{ $post->language->name ?? '' }}', '{{ addslashes($post->code_snippet ?? '') }}')"
                            class="block w-full text-left px-4 py-2 text-blue-600 hover:bg-gray-100">
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
        </div>

        <!-- Post Actions -->
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

        <!-- Comments Section -->
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