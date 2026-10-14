# PlotPoint Tanzania — Initial Architecture

**Status:** Proposed architecture. Not yet implemented or security-tested.

## Decisions

- **Application:** Laravel with Blade templates and Tailwind CSS.
- **Database:** PostgreSQL.
- **Object storage:** Amazon S3 for property images, seller/property documents, and other uploaded resources.
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

## S3 upload flow

1. An authenticated user asks the Laravel backend to upload a file and identifies the intended property/resource.
2. Laravel checks the user's role, ownership, listing state, allowed file type, and maximum permitted size.
3. Laravel creates a random, non-user-controlled object key and returns a short-lived presigned upload URL for that specific object, or accepts the file through the backend where that is more appropriate.
4. The client uploads to S3 without ever receiving AWS access keys.
5. Laravel verifies the resulting object metadata and records it in PostgreSQL. Where configured, the object remains quarantined until malware/content checks finish.
6. Only approved public listing media may be delivered publicly through a controlled public-media path or CDN. Verification documents remain private and are delivered only after server-side authorization, using short-lived download URLs when needed.

## S3 security baseline

- Block public access at bucket level by default.
- Keep identity/verification documents in a private bucket; ideally separate them from public listing media by bucket or strict prefixes and policies.
- Use least-privilege IAM permissions limited to the required buckets/prefixes and operations.
- Prefer temporary credentials/role-based access where the hosting provider supports it; otherwise keep access keys in the hosting secret manager, never in Git.
- Use server-generated object keys; do not trust uploaded filenames or client-supplied content types.
- Enforce file size limits and allowlists; validate file signatures where practical.
- Configure encryption at rest, HTTPS-only access, logging, retention/lifecycle rules, and cost/budget alerts.
- Avoid logging file contents, credentials, private document URLs, or sensitive personal data.
- Consider malware scanning and image re-encoding before public publication.
- Do not treat a successful upload or seller approval as proof of property ownership.

## Configuration

Expected environment configuration will be documented when the Laravel app is scaffolded. Names will likely include AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, AWS_DEFAULT_REGION, AWS_BUCKET, and optionally AWS_ENDPOINT for an S3-compatible provider. Actual secrets must only be stored in local ignored .env files or the hosting secret manager. Never place values in this document or source control.

## Cost and deployment notes

S3 storage, requests, retrieval, and data transfer can incur charges. Use upload caps, image resizing, lifecycle policies, and budget alerts. Before launch, select the hosting region and storage region deliberately and test backup/restore and access controls.

The existing static Vercel prototype is not the Laravel application. Do not claim the new stack is live until the backend, database, storage policies, and deployment have actually been configured and tested.
