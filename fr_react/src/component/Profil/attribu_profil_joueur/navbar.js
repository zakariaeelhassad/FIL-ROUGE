import React from 'react';

const Navbar = ({ activeSection, setActiveSection }) => {
    return (
        <div className="mt-4 border-b-2 border-blue-500">
            <nav className="flex space-x-6 text-center">
                {["activite", "Expérience" , "certifications"].map((section) => (
                    <button
                        key={section}
                        onClick={() => setActiveSection(section)}
                        className={`pb-2 text-gray-700 transition-colors duration-300 ${
                            activeSection === section ? "border-b-2 border-blue-500 text-blue-500 font-medium" : ""
                        }`}
                    >
                        {section.charAt(0).toUpperCase() + section.slice(1)}
                    </button>
                ))}
            </nav>
        </div>
    );
};

export default Navbar;