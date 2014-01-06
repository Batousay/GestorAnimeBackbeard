<?php
// Version: 2.3.2; SPortalHelp
// Last Revision: Tuesday, August 18th by Jade Elizabeth (Alundra).
// This file scares me because there are soooo many words. That's a HAZARD zone for spelling mistakes!

global $helptxt;
 
// Configuration area
$helptxt['sp_ConfigurationArea'] = 'Desde aquí puedes configurar SimplePortal de acuerdo a tus necesidades.';

// General settings
$helptxt['portalactive'] = 'Esto activará el portal.';
$helptxt['sp_portal_mode'] = 'SimplePortal puede usarse en varios modos. Esta opción te permite seleccionar el modo que quieras usar. Los modos son los siguientes:<br /><br />
<strong>Desactivado:</strong> Esto desactivará el portal por completo.<br /><br />
<strong>Página frontal:</strong> Esta es la opción por default. El portal se mostrará en lugar del índice del foro. Los usuarios podrán acceder al índice del foro usando la acción "forum", que puede ser accesada desde el botón "foro".<br /><br />
<strong>Integración:</strong> Esto desactivará el portal. Los bloque solamente pueden ser usados en el foro.<br /><br />
<strong>Independiente:</strong> Esta opción te permite mostrar el portal en una dirección diferente, en otro directorio. El portal aparecerá en la página definida en "URL para el modo independiente". Para más detalles, revisa el archivo SPStandalone.php que se encuentra en el directorio raíz del foro.';
$helptxt['sp_maintenance'] = 'Cuando el modo mantenimiento está activado, el portal sólo será visible para usuarios con el permiso para moderar SimplePortal.';
$helptxt['sp_standalone_url'] = 'Dirección completa para el modo mantenimiento.<br /><br />Ejemplo: http://myforum.com/portal.php';
$helptxt['portaltheme'] = 'Selecciona el theme que será usado en el portal.';
$helptxt['sp_disableForumRedirect'] = 'Esta opción desactivará la redirección ?action=forum , se enviará a la página del portal directamente.';
$helptxt['sp_disableColor'] = 'Si el mod Member Color Link está instalado, esta opción desactivará el mod en el portal (excepto en la lista quién está en línea).';
$helptxt['sp_disable_random_bullets'] = 'Desactiva las pequeñas imágenes de colores que se utilizan en el portal.';
$helptxt['sp_disable_php_validation'] = 'Desactiva la validación de código en el bloque de PHP personalizado, la cuál se utiliza para prevenir errores de sintáxis o de base de datos en el código, no se recomienda desactivar esta opción.';
$helptxt['sp_disable_side_collapse'] = 'Desactiva la habilidad de colapsar los lados del portal.';
$helptxt['sp_resize_images'] = 'Activar el cambiar el tamaño de las imágenes a 300x300px, para prevenir posibles fallos.';

// Block settings
$helptxt['showleft'] = 'Esta opción activará el lado izquierdo del portal y también del foro.';
$helptxt['showright'] = 'Esta opción activará el lado derecho del portal y también del foro.';
$helptxt['leftwidth'] = 'Si el lado izquierdo está activado, puedes seleccionar el ancho de los bloques. el ancho puede ser especificado en pixeles (px) o en porcentajes (%).';
$helptxt['rightwidth'] = 'Si el lado derecho está activado, puedes seleccionar el ancho de los bloques. el ancho puede ser especificado en pixeles (px) o en porcentajes (%).';
$helptxt['sp_enableIntegration'] = 'Esta opción te permite tener bloques dentro del foro. Permite las <em>Opciones avanzadas</em> para cada bloque.';
$helptxt['sp_IntegrationHide'] = 'Esconde los bloques en ciertas secciones del foro. La opción <em>Mostrar bloques en el foro</em> debe de estar activada para que esta opción puede funcionar.';

// Article settings
$helptxt['articleactive'] = 'Esta opción activa los artículos para que se muestren en el portal.';
$helptxt['articleperpage'] = 'Esto establece el máximo número de artículos que se mostrarán en el portal.';
$helptxt['articlelength'] = 'Esta opción te permite establecer un límite para la cantidad de caracteres a mostrar en un artículo. Si el artículo exede el límite, este será cortado y aparecerán puntos suspensivos con un enlace (...) que le permite al usuario leer el resto del artículo.';
$helptxt['articleavatar'] = 'Si esta opción se activa, se mostrará el avatar del autor de cada artículo.';

// Blocks area
$helptxt['sp_BlocksArea'] = 'Los bloques son cajas que pueden ser mostradas en el portal o dentro del foro. Esta sección te permite editar los bloques existentes o crear nuevos.';

// Block list
$helptxt['sp-blocksLeftList'] = 'Estos bloques se mostrarán del lado izquierdo del portal y/o del foro.';
$helptxt['sp-blocksTopList'] = 'Estos bloques están centrados en la parte superior del portal y/o foro.';
$helptxt['sp-blocksBottomList'] = 'Estos bloques están centrados en la parte inferior del portal y/o foro.';
$helptxt['sp-blocksRightList'] = 'Estos bloques se mostrarán del lado derecho del portal y/o del foro.';

// Add/Edit blocks
$helptxt['sp-blocksAdd'] = 'Esta área te permite seleccionar un bloque y configurar sus opciones.';
$helptxt['sp-blocksSelectType'] = 'En esta área puedes crear bloques para el portal. Bloques pre-construidos o personalizados pueden crearse fácilmente configurando sus opciones.';
$helptxt['sp-blocksEdit'] = 'Esta área te permite configurar los bloques seleccionados.';
$helptxt['sp-blocksPermissionType'] = 'esta opción permite usar los permisos en los bloques. Si em usuario necesita estar en todos los grupos de usuario permitidos para ver el bloque, solo uno de lso grupos, o ninguno de los grupos (que sería ignorar los permisos por completo) aquí se puede configurar.
<ul>
<li><strong>Un grupo de usuarios</strong>: El usuario debe de estar en uno de los grupos de usuarios seleciconados para poder ver el bloque.</li>
<li><strong>Todos los grupos de usuarios</strong>: El usuario debe de estar en todos los grupos de usuarios seleccionados para poder ver el bloque.</li>
<li><strong>Ignorar permisos</strong>: Todos los usuarios e invitados pueden ver el bloque.</li>
</ul>';
$helptxt['sp-blocksDisplayOptions'] = 'Mostrar opciones';
$helptxt['sp-blocksCustomDisplayOptions'] = 'Mostrar opciones personalizadas permite un mejor control sobre el bloque.<br /><br />
<strong>Acciones especiales incluyen:</strong><br /><br />
<strong>all:</strong> cada página en el foro.<br />
<strong>portal:</strong> el portal y sus subacciones.<br />
<strong>forum:</strong> todas las acciones y el foro, excepto el portal.<br />
<strong>allaction:</strong> todas las acciones.<br />
<strong>allboard:</strong> todos los foros.<br /><br />
<strong>Wavy (~)</strong><br />
Este simbolo actua como como un comodín, permitiendote incluir acciones dinámicas como ../index.php?issue=* o ../index.php?game=*. usandolas como acciones ~action<br /><br />
<strong>Idkin (|)</strong><br />
Otro simbolo comodín que te permite epecificar el valor exacto para una acción dinámica como ../index.php?issue=1.0 o ../index.php?game=xyz. Debería ser usada junto con "wavy" y después de la acción; ~action|valor<br /><br />
<strong>Negator (-)</strong><br />
Este simbolo es para excluir acciones regulares y dinámicas. Debe de usarse antes del nombre de la acción regular y antes del "wavy" para acciones dinámicas. Usado como -acciónn y -~acción';
$helptxt['sp-blocksStyleOptions'] = 'Estas opciones te permiten especificar el estilo CSS para cada bloque.';

// Articles area
$helptxt['sp_ArticlesArea'] = 'Los Artículos son temas (primer mensaje solamente) que se muestran en el portal. Esta sección te permite modificar los artículos existentes o crear nuevos.';

// Add/Edit articles
$helptxt['sp-articlesAdd'] = 'Agregar';
$helptxt['sp-articlesEdit'] = 'Editar';
$helptxt['sp-articlesCategory'] = 'Selecciona una categoría para esta artículo.';
$helptxt['sp-articlesApproved'] = 'Aprovado';
$helptxt['sp-articlesTopics'] = 'Selecciona los temas que serán mostrados como artículos en el portal.';
$helptxt['sp-articlesBoards'] = 'Selecciona un foro para buscar temas para los artículos.';

// Categories area
$helptxt['sp_CategoriesArea'] = 'Las categorías contienen los artículos. Esta sección configura las categorías existentes, o crea nuevas. Para crear un artículo debe de haber al menos una categoría.';

// Add/Edit categories
$helptxt['sp-categoriesAdd'] = 'Esta sección te permite crear categorías para los artículos. Para crear un artículo debe de haber al menos una categoría.';
$helptxt['sp-categoriesEdit'] = 'Esta sección te permite modificar las categorías existentes.';
$helptxt['sp-categoriesCategories'] = 'Esta página muestra una lista actual de las categorías. Para crear un artículo debe de haber al menos una categoría.';
$helptxt['sp-categoriesDelete'] = 'Al borrar una categoría también se borrarán los artículos que hay en ella, o puedes moverlos a otra categoría.';
// Pages area
$helptxt['sp_PagesArea'] = 'Las páginas pueden ser en código BBC, PHP o HTML se mostrarán dentro de el entorno de tu foro. Esta sección te permite crear, editar y configurar tus páginas.';

// Shoutbox area
$helptxt['sp_ShoutboxArea'] = 'Los Shoutboxes necesitan crearse en esta sección. Esta sección de permite crear y configurar shoutboxes. Un bloque de shoutbox se encesita para poder mostrar el shoutbox que hayas creado.';

// Add/Edit shoutboxes
$helptxt['sp-shoutboxesWarning'] = 'El mensaje de advertencia que pongas aquí se mostrará en la cabecera del shoutbox, cualquier usuario que pueda usar el shoutbox podrá ver este mensaje.';
$helptxt['sp-shoutboxexBBC'] = 'Esta sección te permite escoger los códigos BBC que se podrán usar en este shoutbox.<br /><br />Mantén presionada la tecla CTRL para seleccionar o deseleccionar un BBC en particular. <br /><br />Si deseas seleccionar multiples BBC, entonces  da click en el primero de la lista que deseas seleccionar, mantén presionada la tecla SHIFT, y da click en el ultimo BBC que deseas seleciconar.';

// Block parameters
$helptxt['sp_param_sp_latestMember_limit'] = 'Cuantos usuarios se mostrarán.';
$helptxt['sp_param_sp_boardStats_averages'] = 'Muestra las estadísticas promedio de tu foro.';
$helptxt['sp_param_sp_topPoster_limit'] = 'Cuantos usuarios se mostrarán.';
$helptxt['sp_param_sp_topPoster_type'] = 'El periodo de tiempo que será tomado en cuenta para mostrar a los usuarios.';
$helptxt['sp_param_sp_recent_limit'] = 'Cuantos temas/mensajes se mostrarán.';
$helptxt['sp_param_sp_recent_type'] = 'Mostrar temas o mensajes.';
$helptxt['sp_param_sp_recentPosts_limit'] = 'Cuantos mensajes recientes se mostrarán.';
$helptxt['sp_param_sp_recentTopics_limit'] = 'Cuantos temas recientes se mostrarán.';
$helptxt['sp_param_sp_topTopics_type'] = 'Ordenar temas por respuestas o por vistas.';
$helptxt['sp_param_sp_topTopics_limit'] = 'Cuantos temas se mostrarán.';
$helptxt['sp_param_sp_topBoards_limit'] = 'Cuantos foros se mostrarán.';
$helptxt['sp_param_sp_showPoll_topic'] = 'El ID del tema que contiene la encuesta que se mostrará.';
$helptxt['sp_param_sp_showPoll_type'] = 'Selecciona la forma en que será mostrada la encuesta. Normal te permite mostrar una encuesta llamandola desde su ID, Reciente muestra la encuesta más reciente, y al azar muestra una encuesta al azar.';
$helptxt['sp_param_sp_boardNews_board'] = 'El ID del foro desde donde se tomarán los temas. dejalo en blanco para tomar temas de todos los foros visibles.';
$helptxt['sp_param_sp_boardNews_limit'] = 'El máximo número de noticias que se mostrarán.';
$helptxt['sp_param_sp_boardNews_start'] = 'El ID de un mensaje en particular para empezar desde ese mensaje (de lo contrario el primer mensaje será utilizado).';
$helptxt['sp_param_sp_boardNews_length'] = 'Si esta especificado, los mensajes que exedan este límite serán cortados y se mostrarán unos paréntesis (...), o un "leer más" con un enlace hacia el resto de la noticia.';
$helptxt['sp_param_sp_boardNews_avatar'] = 'Activa los avatares de los autores de los mensajes.';
$helptxt['sp_param_sp_boardNews_per_page'] = 'Cuantos mensajes se mostrarán por página. Déjalo en blanco para desactivar la paginación.';
$helptxt['sp_param_sp_attachmentImage_limit'] = 'Cuantas imágenes adjuntas recientes se mostrarán.';
$helptxt['sp_param_sp_attachmentImage_direction'] = 'Las imágenes adjuntas se pueden alinear de forma horizontal o vertical.';
$helptxt['sp_param_sp_attachmentRecent_limit'] = 'Cuantos archivos adjuntos recientes se mostrarán.';
$helptxt['sp_param_sp_calendar_events'] = 'Activar los eventos del calendario.';
$helptxt['sp_param_sp_calendar_birthdays'] = 'Mostrar cumpleaños en los eventos.';
$helptxt['sp_param_sp_calendar_holidays'] = 'Mostrar días festivos en el calendario.';
$helptxt['sp_param_sp_calendarInformation_events'] = 'Permite que se muestren eventos del calendario.';
$helptxt['sp_param_sp_calendarInformation_future'] = 'Activa eventos futuros del calendario. Esta oción requiere la habilidad de mostrar eventos del calendario. Para mostrar solo eventos de "hoy" usa "0".';
$helptxt['sp_param_sp_calendarInformation_birthdays'] = 'Muestra los cumpleaños del calendario.';
$helptxt['sp_param_sp_calendarInformation_holidays'] = 'Muestra los días festivos del calendario.';
$helptxt['sp_param_sp_rssFeed_url'] = 'Ingresa la dirección completa (URL) del feed RSS.';
$helptxt['sp_param_sp_rssFeed_titles_only'] = 'Muestra los títulos del feed, sin contenido.';
$helptxt['sp_param_sp_rssFeed_count'] = 'cuantos ítems se mostrarán.';
$helptxt['sp_param_sp_rssFeed_limit'] = 'Cuantos caracteres se mostrarán del contenido del feed.';
$helptxt['sp_param_sp_staff_lmod'] = 'Desactiva los moderadores locales de la lista.';
$helptxt['sp_param_sp_articles_limit'] = 'Cuantos artículos se mostrarán.';
$helptxt['sp_param_sp_articles_type'] = 'Muestra artículos al azar, o los últimos.';
$helptxt['sp_param_sp_articles_image'] = 'Activa las imágenes para las categorías, el avatar del usuario, o nada.';
$helptxt['sp_param_sp_gallery_limit'] = 'Cuantas imágenes se mostrarán.';
$helptxt['sp_param_sp_gallery_type'] = 'Muestra imágenes al azar o las últimas imágenes.';
$helptxt['sp_param_sp_gallery_direction'] = 'Las imágenes de la galería pueden alinearse de manera horizontal o vertical.';
$helptxt['sp_param_sp_arcade_limit'] = 'Cuantos ítems se mostrarán.';
$helptxt['sp_param_sp_arcade_type'] = 'Muestra los juegos más populares, los mejores jugadores, o los campeones más antiguos.';
$helptxt['sp_param_sp_shop_style'] = 'Muestra los usuarios más ricos o los ítems de la tienda.';
$helptxt['sp_param_sp_shop_limit'] = 'Cuantos ítems se mostrarán.';
$helptxt['sp_param_sp_shop_type'] = 'Muestra e dinero total de usuario, dinero en su bolsillo, o dinero en el banco.';
$helptxt['sp_param_sp_shop_sort'] = 'Muestra ítems al azar o los más recientes.';
$helptxt['sp_param_sp_blog_limit'] = 'Cuantos ítems se mostrarán.';
$helptxt['sp_param_sp_blog_type'] = 'Muestra artículos de un blog.';
$helptxt['sp_param_sp_blog_sort'] = 'Muestra un blog al azar o el último blog actualizado.';
$helptxt['sp_param_sp_html_content'] = 'Ingresa tu código HTML presonalizado en esta caja.';
$helptxt['sp_param_sp_bbc_content'] = 'Ingresa tu código BBC presonalizado en esta caja.';
$helptxt['sp_param_sp_php_content'] = 'Ingresa tu código PHP presonalizado en esta caja.';

?>