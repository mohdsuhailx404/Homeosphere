<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/cards.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';

// Auth guard: redirect guests to login
if (!is_logged_in()) {
    header('Location: /login?redirect=/dashboard');
    exit;
}

$user = current_user();
$allProperties = properties();

// Get real user activity from store
$userActivity = get_user_activity($user['id']);
$savedPropIds = $userActivity['saved_properties'] ?? [];
$userBookings = $userActivity['bookings'] ?? [];

// Filter real saved properties from the catalogue
$savedProps = [];
if (!empty($savedPropIds)) {
    $strIds = array_map('strval', $savedPropIds);
    foreach ($allProperties as $p) {
        if (in_array((string)$p['id'], $strIds)) {
            $savedProps[] = $p;
        }
    }
}
$savedCount = count($savedProps);
$bookingCount = count($userBookings);

head([
    'title'       => 'My Dashboard & Profile — ' . SITE_NAME,
    'description' => 'Manage your Homeosphere profile, saved properties, and active service bookings.',
    'canonical'   => '/dashboard',
]);
header_partial('dashboard');
?>

<style>
.profile-card-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1.5rem;
}
.profile-user-info {
  display: flex;
  align-items: center;
  gap: 1.25rem;
  min-width: 0;
}
.profile-avatar {
  width: 4.5rem;
  height: 4.5rem;
  border-radius: 9999px;
  background: linear-gradient(135deg, var(--navy-900), var(--navy-800));
  color: var(--gold-400);
  font-weight: 800;
  font-size: 1.6rem;
  display: grid;
  place-items: center;
  border: 3px solid var(--gold-400);
  box-shadow: 0 8px 20px -5px rgba(212, 160, 23, 0.4);
  flex-shrink: 0;
}
.profile-actions {
  display: flex;
  gap: 0.75rem;
}
.profile-metrics-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  margin-top: 1.75rem;
  padding-top: 1.5rem;
  border-top: 1px solid var(--sand-200);
}
.account-info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(min(14rem, 100%), 1fr));
  gap: 1.5rem;
}
.saved-props-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(min(18rem, 100%), 1fr));
  gap: 1.5rem;
}
.booking-item-row {
  padding: 1.25rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
}
.booking-item-left {
  display: flex;
  align-items: center;
  gap: 1rem;
  min-width: 0;
}
.booking-actions-right {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

@media(max-width: 640px) {
  .profile-card-top {
    flex-direction: column;
    align-items: flex-start;
    gap: 1.25rem;
  }
  .profile-user-info {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
    width: 100%;
  }
  .profile-avatar {
    width: 3.75rem;
    height: 3.75rem;
    font-size: 1.35rem;
  }
  .profile-actions {
    width: 100%;
  }
  .profile-actions a {
    flex: 1;
    text-align: center;
    justify-content: center;
  }
  .profile-metrics-grid {
    grid-template-columns: 1fr 1fr;
    gap: 0.65rem;
    padding-top: 1.25rem;
    margin-top: 1.25rem;
  }
  .profile-metric-box {
    padding: 0.85rem 0.95rem !important;
  }
  .profile-metric-box div:first-child {
    font-size: 0.7rem !important;
  }
  .profile-metric-box div:last-child {
    font-size: 1.25rem !important;
  }
  .account-info-grid {
    gap: 1rem;
  }
  .booking-item-row {
    flex-direction: column;
    align-items: flex-start;
    padding: 1rem;
    gap: 0.85rem;
  }
  .booking-item-left {
    width: 100%;
  }
  .booking-actions-right {
    width: 100%;
    justify-content: space-between;
  }
  .booking-actions-right .btn {
    flex: 1;
    text-align: center;
  }
}
</style>

<section class="section" style="background: radial-gradient(circle at 50% 10%, rgba(212,160,23,0.08) 0%, transparent 60%), var(--sand-50, #fbfbf9); padding: 3rem 0 5rem;">
  <div class="container-x">

    <!-- Welcome Toast (if just registered or logged in) -->
    <?php if (isset($_GET['welcome'])): ?>
      <div class="reveal" style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 1rem; padding: 1rem 1.25rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
          <span style="display: grid; place-items: center; width: 2.25rem; height: 2.25rem; border-radius: 9999px; background: #dcfce7; color: #16a34a;">
            <?= icon('check-circle', 20) ?>
          </span>
          <div>
            <h4 style="margin: 0; font-size: 0.95rem; font-weight: 800; color: #166534;">Welcome to your Homeosphere Dashboard, <?= e($user['name']) ?>!</h4>
            <p style="margin: 0.15rem 0 0; font-size: 0.825rem; color: #15803d;">Your account is ready. Discover verified properties or book trusted home services below.</p>
          </div>
        </div>
        <a href="<?= url('/dashboard') ?>" style="font-size: 0.8rem; font-weight: 700; color: #166534; text-decoration: none;">Dismiss ✕</a>
      </div>
    <?php endif; ?>

    <!-- User Profile Header Card -->
    <div class="card card-pad reveal" style="border-radius: 1.5rem; margin-bottom: 2rem; background: #ffffff; border: 1px solid var(--sand-200); box-shadow: 0 10px 30px -5px rgba(11, 31, 58, 0.06);">
      <div class="profile-card-top">
        
        <div class="profile-user-info">
          <div class="profile-avatar">
            <?= e(user_initials($user['name'])) ?>
          </div>
          <div style="min-width: 0; flex: 1;">
            <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
              <h1 style="font-size: clamp(1.3rem, 3.5vw, 1.6rem); font-weight: 800; color: var(--navy-900); margin: 0;"><?= e($user['name']) ?></h1>
              <span class="pill" style="background: rgba(212, 160, 23, 0.14); color: var(--gold-700); font-weight: 800; font-size: 0.75rem; text-transform: uppercase; padding: 0.3rem 0.75rem; border-radius: 9999px;">
                <?= e(role_label($user['role'])) ?>
              </span>
              <span class="pill" style="background: #f0fdf4; color: #16a34a; font-weight: 700; font-size: 0.725rem; padding: 0.25rem 0.65rem; border-radius: 9999px; border: 1px solid #bbf7d0;">
                ✓ Verified
              </span>
            </div>
            <p style="margin: 0.35rem 0 0; font-size: 0.875rem; color: var(--navy-500); display: flex; align-items: center; gap: 0.85rem; flex-wrap: wrap; word-break: break-word;">
              <span style="display: inline-flex; align-items: center; gap: 0.3rem;"><?= icon('mail', 14) ?> <?= e($user['email']) ?></span>
              <?php if (!empty($user['phone'])): ?>
                <span style="display: inline-flex; align-items: center; gap: 0.3rem;"><?= icon('phone', 14) ?> <?= e($user['phone']) ?></span>
              <?php endif; ?>
              <span style="display: inline-flex; align-items: center; gap: 0.3rem;"><?= icon('map-pin', 14) ?> <?= e($user['city']) ?></span>
            </p>
          </div>
        </div>

        <div class="profile-actions">
          <a href="<?= url('/properties') ?>" class="btn btn-gold btn-sm" style="font-weight: 700; display: inline-flex; align-items: center; justify-content: center;">
            Browse Properties ➔
          </a>
          <a href="<?= url('/logout') ?>" class="btn btn-ghost btn-sm" style="color: #dc2626; border-color: #fecaca; font-weight: 700; display: inline-flex; align-items: center; justify-content: center;">
            Sign Out
          </a>
        </div>

      </div>

      <!-- Quick Metrics Ribbon (2 real metrics side-by-side) -->
      <div class="profile-metrics-grid">
        <div class="profile-metric-box" style="background: var(--sand-50, #f8fafc); padding: 1.1rem 1.25rem; border-radius: 1rem; border: 1px solid var(--sand-200);">
          <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase; letter-spacing: 0.04em;">Saved Properties</div>
          <div style="font-size: 1.5rem; font-weight: 800; color: var(--navy-900); margin-top: 0.25rem;">
            <?= $savedCount ?> <span style="font-size: 0.85rem; font-weight: 600; color: var(--navy-400);"><?= $savedCount === 1 ? 'Home' : 'Homes' ?></span>
          </div>
        </div>
        <div class="profile-metric-box" style="background: var(--sand-50, #f8fafc); padding: 1.1rem 1.25rem; border-radius: 1rem; border: 1px solid var(--sand-200);">
          <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-500); text-transform: uppercase; letter-spacing: 0.04em;">Active Bookings</div>
          <div style="font-size: 1.5rem; font-weight: 800; color: var(--navy-900); margin-top: 0.25rem;">
            <?= $bookingCount ?> <span style="font-size: 0.85rem; font-weight: 600; color: var(--navy-400);"><?= $bookingCount === 1 ? 'Request' : 'In Progress' ?></span>
          </div>
        </div>
      </div>
    </div>


    <!-- ================================================================ -->
    <!-- SECTION 1: ACCOUNT & PERSONAL DETAILS -->
    <!-- ================================================================ -->
    <div style="margin-bottom: 3rem;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
        <div>
          <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--navy-900); margin: 0;">Account Information</h2>
          <p style="font-size: 0.85rem; color: var(--navy-500); margin: 0.2rem 0 0;">Your personal contact details and ecosystem credentials.</p>
        </div>
      </div>

      <div class="card card-pad" style="border-radius: 1.25rem; background: #ffffff; border: 1px solid var(--sand-200);">
        <div class="account-info-grid">
          
          <div>
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-400); text-transform: uppercase; letter-spacing: 0.05em;">Full Name</div>
            <div style="font-size: 0.95rem; font-weight: 700; color: var(--navy-900); margin-top: 0.25rem;"><?= e($user['name']) ?></div>
          </div>

          <div>
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-400); text-transform: uppercase; letter-spacing: 0.05em;">Email Address</div>
            <div style="font-size: 0.95rem; font-weight: 700; color: var(--navy-900); margin-top: 0.25rem; word-break: break-all;"><?= e($user['email']) ?></div>
          </div>

          <div>
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-400); text-transform: uppercase; letter-spacing: 0.05em;">Mobile Phone</div>
            <div style="font-size: 0.95rem; font-weight: 700; color: var(--navy-900); margin-top: 0.25rem;"><?= e($user['phone'] ?: '+91 Not provided') ?></div>
          </div>

          <div>
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-400); text-transform: uppercase; letter-spacing: 0.05em;">City / Region</div>
            <div style="font-size: 0.95rem; font-weight: 700; color: var(--navy-900); margin-top: 0.25rem;"><?= e($user['city']) ?></div>
          </div>

          <div>
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-400); text-transform: uppercase; letter-spacing: 0.05em;">Account Persona</div>
            <div style="font-size: 0.95rem; font-weight: 700; color: var(--gold-700); margin-top: 0.25rem;"><?= e(role_label($user['role'])) ?></div>
          </div>

          <div>
            <div style="font-size: 0.75rem; font-weight: 700; color: var(--navy-400); text-transform: uppercase; letter-spacing: 0.05em;">Member Since</div>
            <div style="font-size: 0.95rem; font-weight: 700; color: var(--navy-900); margin-top: 0.25rem;"><?= date('F j, Y', strtotime($user['created_at'])) ?></div>
          </div>

        </div>
      </div>
    </div>


    <!-- ================================================================ -->
    <!-- SECTION 2: SAVED PROPERTIES -->
    <!-- ================================================================ -->
    <div id="saved" style="margin-bottom: 3rem; scroll-margin-top: 6rem;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem;">
        <div>
          <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--navy-900); margin: 0;">Saved Properties (<?= $savedCount ?>)</h2>
          <p style="font-size: 0.85rem; color: var(--navy-500); margin: 0.2rem 0 0;">Homes you have bookmarked for visits, price tracking, or purchase.</p>
        </div>
        <a href="<?= url('/properties') ?>" style="font-size: 0.85rem; font-weight: 700; color: var(--gold-600); text-decoration: none;">Explore More Properties ➔</a>
      </div>

      <?php if ($savedCount === 0): ?>
        <!-- Option 2: Empty State for Saved Properties -->
        <div class="card card-pad" style="border-radius: 1.25rem; background: #ffffff; border: 1.5px dashed var(--sand-300); text-align: center; padding: 3.5rem 1.5rem;">
          <div style="width: 4rem; height: 4rem; border-radius: 9999px; background: rgba(212,160,23,0.12); color: var(--gold-600); display: grid; place-items: center; margin: 0 auto 1rem; font-size: 1.75rem;">
            ♥
          </div>
          <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.5rem;">You haven't saved any properties yet</h3>
          <p style="font-size: 0.875rem; color: var(--navy-500); max-width: 26rem; margin: 0 auto 1.5rem; line-height: 1.5;">
            Browse our verified homes across Delhi NCR, Mumbai, and Bengaluru. Click the heart icon on any listing to save it to your dashboard.
          </p>
          <a href="<?= url('/properties') ?>" class="btn btn-gold" style="font-weight: 700; padding: 0.75rem 1.5rem; display: inline-flex; align-items: center; gap: 0.4rem;">
            Browse Verified Properties ➔
          </a>
        </div>
      <?php else: ?>
        <div class="saved-props-grid">
          <?php foreach ($savedProps as $p): ?>
            <div class="card" style="border-radius: 1.25rem; overflow: hidden; background: #ffffff; border: 1px solid var(--sand-200); box-shadow: 0 4px 14px rgba(11, 31, 58, 0.04); position: relative;">
              <div style="position: relative; height: 12rem; overflow: hidden;">
                <img src="<?= e($p['image']) ?>" alt="<?= e($p['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                <span class="pill" style="position: absolute; top: 0.75rem; left: 0.75rem; background: var(--navy-900); color: #ffffff; font-size: 0.725rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: 9999px;">
                  <?= e($p['type']) ?>
                </span>
                <button type="button" 
                        class="prop-favorite-btn is-saved" 
                        data-prop-id="<?= e($p['id']) ?>"
                        title="Remove from saved"
                        aria-label="Remove from saved">
                  <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                  </svg>
                </button>
              </div>
              <div style="padding: 1.25rem;">
                <div style="font-size: 1.2rem; font-weight: 800; color: var(--navy-900);"><?= e($p['priceLabel']) ?></div>
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy-800); margin: 0.35rem 0 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= e($p['title']) ?></h3>
                <p style="font-size: 0.8rem; color: var(--navy-500); margin: 0 0 1rem; display: flex; align-items: center; gap: 0.3rem;">
                  <?= icon('map-pin', 12) ?> <?= e($p['location']) ?>
                </p>
                
                <div style="display: flex; gap: 0.5rem; font-size: 0.75rem; font-weight: 600; color: var(--navy-600); margin-bottom: 1.15rem;">
                  <span><?= e($p['beds']) ?> Beds</span> • <span><?= e($p['baths']) ?> Baths</span> • <span><?= e($p['area'] ?? $p['sqft'] ?? '—') ?> sqft</span>
                </div>

                <button type="button" 
                        class="btn btn-gold btn-block btn-sm view-details-btn" 
                        data-prop="<?= e(json_encode($p)) ?>"
                        style="font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 0.35rem;">
                  View Details &amp; Request Visit ➔
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>


    <!-- ================================================================ -->
    <!-- SECTION 3: ACTIVE BOOKINGS & INQUIRIES -->
    <!-- ================================================================ -->
    <div id="bookings" style="scroll-margin-top: 6rem;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem;">
        <div>
          <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--navy-900); margin: 0;">Active Bookings &amp; Inquiries (<?= $bookingCount ?>)</h2>
          <p style="font-size: 0.85rem; color: var(--navy-500); margin: 0.2rem 0 0;">Track service schedules, property visits, and advisor consultations.</p>
        </div>
        <a href="<?= url('/services') ?>" style="font-size: 0.85rem; font-weight: 700; color: var(--gold-600); text-decoration: none;">Book a New Service ➔</a>
      </div>

      <?php if ($bookingCount === 0): ?>
        <!-- Option 2: Empty State for Bookings -->
        <div class="card card-pad" style="border-radius: 1.25rem; background: #ffffff; border: 1.5px dashed var(--sand-300); text-align: center; padding: 3.5rem 1.5rem;">
          <div style="width: 4rem; height: 4rem; border-radius: 9999px; background: var(--navy-50); color: var(--navy-700); display: grid; place-items: center; margin: 0 auto 1rem;">
            <?= icon('calendar', 26) ?>
          </div>
          <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.5rem;">No active bookings or requests</h3>
          <p style="font-size: 0.875rem; color: var(--navy-500); max-width: 26rem; margin: 0 auto 1.5rem; line-height: 1.5;">
            You haven't requested any property visits or home services yet. Schedule a site visit on any listing or book verified professionals anytime.
          </p>
          <div style="display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap;">
            <a href="<?= url('/services') ?>" class="btn btn-gold" style="font-weight: 700; padding: 0.75rem 1.5rem;">
              Explore Services ➔
            </a>
            <a href="<?= url('/properties') ?>" class="btn btn-ghost" style="font-weight: 700; padding: 0.75rem 1.5rem;">
              Schedule Property Visit
            </a>
          </div>
        </div>
      <?php else: ?>
        <div class="card" style="border-radius: 1.25rem; background: #ffffff; border: 1px solid var(--sand-200); overflow: hidden;">
          <?php foreach ($userBookings as $idx => $bk): ?>
            <div class="booking-item-row" style="<?= $idx < $bookingCount - 1 ? 'border-bottom: 1px solid var(--sand-200);' : '' ?>">
              <div class="booking-item-left">
                <span style="display: grid; place-items: center; width: 3rem; height: 3rem; border-radius: 0.75rem; background: <?= ($bk['type'] ?? '') === 'site_visit' ? 'var(--navy-50)' : 'rgba(212,160,23,0.12)' ?>; color: <?= ($bk['type'] ?? '') === 'site_visit' ? 'var(--navy-800)' : 'var(--gold-700)' ?>; flex-shrink: 0;">
                  <?= icon(($bk['type'] ?? '') === 'site_visit' ? 'home' : 'wrench', 20) ?>
                </span>
                <div style="min-width: 0;">
                  <div style="font-weight: 800; color: var(--navy-900); font-size: 0.95rem;"><?= e($bk['title']) ?></div>
                  <div style="font-size: 0.8rem; color: var(--navy-500); margin-top: 0.2rem;">
                    Location: <strong><?= e($bk['location'] ?? 'Delhi NCR') ?></strong> • Date: <strong><?= e($bk['date']) ?></strong> • Specialist: <strong><?= e($bk['specialist'] ?? 'Assigned Advisor') ?></strong>
                  </div>
                </div>
              </div>
              <div class="booking-actions-right">
                <span class="pill" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 0.75rem; font-weight: 700; padding: 0.3rem 0.75rem; border-radius: 9999px;">
                  ● <?= e($bk['status'] ?? 'Scheduled') ?>
                </span>
                <a href="tel:+919000000000" class="btn btn-sm btn-ghost" style="font-size: 0.8rem; font-weight: 600;">Contact Advisor</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>

<?php footer_partial(); ?>
