<?php


add_shortcode( 'cm-col', 'cm_col_shortcode' );

function cm_col_shortcode( $atts, $content = null ) {

      $a = shortcode_atts( array(
            'class' => 'col-1'
                ), $atts );
    
      ob_start();
      ?>
      <div class="<?php echo $a[ 'class' ] ?>" style="margin: auto">
            <?php echo do_shortcode( $content ); ?>
      </div>
      <?php
      return ob_get_clean();
}

add_shortcode( 'nz-form', 'nz_form_shortcode' );

function nz_form_shortcode( $atts ) {

      $a = shortcode_atts( array(
            'name' => null
                ), $atts );

      if ( $a[ 'name' ] ) {
            global $nz;
            echo $nz[ $a[ 'name' ] ];
      }
}
