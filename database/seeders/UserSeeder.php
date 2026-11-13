<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // resident account, no author profile so she can comment but not post
        User::create([
            'name' => 'Lola Diaz',
            'email' => 'lola.diaz@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        $kagawadUser = User::create([
            'name' => 'Kagawad Jan Dexter Diaz',
            'email' => 'kagawad.diaz@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        // link the login account to the Kagawad author made in AuthorSeeder
        $kagawadAuthor = Author::where('email', 'kagawad.diaz@bulletin.test')->first();
        $kagawadAuthor->user_id = $kagawadUser->id;
        $kagawadAuthor->save();

        // 8 more residents
        User::factory()->count(8)->create();
    }
}
