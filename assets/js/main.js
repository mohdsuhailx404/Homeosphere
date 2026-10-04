/* Homeosphere — front-end interactions */
(function () {
  'use strict';

  // Sticky header state on scroll
  var siteHeader = document.querySelector('.site-header');
  if (siteHeader) {
    var checkHeaderScroll = function () {
      if (window.scrollY > 20) {
        siteHeader.classList.add('scrolled');
      } else {
        siteHeader.classList.remove('scrolled');
      }
    };
    window.addEventListener('scroll', checkHeaderScroll, { passive: true });
    checkHeaderScroll();
  }

  // Mobile drawer navigation (instant viewport overlay)
  var toggle = document.querySelector('.nav-toggle');
  var drawer = document.getElementById('mobileMenu');
  var closeBtn = document.getElementById('mobileDrawerClose');
  var backdrop = document.getElementById('mobileDrawerBackdrop');

  function openDrawer() {
    if (!drawer) return;
    drawer.classList.add('open');
    drawer.setAttribute('aria-hidden', 'false');
    if (toggle) toggle.setAttribute('aria-expanded', 'true');
    document.body.classList.add('drawer-open');
  }

  function closeDrawer() {
    if (!drawer) return;
    drawer.classList.remove('open');
    drawer.setAttribute('aria-hidden', 'true');
    if (toggle) toggle.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('drawer-open');
  }

  if (toggle && drawer) {
    toggle.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      if (drawer.classList.contains('open')) {
        closeDrawer();
      } else {
        openDrawer();
      }
    });

    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (backdrop) backdrop.addEventListener('click', closeDrawer);

    drawer.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', closeDrawer);
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && drawer.classList.contains('open')) {
        closeDrawer();
      }
    });
  }

  // Header Navigation Dropdown (click & keyboard accessibility)
  var navDropdown = document.querySelector('.nav-dropdown');
  var navToggleBtn = document.querySelector('.nav-dropdown-toggle');
  if (navDropdown && navToggleBtn) {
    navToggleBtn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var isOpen = navDropdown.classList.toggle('open');
      navToggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', function (e) {
      if (!navDropdown.contains(e.target)) {
        navDropdown.classList.remove('open');
        navToggleBtn.setAttribute('aria-expanded', 'false');
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        navDropdown.classList.remove('open');
        navToggleBtn.setAttribute('aria-expanded', 'false');
      }
    });
  }
  // Mobile Property Filters Toggle
  var filterToggleBtn = document.getElementById('mobileFilterToggle');
  var filtersCard = document.getElementById('propFiltersCard');
  if (filterToggleBtn && filtersCard) {
    filterToggleBtn.addEventListener('click', function () {
      var isOpen = filtersCard.classList.toggle('is-open');
      var indicator = document.getElementById('mobileFilterIndicator');
      if (indicator) {
        indicator.textContent = isOpen ? 'Hide filters ▴' : 'Tap to toggle ▾';
      }
    });
  }

  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) {
          en.target.classList.add('is-visible');
          io.unobserve(en.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
    document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
  } else {
    document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('is-visible'); });
  }

  // Interactive FAQ Hover & Accordion
  function initFaqCards() {
    var cards = document.querySelectorAll('.faq-card');
    cards.forEach(function (card) {
      var header = card.querySelector('.faq-card-header');
      var wrapper = card.querySelector('.faq-card-a-wrapper');

      // Mouse hover open
      card.addEventListener('mouseenter', function () {
        card.classList.add('is-open');
        if (header) header.setAttribute('aria-expanded', 'true');
        if (wrapper) wrapper.setAttribute('aria-hidden', 'false');
      });

      // Mouse leave close
      card.addEventListener('mouseleave', function () {
        card.classList.remove('is-open');
        if (header) header.setAttribute('aria-expanded', 'false');
        if (wrapper) wrapper.setAttribute('aria-hidden', 'true');
      });

      // Click / Touch toggle (for mobile and touchscreens)
      if (header) {
        header.addEventListener('click', function (e) {
          e.preventDefault();
          var isOpen = card.classList.contains('is-open');
          if (isOpen) {
            card.classList.remove('is-open');
            header.setAttribute('aria-expanded', 'false');
            if (wrapper) wrapper.setAttribute('aria-hidden', 'true');
          } else {
            // Close other open cards in the same group
            var group = card.closest('.faq-accordion-group');
            if (group) {
              group.querySelectorAll('.faq-card.is-open').forEach(function (other) {
                if (other !== card) {
                  other.classList.remove('is-open');
                  var oh = other.querySelector('.faq-card-header');
                  var ow = other.querySelector('.faq-card-a-wrapper');
                  if (oh) oh.setAttribute('aria-expanded', 'false');
                  if (ow) ow.setAttribute('aria-hidden', 'true');
                }
              });
            }
            card.classList.add('is-open');
            header.setAttribute('aria-expanded', 'true');
            if (wrapper) wrapper.setAttribute('aria-hidden', 'false');
          }
        });

        // Accessible keyboard support
        header.addEventListener('keydown', function (e) {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            header.click();
          }
        });
      }
    });

    // Legacy fallback for any .faq-item
    document.querySelectorAll('.faq-item').forEach(function (item) {
      var q = item.querySelector('.faq-q');
      var a = item.querySelector('.faq-a');
      if (!q || !a) return;
      q.addEventListener('click', function () {
        var isOpen = item.classList.contains('open');
        item.parentNode.querySelectorAll('.faq-item.open').forEach(function (other) {
          if (other !== item) {
            other.classList.remove('open');
            var oa = other.querySelector('.faq-a');
            if (oa) oa.style.maxHeight = '0px';
          }
        });
        if (isOpen) {
          item.classList.remove('open');
          a.style.maxHeight = '0px';
        } else {
          item.classList.add('open');
          a.style.maxHeight = a.scrollHeight + 'px';
        }
      });
    });
  }
  initFaqCards();

  // Dashboard sidebar nav (visual only)
  document.querySelectorAll('.dash-nav-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      btn.parentNode.querySelectorAll('.dash-nav-btn.active').forEach(function (a) { a.classList.remove('active'); });
      btn.classList.add('active');
    });
  });

  // Contact form: submit to /api/contact (Supabase-backed handler)
  var form = document.querySelector('form[data-contact]');
  if (form) {
    var reqSelect = form.querySelector('#requirement');
    var msgTextarea = form.querySelector('#message');

    var reqPreFills = {
      'Buy a property': "Hi, I am looking to buy a property. Please help me explore verified homes matching my preferred city, budget, and configuration.",
      'Rent a property': "Hi, I am looking to rent a home. Please connect me with verified rental listings and schedule property viewings.",
      'List my property': "Hi, I would like to list my property on Homeosphere for sale / rent. Please contact me with details on the listing process, verification, and onboarding.",
      'Property Listing Support': "Hi, I would like to report an issue / inaccurate information regarding a property listing on Homeosphere. Here is the property listing URL/ID and details of the issue:",
      'Book a home service': "Hi, I would like to book a home service. Here are the service requirements, preferred date, and my location:",
      'Contact a pro': "Hi, I would like to connect with a verified professional for my home project. Please help match me with available specialists in my area.",
      'Post a job': "Hi, I have a project/job requirement that I would like to post for verified professionals. Here are the job details, scope, and timeline:",
      'Property management': "Hi, I am interested in Homeosphere's property management services. Please share more information on packages, tenant management, and features.",
      'Join as a professional': "Hi, I am a skilled professional / service agency interested in joining the Homeosphere platform. Please share details on onboarding, partner benefits, and verification.",
      'Partnership / press': "Hi, I would like to discuss a strategic partnership, media inquiry, or corporate collaboration with Homeosphere. Here are the details:",
      'Query': "Hi, I have a query regarding Homeosphere and its services. Could you please assist me with the following:",
      'Others': "Hi, I have a request not covered in the standard options. Here are the details:"
    };

    if (window.customReqPreFills && typeof window.customReqPreFills === 'object') {
      for (var k in window.customReqPreFills) {
        if (window.customReqPreFills.hasOwnProperty(k)) {
          reqPreFills[k] = window.customReqPreFills[k];
        }
      }
    }

    if (reqSelect && msgTextarea) {
      if (!msgTextarea.value.trim() && reqPreFills[reqSelect.value]) {
        msgTextarea.value = reqPreFills[reqSelect.value];
      }

      reqSelect.addEventListener('change', function () {
        var selected = reqSelect.value;
        if (reqPreFills[selected]) {
          msgTextarea.value = reqPreFills[selected];
          msgTextarea.style.transition = 'box-shadow 0.25s ease, border-color 0.25s ease';
          msgTextarea.style.borderColor = 'var(--gold-400, #d4a017)';
          msgTextarea.style.boxShadow = '0 0 0 3px rgba(212, 160, 23, 0.2)';
          setTimeout(function() {
            msgTextarea.style.borderColor = '';
            msgTextarea.style.boxShadow = '';
          }, 450);
        }
      });
    }

    var status = form.querySelector('.form-status');
    var nameInp = form.querySelector('#name');
    var emailInp = form.querySelector('#email');
    var phoneInp = form.querySelector('#phone');
    var reqInp = form.querySelector('#requirement');
    var msgInp = form.querySelector('#message');

    var nameErr = form.querySelector('#name_error');
    var emailErr = form.querySelector('#email_error');
    var phoneErr = form.querySelector('#phone_error');
    var reqErr = form.querySelector('#requirement_error');
    var msgErr = form.querySelector('#message_error');

    function validateContactName() {
      if (!nameInp) return true;
      var val = (nameInp.value || '').trim();
      if (!val) {
        nameInp.classList.remove('is-valid');
        nameInp.classList.add('is-invalid');
        if (nameErr) { nameErr.textContent = 'Please enter your full name.'; nameErr.classList.add('active'); }
        return false;
      }
      if (val.length < 3) {
        nameInp.classList.remove('is-valid');
        nameInp.classList.add('is-invalid');
        if (nameErr) { nameErr.textContent = 'Full name must be at least 3 characters.'; nameErr.classList.add('active'); }
        return false;
      }
      if (!/^[a-zA-Z\s\.\']{3,50}$/.test(val)) {
        nameInp.classList.remove('is-valid');
        nameInp.classList.add('is-invalid');
        if (nameErr) { nameErr.textContent = 'Name can only contain letters, spaces, and dots.'; nameErr.classList.add('active'); }
        return false;
      }
      nameInp.classList.remove('is-invalid');
      nameInp.classList.add('is-valid');
      if (nameErr) nameErr.classList.remove('active');
      return true;
    }

    function validateContactEmail() {
      if (!emailInp) return true;
      var val = (emailInp.value || '').trim();
      if (!val) {
        emailInp.classList.remove('is-valid');
        emailInp.classList.add('is-invalid');
        if (emailErr) { emailErr.textContent = 'Email address is required.'; emailErr.classList.add('active'); }
        return false;
      }
      if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(val)) {
        emailInp.classList.remove('is-valid');
        emailInp.classList.add('is-invalid');
        if (emailErr) { emailErr.textContent = 'Please enter a valid email address (e.g. you@example.com).'; emailErr.classList.add('active'); }
        return false;
      }
      emailInp.classList.remove('is-invalid');
      emailInp.classList.add('is-valid');
      if (emailErr) emailErr.classList.remove('active');
      return true;
    }

    function validateContactPhone() {
      if (!phoneInp) return true;
      var val = (phoneInp.value || '').trim().replace(/\s+/g, '');
      if (!val) {
        phoneInp.classList.remove('is-valid');
        phoneInp.classList.add('is-invalid');
        if (phoneErr) { phoneErr.textContent = 'Phone number is required.'; phoneErr.classList.add('active'); }
        return false;
      }
      if (!/^(?:\+91[\s-]?)?[6-9]\d{9}$/.test(val)) {
        phoneInp.classList.remove('is-valid');
        phoneInp.classList.add('is-invalid');
        if (phoneErr) { phoneErr.textContent = 'Please enter a valid 10-digit Indian mobile number.'; phoneErr.classList.add('active'); }
        return false;
      }
      phoneInp.classList.remove('is-invalid');
      phoneInp.classList.add('is-valid');
      if (phoneErr) phoneErr.classList.remove('active');
      return true;
    }

    function validateContactMessage() {
      if (!msgInp) return true;
      var val = (msgInp.value || '').trim();
      if (!val) {
        msgInp.classList.remove('is-valid');
        msgInp.classList.add('is-invalid');
        if (msgErr) { msgErr.textContent = 'Message is required.'; msgErr.classList.add('active'); }
        return false;
      }
      if (val.length < 15) {
        msgInp.classList.remove('is-valid');
        msgInp.classList.add('is-invalid');
        if (msgErr) { msgErr.textContent = 'Message must be at least 15 characters long.'; msgErr.classList.add('active'); }
        return false;
      }
      msgInp.classList.remove('is-invalid');
      msgInp.classList.add('is-valid');
      if (msgErr) msgErr.classList.remove('active');
      return true;
    }

    if (nameInp) {
      nameInp.addEventListener('blur', validateContactName);
      nameInp.addEventListener('input', function() { if (nameInp.classList.contains('is-invalid')) validateContactName(); });
    }
    if (emailInp) {
      emailInp.addEventListener('blur', validateContactEmail);
      emailInp.addEventListener('input', function() { if (emailInp.classList.contains('is-invalid')) validateContactEmail(); });
    }
    if (phoneInp) {
      phoneInp.addEventListener('blur', validateContactPhone);
      phoneInp.addEventListener('input', function() { if (phoneInp.classList.contains('is-invalid')) validateContactPhone(); });
    }
    if (msgInp) {
      msgInp.addEventListener('blur', validateContactMessage);
      msgInp.addEventListener('input', function() { if (msgInp.classList.contains('is-invalid')) validateContactMessage(); });
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var isNameOk = validateContactName();
      var isEmailOk = validateContactEmail();
      var isPhoneOk = validateContactPhone();
      var isMsgOk = validateContactMessage();

      if (!isNameOk || !isEmailOk || !isPhoneOk || !isMsgOk) {
        if (status) {
          status.textContent = 'Please fix the errors highlighted above before submitting.';
          status.style.color = '#d23b3b';
          status.style.background = '#fdeaea';
          status.style.padding = '0.75rem 1rem';
        }
        var firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) firstInvalid.focus();
        return;
      }

      var fd = new FormData(form);
      var payload = {
        name: (fd.get('name') || '').toString().trim(),
        email: (fd.get('email') || '').toString().trim(),
        phone: (fd.get('phone') || '').toString().trim(),
        requirement: (fd.get('requirement') || '').toString().trim(),
        message: (fd.get('message') || '').toString().trim(),
      };
      status.textContent = 'Sending your message…';
      status.style.color = '#15294f';
      status.style.background = 'var(--navy-50)';
      fetch('/api/contact', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      })
        .then(function (r) { return r.json().then(function (b) { return { ok: r.ok, body: b }; }); })
        .then(function (res) {
          if (res.ok && res.body && res.body.success) {
            status.innerHTML = '<span style="display:inline-flex;align-items:center;gap:.375rem">✓ Thank you! Your message has been received. Our team will respond within one business day.</span>';
            status.style.color = '#0a6349';
            status.style.background = 'var(--gold-100)';
            form.reset();
          } else {
            throw new Error((res.body && res.body.error) || 'Request failed');
          }
        })
        .catch(function () {
          status.textContent = 'Sorry, something went wrong. Please try again or email hello@homeosphere.com directly.';
          status.style.color = '#d23b3b';
          status.style.background = '#fdeaea';
        });
    });
  }

  // --- HERO FUNCTIONAL SEARCH CONTROLLER ---
  (function initHeroSearch() {
    var searchForm = document.getElementById('heroSearchForm');
    var searchInput = document.getElementById('heroSearchInput');
    var suggestionsBox = document.getElementById('heroSuggestions');
    var clearBtn = document.getElementById('heroClearSearchBtn');
    var listingInput = document.getElementById('heroListingType');
    var searchBtnText = document.getElementById('heroSearchBtnText');
    var tabsWrap = document.querySelector('.search-tabs');

    if (!searchForm || !searchInput) return;

    var currentTab = 'Buy Property';
    var debounceTimer = null;
    var activeIndex = -1;

    var TAB_CONFIG = {
      'Buy Property': {
        action: '/properties',
        listing: 'Buy',
        placeholder: 'Search buy property — city, locality, or 2/3 BHK…',
        btnText: 'Explore Properties',
        apiType: 'buy'
      },
      'Rent Property': {
        action: '/properties',
        listing: 'Rent',
        placeholder: 'Search rental homes — city, locality, or BHK…',
        btnText: 'Explore Rentals',
        apiType: 'rent'
      },
      'Home Services': {
        action: '/services',
        listing: '',
        placeholder: 'Search home services — AC, cleaning, painting, plumbing…',
        btnText: 'Search Services',
        apiType: 'service'
      },
      'Hire Professionals': {
        action: '/professionals',
        listing: '',
        placeholder: 'Search verified pros — architect, designer, electrician…',
        btnText: 'Search Professionals',
        apiType: 'professional'
      }
    };

    function applyTab(tabName) {
      currentTab = tabName;
      var conf = TAB_CONFIG[tabName] || TAB_CONFIG['Buy Property'];
      searchForm.action = conf.action;
      if (listingInput) {
        listingInput.value = conf.listing;
        listingInput.disabled = !conf.listing;
      }
      searchInput.placeholder = conf.placeholder;
      if (searchBtnText) searchBtnText.textContent = conf.btnText;
      if (searchInput.value.trim().length >= 1) {
        fetchSuggestions(searchInput.value.trim());
      }
    }

    if (tabsWrap) {
      tabsWrap.addEventListener('click', function (e) {
        var t = e.target.closest('.search-tab');
        if (!t) return;
        tabsWrap.querySelectorAll('.search-tab').forEach(function (x) { x.classList.remove('active', 'on'); });
        t.classList.add('active', 'on');
        var tabName = t.dataset.tab || t.textContent.trim();
        applyTab(tabName);
      });
    }

    function highlightText(text, q) {
      if (!text || !q) return escapePropHtml(text);
      var esc = escapePropHtml(text);
      var reg = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
      return esc.replace(reg, '<span class="search-highlight">$1</span>');
    }

    function renderSuggestions(data, query) {
      if (!suggestionsBox) return;
      var conf = TAB_CONFIG[currentTab] || TAB_CONFIG['Buy Property'];
      var hasProps = data.properties && data.properties.length > 0;
      var hasServices = data.services && data.services.length > 0;
      var hasPros = data.professionals && data.professionals.length > 0;
      var hasCities = data.cities && data.cities.length > 0;

      if (!hasProps && !hasServices && !hasPros && !hasCities) {
        suggestionsBox.innerHTML = 
          '<div style="padding:1.25rem 1rem;text-align:center;color:var(--navy-500);font-size:0.85rem;">' +
            'No direct matches found for "<b>' + escapePropHtml(query) + '</b>".' +
            '<div style="margin-top:0.4rem;font-size:0.75rem;color:var(--navy-400);">Press Enter to search all listings.</div>' +
          '</div>';
        suggestionsBox.style.display = 'block';
        return;
      }

      var html = '';

      // Properties section
      if (hasProps) {
        html += '<div class="search-suggestion-group-title"><span style="display:inline-flex;align-items:center;gap:0.45rem;">' + getPropIcon('home', 14, 'var(--gold-600)') + '<span>Properties</span></span><span>' + data.properties.length + ' found</span></div>';
        data.properties.forEach(function (p) {
          var isRent = p.listing === 'Rent';
          var badgeBg = isRent ? '#0284c7' : '#d4a017';
          html += '<a href="' + escapePropHtml(p.url) + '" class="search-suggestion-item" data-action="navigate">' +
            (p.image ? '<img src="' + escapePropHtml(p.image) + '" class="search-suggestion-thumb" alt="' + escapePropHtml(p.title) + '" loading="lazy">' : '<div class="search-suggestion-icon-wrap">' + getPropIcon('building', 18) + '</div>') +
            '<div class="search-suggestion-body">' +
              '<div class="search-suggestion-title">' + highlightText(p.title, query) + '</div>' +
              '<div class="search-suggestion-meta">' +
                '<span class="search-suggestion-badge" style="background:' + badgeBg + ';color:#fff;">' + escapePropHtml(p.listing) + '</span>' +
                '<span style="display:inline-flex;align-items:center;gap:0.25rem;">' + getPropIcon('map-pin', 12, 'var(--navy-400)') + '<span>' + highlightText(p.location || p.city, query) + '</span></span>' +
                '<span style="font-weight:700;color:var(--gold-600);">' + escapePropHtml(p.priceLabel) + '</span>' +
              '</div>' +
            '</div>' +
          '</a>';
        });
      }

      // Services section
      if (hasServices) {
        html += '<div class="search-suggestion-group-title"><span style="display:inline-flex;align-items:center;gap:0.45rem;">' + getPropIcon('tools', 14, 'var(--gold-600)') + '<span>Home Services</span></span><span>' + data.services.length + ' found</span></div>';
        data.services.forEach(function (s) {
          html += '<a href="' + escapePropHtml(s.url) + '" class="search-suggestion-item" data-action="navigate">' +
            '<div class="search-suggestion-icon-wrap" style="background:var(--gold-100);color:var(--gold-700);">' +
              getPropIcon(s.icon || 'sparkles', 18, 'var(--gold-700)') +
            '</div>' +
            '<div class="search-suggestion-body">' +
              '<div class="search-suggestion-title">' + highlightText(s.name, query) + '</div>' +
              '<div class="search-suggestion-meta">' +
                '<span>Starting from <b>₹' + escapePropHtml(s.start) + '</b></span>' +
                '<span style="display:inline-flex;align-items:center;gap:0.25rem;">' + getPropIcon('star', 12, '#d4a017') + '<span>' + escapePropHtml(s.rating) + '</span></span>' +
              '</div>' +
            '</div>' +
          '</a>';
        });
      }

      // Professionals section
      if (hasPros) {
        html += '<div class="search-suggestion-group-title"><span style="display:inline-flex;align-items:center;gap:0.45rem;">' + getPropIcon('user-check', 14, 'var(--gold-600)') + '<span>Verified Professionals</span></span><span>' + data.professionals.length + ' found</span></div>';
        data.professionals.forEach(function (pr) {
          html += '<a href="' + escapePropHtml(pr.url) + '" class="search-suggestion-item" data-action="navigate">' +
            (pr.avatar ? '<img src="' + escapePropHtml(pr.avatar) + '" class="search-suggestion-avatar" alt="' + escapePropHtml(pr.name) + '">' : '<div class="search-suggestion-icon-wrap">' + getPropIcon('shield-check', 18) + '</div>') +
            '<div class="search-suggestion-body">' +
              '<div class="search-suggestion-title">' + highlightText(pr.name, query) + '</div>' +
              '<div class="search-suggestion-meta">' +
                '<span style="font-weight:600;color:var(--navy-700);">' + highlightText(pr.role, query) + '</span>' +
                '<span style="display:inline-flex;align-items:center;gap:0.25rem;">' + getPropIcon('map-pin', 12, 'var(--navy-400)') + '<span>' + highlightText(pr.location, query) + '</span></span>' +
                '<span style="display:inline-flex;align-items:center;gap:0.25rem;">' + getPropIcon('star', 12, '#d4a017') + '<span>' + escapePropHtml(pr.rating) + '</span></span>' +
              '</div>' +
            '</div>' +
          '</a>';
        });
      }

      // Cities section
      if (hasCities) {
        html += '<div class="search-suggestion-group-title"><span style="display:inline-flex;align-items:center;gap:0.45rem;">' + getPropIcon('map-pin', 14, 'var(--gold-600)') + '<span>Cities &amp; Locations</span></span></div>';
        data.cities.forEach(function (c) {
          html += '<a href="' + escapePropHtml(c.url) + '" class="search-suggestion-item" data-action="navigate">' +
            '<div class="search-suggestion-icon-wrap" style="background:#e0f2fe;color:#0369a1;">' +
              getPropIcon('map-pin', 18, '#0369a1') +
            '</div>' +
            '<div class="search-suggestion-body">' +
              '<div class="search-suggestion-title">' + highlightText(c.name, query) + '</div>' +
              '<div class="search-suggestion-meta"><span>Browse properties in ' + escapePropHtml(c.name) + '</span></div>' +
            '</div>' +
          '</a>';
        });
      }

      // Bottom footer: view all matching in active category
      var submitUrl = conf.action + '?q=' + encodeURIComponent(query) + (conf.listing ? '&listing=' + encodeURIComponent(conf.listing) : '');
      html += '<a href="' + escapePropHtml(submitUrl) + '" class="search-suggestion-footer">' +
        '<span>See all results for "<b>' + escapePropHtml(query) + '</b>" in ' + escapePropHtml(currentTab) + '</span>' +
        '<span style="display:inline-flex;align-items:center;">' + getPropIcon('arrow-right', 14, 'var(--gold-600)') + '</span>' +
      '</a>';

      suggestionsBox.innerHTML = html;
      suggestionsBox.style.display = 'block';
      activeIndex = -1;
    }

    function fetchSuggestions(query) {
      var conf = TAB_CONFIG[currentTab] || TAB_CONFIG['Buy Property'];
      var url = '/api/search-suggest?q=' + encodeURIComponent(query) + '&type=' + encodeURIComponent(conf.apiType);

      fetch(url)
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (searchInput.value.trim() === query) {
            renderSuggestions(data, query);
          }
        })
        .catch(function (err) {
          console.warn('Search suggestion fetch error:', err);
        });
    }

    searchInput.addEventListener('input', function () {
      var val = searchInput.value.trim();
      if (clearBtn) clearBtn.style.display = val.length > 0 ? 'grid' : 'none';

      clearTimeout(debounceTimer);
      if (val.length < 1) {
        if (suggestionsBox) suggestionsBox.style.display = 'none';
        return;
      }
      debounceTimer = setTimeout(function () {
        fetchSuggestions(val);
      }, 150);
    });

    if (clearBtn) {
      clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        clearBtn.style.display = 'none';
        if (suggestionsBox) suggestionsBox.style.display = 'none';
        searchInput.focus();
      });
    }

    // Keyboard navigation in suggestions
    searchInput.addEventListener('keydown', function (e) {
      if (!suggestionsBox || suggestionsBox.style.display === 'none') return;
      var items = suggestionsBox.querySelectorAll('.search-suggestion-item, .search-suggestion-footer');
      if (items.length === 0) return;

      if (e.key === 'ArrowDown') {
        e.preventDefault();
        activeIndex = (activeIndex + 1) % items.length;
        updateActiveSuggestion(items);
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        activeIndex = (activeIndex - 1 + items.length) % items.length;
        updateActiveSuggestion(items);
      } else if (e.key === 'Enter') {
        if (activeIndex >= 0 && items[activeIndex]) {
          e.preventDefault();
          items[activeIndex].click();
        }
      } else if (e.key === 'Escape') {
        suggestionsBox.style.display = 'none';
      }
    });

    function updateActiveSuggestion(items) {
      items.forEach(function (el, idx) {
        el.classList.toggle('selected', idx === activeIndex);
        if (idx === activeIndex) {
          el.scrollIntoView({ block: 'nearest' });
        }
      });
    }

    // Hide dropdown on outside click
    document.addEventListener('click', function (e) {
      if (!searchForm.contains(e.target)) {
        if (suggestionsBox) suggestionsBox.style.display = 'none';
      }
    });

    // Re-open on focus if query present
    searchInput.addEventListener('focus', function () {
      if (searchInput.value.trim().length >= 1 && suggestionsBox && suggestionsBox.innerHTML.trim()) {
        suggestionsBox.style.display = 'block';
      }
    });
  })();

  // Helper for escaping HTML strings
  function escapePropHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"']/g, function(m) {
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m];
    });
  }

  // Theme-consistent SVG vector icon generator
  function getPropIcon(name, size, color) {
    size = size || 16;
    color = color || 'currentColor';
    var paths = {
      'star': '<path d="m12 2 3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z" fill="' + (color === 'currentColor' ? '#d4a017' : color) + '" stroke="' + (color === 'currentColor' ? '#d4a017' : color) + '"/>',
      'home': '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
      'tools': '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
      'user-check': '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>',
      'bed': '<path d="M2 4v16M2 8h18a2 2 0 0 1 2 2v10M2 17h20M6 8V4h6v4"/>',
      'bath': '<path d="M9 6 6.5 3.5a1.5 1.5 0 0 0-1-.5C4.683 3 4 3.683 4 4.5V17a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5M4 12h16M8 19v2M16 19v2"/>',
      'maximize': '<path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3"/>',
      'sofa': '<path d="M20 9V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3"/><path d="M2 11v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v2H6v-2a2 2 0 0 0-4 0z"/><path d="M4 18v2M20 18v2"/>',
      'building': '<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M8 10h.01M16 10h.01M8 14h.01M16 14h.01"/>',
      'clock': '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
      'check-circle': '<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>',
      'map-pin': '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/>',
      'phone': '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.33 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>',
      'calendar': '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
      'shield-check': '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
      'sparkles': '<path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>',
      'wind': '<path d="M17.7 7.7A2.5 2.5 0 1 1 20 10H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/>',
      'zap': '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
      'droplets': '<path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 6.75 7 5.3c-.29 1.45-1.14 2.84-2.29 3.76S3 11.1 3 12.25c0 2.22 1.8 4.05 4 4.05z"/><path d="M12.56 6.6A10.97 10.97 0 0 0 14 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 0 1-11.91 4.97"/>',
      'paintbrush': '<path d="m14 4 6 6-4 4-6-6zM4 20l4-4-2-2-4 4v2h2zM14.5 15.5l-3-3"/>',
      'bug': '<rect width="8" height="14" x="8" y="6" rx="4"/><path d="m19 7-3 2"/><path d="m5 7 3 2"/><path d="m19 19-3-2"/><path d="m5 19 3-2"/><path d="M20 13h-4"/><path d="M4 13h4"/><path d="m10 4 1 2"/><path d="m14 4-1 2"/>',
      'hammer': '<path d="m15 12-8.5 8.5a2.12 2.12 0 0 1-3-3L12 9"/><path d="M17.64 15 22 10.64"/><path d="m20.91 3.26-6.36 6.36a2.5 2.5 0 0 0-.64 2.11L14 13l3 3 1.27-.09a2.5 2.5 0 0 0 2.11-.64l6.36-6.36a1.5 1.5 0 0 0 0-2.12l-3.71-3.71a1.5 1.5 0 0 0-2.12 0z"/>',
      'washing': '<rect width="18" height="20" x="3" y="2" rx="2"/><circle cx="12" cy="13" r="5"/><path d="M12 18a2.5 2.5 0 0 0 0-5 2.5 2.5 0 0 1 0-5"/><circle cx="7.5" cy="5.5" r=".5" fill="currentColor"/><circle cx="10" cy="5.5" r=".5" fill="currentColor"/>',
      'truck': '<rect width="16" height="13" x="1" y="3" rx="2"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
      'shield': '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
      'arrow-right': '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>'
    };
    var body = paths[name] || paths['building'];
    return '<svg xmlns="http://www.w3.org/2000/svg" width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" stroke="' + color + '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;flex-shrink:0;display:inline-block;">' + body + '</svg>';
  }

  // Property Slide-in Details Drawer Controller
  var drawerBackdrop = document.getElementById('propertyDrawerBackdrop');
  var drawerClose = document.getElementById('propDrawerClose');
  var drawerBody = document.getElementById('propDrawerBody');

  function openPropertyDrawer(p) {
    if (!drawerBackdrop || !drawerBody) return;

    var isBuy = (p.listing || '').toLowerCase() === 'buy';
    var actionText = isBuy ? 'Proceed to Buy' : 'Proceed to Rent';
    var actionSubtitle = isBuy ? 'Verified Title &bull; Clear Documentation' : 'Ready to Move &bull; 2 Months Security Deposit';
    var statusBadge = isBuy ? 'Available for Purchase' : 'Available for Rent';
    var gmapsUrl = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent((p.title || '') + ', ' + (p.location || '') + ', ' + (p.city || ''));

    // Parse amenities
    var amenities = p.amenities || [];
    if (typeof amenities === 'string') {
      amenities = amenities.split(',').map(function(s){ return s.trim(); }).filter(Boolean);
    }
    var amenitiesHtml = amenities.map(function(a) {
      return '<span class="pill pill-sand" style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.4rem 0.75rem;font-size:0.8rem;border-radius:9999px;font-weight:600;"><svg style="width:12px;height:12px;stroke:#16a34a;stroke-width:2.5;fill:none;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>' + escapePropHtml(a) + '</span>';
    }).join(' ');

    var overviewText = isBuy
      ? 'This prime residence in ' + escapePropHtml(p.location) + ' features contemporary architecture with ample natural sunlight, well-ventilated living spaces, spacious balconies, and unmatched connectivity to top business hubs, prestigious schools, and transit links.'
      : 'Elegantly appointed home in ' + escapePropHtml(p.location) + ', offering peaceful and secure modern living with high-speed elevator access, 24/7 power backup, CCTV security, and immediate walking distance to markets, cafes, and metro connectivity.';

    var cuName = (window.CURRENT_USER && window.CURRENT_USER.name) ? window.CURRENT_USER.name : '';
    var cuPhone = (window.CURRENT_USER && window.CURRENT_USER.phone) ? window.CURRENT_USER.phone : '';

    drawerBody.innerHTML = `
      <div class="prop-drawer-media">
        <img src="${escapePropHtml(p.image)}" alt="${escapePropHtml(p.title)}" onerror="this.src='/assets/img/properties/prop_mumbai.jpg'">
        <div class="prop-drawer-badges">
          ${p.tag ? `<span class="pill pill-gold" style="font-weight:800;box-shadow:0 2px 8px rgba(0,0,0,0.2);">${escapePropHtml(p.tag)}</span>` : ''}
          <span class="pill glass-dark" style="color:#ffffff;font-weight:700;backdrop-filter:blur(8px);">${isBuy ? 'For Sale' : 'For Rent'}</span>
          ${p.verified ? `<span class="pill pill-navy" style="background:#0b1f3a;color:#ffffff;border:1px solid rgba(212,160,23,0.5);box-shadow:0 2px 8px rgba(0,0,0,0.2);display:inline-flex;align-items:center;gap:0.3rem;">${getPropIcon('shield-check', 13, '#d4a017')} Verified Property</span>` : ''}
        </div>
      </div>

      <div class="prop-drawer-content">
        <!-- Title & Location -->
        <h2 id="propDrawerTitle" style="font-size:1.45rem;font-weight:800;color:var(--navy-900);line-height:1.3;margin:0 0 0.5rem;">${escapePropHtml(p.title)}</h2>
        
        <p style="margin:0 0 1.25rem;font-size:0.875rem;color:var(--navy-600);display:flex;align-items:center;gap:0.4rem;flex-wrap:wrap;">
          ${getPropIcon('map-pin', 16, '#d4a017')}
          <span style="font-weight:600;">${escapePropHtml(p.location)}</span>
          <a href="${gmapsUrl}" target="_blank" rel="noopener noreferrer" style="font-size:0.8rem;color:var(--navy-500);text-decoration:none;display:inline-flex;align-items:center;gap:0.2rem;border-bottom:1px dashed var(--navy-300);" title="Open location in Google Maps">
            <span>View on Map</span>
            <span>↗</span>
          </a>
        </p>

        <!-- Price & Availability Card -->
        <div style="background:var(--sand-50);border:1px solid var(--sand-200);border-radius:1rem;padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;margin-bottom:1.25rem;">
          <div>
            <div style="font-size:0.7rem;font-weight:700;color:var(--navy-400);text-transform:uppercase;letter-spacing:0.04em;">Price</div>
            <div style="font-size:1.6rem;font-weight:800;color:var(--navy-900);line-height:1.1;">${escapePropHtml(p.priceLabel)}</div>
            <div style="font-size:0.75rem;color:var(--navy-500);margin-top:0.2rem;">${actionSubtitle}</div>
          </div>
          <div style="text-align:right;">
            <span style="display:inline-flex;align-items:center;gap:0.35rem;background:#dcfce7;color:#15803d;padding:0.35rem 0.75rem;border-radius:9999px;font-size:0.75rem;font-weight:700;">
              <span style="width:6px;height:6px;border-radius:9999px;background:#16a34a;"></span>
              ${statusBadge}
            </span>
            <div style="font-size:0.75rem;color:var(--navy-500);margin-top:0.35rem;display:flex;align-items:center;justify-content:flex-end;gap:0.3rem;">
              <span>Rating:</span>
              ${getPropIcon('star', 15, '#d4a017')}
              <strong style="color:var(--navy-900);">${escapePropHtml(p.rating || '4.8')}</strong>
              <span style="color:var(--navy-400);">/ 5.0</span>
            </div>
          </div>
        </div>

        <!-- Specifications Grid with Theme-consistent SVG Vectors -->
        <h3 style="font-size:0.875rem;font-weight:700;color:var(--navy-900);margin:1.25rem 0 0.5rem;text-transform:uppercase;letter-spacing:0.04em;">Key Highlights</h3>
        <div class="prop-spec-grid">
          <div class="prop-spec-box">
            <div class="prop-spec-label">Bedrooms</div>
            <div class="prop-spec-val" style="display:flex;align-items:center;justify-content:center;gap:0.4rem;">
              ${getPropIcon('bed', 17, '#0b1f3a')}
              <span>${parseInt(p.beds, 10)} Beds</span>
            </div>
          </div>
          <div class="prop-spec-box">
            <div class="prop-spec-label">Bathrooms</div>
            <div class="prop-spec-val" style="display:flex;align-items:center;justify-content:center;gap:0.4rem;">
              ${getPropIcon('bath', 17, '#0b1f3a')}
              <span>${parseInt(p.baths, 10)} Baths</span>
            </div>
          </div>
          <div class="prop-spec-box">
            <div class="prop-spec-label">Carpet Area</div>
            <div class="prop-spec-val" style="display:flex;align-items:center;justify-content:center;gap:0.4rem;">
              ${getPropIcon('maximize', 17, '#0b1f3a')}
              <span>${parseInt(p.area, 10)} sqft</span>
            </div>
          </div>
          <div class="prop-spec-box">
            <div class="prop-spec-label">Furnishing</div>
            <div class="prop-spec-val" style="display:flex;align-items:center;justify-content:center;gap:0.4rem;">
              ${getPropIcon('sofa', 17, '#0b1f3a')}
              <span>${escapePropHtml(p.furnishing || 'Furnished')}</span>
            </div>
          </div>
          <div class="prop-spec-box">
            <div class="prop-spec-label">Property Type</div>
            <div class="prop-spec-val" style="display:flex;align-items:center;justify-content:center;gap:0.4rem;">
              ${getPropIcon('building', 17, '#0b1f3a')}
              <span>${escapePropHtml(p.type)}</span>
            </div>
          </div>
          <div class="prop-spec-box">
            <div class="prop-spec-label">Possession</div>
            <div class="prop-spec-val" style="display:flex;align-items:center;justify-content:center;gap:0.4rem;">
              ${getPropIcon('clock', 17, '#15803d')}
              <span style="color:#15803d;">Immediate</span>
            </div>
          </div>
        </div>

        <!-- Description -->
        <h3 style="font-size:0.875rem;font-weight:700;color:var(--navy-900);margin:1.5rem 0 0.5rem;text-transform:uppercase;letter-spacing:0.04em;">About This Home</h3>
        <p style="font-size:0.9rem;color:var(--navy-600);line-height:1.6;margin:0 0 1.5rem;">${overviewText}</p>

        <!-- Amenities -->
        <h3 style="font-size:0.875rem;font-weight:700;color:var(--navy-900);margin:1.5rem 0 0.75rem;text-transform:uppercase;letter-spacing:0.04em;">Building &amp; Community Amenities</h3>
        <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.5rem;">
          ${amenitiesHtml}
        </div>

        <!-- Neighborhood & Location -->
        <div style="background:#f8fafc;border:1px dashed var(--sand-300);border-radius:1rem;padding:1.1rem;margin-bottom:1.5rem;">
          <h4 style="font-size:0.875rem;font-weight:700;color:var(--navy-900);margin:0 0 0.4rem;display:flex;align-items:center;gap:0.4rem;">
            ${getPropIcon('map-pin', 16, '#d4a017')}
            <span>Location &amp; Connectivity</span>
          </h4>
          <p style="font-size:0.825rem;color:var(--navy-600);margin:0 0 0.75rem;line-height:1.5;">
            Strategically located in ${escapePropHtml(p.location)} with swift access to commercial hubs, reputed schools, healthcare centers, and transit stations.
          </p>
          <a href="${gmapsUrl}" target="_blank" rel="noopener noreferrer" class="btn btn-sm" style="background:#ffffff;color:var(--navy-900);border:1px solid var(--sand-300);font-weight:700;font-size:0.75rem;padding:0.4rem 0.8rem;border-radius:9999px;text-decoration:none;display:inline-flex;align-items:center;gap:0.35rem;box-shadow:var(--sh-soft);">
            Open in Google Maps ↗
          </a>
        </div>

        <!-- Action Form container (initially hidden, expands on Action click) -->
        <div id="propActionSection" style="display:none;background:var(--navy-50);border:1.5px solid var(--gold-400);border-radius:1.25rem;padding:1.25rem;margin-top:1rem;">
          <h4 id="actionSectionTitle" style="font-size:1.1rem;font-weight:800;color:var(--navy-900);margin:0 0 0.25rem;">Complete Your ${actionText} Request</h4>
          <p style="font-size:0.825rem;color:var(--navy-600);margin:0 0 1rem;">Fill in your contact details below and our property specialist will reach out within 15 minutes.</p>
          <form id="propBookingForm" novalidate onsubmit="return false;">
            <div id="propBookAlert" style="display:none;padding:0.6rem 0.85rem;border-radius:0.5rem;font-size:0.8rem;margin-bottom:0.75rem;background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;"></div>
            <div style="display:grid;gap:0.75rem;">
              <div>
                <label style="display:block;font-size:0.75rem;font-weight:700;color:var(--navy-700);margin-bottom:0.25rem;">Full Name *</label>
                <input type="text" id="propBookName" value="${escapePropHtml(cuName)}" required placeholder="e.g. Rahul Sharma" style="width:100%;padding:0.65rem 0.85rem;border-radius:0.5rem;border:1px solid var(--sand-300);font-size:0.875rem;font-family:inherit;">
                <div class="field-error" id="propBookName_err"></div>
              </div>
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                <div>
                  <label style="display:block;font-size:0.75rem;font-weight:700;color:var(--navy-700);margin-bottom:0.25rem;">Phone Number *</label>
                  <input type="tel" id="propBookPhone" value="${escapePropHtml(cuPhone)}" required placeholder="+91 98765 43210" style="width:100%;padding:0.65rem 0.85rem;border-radius:0.5rem;border:1px solid var(--sand-300);font-size:0.875rem;font-family:inherit;">
                  <div class="field-error" id="propBookPhone_err"></div>
                </div>
                <div>
                  <label style="display:block;font-size:0.75rem;font-weight:700;color:var(--navy-700);margin-bottom:0.25rem;">Preferred Date</label>
                  <input type="date" id="propBookDate" min="${new Date().toISOString().split('T')[0]}" style="width:100%;padding:0.65rem 0.85rem;border-radius:0.5rem;border:1px solid var(--sand-300);font-size:0.875rem;font-family:inherit;">
                  <div class="field-error" id="propBookDate_err"></div>
                </div>
              </div>
              <div>
                <label style="display:block;font-size:0.75rem;font-weight:700;color:var(--navy-700);margin-bottom:0.25rem;">Message or Special Request (Optional)</label>
                <textarea id="propBookMsg" rows="2" maxlength="300" placeholder="I would like to arrange a site visit this week..." style="width:100%;padding:0.65rem 0.85rem;border-radius:0.5rem;border:1px solid var(--sand-300);font-size:0.875rem;font-family:inherit;resize:vertical;"></textarea>
              </div>
              <button type="submit" class="btn btn-gold btn-lg" style="width:100%;font-weight:800;margin-top:0.25rem;">
                Confirm &amp; Submit Request ➔
              </button>
            </div>
          </form>
        </div>

        <!-- Success Message container -->
        <div id="propActionSuccess" style="display:none;background:#ecfdf5;border:1.5px solid #10b981;border-radius:1.25rem;padding:1.5rem;text-align:center;margin-top:1rem;">
          <div style="display:grid;place-items:center;width:3.25rem;height:3.25rem;border-radius:9999px;background:#d1fae5;color:#059669;margin:0 auto 0.75rem;">
            ${getPropIcon('check-circle', 26, '#059669')}
          </div>
          <h4 style="font-size:1.15rem;font-weight:800;color:#065f46;margin:0 0 0.5rem;">Request Registered Successfully!</h4>
          <p style="font-size:0.85rem;color:#047857;margin:0 0 1rem;line-height:1.5;">
            Thank you! Your inquiry for <strong>${escapePropHtml(p.title)}</strong> has been received. Our verified property advisor for <strong>${escapePropHtml(p.city)}</strong> will contact you shortly.
          </p>
          <div style="display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap;">
            <a href="tel:+919000000000" class="btn btn-sm btn-primary" style="text-decoration:none;display:inline-flex;align-items:center;gap:0.35rem;">
              ${getPropIcon('phone', 14, '#ffffff')}
              <span>Call Advisor</span>
            </a>
            <a href="${gmapsUrl}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-ghost" style="text-decoration:none;display:inline-flex;align-items:center;gap:0.35rem;">
              ${getPropIcon('map-pin', 14, 'var(--navy-800)')}
              <span>View on Maps</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Sticky Action Bar at Bottom of Drawer -->
      <div class="prop-drawer-foot">
        <div>
          <div style="font-size:0.7rem;font-weight:700;color:var(--navy-400);text-transform:uppercase;">${isBuy ? 'Total Price' : 'Monthly Rent'}</div>
          <div style="font-size:1.35rem;font-weight:800;color:var(--navy-900);line-height:1;">${escapePropHtml(p.priceLabel)}</div>
        </div>
        <div style="display:flex;gap:0.5rem;">
          <button id="propDrawerActionBtn" type="button" class="btn btn-gold" style="font-weight:800;padding:0.75rem 1.25rem;box-shadow:var(--sh-lift);">
            ${actionText} ➔
          </button>
        </div>
      </div>
    `;

    // Hook up Action Button in Sticky Footer
    var actionBtn = drawerBody.querySelector('#propDrawerActionBtn');
    var actionSection = drawerBody.querySelector('#propActionSection');
    var bookingForm = drawerBody.querySelector('#propBookingForm');
    var actionSuccess = drawerBody.querySelector('#propActionSuccess');

    if (actionBtn && actionSection) {
      actionBtn.addEventListener('click', function() {
        actionSection.style.display = 'block';
        actionBtn.style.display = 'none';
        actionSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        if (cuName && cuPhone) {
          var dateInp = actionSection.querySelector('#propBookDate');
          if (dateInp) dateInp.focus();
        } else {
          var nameInp = actionSection.querySelector('#propBookName');
          if (nameInp) nameInp.focus();
        }
      });
    }

    if (bookingForm && actionSuccess) {
      var nameInp = bookingForm.querySelector('#propBookName');
      var phoneInp = bookingForm.querySelector('#propBookPhone');
      var dateInp = bookingForm.querySelector('#propBookDate');
      var nameErr = bookingForm.querySelector('#propBookName_err');
      var phoneErr = bookingForm.querySelector('#propBookPhone_err');
      var dateErr = bookingForm.querySelector('#propBookDate_err');
      var bookAlert = bookingForm.querySelector('#propBookAlert');

      function validatePropName() {
        var val = (nameInp.value || '').trim();
        if (!val) {
          nameInp.classList.remove('is-valid');
          nameInp.classList.add('is-invalid');
          nameErr.textContent = 'Please enter your full name.';
          nameErr.classList.add('active');
          return false;
        }
        if (val.length < 3) {
          nameInp.classList.remove('is-valid');
          nameInp.classList.add('is-invalid');
          nameErr.textContent = 'Full name must be at least 3 characters.';
          nameErr.classList.add('active');
          return false;
        }
        if (!/^[a-zA-Z\s\.\']{3,50}$/.test(val)) {
          nameInp.classList.remove('is-valid');
          nameInp.classList.add('is-invalid');
          nameErr.textContent = 'Name can only contain letters, spaces, and dots.';
          nameErr.classList.add('active');
          return false;
        }
        nameInp.classList.remove('is-invalid');
        nameInp.classList.add('is-valid');
        nameErr.classList.remove('active');
        return true;
      }

      function validatePropPhone() {
        var raw = (phoneInp.value || '').trim().replace(/\s+/g, '');
        if (!raw) {
          phoneInp.classList.remove('is-valid');
          phoneInp.classList.add('is-invalid');
          phoneErr.textContent = 'Mobile number is required.';
          phoneErr.classList.add('active');
          return false;
        }
        if (!/^(?:\+91[\s-]?)?[6-9]\d{9}$/.test(raw)) {
          phoneInp.classList.remove('is-valid');
          phoneInp.classList.add('is-invalid');
          phoneErr.textContent = 'Please enter a valid 10-digit Indian mobile number.';
          phoneErr.classList.add('active');
          return false;
        }
        phoneInp.classList.remove('is-invalid');
        phoneInp.classList.add('is-valid');
        phoneErr.classList.remove('active');
        return true;
      }

      function validatePropDate() {
        if (!dateInp.value) return true;
        var today = new Date().toISOString().split('T')[0];
        if (dateInp.value < today) {
          dateInp.classList.remove('is-valid');
          dateInp.classList.add('is-invalid');
          dateErr.textContent = 'Preferred date cannot be in the past.';
          dateErr.classList.add('active');
          return false;
        }
        dateInp.classList.remove('is-invalid');
        dateInp.classList.add('is-valid');
        dateErr.classList.remove('active');
        return true;
      }

      nameInp.addEventListener('blur', validatePropName);
      nameInp.addEventListener('input', function() { if (nameInp.classList.contains('is-invalid')) validatePropName(); });

      phoneInp.addEventListener('blur', validatePropPhone);
      phoneInp.addEventListener('input', function() { if (phoneInp.classList.contains('is-invalid')) validatePropPhone(); });

      dateInp.addEventListener('change', validatePropDate);

      bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        var isNameOk = validatePropName();
        var isPhoneOk = validatePropPhone();
        var isDateOk = validatePropDate();

        if (!isNameOk || !isPhoneOk || !isDateOk) {
          if (bookAlert) {
            bookAlert.textContent = 'Please fix the highlighted errors before submitting.';
            bookAlert.style.display = 'block';
          }
          var firstBad = bookingForm.querySelector('.is-invalid');
          if (firstBad) firstBad.focus();
          return;
        }

        if (bookAlert) bookAlert.style.display = 'none';
        actionSection.style.display = 'none';
        actionSuccess.style.display = 'block';
        actionSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' });

        // Synchronize booking to user dashboard
        fetch('/api/user/add-booking', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            prop_id: p.id,
            title: (p.listing === 'Buy' ? 'Site Visit — ' : 'Rental Inquiry — ') + p.title,
            type: p.listing === 'Buy' ? 'site_visit' : 'rental_inquiry',
            location: p.location + ', ' + p.city,
            date: (dateInp ? dateInp.value : '') || new Date().toISOString().split('T')[0],
            name: (nameInp ? nameInp.value.trim() : ''),
            phone: (phoneInp ? phoneInp.value.trim() : '')
          })
        }).catch(function(err) { console.error('Booking sync:', err); });
      });
    }

    // Open drawer
    drawerBackdrop.classList.add('active');
    drawerBackdrop.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closePropertyDrawer() {
    if (!drawerBackdrop) return;
    drawerBackdrop.classList.remove('active');
    drawerBackdrop.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  if (drawerClose) {
    drawerClose.addEventListener('click', closePropertyDrawer);
  }

  if (drawerBackdrop) {
    drawerBackdrop.addEventListener('click', function(e) {
      if (e.target === drawerBackdrop) {
        closePropertyDrawer();
      }
    });
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && drawerBackdrop && drawerBackdrop.classList.contains('active')) {
      closePropertyDrawer();
    }
  });

  // Global Click delegation for .prop-favorite-btn
  document.addEventListener('click', function(e) {
    var favBtn = e.target.closest('.prop-favorite-btn');
    if (!favBtn) return;
    e.preventDefault();
    e.stopPropagation();

    var propId = favBtn.getAttribute('data-prop-id');
    if (!propId) return;

    fetch('/api/user/toggle-favorite', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ prop_id: propId })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      if (data.requires_auth) {
        if (confirm(data.message + '\n\nWould you like to sign in now?')) {
          window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
        }
        return;
      }
      if (data.success) {
        var allMatching = document.querySelectorAll('.prop-favorite-btn[data-prop-id="' + propId + '"]');
        allMatching.forEach(function(b) {
          b.classList.toggle('is-saved', data.saved);
          var svg = b.querySelector('svg');
          if (svg) svg.setAttribute('fill', data.saved ? 'currentColor' : 'none');
          b.setAttribute('title', data.saved ? 'Remove from saved' : 'Save property');
        });
      }
    })
    .catch(function(err) {
      console.error('Favorite toggle failed:', err);
    });
  });

  // Global Click delegation for any .view-details-btn
  document.addEventListener('click', function(e) {
    var btn = e.target.closest('.view-details-btn');
    if (!btn) return;
    e.preventDefault();
    try {
      var raw = btn.getAttribute('data-prop');
      if (raw) {
        var p = JSON.parse(raw);
        openPropertyDrawer(p);
      }
    } catch (err) {
      console.error('Error opening property drawer:', err);
    }
  });

  // User Profile Dropdown Menu in Navbar
  var userToggle = document.getElementById('userMenuToggle');
  var userDropdown = document.getElementById('userDropdownMenu');
  if (userToggle && userDropdown) {
    userToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      var isOpen = userDropdown.classList.toggle('is-open');
      userToggle.classList.toggle('active', isOpen);
      userToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', function(e) {
      if (!userDropdown.contains(e.target) && !userToggle.contains(e.target)) {
        userDropdown.classList.remove('is-open');
        userToggle.classList.remove('active');
        userToggle.setAttribute('aria-expanded', 'false');
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && userDropdown.classList.contains('is-open')) {
        userDropdown.classList.remove('is-open');
        userToggle.classList.remove('active');
        userToggle.setAttribute('aria-expanded', 'false');
      }
    });
  }
})();
