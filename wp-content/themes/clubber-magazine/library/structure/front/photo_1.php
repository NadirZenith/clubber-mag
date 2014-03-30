<?php
$args = array(
    'post_type' => 'gallery',
    'post_status' => 'publish',
    /* 'name' => $wp_query->query_vars['name'], */
    'posts_per_page' => 3
);
$query = new WP_Query($args);
?>
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
<h1>
      <a class="ml5" href="<?php echo get_permalink(get_page_by_path('event-reviews/photo-galleries/')) ?>">Photo review</a>
</h1>
<ul class="gallery-slideshow" style="">
      <?php
      if ($query->have_posts()) {
            while ($query->have_posts()) {
                  $query->the_post();
                  $permalink = get_permalink();
                  ?>
                  <li class="" style="">
                        <article style="">
                              <div style="position:relative">
                                    <div class="hover-2">
                                          <h2 class="ml5"><?php the_title() ?></h2>
                                    </div>
                                    <a class="featured-image" href="<?php echo $permalink; ?>">
                                          <?php the_post_thumbnail('home-gallery-thumb'); ?>
                                    </a>

                              </div>
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
                                          <?php
                                    }
                                    wp_reset_postdata();
                                    ?>
                              </ul>
                        </article>
                  </li>
                  <?php
            }
      } else {
            ?>
            <li>no posts for gallery</li>
            <?php
      }
      ?>
</ul>

<?php
wp_reset_postdata();
?>

<script type="text/javascript">
      jQuery(document).ready(function($) {
            $('.gallery-slideshow').cycle({
                  fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
            });

      });

</script>