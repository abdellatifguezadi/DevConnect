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
                            <button x-data="" @click="$dispatch('open-modal', 'create-post')"
                                class="flex-grow text-left px-4 py-3 rounded-full border border-gray-300 hover:bg-gray-100 text-gray-500">
                                Commencer un post
                            </button>
                        </div>
                        <div class="flex justify-between mt-4 pt-2 border-t">
                            <button x-data="" @click="$dispatch('open-modal', 'create-post')" class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg text-gray-600">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Photo</span>
                            </button>
                            <button x-data="" @click="$dispatch('open-modal', 'create-post')"
                                class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 p-2 rounded-md hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Vidéo</span>
                            </button>
                            <button x-data="" @click="$dispatch('open-modal', 'create-post')"
                                class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 p-2 rounded-md hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                <span>Code</span>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div id="posts-container" class="space-y-8">
                            @foreach($posts as $post)
                            @if($post->language)
                            <div class="text-xs text-gray-400 mb-2">{{ strtoupper($post->language->name) }}</div>
                            @endif
                            @include('components.post-card', ['post' => $post])
                            @endforeach
                        </div>


                        <div class="mt-8 flex justify-center gap-4">
                            @if ($posts->onFirstPage())
                            <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                Précédent
                            </span>
                            @else
                            <a href="{{ $posts->previousPageUrl() }}"
                                class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg shadow transition duration-200">
                                Précédent
                            </a>
                            @endif

                            <span class="px-4 py-2 bg-white text-gray-600 rounded-lg">
                                Page {{ $posts->currentPage() }} sur {{ $posts->lastPage() }}
                            </span>

                            @if ($posts->hasMorePages())
                            <a href="{{ $posts->nextPageUrl() }}"
                                class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg shadow transition duration-200">
                                Suivant
                            </a>
                            @else
                            <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                Suivant
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

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

    function openEditPost(postId, content, language, codeSnippet, imageUrl, videoUrl) {
        const modal = document.getElementById('editPostModal');
        const form = document.getElementById('editPostForm');
        const contentTextarea = document.getElementById('editPostContent');
        const languageInput = document.getElementById('editPostLanguage');
        const codeSnippetTextarea = document.getElementById('editPostCodeSnippet');
        const currentImagePreview = document.getElementById('currentImagePreview');
        const currentImage = document.getElementById('currentImage');
        const currentVideoPreview = document.getElementById('currentVideoPreview');
        const currentVideo = document.getElementById('currentVideo');

        form.action = `/posts/${postId}`;
        contentTextarea.value = content;

        if (languageInput) {
            languageInput.value = language || '';
        }

        if (codeSnippetTextarea) {
            codeSnippetTextarea.value = codeSnippet || '';
        }

        // Handle image preview
        if (imageUrl && imageUrl !== 'undefined' && imageUrl !== 'null') {
            currentImage.src = imageUrl;
            currentImagePreview.classList.remove('hidden');
        } else {
            currentImagePreview.classList.add('hidden');
        }

        // Handle video preview
        if (videoUrl && videoUrl !== 'undefined' && videoUrl !== 'null') {
            currentVideo.src = videoUrl;
            currentVideoPreview.classList.remove('hidden');
        } else {
            currentVideoPreview.classList.add('hidden');
        }

        modal.classList.remove('hidden');
    }

    function closeEditPost() {
        const modal = document.getElementById('editPostModal');
        modal.classList.add('hidden');
    }
</script>

<x-modal name="create-post" :show="$errors->createPost->isNotEmpty()" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Créer un nouveau post
        </h2>

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

                <!-- <div>
                    <label class="block text-sm font-medium text-gray-700">Langue du contenu</label>
                    <input type="text" name="language" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Entrez la langue du contenu">
                </div> -->

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

                <!-- <div>
                    <label class="block text-sm font-medium text-gray-700">Hashtags</label>
                    <input type="text" name="hashtags"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Ajoutez des hashtags (séparés par des espaces)">
                </div> -->
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200" @click="$dispatch('close')">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Publier
                </button>
            </div>
        </form>
    </div>
</x-modal>

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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreButton = document.getElementById('load-more');
        const postsContainer = document.getElementById('posts-container');
        const loading = document.getElementById('loading');

        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', function() {
                loadMoreButton.classList.add('hidden');
                loading.classList.remove('hidden');

                const nextPage = loadMoreButton.dataset.nextPage;

                fetch(`/posts?page=${nextPage}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        postsContainer.insertAdjacentHTML('beforeend', data.html);
                        loading.classList.add('hidden');

                        if (data.hasMorePages) {
                            loadMoreButton.dataset.nextPage = parseInt(nextPage) + 1;
                            loadMoreButton.classList.remove('hidden');
                        } else {
                            loadMoreButton.remove();
                        }
                    });
            });
        }
    });
</script>
@endpush