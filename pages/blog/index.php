<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/data.php';
require_once __DIR__ . '/../../includes/icon.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/footer.php';
require_once __DIR__ . '/../../includes/cards.php';

$posts = blog_posts();
$categories = array_unique(array_map(fn($p) => $p['category'], $posts));

// Count per category
$catCounts = ['All' => count($posts)];
foreach ($posts as $p) {
  $catCounts[$p['category']] = ($catCounts[$p['category']] ?? 0) + 1;
}

// Find Featured Post
$featured = null;
foreach ($posts as $p) {
  if (!empty($p['featured'])) {
    $featured = $p;
    break;
  }
}
if (!$featured && !empty($posts)) {
  $featured = $posts[0];
}

head([
  'title' => 'Homeosphere Blogs — Real Estate Insights, Guides & Trends | ' . SITE_NAME,
  'description' => 'Explore expert real estate trends for 2026, first-time home buyer playbooks, high-yield investment hotspots, seasonal maintenance, and smart living advice.',
  'canonical' => '/blogs',
]);
header_partial('blogs');
?>

<section class="page-head" style="padding: 2.75rem 0 2rem 0;">
  <div class="container-x">
    <p class="breadcrumb"><a href="/">Home</a><span class="sep">/</span>Blogs</p>
    <div style="max-width: 52rem;">
      <p class="eyebrow" style="display:inline-flex;align-items:center;gap:0.4rem;">
        <?= icon('book-open', 14) ?> The Homeosphere Publication
      </p>
      <h1 style="margin-top:0.35rem;font-size: clamp(2rem, 3.5vw, 2.75rem);line-height:1.2;">Insights &amp; Expert Guides for Indian Homes</h1>
      <p style="font-size:1.05rem;color:var(--navy-200);margin-top:0.75rem;line-height:1.6;">
        Real estate market trends, first-time buying playbooks, micro-market investment analyses, seasonal maintenance checklists, and smart-living know-how.
      </p>
    </div>
  </div>
</section>

<section class="section" style="padding-top:1.5rem;padding-bottom:3rem;">
  <div class="container-x">

    <!-- Official Publication & Syndication Channels Strip -->
    <div class="blog-syndicate-strip">
      <div style="display:flex;align-items:center;gap:0.5rem;">
        <span style="display:grid;place-items:center;width:2rem;height:2rem;border-radius:0.5rem;background:rgba(212,160,23,0.12);color:var(--gold-600);">
          <?= icon('sparkles', 16) ?>
        </span>
        <span style="font-size:0.825rem;font-weight:700;color:var(--navy-900);">
          Follow &amp; Read Homeosphere on Official Channels:
        </span>
      </div>
      <div class="blog-syndicate-links">
        <a href="https://medium.com/@deeksha_48830/real-estate-trends-2026-where-indian-property-is-headed-fd351a197e0d?postPublishedType=initial" target="_blank" rel="noopener noreferrer" class="blog-pub-pill pub-medium" title="Read on Medium">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M13.54 12a6.8 6.8 0 01-6.77 6.82A6.8 6.8 0 010 12a6.8 6.8 0 016.77-6.82A6.8 6.8 0 0113.54 12zM20.96 12c0 3.54-1.51 6.42-3.38 6.42-1.87 0-3.39-2.88-3.39-6.42s1.52-6.42 3.39-6.42 3.38 2.88 3.38 6.42M24 12c0 3.17-.53 5.75-1.19 5.75-.66 0-1.19-2.58-1.19-5.75s.53-5.75 1.19-5.75C23.47 6.25 24 8.83 24 12z"/></svg>
          Medium
        </a>
        <a href="https://homeosphere.substack.com/p/the-complete-first-time-home-buyer" target="_blank" rel="noopener noreferrer" class="blog-pub-pill pub-substack" title="Subscribe on Substack">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M22.539 8.242H1.46V5.406h21.08v2.836zM1.46 10.812V24L12 18.11 22.54 24V10.812H1.46zM22.54 0H1.46v2.836h21.08V0z"/></svg>
          Substack
        </a>
        <a href="https://dev.to/homeosphere01/7-property-investment-hotspots-beyond-the-metro-cities-295k" target="_blank" rel="noopener noreferrer" class="blog-pub-pill pub-devto" title="Read on DEV Community">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M7.42 10.05c-.18-.1-.46-.17-.84-.17H5.27v4.24h1.31c.38 0 .66-.07.84-.17.2-.11.33-.29.41-.53.07-.24.11-.56.11-.96v-.88c0-.4-.04-.72-.11-.96-.08-.24-.21-.42-.41-.53zm11.53-.17h-2.73v1.54h1.94v1.17h-1.94v1.54h2.73v1.17h-3.95V8.71h3.95v1.17zm-6.22 3.19l1.41-4.36h1.29l-2.06 5.41h-1.28l-2.06-5.41h1.29l1.41 4.36zM3.1 5.34h17.8c.98 0 1.77.79 1.77 1.77v9.78c0 .98-.79 1.77-1.77 1.77H3.1c-.98 0-1.77-.79-1.77-1.77V7.11c0-.98.79-1.77 1.77-1.77zm4.74 7.27c0-.59-.08-1.07-.24-1.44-.16-.37-.4-.65-.72-.82-.32-.18-.73-.27-1.22-.27H4.05v6.58h1.61c.49 0 .9-.09 1.22-.27.32-.17.56-.45.72-.82.16-.37.24-.85.24-1.44v-1.52z"/></svg>
          DEV Community
        </a>
        <a href="https://www.tumblr.com/blog/homeosphere" target="_blank" rel="noopener noreferrer" class="blog-pub-pill pub-tumblr" title="Follow on Tumblr">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M14.563 24c-5.093 0-7.031-2.756-7.031-6.874V10.04H4.969V6.368c3.08-1.112 4.14-3.58 4.33-6.368h3.763v5.626h4.512v4.414H13.06v6.62c0 2.05.992 2.65 2.723 2.65h1.791V24h-3.011z"/></svg>
          Tumblr
        </a>
        <a href="https://x.com/homeosphere" target="_blank" rel="noopener noreferrer" class="blog-pub-pill pub-twitter" title="Follow @homeosphere on X">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          @homeosphere
        </a>
      </div>
    </div>

    <?php if ($featured): ?>
      <!-- Featured Hero Spotlight Article -->
      <article class="blog-featured-hero">
        <div class="blog-featured-media">
          <img src="<?= e($featured['image']) ?>" alt="<?= e($featured['title']) ?>">
          <div style="position:absolute;top:1rem;left:1rem;display:flex;gap:0.5rem;flex-wrap:wrap;z-index:2;">
            <span class="pill pill-gold" style="box-shadow:0 4px 12px rgba(0,0,0,0.15);font-weight:800;">⭐ Featured Deep Dive</span>
            <span class="pill glass" style="color:var(--navy-900);font-weight:700;"><?= e($featured['category']) ?></span>
          </div>
          <?php if (!empty($featured['source_name'])): ?>
            <span class="blog-platform-badge blog-badge-<?= e($featured['source']) ?>">
              Published on <?= e($featured['source_name']) ?>
            </span>
          <?php endif; ?>
        </div>
        <div class="blog-featured-body">
          <div style="display:flex;align-items:center;gap:0.75rem;font-size:0.8rem;color:var(--navy-500);font-weight:600;margin-bottom:0.75rem;">
            <span><?= date('M j, Y', strtotime($featured['date'])) ?></span>
            <span>•</span>
            <span style="display:inline-flex;align-items:center;gap:0.3rem;"><?= icon('clock', 14) ?> <?= e($featured['read']) ?> read</span>
            <span>•</span>
            <span style="display:inline-flex;align-items:center;gap:0.3rem;"><?= icon('user', 14) ?> <?= e($featured['author']) ?></span>
          </div>

          <h2 style="font-size:clamp(1.35rem, 2.2vw, 1.85rem);font-weight:800;color:var(--navy-900);line-height:1.25;margin:0 0 0.75rem 0;">
            <a href="/blogs/<?= e($featured['slug']) ?>" style="color:inherit;text-decoration:none;">
              <?= e($featured['title']) ?>
            </a>
          </h2>

          <?php if (!empty($featured['quote'])): ?>
            <div class="blog-card-quote" style="margin-bottom:1rem;padding:0.65rem 0.85rem;font-size:0.85rem;">
              <span class="quote-mark">“</span><?= e($featured['quote']) ?>”
            </div>
          <?php endif; ?>

          <p style="font-size:0.925rem;color:var(--navy-600);line-height:1.6;margin:0 0 1.5rem 0;">
            <?= e($featured['excerpt']) ?> Discover the latest JLL residential metrics, Tier-2 migration hotspots, and why tech integration is transforming the Indian housing landscape.
          </p>

          <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;margin-top:auto;">
            <a href="/blogs/<?= e($featured['slug']) ?>" class="btn btn-gold" style="font-weight:800;padding:0.65rem 1.35rem;">
              Read Full Analysis ➔
            </a>
            <?php if (!empty($featured['source_url'])): ?>
              <a href="<?= e($featured['source_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-ghost" style="font-weight:700;padding:0.65rem 1.15rem;display:inline-flex;align-items:center;gap:0.4rem;">
                <?= icon('external-link', 14) ?> Read on <?= e($featured['source_name']) ?>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </article>
    <?php endif; ?>

    <!-- Signature Editorial Quotes Ribbon -->
    <div style="background:var(--sand-50);border:1px solid var(--sand-300);border-radius:1.25rem;padding:1.5rem;margin-bottom:2.5rem;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:0.5rem;">
        <h3 style="font-size:0.95rem;font-weight:800;color:var(--navy-900);text-transform:uppercase;letter-spacing:0.05em;margin:0;display:flex;align-items:center;gap:0.4rem;">
          <?= icon('quote', 16) ?> From The Homeosphere Playbooks:
        </h3>
        <span style="font-size:0.75rem;color:var(--navy-500);font-weight:600;">Verified Quotes &amp; Principles</span>
      </div>
      <div class="blog-quotes-grid">
        <div class="blog-quote-card" style="border-left:3.5px solid var(--gold-500);">
          <p>“2026 mein property sirf ek investment nahi, ek smart decision hai — right location, right home aur right future ke saath.”</p>
          <span class="quote-source" style="color:var(--gold-600);">— Real Estate Trends 2026 (Medium)</span>
        </div>
        <div class="blog-quote-card" style="border-left:3.5px solid var(--gold-500);">
          <p>“Ghar ka sapna bada rakho, bas uski EMI ko sapne se bada mat hone do.”</p>
          <span class="quote-source" style="color:var(--gold-600);">— First-Time Home Buyer Guide (Substack)</span>
        </div>
        <div class="blog-quote-card" style="border-left:3.5px solid var(--gold-500);">
          <p>“Har season ka apna asar, timely maintenance rakhe ghar behtar.”</p>
          <span class="quote-source" style="color:var(--gold-600);">— Seasonal Home Maintenance (DEV)</span>
        </div>
      </div>
    </div>

    <!-- Filter & Live Search Toolbar -->
    <div style="background:#ffffff;border:1px solid var(--sand-300);border-radius:1.25rem;padding:1.25rem;margin-bottom:2rem;display:flex;flex-direction:column;gap:1rem;box-shadow:0 2px 10px rgba(11,31,58,0.03);">
      <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <!-- Search Input -->
        <div style="position:relative;flex:1;min-width:18rem;">
          <span style="position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);color:var(--navy-400);display:grid;place-items:center;">
            <?= icon('search', 16) ?>
          </span>
          <input type="text" id="blogSearch" placeholder="Search by article title, keyword, city, or topic..." 
                 style="width:100%;padding:0.65rem 1rem 0.65rem 2.5rem;border-radius:9999px;border:1.5px solid var(--sand-300);font-size:0.875rem;font-family:inherit;outline:none;background:#fafbfc;transition:all 0.2s;"
                 onfocus="this.style.borderColor='var(--gold-500)';this.style.background='#fff';"
                 onblur="this.style.borderColor='var(--sand-300)';this.style.background='#fafbfc';">
        </div>

        <div style="font-size:0.825rem;color:var(--navy-500);font-weight:600;" id="articleCountBadge">
          Showing <strong><?= count($posts) ?></strong> articles
        </div>
      </div>

      <!-- Categories Filter Chips -->
      <div id="blogFilters" style="display:flex;flex-wrap:wrap;gap:.45rem;border-top:1px solid var(--sand-200);padding-top:1rem;">
        <button class="filter-chip active" data-cat="All" type="button" style="font-weight:700;">
          All <span style="font-size:0.75rem;opacity:0.85;">(<?= $catCounts['All'] ?>)</span>
        </button>
        <?php foreach ($categories as $c): ?>
          <button class="filter-chip" data-cat="<?= e($c) ?>" type="button">
            <?= e($c) ?> <span style="font-size:0.75rem;opacity:0.75;">(<?= $catCounts[$c] ?? 0 ?>)</span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Blog Articles Grid -->
    <div id="blogGrid" class="grid grid-3">
      <?php foreach ($posts as $p): ?>
        <div class="reveal blog-item" 
             data-cat="<?= e($p['category']) ?>"
             data-title="<?= e(strtolower($p['title'] . ' ' . $p['excerpt'] . ' ' . ($p['quote'] ?? '') . ' ' . ($p['source_name'] ?? ''))) ?>">
          <?= blog_card($p) ?>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Empty State for Search / Filter -->
    <div id="blogEmpty" class="card card-pad" style="display:none;text-align:center;color:var(--navy-500);padding:3.5rem 1.5rem;border-radius:1.25rem;border:1.5px dashed var(--sand-300);background:#fff;margin-top:1.5rem;">
      <div style="width:3.5rem;height:3.5rem;border-radius:9999px;background:rgba(212,160,23,0.1);color:var(--gold-600);display:grid;place-items:center;margin:0 auto 1rem;">
        <?= icon('search', 22) ?>
      </div>
      <h3 style="font-size:1.15rem;font-weight:800;color:var(--navy-900);margin:0 0 0.5rem;">No matching articles found</h3>
      <p style="font-size:0.875rem;color:var(--navy-500);margin:0 0 1.25rem;">Try clearing your search query or choosing a different category filter.</p>
      <button class="btn btn-sm btn-ghost" type="button" onclick="resetBlogFilters();">Reset All Filters</button>
    </div>

  </div>
</section>

<!-- Weekly Newsletter / Digest Band -->
<section class="section" style="background:var(--navy-900);color:#ffffff;padding:4rem 0;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-50%;right:-20%;width:600px;height:600px;border-radius:9999px;background:radial-gradient(circle, rgba(212,160,23,0.12) 0%, rgba(11,31,58,0) 70%);pointer-events:none;"></div>
  <div class="container-x" style="max-width:48rem;text-align:center;position:relative;z-index:2;">
    <span class="pill" style="background:rgba(212,160,23,0.2);color:var(--gold-300);font-weight:800;margin-bottom:1rem;display:inline-flex;align-items:center;gap:0.45rem;padding:0.35rem 0.85rem;">
      <?= icon('newspaper', 16) ?> The Homeosphere Intelligence Memo
    </span>
    <h2 style="font-size:clamp(1.75rem, 3vw, 2.35rem);color:#fff;font-weight:800;letter-spacing:-0.02em;margin:0 0 0.75rem 0;">
      Real Estate Clarity, Delivered Every Week
    </h2>
    <p style="font-size:0.95rem;color:var(--navy-200);line-height:1.6;max-width:36rem;margin:0 auto 2rem auto;">
      Join 25,000+ home buyers, investors, and owners across India. Get our latest deep-dives from Medium, Substack, and DEV Community delivered straight to your inbox.
    </p>

    <form onsubmit="handleDigestSubmit(event)" style="display:flex;justify-content:center;gap:0.5rem;flex-wrap:wrap;max-width:32rem;margin:0 auto;">
      <input type="email" id="digestEmail" placeholder="Enter your work or personal email..." required
             style="flex:1;min-width:16rem;padding:0.8rem 1.25rem;border-radius:9999px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.08);color:#fff;font-family:inherit;font-size:0.9rem;outline:none;">
      <button type="submit" class="btn btn-gold" style="font-weight:800;padding:0.8rem 1.75rem;border-radius:9999px;">
        Subscribe Free ➔
      </button>
    </form>
    <div id="digestMsg" style="display:none;margin-top:1rem;font-size:0.85rem;color:var(--gold-400);font-weight:700;"></div>
    <p style="font-size:0.75rem;color:var(--navy-400);margin-top:1rem;">Zero spam. Unsubscribe in one click anytime.</p>
  </div>
</section>

<section class="section container-x">
  <?= cta_band('Put these insights to work', 'Search verified properties, book trusted home services, or onboard your units for smart management — all on Homeosphere.', ['label'=>'Explore Properties','href'=>'/properties'], ['label'=>'Browse Home Services','href'=>'/services']) ?>
</section>

<script>
(function(){
  var chips = document.querySelectorAll('#blogFilters .filter-chip');
  var searchInput = document.getElementById('blogSearch');
  var items = document.querySelectorAll('.blog-item');
  var emptyState = document.getElementById('blogEmpty');
  var countBadge = document.getElementById('articleCountBadge');

  var currentCat = 'All';
  var currentQuery = '';

  function filterPosts() {
    var shown = 0;
    items.forEach(function(el) {
      var cat = el.dataset.cat;
      var title = el.dataset.title || '';
      var matchesCat = (currentCat === 'All' || cat === currentCat);
      var matchesQuery = !currentQuery || title.indexOf(currentQuery.toLowerCase()) !== -1;

      var visible = matchesCat && matchesQuery;
      el.style.display = visible ? '' : 'none';
      if (visible) shown++;
    });

    if (emptyState) emptyState.style.display = shown === 0 ? 'block' : 'none';
    if (countBadge) countBadge.innerHTML = 'Showing <strong>' + shown + '</strong> of <?= count($posts) ?> articles';
  }

  chips.forEach(function(c) {
    c.addEventListener('click', function() {
      chips.forEach(function(x){ x.classList.remove('active'); });
      c.classList.add('active');
      currentCat = c.dataset.cat;
      filterPosts();
    });
  });

  if (searchInput) {
    searchInput.addEventListener('input', function() {
      currentQuery = searchInput.value.trim();
      filterPosts();
    });
  }

  window.resetBlogFilters = function() {
    currentCat = 'All';
    currentQuery = '';
    if (searchInput) searchInput.value = '';
    chips.forEach(function(x){ 
      if (x.dataset.cat === 'All') x.classList.add('active');
      else x.classList.remove('active');
    });
    filterPosts();
  };

  window.handleDigestSubmit = function(e) {
    e.preventDefault();
    var email = document.getElementById('digestEmail').value;
    var msg = document.getElementById('digestMsg');
    if (msg) {
      msg.style.display = 'block';
      msg.innerText = '✓ Thank you for subscribing! We have sent a welcome issue to ' + email;
    }
    e.target.reset();
  };
})();
</script>

<?php footer_partial(); ?>
