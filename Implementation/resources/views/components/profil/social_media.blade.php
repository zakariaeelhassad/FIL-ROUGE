<div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-semibold text-gray-900">Social Media</h2>
        @if(auth()->check() && auth()->id() === $user->id)
        <button onclick="toggleModal()" class="text-brand-500 hover:text-brand-600 text-sm font-medium flex items-center transition">
            <i class="fas fa-edit h-4 w-4 mr-1"></i>
            Edit
        </button>
        @endif
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ $socialMedia->google ?? '#' }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-red-500 text-white hover:bg-red-600 transition shadow-sm">
            <i class="fab fa-google text-white"></i>
        </a>

        <a href="{{ $socialMedia->twitter ?? '#' }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-400 text-white hover:bg-blue-500 transition shadow-sm">
            <i class="fab fa-twitter text-white"></i>
        </a>

        <a href="{{ $socialMedia->linkedin ?? '#' }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
            <i class="fab fa-linkedin text-white"></i>
        </a>

        <a href="{{ $socialMedia->instagram  ?? '#' }}" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-pink-500 text-white hover:bg-pink-600 transition shadow-sm">
            <i class="fab fa-instagram text-white"></i>
        </a>
        
    </div>

    <div class="mt-5 pt-5 border-t border-gray-100">
        <h3 class="text-sm font-medium text-gray-700 mb-3">Contact Information</h3>
        <div class="space-y-2">
            <div class="flex items-center text-sm">
                <i class="fas fa-envelope h-4 w-4 text-gray-500 mr-2"></i>
                <span class="text-gray-600">{{ $user->email }}</span>
            </div>
            <div class="flex items-center text-sm">
                <i class="fas fa-envelope h-4 w-4 text-gray-500 mr-2"></i>
                <span class="text-gray-600">06 99 76 76 89</span>
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && auth()->id() === $user->id)
<!-- Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">
        <h2 class="text-lg font-semibold mb-4">Edit Social Media Links</h2>

        <form action="{{ route('social-media.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="url" name="google" placeholder="Google URL" value="{{ $socialMedia->google ?? '' }}" class="w-full border p-2 rounded" />
            <input type="url" name="twitter" placeholder="Twitter URL" value="{{ $socialMedia->twitter ?? '' }}" class="w-full border p-2 rounded" />
            <input type="url" name="linkedin" placeholder="LinkedIn URL" value="{{ $socialMedia->linkedin ?? '' }}" class="w-full border p-2 rounded" />
            <input type="url" name="instagram" placeholder="Instagram URL" value="{{ $socialMedia->instagram ?? '' }}" class="w-full border p-2 rounded" />

            <div class="flex justify-end gap-2">
                <button type="button" onclick="toggleModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    function toggleModal() {
        const modal = document.getElementById('editModal');
        modal.classList.toggle('hidden');
    }
</script>
@endif