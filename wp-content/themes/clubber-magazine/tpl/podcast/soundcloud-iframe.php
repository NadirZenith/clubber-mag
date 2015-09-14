<?php
if ($sc_info_str = get_post_meta(get_the_ID(), CM_META_SOUNDCLOUD, true)) {

    $sc_info = json_decode($sc_info_str);
     /*d( $sc_info_str, $sc_info ); */
    if ($sc_info) {
        $visual = is_front_page() ? false : true;
        ?>
        <div class="cb">
            <?php
/*            
            d(
             nz_get_soundcloud_iframe($sc_info->uri, array('visual' => $visual))
                );
 */
            echo nz_get_soundcloud_iframe($sc_info->uri, array('visual' => $visual));
            ?>
        </div>
        <?php
    }
}