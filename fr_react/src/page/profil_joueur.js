import { useState } from "react";
import ActiviteSection from "../component/Profil/activite";
import PerformanceStats from "../component/Profil/performance_stats";
import SocialMedia from "../component/Profil/social_media";
import Carte_profil from "../component/Profil/carte_profil_principale";
import Navbar from "../component/Profil/attribu_profil_joueur/navbar";
import ExperienceSection from "../component/Profil/attribu_profil_joueur/experience";
import CertificationSection from "../component/Profil/attribu_profil_joueur/certifications";

function Profil_joueur() {
    const [activeSection, setActiveSection] = useState("activite");

    return (
        <div className="max-w-2xl mx-auto p-4">
            <Carte_profil />
            <div className="flex space-x-4 mt-4">
                <SocialMedia />
                <PerformanceStats />
            </div>
            <Navbar activeSection={activeSection} setActiveSection={setActiveSection} />

            {/* Affichage dynamique de la section sélectionnée */}
            {activeSection === "activite" && <ActiviteSection />}
            {activeSection === "Expérience" && <ExperienceSection />}
            {activeSection === "certifications" && <CertificationSection />}
        </div>
    );
}

export default Profil_joueur;