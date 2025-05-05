<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FootballConnect Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    body {
      font-family: 'Inter', sans-serif;
    }
    .animate-fade-in {
      animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px); 
    }
    to {
        opacity: 1;
        transform: translateY(0); 
    }
    }

    .animate-fade-in-up {
    animation: fadeInUp 0.3s ease-out;
    }

    #dropdownMenu {
    transform-origin: top center; 
    }


  </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex">
    
    @include('components.dashboard.navbar')

  <main class="flex-1 overflow-y-auto">
    <header class="bg-gray-800 border-b border-gray-700 py-4 px-6 flex justify-between items-center sticky top-0 z-10">
      <div class="flex items-center">
        <button id="burgerBtn" class="text-white md:hidden">
            <i class="fas fa-bars"></i>
        </button>        
        <h1 class="text-xl font-semibold">Admin Dashboard</h1>
      </div>
      
      <div class="flex items-center space-x-4">
        <div class="relative hidden md:block">
          <input type="text" placeholder="Search..." class="bg-gray-700 border border-gray-600 rounded-full py-1.5 pl-9 pr-4 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 w-64">
          <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
        </div>
        
        
        <div id="dropdownToggle" class="flex items-center relative cursor-pointer">
            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
              A
            </div>
            @php $authUser = Auth::user(); @endphp
            <div class="ml-2 hidden md:block">
              <div class="text-sm font-medium">{{ $authUser->username }}</div>
            </div>
          </div>
          
          <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden">
            <div class="py-2">
              <div class="px-4 py-2 border-b border-gray-100">
                <p class="text-sm font-medium text-gray-900">{{ $authUser->full_name }}</p>
                <p class="text-xs text-gray-500">{{ $authUser->email }}</p>
              </div>
              <div class="border-t border-gray-100 mt-2 pt-2">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                  <i class="fas fa-sign-out-alt h-5 w-5 mr-2"></i>
                  Logout
                </a>
              </div>
            </div>
          </div>          
      </div>
    </header>

    <div class="p-6">
      <div class="max-w-7xl mx-auto">

        @include('components.dashboard.static_carte')

        <div class="p-6">
          @yield('content')
        </div>

      </div>
    </div>
  </main>
  <script>
    const burgerBtn = document.getElementById('burgerBtn');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const closeBtn = document.getElementById('closeBtn');

    burgerBtn.addEventListener('click', () => {
        mobileSidebar.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', () => {
        mobileSidebar.classList.add('hidden');
    });

    document.addEventListener("DOMContentLoaded", function () {
    const dropdownToggle = document.getElementById("dropdownToggle");
    const dropdownMenu = document.getElementById("dropdownMenu");

    if (dropdownToggle && dropdownMenu) {
        dropdownToggle.addEventListener("click", function (e) {
            e.stopPropagation();

            if (dropdownMenu.classList.contains("hidden")) {
                dropdownMenu.classList.remove("hidden");

                // Remove animation class if it already exists
                dropdownMenu.classList.remove("animate-fade-in-up");

                // Force reflow to restart animation
                void dropdownMenu.offsetWidth;

                // Add animation to make it fade in from the bottom
                dropdownMenu.classList.add("animate-fade-in-up");
            } else {
                dropdownMenu.classList.add("hidden");
            }
        });

        window.addEventListener("click", function (e) {
            if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });
    }
});


  </script>
</body>
</html>