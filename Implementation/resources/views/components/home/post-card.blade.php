<div class="bg-white rounded-2xl border border-gray-100 shadow-soft hover-lift overflow-hidden">
    <!-- Post Header -->
    <div class="p-5 flex items-start space-x-3">
        <a href="{{ route('profil.show', ['id' => $post->user->id]) }}">
            <img
            src="{{ asset('storage/' . $post->user->profile_image ) ?? 'https://placehold.co/100x100/3b82f6/ffffff.png?text='.substr($request->follower->full_name, 0, 2) }}"
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
                <div class="text-gray-400">
                    <button class="hover:text-brand-500 p-1 rounded-full hover:bg-gray-50">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            <div class="text-gray-400 text-xs mt-1">
                {{ $post->created_at->diffForHumans() }}
            </div>
        </div>
    </div>

    <!-- Post Content -->
    <div class="px-5 pb-4">
        <p class="text-gray-800 leading-relaxed">{{ $post->content }}</p>
        <button class="text-brand-500 font-medium text-sm mt-2 hover:underline">voir plus</button>
    </div>

    <!-- Post Images -->
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

    <!-- Action Buttons -->
    <div class="px-5 py-3 flex space-x-2">

        <div id="reaction-container-{{ $post->id }}" class="relative flex-1">
            <button type="button" class="reaction-button flex items-center justify-center w-full bg-gray-50 rounded-xl px-4 py-2.5 hover:bg-brand-50 transition">
                <span class="mr-2">{{ $userReaction ? ($reactionEmojis[$userReaction->reaction] ?? '👍') : '👍' }}</span>
                <span class="font-medium">{{ $userReaction ? ucfirst($userReaction->reaction) : 'Like' }}</span>
            </button>
            
            <div class="reaction-container absolute top-full left-0 mt-2 bg-white border rounded-xl shadow-hover flex space-x-1 p-2 hidden z-10">
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

    <!-- Comments Section -->
    <div class="comment-section hidden border-t border-gray-100" id="comment-section-{{ $post->id }}">
        <div class="p-5">
            <form hx-post="/posts/{{ $post->id }}/comment" 
                hx-target="#comments-container-{{ $post->id }}" 
                hx-swap="beforeend"
                class="flex items-center mb-4">
                @csrf
                <img 
                    src="{{ asset('storage/' . $authUser->profile_image ?? 'default-avatar.png') }}" 
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
