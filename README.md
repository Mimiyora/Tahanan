# Tasks for Today Management System

A database-backed CodeIgniter 4 application for tracking daily work. The welcome page filters the shared `tasks` table to the current date, while the full task list displays every record in date order.

- GitHub repository: [github.com/Mimiyora/Tahanan](https://github.com/Mimiyora/Tahanan)
- Hosted application: [tahanan-pos.onrender.com](https://tahanan-pos.onrender.com)
- Developer: Gerard Doroja

## Required pages

- `/` — welcome dashboard showing only tasks scheduled for today
- `/tasks` — complete task list ordered by scheduled date
- `/profile` — profile for the single demo user
- `/about` — system purpose, technology, course, and developer information

The former Tahanan Coffee House portal remains available alongside the task system:

- `/coffeehouse` — original coffeehouse landing experience
- `/coffeehouse/about` — coffeehouse story
- `/customers` — customer account directory
- `/users` — coffeehouse team directory

The interface is responsive and includes task statuses, daily completion progress, mobile navigation, and client-side search on the full task list.

## Database design

The application implements the assignment schema through CodeIgniter migrations:

- `tasks`: `id`, `title`, `status`, `task_date`, `created_at`
- `users`: `id`, `username`, `full_name`, `email`, `created_at`
- `customers`: `id`, `full_name`, `email`, `phone`, `created_at`
- `staff_members`: `id`, `username`, `full_name`, `created_at`

`TaskSeeder` inserts ten records across five relative dates, including four records for the day the seeder runs. `UserSeeder` keeps exactly one demo user for the assignment profile. The coffeehouse’s six team accounts are stored separately in `staff_members`, preserving the single-record `users` requirement. The application timezone is `Asia/Manila`, so the dashboard and seeded “today” records use Philippine time.

The repository also includes a ready-to-import MySQL export at `database/tasks_for_today.sql`. It uses `CURDATE()` so imported sample data always includes the current date.

## Local setup

Requirements: PHP 8.2 or later, Composer, and MySQL.

1. Install dependencies:

   ```bash
   composer install
   ```

2. Copy `env` to `.env`. The template uses a local MySQL database named `tahanan_tasks` with the default XAMPP `root` account and a blank password. Update the credentials if your environment differs.

3. Create the database, run the migrations, and seed the records:

   ```bash
   php spark db:create tahanan_tasks
   php spark migrate
   php spark db:seed DatabaseSeeder
   ```

   Alternatively, import `database/tasks_for_today.sql` with phpMyAdmin or the MySQL command line.

4. Start the application:

   ```bash
   php spark serve --port 8091
   ```

5. Open [http://localhost:8091](http://localhost:8091).

## Application structure

- `Pages::home()` obtains the current Asia/Manila date and requests only matching records through `TaskModel::forDate()`.
- `Tasks::index()` retrieves all tasks through `TaskModel::ordered()`.
- `Profile::index()` retrieves the one demo record through `UserModel`.
- `Customers::index()` and `Users::index()` serve the retained coffeehouse directories through separate models and tables.
- Views share `app/Views/layouts/main.php` and keep presentation separate from data access.

## Automated tests

The feature suite uses an in-memory SQLite database, applies the project migrations and seeders, and verifies:

- the welcome page includes today’s records and excludes past and future tasks;
- the full task page includes all ten sample records;
- the profile displays exactly one database user;
- the About page identifies the developer; and
- the seed data spans at least three dates and contains at least eight tasks.

Run the suite with:

```bash
composer test
```

The PHP CLI used for testing must have the SQLite3 extension enabled.

## Deployment

The included `Dockerfile`, Apache configuration, `railway.toml`, and `render.yaml` support hosted deployment. At container startup, the application waits for the configured MySQL service, runs pending migrations, seeds any missing tasks, refreshes the single demo profile, and starts Apache on port `8080`.

For Railway, provide `MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, `MYSQLPASSWORD`, and `app_baseURL` as service variables. For Render, connect the repository Blueprint and supply the same MySQL values when prompted.
