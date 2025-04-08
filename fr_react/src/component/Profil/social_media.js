import React from 'react';

const SocialMedia = () => {
    return (
        <div className="flex-1 border-2 border-blue-500 rounded-xl p-4">
            <div className="flex justify-between items-center mb-3">
                <h2 className="font-bold">Social Media</h2>
                <button className="px-3 py-1 border border-blue-500 text-blue-500 rounded-full text-sm">edit</button>
            </div>
            <div className="flex space-x-2">
                <div className="rounded-full bg-white p-2 w-10 h-10 flex items-center justify-center">
                    <span className="text-red-500 font-bold">G</span>
                </div>
                <div className="rounded-full bg-blue-500 p-2 w-10 h-10 flex items-center justify-center">
                    <span className="text-white font-bold">T</span>
                </div>
            </div>
        </div>
    );
};

export default SocialMedia;
