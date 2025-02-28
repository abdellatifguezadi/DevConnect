@props(['comment'])

<div id="comment-{{ $comment->id }}" class="comment mb-4 bg-white rounded-lg shadow p-4">
    <div class="flex items-start space-x-3">
        <img src="{{ $comment->user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy' }}"
            alt="Avatar"
            class="w-8 h-8 rounded-full">
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <h4 class="font-semibold">{{ $comment->user->name }}</h4>
                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            
            <!-- Contenu du commentaire -->
            <p class="mt-1 text-gray-800" id="comment-{{ $comment->id }}-content">
                {{ $comment->content }}
            </p>

            <div class="mt-2 flex items-center space-x-4 text-sm">
                @if($comment->user_id === auth()->id())
                <button onclick="toggleEditComment('{{ $comment->id }}')"
                    class="text-gray-500 hover:text-blue-500">
                    Modifier
                </button>
                <button class="text-gray-500 hover:text-red-500 delete-comment"
                    data-comment-id="{{ $comment->id }}"
                    data-post-id="{{ $comment->post_id }}"
                    data-url="{{ route('comments.destroy', $comment) }}">
                    Supprimer
                </button>
                @endif
            </div>

            <!-- Formulaire d'édition -->
            <div id="edit-comment-{{ $comment->id }}" class="mt-3" style="display: none;">
                <form action="{{ route('comments.update', $comment) }}" method="POST" 
                    class="edit-comment-form" data-comment-id="{{ $comment->id }}">
                    @csrf
                    @method('PUT')
                    <textarea name="content"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="2">{{ $comment->content }}</textarea>
                    <div class="mt-2 flex justify-end space-x-2">
                        <button type="button"
                            onclick="toggleEditComment('{{ $comment->id }}')"
                            class="px-3 py-1 text-gray-600 hover:text-gray-800">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-3 py-1 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition duration-200">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 