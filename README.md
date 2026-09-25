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

## Railway deployment

The repository includes a production `Dockerfile`, Apache configuration, an idempotent startup seeder, and `railway.toml`. On every deployment the container runs pending migrations, inserts the sample records only when each table is empty, and then starts Apache on port 8080.

1. Push the repository to GitHub.
2. Create a Railway project and add a MySQL database service.
3. Add a service from the GitHub repository. Railway will detect the root `Dockerfile`.
4. In the web service's Variables tab, add these reference variables from the MySQL service:

   ```text
   CI_ENVIRONMENT=production
   PORT=8080
   MYSQLHOST=${{MySQL.MYSQLHOST}}
   MYSQLPORT=${{MySQL.MYSQLPORT}}
   MYSQLDATABASE=${{MySQL.MYSQLDATABASE}}
   MYSQLUSER=${{MySQL.MYSQLUSER}}
   MYSQLPASSWORD=${{MySQL.MYSQLPASSWORD}}
   ```

5. Generate a public domain for the web service. Add the generated URL as `app_baseURL`, including `https://` and a trailing slash.
6. Redeploy the web service and open `/customers` and `/users` to confirm the seeded records appear.

Railway database services are private by default, so the application should use the referenced private MySQL connection values instead of exposing the database publicly.

## Render deployment

The included `render.yaml` creates the CodeIgniter application as a free Docker web service in Render's Singapore region. The app automatically uses Render's assigned hostname and port.

The assignment requires MySQL. Render does not provide managed MySQL on its free datastore plans, so choose one of these database options before creating the web service:

- Deploy Render's MySQL template as a paid private service with a persistent disk.
- Supply connection details for an existing externally hosted MySQL database.

For a Render-hosted MySQL service:

1. Deploy the official Render MySQL template in the Singapore region.
2. Set `MYSQL_DATABASE` to `tahanan_pos`, choose a database username, and generate secure user and root passwords.
3. Keep the required disk mounted at `/var/lib/mysql`.
4. In Render, create a new Blueprint from this repository's `render.yaml`.
5. When prompted, provide the MySQL private hostname, database name, username, and password. The port is already set to `3306`.
6. Create the web service. Its startup script waits for MySQL, runs the migrations, inserts sample records only when the tables are empty, and starts Apache.
7. When the deploy becomes live, verify `/`, `/customers`, and `/users` from the assigned `onrender.com` URL.

The free Render web service spins down after 15 minutes without traffic. A persistent MySQL service and disk are paid resources.
