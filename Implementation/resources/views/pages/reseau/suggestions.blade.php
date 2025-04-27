@extends('layouts.app', ['title' => 'Suggested'])

@section('content')
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-8 flex items-center">
            <a href="{{ url()->previous() }}" class="mr-3 text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Suggested For You</h1>
                <p class="text-gray-600">Accounts you might want to follow</p>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
            @if($suggestedUsers->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-search text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-gray-700 font-medium mb-2">No suggestions available</h3>
                    <p class="text-gray-500 max-w-md">We couldn't find any accounts to suggest right now.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($suggestedUsers as $user)
                        <div class="rounded-xl overflow-hidden border border-gray-200 hover-lift">
                            <div class="h-24 bg-gradient-to-r from-brand-700 to-brand-900 relative">
                                <div class="absolute left-1/2 transform -translate-x-1/2 -bottom-8">
                                    <div class="w-16 h-16 rounded-full bg-white p-1 shadow-md">
                                        <div class="w-full h-full rounded-full overflow-hidden bg-gray-100">
                                            <img 
                                                src="{{ asset('storage/' . $user->profile_image) ?? 'https://placehold.co/100x100/3b82f6/ffffff.png?text=' . substr($user->full_name, 0, 2) }}" 
                                                alt="Profile photo" 
                                                class="w-full h-full object-cover" 
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-10 pb-5 px-4 text-center">
                                <h3 class="font-semibold text-gray-900">{{ $user->full_name }}</h3>
                                <p class="text-gray-500 text-sm capitalize mb-4">{{ $user->role }}</p>
                                
                                @php
                                    $authUser = auth()->user();
                                    $isFollowing = $authUser->isFollowing($user->id);
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
            @endif
        </div>
    </div>
    @endsection