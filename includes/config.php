<?php
/**
 * Homeosphere - site configuration.
 */

// Suppress deprecations and runtime warnings from printing onto HTML pages in production
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

const SITE_NAME     = 'Homeosphere';
const SITE_TAGLINE  = 'Everything Your Home Needs, Under One Digital Roof';
const SITE_URL      = 'https://testing.homeosphere.in';
const SITE_EMAIL    = 'hello@homeosphere.com';
const SITE_PHONE    = '+91 90000 00000';
const SITE_ADDRESS  = 'Cyber City, Gurugram, Haryana 122002, India';

// Google AdSense Publisher Account ID (leave blank until approved, e.g. 'ca-pub-XXXXXXXXXXXXXXXX')
const ADSENSE_PUB_ID = '';

// Supabase keys (read from environment, fall back to .env values for local dev)
const SUPABASE_URL  = 'https://0ec90b57d6e95fcbda19832f.supabase.co';
const SUPABASE_ANON = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...';

require_once __DIR__ . '/auth.php';

/** Build a relative site URL for internal navigation. */
function url(string $path = '/'): string {
    return '/' . ltrim($path, '/');
}

/** Build a fully-qualified absolute URL for SEO, Canonical, and Open Graph tags. */
function absolute_url(string $path = '/'): string {
    return rtrim(SITE_URL, '/') . '/' . ltrim($path, '/');
}


/** HTML-escape helper. */
function e($v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Asset URL helper with auto-cache busting. */
function asset(string $path): string {
    $clean = ltrim($path, '/');
    $filePath = __DIR__ . '/../assets/' . $clean;
    $v = file_exists($filePath) ? filemtime($filePath) : '2.0';
    return '/assets/' . $clean . '?v=' . $v;
}