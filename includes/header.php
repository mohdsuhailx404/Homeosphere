<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/icon.php';

function head(array $opts = []): void {
  $title        = $opts['title']       ?? SITE_NAME . ' — ' . SITE_TAGLINE;
  $description  = $opts['description'] ?? 'Homeosphere is India\'s complete home ecosystem — discover properties, buy/sell/rent homes, hire verified professionals, manage properties, and access all home services from one platform.';
  $canonical    = $opts['canonical']   ?? '/';
  $canonicalUrl = absolute_url($canonical);
  $keywords     = $opts['keywords']    ?? 'Homeosphere, real estate India, verified property listings, hire professionals, home services, buy sell rent homes, property management';
  $ogType       = $opts['ogType']      ?? 'website';
  $noindex      = $opts['noindex']     ?? false;
  $robots       = $noindex ? 'noindex,nofollow' : 'index,follow,max-image-preview:large';
  $jsonld       = $opts['jsonld']      ?? null;
  $ogImage      = !empty($opts['image']) ? (str_starts_with($opts['image'], 'http') ? $opts['image'] : absolute_url($opts['image'])) : absolute_url('/assets/img/og-image.jpg');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#0b1f3a">
  <link rel="icon" type="image/webp" href="<?= asset('img/homeospherelogo.webp') ?>">
  <link rel="apple-touch-icon" href="<?= asset('img/homeospherelogo.webp') ?>">
  <title><?= e($title) ?></title>
  
  <?php if (!empty($keywords)): ?>
  <meta name="keywords" content="<?= htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8') ?>">
  <?php endif; ?>

  <meta name="description" content="<?= e($description) ?>">
  <meta name="robots" content="<?= e($robots) ?>">
  <link rel="canonical" href="<?= e($canonicalUrl) ?>">
  
  <!-- Open Graph / Facebook / LinkedIn / WhatsApp -->
  <meta property="og:type" content="<?= e($ogType) ?>">
  <meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
  <meta property="og:title" content="<?= e($title) ?>">
  <meta property="og:description" content="<?= e($description) ?>">
  <meta property="og:url" content="<?= e($canonicalUrl) ?>">
  <meta property="og:image" content="<?= e($ogImage) ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="<?= e($title) ?>">

  <!-- Twitter / X Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@homeosphere">
  <meta name="twitter:creator" content="@homeosphere">
  <meta name="twitter:title" content="<?= e($title) ?>">
  <meta name="twitter:description" content="<?= e($description) ?>">
  <meta name="twitter:image" content="<?= e($ogImage) ?>">
  <meta name="twitter:image:alt" content="<?= e($title) ?>">

  <!-- Google AdSense Auto-Ads (Activates when ADSENSE_PUB_ID is configured) -->
  <?php if (defined('ADSENSE_PUB_ID') && !empty(ADSENSE_PUB_ID)): ?>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?= e(ADSENSE_PUB_ID) ?>" crossorigin="anonymous"></script>
  <?php endif; ?>

  <!-- Performance & Resource Hints -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="dns-prefetch" href="https://fonts.googleapis.com">
  <link rel="dns-prefetch" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;0,9..144,700;0,9..144,800;1,9..144,400;1,9..144,500;1,9..144,600&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=DM+Mono:ital,wght@0,400;0,500;1,400&family=Bricolage+Grotesque:wght@500;600;700;800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
  <?php if (!empty($opts['extra_css'])): ?>
    <?php foreach ((array)$opts['extra_css'] as $cssUrl): ?>
      <link rel="stylesheet" href="<?= e($cssUrl) ?>">
    <?php endforeach; ?>
  <?php endif; ?>

  <!-- Structured Data (JSON-LD) -->
  <?php
  $schema = $jsonld ?: [
      '@context' => 'https://schema.org',
      '@graph'   => [
          [
              '@type'        => 'WebSite',
              '@id'          => absolute_url('/#website'),
              'url'          => absolute_url('/'),
              'name'         => SITE_NAME,
              'description'  => SITE_TAGLINE,
              'potentialAction' => [
                  '@type'       => 'SearchAction',
                  'target'      => absolute_url('/properties?q={search_term_string}'),
                  'query-input' => 'required name=search_term_string'
              ]
          ],
          [
              '@type'        => 'Organization',
              '@id'          => absolute_url('/#organization'),
              'name'         => SITE_NAME,
              'url'          => absolute_url('/'),
              'logo'         => absolute_url('/assets/img/homeospherelogo.webp'),
              'email'        => defined('SITE_EMAIL') ? SITE_EMAIL : 'hello@homeosphere.com',
              'telephone'    => defined('SITE_PHONE') ? SITE_PHONE : '+91 90000 00000',
              'address'      => [
                  '@type'           => 'PostalAddress',
                  'streetAddress'   => 'Cyber City',
                  'addressLocality' => 'Gurugram',
                  'addressRegion'   => 'Haryana',
                  'postalCode'      => '122002',
                  'addressCountry'  => 'IN'
              ],
              'sameAs'       => [
                  'https://www.instagram.com/homeosphere.in?stkn=MTFocjBnenBibGxj',
                  'https://www.facebook.com/profile.php?id=100078204634544',
                  'https://www.linkedin.com/company/homeosphere/about/',
                  'https://x.com/homeosphere',
                  'https://medium.com/@deeksha_48830',
                  'https://homeosphere.substack.com'
              ]
          ]
      ]
  ];
  ?>
  <script type="application/ld+json">
  <?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?>
  </script>

  <script>
    window.CURRENT_USER = <?= json_encode(current_user() ?: null, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
  </script>
</head>
<?php
}

function header_partial(string $active = ''): void {
  $navBefore = [
    ['clean'=>url('/'), 'label'=>'Home', 'key'=>'home'],
    ['clean'=>url('/about'), 'label'=>'About', 'key'=>'about', 'aliases'=>['user', 'roles', 'user_roles', 'user-roles']],
  ];

  $solutionsNav = [
    [
      'href'  => url('/properties'),
      'label' => 'Properties',
      'desc'  => 'Find verified homes to buy & rent',
      'key'   => 'properties',
      'icon'  => 'building',
      'color' => '#2563eb',
      'bg'    => 'rgba(37, 99, 235, 0.1)'
    ],
    [
      'href'  => url('/services'),
      'label' => 'Home Services',
      'desc'  => 'Book repairs, maintenance & renovations',
      'key'   => 'services',
      'icon'  => 'wrench',
      'color' => '#d4a017',
      'bg'    => 'rgba(212, 160, 23, 0.12)'
    ],
    [
      'href'  => url('/professionals'),
      'label' => 'Professionals',
      'desc'  => 'Hire background-verified specialists',
      'key'   => 'professionals',
      'icon'  => 'users',
      'color' => '#10b981',
      'bg'    => 'rgba(16, 185, 129, 0.1)'
    ],
  ];

  $navAfter = [
    ['clean'=>url('/insights'), 'label'=>'Insights', 'key'=>'insights', 'aliases'=>['management', 'property-management']],
    ['clean'=>url('/blogs'), 'label'=>'Blogs', 'key'=>'blogs', 'aliases'=>['blog']],
    ['clean'=>url('/contact'), 'label'=>'Contact', 'key'=>'contact'],
  ];

  $isSolutionsActive = in_array($active, ['properties', 'services', 'professionals']);
?>
<body>
<a href="#main" class="skip-link">Skip to content</a>
<header class="site-header">
  <div class="container-x site-header-inner">
    
    <!-- Logo with Visible Icon -->
    <a href="<?= url('/') ?>" class="site-header-brand">
      <img src="<?= url('/assets/img/homeospherelogo.webp') ?>" 
           alt="Homeosphere Logo">
      <span>Home<span>osphere</span></span>
    </a>

    <!-- Primary Nav Links -->
    <nav class="nav-links">
      <!-- Home, About, User -->
      <?php foreach ($navBefore as $item): 
        $isActive = ($active === $item['key'] || in_array($active, $item['aliases'] ?? []));
      ?>
        <a href="<?= $item['clean'] ?>" 
           class="nav-link <?= $isActive ? 'active' : '' ?>">
          <?= e($item['label']) ?>
        </a>
      <?php endforeach; ?>

      <!-- Solutions Dropdown for Properties, Home Services, and Professionals -->
      <div class="nav-dropdown">
        <button type="button" 
                class="nav-dropdown-toggle <?= $isSolutionsActive ? 'active' : '' ?>" 
                aria-expanded="false" 
                aria-haspopup="true">
          <span>Solutions</span>
          <svg class="dropdown-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </button>

        <div class="nav-dropdown-menu">
          
          <?php foreach ($solutionsNav as $s): 
            $isItemActive = ($active === $s['key']);
          ?>
            <a href="<?= $s['href'] ?>" 
               class="nav-dropdown-item <?= $isItemActive ? 'active' : '' ?>" 
               style="display: flex; align-items: center; gap: 0.75rem; padding: 0.65rem 0.85rem; border-radius: 0.75rem; text-decoration: none; color: #0b1f3a; transition: background 0.15s, transform 0.15s; <?= $isItemActive ? 'background: #f1f5f9;' : '' ?>">
              <span style="width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; background: <?= $s['bg'] ?>; color: <?= $s['color'] ?>; display: grid; place-items: center; flex-shrink: 0;">
                <?= icon($s['icon'], 16) ?>
              </span>
              <div>
                <div style="font-size: 0.875rem; font-weight: 700; color: <?= $isItemActive ? '#b8860b' : '#0b1f3a' ?>; line-height: 1.2;">
                  <?= e($s['label']) ?>
                </div>
                <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.15rem; line-height: 1.3;">
                  <?= e($s['desc']) ?>
                </div>
              </div>
            </a>
          <?php endforeach; ?>

        </div>
      </div>

      <!-- Insights, Blogs -->
      <?php foreach ($navAfter as $item): 
        $isActive = ($active === $item['key'] || in_array($active, $item['aliases'] ?? []));
      ?>
        <a href="<?= $item['clean'] ?>" 
           class="nav-link <?= $isActive ? 'active' : '' ?>">
          <?= e($item['label']) ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <?php 
    $currentUser = current_user();
    $isAuthed = ($currentUser !== null);
    ?>

    <!-- Actions / CTA -->
    <div class="header-actions">
      <?php if ($isAuthed): ?>
        <!-- Authenticated User Profile Pill & Dropdown -->
        <div class="user-nav-wrap">
          <button type="button" class="user-nav-pill" id="userMenuToggle" aria-haspopup="true" aria-expanded="false" title="<?= e($currentUser['name']) ?>">
            <span class="user-avatar-circle"><?= e(user_initials($currentUser['name'])) ?></span>
            <span class="user-pill-info hide-mobile">
              <span class="user-pill-name"><?= e(explode(' ', $currentUser['name'])[0]) ?></span>
              <span class="user-pill-role"><?= e(role_label($currentUser['role'])) ?></span>
            </span>
            <svg class="hide-mobile" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--navy-400);margin-left:0.1rem;"><polyline points="6 9 12 15 18 9"></polyline></svg>
          </button>
          
          <div class="user-dropdown-menu" id="userDropdownMenu" role="menu">
            <div class="user-dropdown-header">
              <div class="name"><?= e($currentUser['name']) ?></div>
              <div class="email"><?= e($currentUser['email']) ?></div>
              <span class="pill" style="font-size:0.7rem;font-weight:700;padding:0.2rem 0.6rem;background:rgba(212,160,23,0.12);color:var(--gold-700);border-radius:9999px;">
                <?= e(role_label($currentUser['role'])) ?>
              </span>
            </div>
            
            <a href="<?= url('/dashboard') ?>" class="user-dropdown-link" role="menuitem">
              <?= icon('user', 16) ?>
              <span>My Profile &amp; Dashboard</span>
            </a>
            <a href="<?= url('/dashboard#saved') ?>" class="user-dropdown-link" role="menuitem">
              <?= icon('heart', 16) ?>
              <span>Saved Properties</span>
            </a>
            <a href="<?= url('/dashboard#bookings') ?>" class="user-dropdown-link" role="menuitem">
              <?= icon('calendar', 16) ?>
              <span>Active Bookings</span>
            </a>
            
            <div style="border-top:1px solid var(--sand-100,#f1f5f9);margin:0.35rem 0;"></div>
            
            <a href="<?= url('/logout') ?>" class="user-dropdown-link logout" role="menuitem">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
              <span>Sign Out</span>
            </a>
          </div>
        </div>
      <?php else: ?>
        <a href="<?= url('/login') ?>" class="header-signin-btn hide-mobile">Sign In</a>
        <a href="<?= url('/signup') ?>" class="header-cta">Get Started</a>
      <?php endif; ?>
      <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false" style="background: #ffffff; border: 1px solid var(--sand-200); border-radius: 0.625rem; padding: 0.5rem; cursor: pointer; color: #0b1f3a;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </button>
    </div>

  </div>
</header>

<!-- Mobile Drawer Navigation (Fixed Viewport Slide-Out) -->
<div class="mobile-drawer" id="mobileMenu" aria-hidden="true">
  <div class="mobile-drawer-backdrop" id="mobileDrawerBackdrop"></div>
  <div class="mobile-drawer-panel" role="dialog" aria-modal="true" aria-label="Mobile Navigation">
    
    <!-- Drawer Header -->
    <div class="mobile-drawer-head">
      <a href="<?= url('/') ?>" class="mobile-drawer-brand">
        <img src="<?= url('/assets/img/homeospherelogo.webp') ?>" alt="Homeosphere" style="height: 2rem; width: auto; object-fit: contain;">
        <span>Home<span style="color: #b8860b;">osphere</span></span>
      </a>
      <button type="button" class="mobile-drawer-close" id="mobileDrawerClose" aria-label="Close menu">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

    <!-- Drawer Scrollable Content -->
    <div class="mobile-drawer-body">
      
      <!-- Primary Navigation -->
      <div class="mobile-nav-group-title">Navigation</div>
      <div class="mobile-nav-links">
        <?php foreach ($navBefore as $item): 
          $isActive = ($active === $item['key'] || in_array($active, $item['aliases'] ?? []));
        ?>
          <a href="<?= $item['clean'] ?>" class="mobile-nav-item <?= $isActive ? 'active' : '' ?>">
            <span><?= e($item['label']) ?></span>
            <?= icon('arrow-right', 14) ?>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Solutions -->
      <div class="mobile-nav-group-title" style="margin-top: 1.25rem;">Marketplaces &amp; Solutions</div>
      <div class="mobile-nav-links">
        <?php foreach ($solutionsNav as $s): 
          $isItemActive = ($active === $s['key']);
        ?>
          <a href="<?= $s['href'] ?>" class="mobile-nav-item <?= $isItemActive ? 'active' : '' ?>">
            <span style="display: flex; align-items: center; gap: 0.65rem;">
              <span style="display: grid; place-items: center; width: 1.85rem; height: 1.85rem; border-radius: 0.45rem; background: <?= $s['bg'] ?>; color: <?= $s['color'] ?>;">
                <?= icon($s['icon'], 15) ?>
              </span>
              <span><?= e($s['label']) ?></span>
            </span>
            <?= icon('arrow-right', 14) ?>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Platform & Media -->
      <div class="mobile-nav-group-title" style="margin-top: 1.25rem;">Platform &amp; Media</div>
      <div class="mobile-nav-links">
        <?php foreach ($navAfter as $item): 
          $isActive = ($active === $item['key'] || in_array($active, $item['aliases'] ?? []));
        ?>
          <a href="<?= $item['clean'] ?>" class="mobile-nav-item <?= $isActive ? 'active' : '' ?>">
            <span><?= e($item['label']) ?></span>
            <?= icon('arrow-right', 14) ?>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- User Account Section -->
      <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--sand-200);">
        <?php if ($isAuthed): ?>
          <div class="mobile-user-box">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.85rem;">
              <span class="user-avatar-circle" style="width: 2.65rem; height: 2.65rem; font-size: 0.9rem; flex-shrink: 0;"><?= e(user_initials($currentUser['name'])) ?></span>
              <div style="flex: 1; min-width: 0;">
                <div style="font-weight: 800; color: var(--navy-900); font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= e($currentUser['name']) ?></div>
                <span class="pill" style="font-size: 0.68rem; font-weight: 700; padding: 0.15rem 0.5rem; background: rgba(212,160,23,0.12); color: var(--gold-700);"><?= e(role_label($currentUser['role'])) ?></span>
              </div>
            </div>
            
            <div style="display: grid; gap: 0.25rem;">
              <a href="<?= url('/dashboard') ?>" class="mobile-user-link">
                <?= icon('user', 15) ?> <span>My Profile &amp; Dashboard</span>
              </a>
              <a href="<?= url('/dashboard#saved') ?>" class="mobile-user-link">
                <?= icon('heart', 15) ?> <span>Saved Properties</span>
              </a>
              <a href="<?= url('/dashboard#bookings') ?>" class="mobile-user-link">
                <?= icon('calendar', 15) ?> <span>Active Bookings</span>
              </a>
              <a href="<?= url('/logout') ?>" class="mobile-user-link" style="color: #dc2626; border-top: 1px dashed var(--sand-200); padding-top: 0.5rem; margin-top: 0.35rem;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                <span>Sign Out</span>
              </a>
            </div>
          </div>
        <?php else: ?>
          <div style="display: grid; gap: 0.6rem;">
            <a href="<?= url('/signup') ?>" class="btn btn-gold btn-block" style="text-align: center; justify-content: center; font-weight: 700; padding: 0.75rem 1rem;">Get Started Free ➔</a>
            <a href="<?= url('/login') ?>" class="btn btn-ghost btn-block" style="text-align: center; justify-content: center; font-weight: 700; padding: 0.75rem 1rem;">Sign In</a>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>

<main id="main">
<?php
}