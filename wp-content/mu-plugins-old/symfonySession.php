<?php

/**
  DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
  Version 2, December 2004

  Copyright (C) 2014 nadirzenith <nz@nadirzenith.net>

  Everyone is permitted to copy and distribute verbatim or modified
  copies of this license document, and changing it is allowed as long
  as the name is changed.

  DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO.
 */
/*
  // set and get session attributes
  $NZS->set('name', 'Drak');
  $NZS->get('name');

 */

/*
  $NZS->getFlashBag()->add('info', 'information');
  $NZS->getFlashBag()->add('warning', 'warning');
  $NZS->getFlashBag()->add('success', 'success');
  $NZS->getFlashBag()->add('error', 'error');
 */


use Symfony\Component\HttpFoundation\Session\Session;
/*use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;*/

/* $NZS = new Session(new PhpBridgeSessionStorage()); */
$NZS = new Session();
/* $NZS->start(); */

function nzs_display_messages($auto = true) {

        global $NZS;

        if ($NZS->getFlashBag()->peekAll()) {
                ?>
                <div class="nzs-messages" >
                        <div class="nzs-messages-wrapper">
                                <a class="closeMessage" href="#"></a>
                                <?php
                                foreach ($NZS->getFlashBag()->all() as $type => $messages) {
                                        foreach ($messages as $message) {
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

                <?php if ($auto) { ?>
                                        setTimeout(function() {
                                                nzs_messages.fadeOut('fast');
                                        }, 3000);
                                        /*
                                         */
                <?php } ?>
                        });
                </script>
                <?php
        }
}

function nzs_get_messages() {
        
}
