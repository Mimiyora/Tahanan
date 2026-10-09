# Frontend Redesign Handoff

## Copy This Prompt Into the New Conversation

Redesign the complete frontend of this CodeIgniter 4 project. Read `PROJECT_FEATURE_OVERVIEW.md` first, then inspect the routes, controllers, views, stylesheet, JavaScript, and feature tests before editing.

The new design must be a modern, bright, and welcoming Coffee House website. Use warm natural-light coffee photography, warm ivory backgrounds, espresso brown, muted terracotta, and soft sage. Use serif typography throughout; do not use sans-serif fonts. Use an expressive serif for headings and a highly readable serif for body text, forms, tables, and navigation.

Unify the Tasks for Today and Coffee House sections into one consistent Tahanan Coffee House identity. The `/` route must remain the required Welcome page and must continue showing tasks scheduled for the current date. Present it as “Tahanan Today”: use a bright photographic hero, show the date and task progress above the fold, and place today’s tasks immediately below it. The activity requirements take priority over decorative marketing content.

Create a consistent application shell across every page. Public navigation should make Today, All Tasks, Coffee House, Story, Profile, and About easy to find. Authenticated management pages for Tasks, Customers, and Users should feel like part of the same brand rather than a separate application. Use a clear logged-in account state and accessible logout control.

Replace the current frontend comprehensively, including both layouts, every application view, `public/assets/css/app.css`, and `public/assets/js/app.js` where appropriate. Reuse backend behavior instead of rewriting working controllers and models unless a small backend adjustment is required to support the interface.

Use original/local image assets. Do not hotlink remote stock images. Generate or add suitable bright Coffee House photography for the hero and supporting sections, optimize it for the web, and include meaningful alternative text when the image conveys content.

Preserve every required and previously implemented feature listed below. Do not remove earlier Coffee House, customer, user, avatar, task, authentication, database, or deployment functionality.

The completed project must be deployable to Vercel. Treat the Vercel deployment as a required deliverable, not an optional future task. Verify the current Vercel PHP runtime requirements from authoritative documentation before choosing the deployment structure. Add the required Vercel entry point, routing configuration, production environment handling, and deployment documentation. Use an external production database and persistent external storage for uploaded avatars if the Vercel runtime does not provide durable local storage. Do not commit credentials or production secrets.

After implementation, run the complete test suite, update only copy-sensitive test assertions when the redesigned wording intentionally changes, lint the PHP files, and manually verify guest and authenticated flows at desktop and mobile widths. Keep the working tree free of generated QA artifacts.

## Agreed Visual Direction

- Bright and welcoming rather than dark or moody.
- Modern premium Coffee House presentation.
- Natural light, warm wood, ceramic cups, and subtle Philippine coffee character.
- Warm ivory, espresso, terracotta, and sage palette.
- Serif typography only.
- Photography-led hero and supporting visual sections.
- Clean contemporary spacing without oversized empty areas.
- Consistent components across public and management pages.
- Subtle motion with reduced-motion support.
- Strong keyboard focus, contrast, labels, and responsive behavior.

## Required Feature Preservation Checklist

### Public Routes

- [ ] `/` remains the Welcome page and displays only today's active tasks.
- [ ] `/tasks` displays all active tasks ordered by date.
- [ ] `/profile` displays the public demo profile.
- [ ] `/about` identifies the system, developer, and course.
- [ ] `/coffeehouse` remains available.
- [ ] `/coffeehouse/about` retains the Coffee House story.
- [ ] `/coffeehouse/team` retains the legacy team directory.
- [ ] `/login` remains publicly available.

### Task Features

- [ ] Today's task count and completion progress remain visible.
- [ ] Task statuses remain Pending, In progress, and Completed.
- [ ] The complete task list retains client-side search.
- [ ] Guests can read tasks but cannot manage them.
- [ ] Authenticated users can create tasks.
- [ ] Required title and task-date validation remains intact.
- [ ] Validation errors and previously entered values remain visible.
- [ ] Authenticated users can open pre-filled edit forms.
- [ ] Authenticated users can update tasks.
- [ ] Authenticated users can archive tasks.
- [ ] Archiving remains a POST action and soft deletion.
- [ ] Archived tasks remain excluded from public task pages.

### Authentication Features

- [ ] Invalid credentials display a safe generic error.
- [ ] Successful login establishes the existing session fields.
- [ ] Protected routes redirect guests to login.
- [ ] Login returns users to the protected GET page they requested.
- [ ] Logout remains a POST action and destroys the session.
- [ ] Guest and authenticated navigation states are clearly different.

### Customer Features

- [ ] Customer directory remains protected.
- [ ] Customer search remains available.
- [ ] Customer creation remains available.
- [ ] Customer editing and updating remain available.
- [ ] Name and email validation remains intact.
- [ ] Optional phone number remains supported.
- [ ] Success, validation, and empty-search states are redesigned.

### User and Avatar Features

- [ ] User directory remains protected.
- [ ] User search remains available.
- [ ] User creation remains available.
- [ ] Unique username validation remains intact.
- [ ] Password creation and optional password replacement remain intact.
- [ ] Password fields are never pre-filled.
- [ ] Avatar upload remains available on user edit.
- [ ] JPG and PNG validation and the 2 MB limit remain intact.
- [ ] Prepared avatars and the fallback placeholder remain visible.
- [ ] User forms retain `multipart/form-data`.

### Preserved Earlier Features

- [ ] Coffee House landing and story content remain accessible.
- [ ] Six-record legacy staff directory remains separate from user accounts.
- [ ] Existing customer, user, staff, and task database tables remain unchanged unless required.
- [ ] Existing migrations, seeders, SQL export, uploads, and deployment configuration remain present.

### Vercel Deployment

- [ ] Verify current Vercel support and runtime requirements for CodeIgniter 4 and PHP.
- [ ] Add and test the required Vercel function entry point.
- [ ] Add `vercel.json` or the current equivalent routing/build configuration.
- [ ] Route application requests through CodeIgniter while allowing static assets to be served directly.
- [ ] Set the production base URL correctly from Vercel environment information.
- [ ] Use a production MySQL-compatible database that Vercel can reach.
- [ ] Document all required database environment variables.
- [ ] Keep database credentials and application secrets out of Git.
- [ ] Ensure CodeIgniter cache, logs, and session handling work in a serverless environment.
- [ ] Do not rely on the deployment filesystem for permanent avatar storage.
- [ ] Configure persistent external object storage for production avatar uploads, or clearly implement an approved persistent alternative.
- [ ] Preserve local development with the existing local database and upload workflow.
- [ ] Document how to run migrations and seed only the intended production data.
- [ ] Verify public pages, authentication, protected actions, database writes, and static assets on the deployed site.
- [ ] Add the final Vercel URL to the README and submission document after deployment succeeds.

## Frontend Contracts

- Preserve route URLs and form actions.
- Preserve form methods and input names.
- Preserve `csrf_field()` in state-changing forms.
- Preserve `old()` values and field-specific validation messages.
- Preserve flash success and error messages.
- Preserve session-based guest/authenticated conditionals.
- Preserve `pending`, `in_progress`, and `completed` values.
- Preserve `data-table-search` behavior or replace it with equivalent tested behavior.
- Preserve semantic labels, alert roles, progress information, and keyboard navigation.
- Do not turn archive or logout into unprotected GET links.

## Suggested Unified Navigation

### Public

- Today
- All Tasks
- Coffee House
- Our Story
- Profile
- About
- Log In

### Authenticated Management

- New Task
- Customers
- Users
- Legacy Team
- Account or user menu
- Log Out

Management links may be grouped in a desktop menu or account panel, but they must remain obvious and accessible on mobile.

## Recommended Verification

- Run `php -d extension=sqlite3 vendor/bin/phpunit`.
- Run PHP syntax checks on application and test files.
- Verify guest access to every public route.
- Verify protected-route redirects while logged out.
- Verify login and logout.
- Verify task create, validation, edit, update, and archive.
- Verify customer create, validation, and edit.
- Verify user create, validation, password handling, and avatar upload.
- Verify search empty states.
- Check approximately 1440 px, 768 px, and 390 px viewport widths.
- Check keyboard navigation, focus visibility, contrast, and reduced motion.

## Vercel Deployment Requirements

The repository currently mentions Vercel as the intended target but does not contain the required Vercel function entry point or routing configuration. The redesign task must finish that deployment work.

At minimum, the implementation should address:

- PHP/CodeIgniter request bootstrapping in Vercel Functions.
- Rewrites from dynamic routes to the CodeIgniter entry point.
- Direct serving of CSS, JavaScript, images, and other public assets.
- Production `baseURL` detection.
- External MySQL connection variables such as `MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, and `MYSQLPASSWORD`.
- Secure application environment variables and encryption/session configuration.
- Serverless-compatible sessions, caching, and logging.
- Persistent storage for user avatars instead of relying on `public/uploads/avatars` inside the deployment filesystem.
- A documented migration and seeding process.
- A deployment checklist and rollback notes in the README.

Do not remove the existing Docker, Render, or Railway files while adding Vercel support. They are preserved project capabilities even though Vercel is the selected deployment target.

## Existing Reference

The detailed current feature inventory is in `PROJECT_FEATURE_OVERVIEW.md` at the repository root.
