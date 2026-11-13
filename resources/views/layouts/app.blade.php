<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Barangay Bulletin – Purok Diaz')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-white text-gray-900">
    <nav class="bg-emerald-700 text-white">
        <div class="max-w-5xl mx-auto px-4 py-3 flex flex-wrap items-center justify-between gap-2">
            <a href="{{ route('posts.index') }}" class="font-semibold">Barangay Bulletin – Purok Diaz</a>
            <a href="{{ route('posts.index') }}" class="text-sm hover:underline">All Posts</a>
        </div>
    </nav>

    <main class="flex-1 w-full max-w-5xl mx-auto px-3 sm:px-4 py-4 sm:py-6">
        @yield('content')
    </main>

    <footer class="bg-gray-100 text-gray-600 text-sm">
        <div class="max-w-5xl mx-auto px-4 py-4">
            Barangay Matina Crossing Hall, Davao City
        </div>
    </footer>
</body>
</html>
