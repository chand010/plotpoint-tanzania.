# Laravel foundation — PlotPoint Tanzania

This branch starts the transition from the standalone HTML concept to Laravel. The existing `index.html` prototype is intentionally preserved. The live Vercel site is not changed by this branch.

## Stack

- Laravel 12 / PHP 8.2+
- Blade for server-rendered pages
- PostgreSQL for marketplace records
- Cloudflare R2 for private object storage (S3-compatible)
- Leaflet + OpenStreetMap for the future map interface
- Tailwind CSS/Vite can be added once the app's first local Composer install is available

## Local setup

1. Install PHP 8.2+, Composer, PostgreSQL, Node.js, and npm.
2. Run `composer install`.
3. Copy `.env.example` to `.env`.
4. Set `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` for a local PostgreSQL database.
5. Run `php artisan key:generate`.
6. Run `php artisan migrate`.
7. Run `php artisan serve` and open the local address shown by Artisan.

The starter files in this branch have not yet been installed with Composer or executed in a PHP environment. Run the install, migrations, and tests before merging or deploying.

## R2 setup

1. Create an R2 bucket in Cloudflare.
2. Create an R2 API token with only the permissions required for this bucket.
3. Set `R2_ACCESS_KEY_ID`, `R2_SECRET_ACCESS_KEY`, `R2_BUCKET`, and `R2_ENDPOINT` in the local `.env` or hosting secret manager.
4. Keep the bucket private by default. Deliver private documents only after authorization, preferably with short-lived signed URLs.
5. Never put R2 credentials in Blade templates, JavaScript, the browser, Git, or this documentation.

The R2 disk uses Laravel's S3-compatible Flysystem adapter. The credentials are intentionally blank in `.env.example`.

## Data model baseline

- `properties`: location, plot details, price, status, and separate seller/property review flags.
- `property_media`: object key and file metadata; the actual file bytes belong in R2.

A map marker is not proof of land title, ownership, survey boundaries, or legal advertising authority. Production listing publication must require documented review and explicit advertising permission. Seller verification and property verification are separate checks.

## Still to implement

- Complete standard Laravel config and generated files through Composer install.
- Authentication, authorization policies, seller/admin workflows, validation, rate limits, and audit logs.
- Property model, media model, listing CRUD, map and search endpoints.
- Secure upload service (allowlisted file types, byte limits, randomized object keys, image re-encoding, malware scanning where available).
- Public photo delivery strategy separated from private title/survey documents.
- Tests, CI, deployment, backups, and production error monitoring.
