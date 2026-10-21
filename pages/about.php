<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';
require_once __DIR__ . '/../includes/cards.php';

$statData = stats();
$roles = user_roles();
$allTestimonials = testimonials();

$values = [
  [
    'icon'  => 'shield',
    'title' => 'Trust by Verification',
    'desc'  => 'Every listing is checked with real title documents and physical photos before appearing online. Every trade pro is identity-checked and background-vetted.'
  ],
  [
    'icon'  => 'love',
    'title' => 'Obsessed with the Resident',
    'desc'  => 'We engineer every screen around the human experience of finding peace and comfort at home, never for intrusive advertising algorithms or spam.'
  ],
  [
    'icon'  => 'building',
    'title' => 'Complete Home Lifecycle',
    'desc'  => 'We do not abandon you at key handover. From discovery to Sunday electrical fixes, lease renewals to rent tracking, we provide total living care.'
  ],
  [
    'icon'  => 'users',
    'title' => 'Community Win-Win',
    'desc'  => 'An ecosystem where home seekers find honesty, landlords protect their investments, tenants live comfortably, and skilled pros earn steady, fair livelihoods.'
  ],
];

$timeline = [
  [
    'phase'       => '01',
    'year'        => '2024',
    'badge'       => 'Phase 01 • The Founding Blueprint',
    'title'       => 'The Spark & Architectural Blueprint',
    'subtitle'    => 'Engineering one unified digital roof for every home decision',
    'desc'        => 'Real estate in India was broken by fake photo bait-and-switch listings and endless broker spam, while home maintenance suffered from unverified handymen and hidden charges. Homeosphere was conceived in Gurugram to bridge this divide — engineering an integrated digital ecosystem uniting verified discovery, vetted trade pros, and automated property management.',
    'highlights'  => [
      'Zero-Spam Verification Protocol Drafted',
      'Unified Ecosystem Architecture Approved',
      'Founding Engineering & Real Estate Research Team Assembled'
    ],
    'chips'       => ['Architecture Drafted', 'Zero-Spam Protocol', 'HQ Gurugram']
  ],
  [
    'phase'       => '02',
    'year'        => '2025',
    'badge'       => 'Phase 02 • Groundbreak & Launch',
    'title'       => '12-City Marketplace Launch',
    'subtitle'    => 'Direct owner connections go live across high-growth metros',
    'desc'        => 'With our proprietary photo-matching and ownership verification engines built, Homeosphere launched across 12 high-growth metropolitan hubs. Thousands of property seekers and owners experienced transparent, broker-free real estate discovery backed by verified trade professionals for the first time.',
    'highlights'  => [
      '12 Metropolitan Hubs Launched Simultaneously',
      'First 2,500 Direct-Owner Properties Listed',
      'Strict Ownership Document & Photo Verification Protocol Live'
    ],
    'chips'       => ['Delhi NCR', 'Bengaluru', 'Mumbai', 'Hyderabad', 'Pune', 'Chennai']
  ],
  [
    'phase'       => '03',
    'year'        => '2025',
    'badge'       => 'Phase 03 • Ecosystem Convergence',
    'title'       => '10 Trade Verticals & Owner OS',
    'subtitle'    => 'Complete lifecycle care for every home',
    'desc'        => 'Finding a property is only chapter one of the journey. In our third major phase, Homeosphere rolled out on-demand services across 10 specialized trade verticals alongside our Property Owner Management Dashboard — introducing digital leases, automated rent tracking, and verified maintenance dispatch.',
    'highlights'  => [
      '10 On-Demand Service Verticals Activated',
      'Owner Dashboard with Rent & Document Tracking',
      'Transparent Standardized Rate Cards Guaranteed'
    ],
    'chips'       => ['Electrical', 'Cleaning', 'Plumbing', 'AC & Climate', 'Owner Portal', 'Digital Leases']
  ],
  [
    'phase'       => '04',
    'year'        => '2026',
    'badge'       => 'Phase 04 • Scale & Nationwide Reach',
    'title'       => 'India\'s Unified Living Ecosystem',
    'subtitle'    => '50+ cities, 10,000+ homes, 5,000+ verified pros',
    'desc'        => 'Today, Homeosphere stands as India\'s complete home ecosystem. Connecting property seekers, owners, tenants, and vetted trade professionals across 50+ cities, our platform powers thousands of smooth relocations, verified home transformations, and reliable transactions daily with dedicated 24/7 support.',
    'highlights'  => [
      '50+ Cities Active Across India',
      '10,000+ Verified Properties in Inventory',
      '5,000+ Vetted Service Pros with 24/7 Concierge Support'
    ],
    'chips'       => ['50+ Cities Live', '10K+ Properties', '5K+ Pros', '24/7 Concierge', 'Pan-India']
  ],
];

head([
    'title'       => 'About Homeosphere — India\'s Complete Home Ecosystem Story',
    'description' => 'Discover how Homeosphere transforms real estate and home maintenance across India with verified properties, trusted service professionals, and smart property management.',
    'keywords'    => 'about homeosphere, real estate ecosystem, property management platform, home services company, verified properties india',
    'canonical'   => '/about',
    'jsonld'      => [
        '@context'    => 'https://schema.org',
        '@type'       => 'AboutPage',
        'name'        => 'About Homeosphere',
        'url'         => url('/about'),
        'description' => 'Homeosphere simplifies how you discover, manage, and maintain homes under one digital roof.',
    ],
]);
header_partial('about');
?>

<!-- 1. EDITORIAL SPLIT HERO (SIGNATURE NAVY BLUE BACKGROUND) -->
<section class="page-head about-hero-section">
  <div class="container-x">
    <div class="about-hero-grid">
      <!-- Left Narrative -->
      <div class="about-hero-content">
        <p class="breadcrumb"><a href="<?= url('/') ?>">Home</a><span class="sep">/</span>About Us</p>
        <p class="eyebrow">ABOUT HOMEOSPHERE</p>
        <h1 class="about-hero-title">Everything Your Home Needs, Under One Digital Roof.</h1>
        <p class="about-hero-lead">
          Homeosphere was engineered to solve India's most stressful home dilemmas. We unite verified property discovery, trusted on-demand trade professionals, and intelligent property management into a single, cohesive ecosystem built around how you actually live.
        </p>
      </div>

      <!-- Right Visual Showcase with Dynamic Hover Effect -->
      <div class="about-hero-visual">
        <div class="hero-showcase-card">
          <!-- Main Architectural Frame -->
          <div class="hero-frame-main">
            <img src="/assets/img/parallax/living.jpg" alt="Homeosphere Architectural Living Room" class="hero-img-main" loading="eager">
            <div class="hero-frame-overlay">
              <span class="hero-frame-tag"><?= icon('shield', 14) ?> 100% VERIFIED ECOSYSTEM</span>
            </div>
          </div>

          <!-- Secondary Overlapping Frame -->
          <div class="hero-frame-sub">
            <img src="/assets/img/service/interior_design.jpg" alt="Homeosphere Verified Professional" class="hero-img-sub" loading="lazy">
            <div class="hero-sub-badge">
              <span class="sub-badge-dot"></span>
              <span>5,000+ Vetted Pros</span>
            </div>
          </div>

          <!-- Ambient Decorative Glow -->
          <div class="hero-ambient-glow"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 2. LIVE PLATFORM STATS RIBBON (FLOATING OVER HERO) -->
<section class="container-x stats-band" style="position:relative;z-index:10;">
  <div class="stats-grid">
    <?php foreach ($statData as $s): ?>
      <div class="stat">
        <p class="stat-value"><?= e($s['value']) ?></p>
        <p class="stat-label"><?= e($s['label']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- 3. THE INDIAN HOME REALITY (PROBLEM VS SOLUTION) -->
<section class="section section-alt" id="reality">
  <div class="container-x">
    <?= section_heading('Why We Built Homeosphere', 'The Indian Home Reality vs. The Homeosphere Standard', 'Finding, maintaining, or renting a home in India was fragmented and chaotic. Here is how we engineered the alternative.') ?>

    <div class="about-contrast-grid mt-12">
      <!-- The Old Broken Reality -->
      <div class="contrast-card contrast-card-old reveal">
        <div class="contrast-card-header">
          <span class="contrast-tag old-tag">THE FRAGMENTED REALITY</span>
          <h3>The Frustration Before Homeosphere</h3>
          <p>Scattered across fake portals, predatory brokers, and unverified handymen.</p>
        </div>
        <ul class="contrast-list">
          <li>
            <span class="contrast-icon-cross">✕</span>
            <div>
              <strong>Fake Photos &amp; Bait-and-Switch Listings</strong>
              <p>Wasting entire weekends visiting flats that look nothing like the photos advertised online.</p>
            </div>
          </li>
          <li>
            <span class="contrast-icon-cross">✕</span>
            <div>
              <strong>15+ Unsolicited Broker Spam Calls Daily</strong>
              <p>Your private phone number leaked across unauthorized agent directories and telemarketers.</p>
            </div>
          </li>
          <li>
            <span class="contrast-icon-cross">✕</span>
            <div>
              <strong>Unvetted Handymen with Arbitrary Pricing</strong>
              <p>No background checks, unpredictable surge charges, and zero post-service warranty.</p>
            </div>
          </li>
          <li>
            <span class="contrast-icon-cross">✕</span>
            <div>
              <strong>Paper Leases &amp; Chaotic Manual Rent Chasing</strong>
              <p>Disorganized bank transfers, physical stamp papers, and zero record of repairs or deposits.</p>
            </div>
          </li>
        </ul>
      </div>

      <!-- The Homeosphere Standard -->
      <div class="contrast-card contrast-card-new reveal" style="transition-delay:120ms">
        <div class="contrast-card-header">
          <span class="contrast-tag new-tag">THE HOMEOSPHERE STANDARD</span>
          <h3>Under One Trusted Digital Roof</h3>
          <p>Every home decision unified with strict verification and seamless digital ease.</p>
        </div>
        <ul class="contrast-list">
          <li>
            <span class="contrast-icon-check">✓</span>
            <div>
              <strong>100% Real-Photo Matching &amp; Title Checks</strong>
              <p>Every single property is verified with ownership documents and geocodes before listing.</p>
            </div>
          </li>
          <li>
            <span class="contrast-icon-check">✓</span>
            <div>
              <strong>Zero-Spam Privacy Protocol</strong>
              <p>Chat directly with verified owners and seekers without ever exposing your private number.</p>
            </div>
          </li>
          <li>
            <span class="contrast-icon-check">✓</span>
            <div>
              <strong>Background-Verified Pros &amp; Standard Rates</strong>
              <p>Police-checked, skill-tested trade pros with guaranteed transparent rate cards.</p>
            </div>
          </li>
          <li>
            <span class="contrast-icon-check">✓</span>
            <div>
              <strong>All-in-One Digital Management OS</strong>
              <p>Digital rental agreements, automated rent tracking, and 1-click maintenance dispatch.</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- 4. THREE CONNECTED PILLARS -->
<section class="section" id="pillars">
  <div class="container-x">
    <?= section_heading('The Ecosystem Architecture', 'Three Connected Pillars. Total Lifecycle Care.', 'Home is not just a one-time transaction — it is an ongoing journey of living, caring, and growing.') ?>

    <div class="grid grid-3 mt-12" style="gap:2rem;">
      <!-- Pillar 1: Discover -->
      <div class="about-pillar-card reveal">
        <div class="pillar-img-wrap">
          <img src="/assets/img/properties/prop_mumbai.jpg" alt="Homeosphere Property Discovery" class="pillar-img" loading="lazy">
          <span class="pillar-num-pill">PILLAR 01</span>
        </div>
        <div class="pillar-body">
          <div class="pillar-icon-box"><?= icon('search', 22) ?></div>
          <h3>DISCOVER</h3>
          <h4>Real Estate Marketplace</h4>
          <p>Direct owner buying and renting across 50+ cities. Transparent pricing, verified titles, high-res photos, and neighborhood livability scores.</p>
          <div class="pillar-tags">
            <span>Direct Owner</span>
            <span>Virtual Tours</span>
            <span>Title Checked</span>
          </div>
          <a href="/properties" class="pillar-link">Explore Properties <?= icon('arrow-right', 14) ?></a>
        </div>
      </div>

      <!-- Pillar 2: Maintain -->
      <div class="about-pillar-card reveal" style="transition-delay:100ms">
        <div class="pillar-img-wrap">
          <img src="/assets/img/service/interior_design.jpg" alt="Homeosphere Home Services" class="pillar-img" loading="lazy">
          <span class="pillar-num-pill">PILLAR 02</span>
        </div>
        <div class="pillar-body">
          <div class="pillar-icon-box"><?= icon('wrench', 22) ?></div>
          <h3>MAINTAIN</h3>
          <h4>10+ On-Demand Services</h4>
          <p>Book verified trade professionals with standard upfront pricing. From electrical and deep cleaning to carpentry and complete interior renovations.</p>
          <div class="pillar-tags">
            <span>10+ Trades</span>
            <span>Standard Rate Card</span>
            <span>Verified Pros</span>
          </div>
          <a href="/services" class="pillar-link">Browse Services <?= icon('arrow-right', 14) ?></a>
        </div>
      </div>

      <!-- Pillar 3: Manage -->
      <div class="about-pillar-card reveal" style="transition-delay:200ms">
        <div class="pillar-img-wrap">
          <img src="/assets/img/parallax/office.jpg" alt="Homeosphere Property Management OS" class="pillar-img" loading="lazy">
          <span class="pillar-num-pill">PILLAR 03</span>
        </div>
        <div class="pillar-body">
          <div class="pillar-icon-box"><?= icon('building', 22) ?></div>
          <h3>MANAGE</h3>
          <h4>Smart Property OS</h4>
          <p>A unified command center for homeowners and landlords. Digital leases, automated rent collection, tenant screening, and instant maintenance dispatch.</p>
          <div class="pillar-tags">
            <span>Digital Leases</span>
            <span>Rent Ledger</span>
            <span>Maintenance Dispatch</span>
          </div>
          <a href="/management" class="pillar-link">Explore Management OS <?= icon('arrow-right', 14) ?></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 5. ARCHITECTURAL MONOGRAPH TIMELINE -->
<section class="section section-alt" id="journey">
  <div class="container-x">
    <div style="text-align:center;max-width:44rem;margin:0 auto 1rem;">
      <span class="pill pill-gold" style="color:var(--navy-900);font-weight:700;"><?= icon('trending', 14) ?> OUR JOURNEY</span>
      <h2 style="font-size:clamp(1.75rem,2.5vw,2.5rem);font-weight:800;color:var(--navy-900);margin:0.75rem 0 0.5rem;line-height:1.2;">From The First Blueprint to India's Home Ecosystem</h2>
      <p style="font-size:1rem;color:var(--navy-600);line-height:1.6;margin:0;">Follow how we mapped, engineered, and scaled India's all-in-one home platform step by step.</p>
    </div>

    <div class="arch-timeline-wrap" id="archTimelineWrap">
      <div class="arch-timeline-spine">
        <div class="arch-timeline-progress" id="archTimelineProgress">
          <span class="arch-timeline-glow-tip"></span>
        </div>
      </div>

      <?php foreach ($timeline as $t): ?>
        <div class="arch-timeline-step reveal">
          <div class="arch-step-node">
            <div class="arch-step-marker"><?= e($t['phase']) ?></div>
            <span class="arch-step-year"><?= e($t['year']) ?></span>
          </div>
          <div class="arch-step-card">
            <span class="arch-step-badge"><?= e($t['badge']) ?></span>
            <h3><?= e($t['title']) ?></h3>
            <p class="arch-step-subtitle"><?= e($t['subtitle']) ?></p>
            <p class="arch-step-desc"><?= e($t['desc']) ?></p>

            <ul class="arch-step-highlights">
              <?php foreach ($t['highlights'] as $h): ?>
                <li>
                  <span class="arch-step-check">✓</span>
                  <span><?= e($h) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>

            <div class="arch-step-chips">
              <?php foreach ($t['chips'] as $cIdx => $chip): ?>
                <span class="arch-step-chip <?= $cIdx === 0 ? 'highlight' : '' ?>"><?= e(ltrim($chip, '#')) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 6. WHO WE SERVE / USER ROLES SECTION -->
<section class="section" id="roles" style="scroll-margin-top: 5rem;">
  <div class="container-x">
    <?= section_heading('Who We Serve', 'One Platform, Five Connected Journeys', 'Whether you\'re buying, selling, renting, owning, or offering services — Homeosphere is built around how you live and work.') ?>
    
    <div class="grid grid-2 mt-12" style="gap: 1.5rem;">
      <?php foreach ($roles as $idx => $r): 
        $isLastOdd = ($idx === count($roles) - 1 && count($roles) % 2 !== 0);
      ?>
        <div class="card card-hover card-pad about-role-card reveal <?= $isLastOdd ? 'role-card-center' : '' ?>" style="display:flex; flex-direction:column;">
          <div style="display:flex;align-items:center;gap:1rem">
            <span class="about-card-icon" style="display:grid;place-items:center;width:3.5rem;height:3.5rem;border-radius:1rem;flex-shrink:0;background:var(--gold-500);color:var(--navy-900);"><?= icon($r['icon'], 28) ?></span>
            <div>
              <h3 style="font-size:1.25rem;margin:0;color:var(--navy-900);"><?= e($r['role']) ?></h3>
              <p style="font-size:.875rem;color:var(--navy-500);margin:0">Connected Journey &amp; Tools</p>
            </div>
          </div>
          <ul style="list-style:none;padding:0;margin:1.5rem 0 0;flex:1;">
            <?php foreach ($r['features'] as $f): ?>
              <li style="display:flex;align-items:flex-start;gap:.75rem;margin-bottom:.75rem;font-size:.875rem;font-weight:600;color:var(--navy-700)">
                <span style="display:grid;place-items:center;width:1.25rem;height:1.25rem;flex-shrink:0;border-radius:9999px;background:var(--gold-100);color:var(--gold-700);font-size:.75rem;margin-top:.125rem">✓</span>
                <?= e($f) ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- One Account, Every Role Banner -->
    <div class="card card-pad mt-10 about-account-card reveal" style="background:#fff;border:1px solid var(--sand-200);border-radius:1.5rem;">
      <div style="text-align:center;max-width:36rem;margin:0 auto 1.5rem;">
        <h3 style="font-size:1.25rem;color:var(--navy-900);margin:0 0 0.5rem;font-weight:800;">One Account, Every Role</h3>
        <p style="font-size:.9rem;color:var(--navy-500);margin:0;">Switch between searching, managing properties, and booking services — without ever leaving Homeosphere.</p>
      </div>
      <div class="grid grid-3" style="gap:1rem;">
        <?php foreach (['Single sign-on across ecosystem','Shared dashboard & alerts','Unified wallet & payment history'] as $b): ?>
          <div class="about-sub-card" style="border-radius:1rem;background:var(--sand-100);padding:1.25rem;text-align:center;display:flex;align-items:center;justify-content:center;">
            <p style="font-size:.875rem;font-weight:700;color:var(--navy-900);margin:0"><?= e($b) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- 7. EDITORIAL VALUES & MANIFESTO -->
<section class="section section-alt" id="manifesto">
  <div class="container-x">
    <?= section_heading('Our Foundation', 'Principles That Guide Every Screen and Decision', 'We operate with unwavering commitments to truth, safety, and resident peace of mind.') ?>

    <div class="about-manifesto-grid mt-12">
      <!-- Left: Manifesto Statement Card -->
      <div class="about-manifesto-card reveal">
        <div>
          <span class="manifesto-tag">THE HOMEOSPHERE MANIFESTO</span>
          <p class="manifesto-quote">
            "A home is where family dreams take root, life's biggest savings are invested, and daily peace of mind resides. <strong>No one should ever have to gamble with fake listings, rogue broker spam, or unverified handymen.</strong> We built Homeosphere to restore dignity and trust to living."
          </p>
        </div>
        <div class="manifesto-author">
          <strong>The Homeosphere Engineering &amp; Operations Team</strong>
          <span>Gurugram HQ • Delhi NCR, India</span>
        </div>
      </div>

      <!-- Right: Values Grid -->
      <div class="grid grid-2" style="gap:1.25rem;">
        <?php foreach ($values as $v): ?>
          <div class="card card-hover card-pad about-value-card reveal" style="display:flex;flex-direction:column;align-items:flex-start;gap:0.75rem;">
            <div class="about-card-icon" style="display:grid;place-items:center;width:3rem;height:3rem;border-radius:1rem;background:var(--navy-50);color:var(--navy-800);flex-shrink:0;">
              <?= icon($v['icon'], 24) ?>
            </div>
            <div>
              <h3 style="font-size:1.1rem;margin:0;font-weight:800;color:var(--navy-900);"><?= e($v['title']) ?></h3>
              <p style="font-size:.875rem;color:var(--navy-600);margin-top:.45rem;line-height:1.55;"><?= e($v['desc']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- 8. COMMUNITY VOICES / REAL TESTIMONIALS -->
<section class="section" id="community">
  <div class="container-x">
    <?= section_heading('Community Voices', 'Trusted by Buyers, Owners, Tenants & Pros', 'Real stories from residents and trade professionals who make Homeosphere their everyday home partner.') ?>

    <div class="about-testimonials-grid mt-12">
      <?php foreach ($allTestimonials as $t): ?>
        <div class="about-testimonial-card reveal">
          <p class="about-testimonial-text">“<?= e($t['text']) ?>”</p>
          <div class="testimonial-author-row">
            <img src="<?= e($t['avatar']) ?>" alt="<?= e($t['name']) ?>" class="testimonial-avatar" loading="lazy">
            <div class="testimonial-meta">
              <strong><?= e($t['name']) ?></strong>
              <span><?= e($t['role']) ?></span>
              <div class="testimonial-stars">★★★★★</div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 9. CTA BAND -->
<section class="section">
  <div class="container-x">
    <?= cta_band(
      'Join us in building India\'s home ecosystem',
      'Whether you\'re a homeowner, a tenant searching for a flat, or a verified professional — we\'d love to welcome you.',
      ['label' => 'Get in Touch', 'href' => '/contact'],
      ['label' => 'Explore Properties', 'href' => '/properties']
    ) ?>
  </div>
</section>

<?php footer_partial(); ?>