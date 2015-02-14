<ul class="home-list">

      <li class="col-1">
            <?php get_template_part( 'tpl/parts/featured-events' ); ?>
      </li>

      <li class="col-1 col-md-1-2 col-small fl">
            <?php get_template_part( 'tpl/home/home-last-news' ); ?>
      </li>

      <li class="col-1 col-md-1-2 col-small fr">
            <?php get_template_part( 'tpl/home/home-last-music' ); ?>
      </li>

      <li class="col-1 col-big fl">
            <?php get_template_part( 'tpl/home/home-last-photo' ); ?>

            <?php get_template_part( 'tpl/home/home-last-video' ); ?>

            <?php get_template_part( 'tpl/home/newsletter' ); ?>
      </li>

      <li class="col-1">
            <div class="featured-image banner-bottom"> 
                  <?php echo do_shortcode( '[sam id=5]' ); ?>
            </div>
      </li>

      <li class="col-1 col-md-1-2 fl">
            <?php get_template_part( 'tpl/home/home-cm-podcasts' ); ?>

      </li>
      <li class="col-1 col-md-1-2 fl">
            <?php get_template_part( 'tpl/home/home-shared-podcasts' ); ?>

      </li>
</ul>

<script type="text/javascript">
      jQuery(document).ready(function($) {
            $('.home-slider').flexslider({
                  controlNav: false,
                  directionNav: false,
                  pauseOnHover: true,
                  /*useCSS: false*/

            });
      });
</script> 