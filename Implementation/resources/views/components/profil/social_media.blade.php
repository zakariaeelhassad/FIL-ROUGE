<div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-semibold text-gray-900">Social Media</h2>
        <button class="text-brand-500 hover:text-brand-600 text-sm font-medium flex items-center transition">
            <i class="fas fa-edit h-4 w-4 mr-1"></i>
            Edit
        </button>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="#" class="flex items-center justify-center w-10 h-10 rounded-full bg-red-500 text-white hover:bg-red-600 transition shadow-sm">
            <i class="fab fa-google text-white"></i>
        </a>

        <a href="#" class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-500 text-white hover:bg-brand-600 transition shadow-sm">
            <i class="fab fa-twitter text-white"></i>
        </a>

        <a href="#" class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
            <i class="fab fa-linkedin text-white"></i>
        </a>

        <a href="#" class="flex items-center justify-center w-10 h-10 rounded-full bg-pink-500 text-white hover:bg-pink-600 transition shadow-sm">
            <i class="fab fa-instagram text-white"></i>
        </a>
    </div>
    
    <div class="mt-5 pt-5 border-t border-gray-100">
        <h3 class="text-sm font-medium text-gray-700 mb-3">Contact Information</h3>
        <div class="space-y-2">
            <div class="flex items-center text-sm">
                <i class="fas fa-envelope h-4 w-4 text-gray-500 mr-2"></i>
                <span class="text-gray-600">{{ Auth::user()->email }}</span>
            </div>
            <div class="flex items-center text-sm">
                <i class="fas fa-phone h-4 w-4 text-gray-500 mr-2"></i>
                <span class="text-gray-600">+1 (555) 123-4567</span>
            </div>
            <div class="flex items-center text-sm">
                <i class="fas fa-map-marker-alt h-4 w-4 text-gray-500 mr-2"></i>
                <span class="text-gray-600">Paris, France</span>
            </div>
        </div>
    </div>
</div>
