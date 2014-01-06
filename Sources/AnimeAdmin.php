<?php
/**********************************************************************************
* AnimeAdmin.php                                                          *
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

function anime_admin_main() {

    global $sourcedir, $context, $txt;

    //TODO: Need to check permissions
    //Something like
    //
    if (!allowedTo('sp_anime_manager') && !allowedTo('sp_anime_manager_news') && !allowedTo('sp_anime_manager_series') && !allowedTo('sp_anime_manager_chapters'))
    		isAllowedTo('sp_admin');

    //We get all the needed functions
    require_once($sourcedir . '/Subs-PortalAdmin.php');
    require_once($sourcedir . '/ManageServer.php');

    //TODO: Own Template
    //We load the template, using SimplePortal One...
    loadLanguage('Anime');
    loadTemplate('AnimeAdmin');

    //List of all the possible actions
    $subActions = array(
		'info' => 'anime_manager_information',
		'tutorials' => 'anime_manager_tutorials',
    );

    //Check and get if we have the "sa" parameter (Default info)
    $_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'info';

    //Title and all stuff
    $context[$context['admin_menu_name']]['tab_data'] = array(
        'title' => $txt['an-adminInfo'],
	'description' => $txt['an-adminInfoDesc'],
    );

    //Call to the function we want
    $subActions[$_REQUEST['sa']]();
}

function anime_manager_information() {
    global $context, $txt;

    $context['an_credits'] = array(
		array(
			'pretext' => $txt['an-info_intro'],
			'title' => $txt['sp-info_team'],
			'groups' => array(
				array(
					'title' => $txt['sp-info_groups_pm'],
					'members' => array(
						'Batousay',
					),
				),
				array(
					'title' => $txt['sp-info_groups_dev'],
					'members' => array(
						'Batousay',
					),
				),
			),
		),
	);

        $context['sub_template'] = 'information';
	$context['page_title'] = $txt['an-info_title'];

}

function anime_manager_tutorials() {
        global $context, $txt;

        $context['sub_template'] = 'tutorials';
	$context['page_title'] = $txt['an-tutorial_title'];
}

?>