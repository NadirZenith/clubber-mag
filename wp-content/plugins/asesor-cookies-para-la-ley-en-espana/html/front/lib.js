
/* ======================================================================================
   @author     Carlos Doral Pérez (http://webartesanal.com)
   @version    0.14
   @copyright  Copyright &copy; 2013-2014 Carlos Doral Pérez, All Rights Reserved
               License: GPLv2 or later
   ====================================================================================== */

//
//
//
var cdp_cookie = {

   // vars
   _id_cookie: 'cdp-cookies-plugin-wp',

   //
   // Compruebo si ya existe la cookie si es visitante nuevo.
   //
   // Modif: 08-ene-2014. Compruebo primero si existe la cookie antes del contenido de la misma
   //
   ya_existe_cookie: function _ya_existe_cookie() {
      if( jQuery.cookie( cdp_cookie._id_cookie ) != null )
         return jQuery.cookie( cdp_cookie._id_cookie ) == 'cdp';
      return false;
   },

   // Guardo cookie
   poner_cookie: function _poner_cookie() {
      return jQuery.cookie( cdp_cookie._id_cookie, 'cdp', { expires: 365, path: '/' } );
   },

   // Elimino cookie
   eliminar: function _eliminar() {
      return jQuery.removeCookie( cdp_cookie._id_cookie );
   },

   // Traigo aviso y lo inserto en el DOM
   // Actualizado: ya no pasa por el admin
   mostrar_aviso: function _mostrar_aviso() {
      jQuery.post( 
         cdp_cookies_info.url_traer_aviso_php,
         { 
            action: 'traer_aviso' 
         }, 
         function( resul ) {
            if( resul.layout == 'pagina' && resul.posicion == 'inferior' )
               jQuery( 'body' ).append( resul.html );
            else
               jQuery( 'body' ).prepend( resul.html );
            if( resul.layout == 'ventana' )
               jQuery( '.cdp-cookies-alerta' ).fadeIn( 500 );
            if( jQuery( '.cdp-cookies-boton-cerrar' ).length > 0 )
               jQuery( '.cdp-cookies-boton-cerrar' ).click( function() {
                  cdp_cookie.poner_cookie();
                  cdp_cookie.ocultar_aviso();
               } );
         },
         'json'
      );
   }, 

   //
   comportamiento: function _comportamiento() {
      return cdp_cookies_info.comportamiento;
   },

   //
   ocultar_aviso: function _ocultar_aviso() {
      if( jQuery( '.cdp-cookies-alerta' ).length > 0 )
         jQuery( '.cdp-cookies-alerta' ).fadeOut( 500 );
   },

   // Preparo la query string
   variables_get: function _variables_get() {
      var url = window.location.href;
      var pares = url.slice( url.indexOf( '?' ) + 1 ).split( '&' );
      var query = {};
      for ( var i = 0 ; i < pares.length ; i++ ) {
         var par = pares[i].split( '=' );
         if( par.length == 1 )
            query[par[0]] = null;
         else
         if( par.length == 2 )
            query[par[0]] = par[1];
      }
      return query;
   },

   // Indica si hay vista previa
   hay_vista_previa: function _hay_vista_previa() {
      return window.location.href.indexOf( '?cdp_cookies_vista_previa=1' ) >= 0;
   },

   // Traigo aviso en vista previa
   // Ya no pasa por el admin
   mostrar_aviso_vista_previa: function _mostrar_aviso_vista_previa() {
      //
      var datos = cdp_cookie.variables_get();
      datos.action = 'traer_aviso';

      //
      jQuery.post( 
         cdp_cookies_info.url_traer_aviso_php, 
         datos,
         function( resul ) {
            if( !resul || !resul.html || resul.html == 0 )
               return;
            if( resul.layout == 'pagina' && resul.posicion == 'inferior' )
               jQuery( 'body' ).append( resul.html );
            else
               jQuery( 'body' ).prepend( resul.html );
            if( resul.layout == 'ventana' )
               jQuery( '.cdp-cookies-alerta' ).fadeIn( 1000 );
         },
         'json'
      );
   },
};
