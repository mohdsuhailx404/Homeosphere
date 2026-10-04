<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';

http_response_code(404);
head(['title'=>'Page Not Found (404) | ' . SITE_NAME, 'description'=>'The page you are looking for could not be found.', 'noindex'=>true, 'canonical'=>'/404']);
header_partial('');
?>
<section class="section container-x center" style="padding:6rem 0">
  <span class="mx-auto" style="display:grid;place-items:center;width:4rem;height:4rem;border-radius:1rem;background:var(--navy-50);color:var(--navy-800)"><?= icon('home', 32) ?></span>
  <p class="mt-6" style="font-size:3rem;font-weight:800;color:var(--navy-900)">404</p>
  <h1 style="font-size:1.5rem;margin-top:.5rem">Page not found</h1>
  <p class="mx-auto" style="max-width:28rem;color:var(--navy-500);margin-top:.75rem">The page you're looking for may have moved or doesn't exist. Let's get you back home.</p>
  <div class="mt-8" style="display:flex;flex-wrap:wrap;justify-content:center;gap:.75rem">
    <a href="/" class="btn btn-primary btn-lg"><?= icon('arrow-left', 16) ?> Back home</a>
    <a href="/properties" class="btn btn-ghost btn-lg">Browse properties</a>
  </div>
</section>
<?php footer_partial(); ?>
