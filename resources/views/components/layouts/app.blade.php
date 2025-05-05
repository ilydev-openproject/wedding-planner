<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Planner</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-gray-100 min-h-screen">

    {{ $slot }}

    @livewireScripts
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>