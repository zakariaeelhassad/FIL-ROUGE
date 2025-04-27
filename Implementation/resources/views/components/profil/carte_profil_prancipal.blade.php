<div class="rounded-2xl overflow-hidden bg-white shadow-soft border border-gray-100">
    <div class="h-48 relative overflow-hidden bg-gradient-to-r from-brand-800 to-brand-950">
        @if($user->banner_image)
            <img src="{{ asset('storage/' . $user->banner_image) }}" alt="Banner Image" class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
    </div>

    <div class="relative px-6 py-6">
        <div class="absolute -top-16 left-6">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-md bg-white">
                <img
                    src="{{ asset('storage/' . ($user->profile_image ?? '../../../images/la-personne.png')) }}"
                    alt="Profile Image"
                    class="w-full h-full object-cover"
                />
            </div>
        </div>

        <div class="ml-36 flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->full_name }}</h1>
                <p class="text-gray-600 mt-1">{{ $user->bio ?? 'No bio available' }}</p>
                
                <div class="mt-3 flex items-center space-x-3">
                    @if($user->role == 'club_admin')
                        <span class="px-3 py-1 bg-brand-100 text-brand-700 text-xs font-medium rounded-full">Club Admin</span>
                    @elseif($user->role == 'joueur')
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Player</span>
                    @endif
                    
                    <span class="text-gray-500 text-sm">Joined {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
            @if(auth()->check() && auth()->id() !== $user->id)
            <div class="text-gray-400 relative group">
                <button class="hover:text-brand-500 p-1 rounded-full hover:bg-gray-50"
                        onclick="toggleDropdown({{ $user->id }})">
                    <i class="fas fa-ellipsis-v"></i>
                </button>


                <div id="dropdown-{{ $user->id }}" class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-xl shadow-md z-20 hidden">
                    <button
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        onclick="openReportModal({{ $user->id }}, 'user')"
                    >
                        Signaler ce commenter
                    </button>
                </div>
            </div>
            @endif
            @if(auth()->check() && auth()->id() === $user->id)
                @if($user->role == 'club_admin' || $user->role == 'joueur')
                    <button class="bg-brand-500 hover:bg-brand-600 text-white px-5 py-2 rounded-full text-sm font-medium transition shadow-sm" id="editProfileBtn">
                        Edit Profile
                        <i class="fas fa-edit h-6 w-6"></i>
                    </button>
                @endif
            @endif
        </div>
        
        <div class="mt-6 flex items-center justify-around border-t border-gray-100 pt-4">
            <div class="text-center">
                <div class="text-xl font-bold text-gray-900">{{ $user->followers->count() }}</div>
                <div class="text-sm text-gray-500">Followers</div>
            </div>
            <div class="text-center">
                <div class="text-xl font-bold text-gray-900">{{ $user->following->count() }}</div>
                <div class="text-sm text-gray-500">Following</div>
            </div>
        </div>        
    </div>
</div>


<div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-8 rounded-2xl w-full max-w-md shadow-xl animate-fade-in">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Edit Profile</h2>
            <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times h-6 w-6"></i>
            </button>
        </div>

        <form action="{{ route('profile.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="full_name" id="full_name" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" value="{{ $user->full_name }}" required>
            </div>

            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                <textarea name="bio" id="bio" rows="3" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition">{{ $user->bio }}</textarea>
            </div>

            <div>
                <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-1">Profile Image</label>
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . ($user->profile_image ?? '../../../images/la-personne.png')) }}" alt="Current profile" class="w-full h-full object-cover">
                    </div>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" class="flex-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                </div>
            </div>

            <div>
                <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-1">Banner Image</label>
                <input type="file" name="banner_image" id="banner_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
            </div>

            <div class="flex justify-end space-x-3 pt-3">
                <button type="button" id="cancelBtn" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit" class="px-5 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div id="report-modal" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl">
        <h2 class="text-lg font-semibold mb-4">Signaler un contenu</h2>
        <form method="POST" action="{{ route('reports.store') }}">
            @csrf
            <input type="hidden" name="reported_type" id="reported_type">
            <input type="hidden" name="reported_id" id="reported_id">

            <label class="block text-sm font-medium text-gray-700 mb-1">Raison</label>
            <textarea name="reason" rows="4" required class="w-full border border-gray-300 rounded-lg p-2 mb-4 focus:outline-none focus:ring-2 focus:ring-brand-200"></textarea>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeReportModal()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Annuler</button>
                <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600">Envoyer</button>
            </div>
        </form>
    </div>
</div>


<script>

    function toggleDropdown(userId) {
        const dropdown = document.getElementById('dropdown-' + userId);
        dropdown.classList.toggle('hidden');
    }

    function openReportModal(id, type) {
        document.getElementById('reported_id').value = id;
        document.getElementById('reported_type').value = type;
        document.getElementById('report-modal').classList.remove('hidden');
        document.getElementById('report-modal').classList.add('flex');
    }

    function closeReportModal() {
        document.getElementById('report-modal').classList.remove('flex');
        document.getElementById('report-modal').classList.add('hidden');
    }

    


    const modal = document.getElementById("editProfileModal");
    const editProfileBtn = document.getElementById("editProfileBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const cancelBtn = document.getElementById("cancelBtn");

    editProfileBtn.onclick = function() {
        modal.classList.remove("hidden");
        document.body.style.overflow = "hidden"; 
    }

    closeModalBtn.onclick = function() {
        modal.classList.add("hidden");
        document.body.style.overflow = "";  
    }
    
    cancelBtn.onclick = function() {
        modal.classList.add("hidden");
        document.body.style.overflow = ""; 
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.classList.add("hidden");
            document.body.style.overflow = ""; 
        }
    }
</script>


