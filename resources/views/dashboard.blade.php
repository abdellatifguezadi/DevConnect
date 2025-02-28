<x-app-layout>


    <div class="py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-gray-50">

                        <div class="max-w-7xl mx-auto pt-20 px-4">
                            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                                <div class="space-y-6">
                                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                                        <div class="relative">
                                            <div class="h-24 bg-gradient-to-r from-blue-600 to-blue-400"></div>
                                            <img src="{{ $user->profile?->avatar  ?? 'https://avatar.iran.liara.run/public/boy' }}" alt="Profile"
                                                class="absolute -bottom-6 left-4 w-20 h-20 rounded-full border-4 border-white shadow-md" />
                                        </div>
                                        <div class="pt-14 p-4">
                                            <div class="flex items-center justify-between">
                                                <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                                                @if($user->profile && $user->profile->github_url)
                                                <a href="{{ $user->profile->github_url }}" target="_blank" class="text-gray-600 hover:text-black">
                                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.237 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                                    </svg>
                                                </a>
                                                @endif
                                                @if($user->profile?->linkedin_url)
                                                <a href="{{ $user->profile->linkedin_url }}" target="_blank" class="text-gray-600 hover:text-black">
                                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                                    </svg>
                                                </a>
                                                @endif

                                                @if($user->profile?->website_url)
                                                <a href="{{ $user->profile->website_url }}" target="_blank" class="text-gray-600 hover:text-black">
                                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9-3-9m-9 9a9 9 0 019-9" />
                                                    </svg>
                                                </a>
                                                @endif
                                            </div>
                                            <p class="text-gray-600 text-sm mt-1">{{ $user->profile->title ?? 'Développeur' }}</p>
                                            <p class="text-gray-500 text-sm mt-2">{{ $user->profile->bio ?? '' }}</p>

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

                                    <div class="bg-white rounded-xl shadow-sm p-4">
                                        <h3 class="font-semibold mb-4">Trending Tags</h3>
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

                                <div class="lg:col-span-2 space-y-6">
                                    <div class="bg-white rounded-lg shadow-sm mb-6 p-4">
                                        <div class="flex items-start space-x-4">
                                            <img src="{{ auth()->user()->profile->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                                alt="User"
                                                class="w-10 h-10 rounded-full" />
                                            <div class="flex-1">
                                                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" x-data="{ 
                                                    showImagePreview: false,
                                                    showVideoPreview: false,
                                                    showCodeEditor: false,
                                                    imageUrl: '',
                                                    videoUrl: ''
                                                }">
                                                    @csrf
                                                    <textarea
                                                        name="content"
                                                        placeholder="Partagez vos pensées..."
                                                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                        rows="3"></textarea>

                                                    <div x-show="showImagePreview" class="mt-3">
                                                        <div class="relative">
                                                            <img :src="imageUrl" class="max-h-64 rounded-lg" />
                                                            <button type="button"
                                                                @click="showImagePreview = false; imageUrl = ''"
                                                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div x-show="showVideoPreview" class="mt-3">
                                                        <div class="relative">
                                                            <video controls class="max-h-64 rounded-lg w-full">
                                                                <source :src="videoUrl" type="video/mp4">
                                                            </video>
                                                            <button type="button"
                                                                @click="showVideoPreview = false; videoUrl = ''"
                                                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div x-show="showCodeEditor" class="mt-3">
                                                        <div class="flex space-x-2 mb-2">
                                                            <select name="programming_language" class="border rounded-md px-2 py-1 text-sm">
                                                                <option value="php">PHP</option>
                                                                <option value="javascript">JavaScript</option>
                                                                <option value="python">Python</option>
                                                                <option value="java">Java</option>
                                                                <option value="csharp">C#</option>
                                                            </select>
                                                            <button type="button"
                                                                @click="showCodeEditor = false"
                                                                class="text-red-500 hover:text-red-700">
                                                                Annuler
                                                            </button>
                                                        </div>
                                                        <textarea
                                                            name="code_snippet"
                                                            class="w-full p-3 border rounded-lg font-mono text-sm bg-gray-900 text-gray-100"
                                                            rows="5"
                                                            placeholder="Collez votre code ici..."></textarea>
                                                    </div>

                                                    <input type="file"
                                                        name="image"
                                                        accept="image/*"
                                                        class="hidden"
                                                        id="image-input"
                                                        @change="const file = $event.target.files[0]; if(file){ imageUrl = URL.createObjectURL(file); showImagePreview = true; }">

                                                    <input type="file"
                                                        name="video"
                                                        accept="video/*"
                                                        class="hidden"
                                                        id="video-input"
                                                        @change="const file = $event.target.files[0]; if(file){ videoUrl = URL.createObjectURL(file); showVideoPreview = true; }">

                                                    <div class="flex justify-between items-center mt-3">
                                                        <div class="flex space-x-2">
                                                            <button type="button"
                                                                onclick="document.getElementById('image-input').click()"
                                                                class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 p-2 rounded-md hover:bg-gray-100">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                <span>Image</span>
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
                                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                                            Publier
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-6">
                                        @foreach($posts as $post)
                                        <div class="bg-white rounded-lg shadow-sm">
                                            <div class="p-4">
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

                                                    <div class="mt-4 flex items-center space-x-4">
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

                                                        <button class="flex items-center space-x-1 text-gray-500 hover:text-blue-500" onclick="document.getElementById('comments-{{ $post->id }}').classList.toggle('hidden')" data-post-id="{{ $post->id }}">
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
                                        </div>

                                        <x-modal name="edit-post-{{ $post->id }}" focusable>
                                            <form method="POST" action="{{ route('posts.update', $post) }}" class="p-6" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <h2 class="text-lg font-medium text-gray-900">Modifier le post</h2>
                                                <div class="mt-6">
                                                    <textarea name="content"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-1"
                                                        rows="4"
                                                        required>{{ $post->content }}</textarea>
                                                </div>


                                                @if($post->code_snippet)
                                                <div class="mt-4">
                                                    <label class="block text-sm font-medium text-gray-700">Code</label>
                                                    <textarea name="code_snippet"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono px-2 py-1 "
                                                        rows="4">{{ $post->code_snippet }}</textarea>
                                                </div>
                                                @endif

                                                @if($post->media)
                                                @if(isset($post->media['images']))
                                                <div class="mt-4">
                                                    <h3 class="font-semibold">Images existantes :</h3>
                                                    @foreach($post->media['images'] as $image)
                                                    <img src="{{ $image }}" alt="Image du post" class="mt-2 w-64 rounded-md">
                                                    @endforeach
                                                    <div class="mt-2">
                                                        <label class="block text-sm font-medium text-gray-700">Remplacer l'image :</label>
                                                        <input type="file" name="image" accept="image/*" class="mt-1 block w-full">
                                                    </div>
                                                </div>
                                                @endif

                                                @if(isset($post->media['videos']))
                                                <div class="mt-4">
                                                    <h3 class="font-semibold">Vidéos existantes :</h3>
                                                    @foreach($post->media['videos'] as $video)
                                                    <video controls class="mt-2 w-64 rounded-md">
                                                        <source src="{{ $video }}" type="video/mp4">
                                                        Votre navigateur ne supporte pas la lecture de vidéos.
                                                    </video>
                                                    @endforeach
                                                    <div class="mt-2">
                                                        <label class="block text-sm font-medium text-gray-700">Remplacer la vidéo :</label>
                                                        <input type="file" name="video" accept="video/*" class="mt-1 block w-full">
                                                    </div>
                                                </div>
                                                @endif
                                                @endif

                                                <div class="mt-6 flex justify-end">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        Annuler
                                                    </x-secondary-button>
                                                    <x-primary-button class="ml-3">
                                                        Mettre à jour
                                                    </x-primary-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                        @endforeach

                                        <div class="mt-4">
                                            {{ $posts->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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