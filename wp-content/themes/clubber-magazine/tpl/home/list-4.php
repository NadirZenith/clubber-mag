<?php
/*
 * event reviews / music archive page item
 */
?>
<article class="mb5 group">
      <div class="fr col-1 col-md-3-4">
            <div class="ml10">

                  <header >
                        <h2>
                              <a class="cm-title" href="<?php echo $item[ 'link' ] ?>">
                                    <?php echo $item[ 'title' ] ?>
                              </a>
                        </h2>
                  </header>
                  <div>
                        <?php echo $item[ 'content' ] ?>
                  </div>

                  <a class="readmore fr m5" href="<?php echo $item[ 'link' ]; ?>" title=""> 
                        <?php echo __( 'Read more', 'cm' ) ?>
                  </a>
            </div>
      </div>
      <div class="fl col-1 col-md-1-4">
            <a class="featured-image" href="<?php echo $item[ 'link' ]; ?>">
                  <?php echo $item[ 'thumbnail' ] ?>

            </a>
      </div>
</article>