<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';
require_once __DIR__ . '/../includes/cards.php';

head([
  'title'       => 'Contact Us — Get in Touch with Homeosphere Team',
  'description' => 'Whether you want to list a property, book a service, or explore partnerships, get in touch with the Homeosphere support team today for assistance.',
  'keywords'    => 'contact homeosphere, homeosphere support, customer service real estate, property management help, contact home services',
  'canonical'   => '/contact',
  'jsonld'      => [
      '@context'    => 'https://schema.org',
      '@type'       => 'ContactPage',
      'name'        => 'Contact Homeosphere',
      'url'         => url('/contact'),
      'description' => 'Get in touch with the Homeosphere support and customer assistance team.',
  ],
]);
header_partial('contact');
?>

<section class="page-head">
  <div class="container-x">
    <p class="breadcrumb"><a href="/">Home</a><span class="sep">/</span>Contact</p>
    <p class="eyebrow">Contact Us</p>
    <h1>Let's talk about your home</h1>
    <p>Whether you want to list a property, book a service, join as a professional, or explore a partnership — we're here to help.</p>
  </div>
</section>
<?php
$reqService = trim($_GET['service'] ?? '');
$reqPro     = trim($_GET['pro'] ?? '');
$reqRole    = trim($_GET['role'] ?? '');
$reqType    = trim($_GET['req'] ?? $_GET['requirement'] ?? '');

$defaultReq = 'Query';
$defaultMsg = '';

if ($reqService) {
  $defaultReq = 'Book a home service';
  $defaultMsg = "Hi, I would like to book the {$reqService} service. Please contact me with details and availability.";
} elseif ($reqPro) {
  $defaultReq = 'Contact a pro';
  $roleText   = $reqRole ? " ({$reqRole})" : '';
  $defaultMsg = "Hi, I would like to connect with and hire {$reqPro}{$roleText} for an upcoming project. Please get in touch with me regarding availability and quotation.";
} elseif ($reqType === 'contact_pro' || $reqType === 'hire_pro' || $reqType === 'pro') {
  $defaultReq = 'Contact a pro';
  $defaultMsg = "Hi, I would like to connect with a verified professional for my home project. Please help match me with available specialists in my area.";
} elseif ($reqType === 'post_job' || $reqType === 'postjob' || str_contains(strtolower($reqType), 'job')) {
  $defaultReq = 'Post a job';
  $defaultMsg = "Hi, I have a project/job requirement that I would like to post for verified professionals. Here are the job details, scope, and timeline:";
} elseif ($reqType === 'listing_support' || $reqType === 'property_listing_support' || $reqType === 'fraud' || $reqType === 'report' || str_contains(strtolower($reqType), 'support')) {
  $defaultReq = 'Property Listing Support';
  $defaultMsg = "Hi, I would like to report an issue / inaccurate information regarding a property listing on Homeosphere. Here is the property listing URL/ID and details of the issue:";
} elseif ($reqType === 'list_property' || $reqType === 'list' || str_contains(strtolower($reqType), 'list')) {
  $defaultReq = 'List my property';
  $defaultMsg = "Hi, I would like to list my property on Homeosphere for sale / rent. Please contact me with details on the listing process, verification, and onboarding.";
} elseif ($reqType === 'request_service' || $reqType === 'custom_service' || str_contains(strtolower($reqType), 'service')) {
  $defaultReq = 'Book a home service';
  $defaultMsg = "Hi, I am looking for a home service that is not currently listed. Here are the details of what I need assistance with:";
} elseif ($reqType === 'submit_requirement' || $reqType === 'buy' || $reqType === 'buy_property') {
  $defaultReq = 'Buy a property';
  $defaultMsg = "Hi, I am looking for a property matching my specific requirements. Please assist me in finding verified listings.";
} elseif ($reqType === 'rent' || $reqType === 'rent_property') {
  $defaultReq = 'Rent a property';
  $defaultMsg = "Hi, I am looking to rent a property. Please assist me in finding verified rental listings.";
} elseif ($reqType === 'management' || $reqType === 'property_management') {
  $defaultReq = 'Property management';
  $defaultMsg = "Hi, I am interested in Homeosphere's property management services. Please share more information on packages and features.";
} elseif ($reqType === 'join_pro' || $reqType === 'join_professional') {
  $defaultReq = 'Join as a professional';
  $defaultMsg = "Hi, I am a skilled professional / agency interested in joining Homeosphere. Please share details on onboarding and verification.";
} elseif ($reqType === 'query' || $reqType === 'question' || $reqType === 'help') {
  $defaultReq = 'Query';
  $defaultMsg = "Hi, I have a query regarding Homeosphere and its services. Could you please assist me with the following:";
} elseif ($reqType === 'others' || $reqType === 'other') {
  $defaultReq = 'Others';
  $defaultMsg = "Hi, I have a request not covered in the standard options. Here are the details:";
}

$reqOptions = [
  'Buy a property',
  'Rent a property',
  'List my property',
  'Property Listing Support',
  'Book a home service',
  'Contact a pro',
  'Post a job',
  'Property management',
  'Join as a professional',
  'Partnership / press',
  'Query',
  'Others'
];
?>
<?php if (!empty($defaultMsg)): ?>
<script>
window.customReqPreFills = {
  <?= json_encode($defaultReq) ?>: <?= json_encode($defaultMsg) ?>
};
</script>
<?php endif; ?>
<section class="section">
  <div class="container-x">
    <div class="contact-layout">
    <!-- Form -->
    <div class="reveal">
      <form data-contact class="card card-pad" novalidate style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div>
          <h2 style="font-size:1.25rem; margin: 0;">Send us a message</h2>
          <p style="font-size:.875rem;color:var(--navy-500);margin-top:.25rem">We typically respond within one business day.</p>
        </div>
        
        <?php 
        $cu = current_user(); 
        $prefillName = $cu['name'] ?? '';
        $prefillEmail = $cu['email'] ?? '';
        $prefillPhone = $cu['phone'] ?? '';
        ?>
        
        <div class="form-grid-2">
          <div>
            <label class="label" for="name" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Full name</label>
            <input class="input" id="name" name="name" type="text" placeholder="Priya Sharma" value="<?= e($prefillName) ?>" required minlength="3" maxlength="50" style="width:100%;">
            <div class="field-error" id="name_error"></div>
          </div>
          <div>
            <label class="label" for="email" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Email address</label>
            <input class="input" id="email" name="email" type="email" placeholder="you@example.com" value="<?= e($prefillEmail) ?>" required style="width:100%;">
            <div class="field-error" id="email_error"></div>
          </div>
          <div>
            <label class="label" for="phone" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Phone</label>
            <input class="input" id="phone" name="phone" type="tel" placeholder="+91 90000 00000" value="<?= e($prefillPhone) ?>" maxlength="14" style="width:100%;">
            <div class="field-error" id="phone_error"></div>
          </div>
          <div>
            <label class="label" for="requirement" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Requirement</label>
            <select class="input" id="requirement" name="requirement" style="width:100%;">
              <?php foreach ($reqOptions as $opt): ?>
                <option <?= ($opt === $defaultReq) ? 'selected' : '' ?>><?= e($opt) ?></option>
              <?php endforeach; ?>
            </select>
            <div class="field-error" id="requirement_error"></div>
          </div>
        </div>

        <div>
          <label class="label" for="message" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Message</label>
          <textarea class="input" id="message" name="message" rows="5" placeholder="Tell us a bit about what you need…" required minlength="15" maxlength="1500" style="width:100%;"><?= e($defaultMsg) ?></textarea>
          <div class="field-error" id="message_error"></div>
        </div>

        <div>
          <button type="submit" class="btn btn-gold btn-lg contact-submit-btn" style="display:inline-flex; align-items:center; gap:0.5rem;"><?= icon('send', 16) ?> Send Message</button>
        </div>

        <p class="form-status" role="status" aria-live="polite" style="margin:0;font-weight:600;border-radius:.75rem;padding:0;font-size:.875rem"></p>
      </form>
    </div>

    <!-- Info + map -->
    <div class="reveal" style="transition-delay:120ms;display:grid;gap:1.5rem;align-self:start">
      <div class="card card-pad">
        <h3 style="font-size:1rem;margin:0 0 1rem">Contact information</h3>
        <ul style="list-style:none;padding:0;margin:0;display:grid;gap:1rem;font-size:.875rem">
          <li style="display:flex;align-items:center;gap:.75rem">
            <span style="display:grid;place-items:center;width:2.5rem;height:2.5rem;border-radius:.75rem;background:var(--navy-50);color:var(--navy-800)"><?= icon('mail', 18) ?></span>
            <div><p style="font-weight:600;color:var(--navy-900);margin:0">Email</p><p style="color:var(--navy-500);margin:0">hello@homeosphere.com</p></div>
          </li>
          <li style="display:flex;align-items:center;gap:.75rem">
            <span style="display:grid;place-items:center;width:2.5rem;height:2.5rem;border-radius:.75rem;background:var(--navy-50);color:var(--navy-800)"><?= icon('phone', 18) ?></span>
            <div><p style="font-weight:600;color:var(--navy-900);margin:0">Phone</p><p style="color:var(--navy-500);margin:0">+91 90000 00000</p></div>
          </li>
          <li style="display:flex;align-items:center;gap:.75rem">
            <span style="display:grid;place-items:center;width:2.5rem;height:2.5rem;border-radius:.75rem;background:var(--navy-50);color:var(--navy-800)"><?= icon('map-pin', 18) ?></span>
            <div><p style="font-weight:600;color:var(--navy-900);margin:0">Office</p><p style="color:var(--navy-500);margin:0"><a href="https://www.google.com/maps/search/?api=1&query=Cyber+City,+Gurugram,+Haryana+122002,+India" target="_blank" rel="noopener noreferrer" style="color:inherit;text-decoration:none;border-bottom:1px dashed var(--navy-300)" title="Open in Google Maps">Cyber City, Gurugram, Haryana 122002, India ↗</a></p></div>
          </li>
        </ul>
        <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--sand-200);">
          <p style="font-weight:700;font-size:0.75rem;color:var(--navy-900);text-transform:uppercase;letter-spacing:0.05em;margin:0 0 0.65rem 0;">Follow &amp; Connect</p>
          <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
            <a href="https://www.facebook.com/profile.php?id=100078204634544" target="_blank" rel="noopener noreferrer" class="btn btn-ghost btn-sm" style="padding:0.35rem 0.7rem;font-size:0.75rem;border-radius:9999px;gap:0.35rem;" title="Facebook">
              <?= icon('facebook', 14) ?> Facebook
            </a>
            <a href="https://www.instagram.com/homeosphere.in?stkn=MTFocjBnenBibGxj" target="_blank" rel="noopener noreferrer" class="btn btn-ghost btn-sm" style="padding:0.35rem 0.7rem;font-size:0.75rem;border-radius:9999px;gap:0.35rem;" title="Instagram">
              <?= icon('instagram', 14) ?> Instagram
            </a>
            <a href="https://x.com/homeosphere" target="_blank" rel="noopener noreferrer" class="btn btn-ghost btn-sm" style="padding:0.35rem 0.7rem;font-size:0.75rem;border-radius:9999px;gap:0.35rem;" title="X (Twitter)">
              <?= icon('x', 14) ?> X
            </a>
            <a href="https://www.linkedin.com/company/homeosphere/about/" target="_blank" rel="noopener noreferrer" class="btn btn-ghost btn-sm" style="padding:0.35rem 0.7rem;font-size:0.75rem;border-radius:9999px;gap:0.35rem;" title="LinkedIn">
              <?= icon('linkedin', 14) ?> LinkedIn
            </a>
          </div>
        </div>
      </div>

      <div class="map-view" style="height:19rem; position:relative; overflow:hidden; border-radius:1rem; border:1px solid var(--sand-200); box-shadow:0 4px 20px -2px rgba(11,31,58,0.06);">
        <!-- Real Interactive Google Maps Embed -->
        <iframe 
          title="Homeosphere Office Location"
          src="https://maps.google.com/maps?q=Cyber+City,+Gurugram,+Haryana+122002,+India&t=&z=15&ie=UTF8&iwloc=&output=embed" 
          width="100%" 
          height="100%" 
          style="border:0; width:100%; height:100%; display:block;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        
        <!-- Redirect Button overlay to Google Maps -->
        <a href="https://www.google.com/maps/search/?api=1&query=Cyber+City,+Gurugram,+Haryana+122002,+India" 
           target="_blank" 
           rel="noopener noreferrer" 
           title="Open Cyber City Gurugram in Google Maps"
           style="position:absolute; bottom:0.85rem; right:0.85rem; background:#ffffff; color:#0b1f3a; box-shadow:0 4px 14px rgba(0,0,0,0.2); z-index:10; font-weight:700; font-size:0.8rem; display:inline-flex; align-items:center; gap:0.45rem; border-radius:9999px; padding:0.45rem 0.9rem; text-decoration:none; border:1px solid rgba(11,31,58,0.12); transition:transform 0.2s, background 0.2s;">
          <svg style="width:14px;height:14px;fill:none;stroke:#d4a017;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          Open in Google Maps ↗
        </a>
      </div>

      <div class="card card-pad">
        <h3 style="font-size:1rem;margin:0">Office hours</h3>
        <p style="font-size:.875rem;color:var(--navy-500);margin-top:.5rem">Monday – Saturday, 10:00 AM – 7:00 PM IST. 24/7 support for active bookings.</p>
      </div>
    </div>
  </div>
</section>

<!-- SEO Text Content Section -->
<section class="section" style="background:var(--sand-50,#f8f9fa);padding:4rem 0;margin-top:2rem;border-top:1px solid var(--sand-200)">
  <div class="container-x" style="max-width:1000px">
    <div class="card card-pad contact-seo-card" style="line-height:1.7;color:var(--navy-800);background:#fff;border-radius:1.5rem;box-shadow:0 15px 35px -5px rgba(11,31,58,0.06);">
      
      <div style="text-align: center; max-width: 42rem; margin: 0 auto 2.5rem auto;">
        <span style="display: inline-block; padding: 0.35rem 0.85rem; border-radius: 9999px; background: var(--navy-50); color: var(--navy-800); font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">Help Center &amp; Support</span>
        <h2 style="font-size:1.75rem;color:var(--navy-900);font-weight:800;letter-spacing:-0.02em;">How Can We Help You Today?</h2>
        <p style="color:var(--navy-600);font-size:0.95rem;margin-top:0.5rem;">At Homeosphere, we are dedicated to providing seamless support for buyers, home sellers, tenants, property landlords, and verified service professionals across India.</p>
      </div>

      <div class="contact-help-grid">
        <div class="contact-help-card">
          <div class="contact-help-icon">
            <?= icon('home', 22) ?>
          </div>
          <div class="contact-help-body">
            <h3>For Property Buyers &amp; Renters</h3>
            <p>Need help scheduling physical site visits or understanding rental lease terms? Contact our property response desk for personalized assistance.</p>
          </div>
        </div>
        <div class="contact-help-card">
          <div class="contact-help-icon">
            <?= icon('wrench', 22) ?>
          </div>
          <div class="contact-help-body">
            <h3>For Service Professionals &amp; Vendors</h3>
            <p>Are you an electrician, plumber, or contractor looking to join Homeosphere? Reach out to our vendor onboarding division to start receiving bookings.</p>
          </div>
        </div>
      </div>

      <div style="border-top: 1px solid var(--sand-200); padding-top: 2rem;">
        <h3 style="font-size:1.25rem;color:var(--navy-900);margin-bottom:1.25rem;font-weight:700;text-align:center;">Frequently Asked Support Questions</h3>
        <?php
        $contactFaqs = [
          [
            'q' => 'How long does it take to receive a response from customer support?',
            'a' => 'Our team typically responds to all contact submissions within 2 to 24 business hours. Priority support is provided to registered property owners.'
          ],
          [
            'q' => 'What is the process for reporting invalid property listings or fraud?',
            'a' => 'If you discover inaccurate details, please select <a href="#requirement" onclick="selectContactRequirement(\'Property Listing Support\'); return false;" style="color:var(--gold-600);font-weight:700;text-decoration:underline;cursor:pointer;">"Property Listing Support"</a> in the contact form with the listing URL. Our audit team inspects reports within 6 hours.'
          ],
          [
            'q' => 'How does Homeosphere verify property listings and prevent fraudulent posts?',
            'a' => 'Every property listing undergoes a mandatory 3-step screening process, including owner verification, title document authentication, and phone verification before receiving the verified badge.'
          ]
        ];
        echo faq_accordion($contactFaqs);
        ?>
      </div>

      <script>
      function selectContactRequirement(reqName) {
        var sel = document.getElementById('requirement');
        if (sel) {
          sel.value = reqName;
          sel.dispatchEvent(new Event('change'));
          sel.scrollIntoView({ behavior: 'smooth', block: 'center' });
          var msg = document.getElementById('message');
          if (msg) setTimeout(function() { msg.focus(); }, 400);
        }
      }
      </script>

    </div>
  </div>
</div>
</section>

<?php footer_partial(); ?>