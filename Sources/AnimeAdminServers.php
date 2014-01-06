<?php
/**********************************************************************************
* AnimeAdminServers.php                                                          *
***********************************************************************************
* AnimeManager                                                                    *
* SMF Modification Project Founded by Batousay (batousay@batousay.com)            *
* =============================================================================== *
* Software Version:           AnimeManager 0.1                                    *
* Software by:                AnimeManager Team (http://www.batousay.com)         *
* Copyright 2010-2010 by:     AnimeManager Team (http://www.batousay.com)         *
* Support, News, Updates at:  http://www.batousay.com                             *
***********************************************************************************
* This program is free software; you may redistribute it and/or modify it under   *
* the terms of the provided license as published by Simple Machines LLC.          *
*                                                                                 *
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
*                                                                                 *
* See the "license.txt" file for details of the Simple Machines license.          *
* The latest version can always be found at http://www.simplemachines.org.        *
**********************************************************************************/

if (!defined('SMF'))
	die('Hacking attempt...');

function anime_admin_servers_main()
{
    global $sourcedir, $context, $txt;

    //TODO: Need to check permissions
    //Something like
    //
    if (!allowedTo('sp_anime_manager'))
    		isAllowedTo('sp_admin');

    //We get all the needed functions
    require_once($sourcedir . '/Subs-PortalAdmin.php');
    require_once($sourcedir . '/Subs-Anime.php');
    require_once($sourcedir . '/Subs-Categories.php');
    require_once($sourcedir . '/Subs-Boards.php');

    //TODO: Own Template
    //We load the template, using SimplePortal One...
    loadTemplate('AnimeAdminServers');

    //List of all the possible actions
    $subActions = array(
                'listServers' => 'anime_admin_servers_list',
		'addServers' => 'anime_admin_servers_add',
		'editServers' => 'anime_admin_servers_edit',
                'deleteServers' => 'anime_admin_servers_delete',
                'stateChange' => 'anime_admin_servers_change',
    );

    //Check and get if we have the "sa" parameter (Default info)
    $_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'listServers';

    //Title and all stuff
    $context[$context['admin_menu_name']]['tab_data'] = array(
        'title' => $txt['an-adminServers'],
	'description' => $txt['an-adminServersDesc'],
    );

    //Call to the function we want
    $subActions[$_REQUEST['sa']]();
}

function anime_admin_servers_list()
{
	global $txt, $context;

	// Category list columns.
	$context['columns'] = array(
		'picture' => array(
			'width' => '20%',
			'label' => $txt['sp-adminColumnPicture'],
			'class' => 'first_th',
		),
		'name' => array(
			'width' => '20%',
			'label' => $txt['sp-adminColumnName'],
		),
                'protected' => array(
                        'width' => '10%',
			'label' => $txt['an-adminColumnProtected'],
                ),
                'private' => array(
                        'width' => '10%',
			'label' => $txt['an-adminColumnPrivate'],
                ),
		'category' => array(
			'width' => '20%',
			'label' => $txt['an-adminColumnCategory'],
		),
		'action' => array(
			'width' => '20%',
			'label' => $txt['sp-adminColumnAction'],
			'class' => 'last_th',
		),
	);

	// Get all the series.
	$context['servers'] = getAnimeServersInfo();

	// Call the sub template.
	$context['sub_template'] = 'servers_list';
	$context['page_title'] = $txt['an-adminServersListName'];
}

function anime_admin_servers_add()
{
    	global $txt, $smcFunc, $context, $func, $sourcedir;

	// Not actually adding a category? Show the add category page.
	if(empty($_POST['edit_servers']))
	{
                $context['servers_categories'] = getAnimeCategoryInfo();

        	// Just we need the template.
		$context['sub_template'] = 'servers_edit';
		$context['page_title'] = $txt['an-serversAdd'];
                $context['button_title'] = $txt['an-serversAddButton'];
		$context['servers_action'] = 'addServers';
	}
	// Adding a category? Lets do this thang! ;D
	else
	{
		// Session check.
		checkSession();

		// Category name can't be empty.
		if (empty($_POST['servers_name']))
			fatal_lang_error('error_sp_name_empty', false);

		// A small info array.
		$serverInfo = array(
			'name' => $smcFunc['htmlspecialchars']($_POST['servers_name'], ENT_QUOTES),
			'banner' => $smcFunc['htmlspecialchars']($_POST['servers_banner_url'], ENT_QUOTES),
                        'id_category' =>  (int) $_POST['servers_category'],
                        'protected' => empty($_POST['servers_protected'])? 0 : 1,
                        'private' => empty($_POST['servers_private'])? 0 : 1,
		);
                
                addServer($serverInfo);

		// Return back to the series list.
		redirectexit('action=admin;area=an-servers;sa=listServers');
        }

}

function anime_admin_servers_edit()
{
   
        global $txt, $smcFunc, $context, $func, $sourcedir;

	// Not actually adding a category? Show the add category page.
	if(empty($_POST['edit_servers']))
	{
            // Be sure you made it an integer.
		$_REQUEST['server_id'] = (int) $_REQUEST['server_id'];

		// Show you ID.
		if(empty($_REQUEST['server_id']))
			fatal_lang_error('error_sp_id_empty', false);

                $aux = getAnimeServersInfo($_REQUEST['server_id']);
                $context['servers_info'] = $aux[0];
                $context['servers_categories'] = getAnimeCategoryInfo();

        	// Just we need the template.
		$context['sub_template'] = 'servers_edit';
		$context['page_title'] = $txt['an-serversEdit'];
                $context['button_title'] = $txt['an-serversEditButton'];
		$context['servers_action'] = 'editServers';
	}
	// Adding a category? Lets do this thang! ;D
	else
	{
		// Session check.
		checkSession();

                $_POST['server_id'] = (int) $_POST['server_id'];
                $_POST['servers_category'] = (int) $_POST['servers_category'];
		// Show you ID.
		if(empty($_POST['server_id']) || empty($_POST['servers_category']))
			fatal_lang_error('error_sp_id_empty', false);

                // The name can't be empty.
		if (empty($_POST['servers_name']))
			fatal_lang_error('error_sp_name_empty', false);

		$serverInfo = array();
                $serverInfo['id'] = $smcFunc['htmlspecialchars']($_POST['server_id'], ENT_QUOTES);
                $serverInfo['name'] = $smcFunc['htmlspecialchars']($_POST['servers_name'], ENT_QUOTES);
                $serverInfo['banner'] = $smcFunc['htmlspecialchars']($_POST['servers_banner_url'], ENT_QUOTES);
                $serverInfo['protected'] = empty($_POST['servers_protect']) ? 0 : 1;
                $serverInfo['id_category'] = $_POST['servers_category'];
                $serverInfo['private'] = empty($_POST['servers_private'])? 0 : 1;


                modifyServer($serverInfo);

                updateAllSeries();
                updateAllSagas();
                findOrphanChapters();
                updateAllChaptersMessages();
                
		// Return back to the series list.
		redirectexit('action=admin;area=an-servers;sa=listServers');
        }


}

function anime_admin_series_delete()
{
}

function anime_admin_servers_change()
{
    global $txt, $smcFunc, $context, $func, $sourcedir;

    $_REQUEST['server_id'] = (int) $_REQUEST['server_id'];


    if(empty($_REQUEST['server_id']) || empty($_REQUEST['type']))
			fatal_lang_error('error_sp_id_empty', false);

    
    if($_REQUEST['type'] == 'Protected' || $_REQUEST['type'] == 'Private') {
        //Toogle value
        $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_portal
                        SET ' . $_REQUEST['type'] . ' = 1 -' . $_REQUEST['type']  . '
			WHERE ID_PORTAL = {int:id_server}',
			// Data to put in.
			array(
                                'id_server' => $_REQUEST['server_id'],
			)
		);

        updateAllSeries();
        updateAllSagas();
        findOrphanChapters();
        updateAllChaptersMessages();

    }else{
        fatal_lang_error('error_sp_id_empty', false);
    }

    redirectexit('action=admin;area=an-servers;sa=listServers');
}
?>