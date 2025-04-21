<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Player Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#e6f0ff',
                            100: '#cce0ff',
                            200: '#99c2ff',
                            300: '#66a3ff',
                            400: '#3385ff',
                            500: '#0066ff',
                            600: '#0052cc',
                            700: '#003d99',
                            800: '#002966',
                            900: '#001433',
                            950: '#0a1445',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 15px rgba(0, 0, 0, 0.05)',
                        'hover': '0 10px 25px rgba(0, 102, 255, 0.15)',
                    },
                }
            }
        }
    </script>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 102, 255, 0.1);
        }
        
        .nav-active {
            position: relative;
        }
        
        .nav-active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #0066ff;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    @include('components.navbar')
    
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
                <nav class="flex overflow-x-auto scrollbar-hide" id="profile-nav">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navButtons = document.querySelectorAll('.nav-button');
            const profileSections = document.querySelectorAll('.profile-section');

            // Set the first tab as active by default
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
                    
                    // Add a subtle animation
                    targetSection.classList.add('animate-fade-in');
                    setTimeout(() => {
                        targetSection.classList.remove('animate-fade-in');
                    }, 300);
                });
            });
        });

        function openModal(model) {
            document.getElementById(model).classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        function closeModal(model) {
            document.getElementById(model).classList.add('hidden');
            document.body.style.overflow = ''; // Enable scrolling
        }
    </script>
</body>
</html>
