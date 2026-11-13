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
        // authors first, posts need an existing author_id
        $this->call([
            AuthorSeeder::class,
            PostSeeder::class,
        ]);
    }
}
