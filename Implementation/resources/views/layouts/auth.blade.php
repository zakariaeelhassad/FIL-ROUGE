<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'GooLink - Authentication' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#e6f0ff',
                            100: '#cce0ff',
                            200: '#99c2ff',
                            300: '#66a3ff',
                            400: '#3385ff',
                            500: '#0066ff',
                            600: '#0052cc',
                            700: '#003d99',
                            800: '#002966',
                            900: '#001433',
                            950: '#0a1445', 
                        }
                    }
                }
            }
        }
    </script>
    @stack('styles')
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
                    <img class="w-16 h-16 text-white" src="{{ asset('images/G_1.png') }}" alt="GooLink Logo">
                </div>
                <h1 class="text-2xl font-bold text-white">GooLink</h1>
            </div>

            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>