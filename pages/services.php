<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';
require_once __DIR__ . '/../includes/cards.php';

$services = service_categories();
$trust = trust_features();
$processSteps = [
  [1,'Choose a service','Pick from 12+ home service categories.'],
  [2,'Pick a time slot','Select a date and time that suits you.'],
  [3,'A verified pro arrives','Background-checked professional at your door.'],
  [4,'Pay securely','Cashless, encrypted payment after the job.'],
];

head([
    'title'       => 'Home Services Marketplace — Book Verified Pros | Homeosphere',
    'description' => 'From AC repair to full renovations, book verified, background-checked home service professionals in minutes. Enjoy transparent pricing and guaranteed work.',
    'keywords'    => 'home services India, AC repair, home renovation, verified electricians, plumbers, home maintenance professionals',
    'canonical'   => '/services',
    'jsonld'      => [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        'name'        => 'Homeosphere Services',
        'url'         => url('/services'),
        'description' => 'Book verified, background-checked home service professionals in minutes.',
    ],
]);
header_partial('services');
?>

<section class="page-head">
  <div class="container-x" style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:1.5rem;">
    <div>
      <p class="breadcrumb"><a href="/">Home</a><span class="sep">/</span>Home Services</p>
      <p class="eyebrow">Home Services Marketplace</p>
      <h1>Home services, done right</h1>
      <p>From a quick AC service to a full home renovation — book verified, background-checked professionals in minutes.</p>
    </div>
    <div>
      <a href="<?= url('/contact?req=request_service') ?>" class="btn btn-outline" style="background:#fff; font-weight:700; display:inline-flex; align-items:center; gap:0.5rem; border-radius:9999px; padding:0.65rem 1.25rem;">
        <?= icon('plus', 16) ?> Request a Service
      </a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container-x">
    <!-- Interactive Search Bar -->
    <div style="max-width:36rem;margin:0 auto 2.5rem;position:relative;">
      <div style="position:relative;">
        <span style="position:absolute;left:1.15rem;top:50%;transform:translateY(-50%);color:var(--navy-400);pointer-events:none;display:flex;align-items:center;">
          <?= icon('search', 18) ?>
        </span>
        <input type="text" id="servicesSearchInput" class="input" placeholder="Search home services (e.g. AC Repair, Cleaning, Plumbing, Painting)…" value="<?= e($_GET['q'] ?? '') ?>" autocomplete="off" style="width:100%;border-radius:9999px;padding:0.85rem 2.85rem 0.85rem 2.85rem;font-size:0.95rem;background:#fff;border:1.5px solid var(--sand-300);box-shadow:var(--sh-soft);">
        <button type="button" id="servicesClearSearch" style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);border:none;background:var(--sand-200);border-radius:9999px;width:1.4rem;height:1.4rem;display:<?= !empty($_GET['q']) ? 'grid' : 'none' ?>;place-items:center;cursor:pointer;color:var(--navy-600);font-weight:700;font-size:0.75rem;" title="Clear search">✕</button>
      </div>
    </div>

    <!-- Active Search Keyword Banner -->
    <div id="serviceSearchBanner" class="search-active-banner" style="display:none;margin-bottom:2rem;">
      <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
        <span class="prop-match-badge"><?= icon('search', 14) ?> Search Match</span>
        <span style="font-size:0.9rem;font-weight:700;color:var(--navy-900);">
          Showing services for "<span id="serviceBannerKeywordText"></span>"
        </span>
        <span id="serviceBannerCount" class="pill pill-gold" style="font-size:0.75rem;padding:0.2rem 0.6rem;">0 matches</span>
      </div>
      <button type="button" id="serviceBannerClearBtn" class="btn btn-ghost btn-sm" style="font-weight:700;color:var(--navy-600);border-radius:9999px;">
        Clear Search ✕
      </button>
    </div>

    <!-- Primary Matching Services Grid -->
    <div id="servicesGrid" class="grid grid-4">
      <?php foreach ($services as $s): ?>
        <div class="reveal service-item" data-name="<?= e($s['name']) ?>" data-id="<?= e($s['id']) ?>"><?= service_card($s) ?></div>
      <?php endforeach; ?>
    </div>

    <!-- Other Available Services Section -->
    <div id="serviceOtherDivider" class="search-section-divider" style="display:none;">
      <span>Other Available Services</span>
    </div>
    <div id="otherServicesGrid" class="grid grid-4" style="display:none;margin-top:1.5rem;"></div>

    <!-- Empty State -->
    <div id="serviceEmptyState" class="card card-pad" style="display:none;text-align:center;color:var(--navy-500);padding:3rem;max-width:36rem;margin:2rem auto 0;">
      <p style="font-size:1.1rem;font-weight:700;color:var(--navy-800);margin:0 0 0.5rem 0;">No services found matching this keyword</p>
      <p style="font-size:0.875rem;margin:0 0 1.25rem 0;">Try searching for "Cleaning", "AC Repair", "Plumbing", "Painting", or "Renovation".</p>
      <button type="button" id="serviceEmptyReset" class="btn btn-gold btn-sm">Show All Services</button>
    </div>
  </div>
</section>

<script>
(function() {
  var input = document.getElementById('servicesSearchInput');
  var clearBtn = document.getElementById('servicesClearSearch');
  var banner = document.getElementById('serviceSearchBanner');
  var bannerKw = document.getElementById('serviceBannerKeywordText');
  var bannerCount = document.getElementById('serviceBannerCount');
  var bannerClear = document.getElementById('serviceBannerClearBtn');
  var mainGrid = document.getElementById('servicesGrid');
  var otherGrid = document.getElementById('otherServicesGrid');
  var otherDivider = document.getElementById('serviceOtherDivider');
  var emptyState = document.getElementById('serviceEmptyState');
  var emptyReset = document.getElementById('serviceEmptyReset');

  var allCards = Array.from(mainGrid.querySelectorAll('.service-item'));
  var debounceTimer = null;

  function filterServices(query) {
    query = (query || '').trim();
    if (clearBtn) clearBtn.style.display = query ? 'grid' : 'none';

    if (!query) {
      banner.style.display = 'none';
      otherDivider.style.display = 'none';
      otherGrid.style.display = 'none';
      emptyState.style.display = 'none';
      mainGrid.style.display = 'grid';

      allCards.forEach(function(el) {
        el.classList.remove('prop-match-highlight');
        el.style.display = '';
        mainGrid.appendChild(el);
      });
      return;
    }

    var qLower = query.toLowerCase();
    var words = qLower.split(/\s+/).filter(Boolean);

    var matches = [];
    var others = [];

    allCards.forEach(function(el) {
      var name = (el.dataset.name || '').toLowerCase();
      var id = (el.dataset.id || '').toLowerCase();
      var text = name + ' ' + id;

      var isMatch = words.every(function(w) { return text.indexOf(w) !== -1; });
      if (isMatch) {
        el.classList.add('prop-match-highlight');
        matches.push(el);
      } else {
        el.classList.remove('prop-match-highlight');
        others.push(el);
      }
    });

    // Populate main grid with exact matches
    matches.forEach(function(el) {
      el.style.display = '';
      mainGrid.appendChild(el);
    });

    // Populate other grid with non-matches
    others.forEach(function(el) {
      el.style.display = '';
      otherGrid.appendChild(el);
    });

    if (matches.length > 0) {
      mainGrid.style.display = 'grid';
      emptyState.style.display = 'none';

      if (others.length > 0) {
        otherDivider.style.display = 'flex';
        otherGrid.style.display = 'grid';
      } else {
        otherDivider.style.display = 'none';
        otherGrid.style.display = 'none';
      }

      banner.style.display = 'flex';
      bannerKw.textContent = query;
      bannerCount.textContent = matches.length + ' match' + (matches.length === 1 ? '' : 'es');
    } else {
      mainGrid.style.display = 'none';
      otherDivider.style.display = 'none';
      otherGrid.style.display = 'none';
      emptyState.style.display = 'block';

      banner.style.display = 'flex';
      bannerKw.textContent = query;
      bannerCount.textContent = '0 matches';
    }
  }

  if (input) {
    input.addEventListener('input', function() {
      var q = input.value;
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(function() {
        filterServices(q);
      }, 120);
    });
  }

  function resetSearch() {
    if (input) {
      input.value = '';
      input.focus();
    }
    filterServices('');
  }

  if (clearBtn) clearBtn.addEventListener('click', resetSearch);
  if (bannerClear) bannerClear.addEventListener('click', resetSearch);
  if (emptyReset) emptyReset.addEventListener('click', resetSearch);

  // Initialize from URL query param
  var params = new URLSearchParams(window.location.search);
  if (params.has('q')) {
    var q = params.get('q');
    if (input) input.value = q;
    filterServices(q);
  }
})();
</script>

<section class="section section-alt">
  <div class="container-x">
    <?= section_heading('How it works', 'Book a service in four steps') ?>
    <div class="grid grid-2 mt-12" style="gap: 1.5rem;">
      <?php foreach ($processSteps as $s): ?>
        <div class="card card-hover card-pad service-step-card reveal" style="display: flex; align-items: flex-start; gap: 1rem; box-sizing: border-box;">
          <span class="service-step-num" style="display: flex; align-items: center; justify-content: center; min-width: 3rem; width: 3rem; height: 3rem; border-radius: 0.75rem; background: var(--navy-800); color: var(--gold-500); font-weight: 800; font-size: 1.125rem; flex-shrink: 0;"><?= (int)$s[0] ?></span>
          <div>
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy-900); margin: 0 0 0.25rem 0;"><?= e($s[1]) ?></h3>
            <p style="font-size: 0.875rem; color: var(--navy-500); margin: 0; line-height: 1.5;"><?= e($s[2]) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container-x">
    <?= section_heading('Why book with us', 'Trust, built into every booking') ?>
    <div class="grid grid-2 mt-12" style="gap: 1.5rem;">
      <?php foreach ($trust as $f): ?>
        <div class="card card-hover card-pad service-trust-card reveal" style="display: flex; align-items: flex-start; gap: 1rem; box-sizing: border-box;">
          <span class="service-trust-icon" style="display: flex; align-items: center; justify-content: center; min-width: 3rem; width: 3rem; height: 3rem; border-radius: 0.75rem; background: var(--gold-100); color: var(--gold-700); flex-shrink: 0;"><?= icon($f['icon'], 24) ?></span>
          <div>
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy-900); margin: 0 0 0.25rem 0;"><?= e($f['title']) ?></h3>
            <p style="font-size: 0.875rem; color: var(--navy-500); margin: 0; line-height: 1.5;"><?= e($f['desc']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container-x">
    <?= cta_band("Need a service that's not listed?", 'Tell us what your home needs and we\'ll connect you with the right professional.', ['label'=>'Request a Service','href'=>'/contact?req=request_service'], ['label'=>'Hire a Professional','href'=>'/professionals']) ?>
  </div>
</section>

<?php footer_partial(); ?>