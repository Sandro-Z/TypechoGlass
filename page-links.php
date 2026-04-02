<?php
/**
 * 友情链接页
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
$linksJson = isset($this->fields->linksJson) ? trim((string) $this->fields->linksJson) : '';
$linkItems = ag_parse_json($linksJson);
?>
<article class="single-article links-page">
  <header class="single-header glass-shell page-header-shell">
    <div class="single-copy">
      <span class="eyebrow"><?php _e('Friends'); ?></span>
      <h1><?php $this->title(); ?></h1>
      <p class="hero-subtitle"><?php echo htmlspecialchars(ag_option('friendsIntro', '这里可以展示 Links Plus 插件输出的友链，也支持直接在本页自定义字段 linksJson 中写入 JSON 友链数据。')); ?></p>
    </div>
  </header>

  <section class="glass-card article-body links-body">
    <div class="entry-content links-plugin-wrap">
      <?php $this->content(); ?>
    </div>

    <?php if (!empty($linkItems) && is_array($linkItems)): ?>
      <div class="section-head compact mtop-xl">
        <h2><?php _e('自定义友链'); ?></h2>
        <span><?php _e('来自 linksJson 字段'); ?></span>
      </div>
      <div class="friend-grid">
        <?php foreach ($linkItems as $item): ?>
          <?php if (empty($item['url']) || empty($item['name'])) continue; ?>
          <a class="friend-card glass-card" href="<?php echo htmlspecialchars($item['url']); ?>" target="_blank" rel="noopener noreferrer">
            <div class="friend-avatar">
              <?php if (!empty($item['image'])): ?>
                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
              <?php else: ?>
                <span><?php echo strtoupper(mb_substr($item['name'], 0, 1, 'UTF-8')); ?></span>
              <?php endif; ?>
            </div>
            <div class="friend-meta">
              <strong><?php echo htmlspecialchars($item['name']); ?></strong>
              <p><?php echo htmlspecialchars($item['description'] ?? ''); ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</article>
<?php $this->need('footer.php'); ?>
