<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GooLink - Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4">
  <div class="stadium-bg"></div>
  <div id="football-container"></div>
  
  <div class="goal-flash" id="goal-flash">
      <div class="goal-text" id="goal-text">BUUUUT !!!</div>
  </div>
  
  <div class="content-container max-w-md w-full">
      <div class="bg-white bg-opacity-90 rounded-xl shadow-xl overflow-hidden">
          <div class="bg-blue-900 p-4 text-center">
              <div class="flex justify-center mb-2">
                  <img class="w-16 h-16 text-white" src="{{ asset('images/G_1.png') }}" alt="">
              </div>
              <h1 class="text-2xl font-bold text-white">GooLink</h1>
          </div>

          <form action="{{ route('signup.store') }}" method="POST" class="p-8">
            @csrf
            <h2 class="text-xl font-bold text-center text-gray-800 mb-8">Inscription</h2>
          
            @if ($errors->any())
<div id="serverError" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Oops! Quelques problèmes sont survenus :</strong>
    <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
            @if ($errors->any())
            <div id="serverError" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                Une erreur est survenue
            </div>
            @endif
          
            <div class="space-y-6">
              <!-- Full Name Input -->
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">Nom complet</label>
                <input
                  class="w-full pl-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('full_name') border-red-500 @enderror"
                  id="full_name"
                  name="full_name"
                  type="text"
                  value="{{ old('full_name') }}"
                  placeholder="Entrez votre nom complet"
                  required
                />
                <p id="fullNameError" class="text-red-500 text-xs italic @error('full_name') block @else hidden @enderror">
                    @error('full_name'){{ $message }}@else Le nom complet est requis.@enderror
                </p>
              </div>
          
              <!-- Username Input -->
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Nom d'utilisateur</label>
                <input
                  class="w-full pl-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('username') border-red-500 @enderror"
                  id="username"
                  name="username"
                  type="text"
                  value="{{ old('username') }}"
                  placeholder="Entrez votre nom d'utilisateur"
                  required
                />
                <p id="usernameError" class="text-red-500 text-xs italic @error('username') block @else hidden @enderror">
                    @error('username'){{ $message }}@else Le nom d'utilisateur est requis.@enderror
                </p>
              </div>
          
              <!-- Email Input -->
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input
                  class="w-full pl-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                  id="email"
                  name="email"
                  type="email"
                  value="{{ old('email') }}"
                  placeholder="Entrez votre email"
                  required
                />
                <p id="emailError" class="text-red-500 text-xs italic @error('email') block @else hidden @enderror">
                    @error('email'){{ $message }}@else L'email est requis.@enderror
                </p>
              </div>
          
              <!-- Password Input -->
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Mot de passe</label>
                <input
                  class="w-full pl-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                  id="password"
                  name="password"
                  type="password"
                  placeholder="Entrez votre mot de passe"
                  required
                />
                <p id="passwordError" class="text-red-500 text-xs italic @error('password') block @else hidden @enderror">
                    @error('password'){{ $message }}@else Le mot de passe est requis.@enderror
                </p>
              </div>
          
              <!-- Confirm Password Input -->
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Confirmer le mot de passe</label>
                <input
                  class="w-full pl-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                  id="password_confirmation"
                  name="password_confirmation"
                  type="password"
                  placeholder="Confirmez votre mot de passe"
                  required
                />
                <p id="passwordConfirmationError" class="text-red-500 text-xs italic @error('password') block @else hidden @enderror">
                    Les mots de passe ne correspondent pas.
                </p>
              </div>
          
              <!-- Role Selection -->
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Rôle</label>
                <select
                  class="w-full pl-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('role') border-red-500 @enderror"
                  id="role"
                  name="role"
                  required
                >
                  <option value="joueur" {{ old('role') == 'joueur' ? 'selected' : '' }}>Joueur</option>
                  <option value="club_admin" {{ old('role') == 'club_admin' ? 'selected' : '' }}>Club Admin</option>
                </select>
                <p id="roleError" class="text-red-500 text-xs italic @error('role') block @else hidden @enderror">
                    @error('role'){{ $message }}@else Le rôle est requis.@enderror
                </p>
              </div>
          
              <!-- Signup Button -->
              <div>
                <button
                  type="submit"
                  class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"
                >
                  S'INSCRIRE
                </button>
              </div>

              <div class="flex items-center justify-between pt-4 border-t border-gray-300">
                <span class="text-sm text-gray-600">Déjà un compte?</span>
                <a href="" class="text-sm font-medium text-blue-600 hover:text-blue-900">Se connecter</a>
            </div>

            </div>
          </form>

      </div>
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>