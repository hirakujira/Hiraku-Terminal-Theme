<?php
if (!defined('ABSPATH')) {
	exit;
}

if (post_password_required()) {
	return;
}

$comment_count = get_comments_number();
?>

<section id="comments" class="comments-area">
	<?php if (have_comments()) : ?>
		<h2 class="comments-title">
			<?php
			printf(
				esc_html(_n('%s 則留言', '%s 則留言', $comment_count, 'hiraku-terminal')),
				esc_html(number_format_i18n($comment_count))
			);
			?>
		</h2>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
			<nav class="comment-navigation" aria-label="<?php esc_attr_e('留言分頁', 'hiraku-terminal'); ?>">
				<?php previous_comments_link(esc_html__('較舊留言', 'hiraku-terminal')); ?>
				<?php next_comments_link(esc_html__('較新留言', 'hiraku-terminal')); ?>
			</nav>
		<?php endif; ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(array(
				'avatar_size' => 48,
				'reply_text' => esc_html__('回覆', 'hiraku-terminal'),
				'reply_to_text' => esc_html__('回覆「%s」的留言 ', 'hiraku-terminal'),
				'short_ping' => true,
				'style' => 'ol',
			));
			?>
		</ol>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
			<nav class="comment-navigation" aria-label="<?php esc_attr_e('留言分頁', 'hiraku-terminal'); ?>">
				<?php previous_comments_link(esc_html__('較舊留言', 'hiraku-terminal')); ?>
				<?php next_comments_link(esc_html__('較新留言', 'hiraku-terminal')); ?>
			</nav>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	comment_form(array(
		'title_reply' => esc_html__('發佈留言', 'hiraku-terminal'),
		'title_reply_to' => esc_html__('回覆「%s」的留言 ', 'hiraku-terminal'),
		'cancel_reply_link' => esc_html__('取消回覆', 'hiraku-terminal'),
	));
	?>
</section>
