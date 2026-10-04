<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';
require_once __DIR__ . '/../includes/cards.php';

$roles = user_roles();

head([
  'title' => 'User Roles — One Platform, Five Journeys | ' . SITE_NAME,
  'description' => 'Whether you\'re buying, selling, renting, owning, or plying your trade — Homeosphere is built around how you use your home.',
  'canonical' => '/user',
]);
header_partial('user');
?>

<section class="page-head">
  <div class="container-x">
    <p class="breadcrumb"><a href="/">Home</a><span class="sep">/</span>User Roles</p>
    <p class="eyebrow">User Roles</p>
    <h1>One platform, five journeys</h1>
    <p>Whether you're buying, selling, renting, owning, or plying your trade — Homeosphere is built around how you use your home.</p>
  </div>
</section>

<section class="section container-x">
  <div class="grid grid-2">
    <?php foreach ($roles as $idx => $r): 
      $isLastOdd = ($idx === count($roles) - 1 && count($roles) % 2 !== 0);
    ?>
      <div class="card card-hover card-pad reveal <?= $isLastOdd ? 'role-card-center' : '' ?>">
        <div style="display:flex;align-items:center;gap:1rem">
          <span style="display:grid;place-items:center;width:3.5rem;height:3.5rem;border-radius:1rem;<?= $r['color']==='gold'?'background:var(--gold-500);color:var(--navy-900)':'background:var(--navy-800);color:#fff' ?>"><?= icon($r['icon'], 28) ?></span>
          <div>
            <h3 style="font-size:1.25rem;margin:0"><?= e($r['role']) ?></h3>
            <p style="font-size:.875rem;color:var(--navy-500);margin:0">Journey &amp; tools</p>
          </div>
        </div>
        <ul style="list-style:none;padding:0;margin:1.5rem 0 0">
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
</section>

<section class="section section-alt">
  <div class="container-x">
    <?= section_heading('How it fits together', 'One account, every role', 'Switch between buying, managing, and hiring — without ever leaving Homeosphere.') ?>
    <div class="mx-auto max-w-3xl card card-pad mt-10" style="background:#fff">
      <div class="grid grid-3">
        <?php foreach (['Single sign-on','Shared dashboard','Unified wallet'] as $b): ?>
          <div style="border-radius:1rem;background:var(--sand-100);padding:1.25rem;text-align:center">
            <p style="font-size:.875rem;font-weight:700;color:var(--navy-900);margin:0"><?= e($b) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="mt-5 center" style="font-size:.875rem;color:var(--navy-500)">Your profile, preferences, and history follow you across every role — so you never start from scratch.</p>
    </div>
  </div>
</section>

<section class="section container-x">
  <?= cta_band('Which role fits you today?', 'Create a free account and switch roles anytime as your needs change.', ['label'=>'Create Free Account','href'=>'/contact'], ['label'=>'Explore the Platform','href'=>'/']) ?>
</section>

<?php footer_partial(); ?>
