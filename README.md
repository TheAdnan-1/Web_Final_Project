# InternTrack — Internship Logbook & Performance Management System

A full Laravel 12 + MySQL system for managing student internships: daily/
weekly activity logs, supervisor feedback and evaluations, document uploads,
and coordinator-level analytics — built for three roles (**Student**,
**Supervisor**, **Coordinator/Admin**) with role-based access control.

This is a complete, standard Laravel project — `artisan`, `composer.json`,
`config/`, `storage/`, `public/index.php`, etc. came from the official
Laravel skeleton, with the application itself (models, controllers,
migrations, views, routes) built on top. Built on **Laravel 12**, which
requires **PHP 8.2+** (same as Laravel 11, but still inside its active
security-support window — see note below). The only thing missing is the
`vendor/` folder, because — like every Laravel project you'd clone from
GitHub — dependencies aren't shipped in source, they're installed locally
with Composer (Step 2 below).

```
interntrack/
├── app/              Controllers, Models, Middleware (custom)
├── bootstrap/        app.php registers the 'role' middleware
├── config/           Standard Laravel config (unmodified)
├── database/         Migrations (3 default + 8 custom) + seeder
├── public/           Standard entry point (unmodified)
├── resources/views/  All Blade views (custom, Tailwind CDN)
├── routes/web.php    All application routes (custom)
├── storage/           Standard Laravel storage dirs (unmodified)
├── artisan
├── composer.json
├── package.json
├── .env               Pre-filled for XAMPP/MySQL, real APP_KEY already set
└── .env.example
```

> **Why Laravel 12, not 11?** Laravel 11 was released Feb 2024 and its
> 2-year security-support window has now closed, so Composer's built-in
> advisory check (added in Composer 2.9+) refuses to install *any* current
> 11.x release — there's no patched version left to fall back to. Laravel
> 12 (Feb 2025) is still fully supported, needs the same PHP 8.2+, and
> won't hit that wall.

---

## 1. Requirements

- **PHP 8.2 or newer** (check with `php -v` — your XAMPP PHP 8.2.12 works)
- Composer 2.x
- MySQL (via XAMPP)
- Internet connection (for `composer install`, and because the UI loads
  Tailwind/Alpine.js/Chart.js/Font Awesome from CDNs — no build step needed)

---

## 2. Setup

### Step 1 — Create the database
Start Apache + MySQL in the XAMPP Control Panel, open
`http://localhost/phpmyadmin`, and create a database named `interntrack`
(default collation is fine).

### Step 2 — Install dependencies
From **inside this project folder** (the one with `composer.json` directly
in it — not a subfolder):

```bash
composer install
```

This downloads Laravel and every package listed in `composer.json` into
`vendor/`. `.env` is already filled in with a valid `APP_KEY` and MySQL
settings that match XAMPP's defaults (`root` user, no password) — double
check it matches your setup, but you shouldn't need to change anything.

### Step 3 — Migrate & seed
```bash
php artisan migrate --seed
php artisan storage:link
```

### Step 4 — Run it
```bash
php artisan serve
```

Visit **http://127.0.0.1:8000**.

> Prefer XAMPP's Apache instead of `artisan serve`? Move this folder into
> `C:/xampp/htdocs/interntrack`, then visit
> `http://localhost/interntrack/public/`.

---

## 3. Demo accounts (seeded automatically)

All demo accounts use the password: **`password`**

| Role        | Email                          |
|-------------|---------------------------------|
| Coordinator | coordinator@interntrack.test    |
| Supervisor  | supervisor1@interntrack.test    |
| Supervisor  | supervisor2@interntrack.test    |
| Supervisor  | supervisor3@interntrack.test    |
| Student     | student1@interntrack.test       |
| Student     | student2@interntrack.test       |
| Student     | student3@interntrack.test       |

New students and supervisors can also self-register from the **Register**
page. Coordinator accounts are intentionally not self-registerable — add
more via `php artisan tinker` or by extending the seeder.

---

## 4. Feature map (against the project brief)

**Student module** — submit internship info, add/edit daily-weekly logs
(rendered as a logbook timeline), upload supporting documents, view
supervisor feedback per entry, generate/print a final internship report.

**Supervisor module** — see assigned students, review submitted logs
(filterable by pending/reviewed), leave a star rating + written feedback per
log (which marks it reviewed), submit a 5-criteria final evaluation
(technical skills, communication, teamwork, punctuality, initiative) with
an auto-calculated overall rating.

**Coordinator/Admin module** — manage student & supervisor accounts (create,
edit, deactivate, delete), assign supervisors to students, monitor every
internship's status and progress, update internship status, view
department-wise statistics and top performers, live dashboard analytics
(Chart.js bar + doughnut charts).

**System-wide** — role-based authentication and middleware
(`role:student|supervisor|coordinator`), progress tracking (hours logged vs.
required), profile + password management for every role.

---

## 5. What's custom vs. stock Laravel

Everything under `app/Http/Controllers`, `app/Http/Middleware`,
`app/Models` (except the base `Controller.php`), `database/migrations`
(the eight `2024_01_01_*` files), `database/seeders/DatabaseSeeder.php`,
`routes/web.php`, and all of `resources/views` is hand-written for this
project. Everything else (`config/`, `public/`, `storage/`, `tests/`,
`artisan`, `bootstrap/app.php`'s routing/exception scaffolding, the three
default migrations) is untouched Laravel 12 boilerplate.

`composer.json` also has one small addition in `config.policy.advisories`:
`"block": false`. This turns Composer's install-time CVE blocker into a
warn-only check instead of a hard stop, so a future advisory affecting a
transitive dependency can't leave you stuck the way the Laravel 11 one did.
For a real production deployment you'd normally leave that blocking enabled
and instead just update the affected package — this override is a
convenience for a lab/dev project where a build shouldn't just stop working.

---

## 6. Troubleshooting

- **"Class not found" / autoload errors** — run `composer dump-autoload`.
- **"could not find driver" on migrate** — your PHP is missing the
  `pdo_mysql` extension. In XAMPP, open `php.ini` (via the XAMPP control
  panel → Apache → Config → PHP), find `;extension=pdo_mysql`, remove the
  leading `;`, save, and restart Apache/your terminal.
- **"SQLSTATE[HY000] [1049] Unknown database"** — you haven't created the
  `interntrack` database in phpMyAdmin yet (Step 1).
- **"affected by security advisories" during `composer install`** —
  shouldn't happen on Laravel 12 as of this writing, but if a new advisory
  appears later, the `policy.advisories.block: false` setting already in
  `composer.json` (see above) prevents it from blocking your install.
- **Blank/broken styling** — you need an internet connection the first time
  each page loads, since Tailwind/Alpine/Chart.js/Font Awesome load from
  CDNs rather than a local build.

---

## 7. Notes & possible extensions

- **PDF export**: the student report and coordinator reports use a
  print-friendly layout with a "Print / Save as PDF" button. For a
  server-generated PDF instead, `composer require barryvdh/laravel-dompdf`
  and swap the report view's Blade for a `Pdf::loadView(...)` call.
- **Styling**: Tailwind is loaded via CDN for zero-build-step convenience.
  `package.json`/`vite.config.js` are still here if you'd rather switch to
  a compiled Tailwind build later.
- **Notifications/emails**: not included, but ready to add via
  `Illuminate\Notifications` if you want to email students when feedback is
  left.
