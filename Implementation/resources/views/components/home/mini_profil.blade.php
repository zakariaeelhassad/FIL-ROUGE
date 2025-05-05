@php
    $user = Auth::user();
@endphp

<div class="rounded-2xl overflow-hidden bg-white shadow-soft border border-gray-100">
    <div class="h-28 relative overflow-hidden">
        <img src="{{ $user->banner_image ? asset('storage/' . $user->banner_image) : '../../../images/téléchargement.jpg' }}"
             alt="Banner Image"
             class="w-full h-full object-cover" />
             
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
    </div>    
    
    <div class="px-6 pt-14 pb-6 text-center relative">
        <div class="absolute -top-10 left-1/2 transform -translate-x-1/2">
            <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-white shadow-sm bg-white">
                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : '../../../images/la-personne.png' }}" 
                     alt="Profile Picture" 
                     class="w-full h-full object-cover" />
            </div>
        </div>
        
        <h2 class="text-brand-600 font-bold text-xl mb-1">{{ $user->full_name ?? $user->username }}</h2>
        
        <p class="text-gray-500 text-sm mb-5 line-clamp-2">{{ $user->bio ?? 'Aucune bio disponible.' }}</p>
        
        <div class="flex justify-center items-center mb-5">
            <div class="flex flex-col items-center">
                <span class="text-2xl font-bold text-gray-800">{{ $user->followers->count() }}</span>
                <span class="text-gray-400 text-sm">followers</span>
            </div>
        </div>
        
        <a href="/profil/joueur" class="block">
            <button class="bg-brand-50 border border-brand-200 text-brand-600 rounded-full px-8 py-2.5 w-full font-medium hover:bg-brand-100 transition">
                VOIR LE PROFIL
            </button>
        </a>
    </div>
</div>
