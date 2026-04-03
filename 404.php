<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
$requestUri = isset($_SERVER['REQUEST_URI']) ? trim((string) $_SERVER['REQUEST_URI']) : '';
$archiveUrl = ag_get_special_page_permalink('archive');
$friendsUrl = ag_get_special_page_permalink('friends');
?>
<section class="glass-shell not-found not-found-shell">
  <div class="not-found-copy">
    <span class="eyebrow">404 / Lost in Glass</span>
    <h1><?php _e('这页被折进了雾面玻璃后面'); ?></h1>
    <p><?php _e('你访问的内容不存在，或者链接地址已经发生变化。站点里最常见的原因，是自定义导航写死了 URL，或独立页面的 slug 后来被改过。'); ?></p>

    <?php if ($requestUri !== ''): ?>
      <div class="not-found-path">
        <span><?php _e('当前请求'); ?></span>
        <code><?php echo htmlspecialchars($requestUri); ?></code>
      </div>
    <?php endif; ?>

    <div class="hero-actions">
      <a class="btn btn-primary" href="<?php $this->options->siteUrl(); ?>"><?php _e('返回首页'); ?></a>
      <a class="btn btn-secondary" href="javascript:history.back()"><?php _e('返回上一页'); ?></a>
      <?php if ($archiveUrl !== ''): ?>
        <a class="btn btn-secondary" href="<?php echo htmlspecialchars($archiveUrl); ?>"><?php _e('查看归档'); ?></a>
      <?php endif; ?>
      <?php if ($friendsUrl !== ''): ?>
        <a class="btn btn-secondary" href="<?php echo htmlspecialchars($friendsUrl); ?>"><?php _e('逛逛友链'); ?></a>
      <?php endif; ?>
    </div>

    <form class="not-found-search" method="get" action="<?php $this->options->siteUrl(); ?>">
      <input type="text" name="s" placeholder="<?php _e('试试搜索文章标题或关键词'); ?>">
      <button class="btn btn-primary" type="submit"><?php _e('站内搜索'); ?></button>
    </form>
  </div>

  <div class="glass-card not-found-panel">
    <div class="nf-visual" aria-hidden="true">
      <div class="nf-number">404</div>
      <span class="nf-ring nf-ring-a"></span>
      <span class="nf-ring nf-ring-b"></span>
      <span class="nf-glow nf-glow-a"></span>
      <span class="nf-glow nf-glow-b"></span>
      <span class="nf-dot nf-dot-a"></span>
      <span class="nf-dot nf-dot-b"></span>
      <span class="nf-dot nf-dot-c"></span>
    </div>

    <div class="not-found-grid">
      <article class="nf-mini-card">
        <strong><?php _e('先检查链接'); ?></strong>
        <p><?php _e('如果是主题导航里的“归档 / 友链”报错，优先检查它是否还在写死页面地址。'); ?></p>
      </article>
      <article class="nf-mini-card">
        <strong><?php _e('正确做法'); ?></strong>
        <p><?php _e('请在 Typecho 后台创建独立页面，并分别绑定“时间归档页”和“友情链接页”模板。'); ?></p>
      </article>
    </div>
  </div>
</section>
<?php $this->need('footer.php'); ?>
