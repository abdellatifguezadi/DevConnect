<form id="editPostForm" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    <textarea name="content"
        id="editPostContent"
        rows="6"
        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        placeholder="Que voulez-vous partager ?"></textarea>
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
