<div class="rounded-3xl bg-[#0a1445] text-white p-4 border-2 border-blue-500">
    <div class="rounded-xl bg-white border-2 border-blue-400 h-40 mb-4">
        @if(Auth::user()->banner_image)
            <img src="{{ asset('storage/' . Auth::user()->banner_image) }}" alt="Banner Image" class="w-full h-full object-cover rounded-xl">
        @else
            <p class="text-center text-gray-500">No banner image</p>
        @endif
    </div>

    <div class="flex items-center space-x-4">
        <div class="relative">
            <div class="w-24 h-24 rounded-full bg-white p-1">
                <img
                    src="{{ asset('storage/' . Auth::user()->profile_image ?? 'default-avatar.png') }}"
                    alt="Profile Image"
                    class="w-full h-full rounded-full object-contain"
                />
            </div>
        </div>

        <div class="flex-1">
            <h1 class="text-xl font-bold">{{ Auth::user()->full_name }}</h1>
            <p class="text-gray-300">{{ Auth::user()->bio ?? 'No bio available' }}</p>
            <div class="mt-1">
                @if(Auth::user()->role == 'club_admin')
                    <span class="px-3 py-1 bg-white text-[#0a1445] text-xs rounded-full">Club </span>
                @elseif(Auth::user()->role == 'joueur')
                    <span class="px-3 py-1 bg-white text-[#0a1445] text-xs rounded-full">Player</span>
                @endif
            </div>
        </div>
    </div>

    @if(Auth::user()->role == 'club_admin' || Auth::user()->role == 'joueur')
        <div class="mt-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-full" id="editProfileBtn">Edit Profile</button>
        </div>
    @endif
</div>

<div id="editProfileModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-6 rounded-xl w-96">
        <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>

        <form action="{{ route('profile.update', ['id' => Auth::user()->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="full_name" class="block text-sm font-semibold text-gray-700">Full Name</label>
                <input type="text" name="full_name" id="full_name" class="w-full p-2 rounded border-2 border-gray-300" value="{{ Auth::user()->full_name }}" required>
            </div>

            <div class="mb-4">
                <label for="bio" class="block text-sm font-semibold text-gray-700">Bio</label>
                <textarea name="bio" id="bio" class="w-full p-2 rounded border-2 border-gray-300">{{ Auth::user()->bio }}</textarea>
            </div>

            <div class="mb-4">
                <label for="profile_image" class="block text-sm font-semibold text-gray-700">Profile Image</label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*">
            </div>

            <div class="mb-4">
                <label for="banner_image" class="block text-sm font-semibold text-gray-700">Banner Image</label>
                <input type="file" name="banner_image" id="banner_image" accept="image/*">
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-full">Save Changes</button>
                <button type="button" id="closeModalBtn" class="bg-red-500 text-white px-4 py-2 rounded-full">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Get modal and buttons
    const modal = document.getElementById("editProfileModal");
    const editProfileBtn = document.getElementById("editProfileBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");

    // Show the modal when the "Edit Profile" button is clicked
    editProfileBtn.onclick = function() {
        modal.classList.remove("hidden");
    }

    // Close the modal when the "Cancel" button is clicked
    closeModalBtn.onclick = function() {
        modal.classList.add("hidden");
    }

    // Close the modal when clicking outside the modal area
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.classList.add("hidden");
        }
    }
</script>
