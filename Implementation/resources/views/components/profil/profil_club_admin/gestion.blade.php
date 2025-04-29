<div class="bg-white rounded-xl p-5">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Gestion</h2>
        @if(auth()->check() && auth()->id() === $user->id)
            <button onclick="openModal('gestionModal')" class="text-brand-500 hover:text-brand-600 text-sm font-medium flex items-center transition">
                <i class="fas fa-edit h-4 w-4 mr-1"></i>
                Edit
            </button>
        @endif
    </div>
    <div id="Gestion-text" class="text-gray-700 leading-relaxed">
        {{ $profile->Gestion === '' ? 'No management information yet. Click the edit button to add details about your management approach and philosophy.' : $profile->Gestion }}
    </div>
</div>

@if($profile)
<div id="gestionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl animate-fade-in">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Edit Gestion</h3>
            <button type="button" onclick="closeModal('gestionModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times h-5 w-5"></i>
            </button>
        </div>
        
        <form id="gestionForm" method="POST" action="{{ route('profiles.update', ['userId' => $profile->user_id]) }}">
            @csrf
            @method('PUT')
            <textarea 
                name="Gestion" 
                rows="6" 
                class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                placeholder="Write about your management approach and philosophy..."
                required
            >{{ $profile->Gestion }}</textarea>
            
            <div class="flex justify-end mt-5 space-x-3">
                <button type="button" onclick="closeModal('gestionModal')" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-sm bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endif
