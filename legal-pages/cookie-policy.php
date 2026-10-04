<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/cards.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';

head([
    'title'       => 'Cookie Policy — Tracking & Browser Storage | ' . SITE_NAME,
    'description' => 'Understand how Homeosphere utilizes essential cookies and browser storage to optimize performance, remember preferences, and ensure account security.',
    'keywords'    => 'homeosphere cookie policy, browser storage, tracking technologies, cookie preferences India',
    'canonical'   => '/cookie-policy',
]);
header_partial();
?>

<section class="page-head">
  <div class="container-x">
    <p class="breadcrumb"><a href="<?= url('/') ?>">Home</a><span class="sep">/</span><a href="#">Legal</a><span class="sep">/</span>Cookie Policy</p>
    <p class="eyebrow" style="color:var(--gold-500);"><?= icon('sparkles', 14) ?> Legal &amp; Compliance</p>
    <h1>Cookie Policy</h1>
    <p>How Homeosphere uses lightweight cookies and storage technologies to keep your sessions fast and secure.</p>
    <div style="display:flex;gap:1.25rem;align-items:center;flex-wrap:wrap;margin-top:1.25rem;font-size:0.85rem;color:var(--gold-400);">
      <span style="display:inline-flex;align-items:center;gap:0.35rem;"><?= icon('check', 14) ?> Transparent Privacy</span>
      <span>•</span>
      <span>Effective Date: September 02, 2026</span>
      <span>•</span>
      <span>Privacy-First &amp; AdSense Compliant</span>
    </div>
  </div>
</section>

<section class="section" style="padding: 3.5rem 0;">
  <div class="container-x">
    <div class="legal-layout">
      
      <!-- Sticky Sidebar -->
      <?= legal_sidebar('cookies') ?>

      <!-- Document Content -->
      <main class="legal-card">
        <p class="legal-lead">
          This Cookie Policy explains how <strong>Homeosphere</strong> employs cookies, local browser storage tokens, and related web technologies to authenticate user sessions, retain property search filters, and safeguard interactive features across our website and mobile portals.
        </p>

        <h2><?= icon('sparkles', 18) ?> 1. What Are Cookies?</h2>
        <p>Cookies are compact text files stored on your computer or mobile device when you access websites. They enable platforms to remember your actions, preserve active logins, and record interface preferences over time so you don't have to re-enter them on subsequent visits.</p>

        <h2><?= icon('grid', 18) ?> 2. Categories of Cookies We Deploy</h2>
        <p>Homeosphere relies on performance-, service-, and publisher-focused cookies classified into the following essential categories:</p>
        <ul>
          <li><strong>Strictly Necessary / Authentication Cookies:</strong> Critical for core platform operations. They maintain secure authentication tokens when you log into your property dashboard, submit booking forms, or access landlord management consoles.</li>
          <li><strong>Preference &amp; Functionality Cookies:</strong> Remember your selected filters (such as chosen city, price range, Buy vs. Rent preferences, and Map View settings) across navigation sessions.</li>
          <li><strong>Security &amp; Fraud Prevention Cookies:</strong> Help detect abusive traffic, automated scraper bots, and repeated suspicious login attempts to protect owner listings and customer data.</li>
          <li><strong>Aggregated Performance Telemetry:</strong> Collect anonymized visit metrics and page load speeds to help our engineering team optimize platform performance and reduce latency.</li>
          <li><strong>Contextual Advertising Cookies:</strong> Deployed by verified partners such as Google AdSense to serve relevant non-intrusive advertisements based on previous visits to this or other websites.</li>
        </ul>

        <div class="legal-notice">
          <h4><?= icon('shield', 16) ?> Transparent Advertising Standards</h4>
          <p>We partner with reputable networks such as Google AdSense. Any advertising cookies placed are subject to Google's strict privacy framework and can be controlled or disabled directly via your browser or Google Ads Settings.</p>
        </div>

        <h2><?= icon('map', 18) ?> 3. Integrated Third-Party Web Services</h2>
        <p>Certain interactive tools on our platform leverage trusted external partners that may utilize essential technical cookies:</p>
        <ul>
          <li><strong>Google AdSense:</strong> Delivers contextual and display advertisements to support platform operations. Users may opt out of personalized ad targeting via <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener noreferrer" style="color:var(--gold-600);text-decoration:underline;">Google Ads Settings</a>.</li>
          <li><strong>Google Maps &amp; Leaflet Tiles:</strong> Used in the Properties and Contact sections to pinpoint property addresses and provide neighborhood navigation.</li>
          <li><strong>Encrypted Payment Gateways:</strong> Used to maintain secure session integrity during tokenized payment processing for service bookings and deposits.</li>
        </ul>

        <h2><?= icon('settings', 18) ?> 4. How You Can Control Cookies</h2>
        <p>You retain full control over how cookies are stored on your device. Most modern browsers allow you to manage, block, or delete cookies via their settings:</p>
        <ul>
          <li><strong>Google Chrome:</strong> Settings &gt; Privacy and Security &gt; Cookies and other site data.</li>
          <li><strong>Mozilla Firefox:</strong> Settings &gt; Privacy &amp; Security &gt; Cookies and Site Data.</li>
          <li><strong>Apple Safari:</strong> Preferences &gt; Privacy &gt; Manage Website Data.</li>
          <li><strong>Microsoft Edge:</strong> Settings &gt; Cookies and site permissions &gt; Manage and delete cookies.</li>
        </ul>
        <p style="font-size:0.875rem;color:var(--navy-500);font-style:italic;">Note: Disabling strictly necessary cookies may degrade certain core functions, such as keeping you signed in or preserving active property filters.</p>

        <div class="legal-contact-box">
          <div>
            <h4 style="font-size:1rem;font-weight:700;color:var(--navy-900);margin:0 0 0.25rem 0;">Questions about tracking technologies?</h4>
            <p style="font-size:0.875rem;color:var(--navy-600);margin:0;">Contact our technical privacy team for assistance.</p>
          </div>
          <a href="mailto:privacy@homeosphere.in" class="btn btn-primary btn-sm" style="flex-shrink:0;">Email Privacy Team ➔</a>
        </div>
      </main>

    </div>
  </div>
</section>

<?php
footer_partial();