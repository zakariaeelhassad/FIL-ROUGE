<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    @include('components.navbar')
    <div class="bg-gray-100 p-6">
        <div class="max-w-2xl mx-auto">
            @include("components.reseau.follow")
            
            <div class="my-4"></div>
            
            @include("components.reseau.follower")
        </div>
    </div>
</body>
</html>