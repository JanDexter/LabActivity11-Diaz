# Barangay Bulletin – Purok Diaz

Lab Activity 11 for 4-334 Full-Stack Web Development (Relationships, Eager Loading & Form Requests).

This continues my Lab 10 bulletin for Barangay Matina Crossing. Every post now shows its author and tags, logged-in residents can comment, and Kagawads can write new posts from the site. All form input goes through Form Request classes. Login is still the simple manual login from Lab 9 (no Breeze yet).

## Seeded logins

Both accounts use the password **`bulletin2026`** (stored hashed).

| Name | Email | What they can do |
|---|---|---|
| Lola Diaz | lola.diaz@bulletin.test | Resident: can comment, gets 403 on New post |
| Kagawad Jan Dexter Diaz | kagawad.diaz@bulletin.test | Linked to my Kagawad author profile, so can comment and write posts |

There are also 8 more residents made with the user factory (their password is `password`, the factory default).

## My 5 tags

- Purok Diaz
- Urgent
- Libre
- Schedule
- **Bayanihan** (my own tag, because it fits the clean-up drive and other community work posts)

Every post gets 1–3 random tags in `TagSeeder` using `attach()`. My pinned post uses `sync()` so it always has exactly Purok Diaz and Urgent.

## My personalized values (kept from Lab 10)

- **Posts per page: 6.** "Diaz" only has 4 letters, so I used the minimum of 6.
- **Categories:** Announcement, Health, Peace & Order, Ayuda, and my own **Livelihood**.
- **Pinned birthday post:** "Purok Diaz Clean-up Drive", published January 23, 2026. It has 3 seeded comments, one of them by Lola Diaz.
- **Comment error message:** "Purok Diaz comments need at least 3 characters."

## Relationships and why I used each one

| Link | Type | Why |
|---|---|---|
| User → Author | `hasOne` | A login account has at most one author profile. Only officials have one, residents don't. The `user_id` is on `authors` (nullable + unique), so the User side is `hasOne`. I use it in `StorePostRequest` to block residents and in `PostController@store` to create the post as that author. |
| Author → User | `belongsTo` | Reverse of the above, the author row holds the `user_id`. |
| Author → Post | `hasMany` | One official writes many posts. |
| Post → Author | `belongsTo` | Each post has one `author_id`. Used to show "Kinsa nag-post ani?" on every card. |
| Post → Comment | `hasMany` | A post has many comments. New comments are created through `$post->comments()->create()`. |
| Comment → Post | `belongsTo` | Each comment has a `post_id`. Used on the author page to show which post a comment was on. |
| User → Comment | `hasMany` | A resident can write many comments. Lola's seeded comment is created through `$lola->comments()`. |
| Comment → User | `belongsTo` | Shows the commenter's name under each comment. |
| Post ↔ Tag | `belongsToMany` | A post can have many tags and a tag is on many posts, so it needs the `post_tag` pivot table (singular names, alphabetical). Post → tags is used for the badges and the `?tag=` filter (`whereHas`). Tag → posts is used for the post count beside each tag in the filter dropdown. |
| Author → Comment | `hasManyThrough` (via Post) | Comments don't have an `author_id`, they only connect to the author through the post. This lets me count "N comments received" on `/authors/{author}` without looping over every post. |

To avoid N+1 queries, `Model::preventLazyLoading()` is on outside production. The index uses `with(['author', 'tags'])->withCount('comments')`, and the show page uses `load()` with `comments.user`.

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

## Checking the seed in tinker

```php
App\Models\User::where('email', 'like', 'kagawad.%')->first()->author->name   // "Kagawad Jan Dexter Diaz"
App\Models\Author::first()->comments()->count()                                // hasManyThrough
App\Models\Post::where('is_pinned', true)->first()->tags->pluck('name')       // ["Purok Diaz", "Urgent"]
```
