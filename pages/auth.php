<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/icon.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';

// Determine initial auth mode (login vs signup)
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
$reqMode = trim($_GET['mode'] ?? '');
if ($reqMode === 'signup' || str_contains($uri, 'signup')) {
    $initialMode = 'signup';
} else {
    $initialMode = 'login';
}

// Pre-selected role (if arriving from pro or property pages)
$reqRole = strtolower(trim($_GET['role'] ?? ''));
if (str_contains($reqRole, 'pro')) {
    $defaultRole = 'professional';
} elseif (str_contains($reqRole, 'owner') || str_contains($reqRole, 'seller')) {
    $defaultRole = 'owner';
} else {
    $defaultRole = 'seeker';
}

head([
    'title'       => ($initialMode === 'signup' ? 'Create Account' : 'Sign In') . ' — India\'s Complete Home Ecosystem | ' . SITE_NAME,
    'description' => 'Sign in or create your Homeosphere account to discover verified properties, book trusted home services, hire professionals, and manage your property.',
    'canonical'   => ($initialMode === 'signup' ? '/signup' : '/login'),
]);
header_partial('auth');
?>

<section class="auth-section">
  <div class="container-x" style="max-width: 34rem; width: 100%;">
    
    <div class="auth-card reveal">
      
      <!-- Brand Logo / Eyebrow Header -->
      <div style="text-align: center; margin-bottom: 1.75rem;">
        <span class="pill" style="background: rgba(212, 160, 23, 0.12); color: var(--gold-700); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; padding: 0.35rem 0.85rem; border-radius: 9999px;">
          <?= icon('shield', 14) ?> Verified Home Ecosystem
        </span>
      </div>

      <!-- Segmented Tab Controls: Sign In vs Create Account -->
      <div class="auth-tabs" role="tablist">
        <button type="button" 
                class="auth-tab-btn <?= $initialMode === 'login' ? 'active' : '' ?>" 
                id="tabLogin" 
                role="tab" 
                aria-selected="<?= $initialMode === 'login' ? 'true' : 'false' ?>">
          <?= icon('lock', 16) ?> Sign In
        </button>
        <button type="button" 
                class="auth-tab-btn <?= $initialMode === 'signup' ? 'active' : '' ?>" 
                id="tabSignup" 
                role="tab" 
                aria-selected="<?= $initialMode === 'signup' ? 'true' : 'false' ?>">
          <?= icon('user', 16) ?> Create Account
        </button>
      </div>

      <!-- ================================================================ -->
      <!-- SIGN IN FORM (LOGIN) -->
      <!-- ================================================================ -->
      <form id="formLogin" novalidate style="<?= $initialMode === 'login' ? 'display:block;' : 'display:none;' ?>">
        
        <div style="margin-bottom: 1.5rem; text-align: center;">
          <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.35rem;">Welcome back</h1>
          <p style="font-size: 0.875rem; color: var(--navy-500); margin: 0;">Sign in to access your properties, bookings &amp; dashboard.</p>
        </div>

        <div id="login_status" style="display:none; padding:0.75rem 1rem; border-radius:0.75rem; margin-bottom:1.25rem; font-size:0.875rem; line-height:1.4;"></div>

        <!-- Identifier: Email or Mobile -->
        <div class="field-group">
          <label class="label" for="login_identifier" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Email or Mobile number</label>
          <div class="input-wrap">
            <input class="input" 
                   id="login_identifier" 
                   name="identifier" 
                   type="text" 
                   placeholder="priya@example.com or 9876543210" 
                   required 
                   autocomplete="username"
                   style="width: 100%;">
          </div>
          <div class="field-error" id="login_identifier_error"></div>
          <div class="field-success" id="login_identifier_success"></div>
        </div>

        <!-- Password -->
        <div class="field-group">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
            <label class="label" for="login_password" style="font-weight:600; font-size:0.875rem; margin:0;">Password</label>
            <a href="javascript:void(0)" onclick="alert('Password reset instructions have been sent to your registered email/phone.');" style="font-size: 0.8rem; font-weight: 600; color: var(--gold-600); text-decoration: none;">Forgot password?</a>
          </div>
          <div class="input-wrap">
            <input class="input" 
                   id="login_password" 
                   name="password" 
                   type="password" 
                   placeholder="Enter your password" 
                   required 
                   autocomplete="current-password"
                   style="width: 100%; padding-right: 2.75rem;">
            <button type="button" class="input-password-toggle" data-target="login_password" aria-label="Show password">
              <?= icon('eye', 18) ?>
            </button>
          </div>
          <div class="field-error" id="login_password_error"></div>
        </div>

        <!-- Remember Me Checkbox -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
          <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--navy-700); cursor: pointer; user-select: none;">
            <input type="checkbox" name="remember" style="accent-color: var(--gold-500); width: 1rem; height: 1rem; cursor: pointer;">
            Remember me on this device
          </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-gold btn-block btn-lg" style="font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
          Sign In to Homeosphere <?= icon('arrow-right', 16) ?>
        </button>

        <div class="auth-divider">
          <span>or continue with</span>
        </div>

        <!-- Social / Alternative Options -->
        <div style="display: grid; gap: 0.75rem;">
          <button type="button" class="auth-social-btn" onclick="alert('Google One-Tap is ready to authenticate.');">
            <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.34 24 12 24z"/><path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.17 0 9.98 0 12s.45 3.83 1.25 5.42l4.03-3.15z"/><path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.34 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/></svg>
            Continue with Google
          </button>
          <button type="button" class="auth-social-btn" onclick="alert('Instant OTP sent to your registered Indian mobile number.');">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
            Continue with Mobile OTP
          </button>
        </div>

        <p style="text-align: center; font-size: 0.85rem; color: var(--navy-500); margin-top: 1.5rem;">
          Don't have an account yet? 
          <a href="javascript:void(0)" onclick="switchAuthTab('signup')" style="color: var(--gold-600); font-weight: 700; text-decoration: none;">Create an account</a>
        </p>
      </form>


      <!-- ================================================================ -->
      <!-- CREATE ACCOUNT FORM (SIGN UP) -->
      <!-- ================================================================ -->
      <form id="formSignup" novalidate style="<?= $initialMode === 'signup' ? 'display:block;' : 'display:none;' ?>">
        
        <div style="margin-bottom: 1.5rem; text-align: center;">
          <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--navy-900); margin: 0 0 0.35rem;">Create your account</h1>
          <p style="font-size: 0.875rem; color: var(--navy-500); margin: 0;">Join India's complete home ecosystem in seconds.</p>
        </div>

        <div id="signup_status" style="display:none; padding:0.75rem 1rem; border-radius:0.75rem; margin-bottom:1.25rem; font-size:0.875rem; line-height:1.4;"></div>

        <!-- Ecosystem Persona / Role Selector -->
        <div style="margin-bottom: 1.25rem;">
          <label style="display: block; font-size: 0.825rem; font-weight: 700; color: var(--navy-800); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
            Select Your Account Type
          </label>
          <input type="hidden" id="signup_role" name="role" value="<?= e($defaultRole) ?>">
          <div class="auth-roles-grid">
            
            <div class="auth-role-card <?= $defaultRole === 'seeker' ? 'active' : '' ?>" data-role="seeker">
              <span class="auth-role-icon"><?= icon('home', 16) ?></span>
              <span class="auth-role-title">Buyer / Tenant</span>
            </div>

            <div class="auth-role-card <?= $defaultRole === 'owner' ? 'active' : '' ?>" data-role="owner">
              <span class="auth-role-icon"><?= icon('building', 16) ?></span>
              <span class="auth-role-title">Property Owner</span>
            </div>

            <div class="auth-role-card <?= $defaultRole === 'professional' ? 'active' : '' ?>" data-role="professional">
              <span class="auth-role-icon"><?= icon('wrench', 16) ?></span>
              <span class="auth-role-title">Service Pro / Agency</span>
            </div>

          </div>
        </div>

        <!-- Full Name (Rule 1: Required, Rule 2: Min 3 Max 50, Rule 4: Regex) -->
        <div class="field-group">
          <label class="label" for="signup_name" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Full name</label>
          <input class="input" 
                 id="signup_name" 
                 name="name" 
                 type="text" 
                 placeholder="Priya Sharma" 
                 minlength="3" 
                 maxlength="50" 
                 required 
                 autocomplete="name"
                 style="width: 100%;">
          <div class="field-error" id="signup_name_error"></div>
          <div class="field-success" id="signup_name_success"></div>
        </div>

        <!-- Email Address (Rule 1: Required, Rule 3: Data Type Email, Rule 4: Pattern) -->
        <div class="field-group">
          <label class="label" for="signup_email" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Email address</label>
          <input class="input" 
                 id="signup_email" 
                 name="email" 
                 type="email" 
                 placeholder="priya.sharma@example.com" 
                 required 
                 autocomplete="email"
                 style="width: 100%;">
          <div class="field-error" id="signup_email_error"></div>
          <div class="field-success" id="signup_email_success"></div>
        </div>

        <!-- Phone Number & City Row -->
        <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 0.75rem;">
          
          <!-- Mobile Phone (Rule 1: Required, Rule 2: 10 digits, Rule 4: Indian Mobile Regex) -->
          <div class="field-group">
            <label class="label" for="signup_phone" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Mobile number</label>
            <div class="input-wrap">
              <span style="position: absolute; left: 0.75rem; font-weight: 700; font-size: 0.85rem; color: var(--navy-500); pointer-events: none;">+91</span>
              <input class="input" 
                     id="signup_phone" 
                     name="phone" 
                     type="tel" 
                     placeholder="98765 43210" 
                     required 
                     maxlength="14"
                     autocomplete="tel"
                     style="width: 100%; padding-left: 3.25rem;">
            </div>
            <div class="field-error" id="signup_phone_error"></div>
            <div class="field-success" id="signup_phone_success"></div>
          </div>

          <!-- City Dropdown -->
          <div class="field-group">
            <label class="label" for="signup_city" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">City / Hub</label>
            <select class="input" id="signup_city" name="city" style="width: 100%;">
              <option>Delhi NCR</option>
              <option>Gurugram</option>
              <option>Noida</option>
              <option>Mumbai</option>
              <option>Bengaluru</option>
              <option>Hyderabad</option>
              <option>Pune</option>
              <option>Chennai</option>
              <option>Kolkata</option>
              <option>Ahmedabad</option>
            </select>
          </div>

        </div>

        <!-- Password (Rule 1: Required, Rule 2: Min 8 Max 64, Rule 4: Complex Regex) -->
        <div class="field-group">
          <label class="label" for="signup_password" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Create password</label>
          <div class="input-wrap">
            <input class="input" 
                   id="signup_password" 
                   name="password" 
                   type="password" 
                   placeholder="At least 8 characters" 
                   minlength="8" 
                   maxlength="64" 
                   required 
                   autocomplete="new-password"
                   style="width: 100%; padding-right: 2.75rem;">
            <button type="button" class="input-password-toggle" data-target="signup_password" aria-label="Show password">
              <?= icon('eye', 18) ?>
            </button>
          </div>
          <!-- Live Password Strength Meter -->
          <div class="password-meter">
            <div class="password-meter-fill" id="password_meter_fill"></div>
          </div>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="password-criteria">8+ chars with uppercase, number &amp; symbol (@$!%*?&#)</span>
            <span id="password_meter_text" style="font-size: 0.725rem; font-weight: 700;"></span>
          </div>
          <div class="field-error" id="signup_password_error"></div>
          <div class="field-success" id="signup_password_success"></div>
        </div>

        <!-- Confirm Password (Rule 5: Cross-Field Match with #signup_password) -->
        <div class="field-group">
          <label class="label" for="signup_confirm_password" style="display:block; margin-bottom:0.35rem; font-weight:600; font-size:0.875rem;">Confirm password</label>
          <div class="input-wrap">
            <input class="input" 
                   id="signup_confirm_password" 
                   name="confirm_password" 
                   type="password" 
                   placeholder="Re-enter your password" 
                   required 
                   autocomplete="new-password"
                   style="width: 100%; padding-right: 2.75rem;">
            <button type="button" class="input-password-toggle" data-target="signup_confirm_password" aria-label="Show password">
              <?= icon('eye', 18) ?>
            </button>
          </div>
          <div class="field-error" id="signup_confirm_password_error"></div>
          <div class="field-success" id="signup_confirm_password_success"></div>
        </div>

        <!-- Terms and Conditions Agreement (Rule 1: Required Boolean) -->
        <div style="margin-bottom: 1.5rem;">
          <label style="display: flex; align-items: flex-start; gap: 0.5rem; font-size: 0.825rem; color: var(--navy-600); cursor: pointer; line-height: 1.4;">
            <input type="checkbox" id="signup_terms" name="terms" required style="accent-color: var(--gold-500); width: 1.1rem; height: 1.1rem; margin-top: 0.1rem; cursor: pointer; flex-shrink: 0;">
            <span>I agree to Homeosphere's <a href="<?= url('/terms-and-conditions') ?>" target="_blank" style="color: var(--navy-900); font-weight: 600; text-decoration: underline;">Terms of Service</a> and <a href="<?= url('/privacy-policy') ?>" target="_blank" style="color: var(--navy-900); font-weight: 600; text-decoration: underline;">Privacy Policy</a>.</span>
          </label>
          <div class="field-error" id="signup_terms_error"></div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-gold btn-block btn-lg" style="font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
          Create Free Account <?= icon('arrow-right', 16) ?>
        </button>

        <p style="text-align: center; font-size: 0.85rem; color: var(--navy-500); margin-top: 1.5rem;">
          Already have an account? 
          <a href="javascript:void(0)" onclick="switchAuthTab('login')" style="color: var(--gold-600); font-weight: 700; text-decoration: none;">Sign in here</a>
        </p>

      </form>

    </div>

  </div>
</section>

<script src="<?= asset('js/auth.js') ?>"></script>

<?php footer_partial(false); ?>
