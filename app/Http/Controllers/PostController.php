<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * "Diaz" only has 4 letters, so I use the minimum of 6.
     */
    private const PER_PAGE = 6;

    public function index(Request $request): View
    {
        // author + tags are eager-loaded here so the cards don't run 1 query per post
        $posts = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->input('q').'%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->input('category'));
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', function ($tagQuery) use ($request) {
                    $tagQuery->where('name', $request->input('tag'));
                });
            })
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $categories = Post::query()->distinct()->orderBy('category')->pluck('category');
        $tags = Tag::query()->orderBy('name')->pluck('name');

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    /**
     * Drafts are filtered out first so findOrFail() gives a 404 for them too.
     */
    public function show(string $id): View
    {
        $post = Post::query()->where('is_published', true)->findOrFail($id);

        $post->views = $post->views + 1;
        $post->save();

        // newest comments first; id is the tie-breaker for comments made in the same second
        $post->load([
            'author',
            'tags',
            'comments' => fn ($query) => $query->latest()->orderByDesc('id'),
            'comments.user',
        ]);

        return view('posts.show', compact('post'));
    }
}
