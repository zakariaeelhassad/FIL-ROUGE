
<div class="mt-4 border-2 border-blue-500 rounded-xl p-4">
    <div class="flex justify-between items-center mb-3">
        <h2 class="font-bold">Tactique</h2>
        <button onclick="openModal('tactiqueModal')" class="px-3 py-1 border border-blue-500 text-blue-500 rounded-full text-sm">Edit</button>
    </div>
    <p id="Tactique-text" class="text-gray-700 text-sm">
        {{ $profile->Tactique === '' ? 'No Gestion yet.' : $profile->Tactique }}
    </p>
</div>


@if($profile)
<div id="tactiqueModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Edit Tactique</h3>
        <form id="tactiqueForm" method="POST" action="{{ route('profiles.update', ['userId' => $profile->user_id]) }}">
            @csrf
            @method('PUT')
            <textarea name="Tactique" rows="4" class="w-full border rounded-md p-2 text-sm" required>{{ $profile->Tactique }}</textarea>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeModal('tactiqueModal')" class="mr-2 px-4 py-1 text-sm border rounded">Cancel</button>
                <button type="submit" class="px-4 py-1 text-sm bg-blue-500 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>
@endif