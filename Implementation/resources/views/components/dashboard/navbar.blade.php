<aside id="sidebar" class="w-64 bg-gray-800 border-r border-gray-700 hidden md:block sticky top-0 md:sticky md:h-screen">
    <div class="p-4 flex items-center justify-between">
        <div class="p-4 flex justify-center">
            <div class="text-xl font-bold">
                <img class="w-16 h-16" src="../../../images/G_1.png" alt="">
            </div>
        </div>
    </div>
    <nav class="mt-8">
        <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase">Main</div>
        
        <a href="/dashboard" class="nav-button flex items-center py-3 px-4 {{ request()->is('dashboard/admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} rounded-r-lg">
            <i class="fas fa-th h-5 w-5 mr-3"></i>
            <span>Dashboard</span>
        </a>

        <a href="/users/admin" class="nav-button flex items-center py-3 px-4 {{ request()->is('users/admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} rounded-r-lg mt-1">
            <i class="fas fa-users h-5 w-5 mr-3"></i>
            <span>Users</span>
        </a>

        <a href="/posts/admin" class="nav-button flex items-center py-3 px-4 {{ request()->is('posts/admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} rounded-r-lg mt-1">
            <i class="fas fa-newspaper h-5 w-5 mr-3"></i>
            <span>Posts</span>
        </a>

        <a href="/comments/admin" class="nav-button flex items-center py-3 px-4 {{ request()->is('comments/admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} rounded-r-lg mt-1">
            <i class="fas fa-comment-alt h-5 w-5 mr-3"></i>
            <span>Comments</span>
        </a>

        <a href="/reports/admin" class="nav-button flex items-center py-3 px-4 {{ request()->is('reports/admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} rounded-r-lg mt-1">
            <i class="fas fa-exclamation-triangle h-5 w-5 mr-3"></i>
            <span>Reports</span>
        </a>
    </nav>
</aside>

<aside id="mobileSidebar" class="md:hidden fixed inset-0 bg-gray-800 bg-opacity-75 z-50 hidden">
    <div class="p-4 flex items-center justify-between">
        <div class="ml-3 text-xl font-bold text-white">FootballConnect</div>
        <button id="closeBtn" class="text-white">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <nav class="mt-8">
        <a href="/dashboard/admin" class="nav-button flex items-center py-3 px-4 {{ request()->is('dashboard/admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} rounded-r-lg">
            <i class="fas fa-th h-5 w-5 mr-3"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="/users/admin" class="nav-button flex items-center py-3 px-4 {{ request()->is('users/admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} rounded-r-lg mt-1">
            <i class="fas fa-users h-5 w-5 mr-3"></i>
            <span>Users</span>
        </a>

        <a href="/posts/admin" class="nav-button flex items-center py-3 px-4 {{ request()->is('posts/admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} rounded-r-lg mt-1">
            <i class="fas fa-newspaper h-5 w-5 mr-3"></i>
            <span>Posts</span>
        </a>

        <a href="/comments/admin" class="nav-button flex items-center py-3 px-4 {{ request()->is('comments/admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} rounded-r-lg mt-1">
            <i class="fas fa-comment-alt h-5 w-5 mr-3"></i>
            <span>Comments</span>
        </a>

        <a href="/reports/admin" class="nav-button flex items-center py-3 px-4 {{ request()->is('reports/admin') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} rounded-r-lg mt-1">
            <i class="fas fa-exclamation-triangle h-5 w-5 mr-3"></i>
            <span>Reports</span>
        </a>
    </nav>
</aside>
