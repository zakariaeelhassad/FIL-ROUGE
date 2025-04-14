<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100">

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @include('components.navbar')

    <div class="bg-gray-100 flex items-start justify-center p-10">
        @include('components.home.mini_profil')

        <main class="space-y-6">
            @php
                $reactionEmojis = [
                    'like' => '👍',
                    'love' => '❤️',
                    'wow' => '😲',
                    'haha' => '😂',
                    'sad' => '😢',
                    'grr'  => '😡',
                ];
            @endphp
            @foreach ($posts as $post)
            <div class="w-[500px] bg-white rounded-3xl border border-blue-400 shadow-md p-6 cursor-pointer">
                <div class="flex items-center mb-4">
                    <img
                        alt="Profile"
                        class="rounded-full w-10 h-10 object-cover mr-3"
                    />
                    <div>
                        <h3 class="text-blue-500 font-bold">{{ $post->user ? $post->user->full_name : 'Unknown User' }}</h3>
                        <p class="text-gray-500 text-sm">{{ $post->user ? $post->user->bio : 'No Bio Available' }}</p>
                        <div class="text-gray-400 text-xs mb-4">
                            Posted on: {{ $post->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <div class="text-gray-800 text-sm mb-4">
                    <p>{{ $post->content }}</p>
                    <span class="text-blue-500 italic cursor-pointer">voir plus</span>
                </div>

                @if($post->images->isNotEmpty())
                <div class="w-full h-40 bg-gray-200 mb-4 rounded-lg overflow-hidden">
                    @foreach($post->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Image" class="w-full h-full object-cover">
                    @endforeach
                </div>
                @endif

                <div class="flex space-x-4 mt-4">
                    <div class="relative">
                        <form action="/posts/{{ $post->id }}/react" method="POST" class="z-10">
                            @csrf
                            @php
                                $userReaction = $post->reactions ? $post->reactions->firstWhere('user_id', auth()->id()) : null;
                            @endphp

                            <button type="button" class="reaction-button flex items-center justify-center bg-gray-200 rounded-full px-4 py-2 hover:bg-blue-100">
                                {{ $userReaction ? ($reactionEmojis[$userReaction->reaction] ?? '👍') : 'like' }}
                            </button>

                        </form>
                        
                        <div class="reaction-container absolute top-full left-0 mt-2 bg-white border rounded-lg shadow-lg space-x-2 p-2 hidden">
                            @foreach ($reactionEmojis as $key => $emoji)
                                <form action="/posts/{{ $post->id }}/react" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" name="reaction" value="{{ $key }}" class="text-2xl hover:bg-gray-100 rounded-full p-1">
                                        {{ $emoji }}
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>

                    <button type="button" class="comment-button flex items-center justify-center bg-gray-200 rounded-full px-4 py-2 hover:bg-blue-100" 
                            data-post-id="{{ $post->id }}">
                        💬 Comment
                    </button>

                    <form action="/posts/{{ $post->id }}/share" method="POST" class="z-10">
                        @csrf
                        <button type="submit" class="flex items-center justify-center bg-gray-200 rounded-full px-4 py-2 hover:bg-blue-100">
                            🔗 Share
                        </button>
                    </form>
                </div>

                @if ($post->userReactions && $post->userReactions->isNotEmpty())
                    <form action="/posts/{{ $post->id }}/react" method="POST" class="mt-4">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="bg-red-500 text-white rounded-full py-1 px-4">Remove Reaction</button>
                    </form>
                @endif

                <div class="comment-section hidden mt-4 border-t pt-4" id="comment-section-{{ $post->id }}">
                    <form action="/posts/{{ $post->id }}/comment" method="POST" class="flex items-center mb-3">
                        @csrf
                        <input type="text" name="content" class="border rounded-full px-4 py-2 flex-grow" placeholder="Write a comment..." required>
                        <button type="submit" class="bg-blue-500 text-white rounded-full px-4 py-2 ml-2">Post</button>
                    </form>
                    
                    <div class="comments-list space-y-3">
                        @foreach($post->comments ?? [] as $comment)
                        <div class="flex items-start">
                            <div class="flex-grow">
                                <div class="bg-gray-100 rounded-lg px-3 py-2">
                                    <h4 class="font-bold text-sm">{{ $comment->user->full_name }}</h4>
                                    <p class="text-sm">{{ $comment->content }}</p>
                                    <div class="text-xs text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</div>
                                </div>
                                
                                <div class="flex space-x-4 mt-1 text-xs text-gray-500">
                                    <button class="hover:text-blue-600 hover:underline flex items-center">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                        </svg>
                                        Like
                                    </button>
                                    
                                    <button class="reply-button hover:text-blue-600 hover:underline flex items-center" data-comment-id="{{ $comment->id }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                        </svg>
                                        Reply
                                    </button>
                                </div>
                                
                                <div class="reply-form hidden mt-2" id="reply-form-{{ $comment->id }}">
                                    <form action="/comments/{{ $comment->id }}/replies" method="POST" class="flex items-center mb-2">
                                        @csrf
                                        <input type="text" name="content" class="border rounded-full px-3 py-1 flex-grow text-sm" placeholder="Write a reply..." required>
                                        <button type="submit" class="bg-blue-500 text-white rounded-full px-3 py-1 ml-2 text-xs">Reply</button>
                                    </form>                                    

                                    @foreach($comment->replies as $reply)
                                        <div class="flex items-start mt-3">
                                            <div class="flex-grow">
                                                <div class="bg-gray-100 rounded-lg px-3 py-2">
                                                    <h4 class="font-bold text-sm">{{ $reply->user->full_name }}</h4>
                                                    <p class="text-sm">{{ $reply->content }}</p>
                                                    <div class="text-xs text-gray-500 mt-1">{{ $reply->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> 
            @endforeach
        </main>
    </div>

    <script>
        document.querySelectorAll('.reaction-button').forEach(button => {
            button.addEventListener('click', function() {
                const reactionContainer = this.closest('.relative').querySelector('.reaction-container');
                reactionContainer.classList.toggle('hidden');
            });
        });

        document.querySelectorAll('.comment-button').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const commentSection = document.getElementById('comment-section-' + postId);
                commentSection.classList.toggle('hidden');
            });
        });

        document.querySelectorAll('.reply-button').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.getElementById('reply-form-' + commentId);
                replyForm.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
