<?php

/**
 *  Class for clear between fields
 *
 *  @author     Stefan Gabos <contact@stefangabos.ro>
 *  @copyright  (c) 2006 - 2014 Stefan Gabos
 *  @package    Controls
 */
class Zebra_Form_Nzclear extends Zebra_Form_Control {

      /**
       *  Adds an <div class="row row-clear"></div> row to the form.
       *
       *
       *  @return void
       */
      function __construct( $id, $default = '', $attributes = '' ) {
            // call the constructor of the parent class
            parent::__construct();

            d( $this );
            d( $id );
            d( $default );
            d( $attributes );
            // set the private attributes of this control
            // these attributes are private for this control and are for internal use only
            // and will not be rendered by the _render_attributes() method
            $this->private_attributes = array(
                  'disable_xss_filters',
                  'default_value',
                  'locked',
            );

            // set the default attributes for the text control
            // put them in the order you'd like them rendered
            $this->set_attributes(
                      array(
                            'type' => 'text',
                            'name' => $id,
                            'id' => $id,
                            'value' => $default,
                            'class' => 'control text',
                      )
            );

            // if "class" is amongst user specified attributes
            if ( is_array( $attributes ) && isset( $attributes[ 'class' ] ) ) {
                  // we need to set the "class" attribute like this, so it doesn't overwrite previous values
                  $this->set_attributes( array( 'class' => $attributes[ 'class' ] ), false );

                  // make sure we don't set it again below
                  unset( $attributes[ 'class' ] );
            }

            // sets user specified attributes for the control
            $this->set_attributes( $attributes );
      }

      /**
       *  Generates the control's HTML code.
       *
       *  <i>This method is automatically called by the {@link Zebra_Form::render() render()} method!</i>
       *
       *  @return empty string
       */
      function toHTML() {
            return 'empty';

            return '<input ' . $this->_render_attributes() . ($this->form_properties[ 'doctype' ] == 'xhtml' ? '/' : '') . '>';
      }

}

?>
