<?php
/********************************************************************************
* inactiveusers_markallboardsread.php									*
*********************************************************************************
* For SMF: Simple Machines Forum 2.x									*
* MYSQL USERS ONLY												*
********************************************************************************/

// Not visited in how many days  Default is 90.
// Set to 0, if you want to mark ALL boards read for ALL users
$not_visited_days = 90 ;

// No of users to do for per iteration
$per_iteration = 30 ;

// No need to edit anything below line this
/********************************************************************************/

// The location of Settings.php, minus the trailing /.  Example: '/home/user/public_html/community'
$path_to_settings = dirname(__FILE__);

@set_time_limit(300);
error_reporting(E_ALL);

if (substr($path_to_settings, -1) == '/')
	$path_to_settings = substr($path_to_settings, 0, -1);
if (!file_exists($path_to_settings . '/SSI.php'))
	$path_to_settings = dirname(__FILE__);

require_once($path_to_settings . '/SSI.php');
require_once($path_to_settings . '/Sources/Subs-Boards.php');

global $db_prefix, $user_info, $smcFunc;
$continue = 0;

function show_header($continue = 0)
{
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>Usuarios inactivos - Script para marcar todos los foros/temas como leidos</title>
		<style type="text/css">
			body
			{
				font-family: Verdana, sans-serif;
				background-color: #D4D4D4;
				margin: 0;
			}
			body, td
			{
				font-size: 10pt;
			}
			div#header
			{
				background: url(Themes/default/images/titlebg.jpg) #E9F0F6 repeat-x;
				padding: 22px 4% 12px 4%;
				font-family: Georgia, serif;
				font-size: x-large;
				border-bottom: 1px solid black;
				height: 40px;
			}
			div#content
			{
				padding: 20px 30px;
			}
			div.error_message
			{
				border: 2px dashed red;
				background-color: #E1E1E1;
				margin: 1ex 4ex;
				padding: 1.5ex;
			}
			div.panel
			{
				border: 1px solid gray;
				background-color: #F0F0F0;
				margin: 1ex 0;
				padding: 1.2ex;
			}
			div.panel h2
			{
				margin: 0;
				margin-bottom: 0.5ex;
				padding-bottom: 3px;
				border-bottom: 1px dashed black;
				font-size: 14pt;
				font-weight: normal;
			}
			div.panel h3
			{
				margin: 0;
				margin-bottom: 2ex;
				font-size: 10pt;
				font-weight: normal;
			}
			form
			{
				margin: 0;
			}
			td.textbox
			{
				padding-top: 2px;
				font-weight: bold;
				white-space: nowrap;
				padding-right: 2ex;
			}
		</style>';
		// IF CONTINUING
		
	// 8 seconds
	if(!empty($continue))
		echo '<meta http-equiv="refresh" content="8" />';
			
echo '</head>
	<body>
		<div id="header">
			<div title="Inactive Users - Mark All Boards/Topics Read">Usuarios inactivos - Script para marcar todos los foros/temas como leidos</div>
		</div>
		<div id="content">';
}

function show_footer()
{
	echo '
		</div>
	</body>
</html>';
}

// Any user who has not visited for 90 days, will have all
$not_visited = time() - (int) $not_visited_days * 24 * 3600;

// First thing's first - get all the boards.
// Why all?  They may have been able to view forums which they now can't.
	$request = $smcFunc['db_query']('', '
		SELECT id_board
		FROM {db_prefix}boards',
		array(
		)
	);
$boards = array();
while ($row = $smcFunc['db_fetch_assoc']($request))
	$boards[$row['id_board']] = $row['id_board'];

$smcFunc['db_free_result']($request);

// Quick Sanitization
$not_visited_days = (int) $not_visited_days;
$per_iteration = (int) $per_iteration;

// Now get members (limit = $per_iteration)
	$result = $smcFunc['db_query']('', '
		SELECT DISTINCT m.id_member
		FROM {db_prefix}members as m
			LEFT JOIN {db_prefix}log_topics as l ON (l.id_member = m.id_member)
		WHERE '. ( $not_visited_days == 0 ? '' : 'm.last_login < {int:not_visited}
			AND ' ) .'IFNULL(l.id_topic, 0) != 0
		LIMIT {int:per_iteration}',
		array(
			'per_iteration' => $per_iteration,
			'not_visited' => $not_visited,
		)
	);

$returned = (int) $smcFunc['db_num_rows']($result);
if($returned == 0)
{
	// Show header
	show_header();
	// Message
	echo "Terminado - Todos los usuarios inactivos tienen ahora marcados todos los foros/temas como leidos.";
	// Footer
	show_footer();
	// Now get out of here
	die;
	exit;
}
elseif($returned == $per_iteration)
{
	// Need to continue/repeat the process for more users
	$continue = 1;
}

show_header($continue);

echo "Esta vez, hay $returned usuarios inactivos que requiren que se les marque todos los foros/temas como leidos<br /><br />";

$members = array();
// Store the members into the array
while($row = $smcFunc['db_fetch_assoc']($result))
	$members[$row['id_member']] = (int) $row['id_member'];

// Abuse SMF's function to mark boards read
foreach($members as $i)
{
	$user_info['id'] = (int) $i;
	echo 'Marcando como leido '.$i.' ';
	markBoardsRead($boards, false);
	echo ' <span style="color:green">Hecho ;)</span><br />';
	
	// Flush the stuff to the browser
	ob_flush();
	flush();	// needed ob_flush
}

if($continue)
	echo '<br />Se ha completado el proceso con exito. el proceso se reanudará en 8 segundos con otra interaccion de '.$per_iteration.' usuarios <br /><br /><span class="header">El script todavia esta funcionando, no cierres o actualices esta pagina</span>';
else
	echo "<br />Se ha completado el proceso con exito.  Se han marcado todos los foros/temas como leidos.<br />el proceso se ha detenido ahora<br /><br />puedes borrar este archivo de tu servidor ahora. recuerda realizar esta operación con frecuencia.<br /><br />
	tambien es recomendable que optimizes las tablas de tu base de datos ahora..";
	
// Finish off with the footer
show_footer();

?>