<?php

/* * ********************************************************************************
 * AnimeAdminSeries.php                                                          *
 * **********************************************************************************
 * AnimeManager                                                                    *
 * SMF Modification Project Founded by Batousay (batousay@batousay.com)            *
 * =============================================================================== *
 * Software Version:           AnimeManager 0.1                                    *
 * Software by:                AnimeManager Team (http://www.batousay.com)         *
 * Copyright 2010-2010 by:     AnimeManager Team (http://www.batousay.com)         *
 * Support, News, Updates at:  http://www.batousay.com                             *
 * **********************************************************************************
 * This program is free software; you may redistribute it and/or modify it under   *
 * the terms of the provided license as published by Simple Machines LLC.          *
 *                                                                                 *
 * This program is distributed in the hope that it is and will be useful, but      *
 * WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
 * or FITNESS FOR A PARTICULAR PURPOSE.                                            *
 *                                                                                 *
 * See the "license.txt" file for details of the Simple Machines license.          *
 * The latest version can always be found at http://www.simplemachines.org.        *
 * ******************************************************************************** */

if (!defined('SMF'))
    die('Hacking attempt...');

function anime_admin_series_main() {
    global $sourcedir, $context, $txt;

    //TODO: Need to check permissions
    //Something like
    //
    if (!allowedTo('sp_anime_manager') && !allowedTo('sp_anime_manager_series'))
        isAllowedTo('sp_admin');

    //We get all the needed functions
    require_once($sourcedir . '/Subs-PortalAdmin.php');
    require_once($sourcedir . '/Subs-Anime.php');
    require_once($sourcedir . '/Subs-Categories.php');
    require_once($sourcedir . '/Subs-Boards.php');

    //TODO: Own Template
    //We load the template, using SimplePortal One...
    loadTemplate('AnimeAdminSeries');

    //List of all the possible actions
    $subActions = array(
        'listSeries' => 'anime_admin_series_list',
        'addSeries' => 'anime_admin_series_add',
        'editSeries' => 'anime_admin_series_edit',
        'deleteSeries' => 'anime_admin_series_delete',
        'stateChange' => 'anime_admin_series_change',
        'listSpecs' => 'anime_admin_series_specs_list',
        'addSpecs' => 'anime_admin_series_specs_add',
        'editSpecs' => 'anime_admin_series_specs_edit'
    );

    //Check and get if we have the "sa" parameter (Default info)
    $_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'listSeries';

    //Title and all stuff
    $context[$context['admin_menu_name']]['tab_data'] = array(
        'title' => $txt['an-adminSeries'],
        'description' => $txt['an-adminSeriesDesc'],
    );

    //Call to the function we want
    $subActions[$_REQUEST['sa']]();
}

function anime_admin_series_list() {
    global $txt, $context, $smcFunc, $scripturl;

    // Category list columns.
    $context['columns'] = array(
        'picture' => array(
            'width' => '25%',
            'label' => $txt['sp-adminColumnPicture'],
            'class' => 'first_th',
        ),
        'name' => array(
            'width' => '20%',
            'label' => $txt['sp-adminColumnName'],
        ),
        'forums' => array(
            'width' => '15%',
            'label' => $txt['an-adminColumnForums'],
        ),
        'category' => array(
            'width' => '10%',
            'label' => $txt['an-adminColumnCategory'],
        ),
        'sagas' => array(
            'width' => '10%',
            'label' => $txt['an-adminColumnSagas'],
        ),
        'finished' => array(
            'width' => '5%',
            'label' => $txt['an-adminColumnFinished'],
        ),
        'publish' => array(
            'width' => '5%',
            'label' => $txt['sp-adminColumnPublish'],
        ),
        'action' => array(
            'width' => '10%',
            'label' => $txt['sp-adminColumnAction'],
            'class' => 'last_th',
        ),
    );
    
    //PAGINACION  desde aqu� faltaba
    // Count all the articles.
	$request = $smcFunc['db_query']('','
		SELECT COUNT(*)
		FROM {db_prefix}an_series
        WHERE ID_SERIES IS NOT NULL'
	);
	list ($context['total_articles']) =  $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);
	// Construct the page index. 20 articles per page.
	$context['page_index'] = constructPageIndex($scripturl . '?action=admin;area=an-series;sa=listSeries', $_REQUEST['start'], $context['total_articles'], 20);
	$context['start'] = $_REQUEST['start'];
    //hasta aqu� es lo que faltaba de paginaci�n

    // Get all the series.
    $context['series'] = getAnimeSeriesInfo2();

    // Call the sub template.
    $context['sub_template'] = 'series_list';
    $context['page_title'] = $txt['an-adminSeriesListName'];
}

function anime_admin_series_add() {
    global $txt, $smcFunc, $context, $func, $sourcedir;

    // Not actually adding a category? Show the add category page.
    if (empty($_POST['edit_series'])) {
        $context['series_categories'] = getAnimeCategoryInfo();

        // Just we need the template.
        $context['sub_template'] = 'series_edit';
        $context['page_title'] = $txt['an-seriesAdd'];
        $context['button_title'] = $txt['an-seriesAddButton'];
        $context['series_action'] = 'addSeries';
    }
    // Adding a category? Lets do this thang! ;D
    else {
        // Session check.
        checkSession();

        // Category name can't be empty.
        if (empty($_POST['series_name']))
            fatal_lang_error('error_sp_name_empty', false);

        $newsImg = $smcFunc['htmlspecialchars']($_POST['series_news_img'], ENT_QUOTES);
        $imgStaff = $smcFunc['htmlspecialchars']($_POST['series_staff_img'], ENT_QUOTES);
        // A small info array.
        $seriesInfo = array(
            'name' => $smcFunc['htmlspecialchars']($_POST['series_name'], ENT_QUOTES),
            'banner' => $smcFunc['htmlspecialchars']($_POST['series_banner_url'], ENT_QUOTES),
            'img_slider' => $smcFunc['htmlspecialchars']($_POST['series_slider'], ENT_QUOTES),
            'newsImg' => array(
                'href' => $newsImg,
                'image' => '<img src="' . $newsImg . '" alt="" width=200 />',
            ),
            'downloads' => $smcFunc['htmlspecialchars']($_POST['series_picture'], ENT_QUOTES),
            'abstract' => $smcFunc['htmlspecialchars']($_POST['series_abstract'], ENT_QUOTES),
            'staff' => $smcFunc['htmlspecialchars']($_POST['series_staff'], ENT_QUOTES),
            'id_category' => (int) $_POST['series_category'],
            'finalized' => empty($_POST['series_finalized']) ? 0 : 1,
            'public' => empty($_POST['series_public']) ? 0 : 1,
            'chapters_total' => (int) $_POST['series_chapters'],
            'Img_staff' => array(
                'href' => $imgStaff,
                'image' => '<img src="' .$imgStaff. '" alt="" width=200 />',
            ),
        );
        /*
         *  Adding boards
         */
        //Get all the category Info
        $aux = getAnimeCategoryInfo($seriesInfo['id_category']);
        $context['series_categories'] = $aux[0];

        if (empty($context['series_categories'])) {
            trigger_error('anime_admin_series_add(): Series_categories empty', E_USER_ERROR);
        }

        $seriesInfo['category_name'] = $context['series_categories']['name'];

        $seriesInfo = createSeriesBoard($seriesInfo);

        /*
         * Recopilatory message in Public Board
         */
        $seriesInfo['message'] = createSeriesMessage($seriesInfo);

        addSeries($seriesInfo);
        updateBlockSeries();

        // Return back to the series list.
        redirectexit('action=admin;area=an-series;sa=listSeries');
    }
}

function anime_admin_series_edit() {
    global $txt, $smcFunc, $context, $func, $sourcedir;

    // Not actually adding a category? Show the add category page.
    if (empty($_POST['edit_series'])) {
        // Be sure you made it an integer.
        $_REQUEST['series_id'] = (int) $_REQUEST['series_id'];

        // Show you ID.
        if (empty($_REQUEST['series_id']))
            fatal_lang_error('error_sp_id_empty', false);

        $aux = getAnimeSeriesInfo($_REQUEST['series_id']);
        $context['series_info'] = $aux[0];
        $context['series_categories'] = getAnimeCategoryInfo();

        // Just we need the template.
        $context['sub_template'] = 'series_edit';
        $context['page_title'] = $txt['an-seriesEdit'];
        $context['button_title'] = $txt['an-seriesEditButton'];
        $context['series_action'] = 'editSeries';
    }
    // Adding a category? Lets do this thang! ;D
    else {
        // Session check.
        checkSession();

        $_POST['series_id'] = (int) $_POST['series_id'];

        // Show you ID.
        if (empty($_POST['series_id']))
            fatal_lang_error('error_sp_id_empty', false);

        $aux = getAnimeSeriesInfo($_POST['series_id']);
        $seriesInfo = $aux[0];


        // The name can't be empty.
        if (empty($_POST['series_name']))
            fatal_lang_error('error_sp_name_empty', false);

        $newsImg = $smcFunc['htmlspecialchars']($_POST['series_news_img'], ENT_QUOTES);
        $imgStaff = $smcFunc['htmlspecialchars']($_POST['series_staff_img'], ENT_QUOTES);
        // A small info array.
        $seriesInfo['name'] = $smcFunc['htmlspecialchars']($_POST['series_name'], ENT_QUOTES);
        $seriesInfo['banner'] = $smcFunc['htmlspecialchars']($_POST['series_banner_url'], ENT_QUOTES);
        $seriesInfo['img_slider'] = $smcFunc['htmlspecialchars']($_POST['series_slider'], ENT_QUOTES);
        $seriesInfo['newsImg'] = array(
            'href' => $newsImg,
            'image' => '<img src="' . $newsImg . '" alt="' . $seriesInfo['name'] . '" width=200 />',
        );

        $seriesInfo['downloads'] = $smcFunc['htmlspecialchars']($_POST['series_picture'], ENT_QUOTES);
        $seriesInfo['abstract'] = $smcFunc['htmlspecialchars']($_POST['series_abstract'], ENT_QUOTES);
        $seriesInfo['staff'] = $smcFunc['htmlspecialchars']($_POST['series_staff'], ENT_QUOTES);
        $seriesInfo['id_category'] = (int) $_POST['series_category'];
        $seriesInfo['finalized'] = empty($_POST['series_finalized']) ? 0 : 1;
        $seriesInfo['public'] = empty($_POST['series_public']) ? 0 : 1;
        $seriesInfo['chapters_total'] = (int) $_POST['series_chapters'];
        $seriesInfo['Img_staff'] = array(
                'href' => $imgStaff,
                'image' => '<img src="' .$imgStaff. '" alt="" width=200 />',
            );


        modifyAnimeSeriesBoard($seriesInfo);

        /*
         * Recopilatory message in Public Board
         */
        $seriesInfo['message'] = modifySeriesMessage($seriesInfo);

        editSeries($seriesInfo);
        updateBlockSeries();

        // Return back to the series list.
        redirectexit('action=admin;area=an-series;sa=listSeries');
    }
}

function anime_admin_series_delete() {
    //TODO: implement delete a serie
}

function anime_admin_series_change() {
    global $txt, $smcFunc, $context, $func, $sourcedir;

    $_REQUEST['series_id'] = (int) $_REQUEST['series_id'];


    if (empty($_REQUEST['series_id']) || empty($_REQUEST['type']))
        fatal_lang_error('error_sp_id_empty', false);


    if ($_REQUEST['type'] == 'Finalized' || $_REQUEST['type'] == 'Public') {
        //Toogle value
        $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_series
                        SET ' . $_REQUEST['type'] . ' = 1 -' . $_REQUEST['type'] . '
			WHERE ID_SERIES = {int:id_series}',
                // Data to put in.
                array(
                    'id_series' => $_REQUEST['series_id'],
                )
        );

        $seriesInfo = getAnimeSeriesInfo($_REQUEST['series_id']);

        modifyAnimeSeriesBoard($seriesInfo[0]);
    } else {
        fatal_lang_error('error_sp_id_empty', false);
    }

    updateBlockSeries();

    redirectexit('action=admin;area=an-series;sa=listSeries');
}

function anime_admin_series_specs_list() {
    global $txt, $context;

    // Category list columns.
    $context['columns'] = array(
        'picture' => array(
            'width' => '35%',
            'label' => $txt['sp-adminColumnPicture'],
            'class' => 'first_th',
        ),
        'name' => array(
            'width' => '35%',
            'label' => $txt['sp-adminColumnName'],
        ),
        'action' => array(
            'width' => '30%',
            'label' => $txt['sp-adminColumnAction'],
            'class' => 'last_th',
        ),
    );

    // Get all the series.
    $context['specs'] = getAnimeSpecsInfo();

    // Call the sub template.
    $context['sub_template'] = 'specs_list';
    $context['page_title'] = $txt['an-adminSpecsListName'];
}

function anime_admin_series_specs_add() {
    global $context, $txt, $smcFunc;

    if (empty($_POST['edit_specs'])) {
        $context['series_categories'] = getAnimeCategoryInfo();

        // Just we need the template.
        $context['sub_template'] = 'specs_edit';
        $context['page_title'] = $txt['an-specsAdd'];
        $context['button_title'] = $txt['an-specsAddButton'];
        $context['series_action'] = 'addSpecs';
    }
    // Adding a category? Lets do this thang! ;D
    else {
        checkSession();

        // Category name can't be empty.
        if (empty($_POST['specs_name']))
            fatal_lang_error('error_sp_name_empty', false);
        // A small info array.
        $specsInfo = array(
            'name' => $smcFunc['htmlspecialchars']($_POST['specs_name'], ENT_QUOTES),
            'picture' => array(
                'href' => $smcFunc['htmlspecialchars']($_POST['specs_image'], ENT_QUOTES),
            ),
        );

        addAnimeSpecs($specsInfo);

        // Return back to the series list.
        redirectexit('action=admin;area=an-series;sa=listSpecs');
    }
}

function anime_admin_series_specs_edit() {
    global $txt, $context, $smcFunc;

    if (empty($_POST['edit_specs'])) {
        $_REQUEST['spec_id'] = (int) $_REQUEST['spec_id'];

        // Show you ID.
        if (empty($_REQUEST['spec_id']))
            fatal_lang_error('error_sp_id_empty', false);

        $context['specs_info'] = getAnimeSpecsInfo($_REQUEST['spec_id']);
        $context['specs_info'] = $context['specs_info'][0];
        
        // Just we need the template.
        $context['sub_template'] = 'specs_edit';
        $context['page_title'] = $txt['an-specsEdit'];
        $context['button_title'] = $txt['an-specsEditButton'];
        $context['series_action'] = 'editSpecs';
    }
    // Adding a category? Lets do this thang! ;D
    else {
        checkSession();

        $_POST['specs_id'] = (int) $_POST['specs_id'];

        // Show you ID.
        if (empty($_POST['specs_id']))
            fatal_lang_error('error_sp_id_empty', false);

        // Category name can't be empty.
        if (empty($_POST['specs_name']))
            fatal_lang_error('error_sp_name_empty', false);
        // A small info array.
        $specsInfo = array(
            'id' => $_POST['specs_id'],
            'name' => $smcFunc['htmlspecialchars']($_POST['specs_name'], ENT_QUOTES),
            'picture' => array(
                'href' => $smcFunc['htmlspecialchars']($_POST['specs_image'], ENT_QUOTES),
            ),
        );

        modifyAnimeSpecs($specsInfo);

        // Return back to the series list.
        redirectexit('action=admin;area=an-series;sa=listSpecs');
    }
}

?>