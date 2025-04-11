<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    <!-- Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <div class="bg-gray-100 flex items-start justify-center p-10">
        <!-- Left Sidebar -->
        @include('components.home.mini_profil')

        <!-- Feed Area -->
        <main class="space-y-6">
            <!-- Post Card 1 -->
@foreach ($posts as $post)
@csrf
<div class="w-[500px] bg-white rounded-3xl border border-blue-400 shadow-md p-6 cursor-pointer">
    <div class="flex items-center mb-4">
        <img
            src="https://placehold.co/40x40"
            alt="Profile"
            class="rounded-full w-10 h-10 object-cover mr-3"
        />
        <div>
            <!-- Display the user’s name -->
            <h3 class="text-blue-500 font-bold">{{ $post->user ? $post->user->full_name : 'Unknown User' }}</h3>
            <p class="text-gray-500 text-sm">{{ $post->user ? $post->user->bio : 'No Bio Available' }}</p>

            <!-- Display the post creation date -->
            <div class="text-gray-400 text-xs mb-4">
                Posted on: {{ $post->created_at->format('d M Y') }}
            </div>
        </div>
    </div>

    <!-- Post Content -->
    <div class="text-gray-800 text-sm mb-4">
        <p>{{ $post->content }}</p>
        <span class="text-blue-500 italic cursor-pointer">voir plus</span>
    </div>

    <!-- Post Image -->
    <div class="w-full h-40 bg-gray-200 mb-4 rounded-lg overflow-hidden">
        <img
            src="{{ $post->image }}"
            alt="Post Media"
            class="w-full h-full object-cover"
        />
    </div>

    <div class="flex justify-between">
        <!-- You can add other buttons or content here if needed -->
        <button class="rounded-full border border-blue-300 p-2 w-20 flex justify-center hover:bg-blue-50">
            <!-- Optional action button -->
        </button>
    </div>
</div> 
@endforeach
           
        </main>
    </div>
</body>
</html>
