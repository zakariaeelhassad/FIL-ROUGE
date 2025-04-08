import React from "react";

const FilterButtons = () => {
    return (
        <div className="flex justify-center mb-6">
            <div className="bg-white border-2 border-blue-400 rounded-full p-1 w-full max-w-xl flex justify-between">
                <button className="px-6 py-2 rounded-full bg-white text-gray-800 hover:bg-gray-100 focus:outline-none">
                    Toutes
                </button>
                <button className="px-6 py-2 rounded-full bg-white text-gray-800 hover:bg-gray-100 focus:outline-none">
                    Mes Posts
                </button>
                <button className="px-6 py-2 rounded-full bg-white text-gray-800 hover:bg-gray-100 focus:outline-none">
                    Offres
                </button>
            </div>
        </div>
    );
};

export default FilterButtons;
