<?php

if (!defined('ABSPATH')) {
	exit;
}

define('HIRAKU_TERMINAL_VERSION', '1.0.0');

function hiraku_terminal_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('responsive-embeds');
	add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script'));
	add_theme_support('custom-logo', array(
		'height'      => 192,
		'width'       => 192,
		'flex-height' => true,
		'flex-width'  => true,
	));
	add_image_size('hiraku-terminal-featured', 960, 640, true);
	add_image_size('hiraku-terminal-row', 360, 240, true);

	register_nav_menus(array(
		'primary' => __('Primary Menu', 'hiraku-terminal'),
	));
}
add_action('after_setup_theme', 'hiraku_terminal_setup');

function hiraku_terminal_enqueue_assets() {
	$css = get_stylesheet_directory() . '/style.css';
	$js = get_stylesheet_directory() . '/assets/theme.js';
	wp_enqueue_style(
		'hiraku-terminal-style',
		get_stylesheet_uri(),
		array(),
		file_exists($css) ? filemtime($css) : HIRAKU_TERMINAL_VERSION
	);
	wp_enqueue_script(
		'hiraku-terminal-script',
		get_stylesheet_directory_uri() . '/assets/theme.js',
		array(),
		file_exists($js) ? filemtime($js) : HIRAKU_TERMINAL_VERSION,
		true
	);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'hiraku_terminal_enqueue_assets');

function hiraku_terminal_logo_url() {
	$logo_ids = array(
		get_theme_mod('custom_logo'),
		get_option('site_logo'),
		get_option('jetpack_site_logo'),
	);

	foreach ($logo_ids as $logo_id) {
		$logo_id = (int) $logo_id;

		if (!$logo_id) {
			continue;
		}

		$logo_url = wp_get_attachment_image_url($logo_id, 'thumbnail');

		if ($logo_url) {
			return $logo_url;
		}
	}

	return get_site_icon_url(192);
}

function hiraku_terminal_disable_gravatar_hovercards() {
	if (function_exists('grofiles_get_avatar')) {
		remove_filter('get_avatar', 'grofiles_get_avatar', 10);
	}
	if (function_exists('grofiles_attach_cards')) {
		remove_action('wp_enqueue_scripts', 'grofiles_attach_cards');
	}
	if (function_exists('grofiles_extra_data')) {
		remove_action('wp_footer', 'grofiles_extra_data');
	}
}
add_action('wp', 'hiraku_terminal_disable_gravatar_hovercards', 0);

function hiraku_terminal_dequeue_gravatar_hovercards() {
	wp_dequeue_script('grofiles-cards');
	wp_dequeue_script('wpgroho');
}
add_action('wp_enqueue_scripts', 'hiraku_terminal_dequeue_gravatar_hovercards', 100);

function hiraku_terminal_comment_form_defaults($defaults) {
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$defaults['logged_in_as'] = sprintf(
		'<p class="logged-in-as">%s %s</p>',
		sprintf(
			esc_html__('目前登入身分為「%s」', 'hiraku-terminal'),
			esc_html($user_identity)
		),
		wp_required_field_message()
	);

	return $defaults;
}
add_filter('comment_form_defaults', 'hiraku_terminal_comment_form_defaults');

function hiraku_terminal_comment_datetime_separator($translation, $text, $domain) {
	if ('default' === $domain && '%1$s at %2$s' === $text) {
		return '%1$s %2$s';
	}

	return $translation;
}
add_filter('gettext', 'hiraku_terminal_comment_datetime_separator', 10, 3);

function hiraku_terminal_icon($name, $size = 20) {
	$paths = array(
		'search' => '<circle cx="11" cy="11" r="7" /><path d="M21 21l-4.3-4.3" />',
		'terminal' => '<path d="M4 17l6-6-6-6" /><path d="M12 19h8" />',
		'arrow-right' => '<path d="M5 12h14" /><path d="M13 5l7 7-7 7" />',
		'arrow-up-right' => '<path d="M7 17L17 7" /><path d="M7 7h10v10" />',
		'chevron-down' => '<path d="M6 9l6 6 6-6" />',
		'clock' => '<circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" />',
		'calendar' => '<rect x="3" y="4" width="18" height="17" rx="2" /><path d="M3 9h18M8 2v4M16 2v4" />',
		'folder' => '<path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />',
		'menu' => '<path d="M3 6h18M3 12h18M3 18h18" />',
		'rss' => '<path d="M4 11a9 9 0 0 1 9 9M4 4a16 16 0 0 1 16 16" /><circle cx="5" cy="19" r="1.5" />',
	);

	$brands = array(
		'github' => '<path fill="currentColor" stroke="none" d="M12 .5C5.37.5 0 5.87 0 12.5c0 5.3 3.44 9.8 8.21 11.39.6.11.82-.26.82-.58l-.01-2.03c-3.34.73-4.04-1.61-4.04-1.61-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.73.08-.73 1.2.09 1.84 1.24 1.84 1.24 1.07 1.83 2.81 1.3 3.5.99.11-.78.42-1.3.76-1.6-2.67-.3-5.47-1.34-5.47-5.95 0-1.31.47-2.39 1.24-3.23-.13-.3-.54-1.52.11-3.18 0 0 1.01-.32 3.3 1.23a11.5 11.5 0 0 1 6 0c2.29-1.55 3.3-1.23 3.3-1.23.65 1.66.24 2.88.12 3.18.77.84 1.23 1.92 1.23 3.23 0 4.62-2.81 5.64-5.49 5.94.43.37.81 1.1.81 2.22l-.01 3.29c0 .32.22.7.83.58A12.01 12.01 0 0 0 24 12.5C24 5.87 18.63.5 12 .5z" />',
		'facebook' => '<path fill="currentColor" stroke="none" d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07c0 6.02 4.39 11.01 10.13 11.93v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.69.24 2.69.24v2.97h-1.52c-1.49 0-1.96.93-1.96 1.89v2.25h3.33l-.53 3.49h-2.8V24C19.61 23.08 24 18.09 24 12.07z" />',
	);

	$is_brand = isset($brands[$name]);
	$body = $is_brand ? $brands[$name] : ($paths[$name] ?? '');

	if (!$body) {
		return '';
	}

	return sprintf(
		'<svg width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="%2$s" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%3$s</svg>',
		(int) $size,
		$is_brand ? 'none' : 'currentColor',
		$body
	);
}

function hiraku_terminal_page_url($slug) {
	$page = get_page_by_path($slug);
	return $page ? get_permalink($page) : home_url('/' . trim($slug, '/') . '/');
}

function hiraku_terminal_category_menu_order() {
	return array(
		'parents' => array(
			'tutorial',
			'experience',
			'news',
			'crypto',
			'announcement'
		),
		'children' => array(
			'news' => array(
				'ios-news',
				'macos-news',
				'apple-product-news',
				'jailbreak-news',
				'software-news',
				'other-news',
			),
			'tutorial' => array(
				'development',
				'tech-research',
				'linux-tutorial',
				'ios-tutorial',
				'macos-tutorial',
				'software-tutorial',
				'jailbreak-tutorial',
				'wordpress-tutorial',
				'other-tutorial',
			),
			'experience' => array(
				'usage-experience',
				'life-experience',
				'music-experience',
				'game',
			),
		),
	);
}

function hiraku_terminal_sort_terms_by_slug_order($terms, $slug_order) {
	if (!$terms || !$slug_order) {
		return $terms;
	}

	$positions = array_flip($slug_order);

	usort($terms, function ($a, $b) use ($positions) {
		$a_position = $positions[$a->slug] ?? PHP_INT_MAX;
		$b_position = $positions[$b->slug] ?? PHP_INT_MAX;

		if ($a_position === $b_position) {
			return $a->term_id <=> $b->term_id;
		}

		return $a_position <=> $b_position;
	});

	return $terms;
}

function hiraku_terminal_category_groups() {
	$menu_order = hiraku_terminal_category_menu_order();
	$parents = get_terms(array(
		'taxonomy' => 'category',
		'parent' => 0,
		'hide_empty' => false,
		'orderby' => 'term_id',
		'order' => 'ASC',
	));

	if (is_wp_error($parents) || !$parents) {
		return array();
	}

	$parents = hiraku_terminal_sort_terms_by_slug_order($parents, $menu_order['parents'] ?? array());
	$groups = array();

	foreach ($parents as $parent) {
		if ('uncategorized' === $parent->slug) {
			continue;
		}

		$children = get_terms(array(
			'taxonomy' => 'category',
			'parent' => $parent->term_id,
			'hide_empty' => false,
			'orderby' => 'term_id',
			'order' => 'ASC',
		));

		if (is_wp_error($children)) {
			$children = array();
		}

		$children = hiraku_terminal_sort_terms_by_slug_order($children, $menu_order['children'][$parent->slug] ?? array());

		if (!$children && 0 === (int) $parent->count) {
			continue;
		}

		$groups[] = array(
			'key' => 'cat-' . $parent->term_id,
			'label' => $parent->name,
			'term' => $parent,
			'children' => $children,
		);
	}

	return $groups;
}

function hiraku_terminal_category_total_count($term) {
	$term = is_object($term) ? $term : get_term($term, 'category');

	if (!$term || is_wp_error($term)) {
		return 0;
	}

	$count = (int) $term->count;
	$children = get_term_children($term->term_id, 'category');

	if (!is_wp_error($children)) {
		foreach ($children as $child_id) {
			$child = get_term($child_id, 'category');
			if ($child && !is_wp_error($child)) {
				$count += (int) $child->count;
			}
		}
	}

	return $count;
}

function hiraku_terminal_category_color($term = null) {
	if (!$term) {
		return '#5eead4';
	}

	if (is_object($term) && !empty($term->parent)) {
		$palette = array(
			'#5eead4',
			'#f472b6',
			'#f6c177',
			'#7aa2f7',
			'#a3e635',
			'#a371f7',
			'#f7a072',
			'#22d3ee',
			'#fb7185',
			'#34d399',
			'#facc15',
			'#c084fc',
		);
		$siblings = get_terms(array(
			'taxonomy' => 'category',
			'parent' => $term->parent,
			'hide_empty' => false,
			'orderby' => 'term_id',
			'order' => 'ASC',
		));

		if (!is_wp_error($siblings) && $siblings) {
			$menu_order = hiraku_terminal_category_menu_order();
			$parent = get_term($term->parent, 'category');
			$siblings = hiraku_terminal_sort_terms_by_slug_order($siblings, $menu_order['children'][$parent->slug] ?? array());

			foreach ($siblings as $index => $sibling) {
				if ((int) $sibling->term_id === (int) $term->term_id) {
					return $palette[$index % count($palette)];
				}
			}
		}
	}

	$name = is_object($term) ? $term->name : (string) $term;
	$slug = is_object($term) ? $term->slug : sanitize_title($name);
	$haystack = strtolower($slug . ' ' . $name);

	if (str_contains($haystack, 'life') || str_contains($haystack, '生活')) {
		return '#f6c177';
	}
	if (str_contains($haystack, 'usage') || str_contains($haystack, '產品')) {
		return '#5eead4';
	}
	if (str_contains($haystack, 'apple') || str_contains($haystack, 'macos') || str_contains($haystack, 'ios')) {
		return '#7aa2f7';
	}
	if (str_contains($haystack, 'crypto') || str_contains($haystack, '加密')) {
		return '#f7a072';
	}
	if (str_contains($haystack, 'jailbreak') || str_contains($haystack, '越獄')) {
		return '#a371f7';
	}
	if (str_contains($haystack, 'dev') || str_contains($haystack, 'tech') || str_contains($haystack, '開發') || str_contains($haystack, '技術')) {
		return '#34d399';
	}

	return '#5eead4';
}

function hiraku_terminal_primary_category($post_id = null) {
	$post_id = $post_id ?: get_the_ID();
	$categories = get_the_category($post_id);

	if (!$categories) {
		return null;
	}

	$category_ids = array_map('intval', wp_list_pluck($categories, 'term_id'));
	$primary_meta_keys = array(
		'_yoast_wpseo_primary_category',
		'rank_math_primary_category',
		'_rank_math_primary_category',
		'_aioseo_primary_category',
	);

	foreach ($primary_meta_keys as $meta_key) {
		$primary_id = (int) get_post_meta($post_id, $meta_key, true);

		if ($primary_id && in_array($primary_id, $category_ids, true)) {
			$primary_category = get_category($primary_id);

			if ($primary_category && !is_wp_error($primary_category)) {
				return $primary_category;
			}
		}
	}

	foreach ($categories as $category) {
		if ('uncategorized' !== $category->slug) {
			return $category;
		}
	}

	return $categories[0];
}

function hiraku_terminal_category_tag($post_id = null, $large = false, $linked = true) {
	$category = hiraku_terminal_primary_category($post_id);

	if (!$category) {
		return '';
	}

	$color = hiraku_terminal_category_color($category);
	$class = 'post-tag' . ($large ? ' is-large' : '');

	$tag = $linked ? 'a' : 'span';
	$href = $linked ? ' href="' . esc_url(get_category_link($category)) . '"' : '';

	return sprintf(
		'<%1$s class="%2$s"%3$s style="--cat:%4$s"><span class="tag-dot"></span>%5$s</%1$s>',
		$tag,
		esc_attr($class),
		$href,
		esc_attr($color),
		esc_html($category->name)
	);
}

function hiraku_terminal_category_tags($post_id = null, $large = false, $linked = true) {
	$post_id = $post_id ?: get_the_ID();
	$categories = get_the_category($post_id);

	if (!$categories) {
		return '';
	}

	$tags = array();
	$primary_category = hiraku_terminal_primary_category($post_id);
	$ordered_categories = array();

	if ($primary_category) {
		foreach ($categories as $category) {
			if ((int) $category->term_id === (int) $primary_category->term_id) {
				$ordered_categories[] = $category;
				break;
			}
		}
	}

	foreach ($categories as $category) {
		if ($primary_category && (int) $category->term_id === (int) $primary_category->term_id) {
			continue;
		}

		$ordered_categories[] = $category;
	}

	foreach ($ordered_categories as $category) {
		if ('uncategorized' === $category->slug) {
			continue;
		}

		$color = hiraku_terminal_category_color($category);
		$class = 'post-tag' . ($large ? ' is-large' : '');
		$tag = $linked ? 'a' : 'span';
		$href = $linked ? ' href="' . esc_url(get_category_link($category)) . '"' : '';

		$tags[] = sprintf(
			'<%1$s class="%2$s"%3$s style="--cat:%4$s"><span class="tag-dot"></span>%5$s</%1$s>',
			$tag,
			esc_attr($class),
			$href,
			esc_attr($color),
			esc_html($category->name)
		);
	}

	return implode('', $tags);
}

function hiraku_terminal_category_browser($mobile = false) {
	$groups = hiraku_terminal_category_groups();

	if (!$groups) {
		return;
	}

	$classes = 'category-browser' . ($mobile ? ' is-mobile' : '');
	?>
	<div class="<?php echo esc_attr($classes); ?>">
		<div class="category-master">
			<?php foreach ($groups as $index => $group) : ?>
				<?php $child_count = count($group['children']); ?>
				<a class="category-parent<?php echo 0 === $index ? ' is-active' : ''; ?>" href="<?php echo esc_url(get_category_link($group['term'])); ?>" data-category-target="<?php echo esc_attr($group['key']); ?>" data-has-children="<?php echo $child_count ? 'true' : 'false'; ?>" aria-expanded="<?php echo 0 === $index ? 'true' : 'false'; ?>">
					<?php echo hiraku_terminal_icon('folder', 15); ?>
					<span class="category-parent-label"><?php echo esc_html($group['label']); ?></span>
					<span class="category-count"><?php echo esc_html($child_count ? $child_count : 1); ?></span>
					<span class="category-arrow">›</span>
				</a>
			<?php endforeach; ?>
		</div>
		<div class="category-details">
			<?php foreach ($groups as $index => $group) : ?>
				<section class="category-detail<?php echo 0 === $index ? ' is-active' : ''; ?>" data-category-detail="<?php echo esc_attr($group['key']); ?>">
					<?php if ($mobile) : ?>
						<button class="category-back" type="button">← 全部分類 <span>/ <?php echo esc_html($group['label']); ?></span></button>
					<?php endif; ?>
					<div class="category-path">
						<a class="category-path-link" href="<?php echo esc_url(get_category_link($group['term'])); ?>">
							<span class="prompt-accent">~/categories/</span><?php echo esc_html($group['label']); ?>
						</a>
					</div>
					<ul class="category-list">
						<?php if (!$group['children']) : ?>
							<li class="category-item is-self">
								<a href="<?php echo esc_url(get_category_link($group['term'])); ?>" style="--cat:<?php echo esc_attr(hiraku_terminal_category_color($group['term'])); ?>">
									<span class="category-dot"></span>
									<span><?php echo esc_html($group['label']); ?></span>
									<span class="category-count"><?php echo esc_html(hiraku_terminal_category_total_count($group['term'])); ?></span>
								</a>
							</li>
						<?php endif; ?>
						<?php foreach ($group['children'] as $category) : ?>
							<li class="category-item">
								<a href="<?php echo esc_url(get_category_link($category)); ?>" style="--cat:<?php echo esc_attr(hiraku_terminal_category_color($category)); ?>">
									<span class="category-dot"></span>
									<span><?php echo esc_html($category->name); ?></span>
									<span class="category-count"><?php echo esc_html(hiraku_terminal_category_total_count($category)); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

function hiraku_terminal_local_url($url) {
	if (!$url) {
		return '';
	}

	$site = untrailingslashit(site_url());
	$url = preg_replace('#https?://(www\.)?hiraku\.dev#i', $site, $url);
	return $url;
}

function hiraku_terminal_post_image_url($post_id = null, $size = 'large') {
	$post_id = $post_id ?: get_the_ID();
	$url = get_the_post_thumbnail_url($post_id, $size);

	return hiraku_terminal_local_url($url);
}

function hiraku_terminal_has_cover($post_id = null) {
	$post_id = $post_id ?: get_the_ID();
	return (bool) get_post_thumbnail_id($post_id);
}

function hiraku_terminal_cover($post_id = null, $class = '', $size = 'large') {
	$post_id = $post_id ?: get_the_ID();
	$category = hiraku_terminal_primary_category($post_id);
	$color = hiraku_terminal_category_color($category);
	$url = hiraku_terminal_post_image_url($post_id, $size);
	$title = get_the_title($post_id);
	$classes = trim('post-cover ' . $class);

	if (!$url) {
		return false;
	}

	echo '<span class="' . esc_attr($classes) . '" style="--cat:' . esc_attr($color) . '">';
	echo '<img src="' . esc_url($url) . '" alt="' . esc_attr($title) . '" loading="lazy">';
	echo '</span>';

	return true;
}

function hiraku_terminal_excerpt($post_id = null, $length = 110) {
	$post_id = $post_id ?: get_the_ID();
	if (has_excerpt($post_id)) {
		$excerpt = get_the_excerpt($post_id);
	} else {
		$content = get_post_field('post_content', $post_id);
		$extended = get_extended($content);
		$excerpt = wp_strip_all_tags(strip_shortcodes($extended['main'] ?: $content));
	}

	$excerpt = preg_replace('/\s+/u', ' ', trim($excerpt));
	return wp_trim_words($excerpt, $length, '…');
}

function hiraku_terminal_post_count() {
	$count = wp_count_posts('post');
	return isset($count->publish) ? (int) $count->publish : 0;
}
