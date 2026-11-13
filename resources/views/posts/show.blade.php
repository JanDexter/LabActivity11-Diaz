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
            Published {{ $post->published_at->format('F d, Y') }} ·
            <a href="{{ route('authors.show', $post->author) }}" class="text-emerald-700 hover:underline">{{ $post->author->name }}</a>
            ({{ $post->author->position }}) · {{ $post->views }} views
        </p>

        <div class="flex flex-wrap gap-1 mt-3">
            @foreach ($post->tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                   class="text-xs bg-gray-100 text-gray-700 rounded-full px-2 py-0.5 hover:bg-gray-200">#{{ $tag->name }}</a>
            @endforeach
        </div>

        <div class="mt-4 leading-relaxed whitespace-pre-line">{{ $post->body }}</div>
    </article>

    <section id="comments" class="mt-8 border-t border-gray-200 pt-6">
        <h2 class="text-lg font-semibold mb-4">Comments ({{ $post->comments->count() }})</h2>

        @auth
            <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-6 space-y-2">
                @csrf

                @if ($errors->any())
                    <div class="border border-red-300 bg-red-50 text-red-700 rounded px-4 py-2 text-sm">
                        <p class="font-semibold">Please fix the following:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label for="body" class="block text-sm font-medium">Write a comment</label>
                <textarea id="body" name="body" rows="3" placeholder="Unsa imong comment?"
                          class="w-full border rounded p-2 focus:outline-none focus:border-emerald-600 @error('body') border-red-500 @else border-gray-300 @enderror">{{ old('body') }}</textarea>
                @error('body') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

                <button class="bg-emerald-700 hover:bg-emerald-800 text-white rounded px-4 py-2">Post comment</button>
            </form>
        @endauth

        @guest
            <p class="mb-6 text-sm text-gray-600">
                <a href="{{ route('login') }}" class="text-emerald-700 hover:underline">Sign in to comment</a>
            </p>
        @endguest

        @forelse ($post->comments as $comment)
            <div class="border-b border-gray-100 py-3">
                <p class="text-sm">
                    <span class="font-semibold">{{ $comment->user->name }}</span>
                    <span class="text-gray-500">· {{ $comment->created_at->diffForHumans() }}</span>
                </p>
                <p class="mt-1 whitespace-pre-line">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-gray-600">No comments yet.</p>
        @endforelse
    </section>
@endsection
