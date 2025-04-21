<div class="bg-white rounded-xl p-5">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Gestion</h2>
        <button onclick="openModal('gestionModal')" class="text-brand-500 hover:text-brand-600 text-sm font-medium flex items-center transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
            Edit
        </button>
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
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
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
