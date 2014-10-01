<?php
define( 'TWITTER_VIA', 'ClubberMag' ); // facebook app id 

/**
 *    see https://about.twitter.com/resources/buttons#tweet
 */
function nz_tt_tweet( $url = null ) {
      if ( TWITTER_VIA ) {
            $url = ($url) ? $url : get_permalink();
            ?>
            <a href="https://twitter.com/share" class="twitter-share-button" data-text="twitter text" data-url="<?php echo $url ?>" data-via="<?php echo TWITTER_VIA ?>">Tweet</a>
            <script>
                  !function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                        if (!d.getElementById(id)) {
                              js = d.createElement(s);
                              js.id = id;
                              js.src = p + '://platform.twitter.com/widgets.js';
                              fjs.parentNode.insertBefore(js, fjs);
                        }
                  }(document, 'script', 'twitter-wjs');
            </script>

            <?php
      }
}
