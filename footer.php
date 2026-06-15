<?php
if (!defined('ABSPATH')) {
	exit;
}
?>
	</main>
	<footer class="site-footer">
		<div class="footer-main">
			<span class="footer-line">© 2010–<?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?> · <?php echo esc_html(get_bloginfo('description')); ?></span>
			<div class="footer-socials" aria-label="社群連結">
				<a class="icon-button" href="https://github.com/hirakujira" aria-label="GitHub"><?php echo hiraku_terminal_icon('github', 19); ?></a>
				<a class="icon-button" href="https://www.facebook.com/hiraku.tw" aria-label="Facebook"><?php echo hiraku_terminal_icon('facebook', 19); ?></a>
			</div>
		</div>
		<span class="footer-line footer-note">開站至今 <?php echo esc_html(number_format_i18n((int) ceil((time() - strtotime('2010-03-12')) / DAY_IN_SECONDS))); ?> 天</span>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
