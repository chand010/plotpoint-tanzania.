# PlotPoint Tanzania — Initial Architecture

**Status:** Proposed architecture. Not yet implemented or security-tested.

## Decisions

- **Application:** Laravel with Blade templates and Tailwind CSS.
- **Database:** PostgreSQL.
- **Object storage:** Cloudflare R2 for property images, seller/property documents, and other uploaded resources. Use its S3-compatible API with Laravel's filesystem adapter.
- **Maps:** Leaflet + OpenStreetMap.
- **Source control:** GitHub.
- **Hosting:** A Laravel-compatible application host plus managed PostgreSQL. Keep the current Vercel static prototype separate until the Laravel deployment is verified.

## Main application areas

1. Public property search, listing detail pages, and map browsing.
2. User accounts and role-aware authorization.
3. Seller profile and approval workflow.
4. Property listing submission, moderation, and status management.
5. Private document review and verification history.
6. Buyer enquiries and saved properties.
7. Administrative audit logs and operational settings.

## Initial relational entities

- users
- seller_profiles
- properties
- property_locations
- property_media (object key, media type, size, content type, uploader, visibility, scan/review status)
- property_documents (private object key, document type, uploader, review status, reviewer, timestamps)
- property_verifications
- enquiries
- favorites
- listing_plans
- payments (only when a payment provider is selected)
- audit_logs

Use foreign keys, constraints, appropriate indexes, and database transactions for related changes. Consider PostGIS only if distance/radius or advanced geospatial queries become a real requirement.

## Cloudflare R2 upload flow

1. An authenticated user asks the Laravel backend to upload a file and identifies the intended property/resource.
2. Laravel checks the user's role, ownership, listing state, allowed file type, and maximum permitted size.
3. Laravel creates a random, non-user-controlled object key and returns a short-lived presigned upload URL for that specific object, or accepts the file through the backend where that is more appropriate.
4. The client uploads to R2 without ever receiving R2 access keys.
5. Laravel verifies the resulting object metadata and records it in PostgreSQL. Where configured, the object remains quarantined until malware/content checks finish.
6. Only approved public listing media may be delivered through a controlled public-media path or CDN. Verification documents remain private and are delivered only after server-side authorization, using short-lived download URLs when needed.

## R2 security baseline

- Keep buckets private by default; enable public access only for intentionally public listing media if the delivery model requires it.
- Keep identity/verification documents private; ideally separate them from public listing media by bucket or strict prefixes and policies.
- Use scoped R2 API tokens with least-privilege access to the required bucket and operations.
- Keep R2 credentials in the hosting secret manager or ignored local .env file, never in Git or browser code.
- Use server-generated object keys; do not trust uploaded filenames or client-supplied content types.
- Enforce file size limits and allowlists; validate file signatures where practical.
- Use HTTPS, review logging and retention needs, configure lifecycle rules where appropriate, and set usage/budget alerts.
- Avoid logging file contents, credentials, private document URLs, or sensitive personal data.
- Consider malware scanning and image re-encoding before public publication.
- Do not treat a successful upload or seller approval as proof of property ownership.

## Configuration

When scaffolding Laravel, configure the S3-compatible filesystem disk with the R2 account endpoint, bucket name, region value required by the adapter, and R2 access credentials. Exact environment variable names will be recorded in the implementation setup guide. Never place real secrets in this document or source control.

## Cost and deployment notes

R2 has a free usage allowance, but storage, request volumes, and other service usage can exceed included limits. Confirm current pricing and terms before production, set upload caps and usage alerts, and optimize images. Before launch, choose the application/database hosting arrangement and test backup/restore and access controls.

The existing static Vercel prototype is not the Laravel application. Do not claim the new stack is live until the backend, database, storage policies, and deployment have actually been configured and tested.
