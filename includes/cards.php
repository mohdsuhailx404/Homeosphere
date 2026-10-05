<?php
require_once __DIR__ . '/icon.php';

/** Render a property card. */
function property_card(array $p): string {
  ob_start();
  $amenities = array_slice($p['amenities'], 0, 3);
  $extra = count($p['amenities']) > 3 ? count($p['amenities']) - 3 : 0;
  ?>
  <article class="card card-hover prop-card">
    <div class="prop-media">
      <img src="<?= e($p['image']) ?>" alt="<?= e($p['title']) ?>" loading="lazy">
      <div class="prop-badges">
        <div style="display:flex;gap:.5rem">
          <?php if ($p['tag']): ?><span class="pill pill-gold"><?= e($p['tag']) ?></span><?php endif; ?>
          <span class="pill glass" style="color:var(--navy-800)">For <?= $p['listing'] === 'Buy' ? 'Sale' : 'Rent' ?></span>
        </div>
      </div>
      <?php if ($p['verified']): ?>
        <span class="pill pill-navy prop-verified"><?= icon('badge', 14) ?> Verified</span>
      <?php endif; ?>
      <?php $isSaved = function_exists('user_has_saved_property') && user_has_saved_property((string)$p['id']); ?>
      <button type="button" 
              class="prop-favorite-btn <?= $isSaved ? 'is-saved' : '' ?>" 
              data-prop-id="<?= e($p['id']) ?>"
              title="<?= $isSaved ? 'Remove from saved' : 'Save property' ?>"
              aria-label="Save property">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="<?= $isSaved ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
        </svg>
      </button>
    </div>
    <div class="prop-body">
      <h3 class="prop-title"><?= e($p['title']) ?></h3>
      <p class="prop-loc" title="<?= e($p['location']) ?>">
        <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($p['title'] . ', ' . $p['location'] . ', ' . $p['city']) ?>" target="_blank" rel="noopener noreferrer" title="Open in Google Maps">
          <span style="display:inline-flex;align-items:center;flex-shrink:0;"><?= icon('map-pin', 16) ?></span>
          <span class="prop-loc-text"><?= e($p['location']) ?></span>
          <span style="font-size:0.75rem;opacity:0.7;flex-shrink:0;">↗</span>
        </a>
      </p>
      <?php
        $priceDisplay = $p['priceLabel'] ?? '';
        $priceDisplay = preg_replace('/(\d+),000\/mo/i', '${1}k/mo', $priceDisplay);
      ?>
      <div class="prop-price">
        <b class="prop-price-val"><?= e($priceDisplay) ?></b>
        <span class="pill pill-sand prop-type-pill"><?= e($p['type'] === 'Independent House' ? 'House' : $p['type']) ?></span>
      </div>
      <div class="prop-stats">
        <span class="prop-stat"><?= icon('bed', 16) ?> <?= (int)$p['beds'] ?> Beds</span>
        <span class="prop-stat"><?= icon('bath', 16) ?> <?= (int)$p['baths'] ?> Baths</span>
        <span class="prop-stat"><?= icon('maximize', 16) ?> <?= (int)$p['area'] ?> sqft</span>
      </div>
      <div class="prop-amenities">
        <?php foreach ($amenities as $a): ?><span class="pill pill-sand"><?= e($a) ?></span><?php endforeach; ?>
        <?php if ($extra): ?><span class="pill pill-sand">+<?= $extra ?></span><?php endif; ?>
      </div>
      <div class="prop-foot">
        <span class="prop-rating"><?= icon('star', 16) ?> <?= e($p['rating']) ?></span>
        <button class="btn btn-primary btn-sm view-details-btn" type="button" data-prop="<?= htmlspecialchars(json_encode($p, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8') ?>">View Details</button>
      </div>
    </div>
  </article>
  <?php
  return ob_get_clean();
}

/** Render a service card. */
function service_card(array $s): string {
  ob_start();
  ?>
  <article class="card card-hover svc-card">
    <div class="svc-media">
      <img src="<?= e($s['image']) ?>" alt="<?= e($s['name']) ?>" loading="lazy">
      <span class="pill glass svc-rating" style="color:var(--navy-800)"><?= icon('star', 14) ?> <?= e($s['rating']) ?></span>
    </div>
    <div class="svc-body">
      <h3 class="svc-name"><?= e($s['name']) ?></h3>
      <p class="svc-price">Starting from <b>₹<?= number_format((int)$s['start']) ?></b></p>
      <a href="<?= url('/contact?service=' . urlencode($s['name'])) ?>" class="btn btn-gold btn-block mt-4" style="text-align: center; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">Book Now</a>
    </div>
  </article>
  <?php
  return ob_get_clean();
}

/** Render a professional card. */
function professional_card(array $p): string {
  ob_start();
  $proName = $p['name'] ?? '';
  $proRole = $p['role'] ?? $p['title'] ?? '';
  $contactUrl = url('/contact?' . http_build_query(['pro' => $proName, 'role' => $proRole, 'req' => 'contact_pro']));
  ?>
  <article class="card card-hover card-pad" style="display: flex; flex-direction: column; height: 100%; box-sizing: border-box;">
    
    <!-- Profile Header with Image -->
    <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.25rem;">
      <img src="<?= e($p['img'] ?? $p['image'] ?? $p['avatar'] ?? '') ?>" alt="<?= e($p['name'] ?? '') ?>" loading="lazy" style="width: 4rem; height: 4rem; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
      <div style="flex-grow: 1; min-width: 0;">
        <h3 style="font-size: 1rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 0.25rem;">
          <?= e($p['name'] ?? '') ?> <span style="color: var(--primary);">✓</span>
        </h3>
        <p style="font-size: 0.875rem; font-weight: 600; color: var(--gold-600); margin: 0.125rem 0;"><?= e($p['role'] ?? $p['title'] ?? '') ?></p>
        <p style="font-size: 0.75rem; color: var(--navy-400); margin: 0; display: flex; align-items: center; gap: 0.25rem;"><?= icon('map-pin', 14) ?> <?= e($p['location'] ?? '') ?></p>
      </div>
    </div>

    <!-- Stats Box -->
    <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 0.5rem; text-align: center; margin-bottom: 1.25rem;">
      <div style="background: var(--sand-100, #f4f2ee); padding: 0.6rem 0.25rem; border-radius: 0.625rem; border: 1px solid var(--sand-200, #e6e2d8);">
        <p style="font-size: 0.875rem; font-weight: 800; color: var(--navy-900); margin: 0; display: flex; align-items: center; justify-content: center; gap: 0.3rem;">
          <span style="color: var(--gold-600); display: inline-flex;"><?= icon('briefcase', 14) ?></span>
          <span><?= e($p['exp'] ?? $p['experience'] ?? '0') ?> yrs</span>
        </p>
        <p style="font-size: 0.7rem; font-weight: 600; color: var(--navy-500); margin: 0.2rem 0 0;">Experience</p>
      </div>
      <div style="background: var(--sand-100, #f4f2ee); padding: 0.6rem 0.25rem; border-radius: 0.625rem; border: 1px solid var(--sand-200, #e6e2d8);">
        <p style="font-size: 0.875rem; font-weight: 800; color: var(--navy-900); margin: 0; display: flex; align-items: center; justify-content: center; gap: 0.3rem;">
          <span style="color: var(--gold-600); display: inline-flex;"><?= icon('building', 14) ?></span>
          <span><?= e($p['projects'] ?? '0') ?></span>
        </p>
        <p style="font-size: 0.7rem; font-weight: 600; color: var(--navy-500); margin: 0.2rem 0 0;">Projects</p>
      </div>
      <div style="background: var(--sand-100, #f4f2ee); padding: 0.6rem 0.25rem; border-radius: 0.625rem; border: 1px solid var(--sand-200, #e6e2d8);">
        <p style="font-size: 0.875rem; font-weight: 800; color: var(--navy-900); margin: 0; display: flex; align-items: center; justify-content: center; gap: 0.3rem;">
          <span style="color: var(--gold-500); display: inline-flex;"><?= icon('star', 13) ?></span>
          <span><?= e($p['rating'] ?? '5.0') ?></span>
        </p>
        <p style="font-size: 0.7rem; font-weight: 600; color: var(--navy-500); margin: 0.2rem 0 0;"><?= e($p['reviews'] ?? '0') ?> reviews</p>
      </div>
    </div>

    <!-- Tags -->
    <?php if (!empty($p['tags']) && is_array($p['tags'])): ?>
    <div style="display: flex; flex-wrap: wrap; gap: 0.375rem; margin-bottom: 1.25rem;">
      <?php foreach ($p['tags'] as $tag): ?>
        <span class="pill pill-sand" style="font-size: 0.75rem;"><?= e($tag) ?></span>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Portfolio Images -->
    <?php if (!empty($p['portfolio']) && is_array($p['portfolio'])): ?>
    <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 0.5rem; margin-bottom: 1.5rem;">
      <?php foreach ($p['portfolio'] as $img): ?>
        <img src="<?= e($img) ?>" alt="Portfolio" loading="lazy" style="width: 100%; height: 3.5rem; object-fit: cover; border-radius: 0.375rem;">
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Action Button (Pushed to bottom properly) -->
    <div style="margin-top: auto; padding-top: 0.5rem;">
      <a href="<?= $contactUrl ?>" class="btn btn-primary btn-block" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; text-align: center; font-weight: 700; padding: 0.65rem 1rem; border-radius: 0.75rem;">Contact</a>
    </div>

  </article>
  <?php
  return ob_get_clean();
}

/** Render a blog card. */
function blog_card(array $p): string {
  ob_start();
  $hasQuote = !empty($p['quote']);
  ?>
  <a class="card card-hover blog-card" href="/blogs/<?= e($p['slug']) ?>">
    <div class="blog-media">
      <img src="<?= e($p['image']) ?>" alt="<?= e($p['title']) ?>" loading="lazy">
      <span class="pill glass blog-cat" style="color:var(--navy-900);font-weight:700;"><?= e($p['category']) ?></span>
      <?php if (!empty($p['source_name']) && ($p['source'] ?? '') !== 'internal'): ?>
        <span class="blog-platform-badge blog-badge-<?= e($p['source'] ?? 'default') ?>">
          <?= e($p['source_name']) ?>
        </span>
      <?php endif; ?>
    </div>
    <div class="blog-body">
      <?php if ($hasQuote): ?>
        <div class="blog-card-quote">
          <span class="quote-mark">“</span><?= e(mb_strimwidth($p['quote'], 0, 95, '...')) ?>
        </div>
      <?php endif; ?>
      <h3 class="blog-title"><?= e($p['title']) ?></h3>
      <p class="blog-excerpt"><?= e($p['excerpt']) ?></p>
      <div class="blog-foot">
        <span style="display:flex;align-items:center;gap:.375rem"><?= icon('user', 14) ?> <?= e($p['author']) ?></span>
        <span style="display:flex;align-items:center;gap:.375rem"><?= icon('clock', 14) ?> <?= e($p['read']) ?></span>
      </div>
    </div>
  </a>
  <?php
  return ob_get_clean();
}

/** Render a testimonial card. */
function testimonial_card(array $t): string {
  ob_start();
  ?>
  <article class="card tst-card">
    <div class="tst-quote"><?= icon('quote', 28) ?></div>
    <div class="tst-stars">
      <?php for ($i = 0; $i < (int)$t['rating']; $i++): ?><span style="color:var(--gold-500)"><?= icon('star', 16) ?></span><?php endfor; ?>
    </div>
    <p class="tst-text">"<?= e($t['text']) ?>"</p>
    <div class="tst-author">
      <img class="tst-avatar" src="<?= e($t['avatar']) ?>" alt="<?= e($t['name']) ?>" loading="lazy">
      <div>
        <p class="tst-name"><?= e($t['name']) ?></p>
        <p class="tst-role"><?= e($t['role']) ?></p>
      </div>
    </div>
  </article>
  <?php
  return ob_get_clean();
}

/** Section heading. */
function section_heading(string $eyebrow, string $title, string $subtitle = '', bool $center = true): string {
  ob_start();
  ?>
  <div class="<?= $center ? 'mx-auto max-w-2xl center' : 'max-w-2xl' ?>">
    <?php if ($eyebrow): ?><p class="eyebrow" style="margin-bottom:.75rem"><?= e($eyebrow) ?></p><?php endif; ?>
    <h2 class="section-title"><?= e($title) ?></h2>
    <?php if ($subtitle): ?><p class="mt-4" style="font-size:1.1rem;color:var(--navy-500)"><?= e($subtitle) ?></p><?php endif; ?>
  </div>
  <?php
  return ob_get_clean();
}

/** CTA band. */
function cta_band(string $title, string $subtitle, array $primary = ['label'=>'Get Started','href'=>'/signup'], ?array $secondary = null): string {
  ob_start();
  ?>
  <div class="cta-band">
    <div class="cta-grid">
      <div>
        <h2><?= e($title) ?></h2>
        <?php if ($subtitle): ?><p><?= e($subtitle) ?></p><?php endif; ?>
      </div>
      <div class="cta-actions">
        <a class="btn btn-gold btn-lg" href="<?= e($primary['href'] ?? '/signup') ?>"><?= e($primary['label'] ?? 'Get Started') ?> <?= icon('arrow-right', 16) ?></a>
        <?php if ($secondary): ?><a class="btn btn-light btn-lg" href="<?= e($secondary['href'] ?? '/contact') ?>"><?= e($secondary['label'] ?? 'Talk to Us') ?></a><?php endif; ?>
      </div>
    </div>
  </div>
  <?php
  return ob_get_clean();
}



/** FAQ interactive hover accordion. */
function faq_accordion(array $items): string {
  ob_start();
  ?>
  <div class="faq-accordion-group" data-faq-group>
    <?php foreach ($items as $i => $item): ?>
      <div class="faq-card" data-faq-card tabindex="0">
        <button type="button" class="faq-card-header" aria-expanded="false">
          <span class="faq-card-question"><?= e($item['q']) ?></span>
          <span class="faq-card-icon" aria-hidden="true">
            <svg class="faq-icon-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
          </span>
        </button>
        <div class="faq-card-a-wrapper" aria-hidden="true">
          <div class="faq-card-a-inner">
            <div class="faq-card-a-content">
              <?= $item['a'] ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php
  return ob_get_clean();
}

/** Render the sidebar navigation for Legal & Compliance pages. */
function legal_sidebar(string $active): string {
  $docs = [
    [
      'key'   => 'privacy',
      'label' => 'Privacy Policy',
      'href'  => '/legal-pages/privacy-policy.php',
      'desc'  => 'Data protection & security',
      'icon'  => 'shield'
    ],
    [
      'key'   => 'terms',
      'label' => 'Terms & Conditions',
      'href'  => '/legal-pages/terms-and-conditions.php',
      'desc'  => 'Platform usage & rules',
      'icon'  => 'tag'
    ],
    [
      'key'   => 'cookies',
      'label' => 'Cookie Policy',
      'href'  => '/legal-pages/cookie-policy.php',
      'desc'  => 'Tracking & browser cookies',
      'icon'  => 'sparkles'
    ],
    [
      'key'   => 'disclaimer',
      'label' => 'Disclaimer',
      'href'  => '/legal-pages/disclaimer.php',
      'desc'  => 'Marketplace intermediary notice',
      'icon'  => 'building'
    ],
  ];

  ob_start();
  ?>
  <aside class="legal-sidebar">
    <div class="card card-pad" style="padding: 1.25rem;">
      <div style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gold-600); margin-bottom: 0.75rem;">
        Legal Documents
      </div>
      <nav class="legal-nav">
        <?php foreach ($docs as $d): 
          $isActive = ($active === $d['key']);
        ?>
          <a href="<?= url($d['href']) ?>" class="legal-nav-item <?= $isActive ? 'active' : '' ?>">
            <span class="legal-nav-icon">
              <?= icon($d['icon'], 16) ?>
            </span>
            <div style="min-width: 0;">
              <div style="line-height: 1.2; font-size: 0.875rem;"><?= e($d['label']) ?></div>
              <div style="font-size: 0.7rem; font-weight: 500; color: var(--navy-400); margin-top: 0.15rem;"><?= e($d['desc']) ?></div>
            </div>
          </a>
        <?php endforeach; ?>
      </nav>
    </div>

    <!-- Grievance Officer Box -->
    <div class="card card-pad" style="padding: 1.25rem; background: var(--navy-900); color: #ffffff;">
      <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
        <span style="color: var(--gold-400);"><?= icon('shield', 18) ?></span>
        <h4 style="font-size: 0.9rem; font-weight: 700; color: #ffffff; margin: 0;">Grievance Officer</h4>
      </div>
      <p style="font-size: 0.8rem; color: var(--navy-200); line-height: 1.5; margin: 0 0 0.75rem 0;">
        For statutory compliance or grievances under Indian Information Technology Rules:
      </p>
      <div style="font-size: 0.8rem; display: flex; flex-direction: column; gap: 0.35rem;">
        <span style="color: var(--gold-400); font-weight: 600;">Ms. Aditi Sharma</span>
        <a href="mailto:privacy@homeosphere.in" style="color: #ffffff; text-decoration: none; display: flex; align-items: center; gap: 0.35rem;">
          <?= icon('mail', 14) ?> privacy@homeosphere.in
        </a>
        <a href="tel:+919000000000" style="color: #ffffff; text-decoration: none; display: flex; align-items: center; gap: 0.35rem;">
          <?= icon('phone', 14) ?> +91 90000 00000
        </a>
      </div>
    </div>
  </aside>
  <?php
  return ob_get_clean();
}

/**
 * Render a Google AdSense policy-compliant ad slot container.
 * Zero-layout-shift (CLS = 0) with transparent "Advertisement" labeling.
 */
function adsense_slot(string $type = 'horizontal', string $slotId = ''): string {
  ob_start();
  $pubId = defined('ADSENSE_PUB_ID') ? ADSENSE_PUB_ID : '';
  $hasPub = !empty($pubId);
  $minH = $type === 'horizontal' ? '90px' : ($type === 'rectangle' ? '250px' : '60px');
  ?>
  <div class="adsense-container adsense-<?= e($type) ?>" style="margin:1.75rem auto;max-width:100%;text-align:center;overflow:hidden;">
    <div style="font-size:0.65rem;text-transform:uppercase;letter-spacing:0.08em;color:var(--navy-400);margin-bottom:0.35rem;font-weight:700;">
      Advertisement
    </div>
    <div style="min-height:<?= $minH ?>;display:flex;align-items:center;justify-content:center;background:var(--sand-100);border:1px dashed var(--sand-300);border-radius:0.75rem;padding:0.5rem;">
      <?php if ($hasPub && !empty($slotId)): ?>
        <ins class="adsbygoogle"
             style="display:block;width:100%;"
             data-ad-client="<?= e($pubId) ?>"
             data-ad-slot="<?= e($slotId) ?>"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      <?php else: ?>
        <div style="font-size:0.75rem;color:var(--navy-400);font-weight:600;padding:1rem;display:flex;align-items:center;gap:0.5rem;">
          <span style="color:var(--gold-500);"><?= icon('shield', 14) ?></span> Homeosphere Partner Network
        </div>
      <?php endif; ?>
    </div>
  </div>
  <?php
  return ob_get_clean();
}