import React, { useState, useEffect, useRef } from 'react';
import { motion } from 'framer-motion';
import { AnimatePresence } from 'framer-motion';

const FootballAnimation = () => {
  const [footballs, setFootballs] = useState([]);
  const containerRef = useRef(null);

  const createFootball = () => {
    const newFootball = {
      id: Date.now(),
      x: Math.random() * window.innerWidth,
      y: -50,
      rotation: Math.random() * 360
    };
    setFootballs(prev => [...prev, newFootball]);
  };

  useEffect(() => {
    const footballInterval = setInterval(createFootball, 500);
    const burstInterval = setInterval(() => {
      for (let i = 0; i < 5; i++) {
        createFootball();
      }
    }, 3000);

    // Initial burst
    for (let i = 0; i < 10; i++) {
      setTimeout(createFootball, i * 200);
    }

    return () => {
      clearInterval(footballInterval);
      clearInterval(burstInterval);
    };
  }, []);

  return (
    <div 
      ref={containerRef} 
      style={{
        position: 'fixed',
        top: 0,
        left: 0,
        width: '100%',
        height: '100%',
        zIndex: 0,
        pointerEvents: 'none',
        overflow: 'hidden'
      }}
    >
      {footballs.map((ball) => (
        <motion.div
          key={ball.id}
          initial={{ 
            y: ball.y, 
            x: ball.x,
            rotate: ball.rotation 
          }}
          animate={{
            y: window.innerHeight,
            rotate: ball.rotation + 360
          }}
          transition={{
            duration: 5,
            ease: "easeInOut"
          }}
          style={{
            position: 'absolute',
            width: '80px',
            height: '80px',
            backgroundImage: 'url(/path/to/football-image.png)',
            backgroundSize: 'contain',
            backgroundRepeat: 'no-repeat'
          }}
          onAnimationComplete={() => {
            setFootballs(prev => prev.filter(f => f.id !== ball.id));
          }}
        />
      ))}
    </div>
  );
};

const GoalFlash = ({ show, onComplete }) => {
  return (
    <AnimatePresence>
      {show && (
        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          exit={{ opacity: 0 }}
          style={{
            position: 'fixed',
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',
            backgroundColor: 'rgba(255, 255, 255, 0.8)',
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            zIndex: 100
          }}
        >
          <motion.div
            initial={{ scale: 0 }}
            animate={{ scale: 1 }}
            transition={{ duration: 0.5 }}
            style={{
              fontSize: '5rem',
              fontWeight: 'bold',
              color: '#3910b4',
              textShadow: '2px 2px 4px rgba(0, 0, 0, 0.5)'
            }}
          >
            BUUUUT !!!
          </motion.div>
        </motion.div>
      )}
    </AnimatePresence>
  );
};

function Login() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [rememberMe, setRememberMe] = useState(false);
  const [showGoal, setShowGoal] = useState(false);

  const handleSubmit = (e) => {
    e.preventDefault();
    
    setShowGoal(true);
    setTimeout(() => setShowGoal(false), 2500);

    console.log('Login attempt', { username, password, rememberMe });
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
      {/* Football Background Animation */}
      <FootballAnimation />

      {/* Goal Flash */}
      <GoalFlash show={showGoal} />

      <div className="max-w-md w-full z-10 relative">
        <div className="bg-white bg-opacity-90 rounded-xl shadow-xl overflow-hidden">
          {/* Header */}
          <div className="bg-blue-900 p-4 text-center">
            <div className="flex justify-center mb-2">
              <img 
                className="w-16 h-16" 
                src="/path/to/logo.png" 
                alt="GooLink Logo" 
              />
            </div>
            <h1 className="text-2xl font-bold text-white">GooLink</h1>
          </div>

          {/* Login Form */}
          <form onSubmit={handleSubmit} className="p-8">
            <h2 className="text-xl font-bold text-center text-gray-800 mb-8">
              Connexion
            </h2>
            
            <div className="space-y-6">
              {/* Username Input */}
              <div>
                <label 
                  className="block text-gray-700 text-sm font-bold mb-2" 
                  htmlFor="username"
                >
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
                    placeholder="Entrez votre nom d'utilisateur"
                    value={username}
                    onChange={(e) => setUsername(e.target.value)}
                    required
                  />
                </div>
              </div>
              
              {/* Password Input */}
              <div>
                <label 
                  className="block text-gray-700 text-sm font-bold mb-2" 
                  htmlFor="password"
                >
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
                    placeholder="Entrez votre mot de passe"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                  />
                </div>
              </div>
              
              {/* Remember Me & Forgot Password */}
              <div className="flex items-center justify-between">
                <div className="flex items-center">
                  <input
                    id="remember"
                    type="checkbox"
                    className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    checked={rememberMe}
                    onChange={(e) => setRememberMe(e.target.checked)}
                  />
                  <label 
                    htmlFor="remember" 
                    className="ml-2 block text-sm text-gray-700"
                  >
                    Se souvenir de moi
                  </label>
                </div>
                <a 
                  href="#" 
                  className="text-sm text-blue-600 hover:text-blue-900"
                >
                  Mot de passe oublié?
                </a>
              </div>
              
              {/* Login Button */}
              <div>
                <button
                  type="submit"
                  className="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"
                >
                  CONNEXION
                </button>
              </div>
              
              {/* Sign Up Link */}
              <div className="flex items-center justify-between pt-4 border-t border-gray-300">
                <span className="text-sm text-gray-600">
                  Pas encore de compte?
                </span>
                <a 
                  href="#" 
                  className="text-sm font-medium text-blue-600 hover:text-blue-900"
                >
                  S'inscrire
                </a>
              </div>
            </div>
          </form>
          
          {/* Social Links */}
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
}

export default Login;