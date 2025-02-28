<form id="editPostForm" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    <textarea name="content"
        id="editPostContent"
        rows="6"
        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        placeholder="Que voulez-vous partager ?"></textarea>

    @if(isset($post) && $post->code_snippet)
    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Code</label>
        <textarea name="code_snippet"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono"
            rows="4">{{ $post->code_snippet }}</textarea>
    </div>
    @endif

    <div class="flex justify-end space-x-3">
        <button type="button"
            onclick="closeEditPost()"
            class="px-6 py-3 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
            Annuler
        </button>
        <button type="submit"
            class="px-6 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition-colors">
            Enregistrer
        </button>
    </div>
</form>
