
<?php
d(
get_option('relevanssi_index_users')
          );
$search = get_query_var( 's' );
/*$search = 'clubber+mag';*/

$search_string = esc_attr( trim( get_query_var( 's' ) ) );
$user_query = new WP_User_Query( array(
      'search' => "*{$search}*",
      'search_columns' => array(
            'user_login',
            'user_nicename',
            'user_email',
            'user_url',
      ),
      'meta_query' => array(
            'relation' => 'OR',
            array(
                  'key' => 'first_name',
                  'value' => $search,
                  'compare' => 'LIKE'
            ),
            array(
                  'key' => 'last_name',
                  'value' => $search,
                  'compare' => 'LIKE'
            )
      )
          ) );
$users_found = $user_query->get_results();


d( $user_query );
d( $users_found );
?>
<div class="co-1">
      <section>
            <header>
                  <h2>
                        Usuarios
                  </h2>
                  <hr class="cb pb5">
            </header>
            <?php
            if ( !empty( $user_query->results ) ) {
                  ?>
                  <ul>
                        <?php
                        foreach ( $user_query->results as $user ) {
                              ?>
                              <li class="col-1-4 fl">
                                    <article class="">
                                          <a href="<?php echo get_author_posts_url( $user->ID ); ?>" class="fl">
                                                <?php
                                                $url = nz_get_user_image( $user->ID, 'profile' );
                                                ?>
                                                <img src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="100" height="100">
                                          </a>
                                          <div class="fl">
                                                <a class="ml5" href="<?php echo get_author_posts_url( $user->ID ); ?>" >

                                                      <?php echo $user->display_name ?>
                                                </a>
                                          </div>
                                    </article>
                              </li>
                              <?php
                        }
                        ?>
                  </ul>
                  <?php
            } else {
                  ?>
                  <p class="meddium">Ningún usuario encontrado con <span style="font-style:italic">'<?php echo get_query_var( 's' ) ?>'</span></p>
                  <?php
            }
            ?>
      </section>  
</div>
<div class="col-1 mt15">
      <section>

            <header class="">
                  <h2>
                        Otros resultados
                  </h2>
                  <hr class="cb pb5">
            </header>
            <?php
            if ( have_posts() ) {
                  ?>
                  <ul class="archive-list">
                        <?php
                        while ( have_posts() ) {
                              the_post();
                              ?>
                              <li>

                                    <section class="bg-50 block-5 mb15">
                                          <article>
                                                <header>
                                                      <h1 class="mt5">
                                                            <a class="ml5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                                      </h1>
                                                </header>
                                                <hr class="pb5">
                                                <div class="fl ml5 col-2-4 ">
                                                      <div class="" style="text-align:justify">
                                                            <?php the_excerpt() ?>
                                                      </div>
                                                      <p class="">
                                                            <a class="readmore" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __( 'Read more', 'cm' ) ?></a>
                                                      </p>

                                                      <div  style="color: #666;">
                                                            <?php echo get_the_date() ?>
                                                      </div>
                                                </div>



                                                <div class="fr col-2-4 nm" >
                                                      <?php
                                                      if ( has_post_thumbnail() ) {
                                                            ?>
                                                            <a class="featured-image" href="<?php the_permalink() ?>" >
                                                                  <?php
                                                                  the_post_thumbnail( '430-190-thumb' );
                                                                  ?>
                                                            </a>
                                                            <?php
                                                      }
                                                      ?>
                                                </div>

                                          </article>
                                    </section>
                              </li>

                              <?php
                        }
                        ?>
                  </ul>
                  <?php
            } else {
                  ?>
                  <p class="meddium"><?php _e( 'No Posts Found.', 'cm' ); ?> con <span style="font-style:italic">'<?php echo get_query_var( 's' ) ?>'</span></p>
                  <?php
            }
            ?>
      </section>
      <?php
      include (locate_template( 'templates/pagination.php' ));
      ?>
</div>
