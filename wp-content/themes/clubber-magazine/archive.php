<section>
      <header class="mt15 mb10">
            <h1>
                  <span class="cm-title">
                        <?php
                        if ( is_category() ) :
                              single_cat_title();
                        elseif ( is_tax() ) :
                              single_tag_title();
                        elseif ( is_archive() ) :
                              post_type_archive_title();

                        endif;
                        ?>
                  </span>
            </h1>
      </header>
      <?php
      global $post;
      if ( have_posts() ) {
            ?>
            <ul>
                  <?php
                  while ( have_posts() ) {
                        the_post();
                        ?>
                        <li class="col-1">
                              <?php
                              get_template_part( 'tpl/parts/list-3' );
                              ?>
                        </li>
                        <?php
                  }
                  ?>
            </ul>
            <?php
      } else {
            get_template_part( 'tpl/parts/not-found' );
      }
      ?>
      <?php
      include (locate_template( 'templates/pagination.php' ));
      ?>
</section>