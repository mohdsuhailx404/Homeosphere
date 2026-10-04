<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/cards.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';

head([
    'title'       => 'Legal Disclaimer — Real Estate & Services Intermediary | ' . SITE_NAME,
    'description' => 'Important legal disclosures, marketplace intermediary notices, and due diligence guidelines for property transactions and home service bookings on Homeosphere.',
    'keywords'    => 'homeosphere disclaimer, real estate disclosures, intermediary notice, property due diligence India',
    'canonical'   => '/disclaimer',
]);
header_partial();
?>

<section class="page-head">
  <div class="container-x">
    <p class="breadcrumb"><a href="<?= url('/') ?>">Home</a><span class="sep">/</span><a href="#">Legal</a><span class="sep">/</span>Disclaimer</p>
    <p class="eyebrow" style="color:var(--gold-500);"><?= icon('building', 14) ?> Legal &amp; Compliance</p>
    <h1>Legal Disclaimer</h1>
    <p>Important disclosures regarding property listings, verified professionals, and marketplace platform services.</p>
    <div style="display:flex;gap:1.25rem;align-items:center;flex-wrap:wrap;margin-top:1.25rem;font-size:0.85rem;color:var(--gold-400);">
      <span style="display:inline-flex;align-items:center;gap:0.35rem;"><?= icon('shield', 14) ?> Intermediary Status: Section 79, IT Act</span>
      <span>•</span>
      <span>Effective Date: September 02, 2026</span>
    </div>
  </div>
</section>

<section class="section" style="padding: 3.5rem 0;">
  <div class="container-x">
    <div class="legal-layout">
      
      <!-- Sticky Sidebar -->
      <?= legal_sidebar('disclaimer') ?>

      <!-- Document Content -->
      <main class="legal-card">
        <p class="legal-lead">
          The information, listings, pricing estimates, and professional directory features provided by <strong>Homeosphere</strong> are provided on an "as is" and "as available" basis for general informational and marketplace facilitation purposes only.
        </p>

        <h2><?= icon('building', 18) ?> 1. Property Listings &amp; Specifications Disclaimer</h2>
        <p>All property listings, architectural renderings, carpet areas, pricing tags, and availability schedules presented on Homeosphere are submitted directly by registered property owners, certified builders, and authorized brokerage representatives:</p>
        <ul>
          <li><strong>No Guarantee of Unconditional Accuracy:</strong> While Homeosphere performs automated sanity checks and verification reviews, we do not warrant that all specifications, amenities, or floor plans are entirely free from third-party omissions or subsequent modifications.</li>
          <li><strong>Price Fluctuations:</strong> Property purchase values, monthly rentals, and maintenance fees are set by respective owners and are subject to market changes or independent negotiations without prior notice.</li>
        </ul>

        <div class="legal-notice">
          <h4><?= icon('shield', 16) ?> Buyer &amp; Tenant Due Diligence Advisory</h4>
          <p>Prospective property buyers, investors, and tenants are strongly advised to perform physical site visits, examine original title deeds, verify RERA filings, and retain independent legal counsel prior to signing agreements or disbursing advance deposits.</p>
        </div>

        <h2><?= icon('wrench', 18) ?> 2. Independent Professional Contractors</h2>
        <p>Homeosphere provides an onboarded directory of background-checked home service professionals (architects, contractors, plumbers, electricians, painters, and maintenance specialists):</p>
        <ul>
          <li><strong>Intermediary Marketplace Role:</strong> Homeosphere operates as an electronic intermediary under Section 79 of the Information Technology Act, 2000. Verified professionals operate as independent service providers and are not direct employees or legal agents of Homeosphere.</li>
          <li><strong>Contractual Relationship:</strong> The contract for actual service performance is executed between the service customer and the independent professional. While Homeosphere provides re-work dispute assistance on select services, we are not liable for direct on-site damages arising outside platform-agreed scopes.</li>
        </ul>

        <h2><?= icon('map', 18) ?> 3. Mapping, Geolocation &amp; Neighborhood Estimates</h2>
        <p>Map pins, satellite views, and neighborhood commute estimates utilize third-party geocoding providers (including Google Maps and OpenStreetMap / Leaflet):</p>
        <ul>
          <li>Pin coordinates represent approximate geographic landmarks or registered project sectors. Exact physical boundaries must be verified on site.</li>
          <li>Commute times, metro distances, and nearby facility indicators are dynamic estimates influenced by local municipal construction and traffic conditions.</li>
        </ul>

        <h2><?= icon('target', 18) ?> 4. Limitation of Liability</h2>
        <p>To the fullest extent permitted by applicable Indian law, Homeosphere Technologies Pvt. Ltd., its directors, officers, and employees shall not be liable for any indirect, incidental, punitive, or consequential damages arising from reliance on platform listings, user communication, or service execution.</p>

        <div class="legal-contact-box">
          <div>
            <h4 style="font-size:1rem;font-weight:700;color:var(--navy-900);margin:0 0 0.25rem 0;">Require formal compliance confirmation?</h4>
            <p style="font-size:0.875rem;color:var(--navy-600);margin:0;">Contact our legal and compliance department.</p>
          </div>
          <a href="<?= url('/pages/contact.php') ?>" class="btn btn-primary btn-sm" style="flex-shrink:0;">Contact Legal Desk ➔</a>
        </div>
      </main>

    </div>
  </div>
</section>

<?php
footer_partial();