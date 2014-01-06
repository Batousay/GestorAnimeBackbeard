<?php
// Version: 2.3.2; SPortalHelp
// Last Revision: Tuesday, August 18th by Jade Elizabeth (Alundra).
// This file scares me because there are soooo many words. That's a HAZARD zone for spelling mistakes!

global $helptxt;

// Configuration area
$helptxt['sp_ConfigurationArea'] = 'Desde aqu&iacute; puedes configurar SimplePortal de acuerdo a tus necesidades.';

// General settings
$helptxt['portalactive'] = 'Esto activar&aacute; el portal.';
$helptxt['sp_portal_mode'] = 'SimplePortal puede usarse en varios modos. Esta opci&oacute;n te permite seleccionar el modo que quieras usar. Los modos son los siguientes:<br /><br />
<strong>Desactivado:</strong> Esto desactivar&aacute; el portal por completo.<br /><br />
<strong>P&aacute;gina frontal:</strong> Esta es la opci&oacute;n por default. El portal se mostrar&aacute; en lugar del &iacute;ndice del foro. Los usuarios podr&aacute;n acceder al &iacute;ndice del foro usando la acci&oacute;n "forum", que puede ser accesada desde el bot&oacute;n "foro".<br /><br />
<strong>Integraci&oacute;n:</strong> Esto desactivar&aacute; el portal. Los bloque solamente pueden ser usados en el foro.<br /><br />
<strong>Independiente:</strong> Esta opci&oacute;n te permite mostrar el portal en una direcci&oacute;n diferente, en otro directorio. El portal aparecer&aacute; en la p&aacute;gina definida en "URL para el modo independiente". Para m&aacute;s detalles, revisa el archivo SPStandalone.php que se encuentra en el directorio ra&iacute;z del foro.';
$helptxt['sp_maintenance'] = 'Cuando el modo mantenimiento est&aacute; activado, el portal s&oacute;lo ser&aacute; visible para usuarios con el permiso para moderar SimplePortal.';
$helptxt['sp_standalone_url'] = 'Direcci&oacute;n completa para el modo mantenimiento.<br /><br />Ejemplo: http://myforum.com/portal.php';
$helptxt['portaltheme'] = 'Selecciona el theme que ser&aacute; usado en el portal.';
$helptxt['sp_disableForumRedirect'] = 'Esta opci&oacute;n desactivar&aacute; la redirecci&oacute;n ?action=forum , se enviar&aacute; a la p&aacute;gina del portal directamente.';
$helptxt['sp_disableColor'] = 'Si el mod Member Color Link est&aacute; instalado, esta opci&oacute;n desactivar&aacute; el mod en el portal (excepto en la lista qui&eacute;n est&aacute; en l&iacute;nea).';
$helptxt['sp_disable_random_bullets'] = 'Desactiva las peque&ntilde;as im&aacute;genes de colores que se utilizan en el portal.';
$helptxt['sp_disable_php_validation'] = 'Desactiva la validaci&oacute;n de c&oacute;digo en el bloque de PHP personalizado, la cu&aacute;l se utiliza para prevenir errores de sint&aacute;xis o de base de datos en el c&oacute;digo, no se recomienda desactivar esta opci&oacute;n.';
$helptxt['sp_disable_side_collapse'] = 'Desactiva la habilidad de colapsar los lados del portal.';
$helptxt['sp_resize_images'] = 'Activar el cambiar el tamaño de las im&aacute;genes a 300x300px, para prevenir posibles fallos.';

// Block settings
$helptxt['showleft'] = 'Esta opci&oacute;n activar&aacute; el lado izquierdo del portal y tambi&eacute;n del foro.';
$helptxt['showright'] = 'Esta opci&oacute;n activar&aacute; el lado derecho del portal y tambi&eacute;n del foro.';
$helptxt['leftwidth'] = 'Si el lado izquierdo est&aacute; activado, puedes seleccionar el ancho de los bloques. el ancho puede ser especificado en pixeles (px) o en porcentajes (%).';
$helptxt['rightwidth'] = 'Si el lado derecho est&aacute; activado, puedes seleccionar el ancho de los bloques. el ancho puede ser especificado en pixeles (px) o en porcentajes (%).';
$helptxt['sp_enableIntegration'] = 'Esta opci&oacute;n te permite tener bloques dentro del foro. Permite las <em>Opciones avanzadas</em> para cada bloque.';
$helptxt['sp_IntegrationHide'] = 'Esconde los bloques en ciertas secciones del foro. La opci&oacute;n <em>Mostrar bloques en el foro</em> debe de estar activada para que esta opci&oacute;n puede funcionar.';

// Article settings
$helptxt['articleactive'] = 'Esta opci&oacute;n activa los art&iacute;culos para que se muestren en el portal.';
$helptxt['articleperpage'] = 'Esto establece el m&aacute;ximo n&uacute;mero de art&iacute;culos que se mostrar&aacute;n en el portal.';
$helptxt['articlelength'] = 'Esta opci&oacute;n te permite establecer un l&iacute;mite para la cantidad de caracteres a mostrar en un art&iacute;culo. Si el art&iacute;culo exede el l&iacute;mite, este ser&aacute; cortado y aparecer&aacute;n puntos suspensivos con un enlace (...) que le permite al usuario leer el resto del art&iacute;culo.';
$helptxt['articleavatar'] = 'Si esta opci&oacute;n se activa, se mostrar&aacute; el avatar del autor de cada art&iacute;culo.';

// Blocks area
$helptxt['sp_BlocksArea'] = 'Los bloques son cajas que pueden ser mostradas en el portal o dentro del foro. Esta secci&oacute;n te permite editar los bloques existentes o crear nuevos.';

// Block list
$helptxt['sp-blocksLeftList'] = 'Estos bloques se mostrar&aacute;n del lado izquierdo del portal y/o del foro.';
$helptxt['sp-blocksTopList'] = 'Estos bloques est&aacute;n centrados en la parte superior del portal y/o foro.';
$helptxt['sp-blocksBottomList'] = 'Estos bloques est&aacute;n centrados en la parte inferior del portal y/o foro.';
$helptxt['sp-blocksRightList'] = 'Estos bloques se mostrar&aacute;n del lado derecho del portal y/o del foro.';

// Add/Edit blocks
$helptxt['sp-blocksAdd'] = 'Esta &aacute;rea te permite seleccionar un bloque y configurar sus opciones.';
$helptxt['sp-blocksSelectType'] = 'En esta &aacute;rea puedes crear bloques para el portal. Bloques pre-construidos o personalizados pueden crearse f&aacute;cilmente configurando sus opciones.';
$helptxt['sp-blocksEdit'] = 'Esta &aacute;rea te permite configurar los bloques seleccionados.';
$helptxt['sp-blocksPermissionType'] = 'esta opci&oacute;n permite usar los permisos en los bloques. Si em usuario necesita estar en todos los grupos de usuario permitidos para ver el bloque, solo uno de lso grupos, o ninguno de los grupos (que ser&iacute;a ignorar los permisos por completo) aqu&iacute; se puede configurar.
<ul>
<li><strong>Un grupo de usuarios</strong>: El usuario debe de estar en uno de los grupos de usuarios seleciconados para poder ver el bloque.</li>
<li><strong>Todos los grupos de usuarios</strong>: El usuario debe de estar en todos los grupos de usuarios seleccionados para poder ver el bloque.</li>
<li><strong>Ignorar permisos</strong>: Todos los usuarios e invitados pueden ver el bloque.</li>
</ul>';
$helptxt['sp-blocksDisplayOptions'] = 'Mostrar opciones';
$helptxt['sp-blocksCustomDisplayOptions'] = 'Mostrar opciones personalizadas permite un mejor control sobre el bloque.<br /><br />
<strong>Acciones especiales incluyen:</strong><br /><br />
<strong>all:</strong> cada p&aacute;gina en el foro.<br />
<strong>portal:</strong> el portal y sus subacciones.<br />
<strong>forum:</strong> todas las acciones y el foro, excepto el portal.<br />
<strong>allaction:</strong> todas las acciones.<br />
<strong>allboard:</strong> todos los foros.<br /><br />
<strong>Wavy (~)</strong><br />
Este simbolo actua como como un comod&iacute;n, permitiendote incluir acciones din&aacute;micas como ../index.php?issue=* o ../index.php?game=*. usandolas como acciones ~action<br /><br />
<strong>Idkin (|)</strong><br />
Otro simbolo comod&iacute;n que te permite epecificar el valor exacto para una acci&oacute;n din&aacute;mica como ../index.php?issue=1.0 o ../index.php?game=xyz. Deber&iacute;a ser usada junto con "wavy" y despu&eacute;s de la acci&oacute;n; ~action|valor<br /><br />
<strong>Negator (-)</strong><br />
Este simbolo es para excluir acciones regulares y din&aacute;micas. Debe de usarse antes del nombre de la acci&oacute;n regular y antes del "wavy" para acciones din&aacute;micas. Usado como -acci&oacute;nn y -~acci&oacute;n';
$helptxt['sp-blocksStyleOptions'] = 'Estas opciones te permiten especificar el estilo CSS para cada bloque.';

// Articles area
$helptxt['sp_ArticlesArea'] = 'Los Art&iacute;culos son temas (primer mensaje solamente) que se muestran en el portal. Esta secci&oacute;n te permite modificar los art&iacute;culos existentes o crear nuevos.';

// Add/Edit articles
$helptxt['sp-articlesAdd'] = 'Agregar';
$helptxt['sp-articlesEdit'] = 'Editar';
$helptxt['sp-articlesCategory'] = 'Selecciona una categor&iacute;a para esta art&iacute;culo.';
$helptxt['sp-articlesApproved'] = 'Aprovado';
$helptxt['sp-articlesTopics'] = 'Selecciona los temas que ser&aacute;n mostrados como art&iacute;culos en el portal.';
$helptxt['sp-articlesBoards'] = 'Selecciona un foro para buscar temas para los art&iacute;culos.';

// Categories area
$helptxt['sp_CategoriesArea'] = 'Las categor&iacute;as contienen los art&iacute;culos. Esta secci&oacute;n configura las categor&iacute;as existentes, o crea nuevas. Para crear un art&iacute;culo debe de haber al menos una categor&iacute;a.';

// Add/Edit categories
$helptxt['sp-categoriesAdd'] = 'Esta secci&oacute;n te permite crear categor&iacute;as para los art&iacute;culos. Para crear un art&iacute;culo debe de haber al menos una categor&iacute;a.';
$helptxt['sp-categoriesEdit'] = 'Esta secci&oacute;n te permite modificar las categor&iacute;as existentes.';
$helptxt['sp-categoriesCategories'] = 'Esta p&aacute;gina muestra una lista actual de las categor&iacute;as. Para crear un art&iacute;culo debe de haber al menos una categor&iacute;a.';
$helptxt['sp-categoriesDelete'] = 'Al borrar una categor&iacute;a tambi&eacute;n se borrar&aacute;n los art&iacute;culos que hay en ella, o puedes moverlos a otra categor&iacute;a.';
// Pages area
$helptxt['sp_PagesArea'] = 'Las p&aacute;ginas pueden ser en c&oacute;digo BBC, PHP o HTML se mostrar&aacute;n dentro de el entorno de tu foro. Esta secci&oacute;n te permite crear, editar y configurar tus p&aacute;ginas.';

// Shoutbox area
$helptxt['sp_ShoutboxArea'] = 'Los Shoutboxes necesitan crearse en esta secci&oacute;n. Esta secci&oacute;n de permite crear y configurar shoutboxes. Un bloque de shoutbox se encesita para poder mostrar el shoutbox que hayas creado.';

// Add/Edit shoutboxes
$helptxt['sp-shoutboxesWarning'] = 'El mensaje de advertencia que pongas aqu&iacute; se mostrar&aacute; en la cabecera del shoutbox, cualquier usuario que pueda usar el shoutbox podr&aacute; ver este mensaje.';
$helptxt['sp-shoutboxexBBC'] = 'Esta secci&oacute;n te permite escoger los c&oacute;digos BBC que se podr&aacute;n usar en este shoutbox.<br /><br />Mant&eacute;n presionada la tecla CTRL para seleccionar o deseleccionar un BBC en particular. <br /><br />Si deseas seleccionar multiples BBC, entonces  da click en el primero de la lista que deseas seleccionar, mant&eacute;n presionada la tecla SHIFT, y da click en el ultimo BBC que deseas seleciconar.';

// Block parameters
$helptxt['sp_param_sp_latestMember_limit'] = 'Cuantos usuarios se mostrar&aacute;n.';
$helptxt['sp_param_sp_boardStats_averages'] = 'Muestra las estad&iacute;sticas promedio de tu foro.';
$helptxt['sp_param_sp_topPoster_limit'] = 'Cuantos usuarios se mostrar&aacute;n.';
$helptxt['sp_param_sp_topPoster_type'] = 'El periodo de tiempo que ser&aacute; tomado en cuenta para mostrar a los usuarios.';
$helptxt['sp_param_sp_recent_limit'] = 'Cuantos temas/mensajes se mostrar&aacute;n.';
$helptxt['sp_param_sp_recent_type'] = 'Mostrar temas o mensajes.';
$helptxt['sp_param_sp_recentPosts_limit'] = 'Cuantos mensajes recientes se mostrar&aacute;n.';
$helptxt['sp_param_sp_recentTopics_limit'] = 'Cuantos temas recientes se mostrar&aacute;n.';
$helptxt['sp_param_sp_topTopics_type'] = 'Ordenar temas por respuestas o por vistas.';
$helptxt['sp_param_sp_topTopics_limit'] = 'Cuantos temas se mostrar&aacute;n.';
$helptxt['sp_param_sp_topBoards_limit'] = 'Cuantos foros se mostrar&aacute;n.';
$helptxt['sp_param_sp_showPoll_topic'] = 'El ID del tema que contiene la encuesta que se mostrar&aacute;.';
$helptxt['sp_param_sp_showPoll_type'] = 'Selecciona la forma en que ser&aacute; mostrada la encuesta. Normal te permite mostrar una encuesta llamandola desde su ID, Reciente muestra la encuesta m&aacute;s reciente, y al azar muestra una encuesta al azar.';
$helptxt['sp_param_sp_boardNews_board'] = 'El ID del foro desde donde se tomar&aacute;n los temas. dejalo en blanco para tomar temas de todos los foros visibles.';
$helptxt['sp_param_sp_boardNews_limit'] = 'El m&aacute;ximo n&uacute;mero de noticias que se mostrar&aacute;n.';
$helptxt['sp_param_sp_boardNews_start'] = 'El ID de un mensaje en particular para empezar desde ese mensaje (de lo contrario el primer mensaje ser&aacute; utilizado).';
$helptxt['sp_param_sp_boardNews_length'] = 'Si esta especificado, los mensajes que exedan este l&iacute;mite ser&aacute;n cortados y se mostrar&aacute;n unos par&eacute;ntesis (...), o un "leer m&aacute;s" con un enlace hacia el resto de la noticia.';
$helptxt['sp_param_sp_boardNews_avatar'] = 'Activa los avatares de los autores de los mensajes.';
$helptxt['sp_param_sp_boardNews_per_page'] = 'Cuantos mensajes se mostrar&aacute;n por p&aacute;gina. D&eacute;jalo en blanco para desactivar la paginaci&oacute;n.';
$helptxt['sp_param_sp_attachmentImage_limit'] = 'Cuantas im&aacute;genes adjuntas recientes se mostrar&aacute;n.';
$helptxt['sp_param_sp_attachmentImage_direction'] = 'Las im&aacute;genes adjuntas se pueden alinear de forma horizontal o vertical.';
$helptxt['sp_param_sp_attachmentRecent_limit'] = 'Cuantos archivos adjuntos recientes se mostrar&aacute;n.';
$helptxt['sp_param_sp_calendar_events'] = 'Activar los eventos del calendario.';
$helptxt['sp_param_sp_calendar_birthdays'] = 'Mostrar cumplea&ntilde;os en los eventos.';
$helptxt['sp_param_sp_calendar_holidays'] = 'Mostrar d&iacute;as festivos en el calendario.';
$helptxt['sp_param_sp_calendarInformation_events'] = 'Permite que se muestren eventos del calendario.';
$helptxt['sp_param_sp_calendarInformation_future'] = 'Activa eventos futuros del calendario. Esta oci&oacute;n requiere la habilidad de mostrar eventos del calendario. Para mostrar solo eventos de "hoy" usa "0".';
$helptxt['sp_param_sp_calendarInformation_birthdays'] = 'Muestra los cumplea&ntilde;os del calendario.';
$helptxt['sp_param_sp_calendarInformation_holidays'] = 'Muestra los d&iacute;as festivos del calendario.';
$helptxt['sp_param_sp_rssFeed_url'] = 'Ingresa la direcci&oacute;n completa (URL) del feed RSS.';
$helptxt['sp_param_sp_rssFeed_titles_only'] = 'Muestra los t&iacute;tulos del feed, sin contenido.';
$helptxt['sp_param_sp_rssFeed_count'] = 'cuantos &iacute;tems se mostrar&aacute;n.';
$helptxt['sp_param_sp_rssFeed_limit'] = 'Cuantos caracteres se mostrar&aacute;n del contenido del feed.';
$helptxt['sp_param_sp_staff_lmod'] = 'Desactiva los moderadores locales de la lista.';
$helptxt['sp_param_sp_articles_limit'] = 'Cuantos art&iacute;culos se mostrar&aacute;n.';
$helptxt['sp_param_sp_articles_type'] = 'Muestra art&iacute;culos al azar, o los &uacute;ltimos.';
$helptxt['sp_param_sp_articles_image'] = 'Activa las im&aacute;genes para las categor&iacute;as, el avatar del usuario, o nada.';
$helptxt['sp_param_sp_gallery_limit'] = 'Cuantas im&aacute;genes se mostrar&aacute;n.';
$helptxt['sp_param_sp_gallery_type'] = 'Muestra im&aacute;genes al azar o las &uacute;ltimas im&aacute;genes.';
$helptxt['sp_param_sp_gallery_direction'] = 'Las im&aacute;genes de la galer&iacute;a pueden alinearse de manera horizontal o vertical.';
$helptxt['sp_param_sp_arcade_limit'] = 'Cuantos &iacute;tems se mostrar&aacute;n.';
$helptxt['sp_param_sp_arcade_type'] = 'Muestra los juegos m&aacute;s populares, los mejores jugadores, o los campeones m&aacute;s antiguos.';
$helptxt['sp_param_sp_shop_style'] = 'Muestra los usuarios m&aacute;s ricos o los &iacute;tems de la tienda.';
$helptxt['sp_param_sp_shop_limit'] = 'Cuantos &iacute;tems se mostrar&aacute;n.';
$helptxt['sp_param_sp_shop_type'] = 'Muestra e dinero total de usuario, dinero en su bolsillo, o dinero en el banco.';
$helptxt['sp_param_sp_shop_sort'] = 'Muestra &iacute;tems al azar o los m&aacute;s recientes.';
$helptxt['sp_param_sp_blog_limit'] = 'Cuantos &iacute;tems se mostrar&aacute;n.';
$helptxt['sp_param_sp_blog_type'] = 'Muestra art&iacute;culos de un blog.';
$helptxt['sp_param_sp_blog_sort'] = 'Muestra un blog al azar o el &uacute;ltimo blog actualizado.';
$helptxt['sp_param_sp_html_content'] = 'Ingresa tu c&oacute;digo HTML presonalizado en esta caja.';
$helptxt['sp_param_sp_bbc_content'] = 'Ingresa tu c&oacute;digo BBC presonalizado en esta caja.';
$helptxt['sp_param_sp_php_content'] = 'Ingresa tu c&oacute;digo PHP presonalizado en esta caja.';

?>