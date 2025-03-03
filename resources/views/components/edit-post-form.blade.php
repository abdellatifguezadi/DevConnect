<form id="editPostForm" method="POST" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <textarea name="content"
        id="editPostContent"
        rows="6"
        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        placeholder="Que voulez-vous partager ?"></textarea>

    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Langage de programmation</label>
        <input type="text" name="language" id="editPostLanguage"
            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Spécifiez le langage">
    </div>

    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Photo</label>
        <input type="file" name="image" accept="image/*"
            class="mt-1 block w-full text-sm text-gray-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-full file:border-0
            file:text-sm file:font-semibold
            file:bg-violet-50 file:text-violet-700
            hover:file:bg-violet-100">
        <p class="text-sm text-gray-500 mt-1">Choisissez une nouvelle image pour remplacer l'existante</p>

        <div id="currentImagePreview" class="mt-2 hidden">
            <p class="text-sm font-medium text-gray-700">Image actuelle:</p>
            <img id="currentImage" src="" alt="Image actuelle" class="mt-1 max-h-40 rounded-lg">
        </div>
    </div>

    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Vidéo</label>
        <input type="file" name="video" accept="video/mp4,video/mov,video/avi"
            class="mt-1 block w-full text-sm text-gray-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-full file:border-0
            file:text-sm file:font-semibold
            file:bg-violet-50 file:text-violet-700
            hover:file:bg-violet-100">
        <p class="text-sm text-gray-500 mt-1">Choisissez une nouvelle vidéo pour remplacer l'existante</p>

        <div id="currentVideoPreview" class="mt-2 hidden">
            <p class="text-sm font-medium text-gray-700">Vidéo actuelle:</p>
            <video id="currentVideo" src="" controls class="mt-1 max-w-full rounded-lg"></video>
        </div>
    </div>

    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Code</label>
        <textarea name="code_snippet" id="editPostCodeSnippet"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono"
            rows="4"></textarea>
    </div>

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