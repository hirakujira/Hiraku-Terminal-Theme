<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();

$is_front_posts = is_home() && !is_paged() && !is_search() && !is_archive();
$is_okx_archive = is_category('okx');
$post_count = hiraku_terminal_post_count();
$site_description = get_bloginfo('description', 'display');
$okx_category = hiraku_terminal_okx_category();
$okx_url = $okx_category ? get_category_link($okx_category) : '';
$okx_cover_url = hiraku_terminal_okx_cover_url();
$okx_description = $okx_category ? wp_strip_all_tags(term_description($okx_category->term_id, 'category')) : '';

if (!$okx_description) {
	$okx_description = 'OKX 交易所的開戶、法幣出入金、OKX Card 回饋等實用教學與心得，集中在這裡。';
}
?>

<?php if ($is_front_posts) : ?>
	<div class="status-line">
		<span class="prompt-accent"><?php echo esc_html($site_description); ?></span>
		<span>:</span>
		<span style="color:#7aa2f7">~/posts</span>
		<span>$ ls -lt</span>
		<span class="status-muted"># <?php echo esc_html(number_format_i18n($post_count)); ?> 篇文章 · since 2010</span>
	</div>
	<?php if ($okx_category && !is_wp_error($okx_url)) : ?>
		<section class="okx-promo wrap">
			<a class="okx-promo-link" href="<?php echo esc_url($okx_url); ?>" aria-label="進入 OKX 專區">
				<span class="okx-media okx-promo-media">
					<?php if ($okx_cover_url) : ?>
						<img src="<?php echo esc_url($okx_cover_url); ?>" alt="">
					<?php else : ?>
						<span class="okx-cover-fallback" aria-hidden="true">OKX</span>
					<?php endif; ?>
				</span>
				<span class="okx-promo-copy">
					<span class="okx-promo-meta">
						<span class="okx-collection-label">專區 · COLLECTION</span>
						<span class="okx-path">$ cd ~/okx/</span>
					</span>
					<span class="okx-promo-title">OKX 專區</span>
					<span class="okx-promo-description">開戶、法幣出入金、OKX Card 回饋，相關文章一次看懂</span>
				</span>
				<span class="okx-promo-action">進入專區 <?php echo hiraku_terminal_icon('arrow-right', 16); ?></span>
			</a>
		</section>
	<?php endif; ?>
<?php elseif ($is_okx_archive) : ?>
	<header class="okx-archive-header wrap">
		<div class="okx-archive-card">
			<div class="terminal-chrome">
				<span class="chrome-dot"></span><span class="chrome-dot"></span><span class="chrome-dot"></span>
				<span class="okx-terminal-path">~/okx</span>
			</div>
			<div class="okx-archive-copy">
				<span class="okx-media okx-archive-media">
					<?php if ($okx_cover_url) : ?>
						<img src="<?php echo esc_url($okx_cover_url); ?>" alt="">
					<?php else : ?>
						<span class="okx-cover-fallback" aria-hidden="true">OKX</span>
					<?php endif; ?>
				</span>
				<div>
					<h1>OKX 專區</h1>
					<p><?php echo esc_html($okx_description); ?></p>
				</div>
			</div>
		</div>
	</header>
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
			<h2><span class="prompt-accent">$</span> <?php echo $is_front_posts ? 'recent_posts/' : ($is_okx_archive ? 'ls ~/okx/' : 'results/'); ?></h2>
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
		<?php if ($is_okx_archive) : ?>
			<div class="okx-back-home">
				<a href="<?php echo esc_url(home_url('/')); ?>">← 回首頁</a>
			</div>
		<?php endif; ?>
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
