/**
 * Homeosphere - Authentication & Strict 5-Tier Form Validation System
 * 
 * 1. Required: Ensures fields are not left empty or whitespace.
 * 2. Min/Max Length: Enforces character bounds (Name: 3-50, Password: 8-64, Phone: 10-14).
 * 3. Data Type: Validates input types (email, telephone, text, checkbox).
 * 4. Pattern (Regex):
 *    - Name: Letters, spaces, dots only.
 *    - Phone: Indian mobile (10 digits starting with 6-9, optional +91).
 *    - Password: Min 8 chars, 1 uppercase, 1 lowercase, 1 number, 1 special character.
 * 5. Cross-Field Match:
 *    - Compares Password and Confirm Password in real-time.
 */

(function () {
  'use strict';

  // REGEX PATTERNS
  var PATTERNS = {
    name: /^[a-zA-Z\s\.\']{3,50}$/,
    email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
    phone: /^(?:\+91[\s-]?)?[6-9]\d{9}$/,
    password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,64}$/
  };

  // DOM Elements
  var tabLogin = document.getElementById('tabLogin');
  var tabSignup = document.getElementById('tabSignup');
  var formLogin = document.getElementById('formLogin');
  var formSignup = document.getElementById('formSignup');

  // Switch between Login and Signup tabs
  window.switchAuthTab = function (mode) {
    if (mode === 'signup') {
      if (tabSignup) tabSignup.classList.add('active');
      if (tabLogin) tabLogin.classList.remove('active');
      if (formSignup) formSignup.style.display = 'block';
      if (formLogin) formLogin.style.display = 'none';
      if (window.history && window.history.replaceState) {
        window.history.replaceState(null, '', '/signup');
      }
    } else {
      if (tabLogin) tabLogin.classList.add('active');
      if (tabSignup) tabSignup.classList.remove('active');
      if (formLogin) formLogin.style.display = 'block';
      if (formSignup) formSignup.style.display = 'none';
      if (window.history && window.history.replaceState) {
        window.history.replaceState(null, '', '/login');
      }
    }
  };

  if (tabLogin) {
    tabLogin.addEventListener('click', function (e) {
      e.preventDefault();
      window.switchAuthTab('login');
    });
  }

  if (tabSignup) {
    tabSignup.addEventListener('click', function (e) {
      e.preventDefault();
      window.switchAuthTab('signup');
    });
  }

  // Role Card Selection on Signup Form
  var roleCards = document.querySelectorAll('.auth-role-card');
  var hiddenRoleInput = document.getElementById('signup_role');
  roleCards.forEach(function (card) {
    card.addEventListener('click', function () {
      roleCards.forEach(function (c) { c.classList.remove('active'); });
      card.classList.add('active');
      if (hiddenRoleInput) {
        hiddenRoleInput.value = card.getAttribute('data-role');
      }
    });
  });

  // Password Visibility Toggle Helpers
  document.querySelectorAll('.input-password-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var targetId = btn.getAttribute('data-target');
      var input = document.getElementById(targetId);
      if (!input) return;

      var isPassword = input.getAttribute('type') === 'password';
      input.setAttribute('type', isPassword ? 'text' : 'password');
      btn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');

      // Update toggle icon
      btn.innerHTML = isPassword
        ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>'
        : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
    });
  });

  // UI Error & Success Helpers
  function setFieldError(fieldId, errorMsg) {
    var input = document.getElementById(fieldId);
    var errEl = document.getElementById(fieldId + '_error');
    var succEl = document.getElementById(fieldId + '_success');

    if (input) {
      input.classList.remove('is-valid');
      input.classList.add('is-invalid');
      input.setAttribute('aria-invalid', 'true');
    }
    if (succEl) {
      succEl.classList.remove('active');
    }
    if (errEl) {
      errEl.textContent = errorMsg;
      errEl.classList.add('active');
    }
  }

  function setFieldSuccess(fieldId, successMsg) {
    var input = document.getElementById(fieldId);
    var errEl = document.getElementById(fieldId + '_error');
    var succEl = document.getElementById(fieldId + '_success');

    if (input) {
      input.classList.remove('is-invalid');
      input.classList.add('is-valid');
      input.setAttribute('aria-invalid', 'false');
    }
    if (errEl) {
      errEl.classList.remove('active');
    }
    if (succEl) {
      succEl.textContent = successMsg || 'Looks good!';
      succEl.classList.add('active');
    }
  }

  // Password Strength Calculator
  function calculatePasswordStrength(pass) {
    var score = 0;
    if (pass.length >= 8) score++;
    if (/[A-Z]/.test(pass)) score++;
    if (/\d/.test(pass)) score++;
    if (/[@$!%*?&#]/.test(pass)) score++;
    return score;
  }

  var signupPass = document.getElementById('signup_password');
  var meterFill = document.getElementById('password_meter_fill');
  var meterText = document.getElementById('password_meter_text');

  if (signupPass && meterFill) {
    signupPass.addEventListener('input', function () {
      var val = signupPass.value;
      if (!val) {
        meterFill.className = 'password-meter-fill';
        if (meterText) meterText.textContent = '';
        return;
      }
      var score = calculatePasswordStrength(val);
      meterFill.className = 'password-meter-fill';
      if (score <= 1) {
        meterFill.classList.add('weak');
        if (meterText) {
          meterText.textContent = 'Weak: Add uppercase, number & symbol';
          meterText.style.color = '#ef4444';
        }
      } else if (score <= 3) {
        meterFill.classList.add('medium');
        if (meterText) {
          meterText.textContent = 'Fair: Almost there';
          meterText.style.color = '#f59e0b';
        }
      } else {
        meterFill.classList.add('strong');
        if (meterText) {
          meterText.textContent = 'Strong password ✓';
          meterText.style.color = '#16a34a';
        }
      }

      var confirmPass = document.getElementById('signup_confirm_password');
      if (confirmPass && confirmPass.value) {
        validateConfirmPassword();
      }
    });
  }

  // Cross-Field Match Validation
  function validateConfirmPassword() {
    var p1 = document.getElementById('signup_password');
    var p2 = document.getElementById('signup_confirm_password');
    if (!p1 || !p2) return false;

    var val1 = p1.value;
    var val2 = p2.value;

    if (!val2) {
      setFieldError('signup_confirm_password', 'Please confirm your password.');
      return false;
    }
    if (val1 !== val2) {
      setFieldError('signup_confirm_password', 'Passwords do not match.');
      return false;
    }

    setFieldSuccess('signup_confirm_password', 'Passwords match ✓');
    return true;
  }

  var confirmPassInput = document.getElementById('signup_confirm_password');
  if (confirmPassInput) {
    confirmPassInput.addEventListener('input', validateConfirmPassword);
    confirmPassInput.addEventListener('blur', validateConfirmPassword);
  }

  // Field-Level Validations for Sign Up
  function validateName() {
    var el = document.getElementById('signup_name');
    if (!el) return false;
    var val = el.value.trim();

    // 1. Required
    if (!val) {
      setFieldError('signup_name', 'Full name is required.');
      return false;
    }
    // 2. Min/Max Length
    if (val.length < 3) {
      setFieldError('signup_name', 'Full name must be at least 3 characters.');
      return false;
    }
    if (val.length > 50) {
      setFieldError('signup_name', 'Full name cannot exceed 50 characters.');
      return false;
    }
    // 4. Pattern (Regex)
    if (!PATTERNS.name.test(val)) {
      setFieldError('signup_name', 'Name can only contain letters, spaces, and dots.');
      return false;
    }

    setFieldSuccess('signup_name', 'Looks good!');
    return true;
  }

  function validateEmail() {
    var el = document.getElementById('signup_email');
    if (!el) return false;
    var val = el.value.trim();

    // 1. Required
    if (!val) {
      setFieldError('signup_email', 'Email address is required.');
      return false;
    }
    // 3. Data Type & 4. Pattern
    if (!PATTERNS.email.test(val)) {
      setFieldError('signup_email', 'Please enter a valid email address (e.g. name@example.com).');
      return false;
    }

    setFieldSuccess('signup_email', 'Valid email format ✓');
    return true;
  }

  function validatePhone() {
    var el = document.getElementById('signup_phone');
    if (!el) return false;
    var val = el.value.trim().replace(/\s+/g, '');

    // 1. Required
    if (!val) {
      setFieldError('signup_phone', 'Phone number is required.');
      return false;
    }
    // 2. Min/Max Length (Indian mobile)
    if (val.length < 10 || val.length > 14) {
      setFieldError('signup_phone', 'Phone number must be 10 digits (excluding +91).');
      return false;
    }
    // 4. Pattern (Regex)
    if (!PATTERNS.phone.test(val)) {
      setFieldError('signup_phone', 'Please enter a valid Indian mobile number starting with 6, 7, 8, or 9.');
      return false;
    }

    setFieldSuccess('signup_phone', 'Valid phone number ✓');
    return true;
  }

  function validatePassword() {
    var el = document.getElementById('signup_password');
    if (!el) return false;
    var val = el.value;

    // 1. Required
    if (!val) {
      setFieldError('signup_password', 'Password is required.');
      return false;
    }
    // 2. Min/Max Length
    if (val.length < 8) {
      setFieldError('signup_password', 'Password must be at least 8 characters long.');
      return false;
    }
    if (val.length > 64) {
      setFieldError('signup_password', 'Password cannot exceed 64 characters.');
      return false;
    }
    // 4. Pattern (Regex)
    if (!PATTERNS.password.test(val)) {
      setFieldError('signup_password', 'Must contain at least 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special symbol (@$!%*?&#).');
      return false;
    }

    setFieldSuccess('signup_password', 'Secure password ✓');
    return true;
  }

  function validateTerms() {
    var el = document.getElementById('signup_terms');
    var errEl = document.getElementById('signup_terms_error');
    if (!el) return true;

    if (!el.checked) {
      if (errEl) {
        errEl.textContent = 'You must agree to the Terms of Service and Privacy Policy to continue.';
        errEl.classList.add('active');
      }
      return false;
    }
    if (errEl) errEl.classList.remove('active');
    return true;
  }

  // Attach real-time blur/input event listeners on Sign Up inputs
  var nameInp = document.getElementById('signup_name');
  if (nameInp) {
    nameInp.addEventListener('blur', validateName);
    nameInp.addEventListener('input', function () {
      if (nameInp.classList.contains('is-invalid')) validateName();
    });
  }

  var emailInp = document.getElementById('signup_email');
  if (emailInp) {
    emailInp.addEventListener('blur', validateEmail);
    emailInp.addEventListener('input', function () {
      if (emailInp.classList.contains('is-invalid')) validateEmail();
    });
  }

  var phoneInp = document.getElementById('signup_phone');
  if (phoneInp) {
    phoneInp.addEventListener('blur', validatePhone);
    phoneInp.addEventListener('input', function () {
      if (phoneInp.classList.contains('is-invalid')) validatePhone();
    });
  }

  if (signupPass) {
    signupPass.addEventListener('blur', validatePassword);
    signupPass.addEventListener('input', function () {
      if (signupPass.classList.contains('is-invalid')) validatePassword();
    });
  }

  var termsInp = document.getElementById('signup_terms');
  if (termsInp) {
    termsInp.addEventListener('change', validateTerms);
  }

  // Sign Up Form Submission
  if (formSignup) {
    formSignup.addEventListener('submit', function (e) {
      e.preventDefault();

      var isNameValid = validateName();
      var isEmailValid = validateEmail();
      var isPhoneValid = validatePhone();
      var isPassValid = validatePassword();
      var isConfirmValid = validateConfirmPassword();
      var isTermsValid = validateTerms();

      var allValid = isNameValid && isEmailValid && isPhoneValid && isPassValid && isConfirmValid && isTermsValid;

      var statusAlert = document.getElementById('signup_status');
      if (!allValid) {
        if (statusAlert) {
          statusAlert.style.display = 'block';
          statusAlert.style.background = '#fef2f2';
          statusAlert.style.color = '#b91c1c';
          statusAlert.style.border = '1px solid #fecaca';
          statusAlert.innerHTML = '<strong>Please fix the highlighted errors</strong> before creating your account.';
        }
        var firstInvalid = formSignup.querySelector('.is-invalid');
        if (firstInvalid) firstInvalid.focus();
        return;
      }

      var submitBtn = formSignup.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Creating Account…';
      }

      // Submit to backend signup endpoint
      fetch('/api/auth/signup', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          name: nameInp.value.trim(),
          email: emailInp.value.trim(),
          phone: phoneInp.value.trim(),
          role: (hiddenRoleInput ? hiddenRoleInput.value : 'seeker'),
          city: (document.getElementById('signup_city') ? document.getElementById('signup_city').value : 'Delhi NCR'),
          password: signupPass.value
        })
      })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (res.success) {
          if (statusAlert) {
            statusAlert.style.display = 'block';
            statusAlert.style.background = '#f0fdf4';
            statusAlert.style.color = '#15803d';
            statusAlert.style.border = '1px solid #bbf7d0';
            statusAlert.innerHTML = '<strong>Welcome to Homeosphere!</strong> ' + (res.message || 'Account created successfully.') + ' Redirecting…';
          }
          setTimeout(function () {
            window.location.href = res.redirect || '/dashboard?welcome=1';
          }, 800);
        } else {
          throw new Error(res.error || 'Registration failed');
        }
      })
      .catch(function (err) {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = 'Create Free Account ➔';
        }
        if (statusAlert) {
          statusAlert.style.display = 'block';
          statusAlert.style.background = '#fef2f2';
          statusAlert.style.color = '#b91c1c';
          statusAlert.style.border = '1px solid #fecaca';
          statusAlert.textContent = err.message || 'Registration failed. Please try again.';
        }
      });
    });
  }

  // Sign In Form Validation & Submission
  function validateLoginIdentifier() {
    var el = document.getElementById('login_identifier');
    if (!el) return false;
    var val = el.value.trim();

    if (!val) {
      setFieldError('login_identifier', 'Please enter your email address or mobile number.');
      return false;
    }
    var isEmail = PATTERNS.email.test(val);
    var isPhone = PATTERNS.phone.test(val.replace(/\s+/g, ''));

    if (!isEmail && !isPhone) {
      setFieldError('login_identifier', 'Please enter a valid email address or 10-digit mobile number.');
      return false;
    }

    setFieldSuccess('login_identifier', 'Valid login format ✓');
    return true;
  }

  function validateLoginPassword() {
    var el = document.getElementById('login_password');
    if (!el) return false;
    var val = el.value;

    if (!val) {
      setFieldError('login_password', 'Password is required.');
      return false;
    }
    if (val.length < 6) {
      setFieldError('login_password', 'Password must be at least 6 characters.');
      return false;
    }

    setFieldSuccess('login_password', '');
    return true;
  }

  var loginIdInp = document.getElementById('login_identifier');
  if (loginIdInp) {
    loginIdInp.addEventListener('blur', validateLoginIdentifier);
    loginIdInp.addEventListener('input', function () {
      if (loginIdInp.classList.contains('is-invalid')) validateLoginIdentifier();
    });
  }

  var loginPassInp = document.getElementById('login_password');
  if (loginPassInp) {
    loginPassInp.addEventListener('blur', validateLoginPassword);
    loginPassInp.addEventListener('input', function () {
      if (loginPassInp.classList.contains('is-invalid')) validateLoginPassword();
    });
  }

  if (formLogin) {
    formLogin.addEventListener('submit', function (e) {
      e.preventDefault();

      var isIdValid = validateLoginIdentifier();
      var isPassValid = validateLoginPassword();

      var statusAlert = document.getElementById('login_status');
      if (!isIdValid || !isPassValid) {
        if (statusAlert) {
          statusAlert.style.display = 'block';
          statusAlert.style.background = '#fef2f2';
          statusAlert.style.color = '#b91c1c';
          statusAlert.style.border = '1px solid #fecaca';
          statusAlert.innerHTML = 'Please check your login details and try again.';
        }
        var firstInvalid = formLogin.querySelector('.is-invalid');
        if (firstInvalid) firstInvalid.focus();
        return;
      }

      var submitBtn = formLogin.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Signing In…';
      }

      // Submit to backend login endpoint
      fetch('/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          identifier: loginIdInp.value.trim(),
          password: loginPassInp.value
        })
      })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (res.success) {
          if (statusAlert) {
            statusAlert.style.display = 'block';
            statusAlert.style.background = '#f0fdf4';
            statusAlert.style.color = '#15803d';
            statusAlert.style.border = '1px solid #bbf7d0';
            statusAlert.innerHTML = '<strong>Welcome back!</strong> ' + (res.message || 'Signing in…') + ' Redirecting…';
          }
          setTimeout(function () {
            window.location.href = res.redirect || '/dashboard';
          }, 800);
        } else {
          throw new Error(res.error || 'Login failed');
        }
      })
      .catch(function (err) {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = 'Sign In to Homeosphere ➔';
        }
        if (statusAlert) {
          statusAlert.style.display = 'block';
          statusAlert.style.background = '#fef2f2';
          statusAlert.style.color = '#b91c1c';
          statusAlert.style.border = '1px solid #fecaca';
          statusAlert.textContent = err.message || 'Invalid login details.';
        }
      });
    });
  }
})();
