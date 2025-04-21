<div id="reaction-container-{{ $post->id }}" class="relative">
    <button type="button" class="reaction-button flex items-center justify-center bg-gray-50 rounded-xl px-4 py-2.5 hover:bg-brand-50 transition w-full">
        <span class="mr-2">{{ $userReaction ? ($reactionEmojis[$userReaction->reaction] ?? '👍') : '👍' }}</span>
        <span class="font-medium">{{ $userReaction ? ucfirst($userReaction->reaction) : 'Like' }}</span>
    </button>
    
    <div class="reaction-container absolute top-full left-0 mt-2 bg-white border rounded-xl shadow-hover flex space-x-1 p-2 hidden z-10">
        @foreach ($reactionEmojis as $key => $emoji)
        <form 
            hx-post="{{ route('posts.react.store', $post->id) }}"
            hx-target="#reaction-container-{{ $post->id }}" 
            hx-swap="outerHTML"
            hx-trigger="click"
            class="inline">
            @csrf
            <button type="submit" name="reaction" value="{{ $key }}" class="text-2xl hover:bg-gray-100 rounded-full p-1.5 transition">
                {{ $emoji }}
            </button>
        </form>
        @endforeach
    </div>
</div>
