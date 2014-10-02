
<div id="primary">
      <?php
      /* d('single ' . get_post_type()); */
      global $post;
      if ( have_posts() ) {

            while ( have_posts() ) {
                  the_post();
                  ?>

                  <section class="bg-50 block-5" style="overflow:visible">
                        <article >
                              <header class="hover" style="top:0px; height: 50px;">
                                    <h1 class="fl ml5 sc-eee">
                                          <?php the_title(); ?> 
                                    </h1>
                                    <?php
                                    /*
                                      if (get_the_author() === wp_get_current_user()->display_name) {
                                      $artist_edit_url = add_query_arg(array('gform_post_id' => $artist_page_id), get_permalink(get_page_by_path('recursos')) . 'artista');
                                      ?>
                                      <span class="fr mr5 mt5" title="Nuevo contenido">[ <a href="<?php echo $artist_edit_url ?>">editar</a> ]</span>
                                      <?php
                                      }
                                     *  */
                                    ?>
                              </header>
                              <div class="featured-image" style="width:100%;">
                                    <?php
                                    /* the_post_thumbnail('single-thumb'); */
                                    the_post_thumbnail();
                                    ?>
                              </div>
                              <div class="fr mt5 mr5 cb">
                                    <span class=""style="color: #666;">
                                          <?php echo get_the_date(); ?>
                                    </span>
                              </div>
                              <div class="mt5 ml5 mr5 meddium cb">
                                    <?php
                                    the_content();
                                    $post_type = get_post_type();
                                    if ( in_array( $post_type, array( 'artista', 'sello' ) ) ) {
                                          include (locate_template( 'templates/child-list.php' ));
                                    }
                                    ?>
                              </div>


                        </article>
                  </section>

                  <script type="text/javascript">
                        (function($) {
                              $('dt.gallery-icon a').fancybox();
                        })(jQuery);
                  </script>
                  <style>
                        .gallery img{
                              width: 95%;
                        }
                  </style>
                  <?php
            }
      }
      ?>

      <div class="cb bg-50  block-5 mt15">
            <h1 class="ml5">Comentarios</h1>
            <?php
            include_once 'facebook/comments.php';
            ?>
      </div>

      <?php
      $tags = wp_get_post_tags( get_the_ID(), $args );
      if ( !empty( $tags ) ) {
            if ( !is_wp_error( $tags ) ) {
                  ?>
                  <div class="cb bg-50  block-5 mt15">
                        <div class="tag-list">
                              <span class="tags-icon"></span>
                              <ul>
                                    <?php
                                    foreach ( $tags as $tag ) {
                                          echo '<li><a href="' . get_term_link( $tag ) . '">' . $tag->name . '</a></li>';
                                    }
                                    ?>
                              </ul>
                        </div>
                  </div>
                  <?php
            }
      }
      ?>

      <?php
      $args = array(
            'post_type' => get_post_type(),
            'posts_per_page' => 4,
            'post__not_in' => array( get_the_ID() ),
                /* 'orderby' => 'RAND', */
      );

      $query = new WP_Query( $args );
      $tpl_loop = array(
            'query' => $query,
            'container' => array(
                  'tag' => 'ul',
                  'id' => '',
                  'class' => ''
            ),
            'item_container' => array(
                  'tag' => 'li',
                  'id' => '',
                  'class' => ''
            ),
            'item_template' => array(
                  'template_part' => 'tpl/archive/related-list-item'
            )
      );


      $loop = new NzTplLoop( $tpl_loop );
      ?>
      <div class="cb bg-50  block-5 mt15">
            <h1 class="ml5">Contenidos relacionados</h1>
            <hr class="pb5">

            <?php echo $loop->render(); ?>
      </div>


</div>

<div id="secondary">
      <?php get_sidebar( 'right' ); ?>
</div><!-- #secondary -->
