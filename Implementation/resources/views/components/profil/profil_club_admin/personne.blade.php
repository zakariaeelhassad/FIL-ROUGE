<div class="relative">
    @if(auth()->check() && auth()->id() === $user->id)
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-800">Joueurs</h3>
        <button 
            type="button" 
            onclick="openModal('invitePlayersModal')" 
            class="px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition-colors duration-300 flex items-center gap-2"
        >
        <i class="fas fa-plus h-5 w-5"></i>
            Inviter des Joueurs
        </button>
    </div>
    @endif


    @if(isset($invitations) && is_countable($invitations) && $invitations->where('status', 'accepted')->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($invitations->where('status', 'accepted') as $invitation)
                @php
                    $user = $invitation->joueur->user ?? null;
                @endphp
                <div class="rounded-xl overflow-hidden border border-gray-200 hover:shadow-md transition">
                    <div class="h-24 bg-gradient-to-r from-brand-700 to-brand-900 relative">
                        <div class="absolute left-1/2 transform -translate-x-1/2 -bottom-8">
                            <div class="w-16 h-16 rounded-full bg-white p-1 shadow-md">
                                <div class="w-full h-full rounded-full overflow-hidden bg-gray-100">
                                    <img 
                                        src="{{ asset('storage/' . ($user->profile_image ?? '../../../images/la-personne.png')) }}" 
                                        alt="Profile photo" 
                                        class="w-full h-full object-cover" 
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-10 pb-5 px-4 text-center">
                        <h3 class="font-semibold text-gray-900">{{ $user->full_name ?? 'Joueur' }}</h3>
                        <p class="text-gray-500 text-sm">{{ $user->email ?? 'email@example.com' }}</p>

                        <div class="my-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-semibold">Acceptée</span>
                        </div>

                        <p class="text-xs text-gray-500">Invité le {{ $invitation->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-gray-50 rounded-lg p-4 text-center text-gray-500">
            Aucune invitation acceptée
        </div>
    @endif
    
</div>

<div id="invitePlayersModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="invitePlayersModalLabel" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="invitePlayersModalLabel">
                            Inviter des Joueurs
                        </h3>
                    
                        <div class="mt-4 mb-4">
                            <div class="relative">
                                <input type="text" id="playerSearch" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-brand-500 focus:border-brand-500" placeholder="Rechercher un joueur...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search h-5 w-5 text-gray-400" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="max-h-80 overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="playersList">
                                    @if(isset($availableJoueurs) && count($availableJoueurs) > 0)
                                        @foreach($availableJoueurs as $joueur)
                                        <tr class="player-item hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 mr-3">
                                                        {{ substr($joueur->name ?? 'J', 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900 player-name">{{ $joueur->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500 player-email">{{ $joueur->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('invitations.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="joueur_id" value="{{ $joueur->joueurProfile->id }}">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-brand-500 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                                                        Inviter
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                Aucun joueur disponible
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal('invitePlayersModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('playerSearch');
        const playerItems = document.querySelectorAll('.player-item');
        
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                
                playerItems.forEach(item => {
                    const name = item.querySelector('.player-name')?.textContent.toLowerCase() || '';
                    const email = item.querySelector('.player-email')?.textContent.toLowerCase() || '';
                    
                    if (name.includes(searchValue) || email.includes(searchValue)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });

    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden'; 
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = ''; 
    }
</script>