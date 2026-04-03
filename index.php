<?php
/**
 * TypechoGlass
 *
 * Apple-inspired glassmorphism theme for Typecho.
 *
 * @package TypechoGlass
 * @author Sandro
 * @version 1.0.1
 * @link https://typecho.org
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
$weatherLocation = trim((string) ag_option('weatherLocation', 'Shanghai'));
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
      <span class="label"><?php echo htmlspecialchars(ag_option('heroPanelOneLabel', '当前模式')); ?></span>
      <strong><?php echo htmlspecialchars(ag_option('heroPanelOneValue', '亮 / 暗自适应')); ?></strong>
    </div>
    <div class="hero-stat hero-weather" id="hero-weather" data-location="<?php echo htmlspecialchars($weatherLocation); ?>" aria-live="polite">
      <div class="weather-card-head">
        <div>
          <span class="label"><?php _e('天气'); ?></span>
          <strong class="weather-location" id="weather-location"><?php echo htmlspecialchars($weatherLocation !== '' ? $weatherLocation : '未设置地点'); ?></strong>
        </div>
        <span class="weather-pill" id="weather-pill"><?php _e('待更新'); ?></span>
      </div>

      <div class="weather-main">
        <div class="weather-main-copy">
          <div class="weather-temp">
            <span id="weather-temperature">--</span>
            <small>°C</small>
          </div>
          <p class="weather-summary" id="weather-summary"><?php _e('正在获取天气信息...'); ?></p>
        </div>
        <div class="weather-visual" id="weather-visual" aria-hidden="true">--</div>
      </div>

      <div class="weather-grid">
        <div class="weather-metric">
          <span><?php _e('体感'); ?></span>
          <strong id="weather-feels-like">--</strong>
        </div>
        <div class="weather-metric">
          <span><?php _e('湿度'); ?></span>
          <strong id="weather-humidity">--</strong>
        </div>
        <div class="weather-metric">
          <span><?php _e('风速'); ?></span>
          <strong id="weather-wind">--</strong>
        </div>
        <div class="weather-metric">
          <span><?php _e('高 / 低'); ?></span>
          <strong id="weather-range">--</strong>
        </div>
      </div>

      <p class="weather-meta" id="weather-meta"><?php _e('数据源：Open-Meteo'); ?></p>
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
