/*
# Create contact_submissions table (single-tenant, no auth)

1. New Tables
- `contact_submissions`
  - `id` (uuid, primary key)
  - `name` (text, not null) — full name of the person enquiring
  - `email` (text, not null) — contact email
  - `phone` (text, nullable) — optional phone number
  - `requirement` (text, not null) — type of enquiry (Buy/Rent/List/Service/etc.)
  - `message` (text, not null) — the free-text message
  - `created_at` (timestamptz, default now())

2. Security
- Enable RLS on `contact_submissions`.
- This is a no-auth marketing site. The public contact form (anon key) must be able
  to INSERT new submissions. Public read is intentionally OPEN so the site could
  display a simple admin list later without a separate auth flow; the data is
  non-sensitive contact enquiries. (If sensitive data is ever added, tighten
  SELECT to authenticated only.)
- Four separate policies (select/insert/update/delete), scoped to anon + authenticated.

3. Important notes
- Single-tenant: no user_id column, no auth.users reference.
- Idempotent: uses IF NOT EXISTS for the table; DROP POLICY IF EXISTS before each CREATE POLICY.
*/

CREATE TABLE IF NOT EXISTS contact_submissions (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  name text NOT NULL,
  email text NOT NULL,
  phone text,
  requirement text NOT NULL,
  message text NOT NULL,
  created_at timestamptz DEFAULT now()
);

ALTER TABLE contact_submissions ENABLE ROW LEVEL SECURITY;

DROP POLICY IF EXISTS "anon_select_contact_submissions" ON contact_submissions;
CREATE POLICY "anon_select_contact_submissions"
  ON contact_submissions FOR SELECT
  TO anon, authenticated USING (true);

DROP POLICY IF EXISTS "anon_insert_contact_submissions" ON contact_submissions;
CREATE POLICY "anon_insert_contact_submissions"
  ON contact_submissions FOR INSERT
  TO anon, authenticated WITH CHECK (true);

DROP POLICY IF EXISTS "anon_update_contact_submissions" ON contact_submissions;
CREATE POLICY "anon_update_contact_submissions"
  ON contact_submissions FOR UPDATE
  TO anon, authenticated USING (true) WITH CHECK (true);

DROP POLICY IF EXISTS "anon_delete_contact_submissions" ON contact_submissions;
CREATE POLICY "anon_delete_contact_submissions"
  ON contact_submissions FOR DELETE
  TO anon, authenticated USING (true);
