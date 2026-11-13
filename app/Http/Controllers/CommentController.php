<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Validation is already done by StoreCommentRequest before this runs.
     * Drafts 404 on the show page, so they can't get comments either.
     */
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        abort_if(! $post->is_published, 404);

        $post->comments()->create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('posts.show', $post->id)->with('status', 'Comment posted.');
    }
}
