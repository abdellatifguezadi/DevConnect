<x-app-layout>
    <div class="min-h-screen bg-[#f3f2ef]">
        <div class="max-w-[1128px] mx-auto px-4 pt-20">
            <!-- Post -->
            <div class="bg-white rounded-lg shadow p-6 mb-4">
                <div class="flex items-start space-x-4">
                    <img src="{{ $post->user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                        alt="{{ $post->user->name }}"
                        class="w-12 h-12 rounded-full">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">{{ $post->user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
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
                                @if($post->language)
                                <div class="text-xs text-gray-400 mb-2">{{ strtoupper($post->language->name) }}</div>
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
                            
                            <!-- Bouton Partager avec dropdown -->
                            <div class="relative dropdown-container">
                                <button onclick="toggleShareDropdown('{{ $post->id }}')" class="flex items-center space-x-1 text-gray-500 hover:text-blue-500 font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    <span>Partager</span>
                                </button>
                                <div id="share-dropdown-{{ $post->id }}" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                                    @php
                                        $shareTitle = "Découvrez ce post sur " . config('app.name') . ": " . substr($post->content, 0, 60) . "...";
                                        $shareUrl = route('posts.show', $post);
                                        $encodedShareUrl = urlencode($shareUrl);
                                        $encodedShareTitle = urlencode($shareTitle);
                                    @endphp
                                    
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedShareUrl }}" class="social-button facebook" target="_blank">
                                        <i class="fab fa-facebook"></i> Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ $encodedShareUrl }}&text={{ $encodedShareTitle }}" class="social-button twitter" target="_blank">
                                        <i class="fab fa-twitter"></i> Twitter
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedShareUrl }}" class="social-button linkedin" target="_blank">
                                        <i class="fab fa-linkedin"></i> LinkedIn
                                    </a>
                                    <a href="https://wa.me/?text={{ $encodedShareTitle }}%20{{ $encodedShareUrl }}" class="social-button whatsapp" target="_blank">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                    <a href="https://telegram.me/share/url?url={{ $encodedShareUrl }}&text={{ $encodedShareTitle }}" class="social-button telegram" target="_blank">
                                        <i class="fab fa-telegram"></i> Telegram
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div id="comments-{{ $post->id }}" class="mt-4">
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
            </div>

            <!-- Profil de l'utilisateur -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center space-x-4">
                    <img src="{{ $user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                        alt="{{ $user->name }}"
                        class="w-16 h-16 rounded-full">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-500">{{ $user->profile?->headline ?? 'Membre de ' . config('app.name') }}</p>
                        <div class="flex space-x-4 mt-2">
                            <span class="text-sm text-gray-500">{{ $postsCount }} publications</span>
                            <span class="text-sm text-gray-500">{{ $connectionsCount }} connexions</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('profile.show', $user) }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                        Voir le profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 