<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Chat</title>
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
                        brand: {
                            50: '#e6f0ff',
                            100: '#cce0ff',
                            200: '#99c2ff',
                            300: '#66a3ff',
                            400: '#3385ff',
                            500: '#0066ff',
                            600: '#0052cc',
                            700: '#003d99',
                            800: '#002966',
                            900: '#001433',
                            950: '#0a1445',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 15px rgba(0, 0, 0, 0.05)',
                        'hover': '0 10px 25px rgba(0, 102, 255, 0.15)',
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
        
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 102, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    @include('components.navbar')
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Start New Chat') }}
            </h2>
            <a href="{{ route('chat.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Chats
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-soft rounded-2xl">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-4">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="search" 
                            class="w-full rounded-lg border-gray-300 focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50 pl-10" 
                            placeholder="Type a name or email..."
                        >
                        <i class="fas fa-search text-gray-400 absolute left-3 top-3"></i>
                    </div>
                </div>
                
                <h3 class="font-medium text-gray-700 mb-3 mt-6">Select a user to chat with:</h3>
                
                @if($users->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-slash text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-gray-500 mb-2">No users available to chat with.</p>
                    </div>
                @else
                    <div class="space-y-3" id="users-list">
                        @foreach($users as $user)
                            <form action="{{ route('chat.storeChat') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="w-full text-left p-4 border rounded-xl hover:bg-gray-50 hover-lift transition">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full bg-brand-100 flex-shrink-0 overflow-hidden border border-brand-200">
                                            <img 
                                                src="{{ $user->profile_image ?? 'https://placehold.co/100x100/3b82f6/ffffff.png?text='.substr($user->name, 0, 2) }}" 
                                                alt="Profile photo" 
                                                class="w-full h-full object-cover" 
                                            />
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="font-bold text-gray-900">{{ $user->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $user->email ?? 'No email available' }}</p>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const usersList = document.getElementById('users-list');
            
            if (searchInput && usersList) {
                const userForms = usersList.querySelectorAll('form');
                
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    
                    userForms.forEach(form => {
                        const userName = form.querySelector('h3').textContent.toLowerCase();
                        const userEmail = form.querySelector('p').textContent.toLowerCase();
                        
                        if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                            form.style.display = '';
                        } else {
                            form.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>
