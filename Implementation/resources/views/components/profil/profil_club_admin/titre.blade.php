<div class="bg-white rounded-xl p-5">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg font-semibold text-gray-900">Titres & Achievements</h2>
        @if(auth()->check() && auth()->id() === $user->id)
            <button onclick="openModal('titreModal')" class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-full transition shadow-sm flex items-center">
                <i class="fas fa-plus h-4 w-4 mr-1"></i>
                Add Title
            </button>
        @endif
    </div>

    @if($titres->count() > 0)
        <div class="space-y-4">
            @foreach($titres as $titre)
                <div class="bg-gray-50 rounded-xl p-4 flex items-start hover:bg-gray-100 transition">
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
                        <p class="text-gray-600 text-sm mt-1">{{ $titre->description }}</p>
                    </div>

                    <div class="text-3xl font-bold text-brand-500 ml-4">{{ $titre->nombre }}</div>
                </div>
            @endforeach
        </div>
        
        <button class="w-full py-3 mt-5 text-center text-gray-700 hover:bg-gray-100 rounded-xl transition font-medium">
            View All Titles
        </button>
    @else
        <div class="text-center py-10 bg-gray-50 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
            </svg>
            <p class="mt-4 text-gray-500">No titles or achievements yet</p>
            <p class="text-sm text-gray-400 mt-1">Click the "Add Title" button to add your first achievement</p>
        </div>
    @endif
</div>

@if($profile)
<div id="titreModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl animate-fade-in">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Add New Title</h3>
            <button type="button" onclick="closeModal('titreModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times h-5 w-5"></i>
            </button>
        </div>
        
        <form 
            action="{{ route('titres.store') }}" 
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4"
        >
            @csrf
            
            <div>
                <label for="nom_titre" class="block text-sm font-medium text-gray-700 mb-1">Title Name</label>
                <input 
                    type="text" 
                    name="nom_titre" 
                    id="nom_titre"
                    class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                    placeholder="e.g. Champion League Winner"
                    required
                >
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea 
                    name="description" 
                    id="description"
                    rows="3" 
                    class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                    placeholder="Describe your achievement..."
                    required
                ></textarea>
            </div>
            
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Count</label>
                <input 
                    type="number" 
                    name="nombre" 
                    id="nombre"
                    class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                    placeholder="How many times achieved?"
                    required
                >
            </div>
            
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image (Optional)</label>
                <input 
                    type="file" 
                    name="image" 
                    id="image"
                    accept="image/*" 
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100"
                >
            </div>

            <div class="flex justify-end mt-5 space-x-3">
                <button type="button" onclick="closeModal('titreModal')" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-sm bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                    Add Title
                </button>
            </div>
        </form>
    </div>
</div>
@endif
