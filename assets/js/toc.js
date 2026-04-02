(function () {
  const container = document.getElementById('toc-container');
  const content = document.getElementById('entry-content');
  if (!container || !content) return;

  const headings = Array.from(content.querySelectorAll('h2, h3, h4'));
  if (!headings.length) {
    container.innerHTML = '<p class="muted">本页没有可生成的目录。</p>';
    return;
  }

  headings.forEach(function (heading, index) {
    if (!heading.id) heading.id = 'section-' + (index + 1);
    const depth = Number(heading.tagName.replace('H', ''));
    const link = document.createElement('a');
    link.className = 'toc-item depth-' + depth;
    link.href = '#' + heading.id;
    link.textContent = heading.textContent;
    container.appendChild(link);
  });

  const tocItems = Array.from(container.querySelectorAll('.toc-item'));
  const observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      tocItems.forEach(function (item) {
        item.classList.toggle('is-active', item.getAttribute('href') === '#' + entry.target.id);
      });
    });
  }, {
    rootMargin: '0px 0px -70% 0px',
    threshold: 0
  });

  headings.forEach(function (heading) { observer.observe(heading); });
})();
