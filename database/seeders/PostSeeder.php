<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = Author::all();

        // 40 published posts spread over the existing authors
        Post::factory()->count(40)
            ->sequence(fn ($seq) => ['author_id' => $authors->random()->id])
            ->create();

        // 10 drafts
        Post::factory()->count(10)->draft()
            ->sequence(fn ($seq) => ['author_id' => $authors->random()->id])
            ->create();

        // my pinned post, published on my birthday (Jan 23)
        $kagawad = Author::where('email', 'kagawad.diaz@bulletin.test')->first();

        Post::create([
            'author_id' => $kagawad->id,
            'title' => 'Purok Diaz Clean-up Drive',
            'category' => 'Announcement',
            'body' => 'All residents of Purok Diaz are invited to join the clean-up drive this Saturday, 6:00 AM, starting at the Barangay Matina Crossing Hall. Please bring your own gloves, walis tingting and sako for the trash. Snacks will be provided after. Salamat sa inyong kooperasyon!',
            'is_published' => true,
            'is_pinned' => true,
            'published_at' => '2026-01-23 08:00:00',
            'views' => 0,
        ]);
    }
}
