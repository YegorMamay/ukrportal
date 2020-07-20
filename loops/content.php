<?php if (have_posts()): ?>
    <div class="js-ajax-posts">
        <?php while (have_posts()): the_post(); ?>
                    <article id="post_<?php the_ID() ?>" class="row">
                        <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                            <?php the_post_thumbnail('large'); ?>
                            <div class="sp-xs-3 sp-sm-0"></div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-7 col-lg-7 col-xl-7">
                                <div class="post-caption">
                                    <span class="post-caption__item">
                                        <?php the_category(' '); ?>
                                    </span>
                                    <span class="post-caption__date">
                                         <?php echo the_time('d-m-Y'); ?>
                                    </span>
                                </div>
                                <div class="post-headers"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></div>
                                <div class="sp-xs-1"></div>
                                <div class="post-description"><?php the_excerpt(); ?></div>
                        </div>
                    </article>
                    <div class="sp-xs-6"></div>
        <?php endwhile; ?>
    </div>

    <?php if (get_theme_mod('bw_load_more_enable') && function_exists('bw_load_more')) { ?>
        <div class="text-center"><?php bw_load_more(); ?></div>
        <div class="sp-xs-6"></div>
    <?php } else {
        if (function_exists('bw_pagination')) {
            bw_pagination();
        } else {
            if (is_paged()) { ?>
                <ul class="pagination">
                    <li class="older"><?php next_posts_link('<i class="fa fa-arrow-left"></i> ' . __('Previous', 'brainworks')) ?></li>
                    <li class="newer"><?php previous_posts_link(__('Next', 'brainworks') . ' <i class="fa fa-arrow-right"></i>') ?></li>
                </ul>
            <?php }
        }
    } ?>

<?php else : ?>
    <?php get_template_part('loops/content', 'none'); ?>
<?php endif; ?>
