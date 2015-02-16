<?php
$tags = wp_get_post_tags( get_the_ID() );
if ( !empty( $tags ) ) {
      if ( !is_wp_error( $tags ) ) {
            ?>
            <div class="cb pb15">
                  <div class="tag-list">
                        <span class="tags-icon"></span>
                        <ul>
                              <?php
                              foreach ( $tags as $tag ) {
                                    echo '<li><span>' . $tag->name . '</span></li>';
                              }
                              ?>
                        </ul>
                  </div>
            </div>
            <?php
      }
}
?>