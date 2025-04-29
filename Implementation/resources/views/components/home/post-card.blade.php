<div class="bg-white rounded-2xl border border-gray-100 shadow-soft hover-lift">
    <!-- Post Header -->
    <div class="p-5 flex items-start space-x-3">
        <a href="{{ route('profil.show', ['id' => $post->user->id]) }}">
            <img
            src="{{ asset('storage/' . ($post->user->profile_image  ?? '../../../images/la-personne.png')) }}"
            alt="Profile"
            class="rounded-full w-12 h-12 object-cover border-2 border-brand-100"
        />
        </a>
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-brand-600 font-bold text-lg">{{ $post->user ? $post->user->full_name : 'Unknown User' }}</h3>
                    <p class="text-gray-500 text-sm">{{ $post->user ? $post->user->bio : 'No Bio Available' }}</p>
                </div>
                @if(auth()->check() && auth()->id() !== $post->user_id)
                <div class="text-gray-400 relative group">
                    <button class="hover:text-brand-500 p-1 rounded-full hover:bg-gray-50"
                            onclick="togglePostDropdown({{ $post->id }})">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>

                    <div id="dropdown-{{ $post->id }}" class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-xl shadow-md z-20 hidden">
                        <button
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            onclick="openReportModal({{ $post->id }}, 'post')"
                        >
                            Signaler ce post
                        </button>
                    </div>
                </div>
                @endif
                @if(auth()->check() && auth()->id() === $post->user_id)
                    <div class="relative inline-block text-left">
                        <button onclick="toggleOwnerDropdown(this)" class="hover:text-brand-500 p-1 rounded-full hover:bg-gray-50 focus:outline-none">
                            <i class="fas fa-ellipsis-v"></i>
                       </button>    
                        <div class="dropdown-menu absolute right-0 mt-2 w-28 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50">
                            <div class="py-1 text-sm text-gray-700">                                              
                                <form action="{{ route('delete.post', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')" class="block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-500">Delete</button>
                                </form>                                                                                            
                            </div>
                        </div>
                    </div> 
                @endif                 
            </div>
            <div class="text-gray-400 text-xs mt-1">
                {{ $post->created_at->diffForHumans() }}
            </div>
        </div>
    </div>

    <div class="px-5 pb-4">
        <p class="text-gray-800">{{ $post->content }}</p>
    </div>

    @if($post->media->isNotEmpty())
        <div class="border-t border-b border-gray-100 space-y-4 mt-4">
            @foreach($post->media as $media)
                @if($media->type === 'image')
                    <img 
                        src="{{ asset('storage/' . $media->path) }}" 
                        alt="Post image" 
                        class="w-full object-cover rounded-xl"
                    >
                @elseif($media->type === 'video')
                    <video 
                        controls 
                        class="w-full rounded-xl"
                    >
                        <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                        Ton navigateur ne supporte pas la lecture vidéo.
                    </video>
                @endif
            @endforeach
        </div>
    @endif

    <div class="px-5 py-3 flex items-center justify-between border-b border-gray-100">
        <div class="flex items-center space-x-1">
            @php
                $reactionEmojis = [
                    'like' => '👍',
                    'love' => '❤️',
                    'wow' => '😲',
                    'haha' => '😂',
                    'sad' => '😢',
                    'grr'  => '😡',
                ];
                
                $userReaction = App\Models\Reaction::where('user_id', auth()->id())
                    ->where('post_id', $post->id)
                    ->first();
            @endphp
            <span class="text-gray-500 text-sm ml-1">{{ $post->reactions->count() }} Réaction</span>
            <span class="mx-1">•</span> 
        </div>
        
        <div class="text-gray-500 text-sm">
            @php
                $totalComments = $post->comments->count(); 
                $totalReplies = $post->comments->sum(function($comment) {
                    return $comment->replies->count();
                });
                $total = $totalComments + $totalReplies;
            @endphp
        
            <span>{{ $total }} comments</span>
            <span class="mx-1">•</span> 
        </div>
        
    </div>

    <div class="px-5 py-3 flex space-x-2">

        <div id="reaction-container-{{ $post->id }}" class="relative flex-1">
            <button type="button" class="reaction-button flex items-center justify-center w-full bg-gray-50 rounded-xl px-4 py-2.5 hover:bg-brand-50 transition">
                <span class="mr-2">{{ $userReaction ? ($reactionEmojis[$userReaction->reaction] ?? '👍') : '👍' }}</span>
                <span class="font-medium">{{ $userReaction ? ucfirst($userReaction->reaction) : 'Like' }}</span>
            </button>            
        
            <div class="reaction-container absolute top-full left-0 mt-2 bg-white border rounded-xl shadow-hover flex space-x-1 p-2 hidden z-10 w-full min-h-[48px]">
                @foreach ($reactionEmojis as $key => $emoji)
                    <form hx-post="{{ route('posts.react.store', $post->id) }}" 
                        hx-target="#reaction-container-{{ $post->id }}" 
                        hx-swap="outerHTML"
                        class="inline">
                        @csrf
                        <button type="submit" name="reaction" value="{{ $key }}" class="text-2xl hover:bg-gray-100 rounded-full p-1.5 transition">
                            {{ $emoji }}
                        </button>
                    </form>
                @endforeach
            </div>
        </div>        

        <button type="button" class="comment-button flex items-center justify-center flex-1 bg-gray-50 rounded-xl px-4 py-2.5 hover:bg-brand-50 transition" 
                data-post-id="{{ $post->id }}">
            <span class="mr-2">💬</span>
            <span class="font-medium">Comment</span>
        </button>
    </div>

    @if ($post->userReactions && $post->userReactions->isNotEmpty())
        <div class="px-5 pb-4">
            <form action="/posts/{{ $post->id }}/react" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="bg-red-50 text-red-500 border border-red-200 rounded-xl py-2 px-4 text-sm font-medium hover:bg-red-100 transition">
                    Remove Reaction
                </button>
            </form>
        </div>
    @endif

    <div class="comment-section hidden border-t border-gray-100" id="comment-section-{{ $post->id }}">
        <div class="p-5">
            <form hx-post="/posts/{{ $post->id }}/comment" 
                hx-target="#comments-container-{{ $post->id }}" 
                hx-swap="beforeend"
                class="flex items-center mb-4">
                @csrf
                <img 
                    src="{{ asset('storage/' . ($authUser->profile_image ?? '../../../images/la-personne.png')) }}" 
                    class="w-8 h-8 rounded-full object-cover mr-3 border border-brand-100"
                    alt="Profile"
                >
                <input 
                    type="text" 
                    name="content" 
                    class="border border-gray-200 rounded-full px-4 py-2 flex-grow focus:outline-none focus:ring-2 focus:ring-brand-300" 
                    placeholder="Write a comment..." 
                    required 
                    id="comment-input-{{ $post->id }}"
                >
                <button type="submit" class="bg-brand-500 text-white rounded-full px-4 py-2 ml-2 hover:bg-brand-600 transition">
                    Post
                </button>
            </form>
            
            <div id="comments-container-{{ $post->id }}" class="comments-list space-y-4">
                @foreach($post->comments ?? [] as $comment)
                @include('partials.comments', ['comment' => $comment])
                @endforeach
            </div>
        </div>
    </div>
</div> 


<div id="report-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl">
        <h2 class="text-lg font-semibold mb-4">Signaler un contenu</h2>
        <form method="POST" action="{{ route('reports.store') }}">
            @csrf
            <input type="hidden" name="reported_type" id="reported_type">
            <input type="hidden" name="reported_id" id="reported_id">

            <label class="block text-sm font-medium text-gray-700 mb-1">Raison</label>
            <textarea name="reason" rows="4" required class="w-full border border-gray-300 rounded-lg p-2 mb-4 focus:outline-none focus:ring-2 focus:ring-brand-200"></textarea>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeReportModal()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Annuler</button>
                <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">Envoyer</button>
            </div>
        </form>
    </div>
</div>

<script>
// For other users' dropdown (report)
function togglePostDropdown(postId) {
    const dropdown = document.getElementById('dropdown-' + postId);
    if (dropdown) dropdown.classList.toggle('hidden');
}

// For post owner dropdown (edit/delete)
function toggleOwnerDropdown(button) {
    const dropdown = button.nextElementSibling;
    if (dropdown && dropdown.classList.contains('dropdown-menu')) {
        dropdown.classList.toggle('hidden');
    }
}

function openReportModal(id, type) {
    document.getElementById('reported_id').value = id;
    document.getElementById('reported_type').value = type;
    document.getElementById('report-modal').classList.remove('hidden');
    document.getElementById('report-modal').classList.add('flex');
}

function closeReportModal() {
    document.getElementById('report-modal').classList.remove('flex');
    document.getElementById('report-modal').classList.add('hidden');
}

function openEditModal(postId, content, media = []) {
    const modal = document.getElementById('editPostModal');
    const form = document.getElementById('edit-post-form');
    const textarea = document.getElementById('edit-post-content');
    const mediaContainer = document.getElementById('existing-media-container');
    const removeMediaBtn = document.getElementById('remove-media-btn');

    form.action = `/update/${postId}/post`;
    textarea.value = content;
    mediaContainer.innerHTML = '';

    if (media.length > 0) {
        media.forEach(item => {
            const mediaElement = item.type === 'image' 
                ? `<img src="/storage/${item.path}" class="w-full h-24 object-cover rounded-lg border border-gray-200" alt="Media">`
                : `<video controls class="w-full h-24 object-cover rounded-lg border border-gray-200">
                     <source src="/storage/${item.path}" type="video/mp4">
                   </video>`;
            
            mediaContainer.innerHTML += `
                <div class="relative group">
                    ${mediaElement}
                    <input type="checkbox" name="keep_media[]" value="${item.id}" checked 
                           class="absolute top-2 left-2 h-5 w-5 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition"></div>
                </div>
            `;
        });

        removeMediaBtn.classList.remove('hidden');
        removeMediaBtn.onclick = () => {
            document.querySelectorAll('input[name="keep_media[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            removeMediaBtn.classList.add('hidden');
        };
    } else {
        removeMediaBtn.classList.add('hidden');
    }

    modal.classList.remove('hidden');
}
</script>