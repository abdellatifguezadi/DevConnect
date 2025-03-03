<x-app-layout>
    <div class="min-h-screen bg-[#f3f2ef]">
        <div class="max-w-[1128px] mx-auto px-4 pt-20">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow p-6 mb-4">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-100">
                        <span class="text-blue-500 text-2xl font-bold">#</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">#{{ $tag->name }}</h1>
                        <p class="text-gray-500">{{ $tag->posts_count }} publication{{ $tag->posts_count > 1 ? 's' : '' }}</p>
                    </div>
                </div>
            </div>

            <!-- Posts -->
            <div class="space-y-4">
                @forelse($posts as $post)
                @include('components.post-card', ['post' => $post])
                @empty
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500">Aucune publication avec ce hashtag</p>
                </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>