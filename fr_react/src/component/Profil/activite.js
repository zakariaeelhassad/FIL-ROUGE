import React from 'react';

const ActiviteSection = ({ openModal }) => {
    return (
        <div className=" mt-4 border-2 border-blue-400 rounded-xl p-4">
            {/* En-tête de la section */}
            <div className="flex justify-between items-center mb-4">
                <h2 className="font-bold text-lg">Activité</h2>
                <button
                    onClick={openModal}
                    className="px-3 py-1 border border-blue-500 text-blue-500 rounded-full text-sm"
                >
                    Créer un post
                </button>
            </div>

            {/* Premier post */}
            <div className="border border-blue-300 rounded-xl p-3 mb-4">
                {/* En-tête du post */}
                <div className="flex items-center mb-2">
                    <div className="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white">
                        <span>A</span>
                    </div>
                    <div className="ml-2">
                        <p className="text-xs text-blue-500">Dernier match</p>
                        <p className="text-xs text-gray-400">il y a 3 jours</p>
                    </div>
                </div>

                {/* Contenu du post */}
                <p className="text-sm text-gray-700 mb-3">
                    nefjhf rehrr fcfblehrfbf bjrejhbe n jkerf rejkbfrjrb jbrekjbfr jbrekjb
                    jbkrkjbfe rejfbkjef jb khlob jbkjbk jbkjbk jb bkjbj jbkjb jbkjbk bjbjbk
                    jbkvje vkbfvi aebkjbfaek ebfbez bezjkjbfz bzekbfz bezfze vjkbvf.
                </p>

                {/* Image du post */}
                <img src="" alt="ZH Logo" className="w-full rounded-lg mb-3" />

                {/* Boutons d'action */}
                <div className="flex space-x-2">
                    <button className="flex-1 flex items-center justify-center bg-gray-200 rounded-full py-1">
                        <span className="text-gray-500">👍</span>
                    </button>
                    <button className="flex-1 flex items-center justify-center bg-gray-200 rounded-full py-1">
                        <span className="text-gray-500">💬</span>
                    </button>
                    <button className="flex-1 flex items-center justify-center bg-gray-200 rounded-full py-1">
                        <span className="text-gray-500">🔄</span>
                    </button>
                </div>
            </div>

            {/* Deuxième post */}
            <div className="border border-blue-300 rounded-xl p-3 mb-4">
                {/* En-tête du post */}
                <div className="flex items-center mb-2">
                    <div className="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white">
                        <span>A</span>
                    </div>
                    <div className="ml-2">
                        <p className="text-xs text-blue-500">Dernier match</p>
                        <p className="text-xs text-gray-400">il y a 5 jours</p>
                    </div>
                </div>

                {/* Contenu du post */}
                <p className="text-sm text-gray-700 mb-3">
                    nefjhf rehrr fcfblehrfbf bjrejhbe n jkerf rejkbfrjrb jbrekjbfr jbrekjb
                    jbkrkjbfe rejfbkjef jb khlob jbkjbk jbkjbk jb bkjbj jbkjb jbkjbk bjbjbk
                    jbkvje vkbfvi aebkjbfaek ebfbez bezjkjbfz bzekbfz bezfze vjkbvf.
                </p>

                {/* Images du post */}
                <div className="grid grid-cols-2 gap-2 mb-3">
                    <img src="./champe.jpg" alt="ZH Logo 1" className="w-full rounded-lg" />
                    <img src="./champe.jpg" alt="ZH Logo 2" className="w-full rounded-lg" />
                </div>

                {/* Boutons d'action */}
                <div className="flex space-x-2">
                    <button className="flex-1 flex items-center justify-center bg-gray-200 rounded-full py-1">
                        <span className="text-gray-500">👍</span>
                    </button>
                    <button className="flex-1 flex items-center justify-center bg-gray-200 rounded-full py-1">
                        <span className="text-gray-500">💬</span>
                    </button>
                    <button className="flex-1 flex items-center justify-center bg-gray-200 rounded-full py-1">
                        <span className="text-gray-500">🔄</span>
                    </button>
                </div>
            </div>

            {/* Bouton pour afficher plus de posts */}
            <button className="w-full py-2 text-center text-gray-700 hover:bg-gray-100 rounded">
                Afficher tous les posts
            </button>
        </div>
    );
};

export default ActiviteSection;
