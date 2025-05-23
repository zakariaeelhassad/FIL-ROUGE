@extends('layouts.app', ['title' => 'profil'])

@section('content')
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <div class="max-w-4xl mx-auto px-4 py-8">
        @include("components.profil.carte_profil_prancipal")

        <div class="mt-6">
            @include("components.profil.profil_club_admin.performance_stats")
        </div>

        <div class="mt-8 bg-white rounded-2xl shadow-soft">
            <div class="border-b border-gray-100">
                <nav class="flex overflow-x-auto scrollbar-hide space-x-2 md:space-x-0 md:overflow-visible">
                    <button data-target="description" class="nav-button px-4 py-3 text-sm md:text-base text-gray-700 transition-colors duration-300 hover:text-brand-500 focus:outline-none whitespace-nowrap">
                        Description
                    </button>
                    <button data-target="ecole" class="nav-button px-4 py-3 text-sm md:text-base text-gray-700 transition-colors duration-300 hover:text-brand-500 focus:outline-none whitespace-nowrap">
                        Ecole
                    </button>
                    <button data-target="tactique" class="nav-button px-4 py-3 text-sm md:text-base text-gray-700 transition-colors duration-300 hover:text-brand-500 focus:outline-none whitespace-nowrap">
                        Tactique
                    </button>
                    <button data-target="gestion" class="nav-button px-4 py-3 text-sm md:text-base text-gray-700 transition-colors duration-300 hover:text-brand-500 focus:outline-none whitespace-nowrap">
                        Gestion
                    </button>
                    <button data-target="activité" class="nav-button px-4 py-3 text-sm md:text-base text-gray-700 transition-colors duration-300 hover:text-brand-500 focus:outline-none whitespace-nowrap">
                        Activité
                    </button>
                    <button data-target="titres" class="nav-button px-4 py-3 text-sm md:text-base text-gray-700 transition-colors duration-300 hover:text-brand-500 focus:outline-none whitespace-nowrap">
                        Titres
                    </button>
                    <button data-target="personnes" class="nav-button px-4 py-3 text-sm md:text-base text-gray-700 transition-colors duration-300 hover:text-brand-500 focus:outline-none whitespace-nowrap">
                        Personnes
                    </button>
                </nav>
            </div>

            <div class="p-6">
                <div id="description" class="profile-section">
                    @include("components.profil.profil_club_admin.description")
                </div>
                <div id="ecole" class="profile-section hidden">
                    @include("components.profil.profil_club_admin.ecole")
                </div>
                <div id="tactique" class="profile-section hidden">
                    @include("components.profil.profil_club_admin.tactique")
                </div>
                <div id="gestion" class="profile-section hidden">
                    @include("components.profil.profil_club_admin.gestion")
                </div>
                <div id="activité" class="profile-section hidden">
                    @include("components.profil.activite")
                </div>
                <div id="titres" class="profile-section hidden">
                    @include("components.profil.profil_club_admin.titre")
                </div>
                <div id="personnes" class="profile-section hidden">
                    @include('components.profil.profil_club_admin.personne', [
                            'user' => $user,
                            'invitations' => $invitations ?? collect(),
                            'clubMembers' => $clubMembers ?? collect(),
                            'availableJoueurs' => $availableJoueurs ?? collect()
                        ])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navButtons = document.querySelectorAll('.nav-button');
            const profileSections = document.querySelectorAll('.profile-section');

            if (navButtons.length > 0) {
                navButtons[0].classList.add('text-brand-500', 'font-bold', 'nav-active');
            }

            navButtons.forEach(button => {
                button.addEventListener('click', () => {
                    navButtons.forEach(btn => {
                        btn.classList.remove('text-brand-500', 'font-bold', 'nav-active');
                        btn.classList.add('text-gray-700');
                    });

                    button.classList.remove('text-gray-700');
                    button.classList.add('text-brand-500', 'font-bold', 'nav-active');

                    profileSections.forEach(section => {
                        section.classList.add('hidden');
                    });

                    const targetSectionId = button.getAttribute('data-target');
                    const targetSection = document.getElementById(targetSectionId);
                    targetSection.classList.remove('hidden');

                    targetSection.classList.add('animate-fade-in');
                    setTimeout(() => {
                        targetSection.classList.remove('animate-fade-in');
                    }, 300);
                });
            });
        });

        function openModal(model) {
            document.getElementById(model).classList.remove('hidden');
        }

        function closeModal(model) {
            document.getElementById(model).classList.add('hidden');
        }
    </script>
@endpush
