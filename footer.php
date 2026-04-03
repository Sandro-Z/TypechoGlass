<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
  </div>

  <footer class="site-footer-wrap">
    <footer class="site-footer glass-shell">
      <div class="footer-main">
        <div>
          <strong><?php $this->options->title(); ?></strong>
          <p><?php echo htmlspecialchars(ag_option('footerText', 'AeroGlass 主题 · 轻盈、纯色、可扩展。')); ?></p>
        </div>

        <div class="footer-social">
          <?php ag_render_social_links(); ?>
        </div>
      </div>

      <div class="footer-meta">
        <span>© <?php echo date('Y'); ?> <?php $this->options->title(); ?></span>
        <?php if (trim(ag_option('beian', '')) !== ''): ?>
          <span><?php echo htmlspecialchars(ag_option('beian', '')); ?></span>
        <?php endif; ?>
        <span>Powered by Typecho</span>
      </div>
    </footer>
  </footer>

  <button class="floating-backtop glass-card" id="backtop" aria-label="<?php _e('返回顶部'); ?>">
    <?php echo ag_icon('arrow-up'); ?>
  </button>

  <script>window.AeroGlassConfig = <?php echo json_encode([
    'colorMode' => ag_option('colorMode', 'auto'),
    'showReadingProgress' => ag_option_bool('showReadingProgress', true),
    'showToc' => ag_option_bool('showToc', true),
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;</script>
  <script src="<?php echo ag_asset('assets/js/theme.js'); ?>"></script>
  <script src="<?php echo ag_asset('assets/js/main.js'); ?>"></script>
  <script src="<?php echo ag_asset('assets/js/toc.js'); ?>"></script>
  <script><?php echo ag_option('customJs', ''); ?></script>
  <script type="text/x-mathjax-config">
    MathJax.Hub.Config({
      tex2jax: {
        preview: 'none'
      },
      'fast-preview': {
        disabled: true
      }
    });
  </script>
  <?php if ($this->is('post') || $this->is('page')): ?>
    <?php if ($this->allow('comment')): ?>
      <?php ag_threaded_comments_script_safe(); ?>
    <?php endif; ?>
  <?php endif; ?>
  <?php $this->footer(); ?>
</body>
</html>
