<?php
$args = array(
    'post_type' => 'music',
    'posts_per_page' => 3,
);
$the_query = new WP_Query($args);
?>

<h1>
      <a class="ml5" href="<?php echo get_post_type_archive_link($args['post_type']); ?>">
            Musica
      </a>
</h1>

<ul>
      <?php
// The Loop
      if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                  $the_query->the_post();
                  $terms = wp_get_post_terms(get_the_ID(), 'music_type', $args);
                  ?>
                  <li class="pr" style="margin-bottom: 7px;">
                        <article>
                              <div class="hover">
                                    <h2 >
                                          <a class="ml5" href="<?php the_permalink() ?>">
                                                <?php the_title() ?>
                                                <?php
                                                /* echo wp_trim_words(get_the_title(), 5); */
                                                ?>
                                          </a>
                                          <span style="font-size: 12px;" class="fr mr5"><?php echo $terms[0]->name; ?></span>

                                    </h2>
                              </div>

                              <a class="featured-image" href="<?php the_permalink() ?>"  style="">
                                    <?php the_post_thumbnail('340-155-thumb'); ?>

                              </a>

                        </article>
                  </li>
                  <?php
            } //END WHILE
      } else {
            ?>
            <li> no posts for musica</li>
            <?php
      }
      ?>
</ul>

<?php
wp_reset_postdata();
?>