
<div class="mt-4 border-2 border-blue-400 rounded-xl p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-lg">Activité</h2>
        <button onclick="openModal('activiteModal')" class="px-3 py-1 border border-blue-500 text-blue-500 rounded-full text-sm">
            Créer un post
        </button>
    </div>

    @if($posts->count() > 0)
        @foreach($posts as $post)
            <div class="border border-blue-300 rounded-xl p-3 mb-4">
                <div class="flex items-center mb-2">
                    <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white">
                        <span></span>
                    </div>
                    <div class="ml-2">
                        <p class="text-xs text-blue-500">{{ $post->title ?? 'Post' }}</p>
                        <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <p class="text-sm text-gray-700 mb-3">
                    {{ $post->content }}
                </p>

                @if($post->images->isNotEmpty())
                <div class="w-full h-40 bg-gray-200 mb-4 rounded-lg overflow-hidden">
                    @foreach($post->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Image" class="w-full h-full object-cover">
                    @endforeach
                </div>
                @endif

                <div class="flex space-x-2">
                    <button class="flex-1 flex items-center justify-center bg-gray-200 rounded-full py-1">
                        <span class="text-gray-500">👍</span>
                    </button>
                    <button class="flex-1 flex items-center justify-center bg-gray-200 rounded-full py-1">
                        <span class="text-gray-500">💬</span>
                    </button>
                    <button class="flex-1 flex items-center justify-center bg-gray-200 rounded-full py-1">
                        <span class="text-gray-500">🔄</span>
                    </button>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-center text-gray-500">Aucun post pour le moment</p>
    @endif

    <button class="w-full py-2 text-center text-gray-700 hover:bg-gray-100 rounded">
        Afficher tous les posts
    </button>
</div>

@if($profile)
<div id="activiteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Edit activite</h3>
        
        <form 
            id="create-post-form" 
            action="{{ route('posts.store') }}" 
            method="POST"
            enctype="multipart/form-data"
            class="mt-4 border border-blue-300 p-4 rounded-xl bg-white space-y-3"
            >
            @csrf

            <textarea name="content" rows="3" class="w-full border rounded p-2" placeholder="Exprimez-vous..."></textarea>

            <input type="file" name="image" accept="image/*" class="w-full border rounded p-2" />

            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeModal('activiteModal')" class="mr-2 px-4 py-1 text-sm border rounded">Cancel</button>
                <button type="submit" class="px-4 py-1 text-sm bg-blue-500 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>
@endif
