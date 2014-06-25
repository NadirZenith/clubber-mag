/* ======================================================================================
   @author     Carlos Doral Pérez (http://webartesanal.com)
   @version    0.15
   @copyright  Copyright &copy; 2013-2014 Carlos Doral Pérez, All Rights Reserved
               License: GPLv2 or later
   ====================================================================================== */

//
//
//
jQuery( document ).ready( function( $ )
{
   // Funcionamiento para depuración desde el admin de Wordpress
   if( cdp_cookie.hay_vista_previa() )
   {
      cdp_cookie.mostrar_aviso_vista_previa();
      return;
   }

   // Si ya hay cookie retorno
   if( cdp_cookie.ya_existe_cookie() )
      return;

   // Comportamiento 'navegar'
   if( cdp_cookie.comportamiento() == 'navegar' )
      cdp_cookie.poner_cookie();

   // Muestro aviso
   cdp_cookie.mostrar_aviso();
} );
