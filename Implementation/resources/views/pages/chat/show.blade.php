<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat with {{ $otherUser->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        instagram: {
                            blue: '#0095f6',
                            darkBlue: '#00376b',
                            red: '#ed4956',
                            lightGray: '#efefef',
                            mediumGray: '#dbdbdb',
                            darkGray: '#8e8e8e',
                            extraDarkGray: '#262626',
                            black: '#000000',
                            white: '#ffffff',
                        }
                    },
                    boxShadow: {
                        'instagram': '0 0 5px rgba(0, 0, 0, 0.1)',
                    },
                }
            }
        }
    </script>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .instagram-gradient {
            background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
        }
        
        .instagram-gradient-border {
            position: relative;
            padding: 2px;
            border-radius: 50%;
            background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
        }
        
        .message-bubble-sent {
            border-radius: 22px;
            background-color: #efefef;
            color: #262626;
        }
        
        .message-bubble-received {
            border-radius: 22px;
            background-color: #ffffff;
            border: 1px solid #efefef;
            color: #262626;
        }
    </style>
</head>
<body class="bg-instagram-white font-sans text-instagram-extraDarkGray">
    @include('components.navbar')
    
    <div class="max-w-3xl mx-auto px-4 py-4">
        <div class="flex items-center mb-4 border-b border-instagram-lightGray pb-4">
            <a href="{{ route('chat.index') }}" class="mr-4 text-instagram-blue">
                <i class="fas fa-arrow-left"></i>
            </a>
            @php
                $otherUser = $chat->getOtherUser(auth()->id());
                $unreadCount = $chat->messages()
                ->where('receiver_id', auth()->id())
                ->where('read', false)
                ->count();
            @endphp
            <div class="instagram-gradient-border mr-3">
                <div class="h-9 w-9 bg-white rounded-full flex items-center justify-center overflow-hidden">
                    <a href="{{ route('profil.show', ['id' => $otherUser->id]) }}">
                        <img src="{{ asset('storage/' . ($otherUser->profile_image  ??  '../../../images/la-personne.png') ) }}" class="h-full w-full object-cover">
                    </a>
                </div>
            </div>
            <div class="flex-grow">
                <h2 class="font-semibold text-sm">{{ $otherUser->name }}</h2>
                <p class="text-xs text-instagram-darkGray">Active now</p>
            </div>
            
        </div>

        <div class="bg-white rounded-lg overflow-hidden">
            <!-- Chat messages container -->
            <div id="chat-messages" class="h-96 overflow-y-auto p-4 bg-white">
                @foreach($messages as $message)
                    <div class="mb-3 @if($message->sender_id === auth()->id()) text-right @endif">
                        <div class="@if($message->sender_id === auth()->id()) 
                                    inline-block message-bubble-sent
                                  @else 
                                    inline-block message-bubble-received
                                  @endif 
                                  px-4 py-3 max-w-xs sm:max-w-md break-words">
                            {{ $message->message }}
                        </div>
                        <div class="text-xs text-instagram-darkGray mt-1 px-1">
                            {{ $message->created_at->format('g:i a') }}
                            @if($message->sender_id === auth()->id())
                                @if($message->read)
                                    <span class="ml-1 text-instagram-blue"><i class="fas fa-check-double text-xs"></i></span>
                                @else
                                    <span class="ml-1 text-instagram-darkGray"><i class="fas fa-check text-xs"></i></span>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <form id="chat-form" class="border-t border-instagram-lightGray p-3">
                @csrf
                <div class="flex items-center bg-instagram-lightGray rounded-full px-4 py-2">
                    <button type="button" class="text-instagram-darkGray mr-3">
                        <i class="far fa-smile"></i>
                    </button>
                    <input type="text" name="message" id="message-input" 
                        class="flex-1 bg-transparent border-none focus:ring-0 text-sm placeholder-instagram-darkGray" 
                        placeholder="Message...">
                    <button type="button" class="text-instagram-darkGray mx-2">
                        <i class="far fa-image"></i>
                    </button>
                    <button type="button" class="text-instagram-darkGray mx-2">
                        <i class="far fa-heart"></i>
                    </button>
                    <button type="submit" id="send-button"
                        class="text-instagram-blue font-semibold text-sm disabled:opacity-50 disabled:text-instagram-darkGray ml-2">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.getElementById('chat-messages');
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-input');
            const sendButton = document.getElementById('send-button');
            const chatId = {{ $chat->id }};
            
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                forceTLS: true,
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    }
                }
            });
            
            const channel = pusher.subscribe('private-chat.{{ $chat->id }}');
            channel.bind('App\\Events\\NewMessage', function(data) {
                if (data.message.sender_id == {{ $otherUser->id }}) {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'mb-3 animate-fade-in';
                    
                    const innerDiv = document.createElement('div');
                    innerDiv.className = 'inline-block message-bubble-received px-4 py-3 max-w-xs sm:max-w-md break-words';
                    innerDiv.textContent = data.message.message;
                    
                    const timeDiv = document.createElement('div');
                    timeDiv.className = 'text-xs text-instagram-darkGray mt-1 px-1';
                    
                    const date = new Date(data.message.created_at);
                    const formattedTime = date.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });
                    timeDiv.textContent = formattedTime;
                    
                    messageDiv.appendChild(innerDiv);
                    messageDiv.appendChild(timeDiv);
                    
                    chatMessages.appendChild(messageDiv);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    
                    fetch(`/chats/${chatId}/messages/${data.message.id}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                }
            });
            
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (messageInput.value.trim() === '') return;
                
                fetch(`/chats/${chatId}/messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        message: messageInput.value
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'mb-3 text-right animate-fade-in';
                    
                    const innerDiv = document.createElement('div');
                    innerDiv.className = 'inline-block message-bubble-sent px-4 py-3 max-w-xs sm:max-w-md break-words';
                    innerDiv.textContent = messageInput.value;
                    
                    const timeDiv = document.createElement('div');
                    timeDiv.className = 'text-xs text-instagram-darkGray mt-1 px-1';
                    
                    const date = new Date();
                    const formattedTime = date.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });
                    timeDiv.textContent = formattedTime;
                    
                    const checkmark = document.createElement('span');
                    checkmark.className = 'ml-1 text-instagram-darkGray';
                    checkmark.innerHTML = '<i class="fas fa-check text-xs"></i>';
                    timeDiv.appendChild(checkmark);
                    
                    messageDiv.appendChild(innerDiv);
                    messageDiv.appendChild(timeDiv);
                    
                    chatMessages.appendChild(messageDiv);
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    
                    messageInput.value = '';
                    messageInput.focus();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to send message. Please try again.');
                });
            });
            
            messageInput.addEventListener('input', function() {
                if (messageInput.value.trim() === '') {
                    sendButton.classList.add('disabled:opacity-50', 'disabled:text-instagram-darkGray');
                    sendButton.disabled = true;
                } else {
                    sendButton.classList.remove('disabled:opacity-50', 'disabled:text-instagram-darkGray');
                    sendButton.disabled = false;
                }
            });
            
            messageInput.dispatchEvent(new Event('input'));
        });
    </script>
</body>
</html>