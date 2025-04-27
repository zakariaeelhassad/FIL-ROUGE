@extends('layouts.app', ['title' => 'Following'])

@section('content')
    
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-8 flex items-center">
            <a href="{{ route('reseau') }}" class="mr-3 text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->full_name }} is Following</h1>
                <p class="text-gray-600">{{ $acceptedFollowing->count() }} {{ Str::plural('account', $acceptedFollowing->count()) }}</p>
            </div>
        </div>
        
        @if(auth()->id() === $user->id && $pendingFollowing->count() > 0)
            <div class="mb-6 bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
                <h2 class="font-semibold text-lg mb-4">Pending Requests</h2>
                
                <div class="space-y-4">
                    @foreach($pendingFollowing as $follow)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 flex-shrink-0">
                                    <a href="{{ route('profil.show', ['id' => $follow->following->id]) }}">
                                        <img 
                                            src="{{ asset('storage/' . ($follow->following->profile_image ??  '../../../images/la-personne.png') ) }}" 
                                            alt="Profile photo" 
                                            class="w-full h-full object-cover" 
                                        />
                                    </a>
                                </div>
                                <div class="ml-3">
                                    <a href="{{ route('profil.show', ['id' => $follow->following->id]) }}" class="font-medium text-gray-900 hover:text-brand-600 transition">{{ $follow->following->full_name }}</a>
                                    <p class="text-gray-500 text-sm">{{ $follow->following->role }}</p>
                                </div>
                            </div>
                            
                            <form action="{{ route('unfollow', $follow->following->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-1.5 rounded-full text-sm font-medium transition">
                                    Cancel Request
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
            @if($acceptedFollowing->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-user-plus text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-gray-700 font-medium mb-2">Not following anyone yet</h3>
                    <p class="text-gray-500 max-w-md">When {{ $user->id === auth()->id() ? 'you follow' : $user->full_name . ' follows' }} someone, they'll appear here.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($acceptedFollowing as $follow)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 flex-shrink-0">
                                    <a href="{{ route('profil.show', ['id' => $follow->following->id]) }}">
                                        <img 
                                            src="{{ asset('storage/' . ($follow->following->profile_image ?? '../../../images/la-personne.png'))  }}" 
                                            alt="Profile photo" 
                                            class="w-full h-full object-cover" 
                                        />
                                    </a>
                                </div>
                                <div class="ml-3">
                                    <a href="{{ route('profil.show', ['id' => $follow->following->id]) }}" class="font-medium text-gray-900 hover:text-brand-600 transition">{{ $follow->following->full_name }}</a>
                                    <p class="text-gray-500 text-sm">{{ $follow->following->role }}</p>
                                </div>
                            </div>
                            
                            @if(auth()->id() !== $follow->following->id)
                                <form action="{{ route('unfollow', $follow->following->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-1.5 rounded-full text-sm font-medium transition">
                                        Following
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection