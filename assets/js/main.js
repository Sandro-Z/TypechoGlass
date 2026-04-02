(function () {
  const navToggle = document.getElementById('nav-toggle');
  const nav = document.getElementById('site-nav');
  const backtop = document.getElementById('backtop');
  const progress = document.getElementById('reading-progress');

  if (navToggle && nav) {
    navToggle.addEventListener('click', function () {
      nav.classList.toggle('is-open');
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
