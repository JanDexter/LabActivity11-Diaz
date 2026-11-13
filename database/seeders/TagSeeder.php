<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // the 4 required tags + Bayanihan as my own tag
        $names = ['Purok Diaz', 'Urgent', 'Libre', 'Schedule', 'Bayanihan'];

        foreach ($names as $name) {
            Tag::create(['name' => $name]);
        }

        $tags = Tag::all();

        // 1-3 random tags per post, through the relationship (no manual pivot inserts)
        foreach (Post::all() as $post) {
            $post->tags()->attach($tags->random(rand(1, 3))->pluck('id'));
        }

        // sync() replaces whatever was attached above, so the pinned post
        // always ends up with exactly these two tags
        $pinned = Post::where('is_pinned', true)->first();
        $pinned->tags()->sync(
            Tag::whereIn('name', ['Purok Diaz', 'Urgent'])->pluck('id')
        );
    }
}
