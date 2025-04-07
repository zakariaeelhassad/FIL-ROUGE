import React from 'react';

const ExperienceSection = () => {
    return (
        <div className=" mt-4 border-2 border-blue-400 rounded-xl p-6">
            {/* En-tête de la section */}
            <div className="flex justify-between items-center mb-6">
                <h2 className="font-bold text-lg text-blue-600">Expérience</h2>
                <button className="px-3 py-1 border border-blue-500 text-blue-500 rounded-full text-sm">ajouter une expérience</button>
            </div>

            {/* Première expérience */}
            <div className="flex mb-6 pb-4 border-b border-gray-200">
                {/* Logo du Real Madrid */}
                <div className="w-16 h-16 flex-shrink-0">
                    <img src="https://upload.wikimedia.org/wikipedia/en/thumb/5/56/Real_Madrid_CF.svg/1200px-Real_Madrid_CF.svg.png" alt="Real Madrid Logo" className="w-full h-full" />
                </div>

                {/* Informations sur l'expérience */}
                <div className="ml-4">
                    <div className="flex items-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/16/Crown_of_Spain.svg/1200px-Crown_of_Spain.svg.png" alt="Crown" className="w-5 h-5 mr-1" />
                        <h3 className="font-bold text-lg">Real Madrid</h3>
                    </div>
                    <p className="text-gray-700">Temps plein 2009/2017</p>
                    <p className="text-gray-700">Madrid, Espagne</p>
                    <p className="text-gray-700">Sinyor</p>
                </div>
            </div>

            {/* Deuxième expérience */}
            <div className="flex mb-6">
                {/* Logo du Real Madrid */}
                <div className="w-16 h-16 flex-shrink-0">
                    <img src="https://upload.wikimedia.org/wikipedia/en/thumb/5/56/Real_Madrid_CF.svg/1200px-Real_Madrid_CF.svg.png" alt="Real Madrid Logo" className="w-full h-full" />
                </div>

                {/* Informations sur l'expérience */}
                <div className="ml-4">
                    <div className="flex items-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/16/Crown_of_Spain.svg/1200px-Crown_of_Spain.svg.png" alt="Crown" className="w-5 h-5 mr-1" />
                        <h3 className="font-bold text-lg">Real Madrid</h3>
                    </div>
                    <p className="text-gray-700">Temps plein 2009/2017</p>
                    <p className="text-gray-700">Madrid, Espagne</p>
                    <p className="text-gray-700">Sinyor</p>
                </div>
            </div>

            {/* Bouton pour afficher plus d'expériences */}
            <button className="w-full py-3 text-center text-gray-800 hover:bg-gray-100 rounded border-t border-gray-200">
                Afficher tous les Expériences
            </button>
        </div>
    );
};

export default ExperienceSection;
