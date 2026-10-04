<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';
require_once __DIR__ . '/../includes/cards.php';

$props      = properties();
$citiesData = cities();
$typesData  = property_types();
$furnData   = furnishing_types();
$amenData   = amenities_list();

head([
    'title'       => 'Property Marketplace — Buy & Rent Homes | Homeosphere',
    'description' => 'Browse verified properties for sale and rent across 50+ Indian cities. Filter by budget, location, and amenities to find your dream home today.',
    'keywords'    => 'buy homes India, rent properties, verified property listings, real estate marketplace, apartments for sale',
    'canonical'   => '/properties',
    'jsonld'      => [
        '@context'    => 'https://schema.org',
        '@type'       => 'RealEstateAgent',
        'name'        => SITE_NAME ?? 'Homeosphere',
        'url'         => url('/properties'),
        'description' => 'Browse verified properties for sale and rent across 50+ Indian cities.'
    ],
]);
header_partial('properties');
?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<?php
?>

<section class="page-head">
  <div class="container-x">
    <p class="breadcrumb"><a href="/">Home</a><span class="sep">/</span>Properties</p>
    <p class="eyebrow">Real Estate Marketplace</p>
    <h1>Find your next home</h1>
    <p>Browse verified properties for sale and rent across 50+ Indian cities. Filter by budget, type, and amenities.</p>
  </div>
</section>

<section class="section">
  <div class="container-x">
    <div class="dash-grid">
    <!-- Filters sidebar -->
    <aside class="prop-filter-aside">
      <div class="mobile-filter-toggle-wrap">
        <button type="button" id="mobileFilterToggle" class="btn btn-ghost btn-block" style="display:flex; justify-content:space-between; align-items:center; padding: 0.85rem 1.25rem; font-weight:700;">
          <span style="display:inline-flex; align-items:center; gap:0.5rem;">
            <?= icon('sliders', 18) ?> Filters &amp; Search
          </span>
          <span id="mobileFilterIndicator" style="font-size:0.8rem; color:var(--gold-600);">Tap to toggle ▾</span>
        </button>
      </div>
      <div class="card filters" id="propFiltersCard">
        <h2><?= icon('sliders', 18) ?> Filters</h2>
        <form id="filterForm" method="get" action="/properties">
          <div class="filter-group">
            <label class="label" for="propSearchKeyword">Search Keyword / Locality</label>
            <div style="position:relative;">
              <input type="text" class="input" id="propSearchKeyword" name="q" placeholder="E.g. Villa, Worli, 3BHK, Pool…" value="<?= e($_GET['q'] ?? '') ?>" autocomplete="off" style="padding-right:2.2rem;width:100%;">
              <button type="button" id="clearKeywordFilter" style="position:absolute;right:0.6rem;top:50%;transform:translateY(-50%);border:none;background:none;color:var(--navy-400);cursor:pointer;display:<?= !empty($_GET['q']) ? 'block' : 'none' ?>;font-weight:700;padding:0.2rem;" title="Clear keyword">✕</button>
            </div>
          </div>
          <div class="filter-group">
            <label class="label">Listing type</label>
            <div class="filter-chips" data-group="listing">
              <button type="button" class="filter-chip active" data-val="All">All</button>
              <button type="button" class="filter-chip" data-val="Buy">Buy</button>
              <button type="button" class="filter-chip" data-val="Rent">Rent</button>
            </div>
          </div>
          <div class="filter-group">
            <label class="label" for="city">City</label>
            <select class="input" id="city" name="city"><option value="All">All</option>
              <?php foreach ($citiesData as $c): ?><option value="<?= e($c) ?>"><?= e($c) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="filter-group">
            <label class="label" for="type">Property type</label>
            <select class="input" id="type" name="type"><option value="All">All</option>
              <?php foreach ($typesData as $t): ?><option value="<?= e($t) ?>"><?= e($t) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="filter-group">
            <label class="label">Bedrooms</label>
            <div class="filter-chips" data-group="beds">
              <button type="button" class="filter-chip active" data-val="Any">Any</button>
              <button type="button" class="filter-chip" data-val="1">1</button>
              <button type="button" class="filter-chip" data-val="2">2</button>
              <button type="button" class="filter-chip" data-val="3">3</button>
              <button type="button" class="filter-chip" data-val="4+">4+</button>
            </div>
          </div>
          <div class="filter-group">
            <label class="label" for="furnish">Furnishing</label>
            <select class="input" id="furnish" name="furnish"><option value="All">All</option>
              <?php foreach ($furnData as $f): ?><option value="<?= e($f) ?>"><?= e($f) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="filter-group">
            <label class="label" for="amenity">Amenities</label>
            <select class="input" id="amenity" name="amenity"><option value="All">All</option>
              <?php foreach ($amenData as $a): ?><option value="<?= e($a) ?>"><?= e($a) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="filter-group">
            <label class="label" for="budget">Max budget</label>
            <input type="range" id="budget" min="5000000" max="100000000" step="500000" value="100000000" class="input" style="padding:0">
            <p id="budgetLabel" style="font-size:.75rem;color:var(--navy-500);margin-top:.5rem">₹10.0 Cr</p>
          </div>
          <button type="button" id="resetFilters" class="btn btn-ghost btn-block">Reset filters</button>
        </form>
      </div>
    </aside>

    <!-- Results -->
    <div>
      <!-- Active Search Keyword Banner -->
      <div id="propSearchBanner" class="search-active-banner" style="display:none;">
        <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
          <span class="prop-match-badge"><?= icon('search', 14) ?> Search Match</span>
          <span style="font-size:0.9rem;font-weight:700;color:var(--navy-900);">
            Showing properties for "<span id="bannerKeywordText"></span>"
          </span>
          <span id="bannerMatchCount" class="pill pill-gold" style="font-size:0.75rem;padding:0.2rem 0.6rem;">0 matches</span>
        </div>
        <button type="button" id="bannerClearBtn" class="btn btn-ghost btn-sm" style="font-weight:700;color:var(--navy-600);border-radius:9999px;">
          Clear Search ✕
        </button>
      </div>

      <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.25rem;flex-wrap:wrap;">
        <p style="font-size:.875rem;color:var(--navy-600);margin:0;"><b id="resultCount" style="color:var(--navy-900)"><?= count($props) ?></b> properties found</p>
        <div style="display:flex;align-items:center;gap:.75rem;">
          <a href="<?= url('/contact?req=list_property') ?>" class="btn btn-outline btn-sm" style="font-weight:700;display:inline-flex;align-items:center;gap:0.35rem;border-radius:9999px;padding:0.4rem 0.85rem;font-size:0.8rem;">
            <?= icon('plus', 14) ?> List Your Property
          </a>
          <div style="display:flex;gap:.375rem;border-radius:9999px;background:var(--sand-100);padding:.25rem">
            <button id="viewGrid" data-on="1" class="btn btn-sm" style="background:#fff;color:var(--navy-900);box-shadow:var(--sh-soft)"><?= icon('grid', 16) ?> Grid</button>
            <button id="viewMap" class="btn btn-sm" style="background:transparent;color:var(--navy-500)"><?= icon('map', 16) ?> Map</button>
          </div>
        </div>
      </div>

      <div id="gridView" class="grid grid-3">
        <?php foreach ($props as $p): ?>
          <div class="prop-item" data-id="<?= e($p['id']) ?>" data-title="<?= e($p['title']) ?>" data-location="<?= e($p['location']) ?>" data-listing="<?= e($p['listing']) ?>" data-city="<?= e($p['city']) ?>" data-type="<?= e($p['type']) ?>" data-beds="<?= (int)$p['beds'] ?>" data-furnish="<?= e($p['furnishing']) ?>" data-amenities="<?= e(implode(',', $p['amenities'])) ?>" data-price="<?= (int)$p['price'] ?>">
            <?= property_card($p) ?>
          </div>
        <?php endforeach; ?>
      </div>

      <div id="propOtherDivider" class="search-section-divider" style="display:none;">
        <span>Other Available Properties</span>
      </div>
      <div id="otherGridView" class="grid grid-3" style="display:none;margin-top:1rem;"></div>

      <div id="mapView" style="display:none">
        <div class="dash-grid">
          <div class="map-view" style="position:relative; height:32rem; border-radius:1.5rem; overflow:hidden; border:1px solid var(--sand-200); box-shadow:0 4px 20px -2px rgba(11,31,58,0.06); background:#eef2f6;">
            <!-- Real Interactive Map Container -->
            <div id="propertyMap" style="width:100%; height:100%; z-index:1;"></div>
            
            <!-- Fallback pins if map tile network is loading -->
            <div id="fallbackPins" style="display:none; position:absolute; inset:0; z-index:2;">
              <div class="map-grid"></div>
              <?php foreach ($props as $p): ?>
                <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($p['title'] . ', ' . $p['location'] . ', ' . $p['city']) ?>" target="_blank" rel="noopener noreferrer" class="map-pin" data-listing="<?= e($p['listing']) ?>" data-city="<?= e($p['city']) ?>" data-type="<?= e($p['type']) ?>" data-beds="<?= (int)$p['beds'] ?>" data-furnish="<?= e($p['furnishing']) ?>" data-amenities="<?= e(implode(',', $p['amenities'])) ?>" data-price="<?= (int)$p['price'] ?>" style="left:<?= $p['coords']['x'] ?>%;top:<?= $p['coords']['y'] ?>%; text-decoration:none;" title="Open <?= e($p['title']) ?> in Google Maps">
                  <span class="map-pin-pill" style="max-width:210px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; display:inline-flex; align-items:center; gap:0.35rem; padding:0.4rem 0.75rem; background:#0b1f3a; color:#ffffff; border-radius:9999px; border:1.5px solid #d4a017;">
                    <svg style="width:12px;height:12px;fill:none;stroke:#d4a017;stroke-width:2.2;flex-shrink:0;" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <span><?= e($p['title']) ?></span>
                  </span>
                </a>
              <?php endforeach; ?>
            </div>

            <!-- Helpful Legend overlay -->
            <div style="position:absolute;bottom:1rem;left:1rem;z-index:999;border-radius:.75rem;background:rgba(255,255,255,.95);padding:.45rem .85rem;font-size:.75rem;color:var(--navy-800);font-weight:700;box-shadow:0 4px 14px rgba(0,0,0,0.14);backdrop-filter:blur(8px);display:flex;align-items:center;gap:.45rem;pointer-events:none;border:1px solid rgba(11,31,58,0.08);">
              <svg style="width:16px;height:16px;flex-shrink:0;" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5" fill="#fff"/></svg>
              <span>Google Maps &bull; Click any property pin to open in Google Maps ↗</span>
            </div>
          </div>
          <div id="mapList" style="display:grid;gap:1rem;max-height:32rem;overflow-y:auto" class="scrollbar-hide">
            <?php foreach ($props as $p): ?>
              <div class="map-list-item" data-listing="<?= e($p['listing']) ?>" data-city="<?= e($p['city']) ?>" data-type="<?= e($p['type']) ?>" data-beds="<?= (int)$p['beds'] ?>" data-furnish="<?= e($p['furnishing']) ?>" data-amenities="<?= e(implode(',', $p['amenities'])) ?>" data-price="<?= (int)$p['price'] ?>">
                <?= property_card($p) ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div id="emptyState" class="card card-pad" style="display:none;text-align:center;color:var(--navy-500);padding:3rem">No properties match these filters. Try widening your search.</div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container-x">
    <?= cta_band("Can't find what you're looking for?", 'List a requirement and our team will match you with properties that fit — before they go live.', ['label'=>'Submit a Requirement','href'=>'/contact?req=submit_requirement'], ['label'=>'List Your Property','href'=>'/contact?req=list_property']) ?>
  </div>
</section>

<script>
(function(){
  var state = { q:'', listing:'All', city:'All', type:'All', beds:'Any', furnish:'All', amenity:'All', maxPrice:100000000 };
  function fmtPrice(v){ return v >= 10000000 ? '₹' + (v/10000000).toFixed(1) + ' Cr' : '₹' + (v/100000) + ' L'; }

  var propertiesList = <?= json_encode(array_map(function($p) {
    return [
      'id' => $p['id'],
      'title' => $p['title'],
      'location' => $p['location'],
      'city' => $p['city'],
      'priceLabel' => $p['priceLabel'],
      'listing' => $p['listing'],
      'type' => $p['type'],
      'beds' => (int)$p['beds'],
      'furnish' => $p['furnishing'],
      'amenities' => implode(',', $p['amenities']),
      'price' => (int)$p['price'],
      'lat' => $p['lat'] ?? 20.5937,
      'lng' => $p['lng'] ?? 78.9629,
      'image' => $p['image'],
      'gmaps' => 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($p['title'] . ', ' . $p['location'] . ', ' . $p['city']),
    ];
  }, $props), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;

  var map = null;
  var mapMarkers = [];

  function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, function(m) {
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m];
    });
  }

  function initMap() {
    if (map) return;
    if (typeof L === 'undefined') {
      var fb = document.getElementById('fallbackPins');
      if (fb) fb.style.display = 'block';
      return;
    }

    map = L.map('propertyMap', {
      zoomControl: true,
      scrollWheelZoom: true
    }).setView([21.0, 78.0], 5);

    // Google Maps Roadmap (Streets) Layer
    var googleStreets = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
      maxZoom: 20,
      subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
      attribution: '&copy; <a href="https://maps.google.com" target="_blank" rel="noopener">Google Maps</a>'
    });

    // Google Maps Satellite / Hybrid Layer
    var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
      maxZoom: 20,
      subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
      attribution: '&copy; <a href="https://maps.google.com" target="_blank" rel="noopener">Google Maps</a>'
    });

    // Google Maps Terrain Layer
    var googleTerrain = L.tileLayer('https://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
      maxZoom: 20,
      subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
      attribution: '&copy; <a href="https://maps.google.com" target="_blank" rel="noopener">Google Maps</a>'
    });

    googleStreets.addTo(map);

    // Google Maps Layer Switcher
    L.control.layers({
      "Google Streets": googleStreets,
      "Google Satellite": googleHybrid,
      "Google Terrain": googleTerrain
    }, null, { position: 'topright' }).addTo(map);

    propertiesList.forEach(function(p) {
      var icon = L.divIcon({
        className: 'custom-property-pin',
        html: '<div style="transform:translate(-50%,-50%);cursor:pointer;" title="Click to open ' + escapeHtml(p.title) + ' in Google Maps">' +
          '<span class="map-pin-pill" style="display:inline-flex;align-items:center;gap:0.35rem;white-space:nowrap;padding:0.4rem 0.75rem;border-radius:9999px;background:#0b1f3a;color:#ffffff;font-size:0.75rem;font-weight:700;box-shadow:0 4px 14px rgba(0,0,0,0.3);border:1.5px solid #d4a017;max-width:220px;overflow:hidden;text-overflow:ellipsis;transition:transform 0.2s, background 0.2s;">' +
            '<svg style="width:12px;height:12px;fill:none;stroke:#d4a017;stroke-width:2.2;flex-shrink:0;" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>' +
            '<span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' + escapeHtml(p.title) + '</span>' +
          '</span>' +
        '</div>',
        iconSize: [0, 0],
        iconAnchor: [0, 0]
      });

      var marker = L.marker([p.lat, p.lng], { icon: icon });

      // Click directly opens Google Maps in a new tab / Google Maps app!
      marker.on('click', function(e) {
        if (e && e.originalEvent) {
          e.originalEvent.stopPropagation();
        }
        window.open(p.gmaps, '_blank');
      });

      // Hover tooltip with property info
      marker.bindTooltip(
        '<div style="font-family:\'Plus Jakarta Sans\',sans-serif;font-size:0.75rem;line-height:1.4;padding:2px;">' +
          '<strong style="color:#0b1f3a;font-size:0.8rem;">' + escapeHtml(p.title) + '</strong><br>' +
          '<span style="color:#64748b;">📍 ' + escapeHtml(p.location) + '</span><br>' +
          '<span style="color:#d4a017;font-weight:700;">' + escapeHtml(p.priceLabel) + '</span><br>' +
          '<span style="color:#2563eb;font-weight:700;font-size:0.7rem;">Click to open on Google Maps ↗</span>' +
        '</div>',
        { direction: 'top', offset: [0, -15] }
      );

      marker.propertyData = p;
      mapMarkers.push(marker);
      marker.addTo(map);
    });

    fitMapMarkers();
  }

  function fitMapMarkers() {
    if (!map) return;
    var visibleCoords = [];
    mapMarkers.forEach(function(m) {
      if (matches(m.propertyData)) {
        if (!map.hasLayer(m)) m.addTo(map);
        visibleCoords.push(m.getLatLng());
      } else {
        if (map.hasLayer(m)) map.removeLayer(m);
      }
    });

    if (visibleCoords.length > 0) {
      var bounds = L.latLngBounds(visibleCoords);
      map.fitBounds(bounds, { padding: [50, 50], maxZoom: 13 });
    }
  }

  function matchesKeyword(d, q) {
    if (!q || !q.trim()) return true;
    var listingTerms = d.listing === 'Buy' ? 'buy for sale sale' : (d.listing === 'Rent' ? 'rent for rent rental' : '');
    var str = ((d.title || '') + ' ' + (d.location || '') + ' ' + (d.city || '') + ' ' + (d.type || '') + ' ' + listingTerms + ' ' + (d.furnish || '') + ' ' + (d.amenities || '')).toLowerCase();
    var words = q.trim().toLowerCase().split(/\s+/).filter(Boolean);
    return words.every(function(w) { return str.indexOf(w) !== -1; });
  }

  function matchesFilters(el) {
    var d = el.dataset || el;
    if (d.listing !== 'All' && state.listing !== 'All' && d.listing !== state.listing) return false;
    if (state.city !== 'All' && d.city !== state.city) return false;
    if (state.type !== 'All' && d.type !== state.type) return false;
    if (state.beds !== 'Any') {
      var b = parseInt(d.beds, 10);
      if (state.beds === '4+' ? b < 4 : b !== parseInt(state.beds, 10)) return false;
    }
    if (state.furnish !== 'All' && d.furnish !== state.furnish) return false;
    var am = d.amenities || '';
    if (state.amenity !== 'All' && am.indexOf(state.amenity) === -1) return false;
    if (parseInt(d.price, 10) > state.maxPrice) return false;
    return true;
  }

  function matches(el) {
    var d = el.dataset || el;
    return matchesKeyword(d, state.q) && matchesFilters(el);
  }

  function apply() {
    var grid = document.getElementById('gridView');
    var otherGrid = document.getElementById('otherGridView');
    var otherDivider = document.getElementById('propOtherDivider');
    var banner = document.getElementById('propSearchBanner');
    var bannerKw = document.getElementById('bannerKeywordText');
    var bannerCount = document.getElementById('bannerMatchCount');
    var mapPins = document.querySelectorAll('#fallbackPins .map-pin');
    var mapItems = document.querySelectorAll('.map-list-item');

    var allCards = Array.from(grid.querySelectorAll('.prop-item')).concat(Array.from(otherGrid.querySelectorAll('.prop-item')));

    var matchesList = [];
    var otherList = [];

    allCards.forEach(function(el) {
      var d = el.dataset || {};
      var passFilter = matchesFilters(el);
      var passKeyword = matchesKeyword(d, state.q);

      el.classList.remove('prop-match-highlight');

      if (passFilter && passKeyword) {
        if (state.q) {
          el.classList.add('prop-match-highlight');
        }
        el.style.display = '';
        matchesList.push(el);
      } else if (passFilter && !passKeyword) {
        el.style.display = '';
        otherList.push(el);
      } else {
        el.style.display = 'none';
        otherList.push(el);
      }
    });

    // Reorder gridView: exact keyword matches first
    matchesList.forEach(function(el) {
      grid.appendChild(el);
    });

    if (state.q && state.q.length > 0) {
      var visibleOthers = otherList.filter(function(el) { return matchesFilters(el); });
      visibleOthers.forEach(function(el) {
        otherGrid.appendChild(el);
      });

      if (visibleOthers.length > 0 && matchesList.length > 0) {
        otherDivider.style.display = 'flex';
        otherGrid.style.display = (document.getElementById('viewGrid').dataset.on === '1' ? 'grid' : 'none');
      } else {
        otherDivider.style.display = 'none';
        otherGrid.style.display = 'none';
      }

      banner.style.display = 'flex';
      bannerKw.textContent = state.q;
      bannerCount.textContent = matchesList.length + ' match' + (matchesList.length === 1 ? '' : 'es');

      var totalFound = matchesList.length + visibleOthers.length;
      document.getElementById('resultCount').textContent = matchesList.length > 0
        ? matchesList.length + ' matching "' + state.q + '" (' + totalFound + ' total)'
        : totalFound;
    } else {
      otherList.forEach(function(el) {
        grid.appendChild(el);
      });
      otherDivider.style.display = 'none';
      otherGrid.style.display = 'none';
      banner.style.display = 'none';

      var totalShown = matchesList.length + otherList.filter(function(el) { return matchesFilters(el); }).length;
      document.getElementById('resultCount').textContent = totalShown;
    }

    // Map list items & pins
    mapPins.forEach(function(el) {
      var d = el.dataset || {};
      el.style.display = (matchesFilters(el) && (state.q ? matchesKeyword(d, state.q) : true)) ? '' : 'none';
    });
    mapItems.forEach(function(el) {
      var d = el.dataset || {};
      el.style.display = (matchesFilters(el) && (state.q ? matchesKeyword(d, state.q) : true)) ? '' : 'none';
    });

    if (map) {
      fitMapMarkers();
    }

    var totalActive = matchesList.length + (state.q ? 0 : otherList.filter(function(el) { return matchesFilters(el); }).length);
    document.getElementById('emptyState').style.display = (matchesList.length === 0 && (!state.q || otherList.filter(function(el) { return matchesFilters(el); }).length === 0)) ? 'block' : 'none';
    document.getElementById('gridView').style.display = (matchesList.length === 0 && (!state.q || otherList.filter(function(el) { return matchesFilters(el); }).length === 0)) ? 'none' : (document.getElementById('viewGrid').dataset.on === '1' ? 'grid' : 'none');
  }

  // chips
  document.querySelectorAll('.filter-chips').forEach(function(group){
    group.addEventListener('click', function(e){
      var chip = e.target.closest('.filter-chip'); if (!chip) return;
      group.querySelectorAll('.filter-chip').forEach(function(c){ c.classList.remove('active'); });
      chip.classList.add('active');
      state[group.dataset.group] = chip.dataset.val;
      apply();
    });
  });

  // selects
  ['city','type','furnish','amenity'].forEach(function(name){
    var el = document.getElementById(name); if (!el) return;
    el.addEventListener('change', function(){ state[name === 'amenity' ? 'amenity' : name] = el.value; apply(); });
  });

  // budget
  var budget = document.getElementById('budget'), lbl = document.getElementById('budgetLabel');
  budget.addEventListener('input', function(){ state.maxPrice = parseInt(budget.value,10); lbl.textContent = fmtPrice(state.maxPrice); apply(); });

  // reset
  document.getElementById('resetFilters').addEventListener('click', function(){
    state = { q:'', listing:'All', city:'All', type:'All', beds:'Any', furnish:'All', amenity:'All', maxPrice:100000000 };
    var kwEl = document.getElementById('propSearchKeyword');
    if (kwEl) kwEl.value = '';
    var clrEl = document.getElementById('clearKeywordFilter');
    if (clrEl) clrEl.style.display = 'none';
    document.querySelectorAll('.filter-chips').forEach(function(g){ g.querySelectorAll('.filter-chip').forEach(function(c){ c.classList.toggle('active', c.dataset.val === 'All' || c.dataset.val === 'Any'); }); });
    ['city','type','furnish','amenity'].forEach(function(n){ var el = document.getElementById(n); if (el) el.value = 'All'; });
    budget.value = 100000000; lbl.textContent = '₹10.0 Cr';
    apply();
  });

  // Keyword input listeners
  var kwEl = document.getElementById('propSearchKeyword');
  var clrEl = document.getElementById('clearKeywordFilter');
  var kwDebounce = null;
  if (kwEl) {
    kwEl.addEventListener('input', function() {
      var val = kwEl.value.trim();
      if (clrEl) clrEl.style.display = val ? 'block' : 'none';
      clearTimeout(kwDebounce);
      kwDebounce = setTimeout(function() {
        state.q = val;
        apply();
      }, 150);
    });
  }
  if (clrEl) {
    clrEl.addEventListener('click', function() {
      if (kwEl) kwEl.value = '';
      clrEl.style.display = 'none';
      state.q = '';
      apply();
      if (kwEl) kwEl.focus();
    });
  }
  var bannerClr = document.getElementById('bannerClearBtn');
  if (bannerClr) {
    bannerClr.addEventListener('click', function() {
      if (kwEl) kwEl.value = '';
      if (clrEl) clrEl.style.display = 'none';
      state.q = '';
      apply();
    });
  }

  // view toggle
  var vg = document.getElementById('viewGrid'), vm = document.getElementById('viewMap');
  vg.dataset.on = '1';
  vg.addEventListener('click', function(){ 
    vg.dataset.on='1'; 
    vg.style.background='#fff'; 
    vg.style.color='var(--navy-900)'; 
    vm.style.background='transparent'; 
    vm.style.color='var(--navy-500)'; 
    document.getElementById('gridView').style.display='grid'; 
    if (state.q && document.getElementById('propOtherDivider').style.display === 'flex') {
      document.getElementById('otherGridView').style.display = 'grid';
    }
    document.getElementById('mapView').style.display='none'; 
  });
  vm.addEventListener('click', function(){ 
    vg.dataset.on='0'; 
    vm.style.background='#fff'; 
    vm.style.color='var(--navy-900)'; 
    vg.style.background='transparent'; 
    vg.style.color='var(--navy-500)'; 
    document.getElementById('gridView').style.display='none'; 
    document.getElementById('otherGridView').style.display = 'none';
    document.getElementById('mapView').style.display='block'; 
    initMap();
    if (map) {
      setTimeout(function() {
        map.invalidateSize();
        fitMapMarkers();
      }, 150);
    }
  });

  // Initialize from URL parameters
  var urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('q')) {
    state.q = urlParams.get('q').trim();
    if (kwEl) kwEl.value = state.q;
    if (clrEl) clrEl.style.display = state.q ? 'block' : 'none';
  }
  if (urlParams.has('listing')) {
    var l = urlParams.get('listing').trim().toLowerCase();
    state.listing = (l === 'buy' ? 'Buy' : (l === 'rent' ? 'Rent' : 'All'));
    document.querySelectorAll('.filter-chips[data-group="listing"] .filter-chip').forEach(function(c) {
      c.classList.toggle('active', c.dataset.val.toLowerCase() === state.listing.toLowerCase());
    });
  }
  if (urlParams.has('city')) {
    state.city = urlParams.get('city').trim();
    var cityEl = document.getElementById('city');
    if (cityEl) cityEl.value = state.city;
  }
  if (urlParams.has('type')) {
    state.type = urlParams.get('type').trim();
    var typeEl = document.getElementById('type');
    if (typeEl) typeEl.value = state.type;
  }

  // Initial apply
  apply();
})();
</script>

<?php footer_partial(); ?>
