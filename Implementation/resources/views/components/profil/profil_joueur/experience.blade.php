<div class="bg-white rounded-xl">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Expérience</h2>
        <button onclick="openModal('experienceModal')" class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium rounded-full transition shadow-sm flex items-center">
            <i class="fas fa-plus h-4 w-4 mr-1"></i>
            Add Experience
        </button>
    </div>

    @if($experiences->count() > 0)
        <div class="space-y-6">
            @foreach($experiences as $experience)
                <div class="bg-gray-50 rounded-xl p-5 hover:bg-gray-100 transition hover-lift">
                    <div class="flex">
                        @if(!empty($experience->image))
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-white border border-gray-200 flex-shrink-0">
                                <img src="{{ asset('storage/' . $experience->image) }}" alt="{{ $experience->nameClub }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-16 h-16 rounded-lg bg-brand-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-globe h-8 w-8 text-brand-500"></i>
                            </div>
                        @endif

                        <div class="ml-4 flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $experience->nameClub }}</h3>
                                    <p class="text-gray-600 flex items-center text-sm mt-1">
                                        <i class="fas fa-map-marker-alt h-4 w-4 mr-1 text-gray-400"></i>
                                        {{ $experience->place }}
                                    </p>
                                </div>
                                <span class="bg-brand-50 text-brand-600 text-xs font-medium px-2.5 py-1 rounded-full capitalize">
                                    {{ $experience->categoryType }}
                                </span>
                            </div>
                            
                            <div class="flex items-center mt-3 text-sm text-gray-500">
                                <i class="fas fa-calendar h-4 w-4 mr-1 text-gray-400"></i>
                                {{ $experience->joiningDate }} - {{ $experience->exitDate ?? 'Present' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <button class="w-full py-3 mt-6 text-center text-gray-700 hover:bg-gray-100 rounded-xl transition font-medium">
            View All Experiences
        </button>
    @else
        <div class="text-center py-10 bg-gray-50 rounded-xl">
            <i class="fas fa-briefcase h-12 w-12 text-gray-400"></i>
            <p class="mt-4 text-gray-500">No experiences yet</p>
            <p class="text-sm text-gray-400 mt-1">Click the "Add Experience" button to add your first experience</p>
        </div>
    @endif
</div>

@if($profile)
<div id="experienceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-xl animate-fade-in">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Add New Experience</h3>
            <button type="button" onclick="closeModal('experienceModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times h-5 w-5"></i>
            </button>
        </div>
        
        <form 
            id="create-experience-form" 
            action="{{ route('experiences.store') }}" 
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4"
        >
            @csrf
            
            <div>
                <label for="nameClub" class="block text-sm font-medium text-gray-700 mb-1">Club Name</label>
                <input 
                    type="text" 
                    name="nameClub" 
                    id="nameClub"
                    class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                    placeholder="e.g. FC Barcelona"
                    required
                >
            </div>
            
            <div>
                <label for="place" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <input 
                    type="text" 
                    name="place" 
                    id="place"
                    class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                    placeholder="e.g. Barcelona, Spain"
                    required
                >
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="joiningDate" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input 
                        type="date" 
                        name="joiningDate" 
                        id="joiningDate"
                        class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                        required
                    >
                </div>
                
                <div>
                    <label for="exitDate" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input 
                        type="date" 
                        name="exitDate" 
                        id="exitDate"
                        class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                        placeholder="Leave blank if current"
                    >
                </div>
            </div>
            
            <div>
                <label for="categoryType" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select 
                    name="categoryType" 
                    id="categoryType"
                    class="w-full border border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition" 
                    required
                >
                    <option value="">Select category</option>
                    <option value="sinyor">Sinyor</option>
                    <option value="jinyor">Jinyor</option>
                    <option value="kadiy">Kadiy</option>
                    <option value="minim">Minim</option>
                </select>
            </div>
            
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Club Logo (Optional)</label>
                <input 
                    type="file" 
                    name="image" 
                    id="image"
                    accept="image/*" 
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100"
                >
            </div>

            <div class="flex justify-end mt-5 space-x-3">
                <button type="button" onclick="closeModal('experienceModal')" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-sm bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition">
                    Add Experience
                </button>
            </div>
        </form>
    </div>
</div>
@endif
