  import React, { useState } from 'react';
  import axios from 'axios';
  import { useNavigate } from 'react-router-dom';

  const Signup = () => {
    const [fullName, setFullName] = useState('');
    const [username, setUsername] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');
    const [role, setRole] = useState('joueur');
    const [errors, setErrors] = useState({});
    const [serverError, setServerError] = useState('');

    const navigate = useNavigate();

    const handleSubmit = async (e) => {
      e.preventDefault();
      setErrors({});
      setServerError('');

      const validationErrors = {};
      if (password !== passwordConfirmation) {
        validationErrors.passwordConfirmation = 'Les mots de passe ne correspondent pas';
      }

      if (Object.keys(validationErrors).length > 0) {
        setErrors(validationErrors);
        return;
      }

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/users', {
            full_name: fullName,
            username,
            email,
            password,
            password_confirmation: passwordConfirmation,
            role
        });
    
        if (response.data.status === 'success') {
            document.cookie = `auth_token=${response.data.token.plainTextToken}; path=/; SameSite=Strict`;
            localStorage.setItem('user', JSON.stringify(response.data.data));
    
            navigate('/');
        } else {
            setServerError(response.data.message || 'Une erreur est survenue');
        }
        } catch (err) {
            if (err.response?.data?.errors) {
                const serverValidationErrors = {};
                Object.keys(err.response.data.errors).forEach(key => {
                    serverValidationErrors[key] = err.response.data.errors[key][0];
                });
                setErrors(serverValidationErrors);
            } else {
              console.error('Response Data:', err.response?.data);
                setServerError(err.response?.data?.message || 'Une erreur est survenue lors de l\'inscription');
            }
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

            {/* Signup Form */}
            <form onSubmit={handleSubmit} className="p-8">
              <h2 className="text-xl font-bold text-center text-gray-800 mb-8">
                Inscription
              </h2>
              
              {/* Server-wide error message */}
              {serverError && (
                <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                  {serverError}
                </div>
              )}

              <div className="space-y-6">
                {/* Full Name Input */}
                <div>
                  <label 
                    className="block text-gray-700 text-sm font-bold mb-2" 
                    htmlFor="full_name"
                  >
                    Nom complet
                  </label>
                  <input
                    className={`w-full pl-3 py-2 rounded-lg border ${errors.full_name ? 'border-red-500' : 'border-gray-300'} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500`}
                    id="full_name"
                    type="text"
                    placeholder="Entrez votre nom complet"
                    value={fullName}
                    onChange={(e) => setFullName(e.target.value)}
                    required
                  />
                  {errors.full_name && (
                    <p className="text-red-500 text-xs italic">{errors.full_name}</p>
                  )}
                </div>

                {/* Username Input */}
                <div>
                  <label 
                    className="block text-gray-700 text-sm font-bold mb-2" 
                    htmlFor="username"
                  >
                    Nom d'utilisateur
                  </label>
                  <input
                    className={`w-full pl-3 py-2 rounded-lg border ${errors.username ? 'border-red-500' : 'border-gray-300'} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500`}
                    id="username"
                    type="text"
                    placeholder="Entrez votre nom d'utilisateur"
                    value={username}
                    onChange={(e) => setUsername(e.target.value)}
                    required
                  />
                  {errors.username && (
                    <p className="text-red-500 text-xs italic">{errors.username}</p>
                  )}
                </div>

                {/* Email Input */}
                <div>
                  <label 
                    className="block text-gray-700 text-sm font-bold mb-2" 
                    htmlFor="email"
                  >
                    Email
                  </label>
                  <input
                    className={`w-full pl-3 py-2 rounded-lg border ${errors.email ? 'border-red-500' : 'border-gray-300'} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500`}
                    id="email"
                    type="email"
                    placeholder="Entrez votre email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                  />
                  {errors.email && (
                    <p className="text-red-500 text-xs italic">{errors.email}</p>
                  )}
                </div>

                {/* Password Input */}
                <div>
                  <label 
                    className="block text-gray-700 text-sm font-bold mb-2" 
                    htmlFor="password"
                  >
                    Mot de passe
                  </label>
                  <input
                    className={`w-full pl-3 py-2 rounded-lg border ${errors.password ? 'border-red-500' : 'border-gray-300'} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500`}
                    id="password"
                    type="password"
                    placeholder="Entrez votre mot de passe"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                  />
                  {errors.password && (
                    <p className="text-red-500 text-xs italic">{errors.password}</p>
                  )}
                </div>

                {/* Confirm Password Input */}
                <div>
                  <label 
                    className="block text-gray-700 text-sm font-bold mb-2" 
                    htmlFor="password_confirmation"
                  >
                    Confirmer le mot de passe
                  </label>
                  <input
                    className={`w-full pl-3 py-2 rounded-lg border ${errors.passwordConfirmation ? 'border-red-500' : 'border-gray-300'} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500`}
                    id="password_confirmation"
                    type="password"
                    placeholder="Confirmez votre mot de passe"
                    value={passwordConfirmation}
                    onChange={(e) => setPasswordConfirmation(e.target.value)}
                    required
                  />
                  {errors.passwordConfirmation && (
                    <p className="text-red-500 text-xs italic">{errors.passwordConfirmation}</p>
                  )}
                </div>

                {/* Role Selection */}
                <div>
                  <label 
                    className="block text-gray-700 text-sm font-bold mb-2" 
                    htmlFor="role"
                  >
                    Rôle
                  </label>
                  <select
                    className={`w-full pl-3 py-2 rounded-lg border ${errors.role ? 'border-red-500' : 'border-gray-300'} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500`}
                    id="role"
                    value={role}
                    onChange={(e) => setRole(e.target.value)}
                    required
                  >
                    <option value="joueur">Joueur</option>
                    <option value="club_admin">Club Admin</option>
                    <option value="manager">Manager</option>
                  </select>
                  {errors.role && (
                    <p className="text-red-500 text-xs italic">{errors.role}</p>
                  )}
                </div>

                {/* Signup Button */}
                <div>
                  <button
                    type="submit"
                    className="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"
                  >
                    S'INSCRIRE
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    );
  };

  export default Signup;