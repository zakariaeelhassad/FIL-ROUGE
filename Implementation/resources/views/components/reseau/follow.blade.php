<div class="bg-white rounded-2xl border border-blue-200 p-5 mb-6 max-w-4xl mx-auto">
    @if($followRequests->isEmpty())
        <h2 class="text-blue-900 font-bold text-lg mb-4">Aucune invitation en attente</h2>
    @else
        <h2 class="text-blue-900 font-bold text-lg mb-4" id="pending-count">
            {{ $followRequests->count() }} invitation(s) en attente
        </h2>

        <div id="requests-list">
            @foreach($followRequests as $request )
            @if ($request->status === "pending")
                <div class="bg-gray-50 rounded-xl p-3 flex items-center justify-between mb-3 request-item" data-user-id="{{ $request->follower->id }}">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex-shrink-0 overflow-hidden">
                            <img src="{{ $request->follower->profile_image ?? 'https://placehold.co/100x100/3b82f6/ffffff.png?text='.substr($request->follower->full_name, 0, 2) }}" alt="Photo de profil" class="w-full h-full object-cover" />
                        </div>
                        <div class="ml-3">
                            <p class="text-blue-600 font-semibold text-sm">{{ strtoupper($request->follower->full_name) }}</p>
                            <p class="text-gray-400 text-xs">{{ $request->follower->role }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="handleFollowAction('accept', {{ $request->follower->id }})"
                                class="bg-white border border-blue-200 text-blue-600 px-4 py-1 rounded-full text-sm hover:bg-blue-50">
                            Accepter
                        </button>
                        <button onclick="handleFollowAction('reject', {{ $request->follower->id }})"
                                class="bg-white border border-blue-200 text-blue-600 px-4 py-1 rounded-full text-sm hover:bg-blue-50">
                            Refuser
                        </button>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @endif
</div>

<script>
    async function handleFollowAction(action, userId) {
        try {
            const response = await fetch(`/follow/${action}/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                document.querySelector(`.request-item[data-user-id="${userId}"]`).remove();

                const remaining = document.querySelectorAll('.request-item').length;
                document.getElementById('pending-count').innerText = remaining > 0
                    ? `${remaining} invitation(s) en attente`
                    : `Aucune invitation en attente`;
            }
        } catch (error) {
            console.error("Erreur lors de l'action :", error);
        }
    }
</script>