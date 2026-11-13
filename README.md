# Barangay Bulletin – Purok Diaz

Lab Activity 10 for 4-334 Full-Stack Web Development (Eloquent, Migrations & Seeding).

A small blog for the Barangay Matina Crossing Hall where officials post announcements and residents can search, filter by category, and page through posts. All the data comes from SQLite through Eloquent.

## My personalized values

- **Posts per page: 6.** My last name "Diaz" only has 4 letters, so I used the minimum of 6.
- **Custom category: Livelihood.** The other four are Announcement, Health, Peace & Order and Ayuda.
- **Birthday post date: January 23, 2026.** This is the `published_at` of the pinned "Purok Diaz Clean-up Drive" post.
- **My Kagawad:** Kagawad Jan Dexter Diaz (kagawad.diaz@bulletin.test), made with `Author::create()` in `AuthorSeeder`.

After seeding there are 5 authors and 51 posts (40 published, 10 drafts, plus my pinned post).

## How to run

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run dev
php artisan serve
```

Then open http://localhost:8000. It redirects to `/posts`.

If `database/database.sqlite` doesn't exist yet, create it before migrating: `New-Item database/database.sqlite` (PowerShell) or `touch database/database.sqlite`.

## Tinker

`docs/tinker.png` shows the ActiveRecord part:

```php
$post = App\Models\Post::find(1);
$post->title = 'Purok Diaz: ' . $post->title;
$post->save();
App\Models\Post::find(1)->title
```
