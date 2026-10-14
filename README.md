# PlotPoint Tanzania

**Find Your Plot. Know Its Location. Make Your Move.**

PlotPoint Tanzania is a map-first real-estate discovery project, starting with plots and land in Kigamboni and intended to expand to farms, houses, apartments, and commercial property across Tanzania.

## Current status

The prototype is deployed at https://plotpoint-tanzania.vercel.app. It is a demo, not yet a production marketplace. Demo listings and map pins are illustrative; they do not establish property ownership, title, or surveyed boundaries.

The current prototype is a standalone HTML page. The production Laravel application, PostgreSQL database, authentication, Cloudflare R2 storage, and seller verification workflow are planned and not yet implemented or tested.

## Chosen architecture

- **Laravel + Blade + Tailwind CSS** for server-rendered pages and application logic.
- **PostgreSQL** for users, listings, locations, enquiries, verification records, and file metadata.
- **Cloudflare R2** for property images, uploaded documents, and other file resources. R2's S3-compatible API allows Laravel's S3 filesystem adapter to be used with R2 endpoint configuration.
- **Leaflet + OpenStreetMap** for maps.
- **GitHub** for source control.
- **Laravel-compatible hosting** for the application and a managed PostgreSQL database for production.

This replaces the earlier Next.js/Supabase and Amazon S3 proposals. Do not treat any planned component as implemented until configured and tested. Keep the current Vercel prototype online during the migration; do not create a duplicate project or claim that Laravel has been deployed until a real deployment is verified.

## Roadmap

1. Preserve and document the existing UI prototype.
2. Scaffold the Laravel application with environment-based configuration.
3. Configure PostgreSQL and migrations for users, properties, locations, media, documents, enquiries, and verification records.
4. Implement authentication, roles, policies, and seller onboarding.
5. Integrate Cloudflare R2 for uploads using private storage and short-lived presigned URLs where appropriate.
6. Build property search, listing pages, and the map-first browsing experience.
7. Add moderation, seller/property review workflows, and audit logs.
8. Test security, privacy, accessibility, mobile usability, backup/restore, and production deployment.

## Storage and security rules

- Never commit .env, cloud credentials, access keys, passwords, or signed URLs.
- Do not expose R2 access keys in browser code. Laravel authorizes uploads and issues narrowly scoped, short-lived presigned URLs where appropriate.
- Keep verification documents private. Grant access only to authorized users and reviewers.
- Validate file size, allowed file types, file signatures where practical, and ownership/authorization server-side. Generate safe object keys instead of trusting uploaded filenames.
- Do not allow arbitrary public writes or rely on client-provided MIME types alone.
- Consider malware scanning for uploaded documents and images before publication.
- Set upload size limits, retention/lifecycle rules, logging, and budget alerts. R2 has a free usage allowance but is not unlimited or guaranteed to remain entirely free.
- Seller verification is separate from property/document verification.

## Listing safeguards

Before publishing a real property, review the location, plot or survey-plan references where applicable, plot ID, size, price, availability, seller authority, written permission to advertise, and any referral or commission terms. A map pin does not prove title or surveyed boundaries.

## Architecture notes

See [docs/architecture.md](docs/architecture.md) for the initial design decisions and upload flow.
