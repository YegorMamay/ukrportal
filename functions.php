<?php
/**
 * All the functions are in the PHP pages in the `inc/` folder.
 */

//show_admin_bar(false);

require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/auth.php';
require get_template_directory() . '/inc/admin.php';
require get_template_directory() . '/inc/login.php';
require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/cleanup.php';
require get_template_directory() . '/inc/custom-logo.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enqueues.php';
require get_template_directory() . '/inc/navbar.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/index-pagination.php';
require get_template_directory() . '/inc/split-post-pagination.php';
require get_template_directory() . '/inc/feedback.php';
require get_template_directory() . '/inc/shortcodes.php';
require get_template_directory() . '/inc/meta-boxes.php';
require get_template_directory() . '/inc/custom-post-types.php';

require get_template_directory() . '/inc/LoadMorePosts.php';

add_action( 'after_setup_theme', function () {
	if ( function_exists( 'pll_register_string' ) ) {
		pll_register_string( 'email', 'Email', 'Brainworks' );
		pll_register_string( 'address', 'Address', 'Brainworks' );
		pll_register_string( 'work-schedule', 'Work Schedule', 'Brainworks' );

		pll_register_string( 'social-vk', 'Vk', 'Brainworks' );
		pll_register_string( 'social-twitter', 'Twitter', 'Brainworks' );
		pll_register_string( 'social-youtube', 'YouTube', 'Brainworks' );
		pll_register_string( 'social-facebook', 'Facebook', 'Brainworks' );
		pll_register_string( 'social-linkedin', 'Linkedin', 'Brainworks' );
		pll_register_string( 'social-instagram', 'Instagram', 'Brainworks' );
		pll_register_string( 'social-google-plus', 'Google Plus', 'Brainworks' );
		pll_register_string( 'social-odnoklassniki', 'Odnoklassniki', 'Brainworks' );
		pll_register_string( 'news-title', 'news-title', 'Brainworks' );
	}
} );

remove_action( 'wp_head', '_wp_render_title_tag', 1 ); //удаляет тег title из header.php


// Добавляет возможность задавать картинку для категорий кастомного поста Каталог, при включеном плагине ACF
if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array(
	'key' => 'group_5e6f1fdcc01d8',
	'title' => 'Category',
	'fields' => array(
		array(
			'key' => 'field_5e6f1fe7970b7',
			'label' => 'Изображение',
			'name' => 'cat_img',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'all',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));
endif;

//WOOCOMMERCE
// Изменяет порядок артикула по отношению к другим элементам на странице товара
//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15 );

//Изменение перевода
add_filter('gettext', 'translate_text');
add_filter('ngettext', 'translate_text');
 
function translate_text($translated) {
$translated = str_ireplace('Подытог', 'Итого', $translated);
return $translated;
}


if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Настройки баннера',
        'menu_title'	=> 'Настройки баннера',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

    foreach (['uk', 'en', 'sk'] as $lang) {

        acf_add_options_sub_page([
            'page_title' => "Баннер $lang",
            'menu_title' => __("Баннер $lang", 'Brainworks'),
            'menu_slug' => "banner-${lang}",
            'post_id' => $lang,
            'parent' => 'theme-general-settings',
            'capability'	=> 'edit_posts',
            'redirect'		=> false,
        ]);

    }
}

function widget_nav_args( $nav_menu_args, $nav_menu, $args, $instance) {

    if( $args['id'] === 'footer-widget-area' ) {
        return array_merge( $nav_menu_args, array(
            'depth' => 1
        ) );
    }

    return $nav_menu_args;
}

add_filter('widget_nav_menu_args', 'widget_nav_args', 10, 4);
