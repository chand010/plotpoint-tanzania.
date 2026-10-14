# Laravel foundation — PlotPoint Tanzania

This branch transitions the standalone HTML concept toward Laravel. The existing `index.html` prototype is intentionally preserved, and the live Vercel site is not changed by this branch.

## Stack

- Laravel 12 / PHP 8.2+
- Blade server-rendered pages
- PostgreSQL for marketplace records
- Cloudflare R2 for object storage (S3-compatible, configured private by default)
- Leaflet + OpenStreetMap for map-first discovery
- Tailwind CSS 4 / Vite entrypoints

## Implemented on this branch

- Public property search and detail pages with validated keyword, region, district, type, and price filters.
- Public listing visibility gates: published status, verified seller, reviewed property, and recorded advertising permission.
- Session-based registration, login, logout, login throttling, and session regeneration.
- Authenticated seller workspace and property submission form.
- Submitted properties are saved as private drafts; sellers cannot set verification flags or publish a listing from the public form.
- Basic feature tests for public visibility gates and seller draft submission.
- GitHub Actions workflow for Composer install, frontend build, and Laravel tests.

## Local setup

1. Install PHP 8.2+, Composer, PostgreSQL, Node.js, and npm.
2. Run `composer install`.
3. Copy `.env.example` to `.env`.
4. Set `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` for a local PostgreSQL database.
5. Run `php artisan key:generate`.
6. Run `php artisan migrate`.
7. Run `npm install && npm run build`.
8. Run `php artisan test`, then `php artisan serve`.

**Validation status:** the GitHub branch has not yet been executed in a local PHP/Node environment. The CI workflow is configured but has not been confirmed passing. Do not merge or deploy until dependency installation, migrations, asset compilation, and tests succeed.

## Cloudflare R2 setup

1. Create an R2 bucket in Cloudflare.
2. Create a bucket-scoped R2 API token with only the required permissions.
3. Set `R2_ACCESS_KEY_ID`, `R2_SECRET_ACCESS_KEY`, `R2_BUCKET`, and `R2_ENDPOINT` in local environment or hosting secrets.
4. Keep legal/title/survey documents private. Authorize each access and prefer short-lived signed URLs.
5. Never put R2 credentials in Blade templates, JavaScript, the browser, Git, or this documentation.

The R2 disk uses Laravel's S3-compatible Flysystem adapter. No real upload endpoint is implemented yet, and no credentials belong in the repository.

## Data and publication safeguards

- `properties`: seller, location, plot details, price, status, and separate seller/property review flags.
- `property_media`: object key and file metadata; file bytes should live in R2.
- A public seller submission creates a private draft only. There is no admin review dashboard or seller identity verification workflow yet.
- The authority-to-advertise checkbox is a seller attestation, not independent proof of authority.
- A map marker is not proof of title, ownership, survey boundaries, or legal advertising authority. Verify documents independently before payment.
- Never publish fictional demo content as real inventory.

## Still to implement

- Admin-only review dashboard, audit trail, and a safe way to record separate seller and property verification.
- Secure R2 upload service: file allowlist, strict byte limits, randomized object keys, image re-encoding, malware scanning where available, and authorized private document delivery.
- Public photo rendering separated from private legal documents.
- Seller editing/deletion workflow, enquiries, email verification and password reset.
- Full PostgreSQL integration tests, CI verification, deployment, backups, and production monitoring.
