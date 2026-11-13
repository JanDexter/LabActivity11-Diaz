@extends('layouts.app')

@section('title', 'New post – Barangay Bulletin – Purok Diaz')

@section('content')
    <a href="{{ route('posts.index') }}" class="text-sm text-emerald-700 hover:underline">&larr; Back to posts</a>

    <h1 class="text-2xl font-bold mt-4 mb-4">New post</h1>

    @if ($errors->any())
        <div class="mb-4 border border-red-300 bg-red-50 text-red-700 rounded px-4 py-2 text-sm">
            <p class="font-semibold">Please fix the following:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('posts.store') }}" class="max-w-2xl space-y-4">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium mb-1">Title</label>
            <input id="title" name="title" value="{{ old('title') }}"
                   class="w-full border rounded p-2 focus:outline-none focus:border-emerald-600 @error('title') border-red-500 @else border-gray-300 @enderror">
            @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="category" class="block text-sm font-medium mb-1">Category</label>
            <select id="category" name="category"
                    class="w-full border rounded p-2 focus:outline-none focus:border-emerald-600 @error('category') border-red-500 @else border-gray-300 @enderror">
                <option value="">-- choose a category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                @endforeach
            </select>
            @error('category') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="body" class="block text-sm font-medium mb-1">Body</label>
            <textarea id="body" name="body" rows="8"
                      class="w-full border rounded p-2 focus:outline-none focus:border-emerald-600 @error('body') border-red-500 @else border-gray-300 @enderror">{{ old('body') }}</textarea>
            @error('body') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <fieldset>
            <legend class="block text-sm font-medium mb-1">Tags</legend>
            <div class="flex flex-wrap gap-x-4 gap-y-2">
                @foreach ($tags as $tag)
                    <label class="inline-flex items-center gap-1 text-sm">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                               @checked(in_array($tag->id, old('tags', [])))>
                        {{ $tag->name }}
                    </label>
                @endforeach
            </div>
            @error('tags') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            @error('tags.*') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </fieldset>

        <div>
            <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published'))>
                Publish now (leave unchecked to save as draft)
            </label>
            @error('is_published') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button class="bg-emerald-700 hover:bg-emerald-800 text-white rounded px-4 py-2">Save post</button>
    </form>
@endsection
