<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';
require_once __DIR__ . '/../includes/cards.php';

$statData = stats();
$roles = user_roles();
$values = [
  ['shield','Trust','Verification first — every listing, every professional, every transaction.'],
  ['love','Customer Obsession','We design every screen around the person using it, not the platform.'],
  ['building','Completeness','One ecosystem for every home need — discovery, services, management.'],
  ['users','Community','A network where homeowners, tenants, and professionals all win together.'],
];
$timeline = [
  [
    'year'        => '2024',
    'stage_desc'  => 'Core Foundation & Architecture',
    'stage'       => 'The Founding Blueprint',
    'moniker'     => 'Foundation',
    'icon'        => 'compass',
    'badge'       => 'Phase 01 • Foundation',
    'title'       => 'The Spark & Architectural Blueprint',
    'subtitle'    => 'Engineering one unified roof for every home decision',
    'desc'        => 'Real estate in India was broken by fake listings and spam brokers, while home repairs suffered from unverified handymen and hidden costs. Homeosphere was conceived to bridge this divide — engineering a unified digital ecosystem where verified property discovery, trusted trade professionals, and comprehensive property management converge under one digital roof.',
    'highlights'  => ['Zero-Spam Verification Protocol Drafted', 'Unified Ecosystem Architecture Approved', 'Founding Engineering & Real Estate Team Assembled'],
    'stats_label' => 'Founding Vision',
    'stats_value' => '100% Unified',
    'coord'       => '28.4595° N, 77.0266° E (HQ)',
    'tag'         => 'FOUNDATIONAL BLUEPRINT',
    'chips'       => ['#ArchitectureDrafted', '#ZeroSpamProtocol', '#CoreEngineSeed']
  ],
  [
    'year'        => '2025',
    'stage_desc'  => '12 Metro Cities Live',
    'stage'       => 'Marketplace Launch',
    'moniker'     => 'Marketplace',
    'icon'        => 'map-pin',
    'badge'       => 'Phase 02 • Groundbreak',
    'title'       => 'Marketplace Discovery Takes Flight',
    'subtitle'    => 'Direct owner connections go live across 12 primary cities',
    'desc'        => 'With our proprietary photo-matching and ownership verification engines built, Homeosphere launched across 12 high-growth metropolitan hubs including Delhi NCR, Bengaluru, Mumbai, and Hyderabad. Thousands of property seekers and owners experienced transparent, broker-free real estate discovery backed by verified trade professionals for the first time.',
    'highlights'  => ['12 Metropolitan Hubs Launched Simultaneously', 'First 2,500 Direct-Owner Properties Listed', 'Comprehensive Background-Check Pipeline for Trade Pros'],
    'stats_label' => 'Initial Cities',
    'stats_value' => '12 Metros',
    'coord'       => '12 METRO HUBS ACTIVE',
    'tag'         => 'METROPOLITAN RADAR',
    'chips'       => ['Delhi NCR', 'Bengaluru', 'Mumbai', 'Hyderabad', 'Pune', 'Chennai']
  ],
  [
    'year'        => '2025',
    'stage_desc'  => '10 Trade Verticals & Owner OS',
    'stage'       => 'Services & Management OS',
    'moniker'     => 'Services & OS',
    'icon'        => 'wrench',
    'badge'       => 'Phase 03 • Convergence',
    'title'       => 'Integrated Services & Smart Management',
    'subtitle'    => 'Complete lifecycle care for every home',
    'desc'        => 'Finding a property is only chapter one of the journey. In our third major phase, Homeosphere rolled out on-demand services across 10 specialized trade verticals alongside our Property Owner Management Dashboard — introducing seamless digital leases, automated rent tracking, and verified maintenance dispatch.',
    'highlights'  => ['10 On-Demand Service Verticals Activated', 'Owner Dashboard with Rent & Document Tracking', 'Transparent Standardized Rate Cards Guaranteed'],
    'stats_label' => 'Service Verticals',
    'stats_value' => '10 Trades',
    'coord'       => 'LIFECYCLE OS v3.0',
    'tag'         => 'ECOSYSTEM OS',
    'chips'       => ['Electrical', 'Cleaning', 'Plumbing', 'AC & Climate', 'Owner Portal']
  ],
  [
    'year'        => '2026',
    'stage_desc'  => 'Nationwide Reach • 50+ Cities',
    'stage'       => 'India\'s Home Ecosystem',
    'moniker'     => 'Nationwide',
    'icon'        => 'sparkles',
    'badge'       => 'Phase 04 • Scale & Orbit',
    'title'       => 'India\'s Unified Living Ecosystem',
    'subtitle'    => '50+ cities, 10,000+ homes, 5,000+ verified pros',
    'desc'        => 'Today, Homeosphere stands as India\'s complete home ecosystem. Connecting property seekers, owners, tenants, and vetted trade professionals across 50+ cities, our platform powers thousands of smooth relocations, verified home transformations, and reliable transactions daily with dedicated 24/7 support.',
    'highlights'  => ['50+ Cities Active Across India', '10,000+ Verified Properties in Inventory', '5,000+ Vetted Service Pros with 24/7 Support'],
    'stats_label' => 'Verified Pros',
    'stats_value' => '5,000+',
    'coord'       => 'PAN-INDIA REACH',
    'tag'         => 'NATIONWIDE EXPANSION',
    'chips'       => ['50+ Cities Live', '10K+ Properties', '5K+ Pros', '24/7 Concierge']
  ],
];

head([
    'title'       => 'About Homeosphere — India\'s Complete Home Ecosystem Story',
    'description' => 'Homeosphere simplifies how you discover, manage, and maintain homes by combining real estate technology with verified professional service networks.',
    'keywords'    => 'about homeosphere, real estate ecosystem, property management platform, home services company',
    'canonical'   => '/about',
    'jsonld'      => [
        '@context'    => 'https://schema.org',
        '@type'       => 'AboutPage',
        'name'        => 'About Homeosphere',
        'url'         => url('/about'),
        'description' => 'Homeosphere simplifies how you discover, manage, and maintain homes.',
    ],
]);
header_partial('about');
?>

<section class="page-head">
  <div class="container-x">
    <p class="breadcrumb"><a href="<?= url('/') ?>">Home</a><span class="sep">/</span>About Us</p>
    <p class="eyebrow">About Homeosphere</p>
    <h1>Everything your home needs, under one digital roof</h1>
    <p>Homeosphere was founded to simplify the way people discover, manage, and maintain their homes — by combining real estate technology, digital marketplaces, and professional service networks into a single, trustworthy ecosystem.</p>
  </div>
</section>

<section class="container-x stats-band">
  <div class="stats-grid">
    <?php foreach ($statData as $s): ?>
      <div class="stat"><p class="stat-value"><?= e($s['value']) ?></p><p class="stat-label"><?= e($s['label']) ?></p></div>
    <?php endforeach; ?>
  </div>
</section>

<section class="section">
  <div class="container-x">
    <div class="grid grid-2">
      <!-- Mission Card -->
      <div class="card card-hover card-pad about-feature-card reveal" style="display: flex; flex-direction: column; align-items: flex-start; gap: 1rem;">
        <div class="about-card-icon" style="display:grid;place-items:center;width:3rem;height:3rem;border-radius:1rem;background:var(--gold-500);color:var(--navy-900); flex-shrink:0;"><?= icon('target', 24) ?></div>
        <div>
          <h2 style="font-size:1.5rem; margin: 0;">Our Mission</h2>
          <p style="color:var(--navy-600); margin-top:0.5rem;"><?= e("To make every home transaction and service experience simple, transparent, and reliable — whether you're buying your first apartment, renting a studio, or hiring a plumber on a Sunday.") ?></p>
        </div>
      </div>
      <!-- Vision Card -->
      <div class="card card-hover card-pad about-feature-card reveal" style="display: flex; flex-direction: column; align-items: flex-start; gap: 1rem; transition-delay:120ms">
        <div class="about-card-icon" style="display:grid;place-items:center;width:3rem;height:3rem;border-radius:1rem;background:var(--gold-500);color:var(--navy-900); flex-shrink:0;"><?= icon('eye', 24) ?></div>
        <div>
          <h2 style="font-size:1.5rem; margin: 0;">Our Vision</h2>
          <p style="color:var(--navy-600); margin-top:0.5rem;"><?= e("To become India's most trusted digital home management platform — the first name that comes to mind for anything related to finding, running, or caring for a home.") ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container-x">
    <?= section_heading('What we stand for', 'Values that shape every decision') ?>
    <div class="grid grid-4 mt-12">
      <?php foreach ($values as $v): ?>
        <div class="card card-hover card-pad about-value-card reveal" style="display: flex; flex-direction: column; align-items: flex-start; gap: 0.75rem;">
          <div class="about-card-icon" style="display:grid;place-items:center;width:3rem;height:3rem;border-radius:1rem;background:var(--navy-50);color:var(--navy-800); flex-shrink:0;"><?= icon($v[0], 24) ?></div>
          <div>
            <h3 style="font-size:1rem; margin: 0;"><?= e($v[1]) ?></h3>
            <p style="font-size:.875rem;color:var(--navy-500);margin-top:.375rem"><?= e($v[2]) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- WHO WE SERVE / USER ROLES SECTION -->
<section class="section" id="roles" style="scroll-margin-top: 5rem;">
  <div class="container-x">
    <?= section_heading('Who We Serve', 'One platform, five journeys', 'Whether you\'re buying, selling, renting, owning, or offering services — Homeosphere is built around how you live and work.') ?>
    
    <div class="grid grid-2 mt-12" style="gap: 1.5rem;">
      <?php foreach ($roles as $idx => $r): 
        $isLastOdd = ($idx === count($roles) - 1 && count($roles) % 2 !== 0);
      ?>
        <div class="card card-hover card-pad about-role-card reveal <?= $isLastOdd ? 'role-card-center' : '' ?>" style="display:flex; flex-direction:column;">
          <div style="display:flex;align-items:center;gap:1rem">
            <span class="about-card-icon" style="display:grid;place-items:center;width:3.5rem;height:3.5rem;border-radius:1rem;flex-shrink:0;background:var(--gold-500);color:var(--navy-900);"><?= icon($r['icon'], 28) ?></span>
            <div>
              <h3 style="font-size:1.25rem;margin:0;color:var(--navy-900);"><?= e($r['role']) ?></h3>
              <p style="font-size:.875rem;color:var(--navy-500);margin:0">Journey &amp; tools</p>
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

    <div class="card card-pad mt-10 about-account-card reveal" style="background:#fff;border:1px solid var(--sand-200);border-radius:1.5rem;">
      <div style="text-align:center;max-width:36rem;margin:0 auto 1.5rem;">
        <h3 style="font-size:1.25rem;color:var(--navy-900);margin:0 0 0.5rem;font-weight:800;">One Account, Every Role</h3>
        <p style="font-size:.9rem;color:var(--navy-500);margin:0;">Switch between buying, managing, and hiring — without ever leaving Homeosphere.</p>
      </div>
      <div class="grid grid-3" style="gap:1rem;">
        <?php foreach (['Single sign-on across ecosystem','Shared dashboard & alerts','Unified wallet & payments'] as $b): ?>
          <div class="about-sub-card" style="border-radius:1rem;background:var(--sand-100);padding:1.25rem;text-align:center;display:flex;align-items:center;justify-content:center;">
            <p style="font-size:.875rem;font-weight:700;color:var(--navy-900);margin:0"><?= e($b) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section journey-section" id="journey">
  <div class="container-x">
    <div class="journey-header">
      <span class="pill pill-gold" style="color:var(--navy-900);font-weight:700;"><?= icon('trending', 14) ?> OUR JOURNEY</span>
      <h2 class="mt-3">From The First Blueprint to India's Home Ecosystem</h2>
      <p class="lead mt-3" style="max-width:44rem;margin-left:auto;margin-right:auto;color:var(--navy-600);">Follow our journey as we mapped, engineered, and scaled India's all-in-one home platform.</p>
    </div>

    <div class="expedition-canvas mt-10">
      <!-- Top Track: Route & Waypoints -->
      <div class="expedition-track-container">
        <div class="expedition-track-line">
          <div class="expedition-track-fill" id="expeditionTrackFill"></div>
        </div>
        <div class="expedition-waypoints" role="tablist">
          <?php foreach ($timeline as $idx => $item): ?>
            <button type="button" 
                    class="expedition-node <?= $idx === 0 ? 'active' : '' ?>" 
                    data-index="<?= $idx ?>"
                    role="tab"
                    aria-selected="<?= $idx === 0 ? 'true' : 'false' ?>">
              <span class="node-marker">
                <span class="node-ring"></span>
                <span class="node-dot">0<?= $idx + 1 ?></span>
              </span>
              <span class="node-meta">
                <span class="node-year"><?= e($item['year']) ?></span>
                <span class="node-moniker"><?= e($item['moniker']) ?></span>
              </span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Controls bar: Phase counter & Navigation buttons -->
      <div class="expedition-controls-bar">
        <div class="expedition-phase-counter">
          <span class="phase-indicator" id="phaseIndicator">PHASE 01 / 04</span>
          <span class="phase-elevation" id="phaseElevation">MILESTONE: <?= e($timeline[0]['stage_desc']) ?></span>
        </div>
        <div class="expedition-nav-btns">
          <button type="button" class="expedition-btn" id="journeyPrevBtn" aria-label="Previous Phase" title="Previous Phase">
            <?= icon('arrow-left', 16) ?>
          </button>
          <button type="button" class="expedition-btn" id="journeyNextBtn" aria-label="Next Phase" title="Next Phase">
            <?= icon('arrow-right', 16) ?>
          </button>
        </div>
      </div>

      <!-- Featured Stage: Active Milestone Showcase Pane -->
      <div class="expedition-stage" id="expeditionStage">
        <?php foreach ($timeline as $idx => $item): ?>
          <div class="expedition-slide <?= $idx === 0 ? 'active' : '' ?>" data-index="<?= $idx ?>">
            <div class="expedition-grid">
              
              <!-- Story Pane (Left) -->
              <div class="expedition-story">
                <div class="expedition-badge-row">
                  <span class="pill-gold-outline"><?= e($item['badge']) ?></span>
                  <span class="expedition-year-tag"><?= e($item['year']) ?></span>
                </div>
                <h3 class="expedition-title"><?= e($item['title']) ?></h3>
                <p class="expedition-subtitle"><?= e($item['subtitle']) ?></p>
                <p class="expedition-desc"><?= e($item['desc']) ?></p>
                
                <div class="expedition-highlights">
                  <p class="highlights-title">KEY MILESTONES & BREAKTHROUGHS</p>
                  <ul class="highlights-list">
                    <?php foreach ($item['highlights'] as $h): ?>
                      <li>
                        <span class="check-icon">✓</span>
                        <span><?= e($h) ?></span>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>

              <!-- Visual Vignette Pane (Right) -->
              <div class="expedition-visual">
                <div class="expedition-visual-box">
                  <div class="visual-bg-grid"></div>
                  <div class="visual-header">
                    <span class="visual-tag"><?= e($item['tag']) ?></span>
                    <span class="visual-coord"><?= e($item['coord']) ?></span>
                  </div>
                  <div class="visual-body">
                    <div class="visual-icon-shield">
                      <?= icon($item['icon'], 32) ?>
                    </div>
                    <div class="visual-stats-row">
                      <div class="visual-stat-item">
                        <span class="visual-stat-num"><?= e($item['stats_value']) ?></span>
                        <span class="visual-stat-label"><?= e($item['stats_label']) ?></span>
                      </div>
                      <div class="visual-stat-item">
                        <span class="visual-stat-num"><?= e($item['year']) ?></span>
                        <span class="visual-stat-label">Milestone Year</span>
                      </div>
                    </div>
                    <div class="visual-chips-cloud">
                      <?php foreach ($item['chips'] as $cIdx => $chip): ?>
                        <span class="visual-chip <?= $cIdx === 0 ? 'active' : '' ?>"><?= e($chip) ?></span>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Bottom Panoramic Deck: All 4 milestones clickable -->
      <div class="expedition-deck mt-8">
        <?php foreach ($timeline as $idx => $item): ?>
          <div class="deck-card <?= $idx === 0 ? 'active' : '' ?>" data-index="<?= $idx ?>">
            <div class="deck-head">
              <span class="deck-num">0<?= $idx + 1 ?></span>
              <span class="deck-year"><?= e($item['year']) ?></span>
            </div>
            <h4 class="deck-title"><?= e($item['stage']) ?></h4>
            <p class="deck-elevation"><?= e($item['stage_desc']) ?></p>
            <div class="deck-progress-bar"><div class="deck-progress-fill"></div></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<script>
(function initExpedition() {
  var nodes = Array.from(document.querySelectorAll('.expedition-node'));
  var slides = Array.from(document.querySelectorAll('.expedition-slide'));
  var deckCards = Array.from(document.querySelectorAll('.deck-card'));
  var fill = document.getElementById('expeditionTrackFill');
  var phaseIndicator = document.getElementById('phaseIndicator');
  var phaseElevation = document.getElementById('phaseElevation');
  var prevBtn = document.getElementById('journeyPrevBtn');
  var nextBtn = document.getElementById('journeyNextBtn');

  if (!nodes.length || !slides.length) return;

  var total = nodes.length;
  var currentIndex = 0;

  var milestones = [
    'MILESTONE: Core Foundation & Architecture',
    'MILESTONE: 12-City Marketplace Launch',
    'MILESTONE: 10 Trade Verticals & Owner OS',
    'MILESTONE: Nationwide Scale (50+ Cities)'
  ];

  function setPhase(idx) {
    if (idx < 0) idx = total - 1;
    if (idx >= total) idx = 0;
    currentIndex = idx;

    // 1. Update fill line width
    var percentage = total > 1 ? (currentIndex / (total - 1)) * 100 : 0;
    if (fill) fill.style.width = percentage + '%';

    // 2. Update waypoints
    nodes.forEach(function(n, i) {
      n.classList.toggle('active', i === currentIndex);
      n.setAttribute('aria-selected', i === currentIndex ? 'true' : 'false');
    });

    // 3. Update slides
    slides.forEach(function(s, i) {
      s.classList.toggle('active', i === currentIndex);
    });

    // 4. Update deck cards
    deckCards.forEach(function(c, i) {
      c.classList.toggle('active', i === currentIndex);
    });

    // 5. Update text indicators
    if (phaseIndicator) {
      phaseIndicator.textContent = 'PHASE 0' + (currentIndex + 1) + ' / 0' + total;
    }
    if (phaseElevation) {
      phaseElevation.textContent = milestones[currentIndex] || '';
    }
  }

  // Node clicks
  nodes.forEach(function(n) {
    n.addEventListener('click', function() {
      var idx = parseInt(n.dataset.index, 10);
      setPhase(idx);
    });
  });

  // Deck clicks
  deckCards.forEach(function(c) {
    c.addEventListener('click', function() {
      var idx = parseInt(c.dataset.index, 10);
      setPhase(idx);
    });
  });

  // Nav buttons
  if (prevBtn) prevBtn.addEventListener('click', function() { setPhase(currentIndex - 1); });
  if (nextBtn) nextBtn.addEventListener('click', function() { setPhase(currentIndex + 1); });

  // Keyboard navigation
  document.addEventListener('keydown', function(e) {
    var journeyEl = document.getElementById('journey');
    if (!journeyEl) return;
    var rect = journeyEl.getBoundingClientRect();
    if (rect.top < window.innerHeight && rect.bottom > 0) {
      if (e.key === 'ArrowRight') setPhase(currentIndex + 1);
      if (e.key === 'ArrowLeft') setPhase(currentIndex - 1);
    }
  });

  // Initialize
  setPhase(0);
})();
</script>

<section class="section">
  <div class="container-x">
    <?= cta_band('Join us in building India\'s home ecosystem', 'Whether you\'re a homeowner, a professional, or a future partner — we\'d love to hear from you.', ['label'=>'Get in Touch','href'=>'/contact'], ['label'=>'Explore the Platform','href'=>'/']) ?>
  </div>
</section>

<?php footer_partial(); ?>