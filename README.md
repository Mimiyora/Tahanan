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
- `/customers/new` — validated customer creation form
- `/customers/{id}/edit` — pre-filled customer update form
- `/users` — editable user-account directory with prepared avatars
- `/users/new` — validated user creation form with unique usernames
- `/users/{id}/edit` — pre-filled account and avatar update form
- `/coffeehouse/team` — preserved legacy coffeehouse team directory

The interface is responsive and includes task statuses, daily completion progress, mobile navigation, and client-side search on the full task list.

## Database design

The application implements the assignment schema through CodeIgniter migrations:

- `tasks`: `id`, `title`, `status`, `task_date`, `created_at`
- `users`: `id`, `username`, `full_name`, `email`, `avatar`, `created_at`
- `customers`: `id`, `full_name`, `email`, `phone`, `created_at`
- `staff_members`: `id`, `username`, `full_name`, `created_at`

`TaskSeeder` inserts ten records across five relative dates, including four records for the day the seeder runs. `UserSeeder` adds one demo user to a fresh database without deleting accounts created later. The coffeehouse’s six former team records remain separately in `staff_members`. The application timezone is `Asia/Manila`, so the dashboard and seeded “today” records use Philippine time.

## Forms, validation, and avatar upload

Customer and user create/edit actions use explicit GET and POST routes, controller-side validation, redirect-with-input behavior, and field-level error messages. Customer names and valid email addresses are required. Usernames are required, restricted to safe account characters, and enforced as unique at both the validation and database levels.

The user edit form accepts JPG and PNG profile pictures no larger than 2 MB. CodeIgniter verifies the upload, creates a centered 320 × 320 display image with its Image service, writes it to `public/uploads/avatars`, and stores only the generated filename in `users.avatar`. The listing uses the prepared image or a bundled placeholder. Uploaded files are intentionally excluded from Git.

The repository also includes a ready-to-import MySQL export at `database/tasks_for_today.sql`. It uses `CURDATE()` so imported sample data always includes the current date.

## Local setup

Requirements: PHP 8.2 or later with Fileinfo and GD enabled, Composer, and MySQL.

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
- `Customers` provides validated list, create, edit, and update actions through `CustomerModel`.
- `Users` provides validated account management and safe avatar preparation through `UserModel`.
- `Users::legacy()` retains the former six-record `staff_members` directory at `/coffeehouse/team`.
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
