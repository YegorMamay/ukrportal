<?php get_header(); ?>
<div class="container">
    <div class="main-post">
        <div class="main-post__column">
            <?php echo do_shortcode('[bw-advert count=1 class=front-news display_datetime=1 display_category=1 array_index=0]'); ?>
        </div>
        <div class="main-post__row">
            <div class="main-post__container">
                <?php echo do_shortcode('[bw-advert count=2 class=front-news display_datetime=1 display_category=1 array_index=1]'); ?>
            </div>
            <div class="main-post__container">
                <?php echo do_shortcode('[bw-advert count=3 class=front-news display_datetime=1 display_category=1 array_index=2]'); ?>
            </div>
            <div class="main-post__container">
                <?php echo do_shortcode('[bw-advert count=4 class=front-news display_datetime=1 display_category=1 array_index=3]'); ?>
            </div>
        </div>
    </div>
    <div class="bw-banner">
        <?php
        $banner_link = get_field('banner_link' , pll_current_language('slug'));
        $banner_image = get_field('banner_image' , pll_current_language('slug'));
        ?>
        <a class="bw-banner__image" href="<?php echo $banner_link; ?>">
            <img src="<?php echo $banner_image; ?>" class="bw-banner__image" alt="banner">
        </a>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
          <div class="title-wrapper">
              <h1 class="news-title h2"><?php echo pll_e('news-title') ?></h1>
          </div>
          <div class="sp-xs-4"></div>
            <?php get_template_part('loops/content', get_post_format()); ?>
        </div>

        <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">
            <div class="sp-xs-4"></div>
            <?php dynamic_sidebar('sidebar-widget-area2'); ?>
        </div>

    </div><!-- /.row -->
</div><!-- /.container -->
<?php get_footer(); ?>
