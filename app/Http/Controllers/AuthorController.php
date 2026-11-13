<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function show(Author $author): View
    {
        // comments_count goes through the hasManyThrough (author -> posts -> comments)
        $author->loadCount('comments');

        $posts = $author->posts()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->get();

        // latest comments on this author's posts, with who wrote it and on which post
        // (comments.created_at because posts also has a created_at in the join)
        $latestComments = $author->comments()
            ->with(['user', 'post'])
            ->latest('comments.created_at')
            ->take(5)
            ->get();

        return view('authors.show', compact('author', 'posts', 'latestComments'));
    }
}
