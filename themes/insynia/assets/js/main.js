/**
 * BH Starter — front-end interactions.
 *
 * @package BH_Starter
 */

(function () {
  'use strict';

  /* ---- Sticky header shadow on scroll ---- */
  const header = document.getElementById('site-header');
  if (header) {
    const onScroll = () => {
      header.classList.toggle('scrolled', window.scrollY > 10);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ---- Mobile nav toggle ---- */
  const toggle = document.getElementById('nav-toggle');
  const nav = document.getElementById('main-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!expanded));
      toggle.classList.toggle('active');
      nav.classList.toggle('open');
    });

    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        toggle.classList.remove('active');
        nav.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* ---- Scroll to top button ---- */
  const scrollBtn = document.getElementById('scroll-to-top');
  if (scrollBtn) {
    window.addEventListener(
      'scroll',
      function () {
        scrollBtn.classList.toggle('visible', window.scrollY > 400);
      },
      { passive: true }
    );

    scrollBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ---- Smooth scroll for anchor links ---- */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const id = this.getAttribute('href');
      if (id.length <= 1) return;
      const target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      const offset = header ? header.offsetHeight + 16 : 16;
      const top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top: top, behavior: 'smooth' });
    });
  });

  /* ---- Product detail gallery thumbs ---- */
  const gallery = document.querySelector('[data-product-gallery]');
  if (gallery) {
    const mainImg = document.getElementById('product-detail-main-img');
    const thumbs = gallery.querySelectorAll('.product-detail-thumb');
    if (mainImg && thumbs.length) {
      thumbs.forEach(function (btn) {
        btn.addEventListener('click', function () {
          const src = btn.getAttribute('data-full-src');
          if (!src) return;
          mainImg.setAttribute('src', src);
          thumbs.forEach(function (t) {
            t.classList.remove('is-active');
            t.setAttribute('aria-pressed', 'false');
          });
          btn.classList.add('is-active');
          btn.setAttribute('aria-pressed', 'true');
        });
      });
    }
  }

  /* ---- (animations removed — content is always visible) ---- */
})();
