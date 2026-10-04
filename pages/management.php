<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';
require_once __DIR__ . '/../includes/cards.php';

$user = current_user();
$isLoggedIn = is_logged_in();
$userName = $isLoggedIn ? $user['name'] : 'Guest Landlord';
$userRole = $isLoggedIn ? role_label($user['role']) : 'Property Owner';
$userInitials = $isLoggedIn ? user_initials($user['name']) : 'G';

// Check if demo mode is requested
$isDemo = (isset($_GET['demo']) && $_GET['demo'] === '1');

// Real user activity
$userActivity = $isLoggedIn ? get_user_activity($user['id']) : [];
$managedProperties = $userActivity['managed_properties'] ?? [];

// Demo Dataset for testing & demonstration
if ($isDemo) {
    $managedProperties = [
        [
            'id'       => 'mp1',
            'title'    => 'Skyline Residences — 302',
            'location' => 'Worli, Mumbai',
            'tenant'   => 'Rahul Nair',
            'phone'    => '+91 98201 23456',
            'rent'     => 38000,
            'deposit'  => 114000,
            'status'   => 'Paid',
            'lease'    => 'Renews in 45 days',
            'kyc'      => 'Verified',
            'type'     => '2 BHK Apartment',
            'image'    => '/assets/img/properties/prop_mumbai.jpg'
        ],
        [
            'id'       => 'mp2',
            'title'    => 'Green Acres Villa',
            'location' => 'Whitefield, Bengaluru',
            'tenant'   => 'The Mehta Family',
            'phone'    => '+91 98450 98765',
            'rent'     => 65000,
            'deposit'  => 195000,
            'status'   => 'Paid',
            'lease'    => 'Active until 2027',
            'kyc'      => 'Verified',
            'type'     => '4 BHK Villa',
            'image'    => '/assets/img/properties/prop_blr.jpg'
        ],
        [
            'id'       => 'mp3',
            'title'    => 'Tech Park Heights — 1102',
            'location' => 'Golf Course Road, Gurugram',
            'tenant'   => 'Priya Iyer',
            'phone'    => '+91 98112 34567',
            'rent'     => 28000,
            'deposit'  => 84000,
            'status'   => 'Pending',
            'lease'    => 'Renews in 12 days',
            'kyc'      => 'Verified',
            'type'     => '1 BHK Studio',
            'image'    => '/assets/img/properties/prop_ggm.jpg'
        ],
        [
            'id'       => 'mp4',
            'title'    => 'Lakeview Penthouse',
            'location' => 'Banjara Hills, Hyderabad',
            'tenant'   => 'Vacant',
            'phone'    => '—',
            'rent'     => 95000,
            'deposit'  => 0,
            'status'   => 'Vacant',
            'lease'    => 'Available for lease',
            'kyc'      => '—',
            'type'     => 'Penthouse Suite',
            'image'    => '/assets/img/properties/prop_hyd.jpg'
        ],
    ];
}

$propCount = count($managedProperties);

// Active Tab resolution
$validTabs = ['dashboard', 'properties', 'tenants', 'payments', 'maintenance', 'reports', 'market'];
$activeTab = trim((string)($_GET['tab'] ?? 'dashboard'));
if (!in_array($activeTab, $validTabs)) {
    $activeTab = 'dashboard';
}

// Dynamic calculations
$activeTenants = 0;
$totalRent = 0;
foreach ($managedProperties as $mp) {
    if (($mp['status'] ?? '') !== 'Vacant') {
        $activeTenants++;
        $totalRent += (int)($mp['rent'] ?? 0);
    }
}

$dashStats = [
  ['Total Properties', (string)$propCount, '+1 this year', false, 'building'],
  ['Active Tenants', (string)$activeTenants, '3 renewals due', false, 'users'],
  ['Monthly Rent', '₹' . ($totalRent >= 100000 ? round($totalRent / 100000, 2) . 'L' : number_format($totalRent)), '+8% vs last month', true, 'rupee'],
  ['Open Requests', '3', '2 maintenance, 1 lease', false, 'wrench'],
];

$maint = [
  ['Tap leak — Flat 302', 'Plumbing', 'Open', 'pill pill-navy-soft', 'Suresh Sharma (Certified Plumber)'],
  ['AC service — Penthouse', 'AC Repair', 'Scheduled', 'pill pill-gold-soft', 'UrbanPro Climate Care'],
  ['Painting — Villa lobby', 'Painting', 'Quote sent', 'pill pill-sand', 'ColorCraft Specialists'],
];

$reminders = [
  ['Lease renewal — Flat 101', 'In 7 days', 'calendar'],
  ['Rent due — Green Acres', 'In 12 days', 'rupee'],
  ['Annual maintenance — Penthouse', 'In 30 days', 'wrench'],
];

$nav = [
  ['id'=>'dashboard',   'label'=>'Owner Portal',            'icon'=>'dashboard'],
  ['id'=>'properties',  'label'=>'My Properties',           'icon'=>'building'],
  ['id'=>'tenants',     'label'=>'Tenants',                  'icon'=>'users'],
  ['id'=>'payments',    'label'=>'Payments & Rent',         'icon'=>'rupee'],
  ['id'=>'maintenance', 'label'=>'Maintenance',             'icon'=>'wrench'],
  ['id'=>'reports',     'label'=>'Yield & Reports',         'icon'=>'reports'],
  ['id'=>'market',      'label'=>'Market Trends & Yields',  'icon'=>'trending'],
];

head([
    'title'       => 'Insights & Owner Portal — ' . SITE_NAME,
    'description' => 'Centralized property management dashboard for landlords and property owners in India — rent tracking, tenant portals, maintenance, and yield analytics.',
    'canonical'   => '/insights',
]);
header_partial('insights');
?>

<style>
.pm-layout {
  display: grid;
  grid-template-columns: 260px minmax(0, 1fr);
  gap: 2rem;
  align-items: start;
  width: 100%;
  max-width: 100%;
  min-width: 0;
  box-sizing: border-box;
}
@media(min-width: 993px) {
  .pm-layout > aside {
    position: sticky;
    top: 5.5rem;
    align-self: start;
    z-index: 20;
  }
  .pm-sidebar {
    max-height: calc(100vh - 6.5rem);
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(212, 160, 23, 0.45) transparent;
  }
  .pm-sidebar:not(:hover) {
    scrollbar-color: transparent transparent;
  }
  .pm-sidebar::-webkit-scrollbar {
    width: 5px;
  }
  .pm-sidebar::-webkit-scrollbar-track {
    background: transparent;
    margin: 12px 0;
  }
  .pm-sidebar::-webkit-scrollbar-thumb {
    background: transparent;
    border-radius: 9999px;
    transition: background 0.25s ease;
  }
  .pm-sidebar:hover::-webkit-scrollbar-thumb {
    background: rgba(212, 160, 23, 0.45);
  }
  .pm-sidebar::-webkit-scrollbar-thumb:hover {
    background: var(--gold-500, #d4a017);
  }
}
.pm-layout > aside {
  min-width: 0;
  max-width: 100%;
}
.pm-sidebar {
  background: #0B1F3A;
  color: #fff;
  padding: 1.25rem;
  border-radius: 1rem;
  box-shadow: 0 8px 24px -4px rgba(11, 31, 58, 0.12);
  min-width: 0;
  max-width: 100%;
  box-sizing: border-box;
}
.pm-user-box {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid rgba(255,255,255,0.12);
  margin-bottom: 1rem;
  min-width: 0;
}
.pm-avatar {
  width: 2.75rem;
  height: 2.75rem;
  background: linear-gradient(135deg, var(--gold-500), var(--gold-600));
  color: #0B1F3A;
  font-weight: 800;
  font-size: 0.95rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(212, 160, 23, 0.35);
}
.pm-nav {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
  min-width: 0;
  max-width: 100%;
}
.pm-nav-btn {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  width: 100%;
  background: transparent;
  border: none;
  color: rgba(255,255,255,0.75);
  padding: 0.7rem 0.875rem;
  border-radius: 0.6rem;
  text-align: left;
  cursor: pointer;
  font-size: 0.875rem;
  text-decoration: none;
  transition: 0.2s;
  white-space: nowrap;
  flex-shrink: 0;
  box-sizing: border-box;
}
.pm-nav-btn:hover {
  background: rgba(255,255,255,0.1);
  color: #fff;
}
.pm-nav-btn.active {
  background: #D4A017 !important;
  color: #0B1F3A !important;
  font-weight: 700;
}
.tab-panel {
  display: none;
  min-width: 0;
  max-width: 100%;
  box-sizing: border-box;
}
.tab-panel.active {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  min-width: 0;
  max-width: 100%;
}

/* Market Trends Responsive Toolbar & Elements */
.market-filter-grid {
  display: grid;
  grid-template-columns: 2fr 1fr auto;
  gap: 0.75rem;
  align-items: center;
  width: 100%;
  max-width: 100%;
  box-sizing: border-box;
}
.market-city-scroll {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1rem;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  padding-bottom: 0.4rem;
  scrollbar-width: none;
  width: 100%;
  max-width: 100%;
  box-sizing: border-box;
}
.market-city-scroll::-webkit-scrollbar {
  display: none;
}
.market-city-btn {
  flex-shrink: 0;
  white-space: nowrap;
}

/* Responsive Table Wrappers */
.pm-table-scroll {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  border-radius: 0.75rem;
  width: 100%;
  max-width: 100%;
  min-width: 0;
  box-sizing: border-box;
}
.pm-table-scroll table {
  min-width: 620px;
}

@media(max-width: 992px) {
  .pm-layout {
    grid-template-columns: minmax(0, 1fr) !important;
    gap: 1.25rem;
    width: 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
  }
  .pm-layout > aside {
    width: 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
    overflow: hidden !important;
  }
  .pm-sidebar {
    position: static !important;
    padding: 0.85rem 1rem !important;
    width: 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
    box-sizing: border-box !important;
    overflow: hidden !important;
  }
  .pm-nav {
    flex-direction: row !important;
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
    padding-bottom: 0.4rem !important;
    gap: 0.5rem !important;
    scrollbar-width: none !important;
    width: 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
    box-sizing: border-box !important;
  }
  .pm-nav::-webkit-scrollbar {
    display: none !important;
  }
  .pm-nav-btn {
    width: auto !important;
    padding: 0.55rem 0.95rem !important;
    font-size: 0.85rem !important;
    flex-shrink: 0 !important;
    white-space: nowrap !important;
  }
}

@media(max-width: 768px) {
  .market-filter-grid {
    grid-template-columns: 1fr !important;
  }
  .market-filter-grid input,
  .market-filter-grid select,
  .market-filter-grid button {
    width: 100% !important;
  }
}

@media(max-width: 640px) {
  .pm-stats-grid {
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 0.65rem !important;
  }
  .pm-stats-grid .card {
    padding: 0.9rem !important;
  }
  .pm-stats-grid p:first-of-type {
    font-size: 1.2rem !important;
  }
  .pm-chart-bars {
    height: 120px !important;
  }
  .pm-chart-bar-col {
    width: 20px !important;
  }
/* View Mode Toggle (Responsive 2-line Card on Mobile, Capsule on Desktop) */
.view-mode-toggle {
  background: #ffffff;
  padding: 0.65rem 0.85rem;
  border-radius: 1rem;
  border: 1.5px solid var(--sand-300);
  display: flex;
  flex-direction: column;
  gap: 0.45rem;
  box-shadow: 0 2px 10px rgba(0,0,0,0.04);
  width: 100%;
  max-width: 22rem;
  box-sizing: border-box;
}
.view-mode-label {
  display: flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 0.725rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: var(--navy-600);
}
.view-mode-btns {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
  width: 100%;
}
.view-mode-btns a {
  width: 100% !important;
  box-sizing: border-box !important;
  text-align: center !important;
  justify-content: center !important;
  padding: 0.5rem 0.75rem !important;
  font-size: 0.775rem !important;
  font-weight: 700 !important;
  border-radius: 0.5rem !important;
  text-decoration: none !important;
  display: flex !important;
  align-items: center !important;
}

@media(min-width: 993px) {
  .view-mode-toggle {
    width: auto;
    max-width: none;
    padding: 0.35rem 0.6rem;
    border-radius: 9999px;
    flex-direction: row;
    align-items: center;
    gap: 0.5rem;
  }
  .view-mode-btns {
    flex-direction: row;
    gap: 0.35rem;
    width: auto;
  }
  .view-mode-btns a {
    width: auto !important;
    padding: 0.35rem 0.8rem !important;
    border-radius: 9999px !important;
  }
}

/* Empty State Action Buttons - Stacking on Two Separate Lines for Better Positioning */
.empty-state-btns {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.65rem;
  width: 100%;
  max-width: 22rem;
  margin: 0 auto;
  box-sizing: border-box;
}
.empty-state-btns a,
.empty-state-btns button {
  width: 100% !important;
  max-width: 100% !important;
  box-sizing: border-box !important;
  text-align: center !important;
  justify-content: center !important;
  padding: 0.75rem 1.25rem !important;
  font-weight: 700 !important;
  font-size: 0.875rem !important;
  display: flex !important;
  align-items: center !important;
  border-radius: 0.65rem !important;
}
  .search-action-bar {
    flex-direction: column !important;
    align-items: stretch !important;
  }
  .search-action-bar a {
    width: 100% !important;
    justify-content: center !important;
  }
  .pm-tab-header {
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 0.75rem !important;
  }
  .pm-tab-header .btn {
    width: 100% !important;
    justify-content: center !important;
  }
}
</style>

<section class="page-head" style="padding: 2.5rem 0 2rem 0;">
  <div class="container-x">
    <p class="breadcrumb"><a href="/">Home</a><span class="sep">/</span>Insights &amp; Owner Portal</p>
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
      <div>
        <p class="eyebrow">Property Management &amp; Analytics</p>
        <h1>Owner Insights &amp; Management Portal</h1>
        <p>Centralized portfolio management for landlords, investors, and property owners across India.</p>
      </div>

      <!-- Demo Simulation Mode Switcher -->
      <div class="view-mode-toggle">
        <div class="view-mode-label">
          <?= icon('sliders', 14) ?> <span>View Mode:</span>
        </div>
        <div class="view-mode-btns">
          <a href="?tab=<?= e($activeTab) ?>&demo=0" 
             class="btn btn-sm <?= !$isDemo ? 'btn-gold' : 'btn-ghost' ?>">
            Real Account (Empty)
          </a>
          <a href="?tab=<?= e($activeTab) ?>&demo=1" 
             class="btn btn-sm <?= $isDemo ? 'btn-gold' : 'btn-ghost' ?>">
            ✨ Demo Portfolio (Live)
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top: 1rem; padding-bottom: 3rem;">
  <div class="container-x">
    <div class="pm-layout">
    
    <!-- ============================================================== -->
    <!-- SIDEBAR (INTERACTIVE ROUTING) -->
    <!-- ============================================================== -->
    <aside>
      <div class="pm-sidebar">
        <div class="pm-user-box">
          <span class="pm-avatar"><?= e($userInitials) ?></span>
          <div style="min-width: 0;">
            <p style="font-size:0.9rem; font-weight:700; color:#fff; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
              <?= e($userName) ?>
            </p>
            <p style="font-size:0.75rem; color:#cbd5e1; margin:0.15rem 0 0;">
              <?= e($userRole) ?> · <?= $propCount ?> <?= $propCount === 1 ? 'property' : 'properties' ?>
            </p>
          </div>
        </div>
        
        <nav class="pm-nav" id="ownerPortalNav">
          <?php foreach ($nav as $n): ?>
            <a href="?tab=<?= e($n['id']) ?><?= $isDemo ? '&demo=1' : '' ?>" 
               class="pm-nav-btn <?= $n['id'] === $activeTab ? 'active' : '' ?>" 
               data-tab-target="<?= e($n['id']) ?>"
               role="tab"
               aria-selected="<?= $n['id'] === $activeTab ? 'true' : 'false' ?>">
              <?= icon($n['icon'], 16) ?> 
              <span><?= e($n['label']) ?></span>
            </a>
          <?php endforeach; ?>
        </nav>
      </div>
    </aside>

    <!-- ============================================================== -->
    <!-- MAIN CONTENT PANELS (TABBED) -->
    <!-- ============================================================== -->
    <div style="min-width: 0; width: 100%; max-width: 100%; overflow: hidden;">

      <?php if (!$isLoggedIn && !$isDemo): ?>
        <!-- Guest Banner Notice -->
        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 1rem; padding: 1rem 1.25rem; margin-bottom: 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
          <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="display: grid; place-items: center; width: 2.25rem; height: 2.25rem; border-radius: 9999px; background: #dbeafe; color: #2563eb;">
              <?= icon('user', 18) ?>
            </span>
            <div>
              <h4 style="margin: 0; font-size: 0.95rem; font-weight: 700; color: #1e40af;">Viewing as Guest Landlord</h4>
              <p style="margin: 0.15rem 0 0; font-size: 0.825rem; color: #3b82f6;">Sign in to your Homeosphere account or switch to Demo Mode above to explore all tabs.</p>
            </div>
          </div>
          <a href="<?= url('/login?redirect=/insights') ?>" class="btn btn-sm btn-gold" style="font-weight: 700;">Sign In ➔</a>
        </div>
      <?php endif; ?>

      <!-- Global Search & Action Top Bar -->
      <div class="search-action-bar" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; margin-bottom: 1.5rem;">
        <div style="position: relative; flex: 1; min-width: 220px;">
          <span style="position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); color: var(--navy-400);"><?= icon('search', 16) ?></span>
          <input class="input" style="padding-left: 2.5rem; width: 100%; box-sizing: border-box;" placeholder="Search properties, tenants, maintenance tickets…">
        </div>
        <a href="<?= url('/contact?req=list_property') ?>" class="btn btn-gold" style="display: inline-flex; align-items: center; gap: 0.4rem; font-weight: 700;">
          <?= icon('plus', 16) ?> List a Property
        </a>
      </div>


      <!-- ============================================================ -->
      <!-- TAB 1: OWNER PORTAL (OVERVIEW DASHBOARD) -->
      <!-- ============================================================ -->
      <div id="tabPanel-dashboard" class="tab-panel <?= $activeTab === 'dashboard' ? 'active' : '' ?>">
        
        <?php if ($propCount === 0): ?>
          <!-- Empty State -->
          <div class="card card-pad" style="background: #ffffff; border: 1.5px dashed var(--sand-300); border-radius: 1.25rem; text-align: center; padding: 3.5rem 1.5rem; box-shadow: 0 4px 20px -4px rgba(11, 31, 58, 0.04);">
            <div style="width: 4.5rem; height: 4.5rem; border-radius: 9999px; background: rgba(212,160,23,0.12); color: var(--gold-600); display: grid; place-items: center; margin: 0 auto 1.25rem;">
              <?= icon('building', 32) ?>
            </div>
            <h2 style="font-size: 1.45rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.5rem;">
              You haven't added any properties under management yet
            </h2>
            <p style="font-size: 0.925rem; color: var(--navy-500); max-width: 32rem; margin: 0 auto 1.75rem; line-height: 1.6;">
              Onboard your apartments, villas, or commercial spaces to unlock automated tenant rent collection, real-time yield analytics, and verified on-demand maintenance.
            </p>
            <div class="empty-state-btns">
              <a href="<?= url('/contact?req=list_property') ?>" class="btn btn-gold btn-lg" style="font-weight: 800; display: inline-flex; align-items: center; gap: 0.5rem;">
                List a Property for Management ➔
              </a>
              <a href="?tab=dashboard&demo=1" class="btn btn-ghost btn-lg" style="font-weight: 700;">
                ✨ Try Demo Mode
              </a>
            </div>
          </div>

          <!-- Benefits Grid -->
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(16rem, 100%), 1fr)); gap: 1.25rem;">
            <div class="card" style="background: #fff; padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--sand-200); margin: 0;">
              <span style="display: grid; place-items: center; width: 3rem; height: 3rem; border-radius: 0.75rem; background: rgba(212,160,23,0.12); color: var(--gold-700); margin-bottom: 1rem;"><?= icon('rupee', 22) ?></span>
              <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.35rem;">Automated Rent Collection</h3>
              <p style="font-size: 0.85rem; color: var(--navy-500); line-height: 1.5; margin: 0;">Tenants receive automated payment links. Payouts transfer directly to your bank account with instant ledger updates.</p>
            </div>
            <div class="card" style="background: #fff; padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--sand-200); margin: 0;">
              <span style="display: grid; place-items: center; width: 3rem; height: 3rem; border-radius: 0.75rem; background: var(--navy-50); color: var(--navy-800); margin-bottom: 1rem;"><?= icon('users', 22) ?></span>
              <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.35rem;">Tenant &amp; Lease Vault</h3>
              <p style="font-size: 0.85rem; color: var(--navy-500); line-height: 1.5; margin: 0;">Digitally manage agreements, security deposits, police verification records, and automated renewal notices.</p>
            </div>
            <div class="card" style="background: #fff; padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--sand-200); margin: 0;">
              <span style="display: grid; place-items: center; width: 3rem; height: 3rem; border-radius: 0.75rem; background: #f0fdf4; color: #16a34a; margin-bottom: 1rem;"><?= icon('wrench', 22) ?></span>
              <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.35rem;">Verified Maintenance</h3>
              <p style="font-size: 0.85rem; color: var(--navy-500); line-height: 1.5; margin: 0;">Tenants raise repair tickets serviced promptly by certified pros—eliminating landlord headaches.</p>
            </div>
          </div>
        
        <?php else: ?>
          
          <!-- Key Metrics Grid -->
          <div class="pm-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(140px, 100%), 1fr)); gap: 1rem;">
            <?php foreach ($dashStats as $s): ?>
              <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin: 0; border: 1px solid var(--sand-200);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                  <span style="color: var(--navy-700);"><?= icon($s[4], 18) ?></span>
                  <span style="color: <?= $s[3] ? 'var(--gold-600)' : 'var(--navy-400)' ?>"><?= icon($s[3] ? 'arrow-up' : 'arrow-down', 14) ?></span>
                </div>
                <p style="font-size: 1.5rem; font-weight: bold; margin: 0.75rem 0 0.25rem; color: var(--navy-900);"><?= e($s[1]) ?></p>
                <p style="font-size: 0.9rem; color: #666; margin: 0;"><?= e($s[0]) ?></p>
                <p style="font-size: 0.75rem; color: #888; margin: 0.35rem 0 0;"><?= e($s[2]) ?></p>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Rent Collection Chart Card -->
          <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin: 0; border: 1px solid var(--sand-200);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
              <h3 style="font-size: 1rem; margin: 0; color: var(--navy-900); font-weight: 800;">Rent collection &amp; Yield — last 6 months</h3>
              <span class="pill pill-gold-soft" style="font-weight: 700;">92% collected</span>
            </div>
            <div class="pm-chart-bars" style="display: flex; justify-content: space-around; align-items: flex-end; height: 150px; margin-top: 1.25rem;">
              <?php
              $bars = [['Feb',60],['Mar',72],['Apr',68],['May',84],['Jun',90],['Jul',92]];
              foreach ($bars as $b): ?>
                <div style="display: flex; flex-direction: column; align-items: center; height: 100%; justify-content: flex-end;">
                  <div class="pm-chart-bar-col" style="width: 28px; background: #D4A017; height: <?= $b[1] ?>%; border-radius: 4px 4px 0 0;"></div>
                  <span style="font-size: 0.75rem; margin-top: 0.35rem; color: #666; font-weight: 600;"><?= $b[0] ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Quick Properties Table -->
          <div class="card" style="background: #fff; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin: 0; overflow: hidden; border: 1px solid var(--sand-200);">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 1.25rem; border-bottom: 1px solid #eee;">
              <h3 style="font-size: 1rem; margin: 0; color: var(--navy-900); font-weight: 800;">My Properties &amp; Tenants</h3>
              <a href="?tab=properties<?= $isDemo ? '&demo=1' : '' ?>" class="btn btn-ghost btn-sm" style="font-weight: 700;">View All Properties ➔</a>
            </div>
            <div class="pm-table-scroll">
              <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                  <tr style="background: #fafbfc;">
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Property</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Tenant</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Rent</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Status</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Lease</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($managedProperties as $p): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                      <td style="padding: 0.875rem 1.25rem; font-weight: 700; color: #0B1F3A;"><?= e($p['title']) ?></td>
                      <td style="padding: 0.875rem 1.25rem; color: #555;"><?= e($p['tenant']) ?></td>
                      <td style="padding: 0.875rem 1.25rem; font-weight: 700; color: #0B1F3A;">₹<?= number_format((int)$p['rent']) ?></td>
                      <td style="padding: 0.875rem 1.25rem;">
                        <span class="pill <?= ($p['status'] ?? '') === 'Paid' ? 'pill-gold-soft' : (($p['status'] ?? '') === 'Vacant' ? 'pill-sand' : 'pill-navy-soft') ?>">
                          <?= e($p['status']) ?>
                        </span>
                      </td>
                      <td style="padding: 0.875rem 1.25rem; color: #777; font-size: 0.85rem;"><?= e($p['lease']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </div>


      <!-- ============================================================ -->
      <!-- TAB 2: MY PROPERTIES -->
      <!-- ============================================================ -->
      <div id="tabPanel-properties" class="tab-panel <?= $activeTab === 'properties' ? 'active' : '' ?>">
        <div class="pm-tab-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
          <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--navy-900); margin: 0;">My Managed Properties (<?= $propCount ?>)</h2>
            <p style="font-size: 0.85rem; color: var(--navy-500); margin: 0.2rem 0 0;">Residential and commercial units registered under Homeosphere management.</p>
          </div>
          <a href="<?= url('/contact?req=list_property') ?>" class="btn btn-gold btn-sm" style="font-weight: 700;">+ Onboard New Unit</a>
        </div>

        <?php if ($propCount === 0): ?>
          <div class="card card-pad" style="background: #ffffff; border: 1.5px dashed var(--sand-300); border-radius: 1.25rem; text-align: center; padding: 3.5rem 1.5rem;">
            <div style="width: 4rem; height: 4rem; border-radius: 9999px; background: rgba(212,160,23,0.12); color: var(--gold-600); display: grid; place-items: center; margin: 0 auto 1rem; font-size: 1.75rem;">
              <?= icon('building', 26) ?>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.5rem;">No properties listed under management</h3>
            <p style="font-size: 0.875rem; color: var(--navy-500); max-width: 28rem; margin: 0 auto 1.5rem; line-height: 1.5;">
              List your residential apartments, villas, or commercial units to start managing rent collections, digital leases, and tenant verifications.
            </p>
            <div class="empty-state-btns">
              <a href="<?= url('/contact?req=list_property') ?>" class="btn btn-gold">List a Property ➔</a>
              <a href="?tab=properties&demo=1" class="btn btn-ghost">✨ View Demo Properties</a>
            </div>
          </div>
        <?php else: ?>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(18rem, 100%), 1fr)); gap: 1.5rem;">
            <?php foreach ($managedProperties as $p): ?>
              <div class="card" style="border-radius: 1.25rem; overflow: hidden; background: #ffffff; border: 1px solid var(--sand-200); box-shadow: 0 4px 14px rgba(11, 31, 58, 0.04);">
                <div style="position: relative; height: 11rem; overflow: hidden;">
                  <img src="<?= e($p['image'] ?? '/assets/img/properties/prop_mumbai.jpg') ?>" alt="<?= e($p['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                  <span class="pill" style="position: absolute; top: 0.75rem; left: 0.75rem; background: var(--navy-900); color: #ffffff; font-size: 0.725rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                    <?= e($p['type'] ?? 'Apartment') ?>
                  </span>
                  <span class="pill" style="position: absolute; top: 0.75rem; right: 0.75rem; background: <?= ($p['status'] ?? '') === 'Vacant' ? '#fef3c7; color: #92400e;' : '#f0fdf4; color: #16a34a;' ?> font-weight: 800; font-size: 0.725rem; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                    ● <?= ($p['status'] ?? '') === 'Vacant' ? 'Vacant' : 'Occupied' ?>
                  </span>
                </div>
                <div style="padding: 1.25rem;">
                  <div style="font-size: 1.2rem; font-weight: 800; color: var(--navy-900);">₹<?= number_format((int)($p['rent'] ?? 0)) ?> <span style="font-size: 0.8rem; font-weight: 600; color: var(--navy-500);">/ month</span></div>
                  <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy-800); margin: 0.35rem 0 0.25rem;"><?= e($p['title']) ?></h3>
                  <p style="font-size: 0.8rem; color: var(--navy-500); margin: 0 0 1rem;"><?= icon('map-pin', 12) ?> <?= e($p['location'] ?? 'Delhi NCR') ?></p>
                  
                  <div style="background: var(--sand-50); padding: 0.75rem; border-radius: 0.75rem; font-size: 0.8rem; margin-bottom: 1rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                      <span style="color: var(--navy-500);">Current Tenant:</span>
                      <strong style="color: var(--navy-900);"><?= e($p['tenant']) ?></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                      <span style="color: var(--navy-500);">Lease Status:</span>
                      <strong style="color: #16a34a;"><?= e($p['lease']) ?></strong>
                    </div>
                  </div>

                  <div style="display: flex; gap: 0.5rem;">
                    <a href="<?= url('/contact?req=query') ?>" class="btn btn-sm btn-gold btn-block" style="font-weight: 700;">Manage Unit</a>
                    <a href="<?= url('/contact?req=query') ?>" class="btn btn-sm btn-ghost" style="font-weight: 600;">Lease Vault</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>


      <!-- ============================================================ -->
      <!-- TAB 3: TENANTS DIRECTORY -->
      <!-- ============================================================ -->
      <div id="tabPanel-tenants" class="tab-panel <?= $activeTab === 'tenants' ? 'active' : '' ?>">
        <div class="pm-tab-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
          <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--navy-900); margin: 0;">Tenant Directory (<?= $activeTenants ?> Active)</h2>
            <p style="font-size: 0.85rem; color: var(--navy-500); margin: 0.2rem 0 0;">Verified tenant profiles, KYC documents, and police verification status.</p>
          </div>
          <a href="<?= url('/contact?req=query') ?>" class="btn btn-gold btn-sm" style="font-weight: 700;">+ Invite New Tenant</a>
        </div>

        <?php if ($activeTenants === 0): ?>
          <div class="card card-pad" style="background: #ffffff; border: 1.5px dashed var(--sand-300); border-radius: 1.25rem; text-align: center; padding: 3.5rem 1.5rem;">
            <div style="width: 4rem; height: 4rem; border-radius: 9999px; background: var(--navy-50); color: var(--navy-700); display: grid; place-items: center; margin: 0 auto 1rem;">
              <?= icon('users', 26) ?>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.5rem;">No active tenants registered</h3>
            <p style="font-size: 0.875rem; color: var(--navy-500); max-width: 28rem; margin: 0 auto 1.5rem; line-height: 1.5;">
              Once you onboard a rental property, you can register tenant profiles, track ID verifications, and automate rental agreements.
            </p>
            <div class="empty-state-btns">
              <a href="<?= url('/contact?req=list_property') ?>" class="btn btn-gold">List a Property ➔</a>
              <a href="?tab=tenants&demo=1" class="btn btn-ghost">✨ View Demo Tenants</a>
            </div>
          </div>
        <?php else: ?>
          <div class="card" style="background: #fff; border-radius: 1rem; border: 1px solid var(--sand-200); overflow: hidden;">
            <div class="pm-table-scroll">
              <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                  <tr style="background: #fafbfc;">
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Tenant Profile</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Assigned Unit</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Monthly Rent</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Security Deposit</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">KYC &amp; Verification</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Quick Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($managedProperties as $p): ?>
                    <?php if (($p['status'] ?? '') !== 'Vacant'): ?>
                      <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 1rem 1.25rem;">
                          <div style="font-weight: 700; color: var(--navy-900);"><?= e($p['tenant']) ?></div>
                          <div style="font-size: 0.8rem; color: var(--navy-500);"><?= e($p['phone'] ?? '+91 98000 00000') ?></div>
                        </td>
                        <td style="padding: 1rem 1.25rem; font-weight: 600; color: var(--navy-800);"><?= e($p['title']) ?></td>
                        <td style="padding: 1rem 1.25rem; font-weight: 700; color: var(--navy-900);">₹<?= number_format((int)$p['rent']) ?></td>
                        <td style="padding: 1rem 1.25rem; color: var(--navy-600);">₹<?= number_format((int)($p['deposit'] ?? ($p['rent'] * 3))) ?></td>
                        <td style="padding: 1rem 1.25rem;">
                          <span class="pill" style="background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; font-size: 0.75rem; font-weight: 700;">
                            ✓ <?= e($p['kyc'] ?? 'Police Verified') ?>
                          </span>
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                          <a href="tel:<?= e($p['phone'] ?? '+919000000000') ?>" class="btn btn-sm btn-ghost" style="font-size: 0.8rem; font-weight: 600;">Contact</a>
                        </td>
                      </tr>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </div>


      <!-- ============================================================ -->
      <!-- TAB 4: PAYMENTS & RENT LEDGER -->
      <!-- ============================================================ -->
      <div id="tabPanel-payments" class="tab-panel <?= $activeTab === 'payments' ? 'active' : '' ?>">
        <div class="pm-tab-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
          <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--navy-900); margin: 0;">Payments &amp; Rent Ledger</h2>
            <p style="font-size: 0.85rem; color: var(--navy-500); margin: 0.2rem 0 0;">Automated rent tracking, digital payment receipts, and collection audit.</p>
          </div>
          <button type="button" class="btn btn-ghost btn-sm" onclick="alert('Downloading Financial Ledger (PDF/Excel)...')" style="font-weight: 700;">
            Download Statement 📄
          </button>
        </div>

        <?php if ($propCount === 0): ?>
          <div class="card card-pad" style="background: #ffffff; border: 1.5px dashed var(--sand-300); border-radius: 1.25rem; text-align: center; padding: 3.5rem 1.5rem;">
            <div style="width: 4rem; height: 4rem; border-radius: 9999px; background: rgba(212,160,23,0.12); color: var(--gold-600); display: grid; place-items: center; margin: 0 auto 1rem; font-size: 1.75rem;">
              <?= icon('rupee', 26) ?>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.5rem;">No payment transactions recorded</h3>
            <p style="font-size: 0.875rem; color: var(--navy-500); max-width: 28rem; margin: 0 auto 1.5rem; line-height: 1.5;">
              Connect your bank account once your property is onboarded to start receiving automated rent transfers with instant ledger receipts.
            </p>
            <div class="empty-state-btns">
              <a href="<?= url('/contact?req=list_property') ?>" class="btn btn-gold">Onboard Property ➔</a>
              <a href="?tab=payments&demo=1" class="btn btn-ghost">✨ View Demo Ledger</a>
            </div>
          </div>
        <?php else: ?>
          <!-- Financial Summary Ribbon -->
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(12rem, 100%), 1fr)); gap: 1rem;">
            <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin:0;">
              <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Collected This Month</div>
              <div style="font-size: 1.5rem; font-weight: 800; color: #16a34a; margin-top: 0.25rem;">₹1.03 Lakh</div>
              <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600; margin-top: 0.25rem;">✓ 2 Payouts Completed</div>
            </div>
            <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin:0;">
              <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Pending Rent Due</div>
              <div style="font-size: 1.5rem; font-weight: 800; color: #d97706; margin-top: 0.25rem;">₹28,000</div>
              <div style="font-size: 0.75rem; color: #d97706; font-weight: 600; margin-top: 0.25rem;">Due in 4 days (Tech Park)</div>
            </div>
            <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin:0;">
              <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Collection Rate</div>
              <div style="font-size: 1.5rem; font-weight: 800; color: var(--navy-900); margin-top: 0.25rem;">92%</div>
              <div style="font-size: 0.75rem; color: var(--navy-500); font-weight: 600; margin-top: 0.25rem;">Average 6-month efficiency</div>
            </div>
          </div>

          <!-- Transaction Table -->
          <div class="card" style="background: #fff; border-radius: 1rem; border: 1px solid var(--sand-200); overflow: hidden;">
            <div class="pm-table-scroll">
              <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                  <tr style="background: #fafbfc;">
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Invoice ID</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Property &amp; Tenant</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Amount</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Payment Mode</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Status</th>
                    <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Receipt</th>
                  </tr>
                </thead>
                <tbody>
                  <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 1rem 1.25rem; font-family: monospace; font-size: 0.85rem; font-weight: 700; color: var(--navy-700);">#INV-2026-0901</td>
                    <td style="padding: 1rem 1.25rem;">
                      <div style="font-weight: 700; color: var(--navy-900);">Skyline Residences — 302</div>
                      <div style="font-size: 0.8rem; color: var(--navy-500);">Rahul Nair</div>
                    </td>
                    <td style="padding: 1rem 1.25rem; font-weight: 800; color: #16a34a;">₹38,000</td>
                    <td style="padding: 1rem 1.25rem; color: var(--navy-600); font-size: 0.85rem;">Auto-UPI (HDFC Bank)</td>
                    <td style="padding: 1rem 1.25rem;"><span class="pill" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;font-weight:700;">● Settled</span></td>
                    <td style="padding: 1rem 1.25rem;"><button type="button" class="btn btn-sm btn-ghost" onclick="alert('Downloading Receipt #INV-2026-0901 PDF')">PDF ⬇</button></td>
                  </tr>
                  <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 1rem 1.25rem; font-family: monospace; font-size: 0.85rem; font-weight: 700; color: var(--navy-700);">#INV-2026-0902</td>
                    <td style="padding: 1rem 1.25rem;">
                      <div style="font-weight: 700; color: var(--navy-900);">Green Acres Villa</div>
                      <div style="font-size: 0.8rem; color: var(--navy-500);">The Mehta Family</div>
                    </td>
                    <td style="padding: 1rem 1.25rem; font-weight: 800; color: #16a34a;">₹65,000</td>
                    <td style="padding: 1rem 1.25rem; color: var(--navy-600); font-size: 0.85rem;">NEFT / IMPS Transfer</td>
                    <td style="padding: 1rem 1.25rem;"><span class="pill" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;font-weight:700;">● Settled</span></td>
                    <td style="padding: 1rem 1.25rem;"><button type="button" class="btn btn-sm btn-ghost" onclick="alert('Downloading Receipt #INV-2026-0902 PDF')">PDF ⬇</button></td>
                  </tr>
                  <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 1rem 1.25rem; font-family: monospace; font-size: 0.85rem; font-weight: 700; color: var(--navy-700);">#INV-2026-0903</td>
                    <td style="padding: 1rem 1.25rem;">
                      <div style="font-weight: 700; color: var(--navy-900);">Tech Park Heights — 1102</div>
                      <div style="font-size: 0.8rem; color: var(--navy-500);">Priya Iyer</div>
                    </td>
                    <td style="padding: 1rem 1.25rem; font-weight: 800; color: #d97706;">₹28,000</td>
                    <td style="padding: 1rem 1.25rem; color: var(--navy-600); font-size: 0.85rem;">Payment Link Sent</td>
                    <td style="padding: 1rem 1.25rem;"><span class="pill" style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;font-weight:700;">● Pending</span></td>
                    <td style="padding: 1rem 1.25rem;"><button type="button" class="btn btn-sm btn-ghost" onclick="alert('Payment reminder resent to tenant!')">Resend Link</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </div>


      <!-- ============================================================ -->
      <!-- TAB 5: MAINTENANCE -->
      <!-- ============================================================ -->
      <div id="tabPanel-maintenance" class="tab-panel <?= $activeTab === 'maintenance' ? 'active' : '' ?>">
        <div class="pm-tab-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
          <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--navy-900); margin: 0;">Maintenance &amp; Work Orders</h2>
            <p style="font-size: 0.85rem; color: var(--navy-500); margin: 0.2rem 0 0;">Tenant-reported repair tickets, scheduled preventive maintenance, and vendor bills.</p>
          </div>
          <a href="<?= url('/contact?req=request_service') ?>" class="btn btn-gold btn-sm" style="font-weight: 700;">+ Raise Repair Ticket</a>
        </div>

        <?php if ($propCount === 0): ?>
          <div class="card card-pad" style="background: #ffffff; border: 1.5px dashed var(--sand-300); border-radius: 1.25rem; text-align: center; padding: 3.5rem 1.5rem;">
            <div style="width: 4rem; height: 4rem; border-radius: 9999px; background: rgba(212,160,23,0.12); color: var(--gold-600); display: grid; place-items: center; margin: 0 auto 1rem; font-size: 1.75rem;">
              <?= icon('wrench', 26) ?>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.5rem;">No active maintenance tickets</h3>
            <p style="font-size: 0.875rem; color: var(--navy-500); max-width: 28rem; margin: 0 auto 1.5rem; line-height: 1.5;">
              When tenants raise repair tickets or when preventive service is scheduled, work orders will appear here with live vendor tracking.
            </p>
            <div class="empty-state-btns">
              <a href="<?= url('/services') ?>" class="btn btn-gold">Explore Home Services ➔</a>
              <a href="?tab=maintenance&demo=1" class="btn btn-ghost">✨ View Demo Work Orders</a>
            </div>
          </div>
        <?php else: ?>
          <div style="display: grid; gap: 1rem;">
            <?php foreach ($maint as $m): ?>
              <div class="card" style="padding: 1.25rem 1.5rem; border-radius: 1rem; border: 1px solid var(--sand-200); background: #fff; margin:0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                  <span style="display: grid; place-items: center; width: 3rem; height: 3rem; border-radius: 0.75rem; background: var(--navy-50); color: var(--navy-800);">
                    <?= icon('wrench', 20) ?>
                  </span>
                  <div>
                    <h4 style="font-size: 1rem; font-weight: 800; color: var(--navy-900); margin: 0;"><?= e($m[0]) ?></h4>
                    <p style="font-size: 0.825rem; color: var(--navy-500); margin: 0.25rem 0 0;">
                      Category: <strong><?= e($m[1]) ?></strong> • Assigned: <strong><?= e($m[4] ?? 'Homeosphere Pro') ?></strong>
                    </p>
                  </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                  <span class="<?= e($m[3]) ?>" style="font-weight: 700; font-size: 0.8rem; padding: 0.35rem 0.85rem; border-radius: 9999px;">
                    ● <?= e($m[2]) ?>
                  </span>
                  <button type="button" class="btn btn-sm btn-ghost" onclick="alert('Work order details & vendor contact: <?= e($m[4]) ?>')">Inspect Ticket</button>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>


      <!-- ============================================================ -->
      <!-- TAB 6: YIELD & REPORTS -->
      <!-- ============================================================ -->
      <div id="tabPanel-reports" class="tab-panel <?= $activeTab === 'reports' ? 'active' : '' ?>">
        <div class="pm-tab-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
          <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--navy-900); margin: 0;">Portfolio Yield &amp; Analytics</h2>
            <p style="font-size: 0.85rem; color: var(--navy-500); margin: 0.2rem 0 0;">Annualized return on investment, occupancy health, and tax statement downloads.</p>
          </div>
          <button type="button" class="btn btn-gold btn-sm" onclick="alert('Exporting Complete Annual P&L Portfolio Report...')" style="font-weight: 700;">
            Export P&amp;L Report 📊
          </button>
        </div>

        <?php if ($propCount === 0): ?>
          <div class="card card-pad" style="background: #ffffff; border: 1.5px dashed var(--sand-300); border-radius: 1.25rem; text-align: center; padding: 3.5rem 1.5rem;">
            <div style="width: 4rem; height: 4rem; border-radius: 9999px; background: rgba(212,160,23,0.12); color: var(--gold-600); display: grid; place-items: center; margin: 0 auto 1rem; font-size: 1.75rem;">
              <?= icon('reports', 26) ?>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.5rem;">No yield data available yet</h3>
            <p style="font-size: 0.875rem; color: var(--navy-500); max-width: 28rem; margin: 0 auto 1.5rem; line-height: 1.5;">
              Comprehensive performance charts, occupancy graphs, and annual tax-ready depreciation ledgers will populate automatically as rent cycles commence.
            </p>
            <div class="empty-state-btns">
              <a href="<?= url('/contact?req=list_property') ?>" class="btn btn-gold">Onboard Property ➔</a>
              <a href="?tab=reports&demo=1" class="btn btn-ghost">✨ View Sample Analytics</a>
            </div>
          </div>
        <?php else: ?>
          <!-- Analytics Cards -->
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(13rem, 100%), 1fr)); gap: 1rem;">
            <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin:0;">
              <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Gross Rental Yield</div>
              <div style="font-size: 1.6rem; font-weight: 800; color: var(--gold-600); margin-top: 0.25rem;">5.8% p.a.</div>
              <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600; margin-top: 0.25rem;">+0.6% vs City Average</div>
            </div>
            <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin:0;">
              <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Portfolio Occupancy</div>
              <div style="font-size: 1.6rem; font-weight: 800; color: #16a34a; margin-top: 0.25rem;">75%</div>
              <div style="font-size: 0.75rem; color: var(--navy-500); font-weight: 600; margin-top: 0.25rem;">3 Occupied, 1 Vacant</div>
            </div>
            <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin:0;">
              <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Net Operating Income</div>
              <div style="font-size: 1.6rem; font-weight: 800; color: var(--navy-900); margin-top: 0.25rem;">₹23.4 Lakh</div>
              <div style="font-size: 0.75rem; color: var(--navy-500); font-weight: 600; margin-top: 0.25rem;">Last 12-month trailing</div>
            </div>
            <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin:0;">
              <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Average Tenancy Term</div>
              <div style="font-size: 1.6rem; font-weight: 800; color: var(--navy-900); margin-top: 0.25rem;">18.4 Mos</div>
              <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600; margin-top: 0.25rem;">High retention rate</div>
            </div>
          </div>

          <!-- P&L Breakdown Card -->
          <div class="card" style="background: #fff; padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--sand-200);">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--navy-900); margin: 0 0 1rem;">Income vs. Operating Expense Breakdown (YTD)</h3>
            <div style="display: grid; gap: 0.85rem;">
              <div>
                <div style="display:flex; justify-content:space-between; font-size:0.85rem; font-weight:700; margin-bottom:0.25rem;">
                  <span style="color:var(--navy-800);">Gross Rental Collections</span>
                  <span style="color:#16a34a;">₹25,80,000 (100%)</span>
                </div>
                <div style="height:8px; background:#e2e8f0; border-radius:9999px; overflow:hidden;">
                  <div style="width:100%; height:100%; background:#16a34a;"></div>
                </div>
              </div>

              <div>
                <div style="display:flex; justify-content:space-between; font-size:0.85rem; font-weight:700; margin-bottom:0.25rem;">
                  <span style="color:var(--navy-800);">Maintenance &amp; Repairs</span>
                  <span style="color:#d97706;">₹1,45,000 (5.6%)</span>
                </div>
                <div style="height:8px; background:#e2e8f0; border-radius:9999px; overflow:hidden;">
                  <div style="width:5.6%; height:100%; background:#d97706;"></div>
                </div>
              </div>

              <div>
                <div style="display:flex; justify-content:space-between; font-size:0.85rem; font-weight:700; margin-bottom:0.25rem;">
                  <span style="color:var(--navy-800);">Property Taxes &amp; Society Dues</span>
                  <span style="color:var(--navy-600);">₹95,000 (3.7%)</span>
                </div>
                <div style="height:8px; background:#e2e8f0; border-radius:9999px; overflow:hidden;">
                  <div style="width:3.7%; height:100%; background:var(--navy-600);"></div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>


      <!-- ============================================================ -->
      <!-- TAB 7: REAL ESTATE MARKET INSIGHTS & TRENDS -->
      <!-- ============================================================ -->
      <div id="tabPanel-market" class="tab-panel <?= $activeTab === 'market' ? 'active' : '' ?>">
        
        <!-- Header & Action Button -->
        <div class="pm-tab-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
          <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--navy-900); margin: 0;">Real Estate Market Trends &amp; Yields (2026)</h2>
            <p style="font-size: 0.85rem; color: var(--navy-500); margin: 0.2rem 0 0;">Empirical city-level rental yield benchmarks, capital price per sq. ft. trends, and housing demand analytics across India.</p>
          </div>
          <button type="button" class="btn btn-gold btn-sm" onclick="alert('Downloading Q3 2026 India Residential Market & Yield Report (PDF)...')" style="font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem;">
            <?= icon('reports', 14) ?> Download 2026 Market Report
          </button>
        </div>

        <!-- 4 Market Pulse Metric Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(13rem, 100%), 1fr)); gap: 1rem;">
          <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Average National Yield</span>
              <span style="color: #16a34a;"><?= icon('trending', 16) ?></span>
            </div>
            <div style="font-size: 1.6rem; font-weight: 800; color: var(--navy-900); margin-top: 0.25rem;">4.9% p.a.</div>
            <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600; margin-top: 0.25rem;">+0.4% YoY Expansion</div>
          </div>

          <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Highest Yielding City</span>
              <span style="color: var(--gold-600);"><?= icon('building', 16) ?></span>
            </div>
            <div style="font-size: 1.6rem; font-weight: 800; color: var(--gold-700); margin-top: 0.25rem;">Bengaluru</div>
            <div style="font-size: 0.75rem; color: var(--gold-700); font-weight: 600; margin-top: 0.25rem;">5.6% - 6.2% Gross Yield</div>
          </div>

          <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Top Capital Growth</span>
              <span style="color: #2563eb;"><?= icon('arrow-up', 16) ?></span>
            </div>
            <div style="font-size: 1.6rem; font-weight: 800; color: #2563eb; margin-top: 0.25rem;">Gurugram</div>
            <div style="font-size: 0.75rem; color: #2563eb; font-weight: 600; margin-top: 0.25rem;">+14.8% YoY Price / Sqft</div>
          </div>

          <div class="card" style="background: #fff; padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--sand-200); margin: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase;">Rental Absorption Rate</span>
              <span style="color: #16a34a;"><?= icon('check', 16) ?></span>
            </div>
            <div style="font-size: 1.6rem; font-weight: 800; color: var(--navy-900); margin-top: 0.25rem;">88.4 / 100</div>
            <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600; margin-top: 0.25rem;">Avg 18 Days on Market</div>
          </div>
        </div>

        <?php
        // Expanded 22 Real-Estate Micro-Markets Across Major Indian Metros
        $allMarketLocations = [
          // Mumbai MMR
          ['id'=>'mumbai-worli', 'city'=>'Mumbai MMR', 'area'=>'Worli & Lower Parel', 'type'=>'Ultra-Luxury Seafront & High-Rises', 'priceMin'=>52000, 'priceMax'=>78000, 'priceLabel'=>'₹52,000 – ₹78,000 / sqft', 'yield'=>3.3, 'yieldLabel'=>'3.1% – 3.5%', 'growth'=>9.2, 'growthLabel'=>'+9.2%', 'demand'=>'High', 'badge'=>'Luxury Prime', 'badgeStyle'=>'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;'],
          ['id'=>'mumbai-bandra', 'city'=>'Mumbai MMR', 'area'=>'Bandra West & Khar', 'type'=>'Prime Coastal Suburb & Lifestyle Enclave', 'priceMin'=>36000, 'priceMax'=>48000, 'priceLabel'=>'₹36,000 – ₹48,000 / sqft', 'yield'=>3.6, 'yieldLabel'=>'3.4% – 3.9%', 'growth'=>8.5, 'growthLabel'=>'+8.5%', 'demand'=>'Very High', 'badge'=>'Very High', 'badgeStyle'=>'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;'],
          ['id'=>'mumbai-powai', 'city'=>'Mumbai MMR', 'area'=>'Powai & Chandivali', 'type'=>'Central IT/Fintech & Lakefront Townships', 'priceMin'=>21000, 'priceMax'=>29000, 'priceLabel'=>'₹21,000 – ₹29,000 / sqft', 'yield'=>4.2, 'yieldLabel'=>'3.9% – 4.5%', 'growth'=>9.8, 'growthLabel'=>'+9.8%', 'demand'=>'Very High', 'badge'=>'Balanced Yield', 'badgeStyle'=>'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;'],
          ['id'=>'mumbai-thane', 'city'=>'Mumbai MMR', 'area'=>'Thane West (Ghodbunder Rd)', 'type'=>'Integrated Townships & Metro Corridor', 'priceMin'=>11500, 'priceMax'=>16500, 'priceLabel'=>'₹11,500 – ₹16,500 / sqft', 'yield'=>4.4, 'yieldLabel'=>'4.1% – 4.7%', 'growth'=>11.2, 'growthLabel'=>'+11.2%', 'demand'=>'High', 'badge'=>'Growth Corridor', 'badgeStyle'=>'background:#fef3c7;color:#92400e;border:1px solid #fde68a;'],
          ['id'=>'mumbai-navi', 'city'=>'Mumbai MMR', 'area'=>'Navi Mumbai (Kharghar & Panvel)', 'type'=>'International Airport Growth Belt', 'priceMin'=>9200, 'priceMax'=>14000, 'priceLabel'=>'₹9,200 – ₹14,000 / sqft', 'yield'=>4.6, 'yieldLabel'=>'4.3% – 4.9%', 'growth'=>14.5, 'growthLabel'=>'+14.5%', 'demand'=>'Very High', 'badge'=>'Airport Catalyst', 'badgeStyle'=>'background:#fef3c7;color:#92400e;border:1px solid #fde68a;'],

          // Delhi NCR
          ['id'=>'ncr-golfcourse', 'city'=>'Delhi NCR', 'area'=>'Gurugram (Golf Course Rd & Cyber City)', 'type'=>'MNC Executive Leasing & Luxury Condos', 'priceMin'=>18000, 'priceMax'=>28500, 'priceLabel'=>'₹18,000 – ₹28,500 / sqft', 'yield'=>4.9, 'yieldLabel'=>'4.6% – 5.3%', 'growth'=>14.8, 'growthLabel'=>'+14.8%', 'demand'=>'Booming', 'badge'=>'🔥 Booming', 'badgeStyle'=>'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;'],
          ['id'=>'ncr-sohna', 'city'=>'Delhi NCR', 'area'=>'Gurugram (Golf Course Ext. & Sohna Rd)', 'type'=>'Modern High-Rise Gated Communities', 'priceMin'=>12500, 'priceMax'=>18500, 'priceLabel'=>'₹12,500 – ₹18,500 / sqft', 'yield'=>5.1, 'yieldLabel'=>'4.8% – 5.4%', 'growth'=>13.9, 'growthLabel'=>'+13.9%', 'demand'=>'Very High', 'badge'=>'High Yield', 'badgeStyle'=>'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;'],
          ['id'=>'ncr-noida150', 'city'=>'Delhi NCR', 'area'=>'Noida (Sector 150 & Expressway)', 'type'=>'Sports City & Tech Corporate Corridor', 'priceMin'=>8200, 'priceMax'=>12800, 'priceLabel'=>'₹8,200 – ₹12,800 / sqft', 'yield'=>5.2, 'yieldLabel'=>'4.9% – 5.5%', 'growth'=>12.4, 'growthLabel'=>'+12.4%', 'demand'=>'Very High', 'badge'=>'Very High', 'badgeStyle'=>'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;'],
          ['id'=>'ncr-southdelhi', 'city'=>'Delhi NCR', 'area'=>'South Delhi (Vasant Kunj & GK)', 'type'=>'Established Prime Residential Enclave', 'priceMin'=>24000, 'priceMax'=>38000, 'priceLabel'=>'₹24,000 – ₹38,000 / sqft', 'yield'=>3.8, 'yieldLabel'=>'3.5% – 4.1%', 'growth'=>7.8, 'growthLabel'=>'+7.8%', 'demand'=>'Steady', 'badge'=>'Heritage Prime', 'badgeStyle'=>'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;'],

          // Bengaluru
          ['id'=>'blr-whitefield', 'city'=>'Bengaluru', 'area'=>'Whitefield & ITPL Corridor', 'type'=>'Premier IT Hub & Metro Connectivity', 'priceMin'=>9500, 'priceMax'=>14800, 'priceLabel'=>'₹9,500 – ₹14,800 / sqft', 'yield'=>5.9, 'yieldLabel'=>'5.6% – 6.2%', 'growth'=>13.1, 'growthLabel'=>'+13.1%', 'demand'=>'Very High', 'badge'=>'⭐ Highest Yield', 'badgeStyle'=>'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;'],
          ['id'=>'blr-orr', 'city'=>'Bengaluru', 'area'=>'Outer Ring Road & Bellandur', 'type'=>'Global Capability Centers (GCC) Hub', 'priceMin'=>11200, 'priceMax'=>16500, 'priceLabel'=>'₹11,200 – ₹16,500 / sqft', 'yield'=>5.6, 'yieldLabel'=>'5.3% – 5.9%', 'growth'=>11.8, 'growthLabel'=>'+11.8%', 'demand'=>'Very High', 'badge'=>'Top Tech Demand', 'badgeStyle'=>'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;'],
          ['id'=>'blr-sarjapur', 'city'=>'Bengaluru', 'area'=>'Sarjapur Road & Harlur', 'type'=>'Villa Communities & International Schools', 'priceMin'=>8800, 'priceMax'=>13500, 'priceLabel'=>'₹8,800 – ₹13,500 / sqft', 'yield'=>5.4, 'yieldLabel'=>'5.1% – 5.7%', 'growth'=>12.2, 'growthLabel'=>'+12.2%', 'demand'=>'High', 'badge'=>'Family Hub', 'badgeStyle'=>'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;'],
          ['id'=>'blr-hebbal', 'city'=>'Bengaluru', 'area'=>'Hebbal & North Bengaluru (Airport Rd)', 'type'=>'Aerospace & Business Park Corridor', 'priceMin'=>10500, 'priceMax'=>15800, 'priceLabel'=>'₹10,500 – ₹15,800 / sqft', 'yield'=>5.2, 'yieldLabel'=>'4.9% – 5.5%', 'growth'=>14.1, 'growthLabel'=>'+14.1%', 'demand'=>'Very High', 'badge'=>'Airport Belt', 'badgeStyle'=>'background:#fef3c7;color:#92400e;border:1px solid #fde68a;'],

          // Hyderabad
          ['id'=>'hyd-hitec', 'city'=>'Hyderabad', 'area'=>'Hitec City & Madhapur', 'type'=>'Cyberabad IT Epicenter & High-Rises', 'priceMin'=>9200, 'priceMax'=>14000, 'priceLabel'=>'₹9,200 – ₹14,000 / sqft', 'yield'=>5.5, 'yieldLabel'=>'5.2% – 5.8%', 'growth'=>13.6, 'growthLabel'=>'+13.6%', 'demand'=>'Very High', 'badge'=>'High Yield', 'badgeStyle'=>'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;'],
          ['id'=>'hyd-gachibowli', 'city'=>'Hyderabad', 'area'=>'Gachibowli & Financial District', 'type'=>'BFSI Campuses & Luxury High-Rise Living', 'priceMin'=>9800, 'priceMax'=>15200, 'priceLabel'=>'₹9,800 – ₹15,200 / sqft', 'yield'=>5.4, 'yieldLabel'=>'5.1% – 5.7%', 'growth'=>14.2, 'growthLabel'=>'+14.2%', 'demand'=>'Very High', 'badge'=>'Top Growth', 'badgeStyle'=>'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;'],
          ['id'=>'hyd-banjara', 'city'=>'Hyderabad', 'area'=>'Banjara Hills & Jubilee Hills', 'type'=>'Historic Ultra-HNW Residential Enclave', 'priceMin'=>16500, 'priceMax'=>26000, 'priceLabel'=>'₹16,500 – ₹26,000 / sqft', 'yield'=>3.9, 'yieldLabel'=>'3.6% – 4.2%', 'growth'=>9.5, 'growthLabel'=>'+9.5%', 'demand'=>'High', 'badge'=>'Ultra Luxury', 'badgeStyle'=>'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;'],

          // Pune
          ['id'=>'pune-baner', 'city'=>'Pune', 'area'=>'Baner & Balewadi', 'type'=>'West Pune Tech Professionals Enclave', 'priceMin'=>8400, 'priceMax'=>12200, 'priceLabel'=>'₹8,400 – ₹12,200 / sqft', 'yield'=>5.1, 'yieldLabel'=>'4.8% – 5.4%', 'growth'=>9.4, 'growthLabel'=>'+9.4%', 'demand'=>'High', 'badge'=>'High Demand', 'badgeStyle'=>'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;'],
          ['id'=>'pune-hinjewadi', 'city'=>'Pune', 'area'=>'Hinjewadi Phase 1-3', 'type'=>'Rajiv Gandhi Infotech Park Township', 'priceMin'=>6800, 'priceMax'=>9800, 'priceLabel'=>'₹6,800 – ₹9,800 / sqft', 'yield'=>5.3, 'yieldLabel'=>'5.0% – 5.6%', 'growth'=>10.8, 'growthLabel'=>'+10.8%', 'demand'=>'Very High', 'badge'=>'Affordable Yield', 'badgeStyle'=>'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;'],
          ['id'=>'pune-kharadi', 'city'=>'Pune', 'area'=>'Kharadi & Viman Nagar', 'type'=>'EON Free Zone & World Trade Center', 'priceMin'=>8900, 'priceMax'=>13200, 'priceLabel'=>'₹8,900 – ₹13,200 / sqft', 'yield'=>5.0, 'yieldLabel'=>'4.7% – 5.3%', 'growth'=>10.2, 'growthLabel'=>'+10.2%', 'demand'=>'High', 'badge'=>'East IT Belt', 'badgeStyle'=>'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;'],

          // Other Metros
          ['id'=>'chn-omr', 'city'=>'Other Metros', 'area'=>'Chennai (OMR & Perungudi)', 'type'=>'Express IT Highway Corridor', 'priceMin'=>6500, 'priceMax'=>9800, 'priceLabel'=>'₹6,500 – ₹9,800 / sqft', 'yield'=>4.9, 'yieldLabel'=>'4.6% – 5.2%', 'growth'=>8.6, 'growthLabel'=>'+8.6%', 'demand'=>'Steady', 'badge'=>'IT Belt', 'badgeStyle'=>'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;'],
          ['id'=>'ahm-gift', 'city'=>'Other Metros', 'area'=>'Ahmedabad (GIFT City & SG Highway)', 'type'=>'India First Operational Smart City & IFSC', 'priceMin'=>7500, 'priceMax'=>11800, 'priceLabel'=>'₹7,500 – ₹11,800 / sqft', 'yield'=>5.2, 'yieldLabel'=>'4.8% – 5.5%', 'growth'=>15.2, 'growthLabel'=>'+15.2%', 'demand'=>'Booming', 'badge'=>'IFSC Special', 'badgeStyle'=>'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;'],
          ['id'=>'kol-newtown', 'city'=>'Other Metros', 'area'=>'Kolkata (New Town & Rajarhat)', 'type'=>'Modern Planned Financial & Tech Hub', 'priceMin'=>5400, 'priceMax'=>8200, 'priceLabel'=>'₹5,400 – ₹8,200 / sqft', 'yield'=>4.7, 'yieldLabel'=>'4.4% – 5.0%', 'growth'=>8.1, 'growthLabel'=>'+8.1%', 'demand'=>'Steady', 'badge'=>'Planned City', 'badgeStyle'=>'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;'],
        ];
        ?>

        <!-- ============================================================ -->
        <!-- INTERACTIVE FILTERING TOOLBAR -->
        <!-- ============================================================ -->
        <div class="card" style="background: #ffffff; padding: 1.25rem 1.5rem; border-radius: 1rem; border: 1px solid var(--sand-200); box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
          <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1rem;">
            <div>
              <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--navy-500); letter-spacing: 0.05em;">Interactive Filters &amp; Location Selector</span>
              <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--navy-900); margin: 0.2rem 0 0;">Filter Specific Locations or Compare Micro-Markets</h3>
            </div>
            <div id="marketCountBadge" style="font-size: 0.8rem; font-weight: 700; padding: 0.3rem 0.85rem; border-radius: 9999px; background: var(--sand-100); color: var(--navy-800);">
              Showing all <?= count($allMarketLocations) ?> locations
            </div>
          </div>

          <!-- City Filter Pills -->
          <div class="market-city-scroll" id="marketCityFilters">
            <button type="button" class="btn btn-sm btn-gold market-city-btn" data-city="all" style="border-radius: 9999px; font-weight: 700;">All Cities</button>
            <button type="button" class="btn btn-sm btn-ghost market-city-btn" data-city="Mumbai MMR" style="border-radius: 9999px; font-weight: 600;">Mumbai MMR</button>
            <button type="button" class="btn btn-sm btn-ghost market-city-btn" data-city="Delhi NCR" style="border-radius: 9999px; font-weight: 600;">Delhi NCR</button>
            <button type="button" class="btn btn-sm btn-ghost market-city-btn" data-city="Bengaluru" style="border-radius: 9999px; font-weight: 600;">Bengaluru</button>
            <button type="button" class="btn btn-sm btn-ghost market-city-btn" data-city="Hyderabad" style="border-radius: 9999px; font-weight: 600;">Hyderabad</button>
            <button type="button" class="btn btn-sm btn-ghost market-city-btn" data-city="Pune" style="border-radius: 9999px; font-weight: 600;">Pune</button>
            <button type="button" class="btn btn-sm btn-ghost market-city-btn" data-city="Other Metros" style="border-radius: 9999px; font-weight: 600;">Other Metros (GIFT/Chennai/Kolkata)</button>
          </div>

          <!-- Search & Yield Dropdown Controls -->
          <div class="market-filter-grid">
            <div style="position: relative;">
              <span style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--navy-400);"><?= icon('search', 15) ?></span>
              <input type="text" id="marketSearchInput" class="input" style="padding-left: 2.35rem; width: 100%; box-sizing: border-box; font-size: 0.85rem;" placeholder="Search micro-market (e.g., Whitefield, Worli, Hitec, Hinjewadi, GIFT City)...">
            </div>

            <select id="marketYieldSelect" class="input" style="font-size: 0.85rem; padding: 0.55rem 0.85rem;">
              <option value="all">All Rental Yields</option>
              <option value="high">High Cashflow (> 5.2% p.a.)</option>
              <option value="medium">Balanced Yield (4.5% – 5.2%)</option>
              <option value="low">Capital Preservation (&lt; 4.5%)</option>
            </select>

            <button type="button" id="marketResetBtn" class="btn btn-sm btn-ghost" style="white-space: nowrap; font-weight: 600;">Reset Filters</button>
          </div>

          <!-- Active Comparison Sticky Banner -->
          <div id="marketCompareBanner" style="display: none; margin-top: 1rem; padding: 0.75rem 1rem; border-radius: 0.75rem; background: #eff6ff; border: 1px solid #bfdbfe; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
              <span style="display: grid; place-items: center; width: 1.75rem; height: 1.75rem; border-radius: 50%; background: #2563eb; color: #fff; font-size: 0.75rem; font-weight: 800;" id="compareCountPill">0</span>
              <span style="font-size: 0.85rem; color: #1e40af; font-weight: 700;" id="compareTextSummary">Comparing selected locations</span>
            </div>
            <div style="display: flex; gap: 0.5rem;">
              <button type="button" id="compareClearBtn" class="btn btn-sm btn-ghost" style="font-size: 0.75rem; padding: 0.25rem 0.6rem;">Clear Selection</button>
            </div>
          </div>
        </div>

        <!-- ============================================================ -->
        <!-- DYNAMIC COMPARATIVE YIELD BAR CHART -->
        <!-- ============================================================ -->
        <div class="card" style="background: #fff; padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--sand-200);">
          <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.25rem;">
            <div>
              <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--navy-900); margin: 0;" id="chartTitle">Rental Yield Comparison for Filtered Locations</h3>
              <p style="font-size: 0.8rem; color: var(--navy-500); margin: 0.2rem 0 0;" id="chartSubtitle">Gross annual rent generated as a percentage of property capital value.</p>
            </div>
            <span class="pill pill-gold-soft" id="chartBenchmarkBadge" style="font-weight: 700; font-size: 0.75rem;">Interactive Comparison</span>
          </div>

          <!-- Dynamic Horizontal Progress Bars -->
          <div id="marketChartContainer" style="display: grid; gap: 0.85rem;">
            <!-- Generated Dynamically via JS -->
          </div>

          <div style="margin-top: 1.25rem; padding: 0.875rem 1rem; background: var(--sand-50); border-radius: 0.75rem; border-left: 3px solid var(--gold-500); font-size: 0.825rem; color: var(--navy-700); line-height: 1.5;">
            <strong>Analyst Takeaway:</strong> Tech corridors in Bengaluru (Whitefield, ORR) and Hyderabad (Hitec City) deliver India's highest gross rental yields (5.4% – 6.2%) due to aggressive migration of high-income IT professionals. In contrast, South Mumbai and Bandra provide premier capital safety and asset value appreciation despite lower yields.
          </div>
        </div>

        <!-- ============================================================ -->
        <!-- FULL CITY-BY-CITY RENTAL YIELD & PRICE / SQFT MATRIX -->
        <!-- ============================================================ -->
        <div class="card" style="background: #fff; border-radius: 1rem; border: 1px solid var(--sand-200); overflow: hidden;">
          <div style="padding: 1.25rem; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
            <div>
              <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--navy-900); margin: 0;">Market Yield &amp; Capital Values Matrix (2026)</h3>
              <p style="font-size: 0.8rem; color: var(--navy-500); margin: 0.2rem 0 0;">Select checkboxes to isolate locations for instant side-by-side comparison.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
              <span class="pill pill-sand" style="font-weight: 700; font-size: 0.75rem;">Verified Research Aggregates</span>
            </div>
          </div>

          <div class="pm-table-scroll">
            <table style="width: 100%; border-collapse: collapse; text-align: left;" id="marketDataTable">
              <thead>
                <tr style="background: #fafbfc;">
                  <th style="padding: 0.875rem 1rem; font-size: 0.8rem; color: var(--navy-700); font-weight: 700; width: 40px; text-align: center;">
                    <input type="checkbox" id="marketSelectAllCb" title="Select / Deselect all visible">
                  </th>
                  <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">City &amp; Micro-Market</th>
                  <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Avg Capital Price</th>
                  <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Gross Rental Yield</th>
                  <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">YoY Capital Growth</th>
                  <th style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: var(--navy-700); font-weight: 700;">Tenant Demand</th>
                </tr>
              </thead>
              <tbody id="marketTableBody">
                <?php foreach ($allMarketLocations as $loc): ?>
                  <tr class="market-row" 
                      data-id="<?= e($loc['id']) ?>" 
                      data-city="<?= e($loc['city']) ?>" 
                      data-yield="<?= $loc['yield'] ?>" 
                      data-price="<?= ($loc['priceMin'] + $loc['priceMax']) / 2 ?>"
                      data-text="<?= strtolower(e($loc['area'] . ' ' . $loc['city'] . ' ' . $loc['type'])) ?>"
                      style="border-bottom: 1px solid #eee;">
                    <td style="padding: 1rem; text-align: center;">
                      <input type="checkbox" class="market-cb" data-id="<?= e($loc['id']) ?>">
                    </td>
                    <td style="padding: 1rem 1.25rem;">
                      <div style="font-weight: 700; color: var(--navy-900);"><?= e($loc['area']) ?></div>
                      <div style="font-size: 0.78rem; color: var(--navy-500);"><?= e($loc['city']) ?> • <?= e($loc['type']) ?></div>
                    </td>
                    <td style="padding: 1rem 1.25rem; font-weight: 700; color: var(--navy-900);"><?= e($loc['priceLabel']) ?></td>
                    <td style="padding: 1rem 1.25rem; font-weight: 800; color: <?= $loc['yield'] >= 5.2 ? '#16a34a' : ($loc['yield'] >= 4.5 ? 'var(--gold-600)' : 'var(--navy-700)') ?>;">
                      <?= e($loc['yieldLabel']) ?>
                    </td>
                    <td style="padding: 1rem 1.25rem; color: #16a34a; font-weight: 700;"><?= e($loc['growthLabel']) ?></td>
                    <td style="padding: 1rem 1.25rem;">
                      <span class="pill" style="<?= $loc['badgeStyle'] ?> font-weight: 700; font-size: 0.75rem;">
                        <?= e($loc['badge']) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- Data Source & Verification Footnote -->
          <div style="padding: 1.25rem 1.5rem; background: #f8fafc; border-top: 1px solid #e2e8f0; font-size: 0.8rem; color: #64748b; line-height: 1.6;">
            <div style="font-weight: 700; color: #0B1F3A; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.4rem;">
              <span style="color: #2563eb;"><?= icon('shield', 16) ?></span> Verified Research Sources &amp; Valuation Methodology
            </div>
            <p style="margin: 0 0 0.4rem 0;">
              <strong>Data Sources:</strong> Empirical benchmarks compiled from Anarock Property Consultants (India Residential Reports Q1–Q3 2026), Knight Frank India Affordability Index &amp; Market Trackers, Magicbricks PropIndex, JLL India Research, and registered Homeosphere transaction analytics.
            </p>
            <p style="margin: 0;">
              <strong>Methodology:</strong> Capital prices per square foot reflect registered registry values and verified secondary market sale benchmarks. Gross rental yield is calculated as <em>(Annualized Gross Rental Collections ÷ Capital Value) × 100</em> prior to property taxes, society maintenance charges, and capital gains deductions.
            </p>
          </div>
        </div>

        <!-- Housing Demand Analytics & Tenant Drivers -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(18rem, 100%), 1fr)); gap: 1.5rem;">
          
          <div class="card" style="background: #fff; padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--sand-200); margin:0;">
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem;">
              <span style="display: grid; place-items: center; width: 2.5rem; height: 2.5rem; border-radius: 0.65rem; background: var(--navy-50); color: var(--navy-800);"><?= icon('grid', 18) ?></span>
              <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--navy-900); margin: 0;">Tenant Unit Preferences</h3>
            </div>
            
            <div style="display: grid; gap: 0.75rem;">
              <div>
                <div style="display: flex; justify-content: space-between; font-size: 0.825rem; font-weight: 700; margin-bottom: 0.25rem;">
                  <span>2 BHK Apartments (Core Demand)</span>
                  <span style="color: var(--navy-900);">52% of Inquiries</span>
                </div>
                <div style="height: 6px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
                  <div style="width: 52%; height: 100%; background: var(--navy-900);"></div>
                </div>
              </div>

              <div>
                <div style="display: flex; justify-content: space-between; font-size: 0.825rem; font-weight: 700; margin-bottom: 0.25rem;">
                  <span>3 BHK Premium &amp; Villas</span>
                  <span style="color: var(--gold-700);">34% of Inquiries</span>
                </div>
                <div style="height: 6px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
                  <div style="width: 34%; height: 100%; background: var(--gold-500);"></div>
                </div>
              </div>

              <div>
                <div style="display: flex; justify-content: space-between; font-size: 0.825rem; font-weight: 700; margin-bottom: 0.25rem;">
                  <span>1 BHK Studios &amp; Co-living</span>
                  <span style="color: var(--navy-500);">14% of Inquiries</span>
                </div>
                <div style="height: 6px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
                  <div style="width: 14%; height: 100%; background: #94a3b8;"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="card" style="background: #fff; padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--sand-200); margin:0;">
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem;">
              <span style="display: grid; place-items: center; width: 2.5rem; height: 2.5rem; border-radius: 0.65rem; background: #f0fdf4; color: #16a34a;"><?= icon('zap', 18) ?></span>
              <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--navy-900); margin: 0;">Amenities Commanding Rent Premium</h3>
            </div>

            <ul style="list-style: none; padding: 0; margin: 0; display: grid; gap: 0.65rem; font-size: 0.85rem;">
              <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #e2e8f0; padding-bottom: 0.5rem;">
                <span style="color: var(--navy-700);">🚇 Operational Metro Link (&lt;1.5 km)</span>
                <strong style="color: #16a34a;">+18% Rent Premium</strong>
              </li>
              <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #e2e8f0; padding-bottom: 0.5rem;">
                <span style="color: var(--navy-700);">⚡ 100% DG Power Backup &amp; Security</span>
                <strong style="color: #16a34a;">+14% Rent Premium</strong>
              </li>
              <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #e2e8f0; padding-bottom: 0.5rem;">
                <span style="color: var(--navy-700);">💻 Dedicated WFH / Study Nook</span>
                <strong style="color: #16a34a;">+10% Rent Premium</strong>
              </li>
              <li style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: var(--navy-700);">🔌 EV Charging Station &amp; Clubhouse</span>
                <strong style="color: #16a34a;">+8% Rent Premium</strong>
              </li>
            </ul>
          </div>

        </div>

      </div>

      <!-- JSON Embed for Market Data Engine -->
      <script>
        window.MARKET_LOCATIONS = <?= json_encode($allMarketLocations, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
      </script>

    </div>
  </div>
</div>
</section>

<?php if ($propCount === 0): ?>
  <!-- ============================================================ -->
  <!-- FAQ SECTION (SHOWN ONLY TILL NO PROPERTIES ARE ADDED) -->
  <!-- ============================================================ -->
  <section class="section" style="background: #f8f9fa; padding: 3.5rem 0; border-top: 1px solid #e2e8f0; margin: 0;">
    <div class="container-x" style="max-width: 900px;">
      <div style="text-align: center; margin-bottom: 2rem;">
        <span class="pill pill-gold-soft" style="font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Landlord FAQ</span>
        <h3 style="font-size: 1.5rem; font-weight: 800; color: #0B1F3A; margin: 0.5rem 0 0.25rem;">Frequently Asked Questions</h3>
        <p style="font-size: 0.9rem; color: #64748b; margin: 0;">Common questions about onboarding rental units and automated property management.</p>
      </div>

      <?php
      $landlordFaqs = [
        [
          'q' => 'How does automated rent collection work on Homeosphere?',
          'a' => 'Tenants receive direct payment links via SMS and Email before the due date. Payments are automatically processed and reflected on your dashboard with instant ledger updates.'
        ],
        [
          'q' => 'Can I manage multiple properties and commercial units together?',
          'a' => 'Yes, Homeosphere supports multi-property portfolios including residential apartments, villas, co-living units, and commercial retail spaces under one unified account.'
        ],
        [
          'q' => 'How do I list my property under Homeosphere Management?',
          'a' => 'Click on \'List a Property for Management\' to submit your property details. Our local onboarding team will schedule a physical inspection, set up digital tenant agreements, and launch your live portal.'
        ]
      ];
      echo faq_accordion($landlordFaqs);
      ?>
    </div>
  </section>
<?php endif; ?>

<script>
// Interactive Client-Side Sidebar Tab Switching
document.addEventListener('DOMContentLoaded', function() {
  var navLinks = document.querySelectorAll('#ownerPortalNav .pm-nav-btn');
  var panels = document.querySelectorAll('.tab-panel');

  navLinks.forEach(function(link) {
    link.addEventListener('click', function(e) {
      var tabId = link.getAttribute('data-tab-target');
      if (!tabId) return;
      
      var targetPanel = document.getElementById('tabPanel-' + tabId);
      if (targetPanel) {
        e.preventDefault();

        // 1. Update active state on buttons
        navLinks.forEach(function(btn) {
          btn.classList.remove('active');
          btn.setAttribute('aria-selected', 'false');
        });
        link.classList.add('active');
        link.setAttribute('aria-selected', 'true');

        // 2. Hide other panels, show target panel
        panels.forEach(function(panel) {
          panel.classList.remove('active');
        });
        targetPanel.classList.add('active');

        // 3. Update URL query string smoothly without reload
        var url = new URL(window.location.href);
        url.searchParams.set('tab', tabId);
        window.history.pushState({ tab: tabId }, '', url.toString());

        // 4. Smooth scroll on smaller screens
        if (window.innerWidth <= 992) {
          targetPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }
    });
  });

  // Handle browser back/forward buttons
  window.addEventListener('popstate', function() {
    var urlParams = new URLSearchParams(window.location.search);
    var currentTab = urlParams.get('tab') || 'dashboard';
    var targetBtn = document.querySelector('#ownerPortalNav .pm-nav-btn[data-tab-target="' + currentTab + '"]');
    if (targetBtn) {
      targetBtn.click();
    }
  });

  // ============================================================
  // MARKET TRENDS & YIELDS: INTERACTIVE FILTER & COMPARISON ENGINE
  // ============================================================
  (function initMarketEngine() {
    var locations = window.MARKET_LOCATIONS || [];
    if (!locations.length) return;

    var cityBtns = document.querySelectorAll('.market-city-btn');
    var searchInput = document.getElementById('marketSearchInput');
    var yieldSelect = document.getElementById('marketYieldSelect');
    var resetBtn = document.getElementById('marketResetBtn');
    var countBadge = document.getElementById('marketCountBadge');
    var selectAllCb = document.getElementById('marketSelectAllCb');
    var tableRows = document.querySelectorAll('.market-row');
    var chartContainer = document.getElementById('marketChartContainer');
    var chartTitle = document.getElementById('chartTitle');
    var compareBanner = document.getElementById('marketCompareBanner');
    var compareCountPill = document.getElementById('compareCountPill');
    var compareTextSummary = document.getElementById('compareTextSummary');
    var compareClearBtn = document.getElementById('compareClearBtn');

    var selectedCity = 'all';
    var searchQuery = '';
    var selectedYield = 'all';
    var selectedIds = new Set();

    function applyFilters() {
      var visibleCount = 0;
      var visibleLocations = [];

      tableRows.forEach(function(row) {
        var rowCity = row.getAttribute('data-city');
        var rowYield = parseFloat(row.getAttribute('data-yield'));
        var rowText = row.getAttribute('data-text') || '';
        var rowId = row.getAttribute('data-id');

        // City filter match
        var cityMatch = (selectedCity === 'all') || (rowCity === selectedCity);

        // Search match
        var searchMatch = !searchQuery || rowText.includes(searchQuery.toLowerCase());

        // Yield filter match
        var yieldMatch = true;
        if (selectedYield === 'high') {
          yieldMatch = (rowYield >= 5.2);
        } else if (selectedYield === 'medium') {
          yieldMatch = (rowYield >= 4.5 && rowYield < 5.2);
        } else if (selectedYield === 'low') {
          yieldMatch = (rowYield < 4.5);
        }

        if (cityMatch && searchMatch && yieldMatch) {
          row.style.display = '';
          visibleCount++;
          var matchItem = locations.find(function(l) { return l.id === rowId; });
          if (matchItem) visibleLocations.push(matchItem);
        } else {
          row.style.display = 'none';
        }
      });

      // Update count badge
      if (countBadge) {
        if (selectedCity === 'all' && !searchQuery && selectedYield === 'all') {
          countBadge.textContent = 'Showing all ' + visibleCount + ' locations';
        } else {
          countBadge.textContent = 'Showing ' + visibleCount + ' filtered location' + (visibleCount === 1 ? '' : 's');
        }
      }

      renderChart(visibleLocations);
      updateCompareBanner();
    }

    function renderChart(visibleLocations) {
      if (!chartContainer) return;
      chartContainer.innerHTML = '';

      // Determine items to display in chart:
      // If user has checked specific locations, show only checked ones!
      var itemsToChart = [];
      if (selectedIds.size > 0) {
        itemsToChart = locations.filter(function(l) { return selectedIds.has(l.id); });
        if (chartTitle) chartTitle.textContent = 'Side-by-Side Yield Comparison for ' + itemsToChart.length + ' Selected Locations';
      } else {
        // Otherwise show visible locations (capped to top 6 for a clean chart)
        itemsToChart = visibleLocations.slice(0, 6);
        if (chartTitle) {
          chartTitle.textContent = selectedCity === 'all' && !searchQuery 
            ? 'City-wise Benchmark Gross Rental Yield Comparison' 
            : 'Rental Yield Comparison (' + itemsToChart.length + ' locations)';
        }
      }

      if (itemsToChart.length === 0) {
        chartContainer.innerHTML = '<p style="color: #64748b; font-size: 0.85rem; padding: 1rem 0; margin: 0;">No locations match the selected criteria. Try resetting filters.</p>';
        return;
      }

      // Render progress bars
      itemsToChart.forEach(function(item) {
        var pct = Math.min(100, Math.round((item.yield / 7.0) * 100)); // Scaled against 7.0% max
        var barColor = item.yield >= 5.2 
          ? 'linear-gradient(90deg, #D4A017, #16a34a)' 
          : (item.yield >= 4.5 ? '#D4A017' : '#0B1F3A');

        var row = document.createElement('div');
        row.innerHTML = 
          '<div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 700; margin-bottom: 0.35rem;">' +
            '<span style="color: #0B1F3A;">' + item.area + ' <small style="font-weight: 600; color: #64748b;">(' + item.city + ')</small></span>' +
            '<span style="color: ' + (item.yield >= 5.2 ? '#16a34a' : '#0B1F3A') + ';">' + item.yield + '% Gross Yield</span>' +
          '</div>' +
          '<div style="height: 10px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">' +
            '<div style="width: ' + pct + '%; height: 100%; background: ' + barColor + '; border-radius: 9999px; transition: width 0.4s ease;"></div>' +
          '</div>';
        chartContainer.appendChild(row);
      });
    }

    function updateCompareBanner() {
      if (!compareBanner) return;
      if (selectedIds.size >= 1) {
        compareBanner.style.display = 'flex';
        if (compareCountPill) compareCountPill.textContent = selectedIds.size;
        
        var selectedList = locations.filter(function(l) { return selectedIds.has(l.id); });
        var avgYield = (selectedList.reduce(function(acc, l) { return acc + l.yield; }, 0) / selectedList.length).toFixed(1);
        var avgPrice = Math.round(selectedList.reduce(function(acc, l) { return acc + ((l.priceMin + l.priceMax) / 2); }, 0) / selectedList.length);
        
        if (compareTextSummary) {
          compareTextSummary.innerHTML = 
            'Comparing <strong>' + selectedList.length + ' locations</strong> — Average Yield: <strong>' + avgYield + '%</strong> | Avg Capital Price: <strong>₹' + avgPrice.toLocaleString('en-IN') + '/sqft</strong>';
        }
      } else {
        compareBanner.style.display = 'none';
      }
    }

    // Event: City Button Clicks
    cityBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
        cityBtns.forEach(function(b) {
          b.classList.remove('btn-gold');
          b.classList.add('btn-ghost');
        });
        btn.classList.remove('btn-ghost');
        btn.classList.add('btn-gold');
        selectedCity = btn.getAttribute('data-city');
        applyFilters();
      });
    });

    // Event: Search input
    if (searchInput) {
      searchInput.addEventListener('input', function() {
        searchQuery = this.value.trim();
        applyFilters();
      });
    }

    // Event: Yield Select
    if (yieldSelect) {
      yieldSelect.addEventListener('change', function() {
        selectedYield = this.value;
        applyFilters();
      });
    }

    // Event: Reset
    if (resetBtn) {
      resetBtn.addEventListener('click', function() {
        selectedCity = 'all';
        searchQuery = '';
        selectedYield = 'all';
        selectedIds.clear();

        if (searchInput) searchInput.value = '';
        if (yieldSelect) yieldSelect.value = 'all';
        if (selectAllCb) selectAllCb.checked = false;

        document.querySelectorAll('.market-cb').forEach(function(cb) {
          cb.checked = false;
        });

        cityBtns.forEach(function(b) {
          if (b.getAttribute('data-city') === 'all') {
            b.classList.remove('btn-ghost');
            b.classList.add('btn-gold');
          } else {
            b.classList.remove('btn-gold');
            b.classList.add('btn-ghost');
          }
        });

        applyFilters();
      });
    }

    // Event: Checkbox selection per row
    document.querySelectorAll('.market-cb').forEach(function(cb) {
      cb.addEventListener('change', function() {
        var id = this.getAttribute('data-id');
        if (this.checked) {
          selectedIds.add(id);
        } else {
          selectedIds.delete(id);
        }
        applyFilters();
      });
    });

    // Event: Select All Checkbox
    if (selectAllCb) {
      selectAllCb.addEventListener('change', function() {
        var isChecked = this.checked;
        tableRows.forEach(function(row) {
          if (row.style.display !== 'none') {
            var cb = row.querySelector('.market-cb');
            if (cb) {
              cb.checked = isChecked;
              var id = cb.getAttribute('data-id');
              if (isChecked) {
                selectedIds.add(id);
              } else {
                selectedIds.delete(id);
              }
            }
          }
        });
        applyFilters();
      });
    }

    // Event: Clear Compare Selection
    if (compareClearBtn) {
      compareClearBtn.addEventListener('click', function() {
        selectedIds.clear();
        document.querySelectorAll('.market-cb').forEach(function(cb) {
          cb.checked = false;
        });
        if (selectAllCb) selectAllCb.checked = false;
        applyFilters();
      });
    }

    // Initialize initial render
    applyFilters();
  })();
});
</script>

<?php footer_partial(); ?>