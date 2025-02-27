@props(['reply'])

<div id="reply-{{ $reply->id }}" class="mt-4 ml-8">
    <div class="flex items-start space-x-3">
        <img src="{{ $reply->user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
            alt="Avatar"
            class="w-6 h-6 rounded-full">
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <h4 class="font-semibold text-sm">{{ $reply->user->name }}</h4>
                <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
            </div>
            
            <!-- Contenu de la réponse -->
            <p class="mt-1 text-sm text-gray-800" id="reply-{{ $reply->id }}-content">
                {{ $reply->content }}
            </p>

            <!-- Actions -->
            @if($reply->user_id === auth()->id())
            <div class="mt-2 flex items-center space-x-4 text-xs">
                <button onclick="toggleEditComment('reply-{{ $reply->id }}')"
                    class="text-gray-500 hover:text-blue-500">
                    Modifier
                </button>
                <button class="text-gray-500 hover:text-red-500 delete-comment"
                    data-comment-id="{{ $reply->id }}"
                    data-post-id="{{ $reply->post_id }}"
                    data-url="{{ route('comments.destroy', $reply) }}">
                    Supprimer
                </button>
            </div>
            @endif

            <!-- Formulaire d'édition -->
            <div id="edit-reply-{{ $reply->id }}" class="mt-3" style="display: none;">
                <form action="{{ route('comments.update', $reply) }}" method="POST" 
                    class="edit-comment-form" data-comment-id="{{ $reply->id }}">
                    @csrf
                    @method('PUT')
                    <textarea name="content"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="2">{{ $reply->content }}</textarea>
                    <div class="mt-2 flex justify-end space-x-2">
                        <button type="button"
                            onclick="toggleEditComment('reply-{{ $reply->id }}')"
                            class="px-3 py-1 text-xs text-gray-600 hover:text-gray-800">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-3 py-1 text-xs bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 