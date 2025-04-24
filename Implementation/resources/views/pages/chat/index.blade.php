@extends('layouts.app', ['title' => 'chats'])

@section('content')
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chats') }}
            </h2>
            <a href="{{ route('chat.create') }}" class="bg-brand-500 hover:bg-brand-600 text-white font-medium py-2 px-4 rounded-lg transition flex items-center">
                <i class="fas fa-plus mr-2"></i>
                New Chat
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-soft rounded-2xl">
            <div class="p-6 bg-white border-b border-gray-200">
                @if($chats->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-comments text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-gray-500 mb-2">You don't have any chats yet.</p>
                        <p class="text-sm text-gray-400">Start a new conversation by clicking the "New Chat" button.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($chats as $chat)
                            @php
                                $otherUser = $chat->getOtherUser(auth()->id());
                                $unreadCount = $chat->messages()
                                    ->where('receiver_id', auth()->id())
                                    ->where('read', false)
                                    ->count();
                            @endphp
                            <a href="{{ route('chat.show', $chat) }}" class="block p-4 border rounded-xl hover:bg-gray-50 hover-lift transition">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full bg-brand-100 flex-shrink-0 overflow-hidden border border-brand-200">
                                            <img 
                                                src="{{ asset('storage/' . $otherUser->profile_image) ?? 'https://placehold.co/100x100/3b82f6/ffffff.png?text='.substr($request->follower->full_name, 0, 2)}}"
                                                alt="Profile photo" 
                                                class="w-full h-full object-cover" 
                                            />
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="font-bold text-gray-900">{{ $otherUser->name }}</h3>
                                            @if($chat->latestMessage)
                                                <p class="text-sm text-gray-600 truncate max-w-xs">
                                                    {{ $chat->latestMessage->message }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $chat->latestMessage->created_at->diffForHumans() }}
                                                </p>
                                            @else
                                                <p class="text-sm text-gray-500">No messages yet</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($unreadCount > 0)
                                        <span class="bg-brand-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endsection
