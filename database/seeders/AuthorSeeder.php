<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // my own Kagawad, made by hand (not by the factory)
        Author::create([
            'name' => 'Kagawad Jan Dexter Diaz',
            'position' => 'Kagawad',
            'email' => 'kagawad.diaz@bulletin.test',
        ]);

        // 4 more random officials
        Author::factory()->count(4)->create();
    }
}
