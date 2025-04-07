import { useState } from "react";
import Carte_profil from "./carte_profil_principale";
import SocialMedia from "./socialMedia";
import PerformanceStats from "./performanceStats";
import Navbar from "./attribu_profil_joueur/navbar";
import ActiviteSection from "./activite";
import ExperienceSection from "./attribu_profil_joueur/experience";
import CertificationSection from "./attribu_profil_joueur/certifications";

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