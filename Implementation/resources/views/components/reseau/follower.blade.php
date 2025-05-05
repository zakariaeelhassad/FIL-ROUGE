<div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold text-gray-900">People You May Know</h2>
        <form method="GET" action="{{ route('reseau') }}" class="flex items-center gap-4 mb-6">
            <input 
                type="text" 
                name="search" 
                placeholder="Search by name..." 
                class="border rounded-lg px-4 py-2 w-full sm:w-64"
                value="{{ request('search') }}"
            />

            <select name="role" class="border rounded-lg px-4 py-2">
                <option value="">All Roles</option>
                <option value="joueur" {{ request('role') === 'joueur' ? 'selected' : '' }}>Joueur</option>
                <option value="club_admin" {{ request('role') === 'club_admin' ? 'selected' : '' }}>Club_admin</option>
            </select>

            <button type="submit" class="bg-brand-500 text-white px-4 py-2 rounded-lg hover:bg-brand-600">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($users as $user)
            <div class="rounded-xl overflow-hidden border border-gray-200 hover-lift">
                
                <!-- BANNER IMAGE HERE -->
                <div class="h-28 relative overflow-hidden">
                    <img 
                        src="{{ $user->banner_image ? asset('storage/' . $user->banner_image) : '../../../images/téléchargement.jpg' }}" 
                        alt="Banner Image" 
                        class="w-full h-full object-cover" 
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>

                <div class="relative -mt-8 flex justify-center">
                    <div class="w-16 h-16 rounded-full bg-white p-1 shadow-md">
                        <div class="w-full h-full rounded-full overflow-hidden bg-gray-100">
                            <a href="{{ route('profil.show', ['id' => $user->id]) }}">
                                <img 
                                    src="{{ asset('storage/' . ($user->profile_image ?? '../../../images/la-personne.png')) }}" 
                                    alt="Profile photo" 
                                    class="w-full h-full object-cover" 
                                />
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="pt-4 pb-5 px-4 text-center">
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
                        $isFollowing = $authUser->isFollowing($user->id);
                        $hasRequested = $authUser->hasPendingFollowRequest($user->id);
                    @endphp

                    @if ($authUser->id === $user->id)
                        <button class="w-full bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed">
                            <i class="fas fa-user h-4 w-4 inline mr-1"></i>
                            Your Profile
                        </button>
                    @elseif ($isFollowing)
                        <form action="{{ route('unfollow', $user->id) }}" method="POST" class="follow-form">
                            @csrf
                            <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fas fa-user-check h-4 w-4 inline mr-1"></i>
                                Following
                            </button>
                        </form>
                    @elseif ($hasRequested)
                        <button class="w-full bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed">
                            <i class="fas fa-clock h-4 w-4 inline mr-1"></i>
                            Requested
                        </button>
                    @else
                        <form action="{{ route('follow', $user->id) }}" method="POST" class="follow-form">
                            @csrf
                            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                <i class="fas fa-user-plus h-4 w-4 inline mr-1"></i>
                                Follow
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
