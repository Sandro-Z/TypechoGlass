<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$colorMode = ag_option('colorMode', 'auto');
$lightBg = ag_option('backgroundLight', '');
$darkBg = ag_option('backgroundDark', '');
$title = ag_document_title($this);
$hasDarkLogo = trim((string) ag_option('logoDark', '')) !== '';

?>
<!DOCTYPE html>
<html lang="zh-CN" data-theme-mode="<?php echo htmlspecialchars($colorMode); ?>">
<head>
  <meta charset="<?php $this->options->charset(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#0b0b0f">
  <title><?php echo htmlspecialchars($title); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars(ag_meta_description($this)); ?>">
  <?php if (ag_get_cover($this)): ?>
    <meta property="og:image" content="<?php echo htmlspecialchars(ag_get_cover($this)); ?>">
  <?php endif; ?>
  <meta property="og:type" content="article">
  <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars(ag_meta_description($this)); ?>">
  <link rel="stylesheet" href="<?php echo ag_asset('assets/css/tokens.css'); ?>">
  <link rel="stylesheet" href="<?php echo ag_asset('assets/css/base.css'); ?>">
  <link rel="stylesheet" href="<?php echo ag_asset('assets/css/components.css'); ?>">
  <link rel="stylesheet" href="<?php echo ag_asset('assets/css/markdown.css'); ?>">
  <link rel="stylesheet" href="<?php echo ag_asset('assets/css/pages.css'); ?>">
  <style>
    :root{
      --brand-light: <?php echo htmlspecialchars(ag_option('accentLight', '#0071e3')); ?>;
      --brand-dark: <?php echo htmlspecialchars(ag_option('accentDark', '#2997ff')); ?>;
      --hero-radius: <?php echo (int) ag_option('heroRadius', '32'); ?>px;
      --light-bg-image: <?php echo $lightBg ? "url('" . htmlspecialchars($lightBg, ENT_QUOTES) . "')" : 'none'; ?>;
      --dark-bg-image: <?php echo $darkBg ? "url('" . htmlspecialchars($darkBg, ENT_QUOTES) . "')" : 'none'; ?>;
    }
    <?php echo ag_option('customCss', ''); ?>
  </style>
  <?php $this->header(); ?>
</head>
<body class="<?php echo $this->is('post') ? 'is-post' : ($this->is('page') ? 'is-page' : 'is-list'); ?>">
  <div class="page-bg" aria-hidden="true">
    <div class="page-bg-image"></div>
    <div class="page-gradient page-gradient-a"></div>
    <div class="page-gradient page-gradient-b"></div>
    <div class="page-noise"></div>
  </div>

  <?php if (ag_option_bool('showReadingProgress', true)): ?>
    <div class="reading-progress" id="reading-progress"></div>
  <?php endif; ?>

  <header class="site-header-wrap">
    <div class="site-header glass-shell">
      <a class="site-brand<?php if ($hasDarkLogo): ?> has-dark-logo<?php endif; ?>" href="<?php $this->options->siteUrl(); ?>" aria-label="<?php $this->options->title(); ?>">
        <?php if (ag_option('logoLight', '')): ?>
          <img class="logo logo-light" src="<?php echo htmlspecialchars(ag_option('logoLight', '')); ?>" alt="<?php $this->options->title(); ?>">
        <?php else: ?>
          <span class="brand-mark"><?php echo htmlspecialchars(ag_option('brandInitial', 'A')); ?></span>
        <?php endif; ?>
        <?php if (ag_option('logoDark', '')): ?>
          <img class="logo logo-dark" src="<?php echo htmlspecialchars(ag_option('logoDark', '')); ?>" alt="<?php $this->options->title(); ?>">
        <?php endif; ?>
        <span class="brand-text">
          <strong><?php $this->options->title(); ?></strong>
          <small><?php echo htmlspecialchars(ag_option('brandTagline', $this->options->description)); ?></small>
        </span>
      </a>

      <nav class="site-nav" id="site-nav">
        <a class="nav-link<?php if ($this->is('index')): ?> is-active<?php endif; ?>" href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
        <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
        <?php while ($pages->next()): ?>
          <a class="nav-link<?php if ($this->is('page', $pages->slug)): ?> is-active<?php endif; ?>" href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
        <?php endwhile; ?>
        <?php foreach (ag_get_nav_links() as $item): ?>
          <?php if (empty($item['url']) || empty($item['name'])) continue; ?>
          <a class="nav-link" href="<?php echo htmlspecialchars($item['url']); ?>"<?php echo !empty($item['newtab']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo htmlspecialchars($item['name']); ?></a>
        <?php endforeach; ?>
      </nav>

      <div class="header-actions">
        <form class="search-mini" method="get" action="<?php $this->options->siteUrl(); ?>">
          <input type="text" name="s" placeholder="<?php _e('搜索文章'); ?>">
        </form>
        <button class="icon-btn" id="theme-toggle" type="button" aria-label="<?php _e('切换主题'); ?>">
          <span class="icon-wrap"><?php echo ag_icon('theme'); ?></span>
        </button>
        <button class="icon-btn mobile-only" id="nav-toggle" type="button" aria-label="<?php _e('展开导航'); ?>" aria-controls="site-nav" aria-expanded="false">
          <span class="icon-wrap"><?php echo ag_icon('menu'); ?></span>
        </button>
      </div>
    </div>
  </header>

  <div class="site-frame">
