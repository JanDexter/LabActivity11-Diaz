{{-- one post card, used on the index and on the author page --}}
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
        {{ $post->published_at->format('M d, Y') }} ·
        <a href="{{ route('authors.show', $post->author) }}" class="text-emerald-700 hover:underline">{{ $post->author->name }}</a>
    </p>
    <p class="text-sm text-gray-500">{{ $post->views }} views · {{ $post->comments_count }} comments</p>

    <div class="flex flex-wrap gap-1 mt-3">
        @foreach ($post->tags as $tag)
            <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
               class="text-xs bg-gray-100 text-gray-700 rounded-full px-2 py-0.5 hover:bg-gray-200">#{{ $tag->name }}</a>
        @endforeach
    </div>
</div>
