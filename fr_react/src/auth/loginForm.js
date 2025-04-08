// components/auth/LoginForm.js
import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import GoalFlash from '../component/les_model/goalFlash';
import FootballAnimation from '../component/les_model/footballAnimation';

const LoginForm = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [rememberMe, setRememberMe] = useState(false);
  const [showGoal, setShowGoal] = useState(false);
  const [error, setError] = useState('');
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/login', {
        username,
        password
      });

      localStorage.setItem('user', JSON.stringify(response.data.user));
      localStorage.setItem('token', response.data.token);

      setShowGoal(true);
      
      setTimeout(() => {
        setShowGoal(false);
        
        switch(response.data.user.role) {
          case 'admin':
            navigate('/home');
            break;
          case 'joueur':
            navigate('/home');
            break;
          case 'club_admin':
            navigate('/reseau');
            break;
          default:
            navigate('/notification');
        }
      }, 2500);

    } catch (err) {
      setError(
        err.response?.data?.message || 
        'فشل تسجيل الدخول. يرجى التحقق من بيانات الاعتماد.'
      );
      console.error('Login failed:', err);
    }
  };

  return (
    <div 
      className="min-h-screen flex items-center justify-center p-4 relative"
      style={{
        backgroundImage: 'url(/path/to/stadium-bg.jpg)',
        backgroundSize: 'cover',
        backgroundPosition: 'center'
      }}
    >
      <FootballAnimation />
      <GoalFlash show={showGoal} />

      <div className="max-w-md w-full z-10 relative">
        <div className="bg-white bg-opacity-90 rounded-xl shadow-xl overflow-hidden">
          <div className="bg-blue-900 p-4 text-center">
            <div className="flex justify-center mb-2">
              <img className="w-16 h-16" src="/path/to/logo.png" alt="GooLink Logo" />
            </div>
            <h1 className="text-2xl font-bold text-white">GooLink</h1>
          </div>

          <form onSubmit={handleSubmit} className="p-8">
            <h2 className="text-xl font-bold text-center text-gray-800 mb-8">Connexion</h2>
            
            {/* رسالة الخطأ */}
            {error && (
              <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {error}
              </div>
            )}

            <div className="space-y-6">
              <div>
                <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="username">
                  Nom d'utilisateur
                </label>
                <div className="relative">
                  <div className="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i className="fas fa-user text-gray-500"></i>
                  </div>
                  <input
                    className="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    id="username"
                    type="text"
                    value={username}
                    onChange={(e) => setUsername(e.target.value)}
                    required
                  />
                </div>
              </div>

              <div>
                <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="password">
                  Mot de passe
                </label>
                <div className="relative">
                  <div className="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i className="fas fa-lock text-gray-500"></i>
                  </div>
                  <input
                    className="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    id="password"
                    type="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                  />
                </div>
              </div>

              <div className="flex items-center justify-between">
                <div className="flex items-center">
                  <input
                    id="remember"
                    type="checkbox"
                    className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    checked={rememberMe}
                    onChange={(e) => setRememberMe(e.target.checked)}
                  />
                  <label htmlFor="remember" className="ml-2 block text-sm text-gray-700">
                    Se souvenir de moi
                  </label>
                </div>
                <a href="#" className="text-sm text-blue-600 hover:text-blue-900">
                  Mot de passe oublié?
                </a>
              </div>

              <div>
                <button
                  type="submit"
                  className="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"
                >
                  CONNEXION
                </button>
              </div>

              <div className="flex items-center justify-between pt-4 border-t border-gray-300">
                <span className="text-sm text-gray-600">Pas encore de compte?</span>
                <a href="/register" className="text-sm font-medium text-blue-600 hover:text-blue-900">
                  S'inscrire
                </a>
              </div>
            </div>
          </form>

          <div className="bg-gray-100 py-4 text-center">
            <p className="text-sm text-gray-600">
              Rejoignez notre communauté de <span className="font-bold">100,000+</span> fans de football
            </p>
            <div className="flex justify-center space-x-4 mt-2">
              <a href="#" className="text-gray-600 hover:text-blue-600">
                <i className="fab fa-facebook fa-lg"></i>
              </a>
              <a href="#" className="text-gray-600 hover:text-blue-600">
                <i className="fab fa-twitter fa-lg"></i>
              </a>
              <a href="#" className="text-gray-600 hover:text-blue-600">
                <i className="fab fa-instagram fa-lg"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default LoginForm;