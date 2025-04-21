<div class="flex items-start space-x-3">
    <img 
        src="{{ asset('storage/' . $comment->user->profile_image ?? 'default-avatar.png') }}" 
        alt="Profile"
        class="w-8 h-8 rounded-full object-cover border border-brand-100"
    >
    <div class="flex-grow">
        <div class="bg-gray-50 rounded-xl px-4 py-3">
            <div class="flex items-center justify-between mb-1">
                <h4 class="font-medium text-gray-800">{{ $comment->user->full_name }}</h4>
                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-gray-700 text-sm">{{ $comment->content }}</p>
        </div>                  
        
        <div class="flex space-x-4 mt-1.5 text-xs">
            <button class="text-gray-500 hover:text-brand-600 font-medium transition">
                Like
            </button>
            
            <button class="reply-button text-gray-500 hover:text-brand-600 font-medium transition" data-comment-id="{{ $comment->id }}">
                <i class="fas fa-reply text-gray-500 hover:text-brand-600"></i>
                Reply
            </button>
        </div>
        
        <div class="reply-form hidden mt-3" id="reply-form-{{ $comment->id }}">
            <form 
                hx-post="/comments/{{ $comment->id }}/replies" 
                hx-target="#replies-container-{{ $comment->id }}" 
                hx-swap="beforeend"
                class="flex items-center mb-3"
            >
                @csrf
                <img 
                    src="{{ asset('storage/' . Auth::user()->profile_image ?? 'default-avatar.png') }}" 
                    alt="Profile"
                    class="w-6 h-6 rounded-full object-cover border border-brand-100 mr-2"
                >
                <input 
                    type="text" 
                    name="content" 
                    class="border border-gray-200 rounded-full px-3 py-1.5 flex-grow text-sm focus:outline-none focus:ring-2 focus:ring-brand-300" 
                    placeholder="Write a reply..." 
                    required 
                    id="reply-input-{{ $comment->id }}"
                >
                <button 
                    type="submit" 
                    class="bg-brand-500 text-white rounded-full px-3 py-1.5 ml-2 text-xs font-medium hover:bg-brand-600 transition"
                >
                    Reply
                </button>
            </form>

            <div id="replies-container-{{ $comment->id }}" class="space-y-3 ml-6">
                @foreach($comment->replies as $reply)
                    @include('partials.replies', ['reply' => $reply])
                @endforeach
            </div>                                    
        </div>
    </div>
</div>
