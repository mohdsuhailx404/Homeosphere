<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/data.php';
require_once __DIR__ . '/../../includes/icon.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/footer.php';
require_once __DIR__ . '/../../includes/cards.php';

$slug = $_GET['slug'] ?? '';
$posts = blog_posts();
$post = null;
foreach ($posts as $p) { if ($p['slug'] === $slug) { $post = $p; break; } }

if (!$post) {
  http_response_code(404);
  head(['title'=>'Article not found | ' . SITE_NAME, 'noindex'=>true, 'canonical'=>'/blogs']);
  header_partial('blogs');
  echo '<section class="section container-x center"><h1>Article not found</h1><p style="color:var(--navy-500)">The article you\'re looking for doesn\'t exist.</p><a href="/blogs" class="btn btn-primary mt-6">Back to blogs</a></section>';
  footer_partial();
  exit;
}

// Comprehensive authentic body content per article.
$bodies = [
  'real-estate-trends-2026' => [
    'intro' => 'The Indian real estate market is changing, and 2026 is making that change even more visible. A few years ago, buying a property was mostly about three things: location, price, and size. Today, homebuyers are asking much more: Is the neighborhood future-ready? What are the recurring maintenance expenses? Can the area offer healthy rental yield? In simple words, people are no longer looking for just a house—they are looking for a comprehensive living experience.',
    'quote' => '2026 mein property sirf ek investment nahi, ek smart decision hai — right location, right home aur right future ke saath.',
    'quote_sub' => 'Key takeaway from the Homeosphere 2026 Real Estate Intelligence Report',
    'sections' => [
      [
        '1. Premium Homes Are Getting More Attention',
        'One of the clearest real estate trends in 2026 is the growing demand for premium homes. According to JLL’s Q1 2026 residential market report, sales across India’s top seven cities increased 8% year-on-year, while homes priced at ₹1 crore and above saw particularly strong growth. The premium segment accounted for 71% of total sales in these markets, compared with 59% a year earlier.<br><br>Why are buyers moving towards premium properties? It is not only about luxury. Many buyers now want larger living spaces, dedicated work-from-home areas, private balconies, ample parking, smart security, green open spaces, and superior construction quality. The important thing is not to buy simply because a property carries a "premium" label—it must make financial and practical sense for your household budget.',
      ],
      [
        '2. Tier-2 Cities Are Becoming Important Real Estate Markets',
        'For decades, Mumbai, Delhi-NCR, Bengaluru, Hyderabad, and Pune dominated India’s property conversation. That remains true, but the map is expanding rapidly. Tier-2 cities are attracting buyers, remote tech talent, and developers due to infrastructure upgrades, metro expansions, and attractive pricing.<br><br>A recent CRISIL analysis found that residential real estate demand in Tier-2 cities grew at a 14% compound annual rate between fiscal 2021 and fiscal 2026, with cities such as Nagpur, Coimbatore, Indore, and Lucknow growing even faster. An emerging city offers a sweet spot of lower entry costs and spacious living, though buyers should verify local job generation and connectivity before investing.',
      ],
      [
        '3. Location Is Still the Biggest Factor',
        'Technology may be revolutionizing real estate, but the golden rule remains: location matters. A beautifully designed apartment can become exhausting to live in if daily commutes to workplaces, schools, or hospitals take hours. In 2026, forward-looking buyers evaluate future infrastructure:<br>• Are new metro routes or expressways under construction?<br>• Are commercial IT hubs and hospitals within a 15-minute radius?<br>• What is the historical rental yield and tenant occupancy rate in the micro-market?<br>These questions determine long-term capital appreciation far more than cosmetic interiors.',
      ],
      [
        '4. Smart Homes Are Moving From "Luxury" to "Useful"',
        'Smart-home technology is shifting from fancy gimmicks to practical utilities. Video doorbells, biometric locks, automated climate controls, and energy-monitoring dashboards are increasingly standard in new developments. Homebuyers prioritize features that actively cut electricity bills, detect water leaks early, and give peace of mind while away from home.',
      ],
      [
        '5. Homebuyers Are Becoming More Research-Oriented',
        'Purchasing a home is usually the single largest financial commitment an Indian family undertakes. Today’s buyers check developer track records, RERA registration numbers, encumbrance certificates, and past delivery timelines. A bigger house is never a good decision if the resulting EMI, maintenance charges, and taxes cause sleepless nights. Prudent buyers keep EMIs under 35-40% of their net monthly income.',
      ],
      [
        '6. Digital Platforms Simplify Property Discovery',
        'Finding a property once meant coordinating with dozens of offline brokers, sifting through classifieds, and visiting sites blindly. Modern platforms like Homeosphere unify discovery, verification, and home services under one umbrella across 50+ Indian cities. Buyers can review verified documentation, schedule physical site visits, and explore locality metrics from their phone.',
      ],
      [
        '7. Property Management Is Becoming Essential for Landlords',
        '“Aapki property so rahi ho ya grow kar rahi ho — difference smart management ka hai.”<br><br>Buying an investment property is thrilling, but managing it from another city can quickly become a headache. Digital lease management, automated tenant KYC, instant rent ledger tracking, and on-demand maintenance help landlords protect their assets and maximize net rental yields.',
      ],
    ],
    'takeaways' => [
      'Premium homes (₹1 Cr+) now represent over 70% of residential sales volume across top Indian metros (JLL 2026).',
      'Tier-2 cities like Indore, Nagpur, Coimbatore, and Lucknow are clocking 14%+ annual residential growth (CRISIL).',
      'Smart home automation has evolved from luxury status symbols into energy-saving, security-first essentials.',
      'Active property management and digital verification separate high-performing real estate from idle liabilities.',
    ],
  ],

  'first-home-buyers-guide' => [
    'intro' => 'Buying your first home is exciting, but it can easily feel overwhelming. You start by browsing properties online, and suddenly you are juggling locations, down payments, home loan interest rates, title documents, RERA registrations, and hidden closing costs. Somewhere in between, one question keeps coming back: "Am I making the right decision?" This step-by-step playbook is designed to give you clarity and confidence from initial budgeting to receiving the keys.',
    'quote' => 'Ghar ka sapna bada rakho, bas uski EMI ko sapne se bada mat hone do.',
    'quote_sub' => 'First-Time Home Buyer Principle • Published on Substack',
    'sections' => [
      [
        'Step 1: Start With Your Budget, Not Your Dream Home',
        'When people begin their search, they often fall in love with a stunning show flat and then scramble to stretch their finances. A wiser approach is to work backwards. Calculate what you can comfortably pay without sacrificing life emergencies:<br>• Down payment (usually 15-20% of property cost)<br>• Monthly home loan EMI (must stay under 35-40% of net family income)<br>• Stamp duty & registration fees (typically 5-8% depending on state)<br>• Interior setup, appliances, and moving buffer (at least ₹3-6 Lakh)<br>A good home should elevate your lifestyle, not generate financial stress.',
      ],
      [
        'Step 2: Decide What Kind of Home You Actually Need',
        'Before touring dozens of apartments, define your exact lifestyle parameters: Do you need a 2 BHK or 3 BHK? Is a dedicated work-from-home corner essential? Would you prefer a gated high-rise society with amenities or an independent floor? A young couple might prioritize proximity to tech parks, while growing families need quality schools and parks nearby.',
      ],
      [
        'Step 3: Location & Neighborhood Due Diligence',
        '“Property ki chaar deewarein nahi, uske aas-paas ka shehar bhi aapka future decide karta hai.”<br><br>Always visit the prospective neighborhood at different hours of the day. A locality that feels peaceful at 11:00 AM on a Sunday might face gridlocked traffic or water-logging during a rainy Tuesday evening. Check metro connectivity, drinking water reliability, grocery access, and civic infrastructure.',
      ],
      [
        'Step 4: Understand Carpet Area vs Super Built-Up Area',
        'One of the most frequent traps for first-time buyers is advertised "super built-up area," which includes lobbies, staircases, and amenities. What you actually live inside is the <strong>RERA Carpet Area</strong>. Always compare properties strictly on price per square foot of usable carpet area, rather than promotional numbers.',
      ],
      [
        'Step 5: Rigorous Document & Legal Verification',
        'Never hand over a booking token before verifying essential legal documentation:<br>1. Registered Title Deed & 30-year chain of title ownership<br>2. Encumbrance Certificate (EC) proving the property is free of legal disputes or unpaid mortgages<br>3. RERA Project Registration Number (verify on state RERA portal)<br>4. Sanctioned Building Plan & Commencement Certificate<br>5. Completion (CC) and Occupancy Certificate (OC) for ready-to-move homes<br>On Homeosphere, verified listings undergo rigorous preliminary scrutiny to safeguard buyers.',
      ],
      [
        'Step 6: Plan Your Home Loan Strategy',
        'Do not take a loan simply because a bank approves an excessive eligibility amount. Compare interest rates, fixed vs floating spreads, processing charges, and prepayment flexibility across multiple public and private lenders. Remember: shortening your tenure by even 5 years saves lakhs of rupees in compound interest.',
      ],
      [
        'Step 7: Plan for Post-Handover Life & Maintenance',
        'Signing the deed is not the end of the journey. Once you move in, your home requires electrical, plumbing, painting, deep cleaning, and appliance servicing. Having access to trusted, background-verified home service professionals ensures your new home stays pristine and retains its market value.',
      ],
    ],
    'takeaways' => [
      'Work backwards from your net income: your total EMI must never exceed 40% of monthly earnings.',
      'Always evaluate homes based on RERA Carpet Area rather than deceptive super built-up measurements.',
      'Mandatory document checks: 30-year Title Deed, Encumbrance Certificate, Sanctioned Plan, and Occupancy Certificate (OC).',
      'Account for 8-12% above the base property price for stamp duty, registration, and initial furnishing.',
    ],
  ],

  'seasonal-home-maintenance' => [
    'intro' => 'Owning a home is immensely rewarding—until something suddenly malfunctions. The AC blows warm air during peak May heat; rainwater seeps through a balcony wall in July; or the water heater trips the circuit breaker in December. Most domestic problems give subtle early warning signs that we tend to overlook. A disciplined seasonal checklist preserves your property, prevents emergency repair bills, and keeps your family safe year-round.',
    'quote' => 'Har season ka apna asar, timely maintenance rakhe ghar behtar.',
    'quote_sub' => 'Home Maintenance Principle • Published on DEV Community',
    'sections' => [
      [
        '1. Summer Home Checklist (March – May)',
        'Indian summers place intense demand on cooling equipment, electrical lines, and water reserves:<br>• <strong>AC Full Servicing:</strong> Clean or replace air filters, flush condenser coils, inspect refrigerant pressure, and ensure outdoor compressor ventilation.<br>• <strong>Electrical Safety Audit:</strong> Inspect switchboards for burning odors or loose contacts. Avoid overloading multi-plug extension sockets with heavy appliances.<br>• <strong>Water Storage Cleaning:</strong> Drain and deep clean overhead/underground water tanks to prevent bacterial and algae growth during high temperatures.<br>• <strong>Refrigerator Optimization:</strong> Vacuum dust from back condenser coils and verify door rubber gasket suction.',
      ],
      [
        '2. Monsoon Preparedness Checklist (June – September)',
        'Rainfall and atmospheric humidity require proactive defense against moisture and seepage:<br>• <strong>Roof & Terrace Inspection:</strong> Inspect parapet walls for micro-cracks, re-seal joints with elastomeric waterproofing compound, and clear terrace drainage grates of leaves.<br>• <strong>Window & Door Gaskets:</strong> Check silicone bead seals around UPVC/aluminum window frames to stop driving rain from penetrating wall plaster.<br>• <strong>Balcony & Drain Clearances:</strong> Clean floor drains in utility balconies to avoid standing water that can seep into floor slabs.<br>• <strong>Mold & Mildew Prevention:</strong> Keep wardrobes ventilated, place silica gel bags in shoe cabinets, and treat minor wall mold with anti-fungal solutions before it spreads.',
      ],
      [
        '3. Post-Monsoon Assessment (October)',
        'Once rains recede, inspect walls for damp patches, peeling paint, or efflorescence (salt deposits). Never paint over damp plaster—always fix the underlying water source before applying fresh coat of paint.',
      ],
      [
        '4. Winter Comfort Checklist (November – February)',
        '• <strong>Geyser Servicing:</strong> Flush out mineral sedimentation from water heater tanks and inspect the sacrificial anode rod to ensure safety and energy efficiency.<br>• <strong>Plumbing & Pipe Insulation:</strong> In colder northern regions, insulate exposed outdoor plumbing lines to avoid pressure drop or pipe bursts.<br>• <strong>Deep Dusting & Upholstery:</strong> Low winter humidity provides the best conditions for shampooing sofas, mattresses, and deep-cleaning ceiling fans.',
      ],
      [
        '5. Annual Appliance & Safety Schedule',
        'Maintain a digital maintenance log for all household assets: AC servicing twice a year, water purifier filter replacement every 6-9 months, inverter battery top-up, and periodic pest control. Keeping track prevents sudden breakdowns and extends appliance lifespan by years.',
      ],
    ],
    'takeaways' => [
      'Pre-season AC filter and coil servicing cuts summer power consumption by up to 15%.',
      'Waterproofing seals and drain clearances before June prevent costly interior moisture damage.',
      'Winter geyser descaling ensures electrical safety and faster heating performance.',
      'Proactive preventive maintenance saves up to 4x compared to emergency structural repairs.',
    ],
  ],

  'property-investment-hotspots' => [
    'intro' => 'With residential entry prices in mature metropolitan cores touching all-time highs, investors and second-home buyers are looking beyond saturated city centers. Rapid infrastructure developments—such as high-speed expressways, new international airports, and metro extensions—are unlocking massive capital appreciation and high rental yields in emerging growth corridors.',
    'quote' => 'Property ki chaar deewarein nahi, uske aas-paas ka shehar bhi aapka future decide karta hai.',
    'quote_sub' => 'Market Hotspots Analysis • Published on DEV Community & Homeosphere',
    'sections' => [
      [
        'Why Look Beyond Saturated Metro Cores?',
        'In established tier-1 micro-markets, high property purchase prices compress gross rental yields to 1.8% – 2.4%. Conversely, emerging corridors frequently yield 3.8% – 5.5% alongside significant headroom for 5-year capital appreciation as infrastructure projects complete.',
      ],
      [
        'Top 7 Micro-Market Corridors to Watch in 2026',
        '<strong>1. Whitefield & Sarjapur-ORR Extension (Bengaluru):</strong> Continued tech park expansions paired with operational Metro connectivity.<br><strong>2. Hinjewadi & Balewadi (Pune):</strong> High rental occupancy driven by IT corridors and Pune Metro Line 3.<br><strong>3. Kokapet & Neopolis (Hyderabad):</strong> Commercial SEZ development, wide expressway grids, and premium high-rise demand.<br><strong>4. Dwarka Expressway (Gurugram):</strong> Seamless access to IGI Airport and modern township developments.<br><strong>5. Navi Mumbai (Panvel & Ulwe):</strong> Propelled by the Atal Setu (MTHL) bridge and the upcoming Navi Mumbai International Airport.<br><strong>6. GST Road & Grand Southern Trunk (Chennai):</strong> Industrial and automotive hubs supporting strong middle-income housing demand.<br><strong>7. Super Corridor (Indore) & Amar Shaheed Path (Lucknow):</strong> High-performing Tier-2 growth hubs recording 14%+ annual capital appreciation.',
      ],
      [
        'The 3-Point Evaluation Framework for Hotspot Investing',
        '1. <strong>Employment Proximity:</strong> Is there a verified tech park, manufacturing belt, or university within 5 to 7 km?<br>2. <strong>Committed Infrastructure:</strong> Are the arterial expressways or metro lines currently under construction with realistic completion dates?<br>3. <strong>Healthy Price-to-Rent Ratio:</strong> Ensure the local purchase price supports reasonable monthly rental yields that cover home loan servicing.',
      ],
    ],
    'takeaways' => [
      'Emerging corridors deliver 3.8% - 5.5% rental yields compared to under 2.5% in saturated city centers.',
      'Major infrastructure catalysts (Atal Setu, Dwarka Expressway, Airport corridors) drive the highest appreciation.',
      'Always demand RERA compliance and track record verification even in high-growth investment zones.',
    ],
  ],

  'small-space-interior-ideas' => [
    'intro' => 'Living in a compact urban apartment under 800 square feet does not mean compromising on comfort, elegance, or storage. With intelligent space planning, multi-functional furniture, and thoughtful lighting, even modest footprints can feel open, airy, and luxurious.',
    'quote' => 'Chhota ghar bhi shaandar lag sakta hai jab har inch ko samajhdaari se design kiya jaye.',
    'quote_sub' => 'Interior Design Principle • Featured on Tumblr & Homeosphere',
    'sections' => [
      [
        '1. Choose Double-Duty Furniture',
        'Every piece in a compact home should justify its presence. A hydraulic storage bed, a dining table that folds flush into a study desk, or an ottoman that stores winter linens eliminates clutter while providing daily convenience.',
      ],
      [
        '2. Mirrors and Light Reflections',
        'Placing a full-length mirror directly opposite a natural window reflects sunlight into darker corners and creates the visual illusion of doubling the room’s depth.',
      ],
      [
        '3. Go Floor-to-Ceiling for Storage',
        'Instead of wide, waist-high dressers that eat up precious floor space, utilize vertical height. Floor-to-ceiling wardrobes and floating wall shelves maximize storage while keeping pathways completely clear.',
      ],
    ],
    'takeaways' => [
      'Multi-functional furniture frees up floor area and prevents visual clutter.',
      'Vertical storage draws the eye upward, making ceilings appear taller.',
      'Neutral color palettes paired with strategic mirrors amplify natural daylight.',
    ],
  ],

  'smart-home-essentials' => [
    'intro' => 'A smart home shouldn’t feel like an overwhelming tech demo. The best smart home technologies work quietly in the background—saving electricity, protecting your family, and taking friction out of everyday domestic routines.',
    'quote' => 'Smart home woh nahi jo sirf dikhne mein futuristic lage, balki woh jo aapki rozmarra zindagi ko aasan banaye.',
    'quote_sub' => 'Smart Living Principle • Featured on X (Twitter)',
    'sections' => [
      [
        '1. Start With Smart Lighting and Schedules',
        'Smart LED bulbs and Wi-Fi switches are the easiest entry point. Setting automated dusk-to-dawn schedules cuts unnecessary electricity waste and ensures you never return to a dark house.',
      ],
      [
        '2. Security That Delivers Real Peace of Mind',
        'A video doorbell paired with a smart biometric door lock lets you grant one-time access to delivery couriers or domestic staff even when you are at the office, backed by video verification.',
      ],
      [
        '3. Skip Gimmicks, Invest in Utility',
        'Focus your budget on smart plugs for water geysers and ACs. Turning on your geyser 15 minutes before your morning alarm saves hours of standby power consumption.',
      ],
    ],
    'takeaways' => [
      'Begin with high-impact essentials: automated lighting schedules and smart geyser plugs.',
      'Biometric locks and video doorbells provide verified security and remote access.',
      'Prioritize devices compatible with standard platforms like Google Home and Alexa.',
    ],
  ],

  'rental-agreement-checklist' => [
    'intro' => 'Before signing a rental agreement in India, taking thirty minutes to thoroughly review clauses protects both tenants and landlords from stressful disputes, surprise deductions, and sudden notices.',
    'quote' => 'Sign karne se pehle har clause padhna zaroori hai — ek galat line saalon ki pareshani ban sakti hai.',
    'quote_sub' => 'Rental Legal Guidance • Homeosphere Advisory',
    'sections' => [
      [
        '1. Security Deposit and Refund Timeline',
        'Ensure the agreement explicitly stipulates the exact deposit amount, permitted deductions (limited to actual structural damages or unpaid utility bills), and the exact time window for refund upon vacating (ideally within 7 to 15 days).',
      ],
      [
        '2. Repair and Maintenance Liabilities',
        'A standard rule: day-to-day minor repairs under ₹500 or ₹1,000 (such as changing light bulbs or minor tap washers) are handled by the tenant, whereas major structural leaks, electrical mains, and seepage are the landlord’s responsibility.',
      ],
      [
        '3. Notice Period and Lock-in Clauses',
        'Confirm that the notice period is clearly stated (usually 30 days) and check whether there is a lock-in period. Avoid rigid 11-month lock-in clauses that penalize sudden job relocations.',
      ],
    ],
    'takeaways' => [
      'Document the security deposit refund timeline in clear, unambiguous terms.',
      'Specify financial thresholds for minor vs major property maintenance responsibilities.',
      'Always inspect the property and attach a signed inventory and condition checklist before move-in.',
    ],
  ],
];

$body = $bodies[$post['slug']] ?? [
  'intro' => $post['excerpt'],
  'quote' => $post['quote'] ?? '',
  'quote_sub' => 'The Homeosphere Playbook',
  'sections' => [],
  'takeaways' => [],
];
$related = array_values(array_filter($posts, fn($x) => $x['slug'] !== $post['slug']));
$related = array_slice($related, 0, 3);

head([
  'title' => $post['title'] . ' | ' . SITE_NAME . ' Blog',
  'description' => $post['excerpt'],
  'canonical' => '/blogs/' . $post['slug'],
  'image' => $post['image'],
  'ogType' => 'article',
  'jsonld' => [
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $post['title'],
    'description' => $post['excerpt'],
    'image' => absolute_url($post['image']),
    'datePublished' => $post['date'],
    'author' => ['@type'=>'Organization','name'=>SITE_NAME],
    'publisher' => ['@type'=>'Organization','name'=>SITE_NAME],
    'mainEntityOfPage' => absolute_url('/blogs/' . $post['slug']),
  ],
]);
header_partial('blogs');
?>

<!-- Scroll Reading Progress Bar -->
<div class="blog-progress-container">
  <div id="readingProgress" class="blog-progress-bar"></div>
</div>

<section class="page-head" style="padding: 2.75rem 0 2rem 0;">
  <div class="container-x" style="max-width:52rem">
    <p class="breadcrumb">
      <a href="/">Home</a><span class="sep">/</span><a href="/blogs">Blogs</a><span class="sep">/</span><?= e($post['category']) ?>
    </p>
    
    <div style="margin-top:0.75rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;">
      <a href="/blogs" style="display:inline-flex;align-items:center;gap:.375rem;font-size:.875rem;font-weight:700;color:var(--gold-500);text-decoration:none;">
        <?= icon('arrow-left', 16) ?> Back to all articles
      </a>
      <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
        <span class="pill pill-gold" style="font-weight:700;"><?= e($post['category']) ?></span>
        <?php if (!empty($post['source_name']) && ($post['source'] ?? '') !== 'internal'): ?>
          <span class="blog-platform-badge blog-badge-<?= e($post['source']) ?>" style="position:static;">
            Featured on <?= e($post['source_name']) ?>
          </span>
        <?php endif; ?>
      </div>
    </div>

    <h1 style="margin-top:1.25rem;font-size:clamp(1.85rem, 3.5vw, 2.75rem);line-height:1.22;font-weight:800;color:#ffffff;">
      <?= e($post['title']) ?>
    </h1>

    <div class="article-meta" style="border:0;padding:0;margin-top:1.35rem;color:var(--navy-200);display:flex;flex-wrap:wrap;gap:1.25rem;font-size:0.875rem;">
      <span style="display:flex;align-items:center;gap:.375rem;font-weight:600;"><?= icon('user', 16) ?> <?= e($post['author']) ?></span>
      <span style="display:flex;align-items:center;gap:.375rem"><?= icon('calendar', 16) ?> <?= date('F j, Y', strtotime($post['date'])) ?></span>
      <span style="display:flex;align-items:center;gap:.375rem"><?= icon('clock', 16) ?> <?= e($post['read']) ?> read</span>
    </div>
  </div>
</section>

<div class="container-x" style="max-width:52rem;padding-top:2.5rem;padding-bottom:3rem;">

  <!-- Featured Cover Image -->
  <div style="position:relative;border-radius:1.5rem;overflow:hidden;box-shadow:0 15px 35px -5px rgba(11,31,58,0.12);border:1px solid var(--sand-300);">
    <img src="<?= e($post['image']) ?>" alt="<?= e($post['title']) ?>" style="aspect-ratio:16/9;width:100%;object-fit:cover;display:block;">
  </div>

  <article class="prose" style="margin-top:2.5rem;max-width:100%;">

    <?php if (!empty($post['source_url'])): ?>
      <!-- Official Publication Banner -->
      <div class="blog-syndication-banner">
        <div style="display:flex;align-items:center;gap:0.75rem;">
          <span style="display:grid;place-items:center;width:2.5rem;height:2.5rem;border-radius:0.75rem;background:#fff;border:1px solid var(--sand-300);color:var(--navy-900);">
            <?= icon('book-open', 18) ?>
          </span>
          <div>
            <div style="font-size:0.85rem;font-weight:800;color:var(--navy-900);">
              Originally Published on <?= e($post['source_name']) ?>
            </div>
            <div style="font-size:0.775rem;color:var(--navy-500);">
              Read the full discussion, applause, and community notes on <?= e($post['source_name']) ?>.
            </div>
          </div>
        </div>
        <a href="<?= e($post['source_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-gold" style="font-weight:700;display:inline-flex;align-items:center;gap:0.35rem;">
          <?= icon('external-link', 14) ?> Read on <?= e($post['source_name']) ?>
        </a>
      </div>
    <?php endif; ?>

    <!-- Introduction -->
    <p style="font-size:1.15rem;font-weight:500;line-height:1.75;color:var(--navy-800);margin-bottom:1.5rem;">
      <?= $body['intro'] ?>
    </p>

    <?php if (!empty($body['quote'])): ?>
      <!-- Signature Quoted Pullout Card -->
      <div class="blog-pullquote">
        <div style="display:flex;align-items:flex-start;gap:0.75rem;">
          <span style="color:var(--gold-600);font-size:1.5rem;line-height:1;"><?= icon('quote', 24) ?></span>
          <div>
            <div class="blog-pullquote-hindi">
              “<?= e($body['quote']) ?>”
            </div>
            <?php if (!empty($body['quote_sub'])): ?>
              <div class="blog-pullquote-sub">
                — <?= e($body['quote_sub']) ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if (count($body['sections']) >= 3): ?>
      <!-- Interactive Table of Contents -->
      <div class="blog-toc">
        <h4><?= icon('sliders', 16) ?> Quick Navigation &amp; Table of Contents</h4>
        <ol>
          <?php foreach ($body['sections'] as $idx => $s): ?>
            <li>
              <a href="#section-<?= $idx ?>"><?= e(strip_tags($s[0])) ?></a>
            </li>
          <?php endforeach; ?>
          <?php if (!empty($body['takeaways'])): ?>
            <li><a href="#key-takeaways">Summary &amp; Key Takeaways</a></li>
          <?php endif; ?>
        </ol>
      </div>
    <?php endif; ?>

    <!-- Article Sections -->
    <?php foreach ($body['sections'] as $idx => $s): ?>
      <section id="section-<?= $idx ?>" class="mt-10" style="scroll-margin-top:5rem;">
        <h2 style="font-size:1.45rem;font-weight:800;color:var(--navy-900);line-height:1.3;margin-bottom:0.75rem;padding-bottom:0.35rem;border-bottom:1px solid var(--sand-200);">
          <?= e($s[0]) ?>
        </h2>
        <div style="font-size:1rem;line-height:1.75;color:var(--navy-700);">
          <?= $s[1] ?>
        </div>
      </section>
    <?php endforeach; ?>

    <?php if (!empty($body['takeaways'])): ?>
      <!-- Takeaways Box -->
      <div id="key-takeaways" class="takeaways" style="scroll-margin-top:5rem;border:1.5px solid var(--sand-300);border-radius:1.25rem;background:var(--sand-50);padding:1.75rem;">
        <h3 style="font-size:1.15rem;font-weight:800;color:var(--navy-900);margin:0 0 0.85rem 0;display:flex;align-items:center;gap:0.5rem;">
          <?= icon('sparkles', 18) ?> Key Strategic Takeaways
        </h3>
        <ul style="margin:0;padding-left:0;list-style:none;display:flex;flex-direction:column;gap:0.6rem;">
          <?php foreach ($body['takeaways'] as $t): ?>
            <li style="display:flex;align-items:flex-start;gap:0.65rem;font-size:0.925rem;color:var(--navy-800);line-height:1.55;">
              <span style="color:#16a34a;flex-shrink:0;margin-top:0.15rem;"><?= icon('check', 16) ?></span>
              <span><?= e($t) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Social Share Ribbon -->
    <div class="blog-share-ribbon">
      <span style="font-size:0.825rem;font-weight:800;color:var(--navy-900);display:flex;align-items:center;gap:0.4rem;">
        <?= icon('share', 16) ?> Share this article:
      </span>

      <!-- X / Twitter -->
      <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title'] . ' — ' . (!empty($post['quote']) ? '"' . $post['quote'] . '"' : '') . ' via @homeosphere') ?>&url=<?= urlencode(url('/blogs/' . $post['slug'])) ?>" 
         target="_blank" rel="noopener noreferrer" class="blog-share-btn share-x" title="Share on X">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        Post on X
      </a>

      <!-- WhatsApp -->
      <a href="https://api.whatsapp.com/send?text=<?= urlencode($post['title'] . ' ' . url('/blogs/' . $post['slug'])) ?>" 
         target="_blank" rel="noopener noreferrer" class="blog-share-btn share-wa" title="Share on WhatsApp">
        <?= icon('phone', 14) ?> WhatsApp
      </a>

      <!-- LinkedIn -->
      <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(url('/blogs/' . $post['slug'])) ?>" 
         target="_blank" rel="noopener noreferrer" class="blog-share-btn share-in" title="Share on LinkedIn">
        <?= icon('linkedin', 14) ?> LinkedIn
      </a>

      <!-- Tumblr -->
      <a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?= urlencode(url('/blogs/' . $post['slug'])) ?>&title=<?= urlencode($post['title']) ?>" 
         target="_blank" rel="noopener noreferrer" class="blog-share-btn share-tumblr" title="Share on Tumblr">
        Tumblr
      </a>

      <!-- Copy Link -->
      <button type="button" onclick="copyArticleLink();" class="blog-share-btn" id="copyBtn" title="Copy link to clipboard">
        <?= icon('bookmark', 14) ?> <span id="copyBtnText">Copy Link</span>
      </button>
    </div>

    <!-- Author & Editorial Bio Card -->
    <div style="background:#ffffff;border:1px solid var(--sand-300);border-radius:1.25rem;padding:1.5rem;display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap;box-shadow:0 4px 16px rgba(11,31,58,0.04);">
      <div style="width:3.5rem;height:3.5rem;border-radius:9999px;background:linear-gradient(135deg,var(--navy-900),var(--navy-700));color:var(--gold-400);display:grid;place-items:center;font-weight:800;font-size:1.15rem;flex-shrink:0;box-shadow:0 4px 12px rgba(11,31,58,0.15);">
        HO
      </div>
      <div style="flex:1;min-width:16rem;">
        <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
          <h4 style="font-size:1.05rem;font-weight:800;color:var(--navy-900);margin:0;"><?= e($post['author']) ?></h4>
          <span class="pill" style="font-size:0.7rem;font-weight:700;background:rgba(22,163,74,0.1);color:#16a34a;padding:0.15rem 0.5rem;">
            ✓ Verified Editorial
          </span>
        </div>
        <p style="font-size:0.85rem;color:var(--navy-600);margin:0.35rem 0 0 0;line-height:1.5;">
          The Homeosphere Editorial &amp; PropTech Research Desk delivers actionable market intelligence, legal due diligence, and verified home management guides for property owners, buyers, and tenants across India.
        </p>
        <div style="margin-top:0.75rem;display:flex;gap:0.75rem;align-items:center;font-size:0.8rem;">
          <a href="https://medium.com/@deeksha_48830" target="_blank" rel="noopener noreferrer" style="color:var(--gold-600);font-weight:700;text-decoration:underline;">Medium Publication</a>
          <span style="color:var(--sand-400);">•</span>
          <a href="https://homeosphere.substack.com" target="_blank" rel="noopener noreferrer" style="color:var(--gold-600);font-weight:700;text-decoration:underline;">Substack Memo</a>
          <span style="color:var(--sand-400);">•</span>
          <a href="https://x.com/homeosphere" target="_blank" rel="noopener noreferrer" style="color:var(--gold-600);font-weight:700;text-decoration:underline;">@homeosphere on X</a>
        </div>
      </div>
    </div>

  </article>
</div>

<!-- Related Articles Section -->
<section class="section section-alt" style="padding:3.5rem 0;border-top:1px solid var(--sand-300);">
  <div class="container-x">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.75rem;">
      <div>
        <p class="eyebrow" style="margin:0 0 0.25rem 0;">Continue Reading</p>
        <h2 style="font-size:1.65rem;font-weight:800;color:var(--navy-900);margin:0;">Recommended Articles &amp; Guides</h2>
      </div>
      <a href="/blogs" class="btn btn-ghost btn-sm" style="font-weight:700;">
        Explore All Articles <?= icon('arrow-right', 16) ?>
      </a>
    </div>
    <div class="grid grid-3">
      <?php foreach ($related as $p): ?>
        <div class="reveal"><?= blog_card($p) ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
// Reading progress bar
window.addEventListener('scroll', function() {
  var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrolled = (winScroll / height) * 100;
  var bar = document.getElementById('readingProgress');
  if (bar) bar.style.width = scrolled + '%';
});

// Copy link utility
function copyArticleLink() {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(window.location.href).then(function() {
      var btnText = document.getElementById('copyBtnText');
      if (btnText) {
        btnText.innerText = 'Copied!';
        setTimeout(function() { btnText.innerText = 'Copy Link'; }, 2500);
      }
    });
  }
}
</script>

<?php footer_partial(); ?>

