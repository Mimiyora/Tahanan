# Tahanan Coffee House

Tahanan is a responsive CodeIgniter 4 coffee-house workspace that brings the public brand, today dashboard, task planning, customer records, user accounts, avatars, and staff authentication into one interface.

- Repository: [github.com/Mimiyora/Tahanan](https://github.com/Mimiyora/Tahanan)
- Developer: Gerard Doroja

## Experience and routes

The redesign uses a warm Filipino coffee-house direction: locally served Fraunces and Lora typography, bright natural-light photography, capiz-window geometry, rice-paper backgrounds, espresso structure, clay accents, and sage operational states. It remains usable with a keyboard, respects reduced-motion preferences, and adapts from wide desktop tables to compact mobile records.

Public routes:

- `/` — “Tahanan Today,” with the Manila date, completion progress, and only today’s active tasks
- `/tasks` — every active task in scheduled-date order, with client-side search
- `/profile` — the seeded user profile
- `/about` — project purpose, technology, course, and developer information
- `/coffeehouse` — the customer-facing Coffee House landing page
- `/coffeehouse/about` — the Coffee House story
- `/login` — staff authentication

Authenticated management routes:

- `/tasks/new` and `/tasks/{id}/edit` — create, update, and archive tasks
- `/customers`, `/customers/new`, and `/customers/{id}/edit` — customer records
- `/users`, `/users/new`, and `/users/{id}/edit` — user accounts and avatars
- `/coffeehouse/team` — the preserved legacy six-person staff directory

## Preserved application behavior

- The home query is limited to the current `Asia/Manila` date; the complete list includes every active date.
- Task status, progress, required-field validation, redirect-with-input behavior, and soft deletion remain intact.
- Protected routes remember the requested destination, require a valid session, and accept logout only through a CSRF-protected POST form.
- Customer email validation and user username uniqueness remain enforced.
- Passwords are hashed with `password_hash()` and checked with `password_verify()`.
- New avatars accept JPG or PNG files up to 2 MB. The browser prepares a centered 320 × 320 image before submission; the server validates the image and retains a server-side crop fallback where an image driver is available.
- In production, avatars are stored in Cloudinary and their secure URL plus Cloudinary public ID are saved in Railway MySQL. Local development falls back to `public/uploads/avatars` when `CLOUDINARY_URL` is not set.

The seeded demonstration login is:

- Username: `gerard.doroja`
- Password: `Tahanan123!`

Change or remove these credentials before using the application beyond a demonstration environment.

## Data model

CodeIgniter migrations manage:

- `tasks`: task content, status, schedule date, and archive state
- `users`: login, contact, avatar, and password data
- `customers`: customer contact records
- `staff_members`: the preserved legacy team

`DatabaseSeeder` inserts the complete demonstration dataset. `database/tasks_for_today.sql` remains available as a MySQL import and uses `CURDATE()` for current-day sample work.

## Local setup

Requirements: PHP 8.2+, Composer, Fileinfo, MySQLi, and an image extension supported by CodeIgniter for server-side avatar fallback. The automated suite additionally needs SQLite3.

1. Install dependencies.

   ```bash
   composer install
   ```

2. Copy `env` to `.env` and set the local base URL and database values. The supplied template targets a local MySQL database named `tahanan_tasks`; a SQLite `.env` can also be used for local development.

3. Create, migrate, and seed the database.

   ```bash
   php spark db:create tahanan_tasks
   php spark migrate --all
   php spark db:seed DatabaseSeeder
   ```

4. Start the site and open [http://localhost:8091](http://localhost:8091).

   ```bash
   php spark serve --port 8091
   ```

## Tests

The feature suite uses an isolated in-memory SQLite database. It covers public route content, date filtering, seeded records, authentication, protected task management, validation, archiving, and customer and user workflows.

```bash
composer test
```

When SQLite is installed but disabled in the CLI configuration, enable it for the command (for example, `php -d extension=sqlite3 vendor/bin/phpunit` on the bundled Windows setup).

## Production deployment

The production architecture is:

- GitHub stores the source and triggers deployments from the selected branch.
- Railway MySQL stores application records.
- Cloudinary stores uploaded avatars permanently. This avoids Render's ephemeral filesystem.
- Render builds the Docker image, applies pending CodeIgniter migrations at startup, and serves the site on the platform-provided port.

No credentials belong in Git. The committed `render.yaml` declares secret variables with `sync: false`, so Render asks for them when the Blueprint is created.

### 1. Create Railway MySQL

1. In Railway, create a project and select **New > Database > Add MySQL**.
2. Open the MySQL service, then go to **Settings > Networking**.
3. Under **Public Networking**, select **Add TCP Proxy**. Railway creates an externally reachable host and port.
4. Open the service's **Variables** tab and copy the value of `MYSQL_PUBLIC_URL`.
5. In Render, open the `tahanan` service, select **Environment**, and add `MYSQL_PUBLIC_URL` with the copied value. Remove the old `TIDB_*` variables after the Railway connection works.

The container runs `php spark migrate --all` before Apache starts, so the Railway database schema is created automatically. To add the demonstration records, run this once from a trusted machine configured with the same `MYSQL_PUBLIC_URL`:

```bash
php spark db:seed DatabaseSeeder
```

Do not seed a real production system unless the demonstration account and password are acceptable.

### 2. Create Cloudinary

1. Create or open a Cloudinary product environment.
2. Copy its `CLOUDINARY_URL` from the API keys page.
3. Add that value to Render as the secret `CLOUDINARY_URL`.

New production avatars are uploaded into `tahanan/avatars`. Replacing an avatar also removes the previous Cloudinary asset when its public ID is known.

### 3. Deploy on Render

1. Push this repository to GitHub.
2. In Render, select **New > Blueprint**, connect the GitHub repository, and use the root `render.yaml`.
3. Enter every variable marked `sync: false`, then deploy.
4. Confirm that `https://<service>.onrender.com/health` returns `{"status":"ok","database":"connected"}`.

The Blueprint uses Render's free web-service plan. Free services can spin down while idle, and their local filesystem is ephemeral; Railway MySQL and Cloudinary keep durable data outside the container. Railway's public TCP proxy also counts outbound database traffic toward Railway usage. For a paid Render plan, migrations may instead be moved from the Docker `CMD` to a Render pre-deploy command for cleaner zero-downtime releases.
