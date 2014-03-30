<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
 

<div id="a-z">

      <?php
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $posts_per_row = 3;
      $posts_per_page = 15;
      $args = array(
          /* 'posts_per_page' => $posts_per_page, */
          'post_type' => 'musica',
          'orderby' => 'title',
          'order' => 'ASC',
          /* 'paged' => $paged, */
          'tax_query' => array(
              array(
                  'taxonomy' => 'music_type',
                  'field' => 'slug',
                  'terms' => 'artista'
              )
          )
      );
      query_posts($args);
      if (have_posts()) {
            $in_this_row = 0;
            while (have_posts()) {
                  the_post();
                  $first_letter = strtoupper(substr(apply_filters('the_title', $post->post_title), 0, 1));

                  if ($first_letter != $curr_letter) {
                        if (++$post_count > 1) {
                              echo "\t</div><!-- End row-cells -->\n";
                              echo "</div><!-- End of letter-group -->\n";
                              /* echo "<div class='clear'></div>\n"; */
                        }
                        echo "<div style=\"float:left; width:150px;\" class='letter-group'>\n";
                        echo "\t<div class='letter-cell'>$first_letter</div>\n";
                        $in_this_row = 0;
                        echo "\t<div class='row-cells'>\n";
                        $curr_letter = $first_letter;
                  }
                  if (++$in_this_row > $posts_per_row) {
                        echo "\t</div><!-- End row-cells -->\n";
                        $in_this_row = 0;
                        echo "\t<div class='row-cells'>\n";
                        ++$in_this_row;  // Account for this first post
                  }
                  ?>
                  <div class="title-cell"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></div>
                        <?php
                  }
                  echo "\t</div><!-- End row-cells -->\n";
                  echo "</div><!-- End of letter-group -->\n";
                  /* echo "<div class='clear'></div>\n"; */
                  ?>

            <?php
      } else {
            echo "<h2>Sorry, no posts were found!</h2>";
      }
      ?>

</div><!-- End id='a-z' -->

 
