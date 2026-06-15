<?php
if (!defined('ABSPATH')) {
	exit;
}

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php echo esc_attr(get_bloginfo('charset')); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="color-scheme" content="dark">
	<meta name="theme-color" content="#07100e">
	<style>
		html {
			background: #07100e;
			color-scheme: dark;
		}

		body {
			margin: 0;
			background: #07100e;
			color: #e9edf2;
		}
	</style>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site-shell">
	<a class="skip-link" href="#main">跳至主要內容</a>
	<header class="command-bar">
		<div class="command-inner">
				<a class="brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
					<?php $brand_logo_url = hiraku_terminal_logo_url(); ?>
					<span class="brand-mark">
						<?php if ($brand_logo_url) : ?>
							<img src="<?php echo esc_url($brand_logo_url); ?>" alt="" width="30" height="30">
						<?php else : ?>
							<span class="brand-mark-fallback" aria-hidden="true">H</span>
						<?php endif; ?>
					</span>
					<span class="brand-text">hiraku<span>.dev</span></span>
				</a>

			<nav class="command-nav" aria-label="主要選單">
				<a class="command-link" href="<?php echo esc_url(home_url('/')); ?>">首頁</a>
				<a class="command-link" href="<?php echo esc_url(hiraku_terminal_page_url('about')); ?>">關於</a>
				<a class="command-link" href="<?php echo esc_url(hiraku_terminal_page_url('works')); ?>">作品集</a>
				<a class="command-link" href="<?php echo esc_url(hiraku_terminal_page_url('guestbook')); ?>">訪客留言</a>
				<details class="category-menu">
					<summary>分類 <?php echo hiraku_terminal_icon('chevron-down', 13); ?></summary>
					<div class="mega-panel">
						<div class="mega-kicker"><span class="prompt-accent">$</span> ls ~/categories</div>
						<?php hiraku_terminal_category_browser(false); ?>
					</div>
				</details>
			</nav>

			<div class="header-spacer"></div>
			<?php get_search_form(); ?>
			<div class="socials" aria-label="社群連結">
				<a class="social-link" href="https://github.com/hirakujira" aria-label="GitHub"><?php echo hiraku_terminal_icon('github', 19); ?></a>
				<a class="social-link" href="https://www.facebook.com/hiraku.tw" aria-label="Facebook"><?php echo hiraku_terminal_icon('facebook', 19); ?></a>
				<a class="social-link" href="<?php echo esc_url(get_feed_link()); ?>" aria-label="RSS"><?php echo hiraku_terminal_icon('rss', 18); ?></a>
			</div>

			<div class="mobile-controls">
				<details class="mobile-search">
					<summary class="icon-button" aria-label="搜尋"><?php echo hiraku_terminal_icon('search', 17); ?></summary>
					<div class="mobile-search-panel">
						<?php get_search_form(); ?>
					</div>
				</details>
				<details class="mobile-menu">
					<summary class="icon-button" aria-label="開啟選單"><?php echo hiraku_terminal_icon('menu', 18); ?></summary>
					<div class="mobile-panel">
						<nav aria-label="手機選單">
							<a class="command-link<?php echo (is_home() || is_front_page()) ? ' is-active' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>">首頁</a>
							<a class="command-link<?php echo is_page('about') ? ' is-active' : ''; ?>" href="<?php echo esc_url(hiraku_terminal_page_url('about')); ?>">關於</a>
							<a class="command-link<?php echo is_page('works') ? ' is-active' : ''; ?>" href="<?php echo esc_url(hiraku_terminal_page_url('works')); ?>">作品集</a>
							<a class="command-link<?php echo is_page('guestbook') ? ' is-active' : ''; ?>" href="<?php echo esc_url(hiraku_terminal_page_url('guestbook')); ?>">訪客留言</a>
						</nav>
						<div class="mobile-panel-label">分類</div>
						<div class="mobile-cats">
							<?php hiraku_terminal_category_browser(true); ?>
						</div>
					</div>
				</details>
			</div>
		</div>
	</header>
	<main id="main" class="main">
