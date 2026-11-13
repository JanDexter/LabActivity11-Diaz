@extends('layouts.app')

@section('title', 'Sign in – Barangay Bulletin – Purok Diaz')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="w-full max-w-sm mx-auto mt-2 sm:mt-6 space-y-4 p-4 sm:p-6 border border-gray-300 rounded">
        @csrf
        <h1 class="text-xl font-semibold">Sign in</h1>

        <div>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                   class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:border-emerald-600">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <input type="password" name="password" placeholder="Password"
                   class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:border-emerald-600">
            @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button class="w-full bg-emerald-700 hover:bg-emerald-800 text-white rounded p-2">Sign in</button>
    </form>
@endsection
