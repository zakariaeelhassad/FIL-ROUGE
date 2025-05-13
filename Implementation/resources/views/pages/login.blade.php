<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Connect - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../css/app.css">
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
                    <img class="w-16 h-16 text-white" src="../../../images/G_1.png" alt="">
                </div>
                <h1 class="text-2xl font-bold text-white">GooLink</h1>
            </div>

            <form class="p-8" id="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <h2 class="text-xl font-bold text-center text-gray-800 mb-8">Connexion</h2>

                @if ($errors->any())
                    <div class="text-red-500 text-sm mb-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="space-y-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                            <input 
                                name="email"
                                id="email" 
                                type="email" 
                                class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                placeholder="Entrez votre nom d'utilisateur"
                                value="{{ old('email') }}"
                                required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-gray-500"></i>
                            </div>
                            <input 
                                name="password"
                                id="password" 
                                type="password" 
                                class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                placeholder="Entrez votre mot de passe"
                                required>
                        </div>
                    </div>


                    <div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            CONNEXION
                        </button>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-300">
                        <span class="text-sm text-gray-600">Pas encore de compte?</span>
                        <a href="signup" class="text-sm font-medium text-blue-600 hover:text-blue-900">S'inscrire</a>
                    </div>
                </div>
            </form>

        </div>
    </div>

     <script src="../../../js/app.js"></script> 
</body>
</html>
