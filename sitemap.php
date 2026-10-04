<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/data.php';

header('Content-Type: application/xml; charset=utf-8');

$urls = [
  ['loc' => absolute_url('/'), 'priority' => '1.0', 'changefreq' => 'weekly'],
  ['loc' => absolute_url('/properties'), 'priority' => '0.9', 'changefreq' => 'weekly'],
  ['loc' => absolute_url('/services'), 'priority' => '0.9', 'changefreq' => 'monthly'],
  ['loc' => absolute_url('/professionals'), 'priority' => '0.8', 'changefreq' => 'monthly'],
  ['loc' => absolute_url('/insights'), 'priority' => '0.8', 'changefreq' => 'monthly'],
  ['loc' => absolute_url('/about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
  ['loc' => absolute_url('/blogs'), 'priority' => '0.9', 'changefreq' => 'daily'],
  ['loc' => absolute_url('/contact'), 'priority' => '0.6', 'changefreq' => 'monthly'],
  ['loc' => absolute_url('/login'), 'priority' => '0.5', 'changefreq' => 'monthly'],
  ['loc' => absolute_url('/signup'), 'priority' => '0.5', 'changefreq' => 'monthly'],
  ['loc' => absolute_url('/privacy-policy'), 'priority' => '0.5', 'changefreq' => 'yearly'],
  ['loc' => absolute_url('/terms-and-conditions'), 'priority' => '0.5', 'changefreq' => 'yearly'],
  ['loc' => absolute_url('/cookie-policy'), 'priority' => '0.5', 'changefreq' => 'yearly'],
  ['loc' => absolute_url('/disclaimer'), 'priority' => '0.5', 'changefreq' => 'yearly'],
];

foreach (blog_posts() as $p) {
  $urls[] = [
    'loc' => absolute_url('/blogs/' . $p['slug']),
    'priority' => '0.8',
    'changefreq' => 'weekly',
    'lastmod' => $p['date']
  ];
}

foreach (properties() as $prop) {
  $urls[] = [
    'loc' => absolute_url('/properties?id=' . $prop['id']),
    'priority' => '0.7',
    'changefreq' => 'weekly'
  ];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $u): ?>
  <url>
    <loc><?= e($u['loc']) ?></loc>
    <?php if (!empty($u['lastmod'])): ?><lastmod><?= e($u['lastmod']) ?></lastmod><?php endif; ?>
    <changefreq><?= e($u['changefreq']) ?></changefreq>
    <priority><?= e($u['priority']) ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
