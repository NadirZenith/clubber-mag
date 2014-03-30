<?php
/*
  Template Name: Gallery Template
 */
?>

<?php get_header(); ?>
<div id="container" class="site-content">
      <style>
            .thumbs li{
                  float: left; 
                  width: 23%; 
                  margin: 1%;
            }

            .thumbs li:first-child{
                  /*margin-left: 2%;*/
            }

      </style>
      <!--<div id="content" class="hentry">-->
      <h1 class=""><?php the_title(); ?></h1>
     
      <div class="">
            <ul>
                  <?php
                  d('asdf');
                  global $post, $wpdb, $wp_query;
                  $paged = $wp_query->query_vars["paged"];
                  $permalink = get_permalink();
                  $gllr_options = get_option('gllr_options');
                  if (substr($permalink, strlen($permalink) - 1) != "/") {
                        if (strpos($permalink, "?") !== false) {
                              $permalink = substr($permalink, 0, strpos($permalink, "?") - 1) . "/";
                        } else {
                              $permalink .= "/";
                        }
                  }
                  $count = 0;
                  $args = array(
                      'post_type' => 'gallery',
                      'post_status' => 'publish',
                      'orderby' => 'post_date',
                      'posts_per_page' => -1
                  );
                  $second_query = new WP_Query($args);
                  if (function_exists('pdfprnt_show_buttons_for_custom_post_type'))
                        echo pdfprnt_show_buttons_for_custom_post_type($second_query);
                  $count_all_albums = count($second_query->posts);
                  $per_page = $showitems = get_option('posts_per_page');
                  if ($paged != 0)
                        $start = $per_page * ($paged - 1);
                  else
                        $start = $per_page * $paged;
                  if ($second_query->have_posts()) : while ($second_query->have_posts()) : $second_query->the_post();
                              if ($count < $start) {
                                    $count++;
                                    continue;
                              }
                              if (( $count - $start ) > $per_page - 1)
                                    break;

                              $attachments = get_post_thumbnail_id($post->ID);
                              if (empty($attachments)) {
                                    $attachments = get_children('post_parent=' . $post->ID . '&post_type=attachment&post_mime_type=image&numberposts=1');
                                    $id = key($attachments);
                                    $image_attributes = wp_get_attachment_image_src($id, 'home-gallery-thumb');
                              } else {
                                    $image_attributes = wp_get_attachment_image_src($attachments, 'home-gallery-thumb');
                              }
                              if (1 == $gllr_options['border_images']) {
                                    $gllr_border = 'border-width: ' . $gllr_options['border_images_width'] . 'px; border-color:' . $gllr_options['border_images_color'] . '; padding:0;';
                                    $gllr_border_images = $gllr_options['border_images_width'] * 2;
                              } else {
                                    $gllr_border = 'padding:0;';
                                    $gllr_border_images = 0;
                              }
                              $count++;
                              ?>
                              <li class="bg-50 block-5 mt15">

                                    <!--<li style="clear: both; margin: 15px;overflow: auto">-->
                                    <section class="">
                                          <article >
                                                <div class="featured-image col-2-4 fl nm">
                                                      <a class="" rel="bookmark" href="<?php echo get_permalink(); ?>" title="<?php echo htmlspecialchars($post->post_title); ?>">
                                                            <img alt="<?php echo htmlspecialchars($post->post_title); ?>" title="<?php echo htmlspecialchars($post->post_title); ?>" src="<?php echo $image_attributes[0]; ?>" />
                                                      </a>
                                                </div>
                                                <div class="col-2-4 fl meddium">
                                                      <h1><?php echo htmlspecialchars($post->post_title); ?></h1>
                                                      <div><?php echo the_excerpt_max_charlength(100); ?></div>


                                                      <a class="readmore mr5 mb5" href="<?php echo $permalink . basename(get_permalink($post->ID)); ?>" title=""> 
                                                            <?php echo __('Read more', 'attitude') ?>
                                                      </a>

                                                      <div class="clear"></div>
                                                      <?php
                                                      $posts = get_posts(array(
                                                          "what_to_show" => "posts",
                                                          "post_status" => "inherit",
                                                          "post_type" => "attachment",
                                                          "post_mime_type" => "image/jpeg,image/gif,image/jpg,image/png",
                                                          "post_parent" => get_the_ID(),
                                                          'posts_per_page' => 4
                                                      ));
                                                      ?>

                                                      <ul class="thumbs" style="">
                                                            <?php
                                                            foreach ($posts as $attachment) {
                                                                  $image_attributes = wp_get_attachment_image_src($attachment->ID, 'home-gallery-thumb');
                                                                  ?>
                                                                  <li class="" style="">
                                                                        <a href="<?php echo $permalink; ?>">
                                                                              <img src="<?php echo $image_attributes[0] ?>" class="" alt="">
                                                                        </a>
                                                                  </li>
                                                            <?php } ?>

                                                      </ul>
                                                </div>

                                          </article>
                                    </section>
                              </li>
                              <?php
                        endwhile;
                  endif;
                  wp_reset_query();
                  ?>
            </ul>
            <?php
            if ($paged == 0)
                  $paged = 1;
            $pages = intval($count_all_albums / $per_page);
            if ($count_all_albums % $per_page > 0)
                  $pages +=1;
            $range = 100;
            if (!$pages) {
                  $pages = 1;
            }
            if (1 != $pages) {
                  echo "</div><div class='clear'></div><div class='pagination'>";
                  for ($i = 1; $i <= $pages; $i++) {
                        if (1 != $pages && (!( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems )) {
                              echo ( $paged == $i ) ? "<span class='current'>" . $i . "</span>" : "<a href='" . get_pagenum_link($i) . "' class='inactive' >" . $i . "</a>";
                        }
                  }
                  echo "<div class='clear'></div></div>\n";
            } else {
                  ?>
            </div>
      <?php } ?>

      <!--</div>-->
</div>
<?php
/* get_sidebar(); */
?>
<?php get_footer(); ?>