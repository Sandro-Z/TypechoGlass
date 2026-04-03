<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
$cover = ag_get_cover($this);
?>
<article class="single-article">
  <header class="single-header glass-shell page-header-shell">
    <div class="single-copy">
      <span class="eyebrow"><?php _e('Page'); ?></span>
      <h1><?php $this->title(); ?></h1>
      <?php if (isset($this->fields->subtitle) && trim((string) $this->fields->subtitle) !== ''): ?>
        <p class="hero-subtitle mathjax-process"><?php echo htmlspecialchars((string) $this->fields->subtitle); ?></p>
      <?php else: ?>
        <p class="hero-subtitle mathjax-process"><?php echo htmlspecialchars($this->options->description); ?></p>
      <?php endif; ?>
    </div>

    <div class="single-cover-wrap">
      <?php if ($cover): ?>
        <div class="single-cover glass-card">
          <img src="<?php echo htmlspecialchars($cover); ?>" alt="<?php $this->title(); ?>">
        </div>
      <?php endif; ?>
    </div>
  </header>

  <section class="article-body glass-card page-body">
    <div class="entry-content mathjax-process" id="entry-content">
      <?php $this->content(); ?>
    </div>
  </section>

  <?php if (ag_option_bool('allowPageComments', false)): ?>
    <?php $this->need('comments.php'); ?>
  <?php endif; ?>
</article>
<?php $this->need('footer.php'); ?>
