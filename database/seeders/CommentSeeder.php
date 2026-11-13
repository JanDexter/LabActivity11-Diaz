<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // 0-5 comments on every published post (drafts get none), by random users
        $publishedPosts = Post::where('is_published', true)->where('is_pinned', false)->get();

        foreach ($publishedPosts as $post) {
            Comment::factory()->count(rand(0, 5))
                ->for($post)
                ->sequence(fn ($seq) => ['user_id' => $users->random()->id])
                ->create();
        }

        // my pinned post gets its own comments, one of them by Lola
        $pinned = Post::where('is_pinned', true)->first();
        $lola = User::where('email', 'lola.diaz@bulletin.test')->first();
        $residents = $users->where('id', '!=', $lola->id);

        $pinned->comments()->create([
            'user_id' => $residents->random()->id,
            'body' => 'Asa mi mag-meet sa Sabado? Sa hall ba diretso?',
        ]);

        $pinned->comments()->create([
            'user_id' => $residents->random()->id,
            'body' => 'Mo-apil mi ni Mama, magdala mi ug extra nga sako.',
        ]);

        // Lola's comment goes through her side of the relationship (User hasMany Comment)
        $lola->comments()->create([
            'post_id' => $pinned->id,
            'body' => 'Dili na ko kaya mo-limpyo pero magluto ko ug ginataan para sa mga volunteers.',
        ]);
    }
}
