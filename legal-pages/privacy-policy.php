<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/cards.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';

head([
    'title'       => 'Privacy Policy — Data Protection & Privacy | ' . SITE_NAME,
    'description' => 'Learn how Homeosphere collects, encrypts, and safeguards your personal information and privacy rights across our real estate & home services platform.',
    'keywords'    => 'homeosphere privacy policy, data protection, privacy rights, real estate security, user data protection India',
    'canonical'   => '/privacy-policy',
]);
header_partial();
?>

<section class="page-head">
  <div class="container-x">
    <p class="breadcrumb"><a href="<?= url('/') ?>">Home</a><span class="sep">/</span><a href="#">Legal</a><span class="sep">/</span>Privacy Policy</p>
    <p class="eyebrow" style="color:var(--gold-500);"><?= icon('shield', 14) ?> Legal &amp; Compliance</p>
    <h1>Privacy Policy</h1>
    <p>How Homeosphere collects, protects, and respects your personal information across our home ecosystem.</p>
    <div style="display:flex;gap:1.25rem;align-items:center;flex-wrap:wrap;margin-top:1.25rem;font-size:0.85rem;color:var(--gold-400);">
      <span style="display:inline-flex;align-items:center;gap:0.35rem;"><?= icon('lock', 14) ?> 256-Bit SSL Encrypted</span>
      <span>•</span>
      <span>Effective Date: September 02, 2026</span>
      <span>•</span>
      <span>Applicable Law: IT Act 2000, India</span>
    </div>
  </div>
</section>

<section class="section" style="padding: 3.5rem 0;">
  <div class="container-x">
    <div class="legal-layout">
      
      <!-- Sticky Sidebar -->
      <?= legal_sidebar('privacy') ?>

      <!-- Document Content -->
      <main class="legal-card">
        <p class="legal-lead">
          At <strong>Homeosphere</strong> ("we", "our", or "us"), we consider the privacy and trust of our users paramount. This Privacy Policy details the types of personal data we collect across our property marketplace, service booking portal, and landlord dashboard, how it is safeguarded, and your statutory rights regarding your information.
        </p>

        <h2><?= icon('sparkles', 18) ?> 1. Information We Collect</h2>
        <p>We only collect data strictly necessary to deliver transparent real estate discovery, verified professional hiring, and secure property management services:</p>
        <ul>
          <li><strong>Personal Identity &amp; Contact:</strong> Full legal name, verified mobile phone number, email address, and residence location provided during account creation or property inquiry submissions.</li>
          <li><strong>Property &amp; Transaction Details:</strong> Property specs, physical addresses, leasing terms, maintenance work orders, automated rent ledgers, and transaction records.</li>
          <li><strong>Identity &amp; Professional Verification:</strong> Government-issued identity credentials (Aadhaar/PAN/GSTIN where applicable) submitted by background-verified service professionals and property owners for platform accreditation.</li>
          <li><strong>Technical &amp; Telemetry Data:</strong> IP address, device identifier, browser profile, approximate geolocation, and navigation logs collected via secure session tokens.</li>
        </ul>

        <h2><?= icon('shield', 18) ?> 2. How We Utilize Your Data</h2>
        <p>Your information is utilized solely for lawful platform operations and personalized user experiences:</p>
        <ul>
          <li>Connecting prospective buyers and tenants with verified property owners and certified developers.</li>
          <li>Scheduling and dispatching verified service professionals (plumbers, electricians, painters, architects) to your service address.</li>
          <li>Facilitating automated rent tracking, digital lease management, and instant maintenance notifications for property owners.</li>
          <li>Preventing fraudulent listings, unsolicited spam, and unauthorized account access via automated anomaly detection.</li>
          <li>Complying with statutory reporting requirements under the Real Estate (Regulation and Development) Act (RERA) and Indian IT Rules.</li>
        </ul>

        <div class="legal-notice">
          <h4><?= icon('check', 16) ?> Zero Data Sale Guarantee</h4>
          <p>Homeosphere does <strong>not</strong> sell, rent, monetize, or trade your personal contact information to third-party telemarketers, lead aggregators, or unauthorized advertising brokers under any circumstances.</p>
        </div>

        <h2><?= icon('lock', 18) ?> 3. Data Storage &amp; Security Measures</h2>
        <p>We employ enterprise-grade security protocols to prevent unauthorized access, alteration, or disclosure of your data:</p>
        <ul>
          <li><strong>Encryption Standards:</strong> All data in transit is encrypted using TLS 1.3 cryptographic protocols with modern 256-bit AES encryption at rest.</li>
          <li><strong>Strict Role-Based Access:</strong> Only authorized platform personnel with signed non-disclosure obligations have restricted access to sensitive user records.</li>
          <li><strong>Domestic Data Residency:</strong> User and property records are hosted exclusively within secure Tier-4 data centers physically located within India in accordance with national data residency regulations.</li>
        </ul>

        <h2><?= icon('users', 18) ?> 4. Data Sharing &amp; Third-Party Disclosures</h2>
        <p>We only share essential information with verified third parties under strict contractual data protection mandates:</p>
        <ul>
          <li><strong>Matched Service Professionals:</strong> When you book a home service, your name, contact phone, and service address are shared exclusively with the assigned background-checked professional.</li>
          <li><strong>Licensed Escrow &amp; Payment Gateways:</strong> Payment processing is handled via RBI-authorized payment aggregators; Homeosphere never stores raw credit card CVVs or net banking passwords.</li>
          <li><strong>Statutory Authorities:</strong> If required by court summons, law enforcement subpoena, or legitimate statutory obligations.</li>
        </ul>

        <h2><?= icon('target', 18) ?> 5. Advertising &amp; Third-Party Cookies (Google AdSense Compliance)</h2>
        <p>To support high-quality free market research and digital tools, Homeosphere may display non-intrusive advertisements served by third-party advertising partners, including <strong>Google AdSense</strong>:</p>
        <ul>
          <li><strong>Third-Party Vendors &amp; Google:</strong> Third-party vendors, including Google, use cookies to serve ads based on your prior visits to this website or other websites on the Internet.</li>
          <li><strong>Google Advertising Cookies (DART Cookies):</strong> Google's use of advertising cookies enables it and its partners to serve relevant advertisements to users based on their browsing visits to Homeosphere and other properties across the web.</li>
          <li><strong>Personalized Ads Opt-Out:</strong> You can opt out of personalized advertising at any time by visiting <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener noreferrer" style="color:var(--gold-600);text-decoration:underline;">Google Ads Settings</a>. Alternatively, you can opt out of third-party vendors' use of cookies for personalized advertising by visiting <a href="https://www.aboutads.info" target="_blank" rel="noopener noreferrer" style="color:var(--gold-600);text-decoration:underline;">www.aboutads.info</a>.</li>
        </ul>

        <h2><?= icon('target', 18) ?> 6. Your Rights &amp; Data Control</h2>
        <p>You maintain full sovereignty over your personal data on Homeosphere:</p>
        <ul>
          <li><strong>Right to Review &amp; Rectify:</strong> Inspect and modify your profile details, property listings, or contact preferences directly from your account settings.</li>
          <li><strong>Right to Data Erasure:</strong> Request permanent deletion of your account and associated personal identifiers by contacting our privacy desk.</li>
          <li><strong>Marketing Opt-Out:</strong> Unsubscribe from non-transactional newsletters or promotional updates at any time with a single click.</li>
        </ul>

        <div class="legal-contact-box">
          <div>
            <h4 style="font-size:1rem;font-weight:700;color:var(--navy-900);margin:0 0 0.25rem 0;">Questions about our Privacy Policy?</h4>
            <p style="font-size:0.875rem;color:var(--navy-600);margin:0;">Our dedicated Compliance and Data Protection team is here to assist you.</p>
          </div>
          <a href="<?= url('/pages/contact.php') ?>" class="btn btn-primary btn-sm" style="flex-shrink:0;">Contact Compliance ➔</a>
        </div>
      </main>

    </div>
  </div>
</section>

<?php
footer_partial();