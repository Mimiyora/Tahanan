# Tahanan Coffee House POS

A four-page CodeIgniter 4 point-of-sale account portal with a classic Philippine coffeehouse theme. Customer and staff account records are stored in MySQL and retrieved through CodeIgniter models.

## Pages

- `/` — landing page
- `/about` — brand story
- `/customers` — customer accounts retrieved by `CustomerModel`
- `/users` — staff accounts retrieved by `UserModel`

## Database schema

The project follows the schema supplied for IT0049 TFA2:

- `customers`: `id`, `full_name`, `email`, `phone`, `created_at`
- `users`: `id`, `username`, `full_name`, `created_at`

The repository includes migrations, seeders with six sample records per table, and the MySQL export at `database/tahanan_pos.sql`.

## Local setup

Requirements: PHP 8.2+, Composer.

1. Install dependencies:

   ```bash
   composer install
   ```

2. Copy `env` to `.env`. The template is configured for a local MySQL database named `tahanan_pos` with the default XAMPP `root` account and a blank password. Change these values if your setup is different.

3. Create and populate the database using either method:

   ```bash
   php spark db:create tahanan_pos
   php spark migrate
   php spark db:seed DatabaseSeeder
   ```

   Alternatively, import `database/tahanan_pos.sql` through phpMyAdmin or the MySQL command line.

4. Start the application:

   ```bash
   php spark serve --port 8091
   ```

Set `app.baseURL` in `.env` to the URL used by your local or hosted environment. The development value used for this project is `http://localhost:8091/`.

Visit [http://localhost:8091](http://localhost:8091).

## Data flow

`CustomerModel` and `UserModel` use Query Builder through `findAll()`. Their controllers order the records, derive avatar initials from `full_name`, and pass the results to the existing views. No page records remain in static controller arrays.

## Tests

The feature tests use an in-memory SQLite database, run the same migrations and seeders, and verify that both account pages display database records:

```bash
composer test
```

The PHP CLI used for testing must have the SQLite3 extension enabled. In XAMPP, enable `extension=sqlite3` in `php.ini` if the test command reports that the extension is missing.
