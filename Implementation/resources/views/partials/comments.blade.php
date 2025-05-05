<div class="flex items-start space-x-3">
    <img 
        src="{{ asset('storage/' . ($comment->user->profile_image ?? '../../../images/la-personne.png')) }}" 
        alt="Profile"
        class="w-8 h-8 rounded-full object-cover border border-brand-100"
    >
    <div class="flex-grow">
        <div class="bg-gray-50 rounded-xl px-4 py-3">
            <div class="flex items-center justify-between mb-1">
                <h4 class="font-medium text-gray-800">{{ $comment->user->full_name }}</h4>
                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                @if(auth()->check() && auth()->id() !== $comment->user_id)
                <div class="text-gray-400 relative group">
                    <button class="hover:text-brand-500 p-1 rounded-full hover:bg-gray-50"
                            onclick="toggleDropdown('comment-dropdown-{{ $comment->id }}')">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>

                    <div id="comment-dropdown-{{ $comment->id }}" class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-xl shadow-md z-20 hidden">
                        <button
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            onclick="openReportModal({{ $comment->id }}, 'comment')"
                        >
                            Signaler ce commenter
                        </button>
                    </div>
                </div>
                @endif
                @if(auth()->check() && auth()->id() === $comment->user_id)
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" >
                        @csrf
                        <button type="submit" class="text-red-500 text-xs hover:text-red-700 transition">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                @endif
            </div>
            <p class="text-gray-700 text-sm">{{ $comment->content }}</p>
        </div>                  
        
        <div class="flex space-x-4 mt-1.5 text-xs">
            <button class="text-gray-500 hover:text-brand-600 font-medium transition">
                Like
            </button>
            
            <button class="reply-button text-gray-500 hover:text-brand-600 font-medium transition" 
                    onclick="toggleReplyForm({{ $comment->id }})" 
                    data-comment-id="{{ $comment->id }}">
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
                    src="{{ asset('storage/' . (Auth::user()->profile_image ?? '../../../images/la-personne.png')) }}" 
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