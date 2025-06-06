<div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5">
    <div class="flex justify-between items-center mb-5">
        <h2 class="font-semibold text-gray-900">Performance Stats</h2>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-gray-50 rounded-xl p-4 text-center hover:bg-gray-100 transition">
            <div class="w-16 h-16 rounded-full bg-brand-100 flex items-center justify-center mx-auto mb-2">
                <span class="text-xl font-bold text-brand-600">
                    {{ $user->posts->count()}}
                </span>
            </div>
            <span class="text-sm text-gray-600">Activité</span>
        </div>

        <div class="bg-gray-50 rounded-xl p-4 text-center hover:bg-gray-100 transition">
            <div class="w-16 h-16 rounded-full bg-brand-100 flex items-center justify-center mx-auto mb-2">
                <span class="text-xl font-bold text-brand-600">
                    {{ $user->joueurProfile->experiences->count() }}
                </span>
            </div>
            <span class="text-sm text-gray-600">Expérience</span>
        </div>
    </div>
    
    
</div>
