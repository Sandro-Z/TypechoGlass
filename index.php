<?php
/**
 * AeroGlass for Typecho
 *
 * Apple-inspired glassmorphism theme for Typecho.
 *
 * @package AeroGlass
 * @author OpenAI
 * @version 1.0.0
 * @link https://typecho.org
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
?>
<section class="hero glass-shell hero-home">
  <div class="hero-copy">
    <span class="eyebrow"><?php echo htmlspecialchars(ag_option('heroEyebrow', 'Apple-inspired Typecho Theme')); ?></span>
    <h1><?php echo htmlspecialchars(ag_option('heroTitle', $this->options->title)); ?></h1>
    <p class="hero-subtitle"><?php echo htmlspecialchars(ag_option('heroSubtitle', $this->options->description)); ?></p>

    <div class="hero-actions">
      <a class="btn btn-primary" href="#post-stream"><?php _e('开始阅读'); ?></a>
      <a class="btn btn-secondary" href="<?php $this->options->feedUrl(); ?>"><?php _e('订阅 RSS'); ?></a>
    </div>
  </div>

  <div class="hero-panel glass-card">
    <div class="hero-stat">
      <span class="label"><?php _e('当前模式'); ?></span>
      <strong><?php _e('亮 / 暗自适应'); ?></strong>
    </div>
    <div class="hero-stat">
      <span class="label"><?php _e('主题特性'); ?></span>
      <strong><?php _e('毛玻璃 · 高斯模糊 · 纯色'); ?></strong>
    </div>
    <div class="hero-stat">
      <span class="label"><?php _e('扩展能力'); ?></span>
      <strong><?php _e('Logo · 社媒 · 友链 · 分页'); ?></strong>
    </div>
  </div>
</section>

<?php if (ag_option_bool('showCategoryStrip', true)): ?>
<section class="category-strip glass-card">
  <div class="section-head compact">
    <h2><?php _e('分类'); ?></h2>
    <span><?php _e('快速进入分类页'); ?></span>
  </div>
  <div class="chip-row">
    <?php \Widget\Metas\Category\Rows::alloc()->to($categories); ?>
    <?php while ($categories->next()): ?>
      <a class="chip<?php if ($this->is('category', $categories->slug)): ?> is-active<?php endif; ?>" href="<?php $categories->permalink(); ?>">
        <?php $categories->name(); ?>
        <span><?php echo (int) $categories->count; ?></span>
      </a>
    <?php endwhile; ?>
  </div>
</section>
<?php endif; ?>

<section id="post-stream" class="content-grid">
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
        <h2><?php _e('暂时没有文章'); ?></h2>
        <p><?php _e('你可以先去后台发布第一篇内容。'); ?></p>
      </div>
    <?php endif; ?>
  </main>

  <?php $this->need('sidebar.php'); ?>
</section>
<?php $this->need('footer.php'); ?>
