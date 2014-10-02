<h1>
      <a class="ml5" href="<?php echo get_post_type_archive_link('video'); ?>">
            Video review
      </a>
</h1>

<?php
$args = array(
    'post_type' => 'video',
    'posts_per_page' => 1,
);
$the_query = new WP_Query($args);
?>
<ul>
      <?php
      if ($the_query->have_posts()) {
            ?>
            <?php
            while ($the_query->have_posts()) {
                  $the_query->the_post();
                  ?>
                  <li>
                        <article>
                              <div class="video-container">
                                    <?php
                                    /*$url = types_render_field('youtube-video-url', array('raw' => true));*/
                                    /*parse_str(parse_url($url, PHP_URL_QUERY), $vars);*/
                                    /*<iframe src="//www.youtube.com/embed/<?php echo $vars['v']; ?>" frameborder="0" allowfullscreen></iframe>*/
                                    $video = types_render_field( "video-url", array("output" => "html") );
                                    echo $video;
                                    ?>
                              </div>
                        </article>
                  </li>

                  <?php
            } //END WHILE
            ?>
      <?php } else { ?>
            <li>NO posts for videos</li>      
            <?php
      }
      ?>
</ul>

<?php
wp_reset_postdata();
?>