<?php
/**
 * 时间归档页
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
?>
<article class="single-article archive-page">
  <header class="single-header glass-shell page-header-shell">
    <div class="single-copy">
      <span class="eyebrow"><?php _e('Timeline'); ?></span>
      <h1><?php $this->title(); ?></h1>
      <p class="hero-subtitle"><?php _e('按月份浏览站点全部文章。'); ?></p>
    </div>
  </header>

  <section class="glass-card article-body timeline-body">
    <div class="timeline-list">
      <?php \Widget\Contents\Post\Date::alloc('type=month&format=Y 年 m 月')->parse('<article class="timeline-item"><a href="{permalink}">{date}</a></article>'); ?>
    </div>
  </section>
</article>
<?php $this->need('footer.php'); ?>
