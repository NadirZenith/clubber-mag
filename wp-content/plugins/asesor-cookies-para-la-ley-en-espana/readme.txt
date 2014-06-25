=== Asesor de Cookies para normativa española ===
Contributors: Carlos Doral Pérez (<a href="http:://webartesanal.com">webartesanal.com</a>)
Tags: cookie, cookies, spain, ley, law, politica, policy, españa, normativa
Requires at least: 3.5
Tested up to: 3.8.1
Stable tag: 0.18
License: GPLv2 or later

Este plugin le va a facilitar la confección de la política de cookies para su sitio web proporcionándole los textos legales y técnicos iniciales.

== Description ==

El funcionamiento consiste en mostrar un mensaje cada vez que un nuevo usuario visita su web avisándole que si sigue navegando o si pulsa el botón CERRAR/ACEPTAR del aviso está aceptando la recepción de cookies y la política de cookies.

Este plugin le proporciona los textos legales y técnicos iniciales que necesita su web para confeccionar su política de cookies, se generan automáticamente y los puede editar si lo desea. Estos textos son la política de cookies, la descripción técnica de las cookies y las instrucciones de manipulación de cookies desde los navegadores más populares, todo ello para que el usuario web tenga la máxima información posible.

Características del plugin:

* Muestra un aviso sobre la utilización de cookies a cada usuario nuevo de su web.
* Permite configurar la posición del aviso (inferior, superior) y el comportamiento (bajo qué condiciones desaparece), el lugar de inclusión (en página o en ventana), tamaño de fuente, elegir entre 5 colores, el texto ahora es editable y se incorpora un modo 'vista previa'.
* Permite crear automáticamente las dos páginas con los textos legales y técnicos iniciales que necesita su web: La política de cookies y la descripción coloquial de cookies para los usuarios web. Las páginas son editables.
 
== Screenshots ==

1. Así aparecerá el aviso de cookies al visitante de su web. 
2. Panel de configuración que permite cambiar los colores, posición del aviso, etc.

== Installation ==

1. Descargue el plugin, descomprímalo y súbalo al directorio /wp-content/plugins/
2. Vaya al apartado plugins y active el Asesor de Cookies.
3. Vaya a Herramientas, Asesor de Cookies.
4. Pinche el botón 'Generar Páginas' y luego 'Guardar'.
5. El plugin ya está funcionando con los textos legales por defecto. Si quiere editarlos vaya a Páginas y ahí verá las dos nuevas páginas que ha creado el plugin, la de 'Política de cookies' y la de 'Más información sobre las cookies' que es totalmente técnica y no tendrá que modificar.
6. Es conveniente que añada en su menú o en el pié de página de su web un enlace 'Política de cookies' visible que debe apuntar a la página que ha creado sobre la política de cookies.

Si lo desea, como método alternativo de instalación puede ir a la sección Plugins y hacer lo siguiente:

1. Pulse 'Añadir nuevo'.
2. En el buscador escriba 'asesor cookies'.
3. Haga click en 'Instalar'.
4. Ahora siga desde el paso 2 de la sección anterior.

== Changelog ==

= 0.18 =
* En algunas instalaciones se producian definiciones duplicadas en traer_aviso.php. Gracias a Mikel Gutierrez por su soporte.
* Se renuevan banners.

= 0.17 =
* Errores al subir al repositorio svn.

= 0.16 =
* Errores al subir al repositorio svn.

= 0.15 =
* Validación W3C, la inclusión de CSS no validaba, gracias por avisar Julio!
* El plugin ahora funciona correctamente si el directorio de administración WP tiene protección .htaccess. Gracias a Antonio Rodríguez por avisar.
* Banner superior en admin.

= 0.14 =
* Opción a incluir un botón CERRAR o ACEPTAR en el aviso.
* Pequeños detalles Javascript para prevención de conflictos con otros plugins.
* Algunos detalles en CSS
* Inclusión de enlace al plugin

= 0.13 =
* El texto del aviso ahora es editable.
* Se puede cambiar el tamaño de fuente.
* Corregido error que aparecía cuando un usuario no administrador entraba al back de WP.

= 0.12 =
* readme.txt actualizado y capturas de pantalla.

= 0.11 =
* Versión inicial.

== Troubleshooting ==

Si este plugin no te funciona correctamente prueba a hacer lo siguiente:
* Borra el caché de tu navegador, a veces se quedan versiones antiguas de archivos CSS y JS.
* Si utilizas algún sistema de caché en tu instalación WordPress prueba a borrar dicho caché.

Si te sigue fallando puede ser porque otro plugin genere errores Javascript y esto impide el funcionamiento del Asesor de Cookies. Puedes probar a desactivar otros plugins para saber cuál está dando problemas.


