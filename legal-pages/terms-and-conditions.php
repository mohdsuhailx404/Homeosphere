<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/cards.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';

head([
    'title'       => 'Terms & Conditions — Platform Rules & Policies | ' . SITE_NAME,
    'description' => 'Review the official terms and conditions governing property listings, verified professional services, and user accounts on Homeosphere.',
    'keywords'    => 'homeosphere terms and conditions, terms of service, real estate platform rules, user agreements India',
    'canonical'   => '/terms-and-conditions',
]);
header_partial();
?>

<section class="page-head">
  <div class="container-x">
    <p class="breadcrumb"><a href="<?= url('/') ?>">Home</a><span class="sep">/</span><a href="#">Legal</a><span class="sep">/</span>Terms &amp; Conditions</p>
    <p class="eyebrow" style="color:var(--gold-500);"><?= icon('tag', 14) ?> Legal &amp; Compliance</p>
    <h1>Terms &amp; Conditions</h1>
    <p>The rules, obligations, and standards that guide every transaction and service on Homeosphere.</p>
    <div style="display:flex;gap:1.25rem;align-items:center;flex-wrap:wrap;margin-top:1.25rem;font-size:0.85rem;color:var(--gold-400);">
      <span style="display:inline-flex;align-items:center;gap:0.35rem;"><?= icon('shield', 14) ?> Enforceable Agreement</span>
      <span>•</span>
      <span>Effective Date: September 02, 2026</span>
      <span>•</span>
      <span>Jurisdiction: Gurugram, Haryana</span>
    </div>
  </div>
</section>

<section class="section" style="padding: 3.5rem 0;">
  <div class="container-x">
    <div class="legal-layout">
      
      <!-- Sticky Sidebar -->
      <?= legal_sidebar('terms') ?>

      <!-- Document Content -->
      <main class="legal-card">
        <p class="legal-lead">
          Welcome to <strong>Homeosphere</strong>. By accessing our website, mobile interface, or associated APIs, you enter into a legally binding agreement with Homeosphere Technologies Pvt. Ltd. governing property discovery, home maintenance bookings, professional onboarding, and landlord operations.
        </p>

        <h2><?= icon('check', 18) ?> 1. Acceptance of Terms &amp; Eligibility</h2>
        <p>By creating an account or browsing Homeosphere, you represent that you are at least 18 years of age and possess full legal capacity to enter into binding agreements under Indian law. If you represent an organization or property firm, you confirm authorization to bind that entity.</p>

        <h2><?= icon('user', 18) ?> 2. User Accounts &amp; Credential Security</h2>
        <p>To access personalized services, save properties, or book verified professionals, you must establish an account:</p>
        <ul>
          <li><strong>Accuracy of Information:</strong> You agree to provide true, accurate, and up-to-date identification details during registration.</li>
          <li><strong>Account Safeguarding:</strong> You are responsible for preserving credential confidentiality and immediately notifying Homeosphere of any suspected breach.</li>
          <li><strong>One Identity per User:</strong> Creating duplicate or misleading profiles to circumvent suspensions or artificially manipulate ratings is strictly prohibited.</li>
        </ul>

        <h2><?= icon('building', 18) ?> 3. Property Listings &amp; Intermediary Obligations</h2>
        <p>Homeosphere functions as an advanced digital intermediary connecting verified sellers, buyers, landlords, and tenants:</p>
        <ul>
          <li><strong>Seller &amp; Landlord Commitments:</strong> Property owners warrant that listed homes possess clear, unencumbered titles, valid municipal approvals, and compliant documentation under RERA guidelines.</li>
          <li><strong>Independent Buyer Verification:</strong> Prospective buyers and renters acknowledge that physical site inspections and legal encumbrance checks remain the user's ultimate responsibility prior to monetary disbursements.</li>
          <li><strong>Platform Moderation:</strong> Homeosphere reserves the right to unpublish, flag, or remove listings exhibiting inaccurate pricing, misleading imagery, or unresolved ownership disputes.</li>
        </ul>

        <div class="legal-notice">
          <h4><?= icon('shield', 16) ?> RERA Statutory Compliance</h4>
          <p>All commercial promotional listings for projects under construction display authentic state RERA registration IDs. Users are encouraged to verify project filings on respective state RERA portals.</p>
        </div>

        <h2><?= icon('wrench', 18) ?> 4. Home Services &amp; Professional Network</h2>
        <p>When booking home professionals (contractors, electricians, plumbers, interior designers):</p>
        <ul>
          <li><strong>Background Verification:</strong> Homeosphere screens identity proofs, professional credentials, and police verification for onboarding service specialists.</li>
          <li><strong>Scope of Work &amp; Pricing:</strong> Initial job estimates are transparently provided. Any major revisions required during execution must be agreed upon mutually prior to commencement.</li>
          <li><strong>Satisfaction Warranty:</strong> Selected standardized services include a 7-day Homeosphere Service Re-work Guarantee if deliverables fail agreed specifications.</li>
        </ul>

        <h2><?= icon('lock', 18) ?> 5. Financial Terms, Escrow &amp; Cancellations</h2>
        <p>All payments processed through our platform utilize encrypted, RBI-compliant payment gateways:</p>
        <ul>
          <li><strong>Subscription &amp; Listing Fees:</strong> Any premium listing packages or landlord dashboard subscriptions are billed as specified and are non-refundable once service periods begin.</li>
          <li><strong>Service Cancellation Policy:</strong> Bookings cancelled at least 2 hours prior to scheduled technician dispatch incur zero penalty. Late cancellations may incur a nominal transit charge.</li>
        </ul>

        <h2><?= icon('target', 18) ?> 6. Dispute Resolution &amp; Governing Law</h2>
        <p>These Terms are governed exclusively by the laws of the Republic of India. Any disputes arising out of platform usage shall be referred to arbitration in accordance with the Arbitration and Conciliation Act, 1996, with exclusive judicial jurisdiction vested in the competent courts of Gurugram, Haryana.</p>

        <div class="legal-contact-box">
          <div>
            <h4 style="font-size:1rem;font-weight:700;color:var(--navy-900);margin:0 0 0.25rem 0;">Need clarification regarding our terms?</h4>
            <p style="font-size:0.875rem;color:var(--navy-600);margin:0;">Reach out to our legal team or customer support advisors.</p>
          </div>
          <a href="<?= url('/pages/contact.php') ?>" class="btn btn-primary btn-sm" style="flex-shrink:0;">Contact Legal Desk ➔</a>
        </div>
      </main>

    </div>
  </div>
</section>

<?php
footer_partial();