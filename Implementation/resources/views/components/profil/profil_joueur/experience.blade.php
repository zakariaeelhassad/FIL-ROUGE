<!-- Section d'expérience -->
<div class="mt-4 border-2 border-blue-400 rounded-xl p-6">
    <!-- En-tête de la section -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-bold text-lg text-blue-600">Expérience</h2>
        <button onclick="openModal('experienceModal')" class="px-3 py-1 border border-blue-500 text-blue-500 rounded-full text-sm">ajouter une expérience</button>
    </div>

    <!-- Affichage des expériences -->
    @if($experiences->count() > 0)
        @foreach($experiences as $experience)
            <div class="flex mb-6 pb-4 border-b border-gray-200">
                <!-- Logo -->
                @if(!empty($experience->image))
                <div class="w-16 h-16 flex-shrink-0">
                    <img src="{{ asset('storage/' . $experience->image) }}" alt="Image"class="w-full h-full object-cover rounded">
                </div>
            @endif

                <!-- Infos -->
                <div class="ml-4">
                    <h3 class="font-bold text-lg">{{ $experience->nameClub }}</h3>
                    <p class="text-gray-700">{{ $experience->place }}</p>
                    <p class="text-gray-700">{{ $experience->joiningDate }} / {{ $experience->exitDate ?? 'Actuel' }}</p>
                    <p class="text-gray-600 italic text-sm">Catégorie : {{ ucfirst($experience->categoryType) }}</p>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-center text-gray-500">Aucune expérience pour le moment</p>
    @endif

    <button class="w-full py-3 text-center text-gray-800 hover:bg-gray-100 rounded border-t border-gray-200">
        Afficher toutes les expériences
    </button>
</div>

@if($profile)
<div id="experienceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Ajouter une expérience</h3>

        <form 
            id="create-experience-form" 
            action="{{ route('experiences.store') }}" 
            method="POST"
            enctype="multipart/form-data"
            class="mt-4 border border-blue-300 p-4 rounded-xl bg-white space-y-3"
        >
            @csrf

            <input type="text" name="nameClub" class="w-full border rounded p-2" placeholder="Nom du club" required>

            <input type="text" name="place" class="w-full border rounded p-2" placeholder="Lieu" required>

            <input type="date" name="joiningDate" class="w-full border rounded p-2" required>

            <input type="date" name="exitDate" class="w-full border rounded p-2">

            <select name="categoryType" class="w-full border rounded p-2" required>
                <option value="">Sélectionner la catégorie</option>
                <option value="sinyor">Sinyor</option>
                <option value="jinyor">Jinyor</option>
                <option value="kadiy">Kadiy</option>
                <option value="minim">Minim</option>
            </select>

            <input type="file" name="image" accept="image/*" class="w-full border rounded p-2" />

            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeModal('experienceModal')" class="mr-2 px-4 py-1 text-sm border rounded">Annuler</button>
                <button type="submit" class="px-4 py-1 text-sm bg-blue-500 text-white rounded">Sauvegarder</button>
            </div>
        </form>
    </div>
</div>
@endif
