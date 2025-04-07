import React from "react";

const invitations = [
    {
        id: 1,
        name: "CRISTIANO RONALDO",
        role: "Joueur de Real Madrid",
        image: "https://placehold.co/100x100/3b82f6/ffffff.png?text=CR",
    },
    {
        id: 2,
        name: "CRISTIANO RONALDO",
        role: "Joueur de Real Madrid",
        image: "https://placehold.co/100x100/3b82f6/ffffff.png?text=CR",
    },
    {
        id: 3,
        name: "CRISTIANO RONALDO",
        role: "Joueur de Real Madrid",
        image: "https://placehold.co/100x100/3b82f6/ffffff.png?text=CR",
    },
    {
        id: 4,
        name: "CRISTIANO RONALDO",
        role: "Joueur de Real Madrid",
        image: "https://placehold.co/100x100/3b82f6/ffffff.png?text=CR",
    },
];

const InvitationsList = () => {
    return (
        <div className="bg-white rounded-2xl border border-blue-200 p-5 mb-6">
            <h2 className="text-blue-900 font-bold text-lg mb-4">
                Aucune invitation en attente
            </h2>
            {invitations.map((invite) => (
                <div
                    key={invite.id}
                    className="bg-gray-50 rounded-xl p-3 flex items-center justify-between mb-3"
                >
                    <div className="flex items-center">
                        <div className="w-10 h-10 rounded-full bg-blue-500 flex-shrink-0 overflow-hidden">
                            <img
                                src={invite.image}
                                alt="Photo de profil"
                                className="w-full h-full object-cover"
                            />
                        </div>
                        <div className="ml-3">
                            <p className="text-blue-600 font-semibold text-sm">{invite.name}</p>
                            <p className="text-gray-400 text-xs">{invite.role}</p>
                        </div>
                    </div>
                    <div className="flex space-x-2">
                        <button className="bg-white border border-blue-200 text-blue-600 px-4 py-1 rounded-full text-sm hover:bg-blue-50">
                            Accepter
                        </button>
                        <button className="bg-white border border-blue-200 text-blue-600 px-4 py-1 rounded-full text-sm hover:bg-blue-50">
                            Refuser
                        </button>
                    </div>
                </div>
            ))}
        </div>
    );
};

export default InvitationsList;
