<div class="mt-4 border-2 border-blue-400 rounded-xl p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-lg">Titres & Achievements</h2>
        <button onclick="openModal('titreModal')" class="px-3 py-1 border border-blue-500 text-blue-500 rounded-full text-sm">
            Ajouter un titre
        </button>
    </div>

    @if($titres->count() > 0)
        @foreach($titres as $titre)
            <div class="border border-blue-300 rounded-xl p-3 mb-4 flex items-start">
                
                @if(!empty($titre->image))
                <div class="w-20 h-20 flex-shrink-0">
                    <img src="{{ asset('storage/' . $titre->image) }}" alt="Image" class="w-full h-full object-contain rounded">
                </div>
            @endif
            


                <div class="ml-4 flex-1">
                    <h3 class="text-md font-bold text-indigo-800 mb-1">{{ $titre->nom_titre }}</h3>
                    <p class="text-gray-700 text-sm">{{ $titre->description }}</p>
                </div>

                <div class="text-3xl font-bold text-blue-600 w-16 text-right">{{ $titre->nombre }}</div>
            </div>
        @endforeach
    @else
        <p class="text-center text-gray-500">Aucun titre pour le moment</p>
    @endif

    <button class="w-full py-2 text-center text-gray-700 hover:bg-gray-100 rounded">
        Afficher tous les titres
    </button>
</div>

@if($profile)
<div id="titreModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Ajouter un titre</h3>
        <form 
            action="{{ route('titres.store') }}" 
            method="POST"
            enctype="multipart/form-data"
            class="space-y-3"
        >
            @csrf

            <input type="text" name="nom_titre" class="w-full border p-2 rounded" placeholder="Nom du titre" required>
            <textarea name="description" rows="2" class="w-full border p-2 rounded" placeholder="Description" required></textarea>
            <input type="number" name="nombre" class="w-full border p-2 rounded" placeholder="Nombre" required>
            <input type="file" name="image" accept="image/*" class="w-full border rounded p-2" />

            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeModal('titreModal')" class="mr-2 px-4 py-1 text-sm border rounded">Annuler</button>
                <button type="submit" class="px-4 py-1 text-sm bg-blue-500 text-white rounded">Ajouter</button>
            </div>
        </form>
    </div>
</div>
@endif
