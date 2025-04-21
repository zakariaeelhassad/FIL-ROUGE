<div class="bg-white rounded-xl p-5">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold text-gray-900">Activité</h2>
        <button onclick="openModal('activiteModal')" class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-full transition shadow-sm flex items-center">
            <i class="fas fa-plus h-4 w-4 mr-1"></i>
            Create Post
        </button>
    </div>

    @if($posts->count() > 0)
        <div class="space-y-5">
            @foreach($posts as $post)
                <div class="bg-gray-50 rounded-xl overflow-hidden hover:bg-gray-100 transition hover-lift">
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-brand-100 border border-brand-200">
                                <img 
                                    src="{{ asset('storage/' . Auth::user()->profile_image ?? 'default-avatar.png') }}" 
                                    alt="Profile" 
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-brand-700">{{ $post->title ?? Auth::user()->full_name }}</p>
                                <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-4 leading-relaxed">
                            {{ $post->content }}
                        </p>

                        @if($post->images->isNotEmpty())
                            <div class="rounded-lg overflow-hidden mb-4 bg-white border border-gray-200">
                                @foreach($post->images as $image)
                                    <img 
                                        src="{{ asset('storage/' . $image->path) }}" 
                                        alt="Post image" 
                                        class="w-full object-cover max-h-80"
                                    >
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="flex border-t border-gray-200">
                        <button class="flex-1 flex items-center justify-center py-3 text-gray-600 hover:bg-gray-200 transition">
                            <i class="fas fa-thumbs-up h-5 w-5 mr-2"></i>
                            Like
                        </button>
                        <button class="flex-1 flex items-center justify-center py-3 text-gray-600 hover:bg-gray-200 transition">
                            <i class="fas fa-comment h-5 w-5 mr-2"></i>
                            Comment
                        </button>
                        <button class="flex-1 flex items-center justify-center py-3 text-gray-600 hover:bg-gray-200 transition">
                            <i class="fas fa-share h-5 w-5 mr-2"></i>
                            Share
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <button class="w-full py-3 mt-5 text-center text-gray-700 hover:bg-gray-100 rounded-xl transition font-medium">
            View All Posts
        </button>
    @else
        <div class="text-center py-10 bg-gray-50 rounded-xl">
            <i class="fas fa-microphone h-12 w-12 text-gray-400"></i>
            <p class="mt-4 text-gray-500">No posts yet</p>
            <p class="text-sm text-gray-400 mt-1">Click the "Create Post" button to share your first update</p>
        </div>
    @endif
</div>

@if($profile)
<div id="activiteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl animate-fade-in">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Create New Post</h3>
            <button type="button" onclick="closeModal('activiteModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times h-5 w-5"></i>
            </button>
        </div>
        
        <form 
            id="create-post-form" 
            action="{{ route('posts.store') }}" 
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4"
        >
            @csrf
            
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-brand-100 border border-brand-200">
                    <img 
                        src="{{ asset('storage/' . Auth::user()->profile_image ?? 'default-avatar.png') }}" 
                        alt="Profile" 
                        class="w-full h-full object-cover"
                    >
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->full_name }}</p>
                    <p class="text-xs text-gray-500">Posting publicly</p>
                </div>
            </div>
            
            <textarea 
                name="content" 
                rows="4" 
                class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                placeholder="What's on your mind?"
                required
            ></textarea>
            
            <div>
                <label for="post_image" class="block text-sm font-medium text-gray-700 mb-1">Add Image (Optional)</label>
                <input 
                    type="file" 
                    name="image" 
                    id="post_image"
                    accept="image/*" 
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100"
                >
            </div>

            <div class="flex justify-end mt-5 space-x-3">
                <button type="button" onclick="closeModal('activiteModal')" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-sm bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                    Post
                </button>
            </div>
        </form>
    </div>
</div>
@endif
