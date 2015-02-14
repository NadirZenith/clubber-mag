<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * https://dev.twitter.com/overview/api/response-codes
 * CODE           TEXT              DESCRIPTION
 * 200            OK                Publicado com sucesso, Mensagem recebida
 * 
 * 304            Not Modified      
 * 
 * 400            Bad Request
 * 401            Unauthorized
 * 403            Forbidden
 * 404            Not Found
 * ...
 * 
 * 500            Internal Server Error
 * 
 */

class NzAjaxResponse {

      public function __construct( $message = '', $data = null, $redirect_url = null, $code = 200 ) {

            if ( $code === 200 )
                  $response = array( 'success' => true );
            else
                  $response = array( 'success' => false );

            if ( isset( $redirect_url ) ) {
                  $response[ 'redirect' ] = true;
                  $response[ 'url' ] = $redirect_url;
            } else {
                  if ( isset( $message ) ) {
                        if ( is_array( $message ) ) {
                              $full = '';
                              foreach ( $message as $msg ) {
                                    $full.= $msg . ' - ';
                              }
                              $response[ 'message' ] = '$full';
                        } else {
                              $response[ 'message' ] = $message;
                        }
                  }

                  if ( isset( $data ) )
                        $response[ 'data' ] = $data;
            }

            wp_send_json( $response );
            die();
      }

}
