<?php

switch ( get_query_var( 'taxonomy' ) ) {
      case 'cool_place_type':
            get_template_part( 'archive-cool-place' );

            break;
      case 'music_type':
            get_template_part( 'archive' );

            break;
      case 'city':
            get_template_part( 'archive-agenda' );

            break;

      default:
            break;
}
?>