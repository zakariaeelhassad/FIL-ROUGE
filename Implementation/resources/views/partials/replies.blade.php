<div class="flex items-start space-x-2 mt-2">
    <img 
        src="{{ asset('storage/' . $reply->user->profile_image ?? 'default-avatar.png') }}" 
        alt="Profile"
        class="w-6 h-6 rounded-full object-cover border border-brand-100"
    >
    <div class="flex-grow">
        <div class="bg-gray-50 rounded-xl px-3 py-2">
            <div class="flex items-center justify-between mb-0.5">
                <h4 class="font-medium text-gray-800 text-sm">{{ $reply->user->full_name }}</h4>
                <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
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
