@extends('layouts.app')

@section('title', $post->title . ' – Barangay Bulletin – Purok Diaz')

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-emerald-700 hover:underline">&larr; Back to posts</a>

    <article class="mt-4">
        <div class="flex flex-wrap gap-2 mb-2">
            @if ($post->is_pinned)
                <span class="text-xs font-semibold bg-amber-400 text-amber-950 rounded px-2 py-0.5">Pinned</span>
            @endif
            <span class="text-xs bg-emerald-100 text-emerald-800 rounded px-2 py-0.5">{{ $post->category }}</span>
        </div>

        <h1 class="text-2xl md:text-3xl font-bold">{{ $post->title }}</h1>

        <p class="text-sm text-gray-500 mt-1">
            Published {{ $post->published_at->format('F d, Y') }} · Author #{{ $post->author_id }} · {{ $post->views }} views
        </p>

        <div class="mt-4 leading-relaxed whitespace-pre-line">{{ $post->body }}</div>
    </article>
@endsection
