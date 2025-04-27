@extends('layouts.app', ['title' => 'profil'])

@section('content')
    
    <div class="max-w-4xl mx-auto px-4 py-8">
        @include("components.profil.carte_profil_prancipal")
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="md:col-span-1">
                @include("components.profil.social_media")
            </div>
            <div class="md:col-span-2">
                @include("components.profil.profil_joueur.performance_stats")
            </div>
        </div>
        
        <div class="mt-8 bg-white rounded-2xl shadow-soft">
            <div class="border-b border-gray-100">
                <nav class="flex" id="profile-nav">
                    <button data-target="activite" class="nav-button px-6 py-4 text-gray-700 transition-colors duration-300 hover:text-brand-500 focus:outline-none whitespace-nowrap">
                        Activité
                    </button>
                    <button data-target="experience" class="nav-button px-6 py-4 text-gray-700 transition-colors duration-300 hover:text-brand-500 focus:outline-none whitespace-nowrap">
                        Expérience
                    </button>
                    <button data-target="certification" class="nav-button px-6 py-4 text-gray-700 transition-colors duration-300 hover:text-brand-500 focus:outline-none whitespace-nowrap">
                        Certifications
                    </button>
                </nav>
            </div>
            
            <div class="p-6">
                <div id="activite" class="profile-section">
                    @include("components.profil.activite")
                </div>
                <div id="experience" class="profile-section hidden">
                    @include("components.profil.profil_joueur.experience")
                </div>
                <div id="certification" class="profile-section hidden">
                    @include("components.profil.profil_joueur.certification")
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
            document.body.style.overflow = 'hidden'; 
        }

        function closeModal(model) {
            document.getElementById(model).classList.add('hidden');
            document.body.style.overflow = ''; 
        }
    </script>
    @endpush
