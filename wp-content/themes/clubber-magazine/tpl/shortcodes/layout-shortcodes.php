<?php

/*add_shortcode( 'nz-form', 'nz_form_shortcode' );*/

function nz_form_shortcode( $atts ) {

      $a = shortcode_atts( array(
            'name' => null
                ), $atts );

      if ( $a[ 'name' ] ) {
            global $nz;
            echo $nz[ $a[ 'name' ] ];
      }
}
