<x-app-layout>


    <div class="py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-gray-50">
                        <!-- Main Content -->
                        <div class="max-w-7xl mx-auto pt-20 px-4">
                            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                                <!-- Profile Card -->
                                <div class="space-y-6">
                                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                                        <div class="relative">
                                            <div class="h-24 bg-gradient-to-r from-blue-600 to-blue-400"></div>
                                            <img src="https://avatar.iran.liara.run/public/boy" alt="Profile"
                                                class="absolute -bottom-6 left-4 w-20 h-20 rounded-full border-4 border-white shadow-md" />
                                        </div>
                                        <div class="pt-14 p-4">
                                            <div class="flex items-center justify-between">
                                                <h2 class="text-xl font-bold">Sarah Connor</h2>
                                                <a href="https://github.com" target="_blank" class="text-gray-600 hover:text-black">
                                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.237 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <p class="text-gray-600 text-sm mt-1">Senior Full Stack Developer</p>
                                            <p class="text-gray-500 text-sm mt-2">Building scalable web applications with modern technologies</p>

                                            <div class="mt-4 flex flex-wrap gap-2">
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">JavaScript</span>
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Node.js</span>
                                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">React</span>
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Python</span>
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Docker</span>
                                            </div>

                                            <div class="mt-4 pt-4 border-t">
                                                <div class="flex justify-between text-sm">
                                                    <span class="text-gray-500">Connections</span>
                                                    <span class="text-blue-600 font-medium">487</span>
                                                </div>
                                                <div class="flex justify-between text-sm mt-2">
                                                    <span class="text-gray-500">Posts</span>
                                                    <span class="text-blue-600 font-medium">52</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Popular Tags -->
                                    <div class="bg-white rounded-xl shadow-sm p-4">
                                        <h3 class="font-semibold mb-4">Trending Tags</h3>
                                        <div class="space-y-2">
                                            <a href="#" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded">
                                                <span class="text-gray-600">#javascript</span>
                                                <span class="text-gray-400 text-sm">2.4k</span>
                                            </a>
                                            <a href="#" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded">
                                                <span class="text-gray-600">#react</span>
                                                <span class="text-gray-400 text-sm">1.8k</span>
                                            </a>
                                            <a href="#" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded">
                                                <span class="text-gray-600">#webdev</span>
                                                <span class="text-gray-400 text-sm">1.2k</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Feed -->
                                <div class="lg:col-span-2 space-y-6">
                                    <!-- Post Creation -->
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

                                                    <!-- Prévisualisation Image -->
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

                                                    <!-- Prévisualisation Vidéo -->
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

                                                    <!-- Éditeur de Code -->
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

                                                    <!-- Inputs cachés pour les fichiers -->
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

                                    <!-- Posts -->
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

                                                    <!-- Affichage des médias -->
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

                                                    <!-- Code snippet existant -->
                                                    @if($post->code_snippet)
                                                    <div class="mt-4 bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200">
                                                        @if($post->programming_language)
                                                        <div class="text-xs text-gray-400 mb-2">{{ strtoupper($post->programming_language) }}</div>
                                                        @endif
                                                        <pre><code>{{ $post->code_snippet }}</code></pre>
                                                    </div>
                                                    @endif

                                                    <!-- Hashtags existants -->
                                                    @if($post->hashtags->count() > 0)
                                                    <div class="mt-4 flex flex-wrap gap-2">
                                                        @foreach($post->hashtags as $hashtag)
                                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                                            #{{ $hashtag->name }}
                                                        </span>
                                                        @endforeach
                                                    </div>
                                                    @endif

                                                    <!-- Ajouter cette section juste avant la section des commentaires -->
                                                    <div class="flex items-center space-x-4 mt-4">
                                                        <form action="{{ route('posts.like', $post) }}" method="POST" class="flex items-center space-x-1">
                                                            @csrf
                                                            <button type="submit" class="text-gray-500 hover:text-blue-500 focus:outline-none">
                                                                <svg class="w-6 h-6" fill="{{ $post->likes()->where('user_id', auth()->id())->exists() ? 'currentColor' : 'none' }}"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                                </svg>
                                                            </button>
                                                            <span class="text-sm text-gray-500">{{ $post->likes_count }}</span>
                                                        </form>

                                                        <!-- Bouton Commentaires -->
                                                        <button class="flex items-center space-x-1 text-gray-500 hover:text-blue-500">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                            </svg>
                                                            <span class="text-sm">{{ $post->comments_count }}</span>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="border-t mt-4 pt-4">
                                                    <!-- Section Commentaires -->
                                                    <div class="space-y-4">
                                                        <!-- Formulaire d'ajout de commentaire -->
                                                        <form action="{{ route('posts.comments.add', $post) }}" method="POST" class="flex space-x-3">
                                                            @csrf
                                                            <img src="{{ auth()->user()->profile->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                                                alt="User"
                                                                class="w-8 h-8 rounded-full" />
                                                            <div class="flex-1">
                                                                <textarea
                                                                    name="content"
                                                                    placeholder="Ajouter un commentaire..."
                                                                    class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                    rows="1"></textarea>
                                                                <button type="submit" class="mt-2 px-4 py-1.5 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                                                                    Commenter
                                                                </button>
                                                            </div>
                                                        </form>

                                                        <!-- Liste des commentaires -->
                                                        @foreach($post->comments->where('parent_id', null) as $comment)
                                                        <div class="flex space-x-3">
                                                            <img src="{{ $comment->user->profile->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                                                alt="{{ $comment->user->name }}"
                                                                class="w-8 h-8 rounded-full" />
                                                            <div class="flex-1">
                                                                <div class="bg-gray-50 rounded-lg p-3">
                                                                    <div class="flex justify-between items-start">
                                                                        <div>
                                                                            <h4 class="font-semibold text-sm">{{ $comment->user->name }}</h4>
                                                                            <p class="text-gray-500 text-xs">{{ $comment->created_at->diffForHumans() }}</p>
                                                                        </div>
                                                                        @if($comment->user_id === auth()->id())
                                                                        <div class="relative" x-data="{ open: false }">
                                                                            <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                                                </svg>
                                                                            </button>
                                                                            <div x-show="open"
                                                                                @click.away="open = false"
                                                                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                                                                <button @click="$dispatch('open-modal', 'edit-comment-{{ $comment->id }}')"
                                                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                                    Modifier
                                                                                </button>
                                                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                                                        Supprimer
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                    <p class="text-gray-700 text-sm mt-1">{{ $comment->content }}</p>
                                                                </div>

                                                                <!-- Actions du commentaire -->
                                                                <div class="flex items-center mt-2 space-x-4">
                                                                    <button onclick="toggleReplyInput({{ $comment->id }})" class="text-sm text-blue-500 hover:text-blue-700">
                                                                        Répondre
                                                                    </button>
                                                                </div>

                                                                <!-- Champ de saisie pour répondre au commentaire -->
                                                                <div id="reply-input-{{ $comment->id }}" style="display: none;" class="mt-2">
                                                                    <form method="POST" action="{{ route('comments.reply', $comment) }}" class="flex space-x-3">
                                                                        @csrf
                                                                        <textarea name="content"
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                                            rows="2"
                                                                            required
                                                                            placeholder="Votre réponse..."></textarea>
                                                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                                                            Répondre
                                                                        </button>
                                                                    </form>
                                                                </div>

                                                                <!-- Réponses aux commentaires -->
                                                                @foreach($comment->replies as $reply)
                                                                <div class="ml-8 mt-2 flex space-x-3">
                                                                    <img src="{{ $reply->user->profile->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
                                                                        alt="{{ $reply->user->name }}"
                                                                        class="w-6 h-6 rounded-full" />
                                                                    <div class="flex-1 bg-gray-50 rounded-lg p-2">
                                                                        <div class="flex justify-between items-start">
                                                                            <div>
                                                                                <h4 class="font-semibold text-sm">{{ $reply->user->name }}</h4>
                                                                                <p class="text-gray-500 text-xs">{{ $reply->created_at->diffForHumans() }}</p>
                                                                            </div>
                                                                            @if($reply->user_id === auth()->id())
                                                                            <!-- Menu suppression pour les réponses -->
                                                                            <div class="relative" x-data="{ open: false }">
                                                                                <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                                                    </svg>
                                                                                </button>
                                                                                <div x-show="open"
                                                                                    @click.away="open = false"
                                                                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                                                                    <form action="{{ route('comments.destroy', $reply) }}" method="POST">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit"
                                                                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                                                            Supprimer
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                            @endif
                                                                        </div>
                                                                        <p class="text-gray-700 text-sm mt-1">{{ $reply->content }}</p>
                                                                    </div>
                                                                </div>
                                                                @endforeach

                                                                <!-- Modal pour modifier le commentaire -->
                                                                <x-modal name="edit-comment-{{ $comment->id }}" :show="false" focusable>
                                                                    <form method="POST" action="{{ route('comments.update', $comment) }}" class="p-6">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <h2 class="text-lg font-medium text-gray-900">Modifier le commentaire</h2>
                                                                        <div class="mt-6">
                                                                            <textarea name="content"
                                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                                                rows="3"
                                                                                required>{{ $comment->content }}</textarea>
                                                                        </div>
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
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal pour modifier le post -->
                                        <x-modal name="edit-post-{{ $post->id }}" focusable>
                                            <form method="POST" action="{{ route('posts.update', $post) }}" class="p-6">
                                                @csrf
                                                @method('PUT')
                                                <h2 class="text-lg font-medium text-gray-900">Modifier le post</h2>
                                                <div class="mt-6">
                                                    <textarea name="content"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                        rows="4"
                                                        required>{{ $post->content }}</textarea>
                                                </div>
                                                @if($post->code_snippet)
                                                <div class="mt-4">
                                                    <label class="block text-sm font-medium text-gray-700">Code</label>
                                                    <textarea name="code_snippet"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono"
                                                        rows="4">{{ $post->code_snippet }}</textarea>
                                                </div>
                                                <div class="mt-4">
                                                    <label class="block text-sm font-medium text-gray-700">Langage</label>
                                                    <input type="text"
                                                        name="programming_language"
                                                        value="{{ $post->programming_language }}"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                </div>
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
    function toggleReplyInput(commentId) {
        const replyInput = document.getElementById(`reply-input-${commentId}`);
        if (replyInput.style.display === "none" || replyInput.style.display === "") {
            replyInput.style.display = "block";
        } else {
            replyInput.style.display = "none";
        }
    }
</script>