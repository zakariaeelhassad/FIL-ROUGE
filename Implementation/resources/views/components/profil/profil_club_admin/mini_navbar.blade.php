<div class="mt-4 border-b-2 border-blue-500">
    <nav class="flex space-x-6 text-center">
        <button id="description" class="pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('description')">
            Description
        </button>
        <button id="ecole" class="pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('ecole')">
            Ecole
        </button>
        <button id="tactique" class="pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('tactique')">
            Tactique
        </button>
        <button id="gestion" class="pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('gestion')">
            Gestion
        </button>
        <button id="activite" class="pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('activite')">
            Activité
        </button>
        <button id="titres" class="pb-2 text-gray-700 transition-colors duration-300 hover:text-blue-500" onclick="setActiveSection('titres')">
            Titres
        </button>
    </nav>
</div>

<script>
    // Function to set the active section
    function setActiveSection(section) {
        // Remove active class from all buttons
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            button.classList.remove('border-b-2', 'border-blue-500', 'text-blue-500', 'font-medium');
        });

        // Add active class to the clicked button
        const activeButton = document.getElementById(section);
        activeButton.classList.add('border-b-2', 'border-blue-500', 'text-blue-500', 'font-medium');
    }
</script>
