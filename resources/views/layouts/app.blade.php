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
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 sm:gap-x-6">
                <a href="{{ route('posts.index') }}" class="font-semibold">Barangay Bulletin – Purok Diaz</a>
                <a href="{{ route('posts.index') }}" class="text-sm hover:underline">All Posts</a>
                {{-- only officials with an author profile can write posts --}}
                @auth
                    @if (auth()->user()->author)
                        <a href="{{ route('posts.create') }}" class="text-sm hover:underline">New post</a>
                    @endif
                @endauth
            </div>
            <div class="flex items-center gap-3 sm:gap-4 text-sm">
                @auth
                    <span class="hidden sm:inline">Hi, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="underline">Logout</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="underline">Sign in</a>
                @endguest
            </div>
        </div>
    </nav>

    <main class="flex-1 w-full max-w-5xl mx-auto px-3 sm:px-4 py-4 sm:py-6">
        @if (session('status'))
            <div class="mb-4 border border-emerald-300 bg-emerald-50 text-emerald-800 rounded px-4 py-2 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-100 text-gray-600 text-sm">
        <div class="max-w-5xl mx-auto px-4 py-4">
            Barangay Matina Crossing Hall, Davao City
        </div>
    </footer>
</body>
</html>
