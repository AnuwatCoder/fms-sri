# FMS Information Portal

Laravel 13 and Livewire 4 portal for the Strategic Work, Revenue Management and Information Innovation Division, Faculty of Management Sciences, Prince of Songkla University.

## Main areas

- Public portal for systems, news, documents, events, division information, personnel, and contact details.
- Administration area under `/admin` for managing published portal content.
- Session-based favorite systems and Livewire filtering for public directories.

## Project structure

- `app/Enums` — domain values with behavior, such as system access types.
- `app/Http/Controllers/Admin` — thin HTTP controllers for the administration area.
- `app/Http/Requests/Admin` — administration validation and request normalization.
- `app/Livewire` — interactive public directory and contact components.
- `app/Models` — Eloquent models, query scopes, casts, and presentation accessors.
- `app/Services` — file lifecycle and multi-model business operations.
- `app/Support` — small stateless formatting and sanitizing helpers.
- `database/seeders/Data` — default content used only by database seeders.
- `resources/views/admin` — administration Blade views.
- `resources/views/portal` — public portal Blade views.

The project intentionally does not use repositories. Eloquent remains in controllers for straightforward CRUD, while operations involving uploaded files or transactions live in focused services.

## Setup

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
```

Set `ADMIN_EMAIL`, `ADMIN_NAME`, and `ADMIN_PASSWORD` in `.env` before seeding when an administrator account should be created outside the testing environment.

To refresh only the example portal systems, news, events, and documents, run:

```bash
php artisan db:seed --class=PortalContentSeeder
```

## Development

```bash
composer run dev
```

## Quality checks

```bash
php artisan test
php vendor/bin/pint --test
npm run build
```
