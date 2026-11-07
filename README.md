# Cake & Dessert Management System (Laravel 12)

A Web Programming II lecture homework project based on the professor-provided **07-Confectionery** data. All original three tables are populated by migrations/seeders, including 139 confections, 45 content markers, and 208 price options.

## Requirements

- PHP 8.2 or newer, Composer, and a MySQL server (such as XAMPP MySQL)
- VS Code or another editor
- Internet access for the Bootswatch (Minty), Bootstrap JS, and Chart.js CDNs
- SQLite PHP extension if you want to run the optional automated tests

## Local setup (Windows, VS Code)

1. Extract the ZIP to a suitable location and open **CakeDessertManagement** in VS Code.
2. Ensure that PHP 8.2+ and Composer are available. In the VS Code terminal run:

   ```powershell
   php -v
   composer install
   Copy-Item .env.example .env
   php artisan key:generate
   ```

   If PHP is not on PATH, use the professor-provided portable PHP executable (e.g. `C:\php\php.exe`) for all `php` commands. Composer must use an appropriate PHP executable too.

3. Start MySQL in XAMPP. In phpMyAdmin create an empty database named `cake_dessert` with `utf8mb4` encoding. **Do not import the TSV files manually**; migrations and seeders handle that.
4. Open `.env` and configure MySQL username/password. For example `DB_DATABASE=cake_dessert`, `DB_USERNAME=root`, `DB_PASSWORD=` for a local default XAMPP setup.
5. **Before seeding**, set `ADMIN_NAME`, `ADMIN_EMAIL`, and a strong unique `ADMIN_PASSWORD` (minimum 12 characters) in `.env`. Do not commit real credentials.
6. Run:

   ```powershell
   php artisan migrate:fresh --seed
   php artisan serve
   ```

7. Open http://127.0.0.1:8000. Sign in with the admin credentials configured in `.env`. You may also register a normal user through the Register menu.

**Caution:** `migrate:fresh` deletes and recreates the configured database tables. Use it only on a disposable development database.

## Features / routes

| URL | Purpose | Access |
| --- | --- | --- |
| `/` | Landing page and featured cakes | Everyone |
| `/database` | Searchable joined data across all 3 tables | Everyone |
| `/contact` | Validated message submission | Everyone |
| `/graph` | Live type/unit charts via Chart.js | Everyone |
| `/register`, `/login`, `/logout` | User authentication | As applicable |
| `/messages` | Messages ordered by `created_at DESC` | Logged-in users |
| `/admin/confections` | Confection CRUD with role middleware | Admin only |

The `users.role` field defaults to `registered`. Public registration cannot assign an admin role. Admin accounts can only be seeded by a trusted server configuration. Login regenerates session IDs, logout invalidates the session, web forms have CSRF protection, inputs are validated server-side, and Laravel Blade escapes displayed values.

## Source data

- `database/data/confections.tsv`: 139 products
- `database/data/contents.tsv`: 45 content codes (e.g. `G` means gluten free)
- `database/data/prices.tsv`: 208 prices

The dataset's `prizewinning` column includes `-1` and `0`; the source description calls the column Boolean but does not explain `-1`. Original numeric values remain intact. The supplied `free` codes other than `G` are intentionally not expanded without a source key. The site shows the raw codes and never claims food is allergen-safe based on incomplete data. Price units include pieces, kilograms, slices, bars, etc. Prices in HUF are not directly comparable across different units.

## Web design

Uses the free responsive **Bootswatch Minty** theme (Bootstrap 5) and Blade layout inheritance. Homepage imagery is represented using Unicode cake symbols; no third-party photos are embedded. CDN assets require a connection.

## Test

After configuring the dependencies and PHP SQLite extension:

```powershell
php artisan test
```

Automated tests cover public routes, authentication authorization, registration role protection, admin create, and message validation.

## Hosting

1. Choose a PHP 8.2+ hosting service with MySQL and Laravel support.
2. Install Composer dependencies and set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, a unique `APP_KEY`, secure MySQL credentials, and appropriate directory permissions.
3. Point the site's web document root to **the `public/` directory only** (never expose `.env` or other Laravel application files).
4. Run `php artisan migrate --force` and `php artisan db:seed --force` as appropriate; create admin credentials securely before the first seeding.
5. Ensure session/cache files are writable, external CDNs load, and HTTPS is enabled.

Hosting deployment, GitHub team history, site URLs, live screenshots and personal details **cannot be completed automatically** within this source ZIP. Update the accompanying documentation with real evidence after deploying and testing. Do not place hosting FTP or database passwords in a public repository.

## Teamwork / submission

The professor requires a two-person team, at least five meaningful GitHub history steps, visible contributions from both team members, public repository, live hosting, and a minimum ten-page PDF with real screenshots. Each member submits the PDF to Teams. Update the footer creator names and Neptun codes in `resources/views/layouts/app.blade.php` before submission.

**Important course distinction:** The professor says to extend the exact `Solutions.zip` Authentication lesson starter (React starter kit). That starter ZIP was not among the uploaded files; this standalone application implements conventional Laravel session authentication instead. To meet that literal requirement, merge/adapt the code into the lecturer's provided Authentication starter and verify compatibility.
