import React, { useEffect, useState } from "react";
import axios from '../../axiosConfig';

const PeopleList = () => {
    const [people, setPeople] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.get("/users")
            .then((response) => {
                if (Array.isArray(response.data.data)) {
                    setPeople(response.data.data);
                } else {
                    console.error("Les données reçues ne sont pas un tableau.");
                }
                setLoading(false);
            })
            .catch((error) => {
                console.error("Error fetching users:", error);
                setLoading(false);
            });
    }, []);

    return (
        <div className="bg-white rounded-2xl border border-blue-200 p-5">
            <h2 className="text-blue-900 font-bold text-lg mb-4">Personnes que vous connaissez</h2>
            {loading ? (
                <p>Chargement...</p>
            ) : (
                <div className="grid grid-cols-3 gap-4">
                    {Array.isArray(people) && people.length > 0 ? (
                        people.map((person) => (
                            <div key={person.id} className="rounded-xl overflow-hidden border border-blue-200 h-48">
                                <div className="bg-indigo-900 pt-4 pb-2 px-2 relative">
                                    <div className="w-12 h-12 mx-auto bg-blue-500 rounded-full overflow-hidden mb-1">
                                        <img src={person.image || "https://placehold.co/100x100"} alt="Photo de profil" className="w-full h-full object-cover" />
                                    </div>
                                </div>
                                <div className="bg-white p-2 text-center">
                                    <p className="text-blue-600 font-semibold text-xs">{person.full_name}</p>
                                    <p className="text-gray-400 text-xs mb-8">{person.role}</p>
                                    <button className="bg-white border border-blue-200 text-blue-600 px-3 py-1 rounded-full text-xs hover:bg-blue-50 w-full">
                                        Se connecter
                                    </button>
                                </div>
                            </div>
                        ))
                    ) : (
                        <p>Aucune personne trouvée.</p>
                    )}
                </div>
            )}
        </div>
    );
};

export default PeopleList;
