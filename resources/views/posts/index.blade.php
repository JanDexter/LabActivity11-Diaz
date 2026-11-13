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

        <button class="bg-emerald-700 text-white rounded px-4 py-2 hover:bg-emerald-800">Filter</button>
    </form>

    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
        @forelse ($posts as $post)
            <div class="border rounded p-4 {{ $post->is_pinned ? 'border-amber-400 bg-amber-50' : 'border-gray-200' }}">
                <div class="flex flex-wrap gap-2 mb-2">
                    @if ($post->is_pinned)
                        <span class="text-xs font-semibold bg-amber-400 text-amber-950 rounded px-2 py-0.5">Pinned</span>
                    @endif
                    <span class="text-xs bg-emerald-100 text-emerald-800 rounded px-2 py-0.5">{{ $post->category }}</span>
                </div>

                <a href="{{ route('posts.show', $post->id) }}" class="font-semibold hover:underline">
                    {{ $post->title }}
                </a>

                <p class="text-sm text-gray-500 mt-2">
                    {{ $post->published_at->format('M d, Y') }} · Author #{{ $post->author_id }}
                </p>
                <p class="text-sm text-gray-500">{{ $post->views }} views</p>
            </div>
        @empty
            <p class="text-gray-600">No posts match your search.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
<p class="text-sm text-gray-500 mt-2 md:hidden">Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} posts</p>

@endsection
