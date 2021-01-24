<?php

Class NzWpLang {

      public $options;
      public $default_locale;
      public $default_lang;
      public $current_locale;
      public $current_lang;
      public $user_locale;
      public $browser_lang;
      public $cookie_lang;
      public $query_lang;

      public function __construct( $options = array() ) {

            $this->options = wp_parse_args( $options, array(
                  'query_var' => 'lang',
                  'supported' => array(
                        'es' => 'es_ES',
                        'en' => 'en_US'
                  ),
                  'cookie' => array(
                        'enabled' => true,
                        'name' => 'cm_lang',
                        'expire' => mktime( 0, 5 ),
                        'path' => '/',
                        'domain' => '/',
                  /* 'secure' => 'cm_lang', */
                  /* 'httponly' => 'cm_lang', */
                  )
                      ) );
            $this->default_locale = get_locale();
            $this->default_lang = $this->_get_lang_from_locale( $this->default_locale );
            $this->_change_locale( $this->default_locale );

            add_filter( 'locale', array( $this, 'filter_get_locale' ) );
            add_action( 'user_register', array( $this, 'set_user_locale' ) );

            if ( is_user_logged_in() && !isset($_GET[$this->options['query_var']]) ) {
                  if ( $this->user_locale = get_user_meta( get_current_user_id(), 'lang', true ) ) {
                        $this->_change_locale( $this->user_locale );
                  } else {
                        $this->init();
                        $this->set_user_locale( get_current_user_id() );
                  }
            } else {
                  $this->init();
            }
      }

      public function init() {
            //set browser locale
            $this->browser_lang = $this->_prefered_browser_language( array_keys( $this->options[ 'supported' ] ) );
            $this->_change_locale( $this->_get_locale_from_lang( $this->browser_lang ) );

            if ( isset( $_GET[ $this->options[ 'query_var' ] ] ) ) {
                  //set query var locale
                  $this->query_lang = $_GET[ $this->options[ 'query_var' ] ];
                  $locale = $this->_get_locale_from_lang( $this->query_lang );
                  $this->_change_locale( $locale );


                  //if query var lang is diferent from default and browser lang
                  // set link filters to keep locale
                  if (
                            $this->query_lang != $this->default_lang //
                            || $this->query_lang != $this->browser_lang
                  ) {
                        add_action( 'init', array( $this, 'filter_links' ) );
                  }

                  if ( $this->options[ 'cookie' ][ 'enabled' ] ) {
                        setcookie( $this->options[ 'cookie' ][ 'name' ], $this->current_lang, time() + 3600, '/' );

                        $update_cookie_name = $this->options[ 'cookie' ][ 'name' ] . '_update';
                        if ( isset( $_COOKIE[ $update_cookie_name ] ) && $_COOKIE[ $update_cookie_name ] == $this->current_lang ) {
                              remove_action( 'init', array( $this, 'filter_links' ) );
                              setcookie( $update_cookie_name, '', time() - 3600, '/' );
                        } else {
                              setcookie( $update_cookie_name, $this->current_lang, time() + 3600, '/' );
                        }
                  }
            } else {

                  if ( $this->options[ 'cookie' ][ 'enabled' ] ) {

                        if ( !isset( $_COOKIE[ $this->options[ 'cookie' ][ 'name' ] ] ) ) {
                              setcookie( $this->options[ 'cookie' ][ 'name' ], $this->current_lang, time() + 3600, '/' );
                        } else {
                              $locale = $this->_get_locale_from_lang( $_COOKIE[ $this->options[ 'cookie' ][ 'name' ] ] );
                              $this->_change_locale( $locale );
                        }
                        $this->cookie_lang = $this->current_lang;
                  }
            }
      }

      public function set_user_locale( $user_id ) {
            update_user_meta( $user_id, 'lang', $this->current_locale );
      }

      public function filter_links() {
            add_filter( 'the_permalink', array( $this, 'append_query_string' ) );
            add_filter( 'term_link', array( $this, 'append_query_string' ) );
            add_filter( 'page_link', array( $this, 'append_query_string' ) );
      }

      public function append_query_string( $url ) {
            return add_query_arg( array( $this->options[ 'query_var' ] => $this->current_lang ), $url );
      }

      public function get_translations( $args = array() ) {

            $o = wp_parse_args( $args, array(
                      ) );

            $supported = $this->options[ 'supported' ];
            $protocol = (!empty( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] !== 'off' || $_SERVER[ 'SERVER_PORT' ] == 443) ? "https://" : "http://";
            $host = $_SERVER[ 'HTTP_HOST' ];
            $uri = strtok( $_SERVER[ "REQUEST_URI" ], '?' );
            $current_url = $protocol . $host . $uri;

            $langs = array();
            foreach ( $supported as $lang => $locale ) {

                  $langs[ $lang ][ 'link' ] = add_query_arg( array( 'lang' => $lang ), $current_url );
                  $langs[ $lang ][ 'current' ] = $lang == $this->current_lang;
            }


            return $langs;
      }

      public function filter_get_locale() {
            return $this->current_locale;
      }

      private function _change_locale( $locale ) {
            $this->current_locale = $locale;
            $this->current_lang = $this->_get_lang_from_locale( $locale );
      }

      private function _get_locale_from_lang( $lang ) {

            if ( isset( $this->options[ 'supported' ][ $lang ] ) ) {
                  return $this->options[ 'supported' ][ $lang ];
            }
            $keys = array_keys( $this->options[ 'supported' ] );

            return $this->options[ 'supported' ][ $keys[ 0 ] ];
      }

      private function _get_lang_from_locale( $locale ) {
            foreach ( $this->options[ 'supported' ] as $langi => $locali ) {
                  if ( $locale == $locali )
                        $lang = $langi;
            }

            if ( empty( $lang ) ) {
                  $lang = $this->options[ 'supported' ][ 0 ];
            }
            return $lang;
      }

      /**
        determine which language out of an available set the user prefers most

        $available_languages        array with language-tag-strings (must be lowercase) that are available
        $http_accept_language    a HTTP_ACCEPT_LANGUAGE string (read from $_SERVER['HTTP_ACCEPT_LANGUAGE'] if left out)
       */
      private function _prefered_browser_language( $available_languages, $http_accept_language = "auto" ) {
            // if $http_accept_language was left out, read it from the HTTP-Header 
            if ( $http_accept_language == "auto" )
                  $http_accept_language = isset( $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] ) ? $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] : '';

            // standard  for HTTP_ACCEPT_LANGUAGE is defined under 
            // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4 
            // pattern to find is therefore something like this: 
            //    1#( language-range [ ";" "q" "=" qvalue ] ) 
            // where: 
            //    language-range  = ( ( 1*8ALPHA *( "-" 1*8ALPHA ) ) | "*" ) 
            //    qvalue         = ( "0" [ "." 0*3DIGIT ] ) 
            //            | ( "1" [ "." 0*3("0") ] ) 
            preg_match_all( "/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?" .
                      "(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/i", $http_accept_language, $hits, PREG_SET_ORDER );

            // default language (in case of no hits) is the first in the array 
            $bestlang = $available_languages[ 0 ];
            $bestqval = 0;

            foreach ( $hits as $arr ) {
                  // read data from the array of this hit 
                  $langprefix = strtolower( $arr[ 1 ] );
                  if ( !empty( $arr[ 3 ] ) ) {
                        $langrange = strtolower( $arr[ 3 ] );
                        $language = $langprefix . "-" . $langrange;
                  } else
                        $language = $langprefix;
                  $qvalue = 1.0;
                  if ( !empty( $arr[ 5 ] ) )
                        $qvalue = floatval( $arr[ 5 ] );

                  // find q-maximal language  
                  if ( in_array( $language, $available_languages ) && ($qvalue > $bestqval) ) {
                        $bestlang = $language;
                        $bestqval = $qvalue;
                  }
                  // if no direct hit, try the prefix only but decrease q-value by 10% (as http_negotiate_language does) 
                  else if ( in_array( $langprefix, $available_languages ) && (($qvalue * 0.9) > $bestqval) ) {
                        $bestlang = $langprefix;
                        $bestqval = $qvalue * 0.9;
                  }
            }
            return $bestlang;
      }

}

$NzWpLang = new NzWpLang( );

function nz_wp_language_selector( $args = array() ) {
      global $NzWpLang;
      $translations = $NzWpLang->get_translations( $args );
      $html = '<select name="lang_choice" id="lang_choice">';
      foreach ( $translations as $language => $lang ) {
            $selected = ($lang[ 'current' ]) ? 'selected="selected"' : '';
            $html .= '<option data-url="' . $lang[ 'link' ] . '" value="' . $language . '" ' . $selected . '>' . $language . '</option>';
      }
      $html .= '</select>';
      $html .= '
                  <script type="text/javascript">
                        //<![CDATA[
                        (function() {

                              var d = document.getElementById("lang_choice");
                              d.onchange = function() {
                                    var $selected = $(this).children(":selected");
                                    location.href = $selected.data("url");
                              }
                        })();
                        //]]>
                  </script>                
';

      return $html;
      /* $("#lang_choice").select2(); */
}
