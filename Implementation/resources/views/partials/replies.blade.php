<div class="flex items-start space-x-2 mt-2">
    <img 
        src="{{ asset('storage/' . ($reply->user->profile_image ?? '../../../images/la-personne.png')) }}" 
        alt="Profile"
        class="w-6 h-6 rounded-full object-cover border border-brand-100"
    >
    <div class="flex-grow">
        <div class="bg-gray-50 rounded-xl px-3 py-2">
            <div class="flex items-center justify-between mb-0.5">
                <h4 class="font-medium text-gray-800 text-sm">{{ $reply->user->full_name }}</h4>
                <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>

                @if(auth()->check())
                    @if(auth()->id() === $reply->user_id)
                        <form method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 text-xs hover:underline ml-2">Supprimer</button>
                        </form>
                    @else
                        <div class="text-gray-400 relative group">
                            <button class="hover:text-brand-500 p-1 rounded-full hover:bg-gray-50"
                                    onclick="toggleDropdown1({{ $reply->id }})">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>

                            <div id="dropdown-{{ $reply->id }}" class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-xl shadow-md z-20 hidden">
                                <button
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    onclick="openReportModal({{ $reply->id }}, 'reply')"
                                >
                                    Signaler ce reply
                                </button>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <p class="text-gray-700 text-xs">{{ $reply->content }}</p>
        </div>

        <div class="flex space-x-4 mt-1 text-xs">
            <button class="text-gray-500 hover:text-brand-600 font-medium transition">
                Like
            </button>
        </div>
    </div>
</div>

<!-- Modal de report -->
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

<!-- JavaScript -->
<script>
    function toggleDropdown1(replyId) {
        const dropdown = document.getElementById('dropdown-' + replyId);
        console.log(dropdown.classList.toggle('hidden'));
        
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
</script>
