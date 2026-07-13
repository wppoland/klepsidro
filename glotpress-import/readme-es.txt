=== Plogins Ticker - Countdown Timer for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, countdown, sale, urgency, timer
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.2
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Añade una cuenta atrás de oferta en directo a las páginas de producto de WooCommerce. Sin jQuery, sin saltos de diseño, marcado accesible.

== Description ==

Ticker muestra cuánto tiempo queda de una oferta, directamente en la página del producto. Lee la hora de finalización de las fechas de oferta de WooCommerce de cada producto, o de una única fecha de campaña que establezcas para toda la tienda, y hace la cuenta atrás hasta ese momento.

La hora de finalización se calcula en el servidor, así que hay una única fuente de verdad y el reloj del sistema mal configurado de un visitante no cambia cuándo termina realmente la oferta. El navegador solo formatea el tiempo restante con un pequeño script en JavaScript puro, sin jQuery ni otras dependencias.

La cuenta atrás se apoya en la oferta de WooCommerce que ya gestionas, así que no hay nada extra que programar:

* Lee las «Fechas del precio rebajado» nativas de cada producto desde el primer momento. Establece una fecha de fin de oferta y la cuenta atrás aparece en ese producto.
* O establece una única fecha de fin de campaña para toda la tienda si prefieres que todo cuente hasta el mismo instante. Puedes combinar ambos: gana la fecha de oferta del producto y la fecha de campaña cubre los productos que no tengan una.
* Elige dónde va el temporizador: en el resumen del producto (debajo del precio), antes o después del formulario de añadir al carrito, o en el área de metadatos del producto.
* Tres formatos de tiempo: días/horas/minutos/segundos, horas/minutos/segundos, o un formato compacto de horas/minutos que omite los segundos en campañas más largas.
* Encabezado opcional sobre el reloj y tu propio texto para el mensaje que lo sustituye cuando la oferta termina.
* El marcado se renderiza en el servidor con los recuadros de dígitos ya dimensionados, así que el temporizador no desplaza el diseño cuando JavaScript rellena los números (sin CLS).
* Marcado con `role="timer"` y una región live educada para que los lectores de pantalla puedan anunciarlo; el texto de la etiqueta es traducible.
* Restílalo con propiedades personalizadas de CSS, o copia la plantilla en tu tema en `yourtheme/ticker/single-product/countdown.php` para cambiar el marcado.
* Sin tablas de base de datos personalizadas. Los ajustes están en `wp_options` y se eliminan al quitar el plugin.
* Declara compatibilidad con HPOS y con los bloques de carrito y pago.

El código fuente y el rastreador de incidencias están en GitHub: https://github.com/wppoland/plogins-ticker

== Installation ==

1. Instala y activa WooCommerce 8.0 o posterior.
2. Sube la carpeta `ticker` a `/wp-content/plugins/` o instálala desde la pantalla Plugins.
3. Activa Ticker desde la pantalla <strong>Plugins</strong>.
4. Ve a <strong>WooCommerce → Ticker</strong> y marca «Activar cuenta atrás».
5. Establece una fecha de fin de oferta en un producto (Datos del producto → General → Fechas del precio rebajado) o una fecha de fin de campaña en los ajustes de Ticker. La cuenta atrás aparecerá en la página del producto.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Documentación</strong> - https://plogins.com/es/plogins-ticker/docs/
* <strong>Página del plugin</strong> - https://plogins.com/es/plogins-ticker/
* <strong>Código fuente</strong> - https://github.com/wppoland/plogins-ticker
* <strong>Informes de errores y peticiones de funciones</strong> - https://github.com/wppoland/plogins-ticker/issues


= Does Ticker need WooCommerce? =
Sí. Se conecta a las páginas de producto y a las fechas de oferta de WooCommerce y necesita WooCommerce 8.0 o posterior. Si WooCommerce no está activo, Ticker permanece en silencio y muestra un aviso en la administración.

= Where does the end time come from? =
Por defecto Ticker lee el valor «Fechas del precio rebajado → Hasta» de cada producto. Puedes cambiar la fuente a una única fecha de campaña que aplique en toda la tienda, o dejar la fecha de oferta y además establecer una fecha de campaña: se usa el fin de oferta propio del producto cuando lo tiene; si no, la fecha de campaña.

= Will the timer move my page content around? =
No. La cuenta atrás se renderiza en el servidor con los recuadros de dígitos ya dimensionados, así que el navegador coloca los números en el espacio reservado en lugar de refluir la página. Eso mantiene el Cumulative Layout Shift en cero para el temporizador.

= What if the visitor's computer clock is wrong? =
El momento de fin se envía desde el servidor como una marca de tiempo UTC fija. El navegador solo hace la cuenta atrás hasta ella, así que un reloj mal configurado del visitante no cambia cuándo termina realmente la oferta.

= What shows after the sale ends? =
El reloj se oculta y se sustituye por una breve línea de «oferta finalizada». Puedes establecer tu propio texto o dejar el predeterminado.

= What happens when I delete Ticker? =
Se eliminan sus dos opciones y no quedan tablas, ya que Ticker nunca crea ninguna.


= Does this plugin work on WordPress Multisite? =

Sí. Este plugin es compatible con WordPress Multisite. Actívalo en toda la red o en sitios concretos; cada sitio conserva sus propios ajustes y datos.

== Screenshots ==

1. El temporizador de cuenta atrás de oferta en una página de producto.
2. La página de ajustes: fuente de la cuenta atrás, formato y ubicación.

== External Services ==

Ticker no se conecta a ningún servicio externo. Resuelve la hora de fin de la cuenta atrás íntegramente en tu propio servidor a partir de las «Fechas del precio rebajado» de WooCommerce de cada producto o de una fecha de campaña para toda la tienda que establezcas, y su script `assets/js/ticker.js` solo formatea ese tiempo en el navegador, sin solicitudes a terceros. Tus ajustes se almacenan en las opciones `ticker_settings` y `ticker_db_version` en la tabla `wp_options` de tu sitio; no se crean tablas personalizadas y ningún dato sale de tu sitio.

== Translations ==

Plogins Ticker incluye traducciones al polaco, alemán y español para la interfaz del plugin. El dominio de texto es `plogins-ticker`, así que los paquetes de idioma de WordPress.org también pueden sustituir o ampliar estas traducciones incluidas.

== Changelog ==

= 1.0.2 =
* Añadidas traducciones al polaco, alemán y español para la interfaz del plugin.

= 1.0.1 =
* Primera versión estable.

= 0.1.3 =
* Renombrado a Plogins Ticker para WooCommerce para un nombre de plugin más distintivo.

= 0.1.2 =
* Añade la acción `ticker/countdown_rendered` y `data-ticker-product-id` en el marcado de la cuenta atrás para analítica PRO.

= 0.1.1 =
* Añade el filtro `ticker/end_timestamp` para que PRO y el código personalizado puedan anular la hora de fin de la cuenta atrás resuelta.

= 0.1.0 =
* Primer lanzamiento. Cuenta atrás hasta la fecha de fin de oferta de WooCommerce de un producto o una fecha de campaña para toda la tienda, con ubicación configurable, tres formatos de hora, un encabezado opcional y un mensaje personalizado de oferta finalizada. Renderizado en servidor, sin jQuery, sin saltos de diseño.
