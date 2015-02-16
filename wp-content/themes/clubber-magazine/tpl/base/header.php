<div id="site-logo" class="fl hide show-md">
      <h1>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Clubber-Mag" rel="home">
                  <img src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/assets/images/clubber-mag.png" alt="Clubber-Mag">
            </a>	
      </h1>
</div>

<div id="social-area-top">
      <?php
      $socials = array(
            'facebook' => array(
                  'url' => 'https://www.facebook.com/Clubber.Mag',
            ),
            'twitter' => array(
                  'url' => 'https://www.twitter.com/clubbermag',
            ),
            'instagram' => array(
                  'url' => 'https://www.instagram.com/clubbermagazine',
            ),
            'youtube' => array(
                  'url' => 'https://www.youtube.com/channel/UCOC8TKzHI985Nn-sAGIDKFw',
            ),
            'soundcloud' => array(
                  'url' => 'https://soundcloud.com/clubber-magazine',
            ),
            'google-plus' => array(
                  'url' => 'https://plus.google.com/+Clubbermagazine',
            ),
      );
      ?>
      <?php nz_fa_social_icons( $socials, 'social-icons-top social-icons' ); ?>

      <?php echo nz_fb_like_iframe( 'https://www.facebook.com/Clubber.Mag' ); ?>

</div>

<div id="top-banner"> 
      <?php echo do_shortcode( '[sam id=1]' ); ?>
</div>

<nav id="access" class="cb hide show-md">
      <div id="desktop-menu" class="group">
            <?php
            $args = array(
                  'theme_location' => 'primary',
                  'container' => '',
                  'items_wrap' => '<ul id="main-menu" >%3$s</ul>'
            );
            ?>
            <?php wp_nav_menu( $args ); ?>
      </div>
</nav>

<div id="mobile-menu-title">
      <div class="logo" >
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Clubber-Mag" rel="home">
                  <img width="200" style="margin-left: -3px;" alt="Clubber-Mag" src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/assets/images/clubber-mag-inline.png">
            </a>
      </div>
      <div id="open-search-bar">
            <i class="fa fa-search sc-eee"></i>
      </div>
      <div class="search-form">
            <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
                  <input type="text" placeholder="<?php _e('Search for parties, clubs, artists...' , 'cm');?>" class="s field sf-2" name="s" value="<?php echo get_query_var( 's', '' ) ?>">
            </form>
      </div>
</div>

