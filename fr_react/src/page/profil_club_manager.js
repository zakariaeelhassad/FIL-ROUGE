import { useState } from "react";
import Carte_profil from "../component/Profil/carte_profil_principale";
import SocialMedia from "../component/Profil/social_media";
import PerformanceStats from "../component/Profil/performance_stats";
import TactiqueSection from "../component/Profil/attribu_profil_club_admin/tactique";
import GestionSection from "../component/Profil/attribu_profil_club_admin/gestion";
import TitreSection from "../component/Profil/attribu_profil_club_admin/titre";
import ActiviteSection from "../component/Profil/activite";
import DescriptionSection from "../component/Profil/attribu_profil_club_admin/description";
import Navbar from "../component/Profil/attribu_profil_joueur/navbar";
import EcoleSection from "../component/Profil/attribu_profil_club_admin/ecole";
import CreatePostButton from "../component/les_model/createPostButton";


function Profil_club_manager() {
    const [activeSection, setActiveSection] = useState("description");
    const [isModalOpen, setIsModalOpen] = useState(false);

    const openModal = () => {
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setIsModalOpen(false);
    };

    return (
        <>
            <div className="max-w-2xl mx-auto p-4">
                <Carte_profil />
                <div className="flex space-x-4 mt-4">
                    <SocialMedia />
                    <PerformanceStats />
                </div>
                <Navbar activeSection={activeSection} setActiveSection={setActiveSection} />

                {/* Affichage dynamique de la section sélectionnée */}
                {activeSection === "description" && <DescriptionSection />}
                {activeSection === "ecole" && <EcoleSection />}
                {activeSection === "tactique" && <TactiqueSection />}
                {activeSection === "gestion" && <GestionSection />}
                {activeSection === "titres" && <TitreSection />}
                {activeSection === "activite" && <ActiviteSection openModal={openModal} />}
            </div>

            {/* Modal Component */}
            {isModalOpen && <CreatePostButton openModal={isModalOpen} />}
        </>
    );
}

export default Profil_club_manager;
