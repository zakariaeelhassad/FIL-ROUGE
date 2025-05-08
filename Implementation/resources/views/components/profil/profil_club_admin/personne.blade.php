<!-- Section des joueurs -->
<div class="relative">
    @if(auth()->check() && auth()->id() === $user->id)
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3 sm:gap-0">
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

    <!-- Affichage des joueurs membres du club -->
    <div class="mb-6">
        <h4 class="text-lg font-medium text-gray-700 mb-3">Membres actuels</h4>
        @if(isset($clubMembers) && $clubMembers->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($clubMembers as $member)
                    @php
                        $user = $member->user ?? null;
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
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-semibold">Membre</span>
                            </div>
                            <p class="text-xs text-gray-500">Depuis le {{ $member->updated_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 rounded-lg p-4 text-center text-gray-500">
                Aucun membre dans votre club
            </div>
        @endif
    </div>

    <!-- Affichage des invitations acceptées -->
    <div class="mb-6">
        <h4 class="text-lg font-medium text-gray-700 mb-3">Invitations acceptées</h4>
        @if(isset($invitations) && $invitations->where('status', 'accepted')->count() > 0)
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

    <!-- Affichage des invitations en attente -->
    <div>
        <h4 class="text-lg font-medium text-gray-700 mb-3">Invitations en attente</h4>
        @if(isset($invitations) && $invitations->where('status', 'pending')->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($invitations->where('status', 'pending') as $invitation)
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
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 font-semibold">En attente</span>
                            </div>
                            <p class="text-xs text-gray-500">Invité le {{ $invitation->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 rounded-lg p-4 text-center text-gray-500">
                Aucune invitation en attente
            </div>
        @endif
    </div>
</div>

<!-- Modal d'invitation des joueurs -->
<div id="invitePlayersModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl mx-4 sm:mx-6 md:mx-auto max-h-[90vh] overflow-y-auto relative">
        <!-- Header -->
        <div class="px-4 py-5 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Inviter des Joueurs</h3>
            <button type="button" onclick="closeModal('invitePlayersModal')" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Contenu du modal -->
        <div class="px-4 py-5">
            <!-- Recherche -->
            <div class="mb-4 relative">
                <input type="text" id="playerSearch" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-brand-500 focus:border-brand-500" placeholder="Rechercher un joueur...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search h-5 w-5 text-gray-400" aria-hidden="true"></i>
                </div>
            </div>

            <!-- Liste des joueurs -->
            <div class="max-h-80 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody id="playersList" class="divide-y divide-gray-100">
                        @if(isset($availableJoueurs) && $availableJoueurs->count() > 0)
                            @foreach($availableJoueurs as $joueur)
                                @if($joueur->joueurProfile)
                                <tr class="player-item hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                {{ substr($joueur->full_name ?? $joueur->name ?? 'J', 0, 1) }}
                                            </div>
                                            <div class="text-gray-900 font-medium player-name">{{ $joueur->full_name ?? $joueur->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 player-email">{{ $joueur->email }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <form action="{{ route('invitations.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="joueur_id" value="{{ $joueur->joueurProfile->id }}">
                                            <button type="submit" class="px-3 py-1.5 bg-brand-500 hover:bg-brand-600 text-white text-xs rounded">
                                                Inviter
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500">Aucun joueur disponible</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-4 py-4 border-t border-gray-200 flex justify-end">
            <button type="button" onclick="closeModal('invitePlayersModal')" class="px-4 py-2 rounded-md border text-gray-700 hover:bg-gray-50">
                Fermer
            </button>
        </div>
    </div>
</div>
<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('playerSearch');
        const playerItems = document.querySelectorAll('.player-item');

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                const searchValue = this.value.toLowerCase();
                playerItems.forEach(item => {
                    const name = item.querySelector('.player-name')?.textContent.toLowerCase() || '';
                    const email = item.querySelector('.player-email')?.textContent.toLowerCase() || '';
                    item.style.display = (name.includes(searchValue) || email.includes(searchValue)) ? '' : 'none';
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