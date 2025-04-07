import React from "react";

const TitreSection = () => {
    return (
        <div className=" mt-4 border-2 border-blue-400 rounded-3xl p-6">
            {/* En-tête */}
            <div className="flex justify-between items-center mb-6">
                <h2 className="text-2xl font-bold text-indigo-900">Titres wa Achievements:</h2>
                <button className="px-4 py-2 border border-blue-500 text-blue-600 rounded-full hover:bg-blue-50">
                    Ajouter une expérience
                </button>
            </div>

            {/* Premier trophée - Champions League */}
            <div className="flex items-start mb-6 pb-6 border-b border-gray-200">
                <div className="w-24 h-24 flex-shrink-0">
                    <img
                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/47/Champions_League_trophy.svg/1200px-Champions_League_trophy.svg.png"
                        alt="Champions League Trophy"
                        className="h-full object-contain"
                    />
                </div>
                <div className="flex-grow px-4">
                    <h3 className="text-xl font-bold mb-1">Champions League</h3>
                    <p className="text-gray-700">Description du trophée de la Champions League.</p>
                </div>
                <div className="text-6xl font-bold text-blue-600 flex-shrink-0 w-24 text-right">15</div>
            </div>

            {/* Deuxième trophée - Liga Espagnole */}
            <div className="flex items-start mb-6">
                <div className="w-24 h-24 flex-shrink-0">
                    <img
                        src="https://www.laliga.com/-/media/laliga/laliga-ea-sports/trofeo/trofeo-laliga-ea-sports.png?h=500&iar=0&w=436"
                        alt="Liga Trophy"
                        className="h-full object-contain"
                    />
                </div>
                <div className="flex-grow px-4">
                    <h3 className="text-xl font-bold mb-1">Liga Espagnole</h3>
                    <p className="text-gray-700">Description du trophée de la Liga Espagnole.</p>
                </div>
                <div className="text-6xl font-bold text-blue-600 flex-shrink-0 w-24 text-right">35</div>
            </div>

            {/* Bouton pour tout afficher */}
            <div className="mt-4 text-center">
                <button className="w-full py-3 text-gray-800 hover:bg-gray-100 rounded-md border-t border-gray-200">
                    Afficher tous les posts
                </button>
            </div>
        </div>
    );
};

export default TitreSection;
