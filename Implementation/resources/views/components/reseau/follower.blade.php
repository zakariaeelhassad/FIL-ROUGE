<div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold text-gray-900">People You May Know</h2>
        <button class="text-brand-500 hover:text-brand-600 text-sm font-medium flex items-center transition">
            <i class="fas fa-filter h-4 w-4 mr-1"></i>
            Filter
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($users as $user)
            <div class="rounded-xl overflow-hidden border border-gray-200 hover-lift">
                <!-- Banner -->
                <div class="h-24 bg-gradient-to-r from-brand-700 to-brand-900 relative">
                    <!-- Profile Image -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 -bottom-8">
                        <div class="w-16 h-16 rounded-full bg-white p-1 shadow-md">
                            <div class="w-full h-full rounded-full overflow-hidden bg-gray-100">
                                <img 
                                    src="{{asset('storage/' . $user->profile_image ) ?? 'https://placehold.co/100x100/3b82f6/ffffff.png?text='.substr($user->full_name, 0, 2) }}" 
                                    alt="Profile photo" 
                                    class="w-full h-full object-cover" 
                                />
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="pt-10 pb-5 px-4 text-center">
                    <h3 class="font-semibold text-gray-900">{{ $user->full_name }}</h3>
                    <p class="text-gray-500 text-sm capitalize mb-4">{{ $user->role }}</p>
                    
                    <div class="flex justify-center items-center mb-4">
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                            <i class="fas fa-map-marker-alt h-3 w-3 inline mr-1"></i>
                            Paris, France
                        </span>
                    </div>

                    @php
                        $authUser = auth()->user();
                        $existingFollow = \App\Models\Follow::where('follower_id', $authUser->id)
                            ->where('following_id', $user->id)
                            ->first();
                        $isFriend = \App\Models\Follow::where('follower_id', $user->id)
                            ->where('following_id', $authUser->id)
                            ->where('status', 'accepted')
                            ->exists();
                    @endphp

                    @if ($authUser->id === $user->id)
                        <button class="w-full bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed">
                            <i class="fas fa-user h-4 w-4 inline mr-1"></i>
                            Your Profile
                        </button>
                    @elseif ($existingFollow && $existingFollow->status === 'pending')
                        <button class="w-full bg-yellow-50 text-yellow-600 border border-yellow-200 px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Request Pending
                        </button>
                    @elseif ($isFriend)
                        <button class="w-full bg-green-50 text-green-600 border border-green-200 px-4 py-2 rounded-lg text-sm font-medium cursor-default">
                            <i class="fas fa-check h-4 w-4 inline mr-1"></i>
                            Connected
                        </button>
                    @else
                        <form action="{{ route('follow.send', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fas fa-user-plus h-4 w-4 inline mr-1"></i>
                                Connect
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-6 text-center">
        <button class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
            Load More
        </button>
    </div>
</div>
