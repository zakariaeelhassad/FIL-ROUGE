<div class="bg-white rounded-2xl border border-blue-200 p-5 max-w-7xl mx-auto mt-8">
    <h2 class="text-blue-900 font-bold text-lg mb-4">Personnes que vous connaissez</h2>

    <!-- People Grid -->
    <div class="grid grid-cols-3 gap-4">
        @foreach ($users as $user)
        <div class="rounded-xl overflow-hidden border border-blue-200 h-48">
            <div class="bg-indigo-900 pt-4 pb-2 px-2 relative">
                <div class="w-12 h-12 mx-auto bg-blue-500 rounded-full overflow-hidden mb-1">
                    <img src="https://placehold.co/100x100" alt="Photo de profil" class="w-full h-full object-cover" />
                </div>
            </div>
            <div class="bg-white p-2 text-center">
                <p class="text-blue-600 font-semibold text-xs">{{ $user->full_name }}</p>
                <p class="text-gray-400 text-xs mb-8">{{ $user->role }}</p>
                <a href="" class="bg-white border border-blue-200 text-blue-600 px-3 py-1 rounded-full text-xs hover:bg-blue-50 w-full">
                    Se connecter
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

