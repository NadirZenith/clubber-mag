<?php
/**
 * Template Name: Resources Template
 *
 * Displays the Resources
 *
 */
?>
<?php
global $wp_query;

$page = $wp_query->get_queried_object();

$is_main = ($page->post_parent == 0);

if ( $is_main ) {

      $resources = array(
            'artista' => array(
                  'title' => __( 'Artists', 'cm' ),
                  'description' => 'Comparte tu música, biografía, noticias y fechas!',
                  'img' => 'recurso_artista.jpg',
                  'url' => get_permalink( cm_lang_get_post( CM_RESOURCE_ARTIST_PAGE_ID ) )
            ),
            'promotor' => array(
                  'title' => __( 'Promoters', 'cm' ),
                  'description' => 'Produces eventos y te gustaría promocionarlos? Compártelos en Clubber-mag!',
                  'img' => 'recurso_promotor.jpg',
                  'url' => get_permalink( cm_lang_get_post( CM_RESOURCE_EVENT_PAGE_ID ) )
            ),
            'label' => array(
                  'title' => __( 'Labels', 'cm' ),
                  'description' => 'Promociona tus artistas, sus noticias y  música en Clubber Magazine!',
                  'img' => 'recurso_label.jpg',
                  'url' => get_permalink( cm_lang_get_post( CM_RESOURCE_LABEL_PAGE_ID ) )
            ),
            'coolplace' => array(
                  'title' => __( 'Coolplaces', 'cm' ),
                  'description' => 'Tienes un Club, Restaurant o bar? Este es tú sitio!',
                  'img' => 'recurso_coolplace.jpg',
                  'url' => get_permalink( cm_lang_get_post( CM_RESOURCE_COOLPLACE_PAGE_ID ) )
            )
      );
}
?>

<section <?php post_class( 'ibox-5 box-5' ); ?>>

      <?php echo get_template_part( 'tpl/parts/page-header' ) ?>

      <?php
      if ( isset( $resources ) ) {
            ?>
            <ul>
                  <?php
                  foreach ( $resources as $resource => $data ) {
                        $item[ 'title' ] = $data[ 'title' ];
                        $item[ 'content' ] = $data[ 'description' ];
                        $item[ 'link' ] = $data[ 'url' ];
                        $img = '<img src="' . get_site_url() . '/wp-content/themes/clubber-magazine/assets/images/types/' . $data[ 'img' ] . '"/>';
                        $item[ 'thumbnail' ] = $img;
                        ?>
                        <li class="ibox-5 col-1">
                              <?php include 'tpl/home/list-4.php'; ?>
                        </li>
                        <?php
                  }
                  ?>
            </ul>
            <?php
      } else {
            ?>
            <?php the_content(); ?>
            <?php
      }
      ?>
</section>