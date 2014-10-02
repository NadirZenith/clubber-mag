<?php
$args = array(
      'posts_per_page' => 4,
      'post_type' => 'post',
      'label_name' => 'Últimas noticias'
);
$the_query = new WP_Query( $args );
?>
<h1>
      <a class="ml5" href="<?php echo get_permalink( get_page_by_title( 'noticias' ) ); ?>"> <?php echo $args[ 'label_name' ] ?></a>
</h1>

<ul>
      <?php
      if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                  $the_query->the_post();
                  ?>
                  <li class="mb5">
                        <article>
                              <div class="hover">
                                    <h2>
                                          <a class="ml5"  href="<?php the_permalink() ?>">
                                                <?php
                                                $mytitle = get_the_title();
                                                if ( strlen( $mytitle ) > 40 ) {
                                                      $mytitle = substr( $mytitle, 0, 40 ) . '...';
                                                }
                                                echo $mytitle;
                                                ?>
                                          </a>
                                    </h2>
                              </div>

                              <a class="featured-image" href="<?php the_permalink() ?>" >
                                    <?php the_post_thumbnail( '340-155-thumb' ); ?>
                              </a>

                        </article>
                  </li>
                  <?php
            } //END WHILE
      } else {
            ?>
            <li>NO posts for news</li>      
            <?php
      }
      ?>
</ul>
<?php
wp_reset_postdata();
?>

<a class="fr" href="<?php echo get_permalink( get_page_by_title( 'noticias' ) ); ?>">ver más...</a>
