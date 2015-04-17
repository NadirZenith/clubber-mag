<?php
$posts_per_row = 4;

$args = array(
      'post_type' => 'cool-place',
      'posts_per_page' => $posts_per_row * 1,
      'order' => 'rand',
      'orderby' => 'meta_valua',
      'meta_query' => array(
            array(
                  'key' => 'featured',
                  'value' => 'on',
                  'compare' => '=',
            )
      )
);

$query = new WP_Query( $args );
?>
<section class="mt15">
      <header class="mb3 ml3">
            <h1 class="h2">
                  <span class="cm-title" >
                        <?php _e( 'Featured Cool Places', 'cm' ) ?>
                  </span>
            </h1>
      </header>


      <div class="cb">
            <ul class="slides">
                  <?php
                  if ( $query->have_posts() ) {
                        $count = 0;
                        ?> 
                        <li>
                              <ul>
                                    <?php
                                    while ( $query->have_posts() ) {
                                          $query->the_post();
                                          if ( $count == $posts_per_row ) {
                                                ?>
                                          </ul>
                                    </li>
                                    <li>
                                          <ul>
                                                <?php
                                          }
                                          ?>
                                          <li class="col-1 col-sm-1-2 col-lg-1-4 fl">

                                                <div class="box-3">
                                                      <?php
                                                      get_template_part( 'tpl/home/list-2' );
                                                      ?>
                                                </div>
                                          </li>
                                          <?php
                                          $count +=1;
                                    } //END while
                                    ?>
                              </ul>
                        </li>
                        <?php
                  } //end if have posts
                  ?>
                  <?php wp_reset_postdata(); ?>

            </ul>

      </div>
</section>