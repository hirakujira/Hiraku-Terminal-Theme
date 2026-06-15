<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();

$is_front_posts = is_home() && !is_paged() && !is_search() && !is_archive();
$post_count = hiraku_terminal_post_count();
$site_description = get_bloginfo('description', 'display');
?>

<?php if ($is_front_posts) : ?>
	<div class="status-line">
		<span class="prompt-accent"><?php echo esc_html($site_description); ?></span>
		<span>:</span>
		<span style="color:#7aa2f7">~/posts</span>
		<span>$ ls -lt</span>
		<span class="status-muted"># <?php echo esc_html(number_format_i18n($post_count)); ?> 篇文章 · since 2010</span>
	</div>
<?php else : ?>
	<header class="archive-header">
		<div class="breadcrumb"><span class="prompt-accent">~</span><span>/</span><span><?php echo is_search() ? 'search' : 'archive'; ?></span></div>
		<h1 class="archive-title">
			<?php
			if (is_search()) {
				printf(esc_html__('搜尋：%s', 'hiraku-terminal'), esc_html(get_search_query()));
			} elseif (is_archive()) {
				the_archive_title();
			} else {
				esc_html_e('文章列表', 'hiraku-terminal');
			}
			?>
		</h1>
		<?php if (is_archive() && get_the_archive_description()) : ?>
			<div class="archive-description"><?php the_archive_description(); ?></div>
		<?php endif; ?>
	</header>
<?php endif; ?>

<?php if (have_posts()) : ?>
	<?php if ($is_front_posts) : the_post(); ?>
		<?php $featured_has_cover = hiraku_terminal_has_cover(get_the_ID()); ?>
		<section class="featured wrap">
			<a class="featured-card-link" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
				<article <?php post_class('terminal-card'); ?>>
					<div class="terminal-chrome">
						<span class="chrome-dot"></span><span class="chrome-dot"></span><span class="chrome-dot"></span>
						<span class="pinned">● PINNED</span>
					</div>
					<div class="featured-grid<?php echo $featured_has_cover ? ' has-cover' : ' no-cover'; ?>">
						<div class="featured-copy">
							<div class="post-meta-row">
								<?php echo hiraku_terminal_category_tag(get_the_ID(), true, false); ?>
								<span class="meta"><?php echo esc_html(get_the_date('Y/m/d')); ?></span>
							</div>
							<h1 class="featured-title"><?php echo esc_html(get_the_title()); ?></h1>
						</div>
						<?php if ($featured_has_cover) : ?>
							<div class="featured-cover">
								<?php hiraku_terminal_cover(get_the_ID(), '', 'hiraku-terminal-featured'); ?>
							</div>
						<?php endif; ?>
						<div class="featured-tail">
							<p class="featured-excerpt"><?php echo esc_html(hiraku_terminal_excerpt(get_the_ID(), 72)); ?></p>
							<span class="read-more">繼續閱讀 <?php echo hiraku_terminal_icon('arrow-right', 16); ?></span>
						</div>
					</div>
				</article>
			</a>
		</section>
	<?php endif; ?>

	<section class="list-section wrap">
		<div class="section-heading">
			<h2><span class="prompt-accent">$</span> <?php echo $is_front_posts ? 'recent_posts/' : 'results/'; ?></h2>
			<span class="section-rule"></span>
		</div>
		<div class="post-list">
			<?php while (have_posts()) : the_post(); ?>
				<a href="<?php the_permalink(); ?>" <?php post_class('post-row'); ?>>
					<div class="row-meta">
						<span class="row-date"><?php echo esc_html(get_the_date('Y/m/d')); ?></span>
						<span class="row-cat"><?php echo hiraku_terminal_category_tag(get_the_ID(), false, false); ?></span>
					</div>
					<div class="row-body">
						<div class="row-title"><?php echo esc_html(get_the_title()); ?></div>
						<div class="row-excerpt"><?php echo esc_html(hiraku_terminal_excerpt(get_the_ID(), 44)); ?></div>
					</div>
				</a>
			<?php endwhile; ?>
		</div>
		<nav class="pagination" aria-label="分頁">
			<?php
			echo paginate_links(array(
				'prev_text' => '←',
				'next_text' => '→',
			));
			?>
		</nav>
	</section>
<?php else : ?>
	<section class="page-shell">
		<h1 class="page-title"><?php esc_html_e('找不到內容', 'hiraku-terminal'); ?></h1>
		<div class="entry-content">
			<p><?php esc_html_e('這裡目前沒有符合條件的文章。', 'hiraku-terminal'); ?></p>
			<?php get_search_form(); ?>
		</div>
	</section>
<?php endif; ?>

<?php
get_footer();
