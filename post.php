<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
$cover = ag_get_card_cover($this);
?>
<article class="single-article">
  <header class="single-header glass-shell">
    <div class="single-copy">
      <div class="meta-row">
        <span class="meta-pill"><?php echo ag_primary_category_name($this); ?></span>
        <?php if (isset($this->fields->featured) && $this->fields->featured == '1'): ?>
          <span class="meta-pill accent"><?php _e('推荐'); ?></span>
        <?php endif; ?>
      </div>
      <h1><?php $this->title(); ?></h1>
      <?php if (isset($this->fields->subtitle) && trim((string) $this->fields->subtitle) !== ''): ?>
        <p class="hero-subtitle mathjax-process"><?php echo htmlspecialchars((string) $this->fields->subtitle); ?></p>
      <?php else: ?>
        <p class="hero-subtitle mathjax-process"><?php echo htmlspecialchars(ag_excerpt_plain($this, 110)); ?></p>
      <?php endif; ?>

      <div class="entry-meta glass-card compact-card">
        <span><?php _e('发布于'); ?> <?php $this->date('Y-m-d'); ?></span>
        <span><?php _e('阅读'); ?> <?php echo ag_estimated_reading_time($this->text); ?> <?php _e('分钟'); ?></span>
        <span><?php _e('评论'); ?> <?php $this->commentsNum('0', '1', '%d'); ?></span>
      </div>
    </div>

    <div class="single-cover-wrap">
      <?php if ($cover): ?>
        <div class="single-cover glass-card">
          <img src="<?php echo htmlspecialchars($cover); ?>" alt="<?php $this->title(); ?>">
        </div>
      <?php else: ?>
        <div class="single-cover glass-card no-image">
          <div class="orb orb-a"></div>
          <div class="orb orb-b"></div>
          <div class="orb orb-c"></div>
        </div>
      <?php endif; ?>
    </div>
  </header>

  <div class="article-layout">
    <main class="article-main">
      <section class="article-body glass-card">
        <div class="entry-content mathjax-process" id="entry-content">
          <?php $this->content(); ?>
        </div>

        <?php if ($this->tags): ?>
        <footer class="entry-footer">
          <div class="tag-row">
            <?php $this->tags('', true, '<a class="tag-chip" href="{permalink}">#{name}</a>'); ?>
          </div>
        </footer>
        <?php endif; ?>
      </section>

      <?php ag_render_adjacent_post_nav($this); ?>

      <?php $this->need('comments.php'); ?>
    </main>

    <?php if (ag_option_bool('showToc', true) && !(isset($this->fields->disableToc) && $this->fields->disableToc == '1')): ?>
    <aside class="article-aside">
      <div class="glass-card toc-card">
        <div class="section-head compact">
          <h2><?php _e('目录'); ?></h2>
          <span><?php _e('自动生成'); ?></span>
        </div>
        <div id="toc-container" class="toc-container mathjax-process"></div>
      </div>
    </aside>
    <?php endif; ?>
  </div>
</article>
<?php $this->need('footer.php'); ?>
