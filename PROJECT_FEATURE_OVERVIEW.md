# Tahanan Project Feature Overview

## Project Summary

Tahanan is a server-rendered CodeIgniter 4 application containing two connected experiences:

1. Tasks for Today, a daily task-management system.
2. Tahanan Coffee House, a preserved customer and user account portal.

Both experiences share the same database, authentication session, stylesheet, JavaScript, and visual identity. The application uses PHP views rather than a JavaScript frontend framework.

## Tasks for Today

### Daily Dashboard

- Public route: `/`
- Displays tasks scheduled for the current date in the Asia/Manila timezone.
- Excludes archived tasks.
- Calculates how many tasks are complete.
- Displays a completion percentage and progress bar.
- Uses cards for Pending, In progress, and Completed tasks.
- Displays an empty state when no tasks are scheduled for the day.
- Shows an Add Task link when the visitor is authenticated.

### Complete Task List

- Public route: `/tasks`
- Displays all active tasks.
- Orders tasks by scheduled date and creation time.
- Includes client-side search across task titles, statuses, and dates.
- Displays task status, scheduled date, and creation date.
- Shows management controls only to authenticated users.

### Task Creation

- Protected route: `/tasks/new`
- Accepts a title, task date, and status.
- Requires the title and task date.
- Limits titles to 150 characters.
- Accepts only `pending`, `in_progress`, or `completed` status values.
- Preserves submitted values after failed validation.
- Displays a validation summary and field-level feedback.

### Task Editing

- Protected route: `/tasks/{id}/edit`
- Loads an existing active task into a pre-filled form.
- Applies the same validation rules used during creation.
- Updates the existing database record.

### Task Archiving

- Protected POST route: `/tasks/{id}/delete`
- Performs a soft deletion by setting `is_archived` to `1`.
- Does not permanently remove the database row.
- Removes archived tasks from the daily dashboard and complete task list.
- There is currently no archived-task history or restore interface.

## Authentication and Access Control

### Login

- Public routes: `GET /login` and `POST /login`
- Validates the username and password fields.
- Retrieves the account by username.
- Verifies the password against its stored hash.
- Regenerates the session ID after successful authentication.
- Stores the user ID, username, full name, and login state in the session.
- Displays a generic error for invalid credentials.
- Redirects an authenticated user to the protected GET page originally requested.

### Logout

- Protected POST route: `/logout`
- Destroys the current session.
- Redirects the user to the login page.

### Public Pages

The following pages remain available without authentication:

- `/`
- `/tasks`
- `/profile`
- `/about`
- `/coffeehouse`
- `/coffeehouse/about`
- `/coffeehouse/team`
- `/login`

### Protected Features

Authentication is required for:

- Creating, editing, updating, and archiving tasks.
- Viewing and managing customer accounts.
- Viewing and managing user accounts.
- Uploading user avatars.

The application currently has no roles or permission levels. Every authenticated account has access to all protected features.

## Customer Management

### Customer Directory

- Protected route: `/customers`
- Displays customers alphabetically by full name.
- Includes client-side search.
- Displays initials, name, email address, and phone number.
- Generates clickable email and telephone links.
- Provides New Customer and Edit actions.

### Customer Creation and Editing

- Protected routes: `/customers/new` and `/customers/{id}/edit`
- Requires a full name between 2 and 100 characters.
- Requires a valid email address.
- Accepts an optional phone number of up to 20 characters.
- Preserves input after validation failure.
- Displays validation summaries and field-level messages.
- There is currently no customer deletion feature.

## User Account Management

### User Directory

- Protected route: `/users`
- Displays managed user accounts alphabetically.
- Includes client-side search.
- Shows each user's avatar, name, username, and email address.
- Uses a placeholder image when no avatar exists.
- Links to the preserved legacy staff directory.

### User Creation

- Protected route: `/users/new`
- Requires a unique username.
- Restricts usernames to letters, numbers, periods, underscores, and hyphens.
- Requires a full name and valid email address.
- Requires a password between 8 and 72 characters.
- Hashes the password before database storage.
- Redirects to the edit page after creation so an avatar can be added.

### User Editing and Password Changes

- Protected route: `/users/{id}/edit`
- Pre-fills the username, name, and email address.
- Keeps the current password when the password field is empty.
- Hashes a replacement password when one is submitted.
- There is currently no user deletion feature.

### Avatar Upload

- Available from the user edit form.
- Accepts JPG and PNG files.
- Limits files to 2 MB.
- Verifies that the uploaded file is an image.
- Crops the image to a centered 320 by 320 square.
- Stores the prepared file under `public/uploads/avatars`.
- Stores only the generated filename in the database.
- Removes the previous avatar file after a successful replacement.

## Coffee House Portal

### Coffee House Home

- Public route: `/coffeehouse`
- Contains Coffee House branding and static store statistics.
- Links to customer accounts, user accounts, and the Coffee House story.
- Protected links redirect logged-out visitors to the login page.

### Coffee House Story

- Public route: `/coffeehouse/about`
- Contains static brand and business-story content.

### Legacy Team Directory

- Public route: `/coffeehouse/team`
- Displays the six preserved staff records from the earlier application.
- Includes client-side search.
- Uses initials-based avatars.
- Keeps legacy staff records separate from authenticated user accounts.

## Profile and Informational Pages

### Profile

- Public route: `/profile`
- Displays the first user record in the database.
- Shows initials, name, username, email address, creation date, and active status.
- It is a public demo profile, not necessarily the currently authenticated user's profile.

### Tasks About Page

- Public route: `/about`
- Explains the task system's purpose.
- Identifies CodeIgniter 4, MySQL, the developer, and the course.

## Database Structure

### Tasks

- `id`
- `title`
- `status`
- `task_date`
- `is_archived`
- `created_at`

### Users

- `id`
- `username`
- `full_name`
- `email`
- `avatar`
- `password`
- `created_at`

### Customers

- `id`
- `full_name`
- `email`
- `phone`
- `created_at`

### Legacy Staff Members

- `id`
- `username`
- `full_name`
- `created_at`

## Current Frontend Architecture

- Server-rendered PHP views.
- No Bootstrap, Tailwind, React, Vue, or frontend bundler.
- One shared stylesheet: `public/assets/css/app.css`.
- One small JavaScript file: `public/assets/js/app.js`.
- One layout for Tasks for Today.
- One layout for the Coffee House portal.
- Shared buttons, forms, tables, badges, alerts, avatars, headers, and footers.
- Responsive layouts at approximately 900, 720, and 480 pixels.
- Mobile navigation drawer.
- Client-side table filtering.
- Reduced-motion support.
- Semantic labels, tables, progress information, alerts, and screen-reader text.

## Existing Visual Style

- Warm cream background.
- Dark green, clay red, and gold accent colors.
- Serif display headings with sans-serif body text.
- Large editorial hero sections.
- Cards for dashboard content.
- Tables for account directories.
- Sticky descriptive columns beside forms.
- A separate identity for the Tasks and Coffee House layouts.

## Frontend Contracts to Preserve

A redesign should preserve the following behavior unless the backend is changed at the same time:

- Existing routes and form action URLs.
- POST methods for state-changing actions.
- Existing input names.
- `csrf_field()` calls.
- `multipart/form-data` on the avatar form.
- `old()` values after validation failures.
- Validation summaries and field-specific errors.
- Flash success and error messages.
- Guest and authenticated navigation states.
- Task status values.
- Soft-delete behavior.
- Accessible labels, focus states, and status messages.
- Table IDs and `data-table-search` attributes unless the JavaScript is updated.

The automated tests also assert some visible page text. If the redesign changes that copy, the corresponding test expectations must be updated.

## Current Limitations

- No task details page.
- No archived-task list or restore action.
- No customer deletion.
- No user deletion.
- No server-side pagination, sorting, or advanced filtering.
- No roles or granular permissions.
- No task ownership per user.
- No user registration or password-reset workflow.
- The public profile is not tied to the authenticated session.
- The archive confirmation uses the browser's default confirmation dialog.
- The two layouts duplicate some header and footer markup.

## Recommended Redesign Structure

A unified management interface could organize the application as follows:

### Workspace

- Today
- All Tasks

### Coffee House

- Customers
- User Accounts
- Legacy Team

### Information

- Profile
- About
- Coffee House Story

### Account

- Login or current-user menu
- Logout

The recommended visual direction is a modern productivity dashboard with subtle Filipino warmth. A desktop sidebar, compact top bar, and accessible mobile drawer would unify the two existing experiences without changing their backend behavior.

## Redesign Verification

After the frontend is replaced, verification should include:

- Guest and authenticated navigation states.
- Desktop, tablet, and mobile layouts.
- Task create, update, validation, and archive flows.
- Customer and user forms.
- Avatar upload and preview.
- Empty states and search results.
- Keyboard navigation and visible focus states.
- Existing automated feature tests.
- Updated copy-sensitive test assertions where necessary.
