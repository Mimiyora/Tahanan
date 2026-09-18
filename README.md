# Tahanan Coffee House POS

A four-page CodeIgniter 4 point-of-sale account portal with a classic Philippine coffeehouse theme.

## Pages

- `/` — landing page
- `/about` — brand story
- `/customers` — customer accounts from a temporary PHP array
- `/users` — staff accounts from a temporary PHP array

No database is used in version 1. A documented placeholder is provided in `database/no-database-required.sql` because the assignment submission checklist mentions a database export.

## Local setup

Requirements: PHP 8.2+, Composer.

```bash
composer install
cp env .env
php spark serve
```

Set `app.baseURL` in `.env` to the URL used by your local or hosted environment. The development value used for this project is `http://localhost:8091/`.

Then run `php spark serve --port 8091` and visit [http://localhost:8091](http://localhost:8091).

## Data source

The sample records live directly in:

- `app/Controllers/Customers.php`
- `app/Controllers/Users.php`

Each controller passes its array to a view, where a PHP `foreach` renders the records.
