<?php
/**********************************************************************************
* AnimeAdminMaintenance.php                                                          *
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

function anime_admin_maintenance_main()
{
    global $sourcedir, $context, $txt;

    //TODO: Need to check permissions
    //Something like
    //
    if (!allowedTo('sp_anime_manager'))
    		isAllowedTo('sp_admin');

    //We get all the needed functions
    require_once($sourcedir . '/Subs-Anime.php');

    //TODO: Own Template
    //We load the template, using SimplePortal One...
    loadTemplate('AnimeAdminMaintenance');

    //List of all the possible actions
    $subActions = array(
        'newsNoPost' => 'anime_admin_maintenance_news_post',
        'newsRegenerate' => 'anime_admin_maintenance_news_regenerate',
        'newsDelete' => 'anime_admin_maintenance_news_delete',
        'seriesNoPost' => 'anime_admin_maintenance_series_post',
        'seriesRegenerate' => 'anime_admin_maintenance_series_regenerate',
        'seriesDelete' => 'anime_admin_maintenance_series_delete',
        'sagasNoPost' => 'anime_admin_maintenance_sagas_post',
        'sagasRegenerate' => 'anime_admin_maintenance_sagas_regenerate',
        'sagasDelete' => 'anime_admin_maintenance_sagas_delete',
        'chaptersNoPost' => 'anime_admin_maintenance_chapters_post',
        'chaptersRegenerate' => 'anime_admin_maintenance_chapters_regenerate',
        'chaptersDelete' => 'anime_admin_maintenance_chapters_delete',
        'imagesNoChapter' => 'anime_admin_maintenance_images_chapters',
        'updateNews' => 'anime_admin_maintenance_news_update',
        'updateSeries' => 'anime_admin_maintenance_series_update',
        'updateSagas' => 'anime_admin_maintenance_sagas_update',
        'updateChapters' => 'anime_admin_maintenance_chapters_update',
    );

    //Check and get if we have the "sa" parameter (Default info)
    $_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'newsNoPost';

    //Title and all stuff
    $context[$context['admin_menu_name']]['tab_data'] = array(
        'title' => $txt['an-adminMaintenance'],
	'description' => $txt['an-adminMaintenanceDesc'],
    );

    //Call to the function we want
    $subActions[$_REQUEST['sa']]();
}
function anime_admin_maintenance_news_regenerate() {
    $_REQUEST['news_id'] = (int) $_REQUEST['news_id'];

    if(empty($_REQUEST['news_id'])) {
        trigger_error('maintenance_news_regenerate: news_id is empty');
    }

    $newsInfo = getAnimeNewsInfo($_REQUEST['news_id']);

    regenerateAnimeNews($newsInfo[0]);

    redirectexit('action=admin;area=an-maintenance;sa=newsNoPost');
}

function anime_admin_maintenance_news_delete() {
    $_REQUEST['news_id'] = (int) $_REQUEST['news_id'];

    if(empty($_REQUEST['news_id'])) {
        trigger_error('maintenance_news_delete: news_id is empty');
    }

    $newsInfo = getAnimeNewsInfo($_REQUEST['news_id']);

    deleteAnimeNews($newsInfo[0]);

    redirectexit('action=admin;area=an-maintenance;sa=newsNoPost');
}

function anime_admin_maintenance_news_post()
{
	global $txt, $context;

	// Category list columns.
	$context['columns'] = array(
		'id' => array(
			'width' => '20%',
			'label' => $txt['an-adminMaintenanceNewsId'],
			'class' => 'first_th',
		),
		'serie' => array(
			'width' => '20%',
			'label' => $txt['an-adminSeries'],
		),
                'saga' => array(
                        'width' => '20%',
			'label' => $txt['an-adminSagas'],
                ),
		'chapters' => array(
			'width' => '20%',
			'label' => $txt['an-adminChapters'],
		),
		'action' => array(
			'width' => '20%',
			'label' => $txt['sp-adminColumnAction'],
			'class' => 'last_th',
		),
	);

        $context['news'] = findOrphanNews();

	// Call the sub template.
	$context['sub_template'] = 'maintenance_list';
	$context['page_title'] = $txt['an-adminOrphanNewsListName'];
}

function anime_admin_maintenance_chapters_regenerate() {
    $_REQUEST['chapter_id'] = (int) $_REQUEST['chapter_id'];

    if(empty($_REQUEST['chapter_id'])) {
        trigger_error('maintenance_chapters_regenerate: chapter_id is empty');
    }

    $chapterInfo = getAnimeChaptersInfo($_REQUEST['chapter_id']);

    regenerateAnimeChapter($chapterInfo[0]);

    redirectexit('action=admin;area=an-maintenance;sa=chaptersNoPost');
}

function anime_admin_maintenance_chapters_delete() {
    $_REQUEST['chapter_id'] = (int) $_REQUEST['chapter_id'];

    if(empty($_REQUEST['chapter_id'])) {
        trigger_error('maintenance_chapters_regenerate: chapter_id is empty');
    }

    $chapterInfo = getAnimeChaptersInfo($_REQUEST['chapter_id']);

    deleteAnimeChapter($chapterInfo[0]);

    redirectexit('action=admin;area=an-maintenance;sa=chaptersNoPost');
}

function anime_admin_maintenance_chapters_post()
{
	global $txt, $context;

	// Category list columns.
	$context['columns'] = array(
		'id' => array(
			'width' => '20%',
			'label' => $txt['an-adminMaintenanceNewsId'],
			'class' => 'first_th',
		),
		'serie' => array(
			'width' => '20%',
			'label' => $txt['an-adminSeries'],
		),
                'saga' => array(
                        'width' => '20%',
			'label' => $txt['an-adminSagas'],
                ),
		'number' => array(
			'width' => '20%',
			'label' => $txt['an-adminChapterNumber'],
		),
		'action' => array(
			'width' => '20%',
			'label' => $txt['sp-adminColumnAction'],
			'class' => 'last_th',
		),
	);

        $context['chapters'] = findOrphanChapters();

	// Call the sub template.
	$context['sub_template'] = 'maintenance_list';
	$context['page_title'] = $txt['an-adminOrphanChaptersListName'];
}

function anime_admin_maintenance_sagas_post()
{
	global $txt, $context;

	// Category list columns.
	$context['columns'] = array(
		'id' => array(
			'width' => '20%',
			'label' => $txt['an-adminMaintenanceNewsId'],
			'class' => 'first_th',
		),
		'serie' => array(
			'width' => '30%',
			'label' => $txt['an-adminSeries'],
		),
                'saga' => array(
                        'width' => '30%',
			'label' => $txt['an-adminSagas'],
                ),
		'action' => array(
			'width' => '20%',
			'label' => $txt['sp-adminColumnAction'],
			'class' => 'last_th',
		),
	);

        $context['sagas'] = findOrphanSagas();

	// Call the sub template.
	$context['sub_template'] = 'maintenance_list';
	$context['page_title'] = $txt['an-adminOrphanSagasListName'];
}

function anime_admin_maintenance_sagas_regenerate() {
    $_REQUEST['saga_id'] = (int) $_REQUEST['saga_id'];

    if(empty($_REQUEST['saga_id'])) {
        trigger_error('maintenance_sagas_regenerate: saga_id is empty');
    }

    $sagasInfo = getAnimeSagasInfo($_REQUEST['saga_id']);

    regenerateAnimeSagas($sagasInfo[0]);

    redirectexit('action=admin;area=an-maintenance;sa=sagasNoPost');
}

function anime_admin_maintenance_sagas_delete() {
    $_REQUEST['saga_id'] = (int) $_REQUEST['saga_id'];

    if(empty($_REQUEST['saga_id'])) {
        trigger_error('maintenance_sagas_delete: saga_id is empty');
    }

    $sagasInfo = getAnimeSagasInfo($_REQUEST['saga_id']);

    deleteAnimeSagas($sagasInfo[0]);

    redirectexit('action=admin;area=an-maintenance;sa=sagasNoPost');
}

function anime_admin_maintenance_series_post()
{
	global $txt, $context;

	// Category list columns.
	$context['columns'] = array(
		'id' => array(
			'width' => '20%',
			'label' => $txt['an-adminMaintenanceNewsId'],
			'class' => 'first_th',
		),
		'serie' => array(
			'width' => '30%',
			'label' => $txt['an-adminSeries'],
		),
                'picture' => array(
                        'width' => '30%',
			'label' => $txt['an-seriesPicture'],
                ),
		'action' => array(
			'width' => '20%',
			'label' => $txt['sp-adminColumnAction'],
			'class' => 'last_th',
		),
	);

        $context['series'] = findOrphanSeries();

	// Call the sub template.
	$context['sub_template'] = 'maintenance_list';
	$context['page_title'] = $txt['an-adminOrphanSeriesListName'];
}

function anime_admin_maintenance_series_regenerate() {
    $_REQUEST['serie_id'] = (int) $_REQUEST['serie_id'];

    if(empty($_REQUEST['serie_id'])) {
        trigger_error('maintenance_series_regenerate: serie_id is empty');
    }

    $seriesInfo = getAnimeSeriesInfo($_REQUEST['serie_id']);

    regenerateAnimeSeries($seriesInfo[0]);

    redirectexit('action=admin;area=an-maintenance;sa=seriesNoPost');
}

function anime_admin_maintenance_series_delete() {
    $_REQUEST['serie_id'] = (int) $_REQUEST['serie_id'];

    if(empty($_REQUEST['serie_id'])) {
        trigger_error('maintenance_series_regenerate: serie_id is empty');
    }

    $seriesInfo = getAnimeSeriesInfo($_REQUEST['serie_id']);

    deleteAnimeSeries($seriesInfo[0]);

    redirectexit('action=admin;area=an-maintenance;sa=seriesNoPost');
}

function anime_admin_maintenance_news_update() {
    global $txt, $context, $nl;

    updateAllNews();

    //$context['an-message'] = $txt['an-adminNewsUpdated'] . $nl . $context['modifiedNews'];
    $context['an-message'] = $context['modifiedNews'];

    // Call the sub template.
	$context['sub_template'] = 'maintenance_other';
	$context['page_title'] = $txt['an-adminNewsUpdated']; 
}

function anime_admin_maintenance_series_update() {
    global $txt, $context;

    updateAllSeries();

    $context['an-message'] = $txt['an-adminSeriesUpdated'];

    // Call the sub template.
	$context['sub_template'] = 'maintenance_other';
	$context['page_title'] = $txt['an-adminSeriesUpdated'];
}

function anime_admin_maintenance_sagas_update() {
    global $txt, $context;

    updateAllSagas();

    $context['an-message'] = $txt['an-adminSagasUpdated'];

    // Call the sub template.
	$context['sub_template'] = 'maintenance_other';
	$context['page_title'] = $txt['an-adminSagasUpdated'];
}

function anime_admin_maintenance_chapters_update() {
    global $txt, $context;

    updateAllChaptersMessages();

    $context['an-message'] = $txt['an-adminChaptersUpdated'];

    // Call the sub template.
	$context['sub_template'] = 'maintenance_other';
	$context['page_title'] = $txt['an-adminChaptersUpdated'];
}

?>