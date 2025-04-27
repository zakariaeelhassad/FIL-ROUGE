@extends('layouts.app', ['title' => 'Followers'])

@section('content')
    
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-8 flex items-center">
            <a href="{{ route('reseau') }}" class="mr-3 text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->full_name }}'s Followers</h1>
                <p class="text-gray-600">{{ $followers->count() }} {{ Str::plural('follower', $followers->count()) }}</p>
            </div>
        </div>
        
        @if(auth()->id() === $user->id && $pendingFollowers->count() > 0)
            <div class="mb-6 bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
                <h2 class="font-semibold text-lg mb-4">Follow Requests</h2>
                
                @if($pendingFollowers->isEmpty())
                    <p class="text-gray-500">No pending follow requests.</p>
                @else
                    <div class="space-y-4">
                        @foreach($pendingFollowers as $follow)
                            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 flex-shrink-0">
                                        <a href="{{ route('profil.show', ['id' => $follow->follower->id]) }}">
                                            <img 
                                                src="{{ asset('storage/' . ($follow->follower->profile_image ??  '../../../images/la-personne.png') ) }} " 
                                                alt="Profile photo" 
                                                class="w-full h-full object-cover" 
                                            />
                                        </a>
                                    </div>
                                    <div class="ml-3">
                                        <a href="{{ route('profil.show', ['id' => $follow->follower->id]) }}" class="font-medium text-gray-900 hover:text-brand-600 transition">{{ $follow->follower->full_name }}</a>
                                        <p class="text-gray-500 text-sm">{{ $follow->follower->role }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <form action="{{ route('follow.accept', $follow->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-1.5 rounded-full text-sm font-medium transition">
                                            Accept
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('follow.reject', $follow->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-1.5 rounded-full text-sm font-medium transition">
                                            Decline
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
        
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
            @if($followers->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-users text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-gray-700 font-medium mb-2">No followers yet</h3>
                    <p class="text-gray-500 max-w-md">When someone follows {{ $user->id === auth()->id() ? 'you' : $user->full_name }}, they'll appear here.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($followers as $follow)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 flex-shrink-0">
                                    <a href="{{ route('profil.show', ['id' => $follow->follower->id]) }}">
                                        <img 
                                            src="{{ asset('storage/' . ($follow->follower->profile_image ?? '../../../images/la-personne.png'))  }}" 
                                            alt="Profile photo" 
                                            class="w-full h-full object-cover" 
                                        />
                                    </a>
                                </div>
                                <div class="ml-3">
                                    <a href="{{ route('profil.show', ['id' => $follow->follower->id]) }}" class="font-medium text-gray-900 hover:text-brand-600 transition">{{ $follow->follower->full_name }}</a>
                                    <p class="text-gray-500 text-sm">{{ $follow->follower->role }}</p>
                                </div>
                            </div>
                            
                            @if(auth()->id() !== $follow->follower->id)
                                @if(auth()->user()->isFollowing($follow->follower->id))
                                    <form action="{{ route('unfollow', $follow->follower->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-1.5 rounded-full text-sm font-medium transition">
                                            Following
                                        </button>
                                    </form>
                                @elseif(auth()->user()->hasPendingFollowRequest($follow->follower->id))
                                    <button class="bg-gray-100 text-gray-500 px-4 py-1.5 rounded-full text-sm font-medium" disabled>
                                        Requested
                                    </button>
                                @else
                                    <form action="{{ route('follow', $follow->follower->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-1.5 rounded-full text-sm font-medium transition">
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection