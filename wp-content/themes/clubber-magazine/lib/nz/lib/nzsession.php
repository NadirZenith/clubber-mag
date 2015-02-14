<?php

use Symfony\Component\HttpFoundation\Session\Session;

$NZS = new Session();

$flash_messages = null;

if ( $NZS->getFlashBag()->peekAll() ) {

      $flash_messages = $NZS->getFlashBag()->all();
}

function nzs_display_messages( $auto = true ) {

      global $flash_messages;

      if ( $flash_messages ) {
            ?>
            <div class="nzs-messages" >
                  <div class="nzs-messages-wrapper">
                        <a class="closeMessage" href="#"></a>
                        <?php
                        foreach ( $flash_messages as $type => $messages ) {
                              foreach ( $messages as $message ) {
                                    ?>
                                    <div class="message <?php echo $type ?>">
                                          <p><?php echo $message ?></p>
                                    </div>
                                    <?php
                              }
                        }
                        ?>

                  </div>
            </div>
            <?php ?>
            <script type="text/javascript">
                  jQuery(document).ready(function($) {
                        nzs_messages = $('.nzs-messages');

                        nzs_messages.on('click', function(e) {
                              nzs_messages.fadeOut('fast');
                        });

            <?php if ( $auto ) { ?>
                              setTimeout(function() {
                                    nzs_messages.fadeOut('fast');
                              }, 3000);
            <?php } ?>

                  });
            </script>
            <?php
      }
}
