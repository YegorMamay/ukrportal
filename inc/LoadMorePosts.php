<?php

if (!class_exists('LoadMorePosts')) {
    /**
     * Class LoadMorePosts
     */
    class LoadMorePosts
    {
        /**
         * LoadMorePosts constructor.
         */
        public function __construct()
        {
            add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
            add_action('customize_register', [$this, 'customizeRegister']);

            if (wp_doing_ajax()) {
                add_action('wp_ajax_load_more_posts', [$this, 'ajaxCallback']);
                add_action('wp_ajax_nopriv_load_more_posts', [$this, 'ajaxCallback']);
            }
        }

        /**
         * Enqueue a script
         */
        public function enqueueScripts()
        {
            $condition = is_front_page() || is_home() || is_archive();

            wp_enqueue_script('brainworks-js', get_template_directory_uri() . '/assets/js/brainworks.js', ['jquery'],
                null, true);

            if (get_theme_mod('bw_load_more_enable') && $condition) {
                wp_localize_script('brainworks-js', 'jpAjax', [
                    'action' => 'load_more_posts',
                    'nonce' => wp_create_nonce('load_more_posts_action'),
                    'url' => admin_url('admin-ajax.php'),
                ]);
            }
        }

        /**
         * Customize
         *
         * @param $wp_customize WP_Customize_Manager
         * @return void
         */
        public function customizeRegister($wp_customize)
        {
            // Section Load More
            $wp_customize->add_section('bw_load_more', [
                'title' => 'Load More',
                'description' => 'If this function enabled, the pagination will ignore.',
                'panel' => 'bw_theme_options',
            ]);

            $wp_customize->add_setting('bw_load_more_enable', [
                'default' => false,
                'sanitize_callback' => 'wp_validate_boolean',
            ]);

            $wp_customize->add_control('bw_load_more_enable', [
                'label' => 'Enable/Disable',
                'section' => 'bw_load_more',
                'settings' => 'bw_load_more_enable',
                'type' => 'checkbox',
            ]);
        }

        /**
         * Fires Ajax actions for users.
         */
        public function ajaxCallback()
        {
            check_ajax_referer('load_more_posts_action', 'nonce');

            $paged = empty($_POST['paged']) ? 1 : $_POST['paged'] + 1;

            $args = [
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => get_option('posts_per_page'),
                'order' => 'DESC', // ASC, DESC
                'orderby' => 'date',
                'paged' => $paged,
            ];

            $query = new WP_Query($args);

            $posts = '';

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    $posts .= '
                    <div class="container-fluid">
                        <div class="row">
                            <article id="post-' . get_the_ID() . '" class="row">
                                <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                    <div>' . get_the_post_thumbnail(null, 'large') . '</div>
                                       <div class="sp-xs-3 sp-sm-0"></div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-7 col-lg-7 col-xl-7">
                                    <div class="post-caption">
                                        <span class="post-caption__item">' . get_the_category_list(' ') . '</span>
                                        <span class="post-caption__date">' . get_the_date('d-m-Y') . '</span>
                                    </div>
                                    <div class="post-headers"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>
                                    <div class="sp-xs-1"></div>
                                    <div class="post-description"><p>' . get_the_excerpt() . '</p></div>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="sp-xs-6"></div>
                    ';
                }

                wp_reset_postdata();
            }

            wp_send_json_success($posts, 200);
        }
    }

    new LoadMorePosts();
}

if (!function_exists('bw_load_more')) {
    /**
     * Load More HTML Markup
     *
     * @return void
     */
    function bw_load_more()
    {
        /** @var WP_Query $wp_query */
        global $wp_query;

        $total = isset($wp_query->max_num_pages) ? intval($wp_query->max_num_pages) : 1;

        $output = sprintf(
            '<button class="btn btn-secondary js-load-more" type="button">%s</button>',
            __('Load more posts...', 'brainworks')
        );

        if ($total < 2) {
            return;
        }

        echo $output;
    }
}
