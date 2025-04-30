<div class="bg-white rounded-xl shadow-soft p-6">
    @if(isset($invitations) && $invitations->where('status', 'accepted')->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($invitations->where('status', 'accepted') as $invitation)
            <div class="rounded-xl overflow-hidden border border-gray-200 hover:shadow-md transition">
                <div class="h-24 bg-gradient-to-r from-brand-700 to-brand-900 relative">
                    <div class="absolute left-1/2 transform -translate-x-1/2 -bottom-8">
                        <div class="w-16 h-16 rounded-full bg-white p-1 shadow-md">
                            <img 
                                src="{{ asset('storage/' . ($invitation->club->user->profile_image ?? '../../../images/la-personne.png')) }}" 
                                alt="Profile photo" 
                                class="w-full h-full object-cover" 
                            />
                        </div>
                    </div>
                </div>
                
                <div class="pt-10 pb-5 px-4 text-center">
                    <h3 class="font-semibold text-gray-900">{{ $invitation->club->user->full_name ?? 'Club inconnu' }}</h3>
                    <p class="text-gray-500 text-sm">{{ $invitation->club->user->bio ?? 'bio inconnu' }}</p>

                    <div class="my-3">
                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-semibold">Acceptée</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
        <div class="bg-gray-50 rounded-lg p-4 text-center text-gray-500">
            Aucun historique d'invitation
        </div>
    @endif
    @if(auth()->check() && auth()->id() === $user->id)
        <h3 class="text-xl font-semibold text-gray-800 m-10">Invitations de Clubs</h3>

        @if(session('acceptedClubName'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="h-12 w-12 rounded-full bg-green-200 flex items-center justify-center text-green-600 font-bold text-lg">
                        <i class="fas fa-check h-6 w-6 text-current"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-green-800">Félicitations!</h4>
                        <p>Vous avez rejoint le club <strong>{{ session('acceptedClubName') }}</strong></p>
                    </div>
                </div>
            </div>
        @endif


        @if(isset($invitations) && count($invitations) > 0)
            <div class="space-y-4">
                @foreach($invitations as $invitation)
                    @if($invitation->status == 'pending')
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="h-12 w-12 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 font-bold text-lg">
                                        {{ substr($invitation->club->user->name ?? 'C', 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">
                                            {{ $invitation->club->user->name ?? 'Club inconnu' }}
                                        </h4>
                                        <p class="text-sm text-gray-500">
                                            Invitation reçue le {{ $invitation->created_at->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <form action="{{ route('invitations.accept', $invitation->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition-colors duration-300">
                                            Accepter
                                        </button>
                                    </form>
                                    <form action="{{ route('invitations.reject', $invitation->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
                                            Refuser
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            
            @if(!$invitations->where('status', 'pending')->count())
                <div class="bg-gray-50 rounded-lg p-6 text-center text-gray-500">
                    Vous n'avez aucune invitation de club en attente.
                </div>
            @endif
        @else
            <div class="bg-gray-50 rounded-lg p-6 text-center text-gray-500">
                Vous n'avez aucune invitation de club en attente.
            </div>
        @endif
    @endif



    
    </div>
</div>