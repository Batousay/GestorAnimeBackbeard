<?php
// Version: 2.3.2; SPortal
// Last Revision: Thursday, August 27th by Jade Elizabeth (Alundra).
// I wonder where all the words went..
// Sinan ate them...

global $scripturl, $context; 
 
// General strings
$txt['sp-forum'] = 'Foro';
$txt['sp-portal'] = 'Portal';
$txt['sp-adminTitle'] = 'SimplePortal Administración';
$txt['sp-adminCatTitle'] = 'SimplePortal';
$txt['sp-add_article'] = 'Agregar como artículo';
$txt['sp-remove_article'] = 'Remover de artículo';
$txt['sp-dot'] = 'Punto';
$txt['sp-arrow'] = 'Flecha';
$txt['sp-star'] = 'Estrella';
$txt['sp_yes'] = 'Si';
$txt['sp_no'] = 'No';
$txt['sp_function_unknown_label'] = 'Tipo de bloque desconocido.';

// Block specific strings
$txt['sp-usertmessage'] = 'Mensajes totales';
$txt['sp-usernmessage'] = 'Nuevos mensajes';
$txt['sp-articlesComments'] = 'Comentarios';
$txt['sp-articlesViews'] = 'Vistas';
$txt['sp-articlesPages'] = 'Páginas';
$txt['sp-downloadsCount'] = 'Descargas';
$txt['sp-downloadsPoster'] = 'Escrito por';
$txt['sp_calendar_noEventsFound'] = '¡Lo siento, no hay eventos en el calendario para este día!.';
$txt['sp_calendar_events'] = 'Eventos de hoy.';
$txt['sp_calendar_upcomingEvents'] = 'Próximos eventos';
$txt['sp_calendar_holidays'] = 'Días festivos.';
$txt['sp_calendar_birthdays'] = 'Cumpleaños.';
$txt['sp-pollViewTopic'] = 'Ver Tema';
$txt['sp-read_more'] = 'Leer más';
$txt['sp-downloadsSize'] = 'Tamaño';
$txt['sp-average_posts'] = 'Mensajes promedio';
$txt['sp-average_topics'] = 'Temas promedio';
$txt['sp-average_members'] = 'Usuarios promedio';
$txt['sp-average_online'] = 'En linea promedio';
$txt['sp-online_today'] = 'En linea hoy';
$txt['sp-theme_change'] = 'Cambiar';
$txt['sp-theme_permanent'] = 'Permanentemente';
$txt['sp-game_plays'] = 'Reproducicones';
$txt['sp-game_rating'] = 'Clasificación';
$txt['sp-games'] = 'juegos';
$txt['sp-champ_duration'] = 'Duració';
$txt['sp_shoutbox_title'] = 'Shoutbox';
$txt['sp_shoutbox_button'] = '¡Habla!';
$txt['sp_shoutbox_no_shout'] = '¡Todavía no hay ningún shoutbox!';
$txt['sp_shoutbox_refresh'] = 'Refrescar';
$txt['sp_shoutbox_history'] = 'Historia';
$txt['sp_shoutbox_smiley'] = 'Smileys';
$txt['sp_shoutbox_style'] = 'Estilo';
$txt['sp_topstats_unknown_type'] = 'Tipo de estadisticas desconocido o no soportado.';
$txt['sp_topstats_type_error'] = 'Configuración de tipo incompleta.';
$txt['sp_sashop_no_exist'] = 'Lo sineto, no se pudo encontrar la instalació del Mod SA Shop.';
$txt['sp_shop_no_exist'] = 'Lo siento, no se pudo encontrar la instalació del Mod SMF Shop.';
$txt['sp_eliana_no_exist'] = 'Lo siento, no se pudo encontrar la instalació del Mod Automatic Karma system modification, está desactivado o no está instalado.';
$txt['sp_thankomatic_no_exist'] = 'Lo siento, no se pudo encontrar la instalació del Mod Thank-O-Matic.';
$txt['sp_reputation_no_exist'] = 'Lo siento, no se pudo encontrar la instalació del ModAdvanced Reputation modification, está desactivado o no está instalado.';
$txt['sp_karma_is_disabled'] = 'Karma está desactivado.';
$txt['sp_topStatsMember_total_time_logged_in'] = 'Tiempo total en línea';
$txt['sp_topStatsMember_Posts'] = 'Mensajes';
$txt['sp_topStatsMember_Karma_Good'] = 'Karma positivo';
$txt['sp_topStatsMember_Karma_Bad'] = 'Karma negativo';
$txt['sp_topStatsMember_Karma_Total'] = 'Karma total';
$txt['sp_topStatsMember_Thank-O-Matic_Top_Given'] = 'Agradecimientos enviados';
$txt['sp_topStatsMember_Thank-O-Matic_Top_Recived'] = 'Agradecimientos recibidos';
$txt['sp_topStatsMember_Automatic_Karma_Good'] = 'Karma automático positivo';
$txt['sp_topStatsMember_Automatic_Karma_Bad'] = 'Karma automático negativo';
$txt['sp_topStatsMember_Automatic_Karma_Total'] = 'Karma automático total';
$txt['sp_topStatsMember_Advanced_Reputation_System_Best'] = 'Advanced Reputation System  mejor';
$txt['sp_topStatsMember_Advanced_Reputation_System_Worst'] = 'Advanced Reputation System peor';
$txt['sp_topStatsMember_SMF_Shop_Money'] = 'SMF Shop Dinero';
$txt['sp_topStatsMember_SA_Shop_Cash'] = 'SA Shop Dinero';
$txt['sp_topStatsMember_SA_Shop_Trades'] = 'SA Shop Cambios';
$txt['sp_topStatsMember_SA_Shop_Purchase'] = 'SA Shop Compras';
$txt['sp_topStatsMember_Casino'] = 'dinero de casino';

// Who area strings
$txt['sp_who_index'] = 'Viendo el <a href="' . $scripturl . '">Portal</a>.';
$txt['sp_who_forum'] = 'Viendo el <a href="' . $scripturl . '?action=forum">Foro</a>.';
$txt['sp_who_page'] = 'Viendo la página "<a href="' . $scripturl . '?page=%1$s">%2$s</a>".';

// Error messages
$txt['error_sp_no_message_id'] = 'ID del mensaje inválido.';
$txt['error_sp_article_exists'] = 'Este artículo ya existe.';
$txt['error_sp_cannot_add_article'] = 'no tienes permiso para agregar artículos.';
$txt['error_sp_cannot_remove_article'] = 'Lo siento, no tienes permiso para borrar artículos.';
$txt['error_sp_name_empty'] = 'el campo "nombre" está vacio.';
$txt['error_sp_no_category'] = 'Lo siento, los artículos requieren categorias para ser publicados, por favor, crea una categorìa para poder publicar tu artículo.';
$txt['error_sp_no_category_normaluser'] = 'Lo siento, Los artículos requieren categorias para ser publicados, por favor, pídele a un administrador que cree una categoria para tu artículo.';
$txt['error_sp_no_category_sp_moderator'] = 'Una nueva categoría ha sido creada <a href="%s">aquí</a>.';
$txt['error_sp_side_wrong'] = 'Lado equivocado seleccionado.';
$txt['error_sp_block_wrong'] = 'Bloque equivocado seleccionado.';
$txt['error_sp_php_syntax'] = 'Hay un error de sintáxis en el código del bloque. Por favor, revisa el código.';
$txt['error_sp_php_database'] = 'Hay un error de Base de datos en tu código. Por favor, revisalo.';
$txt['error_sp_no_posts_found'] = 'ningún mensaje fué encontrado.';
$txt['error_sp_no_members_found'] = 'ningún miembro fué encontrado.';
$txt['error_sp_no_gallery_found'] = 'No hay Mods de galerías instalados.';
$txt['error_sp_no_pictures_found'] = 'No hay imágenes en la galería.';
$txt['error_sp_no_boards_found'] = 'Esta categoría no tiene ningún foro.';
$txt['error_sp_no_topics_found'] = 'Este foro no tiene ningún tema.';
$txt['error_sp_no_attachments_found'] = 'No se encontraron archivos adjuntos.';
$txt['error_sp_no_polls_found'] = 'No se encontró ninguna encuesta.';
$txt['error_sp_invalid_feed'] = 'Feed Inválido.';
$txt['error_sp_no_online'] = 'No hay usuarios en linea.';
$txt['error_sp_no_items_day'] = 'No se encontraron eventos en el calendario.';
$txt['error_sp_no_blog_found'] = 'No hay ningún Mod de blogs instalado.';
$txt['error_sp_no_blogs_found'] = 'No se encontró ningúnn blog.';
$txt['error_sp_no_articles_found'] = 'No hay artículos para mostrar.';
$txt['error_sp_no_shop_found'] = 'No hay ningún Mod shop instalado.';
$txt['error_sp_no_arcade_found'] = 'No hay ningúnn mod Arcade instalado.';
$txt['error_sp_no_stats_found'] = 'No se encontraron las estadísticas.';
$txt['error_sp_page_not_found'] = 'La página que pediste no fué encontrada.';
$txt['error_sp_shoutbox_not_exist'] = $context['user']['is_admin'] ? 'Lo siento, parece ser que este shoutbox solo existe en tu cabeza.' : 'Lo siento, este shoutbox no existe.';
$txt['error_sp_no_shoutbox'] = 'No se han creado ningún shoutbox.';

?>