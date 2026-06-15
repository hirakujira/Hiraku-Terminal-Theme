<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
the_post();
$is_about = is_page('about');
?>

<article <?php post_class('page-shell'); ?>>
	<div class="breadcrumb"><span class="prompt-accent">~</span><span>/</span><span><?php echo esc_html(get_post_field('post_name', get_the_ID())); ?></span></div>
	<header class="entry-header">
		<h1 class="page-title"><?php echo esc_html(get_the_title()); ?></h1>
	</header>

	<?php if ($is_about) : ?>
		<div class="profile-card">
			<div class="author-mark"><?php echo hiraku_terminal_icon('terminal', 28); ?></div>
			<div>
				<div class="profile-title">Hiraku（皮樂）</div>
				<div class="profile-subtitle">software_engineer</div>
			</div>
			<div class="header-spacer"></div>
			<a class="icon-button" href="https://github.com/hirakujira" aria-label="GitHub"><?php echo hiraku_terminal_icon('github', 19); ?></a>
			<a class="icon-button" href="https://www.facebook.com/hiraku.tw" aria-label="Facebook"><?php echo hiraku_terminal_icon('facebook', 19); ?></a>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<?php if (comments_open() || get_comments_number()) : ?>
		<?php comments_template(); ?>
	<?php endif; ?>
</article>

<?php
get_footer();
