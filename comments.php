<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<section class="comments-section glass-card">
  <div class="section-head">
    <h2><?php _e('评论'); ?></h2>
    <span><?php $this->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?></span>
  </div>

  <?php $this->comments()->to($comments); ?>

  <?php if ($comments->have()): ?>
    <ol class="comment-list">
      <?php $comments->listComments(['before' => '', 'after' => '', 'avatarSize' => 48, 'dateFormat' => 'Y-m-d H:i', 'callback' => 'ag_comment_item']); ?>
    </ol>
    <?php $comments->pageNav('&laquo; ' . _t('上一页'), _t('下一页') . ' &raquo;'); ?>
  <?php else: ?>
    <div class="comment-empty"><?php _e('还没有人发言，来坐第一个沙发。'); ?></div>
  <?php endif; ?>

  <?php if ($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond-box">
      <div class="respond-head">
        <h3><?php _e('发表看法'); ?></h3>
        <div class="cancel-comment-reply"><?php $comments->cancelReply(_t('取消回复')); ?></div>
      </div>

      <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" class="comment-form">
        <?php if ($this->user->hasLogin()): ?>
          <p class="form-tip"><?php _e('已登录为'); ?> <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a> · <a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></p>
        <?php else: ?>
          <div class="form-grid">
            <label>
              <span><?php _e('昵称'); ?></span>
              <input type="text" name="author" value="<?php $this->remember('author'); ?>" required>
            </label>
            <label>
              <span><?php _e('邮箱'); ?></span>
              <input type="email" name="mail" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?>>
            </label>
            <label>
              <span><?php _e('网址'); ?></span>
              <input type="url" name="url" placeholder="https://" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireUrl): ?> required<?php endif; ?>>
            </label>
          </div>
        <?php endif; ?>

        <label>
          <span><?php _e('评论内容'); ?></span>
          <textarea rows="6" name="text" required></textarea>
        </label>

        <button class="btn btn-primary" type="submit"><?php _e('提交评论'); ?></button>
      </form>
    </div>
  <?php else: ?>
    <div class="comment-empty"><?php _e('评论已关闭。'); ?></div>
  <?php endif; ?>
</section>
