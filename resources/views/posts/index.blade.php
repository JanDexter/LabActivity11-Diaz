@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Barangay Bulletin</h1>

    <form method="GET" action="{{ route('posts.index') }}" class="flex flex-col sm:flex-row gap-2 mb-6">
        <input name="q" value="{{ request('q') }}" placeholder="Search title"
               class="flex-1 border border-gray-300 rounded px-3 py-2">

        <select name="category" class="border border-gray-300 rounded px-3 py-2">
            <option value="">All categories</option>
            @foreach ($categories as $c)
                <option value="{{ $c }}" @selected(request('category') === $c)>{{ $c }}</option>
            @endforeach
        </select>

        <select name="tag" class="border border-gray-300 rounded px-3 py-2">
            <option value="">All tags</option>
            @foreach ($tags as $t)
                <option value="{{ $t->name }}" @selected(request('tag') === $t->name)>{{ $t->name }} ({{ $t->posts_count }})</option>
            @endforeach
        </select>

        <button class="bg-emerald-700 text-white rounded px-4 py-2 hover:bg-emerald-800">Filter</button>
    </form>

    @if (request('tag'))
        <p class="text-sm text-gray-600 mb-4">
            Showing posts tagged <span class="font-semibold">#{{ request('tag') }}</span> ·
            <a href="{{ route('posts.index', request()->except('tag', 'page')) }}" class="text-emerald-700 hover:underline">clear tag</a>
        </p>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
        @forelse ($posts as $post)
            @include('posts._card', ['post' => $post])
        @empty
            <p class="text-gray-600">No posts match your search.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
<p class="text-sm text-gray-500 mt-2 md:hidden">Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} posts</p>

@endsection
