<div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5 overflow-hidden">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold text-gray-900">Connection Requests</h2>
        @if(!$followRequests->isEmpty())
            <span class="bg-brand-50 text-brand-600 text-xs font-medium px-2.5 py-1 rounded-full">
                {{ $followRequests->count() }} pending
            </span>
        @endif
    </div>

    @if($followRequests->isEmpty())
        <div class="flex flex-col items-center justify-center py-8 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-users h-8 w-8 text-gray-400"></i>
            </div>
            <h3 class="text-gray-700 font-medium mb-1">No pending requests</h3>
            <p class="text-gray-500 text-sm">When someone wants to connect with you, you'll see it here</p>
        </div>
    @else
        <div id="requests-list" class="space-y-3">
            @foreach($followRequests as $request)
                @if ($request->status === "pending")
                    <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition request-item animate-fade-in" data-user-id="{{ $request->follower->id }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-brand-100 flex-shrink-0 overflow-hidden border border-brand-200">
                                    <img 
                                        src="{{asset('storage/' . $request->follower->profile_image) ?? 'https://placehold.co/100x100/3b82f6/ffffff.png?text='.substr($request->follower->full_name, 0, 2) }}" 
                                        alt="Profile photo" 
                                        class="w-full h-full object-cover" 
                                    />
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 font-medium">{{ $request->follower->full_name }}</p>
                                    <p class="text-gray-500 text-sm capitalize">{{ $request->follower->role }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <button 
                                    onclick="handleFollowAction('accept', {{ $request->follower->id }})"
                                    class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-1.5 rounded-full text-sm font-medium transition"
                                >
                                    Accept
                                </button>
                                <button 
                                    onclick="handleFollowAction('reject', {{ $request->follower->id }})"
                                    class="bg-white border border-gray-300 text-gray-700 px-4 py-1.5 rounded-full text-sm font-medium hover:bg-gray-50 transition"
                                >
                                    Decline
                                </button>
                            </div>
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
                const requestItem = document.querySelector(`.request-item[data-user-id="${userId}"]`);
                
                // Add fade-out animation
                requestItem.style.transition = 'opacity 0.3s ease-out';
                requestItem.style.opacity = '0';
                
                // Remove after animation completes
                setTimeout(() => {
                    requestItem.remove();
                    
                    const remaining = document.querySelectorAll('.request-item').length;
                    const pendingCountElement = document.querySelector('h2 + span');
                    
                    if (pendingCountElement) {
                        if (remaining > 0) {
                            pendingCountElement.textContent = `${remaining} pending`;
                        } else {
                            // Reload the page to show the empty state
                            window.location.reload();
                        }
                    }
                }, 300);
            }
        } catch (error) {
            console.error("Error processing action:", error);
        }
    }
</script>
