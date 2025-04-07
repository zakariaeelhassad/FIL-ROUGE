import { Routes, Route } from 'react-router-dom';
import Home from "./Home/home";
import Profil_club_manager from "./Profil/profil_club_manager";
import Profil_joueur from "./Profil/profil_joueur";
import Reseau from "./reseau/reseau";
import Notification from "./notification/notification";
import Login from './auth/login';
import Signup from './auth/signup';



function App() {
    return (
        <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/profil_club" element={<Profil_club_manager />} />
            <Route path="/profil_joueur" element={<Profil_joueur />} />
            <Route path="/reseau" element={<Reseau />} />
            <Route path="/notification" element={<Notification />} />
            <Route path="/login" element={<Login />} />
            <Route path="/signup" element={<Signup />} />
        </Routes>
    );
}

export default App;

