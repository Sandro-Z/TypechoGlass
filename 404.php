<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
?>
<section class="glass-shell not-found">
  <div class="glass-card not-found-card">
    <span class="eyebrow">404</span>
    <h1><?php _e('页面走丢了'); ?></h1>
    <p><?php _e('你访问的内容不存在，或者已经被移动。'); ?></p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="<?php $this->options->siteUrl(); ?>"><?php _e('返回首页'); ?></a>
      <a class="btn btn-secondary" href="javascript:history.back()"><?php _e('返回上一页'); ?></a>
    </div>
  </div>
</section>
<?php $this->need('footer.php'); ?>
