<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';
require_once __DIR__ . '/../includes/cards.php';

$pros = professionals();
$roles = array_unique(array_map(fn($p) => $p['role'], $pros));

head([
    'title'       => 'Verified Home Professionals & Experts | Homeosphere',
    'description' => 'Hire top-rated interior designers, architects, contractors, and home service experts. Background-checked professionals for all your home projects.',
    'keywords'    => 'hire professionals, interior designers, architects India, home contractors, verified experts, home improvement pros',
    'canonical'   => '/professionals',
    'jsonld'      => [
        '@context'    => 'https://schema.org',
        '@type'       => 'ItemList',
        'name'        => 'Verified Home Professionals Directory',
        'description' => 'Directory of background-checked home service professionals, architects, and designers.',
        'url'         => url('/professionals'),
    ],
]);
header_partial('professionals');
?>

<section class="page-head">
  <div class="container-x" style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:1.5rem;">
    <div>
      <p class="breadcrumb"><a href="/">Home</a><span class="sep">/</span>Professionals</p>
      <p class="eyebrow">Skilled Professional Marketplace</p>
      <h1>Hire verified home professionals</h1>
      <p>Architects, designers, contractors, electricians, plumbers, painters and more — every professional is background-checked and reviewed.</p>
    </div>
    <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
      <a href="<?= url('/contact?req=contact_pro') ?>" class="btn btn-outline" style="background:#fff; font-weight:700; display:inline-flex; align-items:center; gap:0.5rem; border-radius:9999px; padding:0.65rem 1.25rem;">
        <?= icon('users', 16) ?> Contact a Pro
      </a>
      <a href="<?= url('/contact?req=post_job') ?>" class="btn btn-primary" style="font-weight:700; display:inline-flex; align-items:center; gap:0.5rem; border-radius:9999px; padding:0.65rem 1.25rem;">
        <?= icon('plus', 16) ?> Post a Job
      </a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container-x">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;">
      <div id="proFilters" style="display:flex;flex-wrap:wrap;gap:.5rem">
        <button class="filter-chip active" data-role="All" type="button">All</button>
        <?php foreach ($roles as $r): ?>
          <button class="filter-chip" data-role="<?= e($r) ?>" type="button"><?= e($r) ?></button>
        <?php endforeach; ?>
      </div>

      <div style="position:relative;min-width:280px;flex:1;max-width:380px;">
        <span style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:var(--navy-400);pointer-events:none;display:flex;align-items:center;">
          <?= icon('search', 16) ?>
        </span>
        <input type="text" id="prosSearchInput" class="input" placeholder="Search by name, skill, or city…" value="<?= e($_GET['q'] ?? '') ?>" autocomplete="off" style="width:100%;border-radius:9999px;padding:0.6rem 2.2rem 0.6rem 2.5rem;font-size:0.85rem;background:#fff;border:1.5px solid var(--sand-300);">
        <button type="button" id="prosClearSearch" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);border:none;background:var(--sand-200);border-radius:9999px;width:1.25rem;height:1.25rem;display:<?= !empty($_GET['q']) ? 'grid' : 'none' ?>;place-items:center;cursor:pointer;color:var(--navy-600);font-weight:700;font-size:0.7rem;" title="Clear search">✕</button>
      </div>
    </div>

    <!-- Active Search Keyword Banner -->
    <div id="prosSearchBanner" class="search-active-banner" style="display:none;margin-bottom:1.5rem;">
      <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
        <span class="prop-match-badge"><?= icon('search', 14) ?> Search Match</span>
        <span style="font-size:0.9rem;font-weight:700;color:var(--navy-900);">
          Showing professionals for "<span id="prosBannerKeywordText"></span>"
        </span>
        <span id="prosBannerCount" class="pill pill-gold" style="font-size:0.75rem;padding:0.2rem 0.6rem;">0 matches</span>
      </div>
      <button type="button" id="prosBannerClearBtn" class="btn btn-ghost btn-sm" style="font-weight:700;color:var(--navy-600);border-radius:9999px;">
        Clear Search ✕
      </button>
    </div>

    <div id="proGrid" class="grid grid-3 mt-4">
      <?php foreach ($pros as $p): ?>
        <div class="reveal pro-item" data-id="<?= e($p['id']) ?>" data-name="<?= e($p['name']) ?>" data-role="<?= e($p['role']) ?>" data-location="<?= e($p['location']) ?>" data-skills="<?= e(implode(',', $p['skills'])) ?>"><?= professional_card($p) ?></div>
      <?php endforeach; ?>
    </div>

    <!-- Other Professionals Section -->
    <div id="prosOtherDivider" class="search-section-divider" style="display:none;">
      <span>Other Verified Professionals</span>
    </div>
    <div id="otherProsGrid" class="grid grid-3" style="display:none;margin-top:1.5rem;"></div>

    <!-- Empty State -->
    <div id="prosEmptyState" class="card card-pad" style="display:none;text-align:center;color:var(--navy-500);padding:3rem;max-width:36rem;margin:2rem auto 0;">
      <p style="font-size:1.1rem;font-weight:700;color:var(--navy-800);margin:0 0 0.5rem 0;">No professionals found matching this query</p>
      <p style="font-size:0.875rem;margin:0 0 1.25rem 0;">Try searching for "Architect", "Designer", "Electrician", "Plumber", or a city name.</p>
      <button type="button" id="prosEmptyReset" class="btn btn-gold btn-sm">Show All Professionals</button>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container-x">
    <div class="dash-grid" style="align-items:center">
      <div class="reveal">
        <?= section_heading('For Professionals', 'Grow your business with Homeosphere', 'Join 5,000+ verified professionals receiving matching service requests every day.', false) ?>
        <ul style="list-style:none;padding:0;margin:1.5rem 0 0">
          <?php foreach (['Create a free profile & portfolio','Receive requests matched to your skills & city','Manage your calendar and bookings','Get paid securely — on time, every time','Build your reputation with verified reviews'] as $b): ?>
            <li style="display:flex;align-items:center;gap:.625rem;margin-bottom:.75rem;font-size:.875rem;font-weight:600;color:var(--navy-700)">
              <span style="display:grid;place-items:center;width:1.5rem;height:1.5rem;border-radius:9999px;background:var(--gold-100);color:var(--gold-700);font-size:.75rem">✓</span>
              <?= e($b) ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="reveal" style="transition-delay:120ms">
        <div class="card card-pad">
          <h3 style="font-size:1.25rem">Become a verified professional</h3>
          <p style="font-size:.875rem;color:var(--navy-500);margin-top:.5rem">Fill in your details and our team will verify your profile within 48 hours.</p>
          
          <?php
          $cu = current_user();
          $proPrefillName = $cu['name'] ?? '';
          $proPrefillPhone = preg_replace('/^(?:\+91[\s-]?)?/', '', $cu['phone'] ?? '');
          $proPrefillCity = $cu['city'] ?? 'Delhi NCR';
          ?>
          <form id="proQuickForm" novalidate style="margin-top:1.25rem;display:grid;gap:.75rem">
            <div id="proQuickAlert" style="display:none;padding:0.75rem 1rem;border-radius:0.75rem;font-size:0.85rem;line-height:1.4;"></div>

            <div>
              <input class="input" id="proQuickName" name="name" type="text" placeholder="Full name *" value="<?= e($proPrefillName) ?>" required minlength="3" maxlength="50" style="width:100%;">
              <div class="field-error" id="proQuickName_error"></div>
            </div>

            <div>
              <div class="input-wrap">
                <span style="position: absolute; left: 0.75rem; font-weight: 700; font-size: 0.85rem; color: var(--navy-500); pointer-events: none;">+91</span>
                <input class="input" id="proQuickPhone" name="phone" type="tel" placeholder="Mobile number *" value="<?= e($proPrefillPhone) ?>" required maxlength="14" style="width:100%; padding-left: 3.25rem;">
              </div>
              <div class="field-error" id="proQuickPhone_error"></div>
            </div>

            <div>
              <select class="input" id="proQuickSkill" name="skill" required style="width:100%;">
                <option value="">Select your skill *</option>
                <?php foreach ($roles as $r): ?>
                  <option value="<?= e($r) ?>"><?= e($r) ?></option>
                <?php endforeach; ?>
                <option value="Other">Other / Add Custom Skill…</option>
              </select>
              <div class="field-error" id="proQuickSkill_error"></div>
              
              <!-- Dynamic Custom Skill Input (shown when 'Other' is selected) -->
              <div id="proCustomSkillWrap" style="display:none; margin-top:0.6rem;">
                <input class="input" id="proCustomSkill" name="custom_skill" type="text" placeholder="Specify your skill/trade (e.g. Solar Technician, HVAC, Vastu)" minlength="2" maxlength="50" style="width:100%;">
                <span style="font-size:0.75rem;color:var(--navy-500);margin-top:0.25rem;display:block;">Our onboarding team will review and verify your custom specialization during credential check.</span>
                <div class="field-error" id="proCustomSkill_error"></div>
              </div>
            </div>

            <div>
              <select class="input" id="proQuickCity" name="city" style="width:100%;">
                <?php foreach (['Delhi NCR','Gurugram','Noida','Mumbai','Bengaluru','Hyderabad','Pune','Chennai'] as $c): ?>
                  <option <?= (strcasecmp($proPrefillCity, $c) === 0) ? 'selected' : '' ?>><?= e($c) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <button type="submit" class="btn btn-gold btn-block" style="font-weight:700;display:flex;align-items:center;justify-content:center;gap:0.4rem;">
              Submit Professional Application ➔
            </button>
          </form>

          <p style="text-align:center;font-size:0.8rem;color:var(--navy-500);margin-top:1rem;margin-bottom:0;">
            Want full access? <a href="<?= url('/signup?role=professional') ?>" style="color:var(--gold-600);font-weight:700;text-decoration:none;">Create a full pro account</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
(function() {
  var form = document.getElementById('proQuickForm');
  if (!form) return;

  var nameInp = document.getElementById('proQuickName');
  var phoneInp = document.getElementById('proQuickPhone');
  var skillInp = document.getElementById('proQuickSkill');
  var customWrap = document.getElementById('proCustomSkillWrap');
  var customInp = document.getElementById('proCustomSkill');
  var alertBox = document.getElementById('proQuickAlert');

  var nameErr = document.getElementById('proQuickName_error');
  var phoneErr = document.getElementById('proQuickPhone_error');
  var skillErr = document.getElementById('proQuickSkill_error');
  var customErr = document.getElementById('proCustomSkill_error');

  function validateName() {
    var val = (nameInp.value || '').trim();
    if (!val) {
      nameInp.classList.remove('is-valid');
      nameInp.classList.add('is-invalid');
      nameErr.textContent = 'Please enter your full name.';
      nameErr.classList.add('active');
      return false;
    }
    if (val.length < 3) {
      nameInp.classList.remove('is-valid');
      nameInp.classList.add('is-invalid');
      nameErr.textContent = 'Full name must be at least 3 characters.';
      nameErr.classList.add('active');
      return false;
    }
    if (!/^[a-zA-Z\s\.\']{3,50}$/.test(val)) {
      nameInp.classList.remove('is-valid');
      nameInp.classList.add('is-invalid');
      nameErr.textContent = 'Name can only contain letters, spaces, and dots.';
      nameErr.classList.add('active');
      return false;
    }
    nameInp.classList.remove('is-invalid');
    nameInp.classList.add('is-valid');
    nameErr.classList.remove('active');
    return true;
  }

  function validatePhone() {
    var raw = (phoneInp.value || '').trim().replace(/\s+/g, '');
    if (!raw) {
      phoneInp.classList.remove('is-valid');
      phoneInp.classList.add('is-invalid');
      phoneErr.textContent = 'Mobile number is required.';
      phoneErr.classList.add('active');
      return false;
    }
    if (!/^(?:\+91[\s-]?)?[6-9]\d{9}$/.test(raw)) {
      phoneInp.classList.remove('is-valid');
      phoneInp.classList.add('is-invalid');
      phoneErr.textContent = 'Please enter a valid 10-digit Indian mobile number.';
      phoneErr.classList.add('active');
      return false;
    }
    phoneInp.classList.remove('is-invalid');
    phoneInp.classList.add('is-valid');
    phoneErr.classList.remove('active');
    return true;
  }

  function validateSkill() {
    var val = skillInp.value;
    if (!val) {
      skillInp.classList.remove('is-valid');
      skillInp.classList.add('is-invalid');
      skillErr.textContent = 'Please select your skill or specialization.';
      skillErr.classList.add('active');
      return false;
    }
    skillInp.classList.remove('is-invalid');
    skillInp.classList.add('is-valid');
    skillErr.classList.remove('active');
    return true;
  }

  function validateCustomSkill() {
    if (skillInp.value !== 'Other') return true;
    var val = (customInp.value || '').trim();
    if (!val) {
      customInp.classList.remove('is-valid');
      customInp.classList.add('is-invalid');
      customErr.textContent = 'Please specify your skill or trade.';
      customErr.classList.add('active');
      return false;
    }
    if (val.length < 2) {
      customInp.classList.remove('is-valid');
      customInp.classList.add('is-invalid');
      customErr.textContent = 'Skill must be at least 2 characters.';
      customErr.classList.add('active');
      return false;
    }
    if (!/^[a-zA-Z0-9\s\.\&\/\-\,\'\+]{2,50}$/.test(val)) {
      customInp.classList.remove('is-valid');
      customInp.classList.add('is-invalid');
      customErr.textContent = 'Please enter a valid skill description.';
      customErr.classList.add('active');
      return false;
    }
    customInp.classList.remove('is-invalid');
    customInp.classList.add('is-valid');
    customErr.classList.remove('active');
    return true;
  }

  function handleSkillChange() {
    validateSkill();
    if (skillInp.value === 'Other') {
      if (customWrap) {
        customWrap.style.display = 'block';
        if (customInp) customInp.focus();
      }
    } else {
      if (customWrap) {
        customWrap.style.display = 'none';
        if (customInp) {
          customInp.value = '';
          customInp.classList.remove('is-invalid', 'is-valid');
        }
        if (customErr) customErr.classList.remove('active');
      }
    }
  }

  nameInp.addEventListener('blur', validateName);
  nameInp.addEventListener('input', function() { if (nameInp.classList.contains('is-invalid')) validateName(); });

  phoneInp.addEventListener('blur', validatePhone);
  phoneInp.addEventListener('input', function() { if (phoneInp.classList.contains('is-invalid')) validatePhone(); });

  skillInp.addEventListener('change', handleSkillChange);

  if (customInp) {
    customInp.addEventListener('blur', validateCustomSkill);
    customInp.addEventListener('input', function() { if (customInp.classList.contains('is-invalid')) validateCustomSkill(); });
  }

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    var isNameOk = validateName();
    var isPhoneOk = validatePhone();
    var isSkillOk = validateSkill();
    var isCustomOk = validateCustomSkill();

    if (!isNameOk || !isPhoneOk || !isSkillOk || !isCustomOk) {
      if (alertBox) {
        alertBox.style.display = 'block';
        alertBox.style.background = '#fef2f2';
        alertBox.style.color = '#b91c1c';
        alertBox.style.border = '1px solid #fecaca';
        alertBox.textContent = 'Please fix the highlighted fields before submitting.';
      }
      var firstBad = form.querySelector('.is-invalid');
      if (firstBad) firstBad.focus();
      return;
    }

    // Success simulation
    var submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = 'Submitting Application…';
    }

    setTimeout(function() {
      if (alertBox) {
        alertBox.style.display = 'block';
        alertBox.style.background = '#f0fdf4';
        alertBox.style.color = '#15803d';
        alertBox.style.border = '1px solid #bbf7d0';
        alertBox.innerHTML = '<strong>Application Received!</strong> Our onboarding specialist will contact you within 24 hours to verify your credentials.';
      }
      form.reset();
      nameInp.classList.remove('is-valid');
      phoneInp.classList.remove('is-valid');
      skillInp.classList.remove('is-valid');
      if (customWrap) customWrap.style.display = 'none';
      if (customInp) customInp.classList.remove('is-valid');
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit Professional Application ➔';
      }
    }, 900);
  });
})();
</script>

<section class="section">
  <div class="container-x">
    <?= cta_band('Found the right professional?', 'Connect with verified specialists or post your requirements — no hassle, reliable service.', ['label'=>'Contact a Pro','href'=>url('/contact?req=contact_pro')], ['label'=>'Post a Job','href'=>url('/contact?req=post_job')]) ?>
  </div>
</section>

<script>
(function(){
  var chips = document.querySelectorAll('#proFilters .filter-chip');
  var input = document.getElementById('prosSearchInput');
  var clearBtn = document.getElementById('prosClearSearch');
  var banner = document.getElementById('prosSearchBanner');
  var bannerKw = document.getElementById('prosBannerKeywordText');
  var bannerCount = document.getElementById('prosBannerCount');
  var bannerClear = document.getElementById('prosBannerClearBtn');
  var mainGrid = document.getElementById('proGrid');
  var otherGrid = document.getElementById('otherProsGrid');
  var otherDivider = document.getElementById('prosOtherDivider');
  var emptyState = document.getElementById('prosEmptyState');
  var emptyReset = document.getElementById('prosEmptyReset');

  var allCards = Array.from(mainGrid.querySelectorAll('.pro-item'));
  var activeRole = 'All';
  var query = '';
  var debounceTimer = null;

  function matchesKeyword(el, q) {
    if (!q) return true;
    var name = (el.dataset.name || '').toLowerCase();
    var role = (el.dataset.role || '').toLowerCase();
    var loc = (el.dataset.location || '').toLowerCase();
    var skills = (el.dataset.skills || '').toLowerCase();
    var text = name + ' ' + role + ' ' + loc + ' ' + skills;
    var words = q.toLowerCase().split(/\s+/).filter(Boolean);
    return words.every(function(w) { return text.indexOf(w) !== -1; });
  }

  function matchesRole(el, r) {
    if (!r || r === 'All') return true;
    return (el.dataset.role || '').toLowerCase() === r.toLowerCase();
  }

  function applyFilters() {
    var q = query.trim();
    if (clearBtn) clearBtn.style.display = q ? 'grid' : 'none';

    var matches = [];
    var others = [];

    allCards.forEach(function(el) {
      el.classList.remove('prop-match-highlight');
      var roleOk = matchesRole(el, activeRole);
      var kwOk = matchesKeyword(el, q);

      if (roleOk && kwOk) {
        if (q) el.classList.add('prop-match-highlight');
        matches.push(el);
      } else if (roleOk && !kwOk) {
        others.push(el);
      } else {
        el.style.display = 'none';
      }
    });

    matches.forEach(function(el) {
      el.style.display = '';
      mainGrid.appendChild(el);
    });

    others.forEach(function(el) {
      el.style.display = '';
      otherGrid.appendChild(el);
    });

    if (q) {
      banner.style.display = 'flex';
      bannerKw.textContent = q;
      bannerCount.textContent = matches.length + ' match' + (matches.length === 1 ? '' : 'es');

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
      } else {
        mainGrid.style.display = 'none';
        otherDivider.style.display = 'none';
        otherGrid.style.display = 'none';
        emptyState.style.display = 'block';
      }
    } else {
      banner.style.display = 'none';
      otherDivider.style.display = 'none';
      otherGrid.style.display = 'none';

      var total = matches.length + others.length;
      if (total > 0) {
        mainGrid.style.display = 'grid';
        emptyState.style.display = 'none';
        others.forEach(function(el) { mainGrid.appendChild(el); });
      } else {
        mainGrid.style.display = 'none';
        emptyState.style.display = 'block';
      }
    }
  }

  chips.forEach(function(c){
    c.addEventListener('click', function(){
      chips.forEach(function(x){ x.classList.remove('active'); });
      c.classList.add('active');
      activeRole = c.dataset.role || 'All';
      applyFilters();
    });
  });

  if (input) {
    input.addEventListener('input', function() {
      var val = input.value;
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(function() {
        query = val;
        applyFilters();
      }, 120);
    });
  }

  function resetSearch() {
    if (input) {
      input.value = '';
      input.focus();
    }
    query = '';
    activeRole = 'All';
    chips.forEach(function(c) { c.classList.toggle('active', c.dataset.role === 'All'); });
    applyFilters();
  }

  if (clearBtn) clearBtn.addEventListener('click', resetSearch);
  if (bannerClear) bannerClear.addEventListener('click', resetSearch);
  if (emptyReset) emptyReset.addEventListener('click', resetSearch);

  // Initialize from URL parameters
  var params = new URLSearchParams(window.location.search);
  if (params.has('q')) {
    query = params.get('q');
    if (input) input.value = query;
  }
  if (params.has('role')) {
    var r = params.get('role');
    activeRole = r;
    chips.forEach(function(c) {
      c.classList.toggle('active', (c.dataset.role || '').toLowerCase() === r.toLowerCase());
    });
  }
  applyFilters();
})();
</script>

<?php footer_partial(); ?>
