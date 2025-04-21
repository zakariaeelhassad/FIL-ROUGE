<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/htmx.org@2.0.4/dist/htmx.js" integrity="sha384-oeUn82QNXPuVkGCkcrInrS1twIxKhkZiFfr2TdiuObZ3n3yIeMiqcRzkIcguaof1" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#e6f0ff',
                            100: '#cce0ff',
                            200: '#99c2ff',
                            300: '#66a3ff',
                            400: '#3385ff',
                            500: '#0066ff',
                            600: '#0052cc',
                            700: '#003d99',
                            800: '#002966',
                            900: '#001433',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 15px rgba(0, 0, 0, 0.05)',
                        'hover': '0 10px 25px rgba(0, 102, 255, 0.15)',
                    },
                }
            }
        }
    </script>
    <style>
        .hidden {
            display: none;
        }
        
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 102, 255, 0.1);
        }
        
        .reaction-button:hover + .reaction-container,
        .reaction-container:hover {
            display: flex !important;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    @if (session('success'))
    <div class="fixed top-4 right-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-soft z-50 max-w-md animate-fade-in">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @include('components.navbar')

    <div class="max-w-6xl mx-auto px-4 pt-6 pb-12">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left Sidebar -->
            <div class="md:w-1/4 md:sticky md:top-20 self-start">
                @include('components.home.mini_profil')
            </div>

            <!-- Main Content -->
            <div class="md:w-2/3">
                <div class="space-y-6">
                    <!-- Create Post -->
                    <div class="bg-white rounded-2xl p-5 shadow-soft hover-lift border border-gray-100">
                        <div class="flex items-center space-x-4">
                            @php
                                $authUser = Auth::user();
                            @endphp
                            <img 
                                src="{{ asset('storage/' . $authUser->profile_image ?? 'default-avatar.png') }}" 
                                class="w-12 h-12 rounded-full object-cover border-2 border-brand-100"
                                alt="Profile"
                            >
                            <input 
                                type="text" 
                                placeholder="What's on your mind?" 
                                class="flex-grow bg-gray-50 rounded-full px-5 py-3 focus:outline-none focus:ring-2 focus:ring-brand-300 transition text-gray-700"
                            >
                            <button class="bg-brand-500 text-white rounded-full px-6 py-3 hover:bg-brand-600 transition font-medium shadow-sm">
                                Post
                            </button>
                        </div>
                        
                        <!-- Post Options -->
                        <div class="flex mt-4 pt-3 border-t border-gray-100">
                            <button class="flex items-center justify-center space-x-2 text-gray-600 hover:bg-gray-50 rounded-xl px-4 py-2 transition flex-1">
                                <i class="fas fa-image text-brand-500"></i>
                                <span>Photo</span>
                            </button>
                            <button class="flex items-center justify-center space-x-2 text-gray-600 hover:bg-gray-50 rounded-xl px-4 py-2 transition flex-1">
                                <i class="fas fa-video text-green-500"></i>
                                <span>Video</span>
                            </button>
                            <button class="flex items-center justify-center space-x-2 text-gray-600 hover:bg-gray-50 rounded-xl px-4 py-2 transition flex-1">
                                <i class="fas fa-calendar-alt text-purple-500"></i>
                                <span>Event</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Posts Feed -->
                    @foreach ($posts as $post)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-soft hover-lift overflow-hidden">
                        <!-- Post Header -->
                        <div class="p-5 flex items-start space-x-3">
                            <img
                                src="{{ asset('storage/' . $post->user->profile_image ) ?? 'https://placehold.co/100x100/3b82f6/ffffff.png?text='.substr($request->follower->full_name, 0, 2) }}"
                                alt="Profile"
                                class="rounded-full w-12 h-12 object-cover border-2 border-brand-100"
                            />
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
                                    Posted on: {{ $post->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="px-5 pb-4">
                            <p class="text-gray-800 leading-relaxed">{{ $post->content }}</p>
                            <button class="text-brand-500 font-medium text-sm mt-2 hover:underline">voir plus</button>
                        </div>

                        <!-- Post Images -->
                        @if($post->images->isNotEmpty())
                            <div class="border-t border-b border-gray-100">
                                @foreach($post->images as $image)
                                    <img 
                                        src="{{ asset('storage/' . $image->path) ?? 'https://placehold.co/100x100/3b82f6/ffffff.png?text='.substr($request->follower->full_name, 0, 2)}}" 
                                        alt="Post image" 
                                        class="w-full object-cover "
                                    >
                                @endforeach
                            </div>
                        @endif

                        <!-- Engagement Stats -->
                        <div class="px-5 py-3 flex items-center justify-between border-b border-gray-100">
                            <div class="flex items-center space-x-1">
                                <div class="flex -space-x-1">
                                    <span class="w-6 h-6 rounded-full flex items-center justify-center bg-brand-500 text-white text-xs">👍</span>
                                    <span class="w-6 h-6 rounded-full flex items-center justify-center bg-red-500 text-white text-xs">❤️</span>
                                </div>
                                <span class="text-gray-500 text-sm ml-1">{{ rand(5, 50) }}</span>
                            </div>
                            <div class="text-gray-500 text-sm">
                                <span>{{ rand(1, 15) }} comments</span>
                                <span class="mx-1">•</span>
                                <span>{{ rand(1, 10) }} shares</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="px-5 py-3 flex space-x-2">
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

                            <form action="/posts/{{ $post->id }}/share" method="POST" class="flex-1 z-10">
                                @csrf
                                <button type="submit" class="flex items-center justify-center w-full bg-gray-50 rounded-xl px-4 py-2.5 hover:bg-brand-50 transition">
                                    <span class="mr-2">🔗</span>
                                    <span class="font-medium">Share</span>
                                </button>
                            </form>
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/home.js') }}"></script>
   
</body>
</html>
