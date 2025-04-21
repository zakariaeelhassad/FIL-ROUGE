<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Network</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    },
                    boxShadow: {
                        'soft': '0 4px 15px rgba(0, 0, 0, 0.05)',
                        'hover': '0 10px 25px rgba(0, 102, 255, 0.15)',
                    },
                }
            }
        }
    </script>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 102, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    @include('components.navbar')
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Your Network</h1>
            <p class="text-gray-600">Manage your connections and discover new people</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-1">
                @include("components.reseau.follow")
                
                <div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-5 mt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Network Stats</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Connections</span>
                            <span class="font-medium text-gray-900">128</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Pending Requests</span>
                            <span class="font-medium text-gray-900">{{ $followRequests->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Profile Views</span>
                            <span class="font-medium text-gray-900">342</span>
                        </div>
                        
                        <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-brand-400 to-brand-600 rounded-full" style="width: 75%"></div>
                        </div>
                        <div class="text-xs text-gray-500 text-center">Network growth: 75% of your goal</div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="lg:col-span-2">
                @include("components.reseau.follower")
            </div>
        </div>
    </div>
</body>
</html>
