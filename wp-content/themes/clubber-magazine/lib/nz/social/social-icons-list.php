<?php

function nz_fa_social_icons( $socials, $class = '' ) {
      ?>
      <ul <?php echo ($class != '') ? 'class="' . $class . '"' : '' ?>>
            <?php
            foreach ( $socials as $network => $data ) {
                  ?>
                  <li>
                        <a <?php echo (isset( $data[ 'url' ] ) && !empty( $data[ 'url' ] )) ? 'href="' . $data[ 'url' ] . '"' : '' ?> target="_blank">
                              <i class="fa fa-<?php echo $network; ?>"></i>
                        </a>
                  </li>
                  <?php
            }
            ?>

      </ul>
      <?php
}
