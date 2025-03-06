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
                            <button class="open-create-post-btn flex-grow text-left px-4 py-3 rounded-full border border-gray-300 hover:bg-gray-100 text-gray-500">
                                Commencer un post
                            </button>
                        </div>
                        <div class="flex justify-between mt-4 pt-2 border-t">
                            <button class="open-create-post-btn flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg text-gray-600">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Photo</span>
                            </button>
                            <button class="open-create-post-btn flex items-center space-x-2 text-gray-500 hover:text-blue-500 p-2 rounded-md hover:bg-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Vidéo</span>
                            </button>
                            <button class="open-create-post-btn flex items-center space-x-2 text-gray-500 hover:text-blue-500 p-2 rounded-md hover:bg-gray-100">
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

                        <!-- Loading indicator for infinite scrolling -->
                        <div id="loading-indicator" class="mt-8 flex justify-center hidden">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        </div>

                        <!-- No more posts indicator -->
                        <div id="no-more-posts" class="mt-8 text-center text-gray-500 hidden">
                            Pas d'autres publications à afficher
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
        console.log('Opening edit modal for post:', postId);
        const modal = document.getElementById('editPostModal');
        if (!modal) {
            console.error('Edit post modal not found!');
            return;
        }
        
        const form = document.getElementById('editPostForm');
        if (!form) {
            console.error('Edit post form not found!');
            return;
        }
        
        const contentTextarea = document.getElementById('editPostContent');
        const languageInput = document.getElementById('editPostLanguage');
        const codeSnippetTextarea = document.getElementById('editPostCodeSnippet');
        const currentImagePreview = document.getElementById('currentImagePreview');
        const currentImage = document.getElementById('currentImage');
        const currentVideoPreview = document.getElementById('currentVideoPreview');
        const currentVideo = document.getElementById('currentVideo');

        form.action = `/posts/${postId}`;
        
        if (contentTextarea) {
            contentTextarea.value = content || '';
        }

        if (languageInput) {
            languageInput.value = language || '';
        }

        if (codeSnippetTextarea) {
            codeSnippetTextarea.value = codeSnippet || '';
        }

        // Handle image preview
        if (currentImage && currentImagePreview) {
            if (imageUrl && imageUrl !== 'undefined' && imageUrl !== 'null') {
                currentImage.src = imageUrl;
                currentImagePreview.classList.remove('hidden');
            } else {
                currentImagePreview.classList.add('hidden');
            }
        }

        // Handle video preview
        if (currentVideo && currentVideoPreview) {
            if (videoUrl && videoUrl !== 'undefined' && videoUrl !== 'null') {
                currentVideo.src = videoUrl;
                currentVideoPreview.classList.remove('hidden');
            } else {
                currentVideoPreview.classList.add('hidden');
            }
        }

        modal.classList.remove('hidden');
        console.log('Modal opened successfully');
    }

    function closeEditPost() {
        const modal = document.getElementById('editPostModal');
        modal.classList.add('hidden');
    }
    
    function toggleDropdown(postId) {
        const dropdownMenu = document.getElementById(`dropdown-menu-${postId}`);
        if (dropdownMenu) {
            dropdownMenu.classList.toggle('hidden');
            
            // Close other open dropdowns
            document.querySelectorAll('.dropdown-container').forEach(container => {
                if (container.id !== `dropdown-${postId}`) {
                    const menu = container.querySelector('div[id^="dropdown-menu-"]');
                    if (menu && !menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                    }
                }
            });
            
            // Close this dropdown when clicking outside
            document.addEventListener('click', function closeDropdown(event) {
                const container = document.getElementById(`dropdown-${postId}`);
                if (container && !container.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                    document.removeEventListener('click', closeDropdown);
                }
            });
        }
    }

    // Add new function to handle create post form
    document.addEventListener('DOMContentLoaded', function() {
        // Get all buttons with class 'open-create-post-btn'
        const createPostButtons = document.querySelectorAll('.open-create-post-btn');
        const createPostModal = document.getElementById('createPostModal');

        // Add click event to all create post buttons
        createPostButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (createPostModal) {
                    createPostModal.classList.remove('hidden');
                }
            });
        });

        // Close modal when clicking outside
        if (createPostModal) {
            createPostModal.addEventListener('click', function(e) {
                if (e.target === createPostModal) {
                    createPostModal.classList.add('hidden');
                }
            });
        }

        // Close modal when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && createPostModal) {
                createPostModal.classList.add('hidden');
            }
        });
    });
</script>

<!-- Create Post Modal -->
<div id="createPostModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto z-50">
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white w-full max-w-md rounded-2xl shadow-xl p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Créer une publication</h3>
            <button onclick="document.getElementById('createPostModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <textarea name="content" rows="4" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Que voulez-vous partager ?"></textarea>
                </div>

                <div>
                    <input type="text" name="language" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Langage de programmation (optionnel)">
                </div>

                <div>
                    <textarea name="code_snippet" rows="4" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Ajouter un extrait de code (optionnel)"></textarea>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="images[]" accept="image/*" class="mt-1" multiple>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vidéo</label>
                        <input type="file" name="videos[]" accept="video/*" class="mt-1" multiple>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Publier
                    </button>
                </div>
            </form>
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
</script>@endpush

