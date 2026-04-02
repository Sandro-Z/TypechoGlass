<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
?>
<section class="hero glass-shell hero-archive">
  <div class="hero-copy">
    <span class="eyebrow"><?php _e('Archive'); ?></span>
    <h1><?php echo ag_current_archive_title($this); ?></h1>
    <p class="hero-subtitle"><?php echo htmlspecialchars(ag_current_archive_subtitle($this)); ?></p>
  </div>
</section>

<section class="content-grid">
  <main class="main-column">
    <?php if ($this->have()): ?>
      <div class="post-grid">
        <?php while ($this->next()): ?>
          <?php ag_render_post_card($this); ?>
        <?php endwhile; ?>
      </div>
      <?php ag_render_pagination($this); ?>
    <?php else: ?>
      <div class="glass-card empty-state">
        <h2><?php _e('没有找到内容'); ?></h2>
        <p><?php _e('换个关键词，或者看看其他分类。'); ?></p>
      </div>
    <?php endif; ?>
  </main>

  <?php $this->need('sidebar.php'); ?>
</section>
<?php $this->need('footer.php'); ?>
