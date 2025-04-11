<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    @include('components.navbar')
    <div class="max-w-2xl mx-auto p-4">
        @include("components.profil.carte_profil_prancipal")
        <div class="flex space-x-4 mt-4">
            @include("components.profil.social_media")
            @include("components.profil.performance_stats")
        </div>
        <div class="p-3">
            <div class="mt-4 border-b-2 border-blue-500">
                <nav class="flex space-x-6 text-center">
                    <button data-target="description" class="nav-button pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('description')">
                        Description
                    </button>
                    <button data-target="ecole" class="nav-button pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('ecole')">
                        Ecole
                    </button>
                    <button data-target="tactique" class="nav-button pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('tactique')">
                        Tactique
                    </button>
                    <button data-target="gestion" class="nav-button pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('gestion')">
                        Gestion
                    </button>
                    <button data-target="activité" class="nav-button pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('activite')">
                        Activité
                    </button>
                    <button data-target="titres" class="nav-button pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('titres')">
                        Titres
                    </button>
                </nav>
            </div>
            <div class="p-4">
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
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navButtons = document.querySelectorAll('.nav-button');
            const profileSections = document.querySelectorAll('.profile-section');

            navButtons.forEach(button => {
                button.addEventListener('click', () => {
                    navButtons.forEach(btn => {
                        btn.classList.remove('text-blue-500', 'font-bold', 'nav-active');
                        btn.classList.add('text-gray-700');
                    });

                    button.classList.remove('text-gray-700');
                    button.classList.add('text-blue-500', 'font-bold', 'nav-active');

                    profileSections.forEach(section => {
                        section.classList.add('hidden');
                    });

                    const targetSectionId = button.getAttribute('data-target');
                    const targetSection = document.getElementById(targetSectionId);
                    targetSection.classList.remove('hidden');
                });
            });
        });
    </script>
</body>
</html>