@extends('layouts.app', ['title' => 'reseau'])

@section('content')
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Your Network</h1>
            <p class="text-gray-600">Discover new people and grow your connections</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Your Stats</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between hover:bg-gray-50 p-2 rounded-lg transition">
                            <a href="{{ route('followers') }}" class="w-full flex items-center justify-between">
                                <span class="text-gray-600">Followers</span>
                                <div class="flex items-center">
                                    <span class="font-medium text-gray-900 mr-2">{{ auth()->user()->followers_count }}</span>
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                </div>
                            </a>
                        </div>
                        
                        <div class="flex items-center justify-between hover:bg-gray-50 p-2 rounded-lg transition">
                            <a href="{{ route('following') }}" class="w-full flex items-center justify-between">
                                <span class="text-gray-600">Following</span>
                                <div class="flex items-center">
                                    <span class="font-medium text-gray-900 mr-2">{{ auth()->user()->following_count }}</span>
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                </div>
                            </a>
                        </div>
                        
                        @if(auth()->user()->pending_follow_requests_count > 0)
                            <div class="flex items-center justify-between bg-gray-50 p-2 rounded-lg transition">
                                <a href="{{ route('followers') }}" class="w-full flex items-center justify-between">
                                    <span class="text-brand-600">Follow Requests</span>
                                    <div class="flex items-center">
                                        <span class="font-medium text-brand-600 mr-2">{{ auth()->user()->pending_follow_requests_count }}</span>
                                        <i class="fas fa-chevron-right text-brand-600 text-xs"></i>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Based on your interests</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($suggestedUsers->take(3) as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100">
                                        <a href="{{ route('profil.show', ['id' => $user->id]) }}">
                                            <img 
                                                src="{{ asset('storage/' . ($user->profile_image ??  '../../../images/la-personne.png') ) }}" 
                                                alt="Profile photo" 
                                                class="w-full h-full object-cover" 
                                            />
                                        </a>
                                    </div>
                                    <div class="ml-3">
                                        <a href="{{ route('profil.show', ['id' => $user->id]) }}" class="font-medium text-gray-900 hover:text-brand-600 transition text-sm">{{ $user->full_name }}</a>
                                        <p class="text-gray-500 text-xs">{{ $user->role }}</p>
                                    </div>
                                </div>
                                
                                @if(auth()->user()->isFollowing($user->id))
                                    <form action="{{ route('unfollow', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-gray-500 hover:text-red-500 text-sm font-medium transition">
                                            Unfollow
                                        </button>
                                    </form>
                                @elseif(auth()->user()->hasPendingFollowRequest($user->id))
                                    <button class="text-gray-400 text-sm font-medium cursor-default">
                                        Requested
                                    </button>
                                @else
                                    <form action="{{ route('follow', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-brand-500 hover:text-brand-600 text-sm font-medium transition">
                                            Follow
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-2">
                @include("components.reseau.follower")
            </div>
        </div>
    </div>
    
    @if(session('success') || session('error'))
        <div id="notification" class="fixed bottom-5 right-5 p-4 rounded-lg shadow-lg max-w-sm animate-fade-in {{ session('success') ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    @if(session('success'))
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    @else
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    @endif
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium {{ session('success') ? 'text-green-800' : 'text-red-800' }}">
                        {{ session('success') ?? session('error') }}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="document.getElementById('notification').remove()" class="inline-flex text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <script>
            setTimeout(() => {
                const notification = document.getElementById('notification');
                if (notification) {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 0.5s ease-out';
                    setTimeout(() => notification.remove(), 500);
                }
            }, 5000);
        </script>
    @endif
@endsection