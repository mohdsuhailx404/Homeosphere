<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/icon.php';

/** Render the footer and closing tags. */
function footer_partial(bool $showFooter = true): void {
?>
</main>

<?php if ($showFooter): ?>
<footer class="footer">
  <div class="container-x">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="brand" href="/" style="display:flex;align-items:center;gap:0.75rem;text-decoration:none;">
          <img src="<?= url('/assets/img/homeospherelogo.webp') ?>" 
               alt="Homeosphere Logo" 
               style="height:2.4rem;width:auto;object-fit:contain;display:block;flex-shrink:0;">
          <span class="brand-name" style="color:#fff"><b>Home</b><span>osphere</span></span>
        </a>
        <p>India's complete home ecosystem — discover properties, hire verified professionals, and manage your home, all under one digital roof.</p>
        <div class="footer-social">
          <a href="https://www.facebook.com/profile.php?id=100078204634544" target="_blank" rel="noopener noreferrer" aria-label="Facebook" title="Follow Homeosphere on Facebook"><?= icon('facebook', 16) ?></a>
          <a href="https://www.instagram.com/homeosphere.in?stkn=MTFocjBnenBibGxj" target="_blank" rel="noopener noreferrer" aria-label="Instagram" title="Follow Homeosphere on Instagram"><?= icon('instagram', 16) ?></a>
          <a href="https://x.com/homeosphere" target="_blank" rel="noopener noreferrer" aria-label="X (formerly Twitter)" title="Follow Homeosphere on X"><?= icon('x', 16) ?></a>
          <a href="https://www.linkedin.com/company/homeosphere/about/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" title="Connect with Homeosphere on LinkedIn"><?= icon('linkedin', 16) ?></a>
        </div>
      </div>

      <div class="footer-nav">
        <div>
          <h4>Platform</h4>
          <ul>
            <li><a href="<?= url('/properties') ?>">Properties</a></li>
            <li><a href="<?= url('/services') ?>">Home Services</a></li>
            <li><a href="<?= url('/professionals') ?>">Professionals</a></li>
            <li><a href="<?= url('/insights') ?>">Insights</a></li>
          </ul>
        </div>

        <div>
          <h4>Company</h4>
          <ul>
            <li><a href="<?= url('/about') ?>">About Us</a></li>
            <li><a href="<?= url('/about#roles') ?>">User Roles</a></li>
            <li><a href="<?= url('/blogs') ?>">Blogs</a></li>
            <li><a href="<?= url('/contact') ?>">Contact</a></li>
          </ul>
        </div>

        <div>
          <h4>Legal Pages</h4>
          <ul>
            <li><a href="<?= url('/privacy-policy') ?>">Privacy Policy</a></li>
            <li><a href="<?= url('/terms-and-conditions') ?>">Terms &amp; Conditions</a></li>
            <li><a href="<?= url('/cookie-policy') ?>">Cookie Policy</a></li>
            <li><a href="<?= url('/disclaimer') ?>">Disclaimer</a></li>
          </ul>
        </div>

        <div>
          <h4>For You</h4>
          <ul>
            <li><a href="<?= url('/signup') ?>">Create Account</a></li>
            <li><a href="<?= url('/login') ?>">Sign In</a></li>
            <li><a href="<?= url('/contact?req=list_property') ?>">List a Property</a></li>
            <li><a href="<?= url('/services') ?>">Book a Service</a></li>
            <li><a href="<?= url('/signup?role=professional') ?>">Join as Professional</a></li>
            <li><a href="<?= url('/insights') ?>">Property Insights</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="footer-contact">
      <span><?= icon('mail', 16) ?> <?= e(defined('SITE_EMAIL') ? SITE_EMAIL : 'info@homeosphere.in') ?></span>
      <span><?= icon('phone', 16) ?> <?= e(defined('SITE_PHONE') ? SITE_PHONE : '+91 90000 00000') ?></span>
      <span><?= icon('map-pin', 16) ?> <?= e(defined('SITE_ADDRESS') ? SITE_ADDRESS : 'Cyber City, Gurugram, Haryana 122002, India') ?></span>
    </div>

    <div class="footer-bottom">
      <span>© <?= date('Y') ?> <?= e(SITE_NAME) ?>. All rights reserved.</span>
      <span>Built for India's homes — buyers, owners, tenants &amp; professionals.</span>
    </div>
  </div>
</footer>
<?php endif; ?>

<!-- Property Slide-in Modal Drawer -->
<div id="propertyDrawerBackdrop" class="prop-drawer-backdrop" aria-hidden="true">
  <div id="propertyDrawer" class="prop-drawer" role="dialog" aria-modal="true" aria-labelledby="propDrawerTitle">
    <button id="propDrawerClose" class="prop-drawer-close" aria-label="Close details" type="button">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
    <div id="propDrawerBody" class="prop-drawer-body">
      <!-- Injected dynamically by JavaScript -->
    </div>
  </div>
</div>

<script src="/assets/js/main.js" defer></script>
</body>
</html>
<?php
}