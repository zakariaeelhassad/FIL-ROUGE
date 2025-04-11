<!-- Button Créer un post -->
<button 
    onclick="document.getElementById('create-post-form').classList.toggle('hidden')" 
    class="px-3 py-1 border border-blue-500 text-blue-500 rounded-full text-sm">
    Créer un post
</button>

<!-- Formulaire de création de post -->
<form 
    id="create-post-form" 
    action="{{ route('posts.store') }}" 
    method="POST"
    class="hidden mt-4 border border-blue-300 p-4 rounded-xl bg-white space-y-3"
>
    @csrf

    <!-- Contenu -->
    <textarea name="content" rows="3" class="w-full border rounded p-2" placeholder="Exprimez-vous..."></textarea>

    <!-- Image URL (input simple pour test, plus tard n9adro ndir file upload) -->
    <input type="text" name="image" placeholder="Lien de l'image" class="w-full border rounded p-2" />

    <!-- Bouton d'envoi -->
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600">
        Publier
    </button>
</form>
