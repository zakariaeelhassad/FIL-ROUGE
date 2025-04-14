<div class="bg-white rounded-2xl border border-blue-200 p-5 max-w-7xl mx-auto mt-8">
    <h2 class="text-blue-900 font-bold text-lg mb-4">Personnes que vous connaissez</h2>

    <div class="grid grid-cols-3 gap-4">
        @foreach ($users as $user)
        <div class="rounded-xl overflow-hidden border border-blue-200 h-48">
            <div class="bg-indigo-900 pt-4 pb-2 px-2 relative">
                <div class="w-12 h-12 mx-auto bg-blue-500 rounded-full overflow-hidden mb-1">
                    <img src="https://placehold.co/100x100" alt="Photo de profil" class="w-full h-full object-cover" />
                </div>
            </div>
            <div class="bg-white p-2 text-center">
                <p class="text-blue-600 font-semibold text-xs">{{ $user->full_name }}</p>
                <p class="text-gray-400 text-xs mb-8">{{ $user->role }}</p>

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
                    <button class="bg-gray-100 border border-gray-300 text-gray-500 px-3 py-1 rounded-full text-xs w-full cursor-not-allowed">
                        Vous-même
                    </button>
                @elseif ($existingFollow && $existingFollow->status === 'pending')
                    <button class="bg-yellow-50 border border-yellow-300 text-yellow-600 px-3 py-1 rounded-full text-xs w-full cursor-not-allowed">
                        En attente
                    </button>
                @elseif ($isFriend)
                    <button class="bg-green-50 border border-green-400 text-green-600 px-3 py-1 rounded-full text-xs w-full cursor-default">
                        Connecté
                    </button>
                @else
                    <form action="{{ route('follow.send', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-white border border-blue-200 text-blue-600 px-3 py-1 rounded-full text-xs hover:bg-blue-50 w-full">
                            Se connecter
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>