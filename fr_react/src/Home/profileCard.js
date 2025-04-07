import React from "react";

const ProfileCard = () => {
    return (
        <div className="w-70 bg-white rounded-3xl border border-blue-400 shadow-md p-6">
            {/* Header */}
            <div className="bg-navy-900 h-28 relative">
                <div className="absolute left-0 right-0 flex justify-center" style={{ top: "50%" }}>
                    <div className="rounded-full bg-gray-200 p-1 border-2 border-white">
                        <img
                            src="https://placehold.co/100x100"
                            alt="Photo de profil"
                            className="rounded-full w-24 h-24 object-cover"
                        />
                    </div>
                </div>
            </div>

            {/* Contenu */}
            <div className="pt-16 pb-6 px-4 text-center">
                <h2 className="text-blue-500 font-bold text-xl uppercase">CRISTIANO RONALDO</h2>
                <p className="text-gray-400 text-sm mt-1">Professional Soccer Player | Midfielder</p>

                <div className="flex justify-center items-center mt-6 space-x-2">
                    <span className="text-black font-bold text-2xl">10K</span>
                    <span className="text-gray-400">follow</span>
                </div>

                <button className="mt-6 border border-blue-400 text-blue-500 rounded-full px-6 py-2 text-sm uppercase hover:bg-blue-50 transition">
                    VOIR LE PROFIL
                </button>
            </div>
        </div>
    );
};

export default ProfileCard;
