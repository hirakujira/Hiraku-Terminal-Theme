<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
the_post();
$category = hiraku_terminal_primary_category(get_the_ID());
$breadcrumb_categories = array();

if ($category) {
	$ancestor_ids = array_reverse(get_ancestors($category->term_id, 'category', 'taxonomy'));

	foreach ($ancestor_ids as $ancestor_id) {
		$ancestor = get_term($ancestor_id, 'category');
		if ($ancestor && !is_wp_error($ancestor)) {
			$breadcrumb_categories[] = $ancestor;
		}
	}

	$breadcrumb_categories[] = $category;
}
?>

<article <?php post_class('entry-shell'); ?>>
	<div class="breadcrumb">
		<span class="prompt-accent">~</span><span>/</span><span>posts</span><span>/</span>
		<?php foreach ($breadcrumb_categories as $breadcrumb_category) : ?>
			<a href="<?php echo esc_url(get_category_link($breadcrumb_category)); ?>"><?php echo esc_html($breadcrumb_category->name); ?></a>
			<span>/</span>
		<?php endforeach; ?>
		<span><?php echo esc_html(get_the_title()); ?></span>
	</div>

	<header class="entry-header">
		<div class="post-meta-row">
			<?php echo hiraku_terminal_category_tags(get_the_ID(), true); ?>
			<span class="meta with-icon"><?php echo hiraku_terminal_icon('calendar', 14); ?> <?php echo esc_html(get_the_date('Y/m/d')); ?></span>
		</div>
		<h1 class="entry-title"><?php echo esc_html(get_the_title()); ?></h1>
		<?php if (has_excerpt()) : ?>
			<p class="entry-lede"><?php echo esc_html(get_the_excerpt()); ?></p>
		<?php endif; ?>
	</header>

	<?php if (hiraku_terminal_has_cover(get_the_ID())) : ?>
		<div class="entry-hero">
			<?php hiraku_terminal_cover(get_the_ID(), '', 'hiraku-terminal-featured'); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages(array(
			'before' => '<div class="pagination">',
			'after' => '</div>',
		));
		?>
	</div>

	<footer class="entry-footer">
		<nav class="post-nav" aria-label="文章導覽">
			<?php
			$prev = get_previous_post();
			$next = get_next_post();
			if ($prev) {
				echo '<a href="' . esc_url(get_permalink($prev)) . '"><span class="post-nav-label">← previous</span>' . esc_html(get_the_title($prev)) . '</a>';
			}
			if ($next) {
				echo '<a href="' . esc_url(get_permalink($next)) . '"><span class="post-nav-label">next →</span>' . esc_html(get_the_title($next)) . '</a>';
			}
			?>
		</nav>
	</footer>

	<?php if (comments_open() || get_comments_number()) : ?>
		<?php comments_template(); ?>
	<?php endif; ?>
</article>

<?php
get_footer();
