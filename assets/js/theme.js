(function () {
  const root = document.documentElement;
  const storageKey = 'aeroglass-theme';
  const preferred = (window.AeroGlassConfig && window.AeroGlassConfig.colorMode) || root.getAttribute('data-theme-mode') || 'auto';

  function applyTheme(mode) {
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const realMode = mode === 'auto' ? (systemDark ? 'dark' : 'light') : mode;
    root.setAttribute('data-theme', realMode);
    root.dataset.themeMode = mode;
  }

  const saved = localStorage.getItem(storageKey) || preferred;
  applyTheme(saved);

  const toggle = document.getElementById('theme-toggle');
  if (toggle) {
    toggle.addEventListener('click', function () {
      const current = localStorage.getItem(storageKey) || preferred;
      const next = current === 'auto' ? 'light' : current === 'light' ? 'dark' : 'auto';
      localStorage.setItem(storageKey, next);
      applyTheme(next);
    });
  }

  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
    const current = localStorage.getItem(storageKey) || preferred;
    if (current === 'auto') applyTheme('auto');
  });
})();
