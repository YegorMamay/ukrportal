<?php get_header(); ?>
<div class="container">

    <div class="main-post">
        <?php echo do_shortcode('[bw-advert count=3 class=front-news]'); ?>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
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
