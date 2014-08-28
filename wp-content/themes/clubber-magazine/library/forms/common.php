<?php

add_filter( 'gform_form_tag', 'gform_form_tag_autocomplete', 11, 2 );

function gform_form_tag_autocomplete( $form_tag, $form ) {
    if ( is_admin() )
        return $form_tag;
    if ( GFFormsModel::is_html5_enabled() && in_array( $form[ 'id' ], array( 5, 6 ) ) ) {
        $form_tag = str_replace( '>', ' autocomplete="off">', $form_tag );
    }
    return $form_tag;
}

add_filter( 'gform_update_post/public_edit', 'gform_update_post_permissions', 11, 2 );

/** @todo nz return true if user has permission to edit resource */
function gform_update_post_permissions() {
    return true;
}

/* add_filter('gform_field_content', 'gform_form_input_autocomplete', 11, 5); */

function gform_form_input_autocomplete( $input, $field, $value, $lead_id, $form_id ) {
    if ( is_admin() )
        return $input;
    if ( GFFormsModel::is_html5_enabled() ) {
        $input = preg_replace( '/<(input|textarea)/', '<${1} autocomplete="off" ', $input );
    }
    return $input;
}

;
?>