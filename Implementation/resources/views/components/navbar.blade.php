<nav class="bg-gray-900 text-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="/" class="text-3xl font-bold bg-brand-600 rounded-lg p-1 shadow-lg hover:bg-brand-700 transition">
                    <span class="px-2">GI.</span>
                </a>
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Search..." 
                        class="bg-gray-800 text-white rounded-full pl-10 pr-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-brand-400 transition"
                    >
                    <i class="fas fa-search text-gray-400 absolute left-3 top-2.5"></i>
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-6">
                <a href="/" class="flex flex-col items-center {{ request()->is('/') ? 'text-brand-300 border-b-2 border-brand-500 pb-1' : 'text-gray-400 hover:text-brand-300 transition' }}">
                    <i class="fas fa-home h-6 w-6"></i>
                    <span class="text-xs mt-1">Home</span>
                </a>
                
                <a href="/reseau" class="flex flex-col items-center {{ request()->is('reseau') ? 'text-brand-300 border-b-2 border-brand-500 pb-1' : 'text-gray-400 hover:text-brand-300 transition' }}">
                    <i class="fas fa-users h-6 w-6"></i>
                    <span class="text-xs mt-1">Network</span>
                </a>
                
                <a href="/chats" class="flex flex-col items-center {{ request()->is('chats') ? 'text-brand-300 border-b-2 border-brand-500 pb-1' : 'text-gray-400 hover:text-brand-300 transition' }}">
                    <i class="fas fa-comment h-6 w-6"></i>
                    <span class="text-xs mt-1">Messages</span>
                </a>
            </div>

            <div class="flex items-center space-x-4">
                @auth

                <div class="relative inline-block text-left">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-2 bg-gray-800 rounded-full pl-1 pr-3 py-1 hover:bg-gray-700 transition">
                        @php
                            $authUser = Auth::user();
                        @endphp

                        <img src="{{ asset('storage/' . ($authUser->profile_image ?? '../../../images/la-personne.png')) }}" alt="Profile" class="rounded-full h-8 w-8 border-2 border-brand-400 object-cover" />
                        <span class="font-medium">{{ $authUser->username }}</span>
                        <i class="fas fa-chevron-down h-5 w-5 text-gray-400"></i>
                    </button>

                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden animate-fade-in">
                        <div class="py-2">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ $authUser->full_name }}</p>
                                <p class="text-xs text-gray-500">{{ $authUser->email }}</p>
                            </div>

                            @if ($authUser->role == 'joueur')
                                <a href="{{ route('profil.joueur') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-600">
                                    <i class="fas fa-user h-5 w-5 mr-2 text-gray-500"></i>
                                    Player Profile
                                </a>
                            @elseif ($authUser->role == 'club_admin')
                                <a href="/profil/joueur" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-600">
                                    <i class="fas fa-building h-5 w-5 mr-2 text-gray-500"></i>
                                    Club Profile
                                </a>
                            @endif

                            <a href="/settings" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-600">
                                <i class="fas fa-cog h-5 w-5 mr-2 text-gray-500"></i>
                                Settings
                            </a>

                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt h-5 w-5 mr-2"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="h-1 bg-brand-500"></div>
</nav>

<script>
    function toggleDropdown() {
        const menu = document.getElementById("dropdownMenu");
        if (menu) {
            menu.classList.toggle("hidden");
        }
    }

    window.addEventListener("click", function (e) {
        const button = document.querySelector("button[onclick='toggleDropdown()']");
        const menu = document.getElementById("dropdownMenu");
        if (button && menu) {
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add("hidden");
            }
        }
    });

    function openModal(model) {
        const modal = document.getElementById(model);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModal(model) {
        const modal = document.getElementById(model);
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>
