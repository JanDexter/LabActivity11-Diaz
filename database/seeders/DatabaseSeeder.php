<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // order matters: posts need authors, UserSeeder links the Kagawad
        // author, tags need posts, and comments need both posts and users
        $this->call([
            AuthorSeeder::class,
            PostSeeder::class,
            UserSeeder::class,
            TagSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
