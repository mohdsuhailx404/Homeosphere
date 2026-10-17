<?php
/**
 * PHP built-in dev server router.
 * Maps clean URLs to the right PHP files (mirrors .htaccess for Apache).
 */
// Report errors for runtime diagnostics
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Static assets with cache headers
if (preg_match('#^/(assets|homepage_img)/#', $uri)) {
  header('Cache-Control: public, max-age=31536000, immutable');
  return false; // serve the file as-is
}
if ($uri === '/robots.txt' || $uri === '/favicon.svg') {
  return false;
}
if ($uri === '/favicon.ico' || $uri === '/favicon.webp') {
  header('Content-Type: image/webp');
  header('Cache-Control: public, max-age=31536000, immutable');
  readfile(__DIR__ . '/assets/img/homeospherelogo.webp');
  return true;
}
if ($uri === '/ads.txt') {
  header('Content-Type: text/plain; charset=utf-8');
  if (file_exists(__DIR__ . '/ads.txt')) {
    readfile(__DIR__ . '/ads.txt');
  } else {
    echo "google.com, pub-0000000000000000, DIRECT, f08c47fec0942fa0\n";
  }
  return true;
}
if ($uri === '/sitemap.xml' || $uri === '/sitemap.php') {
  require __DIR__ . '/sitemap.php';
  return true;
}

// API
if ($uri === '/api/contact') {
  require __DIR__ . '/includes/handlers/contact.php';
  return true;
}
if ($uri === '/api/auth/login') {
  $_GET['action'] = 'login';
  require __DIR__ . '/includes/handlers/auth.php';
  return true;
}
if ($uri === '/api/auth/signup') {
  $_GET['action'] = 'signup';
  require __DIR__ . '/includes/handlers/auth.php';
  return true;
}
if ($uri === '/logout') {
  $_GET['action'] = 'logout';
  require __DIR__ . '/includes/handlers/auth.php';
  return true;
}
if ($uri === '/api/user/toggle-favorite') {
  $_GET['action'] = 'toggle-favorite';
  require __DIR__ . '/includes/handlers/activity.php';
  return true;
}
if ($uri === '/api/user/add-booking') {
  $_GET['action'] = 'add-booking';
  require __DIR__ . '/includes/handlers/activity.php';
  return true;
}
if ($uri === '/api/search-suggest') {
  require __DIR__ . '/includes/handlers/search.php';
  return true;
}

// Redirect User Roles routes to merged About page section
if (in_array(rtrim($uri, '/'), ['/user', '/roles', '/user-roles'])) {
  header('Location: /about#roles', true, 301);
  exit;
}

// Top-level pages
$map = [
  '/'                    => __DIR__ . '/index.php',
  '/about'               => __DIR__ . '/pages/about.php',
  '/user'                => __DIR__ . '/pages/roles.php',
  '/roles'               => __DIR__ . '/pages/roles.php',
  '/user-roles'          => __DIR__ . '/pages/roles.php',
  '/properties'          => __DIR__ . '/pages/properties.php',
  '/services'            => __DIR__ . '/pages/services.php',
  '/professionals'       => __DIR__ . '/pages/professionals.php',
  '/insights'            => __DIR__ . '/pages/management.php',
  '/management'          => __DIR__ . '/pages/management.php',
  '/property-management' => __DIR__ . '/pages/management.php',
  '/blogs'               => __DIR__ . '/pages/blog/index.php',
  '/blog'                => __DIR__ . '/pages/blog/index.php',
  '/contact'             => __DIR__ . '/pages/contact.php',
  '/dashboard'           => __DIR__ . '/pages/dashboard.php',
  '/profile'             => __DIR__ . '/pages/dashboard.php',
  '/login'               => __DIR__ . '/pages/auth.php',
  '/signup'              => __DIR__ . '/pages/auth.php',
  '/auth'                => __DIR__ . '/pages/auth.php',
  '/privacy-policy'      => __DIR__ . '/legal-pages/privacy-policy.php',
  '/terms-and-conditions'=> __DIR__ . '/legal-pages/terms-and-conditions.php',
  '/terms'               => __DIR__ . '/legal-pages/terms-and-conditions.php',
  '/cookie-policy'       => __DIR__ . '/legal-pages/cookie-policy.php',
  '/disclaimer'          => __DIR__ . '/legal-pages/disclaimer.php',
];

$cleanUri = rtrim($uri, '/');
if (isset($map[$cleanUri]) || isset($map[$uri])) {
  $file = $map[$cleanUri] ?? $map[$uri];
  require $file;
  return true;
}

// Direct php file execution if requested
if (is_file(__DIR__ . $uri) && preg_match('#\.php$#', $uri)) {
  require __DIR__ . $uri;
  return true;
}

// Blog post: /blogs/<slug> or /blog/<slug>
if (preg_match('#^/blogs?/([a-z0-9-]+)/?$#', $uri, $m)) {
  $_GET['slug'] = $m[1];
  require __DIR__ . '/pages/blog/post.php';
  return true;
}

// 404
http_response_code(404);
require __DIR__ . '/pages/404.php';
return true;
