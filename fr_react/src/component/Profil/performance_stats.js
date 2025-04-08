import React from 'react';

const PerformanceStats = () => {
    return (
        <div className="flex-1 border-2 border-blue-500 rounded-xl p-4">
            <div className="flex justify-between items-center mb-3">
                <h2 className="font-bold">Performance Stats</h2>
                <button className="px-3 py-1 border border-blue-500 text-blue-500 rounded-full text-sm">edit</button>
            </div>
            <div className="flex space-x-3 justify-center">
                <div className="text-center">
                    <div className="rounded-full bg-gray-200 p-2 w-14 h-14 flex items-center justify-center">
                        <span className="font-bold">245</span>
                    </div>
                    <span className="text-xs">activité</span>
                </div>
                <div className="text-center">
                    <div className="rounded-full bg-gray-200 p-2 w-14 h-14 flex items-center justify-center">
                        <span className="font-bold">87</span>
                    </div>
                    <span className="text-xs">expérience</span>
                </div>
                <div className="text-center">
                    <div className="rounded-full bg-gray-200 p-2 w-14 h-14 flex items-center justify-center">
                        <span className="font-bold">112</span>
                    </div>
                    <span className="text-xs">certif</span>
                </div>
            </div>
        </div>
    );
};

export default PerformanceStats;
