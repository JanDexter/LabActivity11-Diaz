@extends('layouts.app')

@section('title', $author->name . ' – Barangay Bulletin – Purok Diaz')

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-emerald-700 hover:underline">&larr; Back to posts</a>

    <div class="mt-4 mb-6">
        <h1 class="text-2xl md:text-3xl font-bold">{{ $author->name }}</h1>
        <p class="text-gray-600">{{ $author->position }}</p>
        <p class="text-sm text-gray-500 mt-1">
            {{ $posts->count() }} published posts · {{ $author->comments_count }} comments received
        </p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
        @forelse ($posts as $post)
            @include('posts._card', ['post' => $post])
        @empty
            <p class="text-gray-600">This author has no published posts yet.</p>
        @endforelse
    </div>

    <section class="mt-8 border-t border-gray-200 pt-6">
        <h2 class="text-lg font-semibold mb-4">Latest comments on their posts</h2>

        @forelse ($latestComments as $comment)
            <div class="border-b border-gray-100 py-3">
                <p class="text-sm">
                    <span class="font-semibold">{{ $comment->user->name }}</span>
                    <span class="text-gray-500">on</span>
                    <a href="{{ route('posts.show', $comment->post->id) }}" class="text-emerald-700 hover:underline">{{ $comment->post->title }}</a>
                    <span class="text-gray-500">· {{ $comment->created_at->diffForHumans() }}</span>
                </p>
                <p class="mt-1 text-gray-700">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-gray-600">No comments yet.</p>
        @endforelse
    </section>
@endsection
