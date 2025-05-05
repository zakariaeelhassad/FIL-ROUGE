<div class="bg-white rounded-xl p-5">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-5 gap-3">
        <h2 class="text-lg font-semibold text-gray-900">Titres & Achievements</h2>
        @if(auth()->check() && auth()->id() === $user->id)
            <button onclick="openModal('titreModal')" class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-full transition shadow-sm flex items-center justify-center w-full sm:w-auto">
                <i class="fas fa-plus h-4 w-4 mr-1"></i>
                Add Title
            </button>
        @endif
    </div>

    @if($titres->count() > 0)
        <div class="space-y-4">
            @foreach($titres as $titre)
                <div class="bg-gray-50 rounded-xl p-4 flex flex-col sm:flex-row sm:items-start sm:justify-between hover:bg-gray-100 transition">
                    <div class="flex items-start">
                        @if(!empty($titre->image))
                            <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-white border border-gray-200">
                                <img src="{{ asset('storage/' . $titre->image) }}" alt="{{ $titre->nom_titre }}" class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="w-16 h-16 flex-shrink-0 rounded-lg bg-brand-100 flex items-center justify-center">
                                <i class="fas fa-trophy h-8 w-8 text-brand-500"></i>
                            </div>
                        @endif

                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-brand-700">{{ $titre->nom_titre }}</h3>
                            <p class="text-gray-600 text-sm mt-1">{{ $titre->description_titre }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:flex-col gap-3 sm:items-end mt-3 sm:mt-0">
                        <div class="text-xl font-bold text-brand-500">{{ $titre->nombre }}</div>
                        @if(auth()->check() && auth()->id() === $user->id)
                            <div class="flex gap-3">
                                <form action="{{ route('titres.delete', $titre->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>  
                                <button onclick="openModal('editTitreModal-{{ $titre->id }}')" class="text-blue-500 hover:text-blue-700" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <div id="editTitreModal-{{ $titre->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4 shadow-xl">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Modifier le Titre</h3>
                            <button type="button" onclick="closeModal('editTitreModal-{{ $titre->id }}')" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times h-5 w-5"></i>
                            </button>
                        </div>

                        <form action="{{ route('update.titre', $titre->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <input type="text" name="nom_titre" value="{{ old('nom_titre', $titre->nom_titre) }}" class="w-full border border-gray-300 rounded-lg p-3" required>
                            <textarea name="description_titre" rows="3" class="w-full border border-gray-300 rounded-lg p-3">{{ old('description_titre', $titre->description_titre) }}</textarea>
                            <input type="number" name="nombre" value="{{ old('nombre', $titre->nombre) }}" class="w-full border border-gray-300 rounded-lg p-3" min="1" required>

                            @if($titre->image)
                                <div>
                                    <img src="{{ asset('storage/' . $titre->image) }}" class="w-24 h-auto mb-2">
                                    <label><input type="checkbox" name="remove_image" value="1"> Supprimer l’image actuelle</label>
                                </div>
                            @endif
                            
                            <input type="file" name="image" class="w-full text-sm text-gray-500">

                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeModal('editTitreModal-{{ $titre->id }}')" class="px-4 py-2 border rounded-lg">Annuler</button>
                                <button type="submit" class="px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="text-center py-10 bg-gray-50 rounded-xl">
            <i class="fas fa-times h-5 w-5"></i>
            <p class="mt-4 text-gray-500">No titles or achievements yet</p>
            <p class="text-sm text-gray-400 mt-1">Click the "Add Title" button to add your first achievement</p>
        </div>
    @endif
</div>

@if($profile)
<div id="titreModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4 shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Add New Title</h3>
            <button type="button" onclick="closeModal('titreModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times h-5 w-5"></i>
            </button>
        </div>
        
        <form action="{{ route('titres.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="text" name="nom_titre" placeholder="Title name" class="w-full border border-gray-300 rounded-lg p-3" required>
            <textarea name="description_titre" placeholder="Description..." rows="3" class="w-full border border-gray-300 rounded-lg p-3" required></textarea>
            <input type="number" name="nombre" placeholder="How many times achieved?" class="w-full border border-gray-300 rounded-lg p-3" required>
            <input type="file" name="image" class="w-full text-sm text-gray-500">
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('titreModal')" class="px-4 py-2 border rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600">Add</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}
</script>
