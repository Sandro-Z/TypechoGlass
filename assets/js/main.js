(function () {
  const navToggle = document.getElementById('nav-toggle');
  const nav = document.getElementById('site-nav');
  const siteHeader = document.querySelector('.site-header');
  const backtop = document.getElementById('backtop');
  const progress = document.getElementById('reading-progress');

  if (navToggle && nav) {
    const syncNavState = function (isOpen) {
      nav.classList.toggle('is-open', isOpen);
      navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

      if (siteHeader) {
        siteHeader.classList.toggle('has-open-nav', isOpen);
      }
    };

    syncNavState(nav.classList.contains('is-open'));

    navToggle.addEventListener('click', function () {
      syncNavState(!nav.classList.contains('is-open'));
    });

    window.addEventListener('resize', function () {
      if (window.innerWidth > 900) {
        syncNavState(false);
      }
    });
  }

  function updateScrollUi() {
    const y = window.scrollY || document.documentElement.scrollTop;
    if (backtop) backtop.classList.toggle('is-visible', y > 320);

    if (progress) {
      const doc = document.documentElement;
      const max = doc.scrollHeight - doc.clientHeight;
      const value = max > 0 ? (y / max) * 100 : 0;
      progress.style.width = value + '%';
    }
  }

  updateScrollUi();
  window.addEventListener('scroll', updateScrollUi, { passive: true });

  if (backtop) {
    backtop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
})();
