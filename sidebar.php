<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<aside class="side-column">
  <section class="glass-card sidebar-card">
    <div class="section-head compact">
      <h2><?php _e('站点简介'); ?></h2>
      <span><?php _e('About'); ?></span>
    </div>
    <p><?php echo htmlspecialchars(ag_option('sidebarIntro', $this->options->description)); ?></p>
  </section>

  <section class="glass-card sidebar-card">
    <div class="section-head compact">
      <h2><?php _e('最近文章'); ?></h2>
      <span><?php _e('Recent'); ?></span>
    </div>
    <ul class="sidebar-list">
      <?php \Widget\Contents\Post\Recent::alloc('pageSize=6')->to($recent); ?>
      <?php while ($recent->next()): ?>
        <li><a href="<?php $recent->permalink(); ?>"><?php $recent->title(); ?></a></li>
      <?php endwhile; ?>
    </ul>
  </section>

  <section class="glass-card sidebar-card">
    <div class="section-head compact">
      <h2><?php _e('分类'); ?></h2>
      <span><?php _e('Categories'); ?></span>
    </div>
    <div class="chip-row sidebar-chip-row">
      <?php \Widget\Metas\Category\Rows::alloc()->to($sideCategories); ?>
      <?php while ($sideCategories->next()): ?>
        <a class="chip" href="<?php $sideCategories->permalink(); ?>"><?php $sideCategories->name(); ?></a>
      <?php endwhile; ?>
    </div>
  </section>

  <section class="glass-card sidebar-card">
    <div class="section-head compact">
      <h2><?php _e('归档'); ?></h2>
      <span><?php _e('Archive'); ?></span>
    </div>
    <ul class="sidebar-list">
      <?php \Widget\Contents\Post\Date::alloc('type=month&format=Y 年 m 月')->parse('<li><a href=" {permalink}"> {date}</a></li>'); ?>
    </ul>
  </section>
</aside>
