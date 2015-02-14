<?php
/* home page news and music list */
?>
<article>
      <div class="hover">
            <header class="m5">
                  <h2 class="sf-2">
                        <a href="<?php the_permalink() ?>">
                              <?php
                              $mytitle = get_the_title();
                              if ( strlen( $mytitle ) > 40 ) {
                                    $mytitle = substr( $mytitle, 0, 40 ) . '...';
                              }
                              echo $mytitle;
                              ?>
                        </a>
                  </h2>
            </header>
      </div>
      <a class="featured-image" href="<?php the_permalink() ?>" >
            <?php the_post_thumbnail( '340-155-thumb' ); ?>
      </a>
</article>