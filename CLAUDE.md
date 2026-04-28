# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Start the dev server (Terminal 1)
php artisan serve

# Build/watch frontend assets (Terminal 2)
npm run dev

# Run the game sync scheduler (Terminal 3)
php artisan schedule:work

# Run a one-off game sync
php artisan sync:games

# Run migrations
php artisan migrate

# Create an admin user
php artisan tinker
# then: App\Models\User::create(['username' => 'admin', 'password' => bcrypt('senha'), 'is_admin' => true]);

# Run tests
php artisan test
# or single test:
php artisan test --filter TestName
```

## Architecture

**Stack:** Laravel 13 + Livewire Flux starter kit + Fortify auth + MySQL.

### Authentication
- Uses **Laravel Fortify** (not Breeze). Config at `config/fortify.php`.
- Login field is `username` (not email). The `'username' => 'username'` key in Fortify config drives this.
- `CreateNewUser` action: `app/Actions/Fortify/CreateNewUser.php`
- Password reset and email verification are **disabled** — no email field exists on users.
- Admin check via `is_admin` boolean on `users` table; `app/Http/Middleware/IsAdmin.php` protects `/admin/*`.

### Key Models
- **User** — `username`, `password`, `is_admin`; `belongsToMany(Group)`, `hasMany(Prediction)`
- **Group** — `name`, `code` (auto-generated 6-char uppercase), `owner_id`, `current_min_bet`; auto-generates code in `booted()`
- **Game** — `api_id`, `home_team`, `away_team`, `starts_at`, `home_score`, `away_score`, `status` (`scheduled`/`in_progress`/`finished`)
- **Prediction** — unique on `(user_id, game_id, group_id)`; `points` field updated by the sync command

### Scoring logic (in `SyncGames` command)
- Exact score → 3 points
- Correct winner or draw (same sign of goal difference) → 1 point
- Wrong → 0 points

### Football API
- Provider: `football-data.org` (competition code `WC`)
- Key and URL come from `FOOTBALL_API_KEY` / `FOOTBALL_API_URL` env vars (mapped in `config/services.php` as `football_api`)
- Scheduler fires `sync:games` every 5 minutes (configured in `routes/console.php`)

### Views
- All app pages use `<x-layouts::app>` (Livewire Flux sidebar layout)
- Auth pages use `<x-layouts::auth>`
- Flux components (`flux:card`, `flux:table`, `flux:button`, etc.) — refer to existing views for usage patterns
- Settings pages at `resources/views/pages/settings/` are Livewire Volt single-file components (`.blade.php` with inline PHP class)

### Routes
- App routes in `routes/web.php`: groups (`/groups`), predictions, ranking
- Admin routes: `prefix('admin')->name('admin.')` with `is_admin` middleware
- Fortify auth routes (login, register, logout) are auto-registered by Fortify
- Settings routes in `routes/settings.php`
