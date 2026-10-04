/**
 * Homeosphere 3.0 — Parallax Architectural Zoom & Spatial Navigation Engine
 * Orchestrates 5 interactive scenes: Entrance, Living Room, Kitchen, Wardrobe, Home Office
 */
(function() {
  'use strict';

  // Frame geometry configuration
  const FR = [
    { a: 0.7921, o: [7.66, 5.46, 85.06, 88.92] },
    { a: 0.7699, o: [7.55, 5.58, 85.36, 89.09] },
    { a: 0.7646, o: [8.40, 6.54, 83.51, 87.51] },
    { a: 0.6839, o: [5.05, 3.54, 90.17, 93.19] }
  ];

  // Kitchen Cabinet 3D Perspective Coordinates — exact pixel mapping from kitchen.jpg
  const CAB = [
    { r: [40.69, 17.11, 7.20, 42.63], bs: "1389.474% 234.555%", bp: "43.844% 29.831%" },
    { r: [47.89, 17.11, 7.51, 42.63], bs: "1331.092% 234.555%", bp: "51.775% 29.831%" },
    { r: [55.40, 17.11, 7.54, 42.63], bs: "1325.523% 234.555%", bp: "59.918% 29.831%" },
    { r: [62.94, 17.11, 8.02, 42.63], bs: "1247.244% 234.555%", bp: "68.428% 29.831%" },
    { r: [40.69, 59.75, 7.20, 23.21], bs: "1389.474% 430.769%", bp: "43.844% 77.810%" },
    { r: [47.89, 59.75, 7.51, 23.21], bs: "1331.092% 430.769%", bp: "51.775% 77.810%" },
    { r: [55.40, 59.75, 7.54, 23.21], bs: "1325.523% 430.769%", bp: "59.918% 77.810%" },
    { r: [62.94, 59.75, 8.02, 23.21], bs: "1247.244% 430.769%", bp: "68.428% 77.810%" }
  ];

  const $ = s => document.querySelector(s);
  const $$ = s => [...document.querySelectorAll(s)];

  const clamp = (x, a = 0, b = 1) => Math.min(b, Math.max(a, x));
  const seg = (x, a, b) => clamp((x - a) / (b - a));
  const ease = t => t < .5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
  const lerp = (a, b, t) => a + (b - a) * t;

  const ROOM_NAMES = ['Entrance', 'Living Room', 'Kitchen', 'Wardrobe', 'Home Office', 'The Balcony'];
  const SCENE_JUMPS = [0, 0.28, 0.44, 0.60, 0.76, 0.94];
  const SCENE_RANGES = [
    [0, 0.22],
    [0.18, 0.38],
    [0.34, 0.54],
    [0.50, 0.70],
    [0.66, 0.86],
    [0.82, 1.00]
  ];

  document.addEventListener('DOMContentLoaded', () => {
    const track = $('#track');
    if (!track) return;

    const sc = $$('.scene');
    const dotsWrap = $('#parallaxDots');
    const p0 = $('#p0');
    const p3 = $('#p3');
    const pk = $('#pk');
    const pt = $('#pt');
    const dl = $('.dl');
    const dr = $('.dr');
    const hin = $('.hero-in');
    const et = $('.ext-title');
    const hint = $('.hint');
    const strip = $('#strip');
    const barsWrap = $('#bars');

    // Build Floating Quick Dots
    if (dotsWrap) {
      dotsWrap.innerHTML = ROOM_NAMES.map((name, i) =>
        `<b data-title="${name}" onclick="window.goScene(${i})" title="${name}"></b>`
      ).join('');
    }
    const dots = $$('#parallaxDots b');

    // Populate Kitchen Cabinets if container is present and empty
    if (pk && !pk.querySelector('.cab') && window.PARALLAX_SERVICES) {
      const svcs = window.PARALLAX_SERVICES;
      const cabHtml = CAB.map((c, i) => {
        const isSm = i >= 4;
        const s = svcs[i] || { name: 'Service', desc: 'Home maintenance', start: 299, id: 'cleaning', image: '/assets/img/service/cleaning.jpg' };
        const thumbUrl = s.image || '/assets/img/service/cleaning.jpg';
        return `
          <div class="cab ${isSm ? 'cab-sm' : 'cab-lg'}" style="left:${c.r[0]}%;top:${c.r[1]}%;width:${c.r[2]}%;height:${c.r[3]}%">
            <div class="inside">
              <div class="cab-card">
                <div class="cab-thumb" style="background-image:url('${thumbUrl}')"></div>
                <div class="cab-body">
                  <h3 class="cab-title">${s.name}</h3>
                  <div class="cab-action">
                    <span class="cab-price">From ₹${Number(s.start).toLocaleString('en-IN')}</span>
                    <a href="/services?cat=${encodeURIComponent(s.id || s.name)}" class="cab-btn">Book Now</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="kd${i % 2 ? ' r' : ''}" style="background-size:${c.bs};background-position:${c.bp}"></div>
          </div>
        `;
      }).join('');
      pk.insertAdjacentHTML('beforeend', cabHtml);
    }

    // Populate Wardrobe Hangers if container is present and empty
    if (p3 && !p3.querySelector('.hang') && window.PARALLAX_PROS) {
      const pros = window.PARALLAX_PROS;
      const hangHtml = pros.slice(0, 6).map((p, i) => {
        const x = [38.9, 50.3, 61.7][i % 3];
        // Upper rail at 30.1%, Lower rail at 55.0% - offset by hook depth (1.2%)
        const y = i < 3 ? 28.9 : 53.8;
        const avatar = p.img || p.avatar || '/assets/img/Professional Portfolios/Arjun Mehta Architect/avatar.png';
        const hireUrl = '/contact?' + new URLSearchParams({ pro: p.name, role: p.role, req: 'contact_pro' }).toString();
        return `
          <div class="hang" style="left:${x - 4.8}%;top:${y}%">
            <div class="hg"></div>
            <div class="tag">
              <div class="pro-head">
                <img src="${avatar}" alt="${p.name}" class="pro-avatar" onerror="this.src='/assets/img/Professional Portfolios/Arjun Mehta Architect/avatar.png'">
                <div>
                  <b>${p.name}</b>
                  <span class="pro-role">${p.role}</span>
                </div>
              </div>
              <small>★ ${p.rating || 4.9} &bull; ${p.experience || 10}+ yrs exp &bull; ${p.location ? p.location.split(',')[0] : 'India'}</small>
              <a href="${hireUrl}" class="hire-btn">Hire Pro ➔</a>
            </div>
          </div>
        `;
      }).join('');
      p3.innerHTML = hangHtml;
    }

    // Build Laptop Bar Chart in Home Office
    if (barsWrap && !barsWrap.children.length) {
      barsWrap.innerHTML = [38, 52, 45, 68, 60, 78, 72, 94].map(h => `<i style="height:${h}%"></i>`).join('');
    }

    // Cache dynamic DOM elements after generation
    const kd = $$('.kd');
    const hg = $$('.hang');
    const bars = $$('#bars i');

    // Global smooth scene jump function
    window.goScene = function(i) {
      if (i < 0 || i >= SCENE_JUMPS.length) return;
      const maxScroll = track.offsetHeight - window.innerHeight;
      const targetY = track.offsetTop + maxScroll * SCENE_JUMPS[i];
      window.scrollTo({ top: targetY, behavior: 'smooth' });
    };

    // Scroll to section below parallax track
    window.scrollToSection = function(selector) {
      const el = $(selector);
      if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
      } else {
        window.scrollTo({ top: track.offsetTop + track.offsetHeight + 10, behavior: 'smooth' });
      }
    };

    // Main Render Function
    function render(p) {
      // Manage scenes visibility, scaling and crossfades
      sc.forEach((s, i) => {
        const [a, b] = SCENE_RANGES[i];
        const l = seg(p, a, b);
        const fi = i ? seg(p, a, a + 0.03) : 1;
        const fo = i < (SCENE_RANGES.length - 1) ? 1 - seg(p, b - 0.03, b) : 1;
        const op = fi * fo;

        s.style.opacity = op;
        s.style.visibility = op > 0.01 ? 'visible' : 'hidden';
        s.style.pointerEvents = op > 0.5 ? 'auto' : 'none';
        s.style.transform = `scale(${(i ? lerp(0.96, 1, ease(fi)) : 1) * (i < (SCENE_RANGES.length - 1) ? lerp(1.03, 1, fo) : 1)})`;

        // Scene 0: Entrance Front Door 3D Open & Zoom to Foyer
        if (i === 0) {
          const g = 100 * ease(seg(l, 0.02, 0.32));
          if (dl) dl.style.transform = `rotateY(${g}deg)`;
          if (dr) dr.style.transform = `rotateY(${-g}deg)`;

          const q = seg(l, 0.16, 0.52);
          if (p0) {
            p0.style.transform = `translate(-50%, -50%) scale(${1 + 10 * q * q})`;
            p0.style.opacity = 1 - seg(l, 0.42, 0.58);
          }
          const h = seg(l, 0.40, 0.58);
          if (hin) {
            hin.style.opacity = h;
            hin.style.pointerEvents = h > 0.8 ? 'auto' : 'none';
          }
          if (et) et.style.opacity = 1 - seg(l, 0, 0.12);
          if (hint) hint.style.opacity = 1 - seg(l, 0, 0.12);
        }

        // Scene 1: Living Room Horizontal Picture Frame Strip Slide
        if (i === 1 && strip) {
          const scrollDist = strip.scrollWidth - 0.3 * window.innerWidth;
          strip.style.transform = `translateX(${lerp(0.62 * window.innerWidth, -scrollDist, ease(l))}px)`;
        }

        // Scene 2: Kitchen Modular 3D Cabinet Doors Swing
        if (i === 2 && kd.length) {
          kd.forEach((d, k) => {
            const col = k % 4;
            const maxAngle = (col === 0 || col === 3) ? 106 : 96;
            const rot = (k % 2 ? 1 : -1) * maxAngle * ease(seg(l, 0.04 + col * 0.02, 0.22 + col * 0.02));
            d.style.transform = `rotateY(${rot}deg)`;
          });
        }

        // Scene 3: Wardrobe Natural Harmonic Hanger Swing
        if (i === 3) {
          if (p3) {
            const e = ease(seg(l, 0.05, 0.95));
            p3.style.transform = `translate(-50%, -50%) translateY(${lerp(4, -4, e)}%) scale(${lerp(1, 1.03, e)})`;
          }
          if (hg.length) {
            hg.forEach((h, k) => {
              const t = seg(l, 0.05 + k * 0.07, 0.32 + k * 0.07);
              const e2 = ease(t);
              h.style.opacity = seg(t, 0, 0.15);
              const swingRot = 26 * Math.cos(e2 * Math.PI * 3.5) * (1 - e2);
              h.style.transform = `translateX(${(1 - e2) * 45}%) rotate(${swingRot}deg)`;
            });
          }
        }

        // Scene 4: Home Office Animated Dashboard Trends Bars
        if (i === 4 && bars.length) {
          bars.forEach((b, k) => {
            b.style.transform = `scaleY(${ease(seg(l, 0.06 + k * 0.03, 0.32 + k * 0.03))})`;
          });
        }

        // Scene 5: The Balcony / Terrace Architectural Zoom & Elevation
        if (i === 5 && pt) {
          const tz = lerp(1.0, 1.06, ease(l));
          pt.style.transform = `translate(-50%, -50%) scale(${tz})`;
        }
      });

      // Update active dot and room indicator
      const activeIdx = p < 0.20 ? 0 : p < 0.36 ? 1 : p < 0.52 ? 2 : p < 0.68 ? 3 : p < 0.84 ? 4 : 5;
      dots.forEach((d, idx) => d.classList.toggle('on', idx === activeIdx));

      // Hide dots when scrolled past the parallax track into standard content
      if (dotsWrap) {
        const scrolledPast = (window.scrollY > (track.offsetTop + track.offsetHeight - 120));
        dotsWrap.classList.toggle('hidden', scrolledPast);
      }
    }

    // Scroll interpolation loop
    let curProgress = 0;
    let targetProgress = 0;

    const calcProgress = () => {
      const maxScroll = track.offsetHeight - window.innerHeight;
      if (maxScroll <= 0) return 0;
      return clamp((window.scrollY - track.offsetTop) / maxScroll);
    };

    window.addEventListener('scroll', () => { targetProgress = calcProgress(); }, { passive: true });
    window.addEventListener('resize', () => { targetProgress = calcProgress(); }, { passive: true });

    targetProgress = calcProgress();
    curProgress = targetProgress;
    window.renderParallax = render;
    window.setParallaxProgress = function(p) {
      targetProgress = p;
      curProgress = p;
      render(p);
    };
    render(curProgress);

    function animationTick() {
      curProgress += (targetProgress - curProgress) * 0.12;
      if (Math.abs(targetProgress - curProgress) < 1e-4) {
        curProgress = targetProgress;
      }
      render(curProgress);
      requestAnimationFrame(animationTick);
    }
    requestAnimationFrame(animationTick);
  });
})();
