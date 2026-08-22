<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();

$okx_category = hiraku_terminal_okx_category();
$okx_cover_url = hiraku_terminal_okx_cover_url();
$okx_description = $okx_category ? wp_strip_all_tags(term_description($okx_category->term_id, 'category')) : '';

if (!$okx_description) {
	$okx_description = 'OKX 交易所的開戶、法幣出入金、OKX Card 回饋等實用教學與心得，集中在這裡。';
}

$article_types = hiraku_terminal_okx_article_types();
$filter_types = array(
	'all' => '所有文章',
	'beginner' => $article_types['beginner'],
	'funding' => $article_types['funding'],
	'trading' => $article_types['trading'],
	'rewards' => $article_types['rewards'],
);
$selected_type = hiraku_terminal_okx_requested_article_type();
$okx_url = $okx_category ? get_category_link($okx_category) : '';
global $wp_query;
$okx_total_pages = (int) $wp_query->max_num_pages;

function hiraku_terminal_okx_article_row($post, $article_types) {
	setup_postdata($post);
	$type = hiraku_terminal_okx_article_type($post->ID);
	?>
	<a href="<?php echo esc_url(get_permalink($post)); ?>" <?php post_class('post-row okx-article-row', $post); ?> data-okx-article-type="<?php echo esc_attr($type); ?>">
		<div class="row-meta">
			<span class="row-date"><?php echo esc_html(get_the_date('Y/m/d', $post)); ?></span>
			<span class="row-cat"><span class="okx-article-type"><?php echo esc_html($article_types[$type]); ?></span></span>
		</div>
		<div class="row-body">
			<div class="row-title"><?php echo esc_html(get_the_title($post)); ?></div>
			<div class="row-excerpt"><?php echo esc_html(hiraku_terminal_excerpt($post->ID, 44)); ?></div>
		</div>
	</a>
	<?php
}
?>

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

<section class="okx-collection wrap">
	<div class="okx-collection-toolbar">
		<div class="okx-filter-buttons" role="group" aria-label="篩選 OKX 文章">
			<?php foreach ($filter_types as $type => $label) : ?>
				<?php
				$filter_url = 'all' === $type ? $okx_url : add_query_arg('okx_type', $type, $okx_url);
				$is_active = $type === ($selected_type ?: 'all');
				?>
				<a class="okx-filter-button<?php echo $is_active ? ' is-active' : ''; ?>" href="<?php echo esc_url($filter_url); ?>"<?php echo $is_active ? ' aria-current="page"' : ''; ?>><?php echo esc_html($label); ?></a>
			<?php endforeach; ?>
		</div>
	</div>

	<?php if (!have_posts()) : ?>
		<div class="entry-content okx-empty-state">
			<p><?php esc_html_e('這裡目前沒有 OKX 文章。', 'hiraku-terminal'); ?></p>
		</div>
	<?php else : ?>
		<div class="post-list">
			<?php while (have_posts()) : the_post(); ?>
				<?php hiraku_terminal_okx_article_row(get_post(), $article_types); ?>
			<?php endwhile; ?>
		</div>
		<?php if ($okx_total_pages > 1) : ?>
			<nav class="pagination" aria-label="分頁">
				<?php
				echo paginate_links(array(
					'prev_text' => '←',
					'next_text' => '→',
					'add_args' => $selected_type ? array('okx_type' => $selected_type) : false,
				));
				?>
			</nav>
		<?php endif; ?>
	<?php endif; ?>

	<div class="okx-back-home">
		<a href="<?php echo esc_url(home_url('/')); ?>">← 回首頁</a>
	</div>
</section>

<?php
get_footer();
