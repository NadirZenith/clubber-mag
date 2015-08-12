<?php
/**
 * Template Name: Event Reviews Template
 *
 * Displays the Event reviews page
 *
 */
?>
<?php
$items = array();
$img = '<img src="' . get_site_url() . '/wp-content/themes/clubber-magazine/assets/images/types/%s"/>';
$items[] = array(
      'title' => __( 'Photo review', 'cm' ),
      'content' => 'Mira, búscate y comparte las fotografías de los eventos más importantes.',
      'link' => get_post_type_archive_link( 'photo' ),
      'thumbnail' => sprintf( $img, 'photo_review.jpg' )
);

$items[] = array(
      'title' => __( 'Video review', 'cm' ),
      'content' => 'Revive los eventos más destacados con nosotros.',
      'link' => get_post_type_archive_link( 'video' ),
      'thumbnail' => sprintf( $img, 'video_review.jpg' )
);
?>
<section class="m5">
      <?php echo get_template_part( 'tpl/parts/page-header' ) ?>

      <ul>
            <?php
            foreach ( $items as $item ) {
                  ?>
                  <li class="ibox-5">
                        <?php
                        /* get_template_part( 'tpl/home/list-4.php' ); */

                        include 'tpl/home/list-4.php';
                        ?>
                  </li>
                  <?php
            }
            ?>
      </ul>
</section>