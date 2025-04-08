import { Routes, Route, useLocation } from 'react-router-dom';
import Home from "./page/home";
import Reseau from "./page/reseau";
import Login from './page/login';
import Signup from './page/signup';
import Navbar from './component/navbar';
import Profil_club_manager from './page/profil_club_manager';
import Profil_joueur from './page/profil_joueur';
import Notification from './page/notification';

function App() {
    const location = useLocation();

    const showNavbarPaths = [
        "/home",
        "/profil_club",
        "/profil_joueur",
        "/reseau",
        "/notification"
    ];

    const showNavbar = showNavbarPaths.includes(location.pathname);

    return (
        <>
            {showNavbar && <Navbar />}
            <Routes>
                <Route path="/home" element={<Home />} />
                <Route path="/profil_club" element={<Profil_club_manager />} />
                <Route path="/profil_joueur" element={<Profil_joueur />} />
                <Route path="/reseau" element={<Reseau />} />
                <Route path="/notification" element={<Notification />} />
                <Route path="/" element={<Login />} />
                <Route path="/signup" element={<Signup />} />
            </Routes>
        </>
    );
}

export default App;

