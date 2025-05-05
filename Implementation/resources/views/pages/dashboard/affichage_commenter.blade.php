@extends('layouts.dashboard', ['title' => 'Commentaires'])

@section('content')
<section class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div class="mb-4 md:mb-0">
            <h2 class="text-2xl font-bold">Suivi des Commentaires</h2>
            <p class="text-gray-400">Consultez les commentaires publiés par les utilisateurs</p>
        </div>
        <div>
            <form action="{{ route('comments') }}" method="GET" class="flex">
                <input type="text" name="search" placeholder="Search comments..." 
                       class="bg-gray-700 text-white px-4 py-2 rounded-l-lg focus:outline-none"
                       value="{{ request('search') }}">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-r-lg">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    

    <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Utilisateur</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Commentaire</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Post</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Publié</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($comments as $comment)
                        <tr class="hover:bg-gray-700/50">
                            <td class="px-4 py-4 flex items-center space-x-2">
                                <img src="{{ asset('storage/' . ($comment->user->profile_image ??  '../../../images/la-personne.png') ) }}"
                                    alt="Profile"
                                    class="w-8 h-8 rounded-full border-2 border-gray-800" />
                                <span class="text-sm">{{ $comment->user->full_name }}</span>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                {{ $comment->content }}
                            </td>
                            <td class="px-4 py-4 text-sm">
                                {{ Str::limit($comment->post->title, 30) }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-400">
                                {{ $comment->created_at->diffForHumans() }}
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex space-x-2 items-center">
                                    <button
                                        type="button"
                                        class="text-blue-400 hover:text-blue-300 toggle-replies"
                                        data-comment-id="{{ $comment->id }}">
                                        <i class="fas fa-reply"></i>
                                    </button>

                                    <form method="POST" action="{{ route('comments.destroy', $comment->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @foreach($comment->replies as $reply)
                            <tr class="bg-gray-800 hidden reply-row" data-parent-id="{{ $comment->id }}">
                                <td class="px-12 py-2 text-sm text-gray-300 flex items-center">
                                    ↳
                                    <img src="{{ asset('storage/' . ($reply->user->profile_image ??  '../../../images/la-personne.png') ) }}"
                                        alt="Reply profile"
                                        class="w-6 h-6 ml-2 rounded-full border border-gray-700" />
                                    <span class="ml-2">{{ $reply->user->full_name }}</span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-300" colspan="3">
                                    {{ $reply->content }}
                                </td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('comments.destroy', $reply->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.toggle-replies').forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const replyRows = document.querySelectorAll(`.reply-row[data-parent-id="${commentId}"]`);

                replyRows.forEach(row => {
                    row.classList.toggle('hidden');
                });
            });
        });
    });
</script>
@endsection


