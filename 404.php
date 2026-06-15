<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<section class="page-shell">
	<div class="breadcrumb"><span class="prompt-accent">~</span><span>/</span><span>404</span></div>
	<h1 class="page-title"><?php esc_html_e('找不到這頁', 'hiraku-terminal'); ?></h1>
	<div class="entry-content">
		<p><?php esc_html_e('這條路徑目前沒有對應的內容。你可以回首頁，或直接搜尋文章。', 'hiraku-terminal'); ?></p>
		<?php get_search_form(); ?>
	</div>
</section>
<?php
get_footer();
