<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/icon.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/cards.php';

$allProps      = properties();
$props         = array_slice($allProps, 0, 6);
$parallaxProps = array_slice($allProps, 0, 8); // 8 picture frames for the Living Room strip
$allServices   = service_categories();
$services      = array_slice($allServices, 0, 8); // 8 cabinets for the Kitchen
$allPros       = professionals();
$pros          = array_slice($allPros, 0, 6); // 6 hangers for the Wardrobe
$blogPreview   = array_slice(blog_posts(), 0, 3);
$lifestyles    = lifestyle_suggestions();
$trust         = trust_features();
$tst           = testimonials();
$statData      = stats();
$faqData       = faqs();

$searchTabs = ['Buy Property', 'Rent Property', 'Home Services', 'Hire Professionals'];

// Configuration for living room picture frame geometry
$ORD = [1, 3, 2, 0, 1, 3, 2, 0];
$HS  = [1, 1.1, 0.92, 1.04, 0.96, 1.08, 0.9, 1];
$FR  = [
  ['a' => 0.7921, 'o' => [7.66, 5.46, 85.06, 88.92]],
  ['a' => 0.7699, 'o' => [7.55, 5.58, 85.36, 89.09]],
  ['a' => 0.7646, 'o' => [8.40, 6.54, 83.51, 87.51]],
  ['a' => 0.6839, 'o' => [5.05, 3.54, 90.17, 93.19]],
];

head([
    'title'       => 'Homeosphere — Complete Home Ecosystem & Services',
    'description' => 'Homeosphere is India\'s complete home ecosystem. Discover properties, hire verified pros, manage homes, and access all services on one platform.',
    'keywords'    => 'Homeosphere, home services India, real estate portal, property management, hire professionals, buy sell rent homes, parallax home',
    'canonical'   => '/',
    'extra_css'   => [asset('css/parallax.css')],
    'jsonld'      => [
        '@context'    => 'https://schema.org',
        '@type'       => 'WebSite',
        'name'        => SITE_NAME,
        'url'         => url('/'),
        'description' => SITE_TAGLINE,
    ],
]);
header_partial('home');
?>

<!-- FLOATING SCENE JUMP DOTS -->
<div class="parallax-dots" id="parallaxDots" role="navigation" aria-label="Room navigation"></div>

<!-- PARALLAX SPATIAL ZOOM SCROLL TRACK -->
<div id="track">
  <div id="stage">

    <!-- SCENE 0: ENTRANCE -->
    <section class="scene" id="s0">
      <div class="plate" id="p0" style="background-image:var(--villa);transform-origin:49.98% 64.43%">
        <div class="doorbox">
          <div class="peek"></div>
          <div class="leaf dl"></div>
          <div class="leaf dr"></div>
        </div>
      </div>
      <div class="ext-title">
        <h1>Step Inside.</h1>
        <p>India's complete home ecosystem, handled from the front door.</p>
      </div>
      <div class="hint">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
        <span>Scroll to open the door</span>
      </div>
      <div class="hero-in">
        <div class="hcopy">
          <span class="eb">India's Complete Home Ecosystem</span>
          <h1><span class="h-line">Everything your home needs,</span><br><span class="h-line">behind one door.</span></h1>
          <p>Discover verified properties, hire trusted specialists, book on-demand repairs, and manage your portfolio — all in one refined digital experience.</p>
          
          <!-- Unified Interactive Hero Search Card -->
          <div class="hero-search-box">
            <div class="hero-search-tabs search-tabs" role="tablist">
              <?php foreach ($searchTabs as $idx => $t): ?>
                <b class="search-tab <?= $idx === 0 ? 'active on' : '' ?>" role="tab" data-tab="<?= e($t) ?>">
                  <?= e($t) ?>
                </b>
              <?php endforeach; ?>
            </div>
            <form id="heroSearchForm" class="hero-search-row" method="get" action="/properties" role="search">
              <input type="hidden" name="listing" id="heroListingType" value="Buy">
              <div style="position:relative;flex:1;display:flex;">
                <input class="search-input" id="heroSearchInput" name="q" type="text" autocomplete="off" placeholder="Search buy property — city, locality, or 2/3 BHK…" aria-label="Search Homeosphere">
                <button type="button" id="heroClearSearchBtn" class="search-clear-btn" style="display:none;" title="Clear search">✕</button>
                <div id="heroSuggestions" class="search-suggestions-dropdown" style="display:none;"></div>
              </div>
              <button type="submit" id="heroSearchBtn" class="btn">
                <?= icon('search', 16) ?>
                <span id="heroSearchBtnText">Explore Properties</span>
              </button>
            </form>
          </div>

          <!-- Real Platform Stats -->
          <div class="hero-stats-row">
            <div><b>12,000+</b><span>Listed Properties</span></div>
            <div><b>800+</b><span>Verified Pros</span></div>
            <div><b>50+</b><span>Cities Across India</span></div>
            <div><b>4.9★</b><span>Average Rating</span></div>
          </div>
        </div>
      </div>
    </section>

    <!-- SCENE 1: LIVING ROOM (PROPERTIES MARKETPLACE) -->
    <section class="scene" id="s1">
      <div class="plate w" style="background-image:var(--living)"></div>
      <div class="strip" id="strip">
        <?php foreach ($parallaxProps as $i => $prop): 
          $k = $ORD[$i % count($ORD)];
          $f = $FR[$k];
          $o = $f['o'];
          $hScale = $HS[$i % count($HS)];
          $propJson = htmlspecialchars(json_encode($prop, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
        ?>
          <div class="fr view-details-btn" 
               data-prop="<?= $propJson ?>"
               title="Click to view details for <?= e($prop['title']) ?>"
               style="--a:<?= $f['a'] ?>;height:calc(var(--fh)*<?= $hScale ?>);margin-top:<?= ($i % 2 ? 3 : 0) ?>svh">
            <div class="ph" style="background-image:url('<?= e($prop['image']) ?>');left:<?= ($o[0]-0.7) ?>%;top:<?= ($o[1]-0.7) ?>%;width:<?= ($o[2]+1.4) ?>%;height:<?= ($o[3]+1.4) ?>%"></div>
            <i style="background-image:var(--f<?= $k ?>)"></i>
            <div class="fr-caption">
              <b><?= e($prop['priceLabel']) ?> &bull; <?= (int)$prop['beds'] ?> BHK</b>
              <span><?= e($prop['location']) ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="glass copy">
        <span class="eb">Living Room &bull; Properties</span>
        <h2>Buy, rent, or sell without the runaround.</h2>
        <p>Browse verified listings with real high-resolution photos, clear pricing, verified legal titles, and direct owner connection.</p>
        <a href="<?= url('/properties') ?>" class="btn">
          <span>Browse Properties</span>
          <?= icon('arrow-right', 15) ?>
        </a>
      </div>
    </section>

    <!-- SCENE 2: KITCHEN (HOME SERVICES) -->
    <section class="scene" id="s2">
      <div class="plate k" style="background-image:var(--kitchen)" id="pk">
        <!-- 3D Modular Cabinets are injected here via JS with real services data -->
      </div>
      <div class="glass copy kc">
        <span class="eb">Kitchen &bull; Home Services</span>
        <h2>Book a service. We open the right door.</h2>
        <p>From plumbing emergencies to deep cleaning and complete renovations — eight essential home services at upfront, transparent rates.</p>
        <a href="<?= url('/services') ?>" class="btn">
          <span>All Services</span>
          <?= icon('arrow-right', 15) ?>
        </a>
      </div>
    </section>

    <!-- SCENE 3: WARDROBE (VERIFIED PROFESSIONALS) -->
    <section class="scene" id="s3">
      <div class="plate wd" id="p3" style="background-image:var(--wardrobe);transform-origin:50% 50%">
        <!-- Hangers with real professional profiles are injected here via JS -->
      </div>
      <div class="glass copy wc" style="width:min(25vw,360px)">
        <span class="eb">Wardrobe &bull; Professionals</span>
        <h2>Hire verified experts, neatly lined up.</h2>
        <p>Architects, interior designers, general contractors, and master craftsmen — background-checked and rated by real Indian homeowners.</p>
        <a href="<?= url('/professionals') ?>" class="btn">
          <span>Find a Professional</span>
          <?= icon('arrow-right', 15) ?>
        </a>
      </div>
    </section>

    <!-- SCENE 4: HOME OFFICE (PROPERTY MANAGEMENT & DASHBOARD) -->
    <section class="scene" id="s4">
      <div class="plate o" style="background-image:var(--office)">
        <div class="lap">
          <div class="scr" id="scr">
            <div class="dh">
              <div class="dh-title">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--gold-400);flex-shrink:0"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                <b>Portfolio Hub</b>
              </div>
              <span class="dh-status"><span class="live-dot"></span> Live Hub</span>
            </div>
            <div class="st">
              <div><small>Occupancy</small><b>96.4%</b><span class="stat-trend">+4.2% MoM</span></div>
              <div><small>Rent Collected</small><b>₹8.40 L</b><span class="stat-trend">94% On-time</span></div>
              <div><small>Open Tickets</small><b>4 Active</b><span class="stat-trend">2 In-progress</span></div>
            </div>
            <div class="ch">
              <div class="ch-chart-card">
                <div class="ch-head">Monthly Yield Trends</div>
                <div class="bars" id="bars"></div>
              </div>
              <div class="tk">
                <b>Maintenance Queue</b>
                <p><span>Worli #402 &bull; Tap</span><em class="in-prog">In Progress</em></p>
                <p><span>Villa #12 &bull; HVAC</span><em class="scheduled">Scheduled</em></p>
                <p><span>Tower B &bull; Gate</span><em class="resolved">Resolved</em></p>
              </div>
            </div>
          </div>
          <div class="lp"></div>
        </div>
      </div>
      <div class="glass copy">
        <span class="eb">Home Office &bull; Property Management</span>
        <h2>Run every property from one desk.</h2>
        <p>Collect rent, track repairs, screen prospective tenants, and generate tax-ready yields in one unified digital dashboard.</p>
        <a href="<?= url('/insights') ?>" class="btn">
          <span>See the Dashboard</span>
          <?= icon('arrow-right', 15) ?>
        </a>
      </div>
    </section>

    <!-- SCENE 5: THE BALCONY / TERRACE (PRIVATE ADVISORY) -->
    <section class="scene" id="s5">
      <div class="plate t" id="pt" style="background-image:var(--terrace)"></div>
      <div class="glass copy tc">
        <span class="eb">The Balcony &bull; Private Advisory</span>
        <h2>Ready to elevate your home journey?</h2>
        <p>Whether acquiring an iconic residence, commissioning verified architects, or seeking full-service portfolio management — talk to our senior advisory team.</p>
        
        <div class="tc-contacts">
          <a href="tel:<?= e(SITE_PHONE) ?>" class="tc-pill" title="Call Concierge">
            <?= icon('phone', 13) ?>
            <span><?= e(SITE_PHONE) ?></span>
          </a>
          <a href="mailto:<?= e(SITE_EMAIL) ?>" class="tc-pill" title="Email Advisory">
            <?= icon('mail', 13) ?>
            <span><?= e(SITE_EMAIL) ?></span>
          </a>
        </div>

        <div class="tc-btn-row">
          <a href="<?= url('/contact?req=query') ?>" class="btn">
            <span>Talk to Our Team</span>
            <?= icon('arrow-right', 15) ?>
          </a>
          <button type="button" class="btn-subtle" onclick="window.scrollToSection('#marketplaceSection')">
            <span>Explore Marketplace</span>
            <?= icon('arrow-down', 14) ?>
          </button>
        </div>
      </div>
    </section>

  </div>
</div>

<main id="main">

  <!-- STATS BAND -->
  <section class="container-x stats-band" id="statsBandSection">
    <div class="stats-grid">
      <?php foreach ($statData as $s): ?>
        <div class="stat reveal">
          <p class="stat-value"><?= e($s['value']) ?></p>
          <p class="stat-label"><?= e($s['label']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- AI LIFESTYLE SUGGESTIONS - ASYMMETRICAL BENTO GRID -->
  <section class="section" id="marketplaceSection">
    <div class="container-x">
      <?= section_heading('Curated Lifestyles', 'Find homes tailored to the way you live', 'Experience-driven property curation. Tell us your lifestyle aspirations, and we surface homes designed around your rhythm.') ?>
      
      <div class="bento-grid">
        <!-- 1. Luxury Living Hero Card (Span 7) -->
        <?php 
          $luxury = null; $family = null; $invest = null; $budget = null;
          foreach ($lifestyles as $l) {
            if ($l['id'] === 'luxury') $luxury = $l;
            elseif ($l['id'] === 'family') $family = $l;
            elseif ($l['id'] === 'investment') $invest = $l;
            elseif ($l['id'] === 'budget') $budget = $l;
          }
        ?>
        <?php if ($luxury): ?>
        <a href="<?= url('/properties?listing=Buy') ?>" class="bento-card bento-card-hero reveal">
          <div class="bento-media">
            <img src="<?= e($luxury['img']) ?>" alt="<?= e($luxury['title']) ?>" loading="lazy">
          </div>
          <div class="bento-overlay"></div>
          <div class="bento-content">
            <span class="bento-tag"><?= icon('crown', 14) ?> Curated Collection</span>
            <h3 class="bento-title"><?= e($luxury['title']) ?></h3>
            <p class="bento-desc"><?= e($luxury['desc']) ?> — Private penthouses, gated estates, and villas with panoramic horizon vistas.</p>
            <div class="bento-chips" style="margin-bottom:1rem">
              <span class="bento-chip" style="background:rgba(255,255,255,0.18);color:#fff">Starting ₹2.50 Cr+</span>
              <span class="bento-chip" style="background:rgba(255,255,255,0.18);color:#fff">Private Pools</span>
              <span class="bento-chip" style="background:rgba(255,255,255,0.18);color:#fff">Verified Titles</span>
            </div>
            <div class="bento-footer">
              <span style="color:rgba(255,255,255,0.85);font-size:0.85rem">Handpicked luxury residences</span>
              <span class="bento-link" style="color:var(--gold-300)">Explore Collection <?= icon('arrow-right', 15) ?></span>
            </div>
          </div>
        </a>
        <?php endif; ?>

        <!-- Side Column for Family and Investment (Span 5) -->
        <div class="bento-side-column">
          <?php if ($family): ?>
          <a href="<?= url('/properties') ?>" class="bento-card bento-card-side reveal">
            <div class="bento-thumb">
              <img src="<?= e($family['img']) ?>" alt="<?= e($family['title']) ?>" loading="lazy">
            </div>
            <div class="bento-side-body">
              <span class="bento-tag"><?= icon('home', 14) ?> Safe Communities</span>
              <h3 class="bento-title"><?= e($family['title']) ?></h3>
              <p class="bento-desc"><?= e($family['desc']) ?></p>
              <div class="bento-chips">
                <span class="bento-chip">Top Schools</span>
                <span class="bento-chip">Parks &amp; Clubs</span>
                <span class="bento-chip">24/7 Security</span>
              </div>
              <div class="bento-footer">
                <span style="font-size:0.78rem;color:var(--navy-500)">Gated Enclaves</span>
                <span class="bento-link">View Homes <?= icon('arrow-right', 14) ?></span>
              </div>
            </div>
          </a>
          <?php endif; ?>

          <?php if ($invest): ?>
          <a href="<?= url('/properties?listing=Buy') ?>" class="bento-card bento-card-side reveal">
            <div class="bento-thumb">
              <img src="<?= e($invest['img']) ?>" alt="<?= e($invest['title']) ?>" loading="lazy">
            </div>
            <div class="bento-side-body">
              <span class="bento-tag"><?= icon('trending', 14) ?> High ROI Hotspots</span>
              <h3 class="bento-title"><?= e($invest['title']) ?></h3>
              <p class="bento-desc"><?= e($invest['desc']) ?></p>
              <div class="bento-chips">
                <span class="bento-chip">+14.2% YoY Gain</span>
                <span class="bento-chip">Tech Corridors</span>
                <span class="bento-chip">High Yield</span>
              </div>
              <div class="bento-footer">
                <span style="font-size:0.78rem;color:var(--navy-500)">Prime Growth Hubs</span>
                <span class="bento-link">Explore Hotspots <?= icon('arrow-right', 14) ?></span>
              </div>
            </div>
          </a>
          <?php endif; ?>
        </div>

        <!-- 4. Budget Friendly Wide Card (Span 12) -->
        <?php if ($budget): ?>
        <a href="<?= url('/properties?listing=Rent') ?>" class="bento-card bento-card-bottom reveal">
          <div class="bento-bottom-media">
            <img src="<?= e($budget['img']) ?>" alt="<?= e($budget['title']) ?>" loading="lazy">
          </div>
          <div class="bento-bottom-body">
            <div class="bento-bottom-content-row">
              <div>
                <span class="bento-tag"><?= icon('wallet', 14) ?> Value &amp; Starter Homes</span>
                <h3 class="bento-title" style="font-size:1.4rem"><?= e($budget['title']) ?> &amp; Turnkey Rentals</h3>
                <p class="bento-desc" style="max-width:38rem"><?= e($budget['desc']) ?> — Zero brokerage options, fully furnished flats, and move-in ready studios near metro corridors.</p>
                <div class="bento-chips">
                  <span class="bento-chip">Zero Brokerage</span>
                  <span class="bento-chip">Under ₹35,000/mo</span>
                  <span class="bento-chip">Metro Accessible</span>
                  <span class="bento-chip">Furnished Flats</span>
                </div>
              </div>
              <div style="flex-shrink:0;margin-top:0.5rem">
                <span class="btn btn-gold" style="font-size:0.85rem;padding:0.6rem 1.35rem;border-radius:9999px">Explore Starter Rentals <?= icon('arrow-right', 14) ?></span>
              </div>
            </div>
          </div>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- PROPERTY MARKETPLACE HIGHLIGHTS -->
  <section class="section section-alt">
    <div class="container-x">
      <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:1rem">
        <?= section_heading('Real Estate Marketplace', 'Discover homes that match your life', 'Verified listings across 50+ cities — buy, rent, or sell with confidence.', false) ?>
        <a href="<?= url('/properties') ?>" class="btn btn-ghost">View all properties <?= icon('arrow-right', 16) ?></a>
      </div>
      <div class="grid grid-3 mt-10">
        <?php foreach ($props as $p): ?>
          <div class="reveal"><?= property_card($p) ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- HOME SERVICES MARKETPLACE -->
  <section class="section">
    <div class="container-x">
      <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:1rem">
        <?= section_heading('Home Services Marketplace', 'Anything your home needs, done by pros', 'From AC repair to full renovations — book verified professionals in minutes.', false) ?>
        <a href="<?= url('/services') ?>" class="btn btn-ghost">All services <?= icon('arrow-right', 16) ?></a>
      </div>
      <div class="grid grid-4 mt-10">
        <?php foreach ($services as $s): ?>
          <div class="reveal"><?= service_card($s) ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- PROFESSIONALS MARKETPLACE -->
  <section class="section section-alt">
    <div class="container-x">
      <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:1rem">
        <?= section_heading('Skilled Professional Marketplace', 'Hire trusted, background-checked pros', 'Architects, designers, contractors, electricians, plumbers — all in one network.', false) ?>
        <a href="<?= url('/professionals') ?>" class="btn btn-ghost">Browse professionals <?= icon('arrow-right', 16) ?></a>
      </div>
      <div class="grid grid-3 mt-10">
        <?php foreach ($pros as $p): ?>
          <div class="reveal"><?= professional_card($p) ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="section" style="background:var(--navy-900);color:#fff">
    <div class="container-x">
      <div class="mx-auto max-w-2xl center">
        <p class="eyebrow" style="color:var(--gold-500)">Loved by thousands</p>
        <h2 style="color:#fff">Real stories from real homes</h2>
        <p class="mt-4" style="color:var(--navy-200)">Home buyers, owners, tenants, and professionals — here's what they say.</p>
      </div>
      <div class="grid grid-4 mt-12">
        <?php foreach ($tst as $t): ?>
          <div class="reveal" style="display:flex;flex-direction:column;height:100%;"><?= testimonial_card($t) ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- BLOG PREVIEW -->
  <section class="section">
    <div class="container-x">
      <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:1rem">
        <?= section_heading('From the Blogs', 'Insights for every homeowner', 'Real estate trends, buying guides, maintenance tips, and interior ideas.', false) ?>
        <a href="<?= url('/blogs') ?>" class="btn btn-ghost">All articles <?= icon('arrow-right', 16) ?></a>
      </div>
      <div class="grid grid-3 mt-10">
        <?php foreach ($blogPreview as $p): ?>
          <div class="reveal"><?= blog_card($p) ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="section section-alt">
    <div class="container-x">
      <?= section_heading('Questions & Answers', 'Frequently asked questions') ?>
      <div class="mt-10"><?= faq_accordion($faqData) ?></div>
    </div>
  </section>

  <!-- CTA -->
  <section class="section">
    <div class="container-x">
      <?= cta_band('Ready to find, manage, and maintain your home?', 'Join India\'s complete home ecosystem. List a property, book a service, or manage your portfolio — all in one place.', ['label'=>'Get Started Free','href'=>url('/signup')], ['label'=>'Talk to Us','href'=>url('/contact?req=query')]) ?>
    </div>
  </section>

</main>

<!-- PASS DYNAMIC DATA TO PARALLAX ENGINE -->
<script>
  window.PARALLAX_SERVICES = <?= json_encode($services, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
  window.PARALLAX_PROS     = <?= json_encode($pros, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="<?= asset('js/parallax.js') ?>"></script>

<?php
footer_partial();