<?php

function clubber_attitude_theloop_for_home() {
      /* theloop_debug(); */

      theloop_for_news();
      theloop_for_artists();
      theloop_for_gallery();
}

function theloop_for_news() {
      $args = array(
          'numberposts' => -1,
          'post_type' => 'noticia',
      );

      $the_query = new WP_Query($args);
      if ($the_query->have_posts()) {
            ?>
            <div style="float:left; width:300px; background-color: #bbb;padding: 5px;">
                  <h2><a href="<?php echo get_post_type_archive_link('noticia'); ?>">The news</a></h2>
                  <?php
                  // The Loop
                  $i = 0;
                  while ($the_query->have_posts()) {
                        $the_query->the_post();

                        if ($i % 2 != 0) {
                              ?>
                              <div style="clear: both; margin-bottom: 5px; overflow: hidden;">
                                    <div style="float: left;">
                                          <?php
                                          if (has_post_thumbnail()) {
                                                the_post_thumbnail('home-news-thumb');
                                          }
                                          ?>
                                    </div>
                                    <div style="float: left; width: 195px; background-color: #999;padding-left: 5px;">
                                          <div style="font-size: 16px;font-weight: bold"><?php the_title() ?></div>
                                          <?php echo wp_trim_words(get_the_content(), 6); ?> 
                                          <a href="<?php the_permalink() ?>"> +plus</a>
                                    </div>
                              </div>
                        <?php } else { ?>
                              <div style="clear: both; margin-bottom: 5px;overflow: hidden">

                                    <div style="float: left; width: 195px; background-color: #999; padding-left: 5px;">
                                          <div style="font-size: 16px;font-weight: bold"><?php the_title() ?></div>
                                          <?php echo wp_trim_words(get_the_content(), 6); ?> 
                                          <a href="<?php the_permalink() ?>"> +plus</a>
                                    </div>

                                    <div style="float: left;">
                                          <?php
                                          if (has_post_thumbnail()) {
                                                the_post_thumbnail('home-news-thumb');
                                          }
                                          ?>
                                    </div>
                              </div>

                              <?php
                        }
                        $i++;
                  }
                  ?>
            </div>
            <?php
      } else {
            echo '<h1> no posts</h1>';
      }

      wp_reset_postdata();
}

function theloop_for_artists() {
      $args = array(
          'numberposts' => -1,
          'post_type' => 'artist',
      );


      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) {
            ?>
            <div style="float:left; width:300px; background-color: #ccc;padding: 5px;">
                  <h2><a href="<?php echo get_post_type_archive_link('artist'); ?>">The artists</a></h2>
                  <?php
                  // The Loop
                  /* echo '<h4>' . get_the_title() . '(' . get_field('tipo_de_post') . ')' . '</h4>'; */
                  ?>
                  <dl class="Zebra_Accordion" id="Zebra_Accordion1">
                        <?php
                        while ($the_query->have_posts()) {
                              $the_query->the_post();
                              ?>
                              <dt style="font-size: 16px;font-weight: bold;background-color:#ddd; margin-bottom: 5px;">
                              <?php the_title(); ?>
                              -
                              <?php $meta_values = meta('artists_post_type') ?>
                              <?php echo $meta_values; ?>
                              </dt>
                              <dd style="overflow: hidden;">
                                    <div style="float: left;">
                                          <?php
                                          if (has_post_thumbnail()) {
                                                the_post_thumbnail('home-artists-thumb');
                                          }
                                          ?>
                                    </div>
                                    <div style="float: left; width: 205px; background-color: #999;padding-left: 5px;">
                                          <div style="font-size: 16px;font-weight: bold"><?php the_title() ?></div>
                                          <?php echo wp_trim_words(get_the_content(), 12); ?> 
                                          <a href="<?php the_permalink() ?>"> +plus</a>
                                    </div>
                              </dd>
                              <?php
                        }
                        ?>
                  </dl>
            </div>

            <?php
      } else {
            echo '<h1> no posts</h1>';
      }

      wp_reset_postdata();
}

/* * ************************************************************************************* */

function theloop_for_gallery() {
      $args = array(
          'numberposts' => -1,
          'post_type' => 'gallery',
      );

      $the_query = new WP_Query($args);
      if ($the_query->have_posts()) {
            ?>
            <div style="float:left; width:300px; background-color: #ddd;padding: 5px;">
                  <!--<h2><a href="<?php echo get_post_type_archive_link('gallery'); ?>">Photo review</a></h2>-->
                  <h2><a href="<?php echo get_permalink(get_page_by_path('galeria')) ?>">Photo review</a></h2>
                  <div class="slideshow" style="clear: both; margin-bottom: 5px; overflow: hidden;">
                        <?php
                        while ($the_query->have_posts()) {
                              $the_query->the_post();
                              ?>
                              <!--<div style="float: left;">-->
                              <div style="float: left;">
                                    <a href="<?php the_permalink() ?>">
                                          <?php
                                          if (has_post_thumbnail()) {
                                                the_post_thumbnail('home-gallery-thumb');
                                          }
                                          ?>
                                          <?php the_title() ?>
                                    </a>
                                    <!--</div>-->
                              </div>
                              <!--<div style="float: left; width: 195px; background-color: #999;padding-left: 5px;">-->
                              <!--<div>-->
                                    <!--<span style="font-size: 16px;font-weight: bold">-->
                              <!--<?php the_title() ?>-->
                              <!--</span>-->
                              <!--</div>-->
                              <!--</div>-->

                              <?php
                        }
                        ?>
                  </div>
                  <script type="text/javascript">
                        jQuery(document).ready(function($) {
                              $('.slideshow').cycle({
                                    fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
                              });
                        });
                  </script>

            </div>
            <?php
      } else {
            echo '<h1> no posts</h1>';
      }

      wp_reset_postdata();
}
