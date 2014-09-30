<?php

class NzTplLoop {

      private $container_options;
      private $item_container_options;
      private $item_template;
      public $query;

      public function __construct( $options ) {

            $this->_set_defaults();

            $this->container_options = $options[ 'container' ];
            $this->item_container_options = $options[ 'item_container' ];
            $this->item_template = $options[ 'item_template' ];
            $this->setQuery( $options[ 'query' ] );
      }

      private function _set_defaults() {
            $this->container_options = array(
                  'tag' => 'ul',
                  'id' => '',
                  'class' => ''
            );

            $this->item_container_options = array(
                  'tag' => 'li',
                  'id' => '',
                  'class' => ''
            );

            $this->item_template = array(
                  /** @todo nz change this */
                  'template_part' => 'templates/nz/archive/list-item'
            );
      }

      private function _get_container( $options ) {
            $id = ($options[ 'id' ]) ? sprintf( ' id="%s"', $options[ 'id' ] ) : '';
            $class = ($options[ 'class' ]) ? sprintf( ' class="%s"', $options[ 'class' ] ) : '';
//open
            $container = '<' . $options[ 'tag' ] . $id . $class . ' >%s';

//close
            $container .= '</' . $options[ 'tag' ] . '>';

            return $container;
      }

      public function render() {

            $query = $this->getQuery();

            $item_container = $this->_get_container( $this->item_container_options );

            $buffer = '';
            while ( $query->have_posts() ) : $query->the_post();
                  ob_start();
                  get_template_part( $this->item_template[ 'template_part' ] );
                  $buffer .= sprintf( $item_container, ob_get_clean() );
            endwhile;

            $container = $this->_get_container( $this->container_options );
            $loop = sprintf( $container, $buffer );

            return $loop;
      }

      public function getQuery() {

            if ( !$this->query ) {
                  global $wp_query;
                  $this->query = $wp_query;
            }

            return $this->query;
      }

      public function setQuery( $query ) {
            $this->query = $query;
      }

}
