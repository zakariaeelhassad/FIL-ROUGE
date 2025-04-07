import React from 'react';
import '../App.css';
import SocialMedia from "./social_media";
import PerformanceStats from "./performance_stats";

const Carte_profil = () => {
    return (
            <div className="rounded-3xl bg-navy-900 text-white p-4 border-2 border-blue-500">
                {/* Zone vide en haut (pourrait être une bannière) */}
                <div className="rounded-xl bg-white border-2 border-blue-400 h-40 mb-4"></div>

                {/* Section profil */}
                <div className="flex items-center space-x-4">
                    {/* Avatar */}
                    <div className="relative">
                        <div className="w-24 h-24 rounded-full bg-white p-1">
                            <img
                                src="https://upload.wikimedia.org/wikipedia/en/thumb/5/56/Real_Madrid_CF.svg/1200px-Real_Madrid_CF.svg.png"
                                alt="Real Madrid Logo"
                                className="w-full h-full rounded-full object-contain"
                            />
                        </div>
                    </div>

                    {/* Informations */}
                    <div className="flex-1">
                        <h1 className="text-xl font-bold">Alex Rodriguez</h1>
                        <p className="text-gray-300">Professional Soccer Player | Midfielder</p>
                        <div className="flex items-center mt-1">
                            <span className="font-bold text-lg">10K</span>
                            <span className="text-gray-300 ml-1">follow</span>
                        </div>
                        <div className="mt-1">
                            <span className="px-3 py-1 bg-white text-navy-900 text-xs rounded-full">Club</span>
                        </div>
                    </div>
                </div>
            </div>
            );
            };

            export default Carte_profil;
