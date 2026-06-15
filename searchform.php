<?php
if (!defined('ABSPATH')) {
	exit;
}
?>
<form role="search" method="get" class="search-form header-search" action="<?php echo esc_url(home_url('/')); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x('搜尋：', 'label', 'hiraku-terminal'); ?></span>
		<input type="search" class="search-field" placeholder="搜尋文章" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
	</label>
	<button type="submit" class="search-submit" aria-label="<?php echo esc_attr_x('搜尋', 'submit button', 'hiraku-terminal'); ?>"><?php echo hiraku_terminal_icon('search', 15); ?></button>
</form>
