@extends('layouts.dashboard', ['title' => 'Dashboard'])

@section('content')
    <section class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Dashboard</h2>
                <p class="text-gray-400 mt-1">Overview of your activity center</p>
            </div>
            <div>
                <span class="bg-blue-600 text-white px-4 py-2 rounded-lg">{{ now()->format('d M, Y') }}</span>
            </div>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Latest Users with more details -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
                <div class="bg-gray-700 px-4 py-3 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Latest Users</h3>
                    <a href="{{ route('users.admin') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-700">
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-400">Name</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-400">Email</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-400">Role</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-400">Joined</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="border-b border-gray-700 hover:bg-gray-750">
                                    <td class="px-4 py-3 text-gray-300">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold mr-3">
                                                {{ substr($user->full_name, 0, 1) }}
                                            </div>
                                            {{ $user->full_name }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-300">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $user->role == 'admin' ? 'bg-red-900 text-red-200' : 'bg-blue-900 text-blue-200' }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-300">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('delete.user', $user->id) }} " method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form> 
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Latest Posts with more details -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
                <div class="bg-gray-700 px-4 py-3 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Latest Posts</h3>
                    <a href="{{ route('posts.admin') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-700">
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-400">Title</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-400">Author</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-400">Status</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-400">Created</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr class="border-b border-gray-700 hover:bg-gray-750">
                                    <td class="px-4 py-3 text-gray-300">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded bg-purple-600 flex items-center justify-center text-white mr-3">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <span class="truncate max-w-xs">{{ $post->content }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-300">{{ $post->user->full_name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $post->status == 'published' ? 'bg-green-900 text-green-200' : 'bg-yellow-900 text-yellow-200' }}">
                                            {{ $post->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-300">{{ $post->created_at->diffForHumans() }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('delete.post', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-md">
                                                   Delete
                                                </button>
                                            </form> 
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Latest Comments with more details -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
                <div class="bg-gray-700 px-4 py-3 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Latest Comments</h3>
                    <a href="{{ route('comments') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        @foreach($comments as $comment)
                        <div class="border border-gray-700 rounded-lg p-4 hover:bg-gray-750">
                            <div class="flex justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold mr-3">
                                        {{ substr($comment->user->full_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-200">{{ $comment->user->full_name }}</h4>
                                        <p class="text-sm text-gray-400 truncate max-w-xs">On post: {{ $comment->post->content }}</p>
                                    </div>
                                </div>
                                <div class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="mt-3 text-gray-300 pl-12">
                                "{{ $comment->content }}"
                            </div>
                            <div class="mt-3 pl-12 flex space-x-2">
                                <form method="POST" action="{{ route('comments.destroy', $comment->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Latest Reports with more details -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
                <div class="bg-gray-700 px-4 py-3 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Latest Reports</h3>
                    <a href="{{ route('reports') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        @foreach($reports as $report)
                        <div class="border border-gray-700 rounded-lg p-4 hover:bg-gray-750">
                            <div class="flex justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-red-600 flex items-center justify-center text-white font-bold mr-3">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div>
                                        @if ($report->reported_type === 'post')
                                            {{ $report->reporter->full_name ?? 'Utilisateur supprimé' }} report le post #{{$report->reported_id}} by {{ $report->reportedPost->user->full_name ?? 'posts supprimé' }} 
                                        @elseif ($report->reported_type === 'comment')
                                            {{ $report->reporter->full_name ?? 'Utilisateur supprimé' }} report le comment #{{$report->reported_id}} by {{ $report->reportedPost->user->full_name ?? 'commenter supprimé' }} 
                                        @elseif ($report->reported_type === 'user')
                                            {{ $report->reporter->full_name ?? 'Utilisateur supprimé' }} report le users {{ $report->reportedPost->user->full_name ?? 'Utilisateur supprimé' }}  #{{$report->reported_id}} 
                                        @else
                                            Unknown Report Type
                                        @endif
                                    </div>
                                </div>
                                <div class="text-gray-400 text-sm">{{ $report->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="mt-3 text-gray-300 pl-12">
                                <div class="text-red-400 font-semibold">{{ $report->reason }}</div>
                                @if($report->description)
                                <div class="mt-1">{{ $report->description }}</div>
                                @endif
                            </div>
                            <div class="mt-3 pl-12 flex space-x-2">
                                <form action="{{ route('repost.delete', $report->id) }} " method="POST" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-md">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection