<?php

/* * ********************************************************************************
 * AnimeAdminChapters.php                                                          *
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

function anime_admin_chapters_main() {
    global $sourcedir, $context, $txt;

    //TODO: Need to check permissions
    //Something like
    //
    if (!allowedTo('sp_anime_manager') && !allowedTo('sp_anime_manager_series') && !allowedTo('sp_anime_manager_chapters'))
        isAllowedTo('sp_admin');

    //We get all the needed functions
    require_once($sourcedir . '/Subs-PortalAdmin.php');
    require_once($sourcedir . '/Subs-Anime.php');
    require_once($sourcedir . '/Subs-Categories.php');
    require_once($sourcedir . '/Subs-Boards.php');

    //TODO: Own Template
    //We load the template, using SimplePortal One...
    loadTemplate('AnimeAdminChapters');

    //List of all the possible actions
    $subActions = array(
        'listUnpublishedChapters' => 'anime_admin_unpublished_chapters_list',
        'listChapters' => 'anime_admin_chapters_list',
        'addChapters' => 'anime_admin_chapters_add',
        'editChapters' => 'anime_admin_chapters_edit',
        'deleteChapters' => 'anime_admin_chapters_delete',
        'stateChange' => 'anime_admin_chapters_change',
    );

    //Check and get if we have the "sa" parameter (Default info)
    $_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'listUnpublishedChapters';

    //Title and all stuff
    $context[$context['admin_menu_name']]['tab_data'] = array(
        'title' => $txt['an-adminChapters'],
        'description' => $txt['an-adminChaptersDesc'],
    );

    //Call to the function we want
    $subActions[$_REQUEST['sa']]();
}

function anime_admin_unpublished_chapters_list() {
    global $txt, $context, $smcFunc, $scripturl;

    // Category list columns.
    $context['columns'] = array(
        'category' => array(
            'width' => '20%',
            'label' => $txt['an-adminColumnCategory'],
            'class' => 'first_th',
        ),
        'serie' => array(
            'width' => '20%',
            'label' => $txt['an-adminColumnSerie'],
        ),
        'saga' => array(
            'width' => '20%',
            'label' => $txt['an-adminColumnSaga'],
        ),
        'number' => array(
            'width' => '10%',
            'label' => $txt['an-adminColumnNumber'],
        ),
        'title' => array(
            'width' => '20%',
            'label' => $txt['an-adminColumnTitle'],
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
		FROM {db_prefix}an_chapter
		WHERE ID_DOWNLOAD IS NULL'
	);
	list ($context['total_articles']) =  $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);
	// Construct the page index. 20 articles per page.
	$context['page_index'] = constructPageIndex($scripturl . '?action=admin;area=an-chapters;sa=listUnpublishedChapters', $_REQUEST['start'], $context['total_articles'], 20);
	$context['start'] = $_REQUEST['start'];
    //hasta aqu� es lo que faltaba de paginaci�n

    // Get all the series.
    $context['chapters'] = getAnimeUnpublishedChaptersInfo();

    // Call the sub template.
    $context['sub_template'] = 'unpublished_chapters_list';
    $context['page_title'] = $txt['an-adminChaptersListName'];
}

function anime_admin_chapters_list() {
    global $txt, $context, $smcFunc, $scripturl;

    // Category list columns.
    $context['columns'] = array(
        'category' => array(
            'width' => '20%',
            'label' => $txt['an-adminColumnCategory'],
            'class' => 'first_th',
        ),
        'serie' => array(
            'width' => '20%',
            'label' => $txt['an-adminColumnSerie'],
        ),
        'saga' => array(
            'width' => '20%',
            'label' => $txt['an-adminColumnSaga'],
        ),
        'number' => array(
            'width' => '10%',
            'label' => $txt['an-adminColumnNumber'],
        ),
        'title' => array(
            'width' => '20%',
            'label' => $txt['an-adminColumnTitle'],
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
		FROM {db_prefix}an_chapter'
	);
	list ($context['total_articles']) =  $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);
	// Construct the page index. 20 articles per page.
	$context['page_index'] = constructPageIndex($scripturl . '?action=admin;area=an-chapters;sa=listChapters', $_REQUEST['start'], $context['total_articles'], 20);
	$context['start'] = $_REQUEST['start'];
    //hasta aqu� es lo que faltaba de paginaci�n

    // Get all the series.
    $context['chapters'] = getAnimeChaptersInfo();

    // Call the sub template.
    $context['sub_template'] = 'chapters_list';
    $context['page_title'] = $txt['an-adminChaptersListName'];
}

function anime_admin_chapters_add() {
    global $txt, $smcFunc, $context, $func, $sourcedir;

    // Not actually adding a category? Show the add category page.
    if (empty($_POST['edit_chapter'])) {
        if (empty($_POST['category_id'])) {
            $context['categories'] = getAnimeCategoryInfo();

            // Just we need the template.
            $context['sub_template'] = 'chapters_edit';
            $context['page_title'] = $txt['an-chaptersAdd'];
            $context['button_title'] = $txt['an-chaptersContinueButton'];
            $context['chapters_action'] = 'addChapters';
        } else {
            if (empty($_POST['series_id'])) {
                $context['series'] = getAnimeSeriesInfo(null, $_POST['category_id']);

                $context['chapter'] = array(
                    'id_category' => $_POST['category_id'],
                    'Nid_category' => $_POST['category_id'],
                );
                // Just we need the template.
                $context['sub_template'] = 'chapters_edit';
                $context['page_title'] = $txt['an-chaptersAdd'];
                $context['button_title'] = $txt['an-chaptersContinueButton'];
                $context['chapters_action'] = 'addChapters';
            } else {
                if (empty($_POST['sagas_id'])) {
                    $context['sagas'] = getAnimeSagasInfoForSeries($_POST['series_id']);

                    $context['chapter'] = array(
                        'id_category' => $_POST['category_id'],
                        'id_serie' => $_POST['series_id'],
                        'Nid_category' => $_POST['category_id'],
                        'Nid_series' => $_POST['series_id'],
                    );

                    // Just we need the template.
                    $context['sub_template'] = 'chapters_edit';
                    $context['page_title'] = $txt['an-chaptersAdd'];
                    $context['button_title'] = $txt['an-chaptersContinueButton'];
                    $context['chapters_action'] = 'addChapters';
                } else {//Heading to last step, fill the general information
                    // Just we need the template.
                    $context['chapter'] = array(
                        'id_category' => $_POST['category_id'],
                        'id_serie' => $_POST['series_id'],
                        'id_saga' => $_POST['sagas_id'],
                        'Nid_category' => $_POST['category_id'],
                        'Nid_series' => $_POST['series_id'],
                        'Nid_sagas' => $_POST['sagas_id'],
                    );

                    $context['chapter']['links'] = getAnimeLinksInfo($_POST['category_id']);

                    $context['sub_template'] = 'chapters_edit';
                    $context['page_title'] = $txt['an-chaptersAdd'];
                    $context['button_title'] = $txt['an-chaptersAddButton'];
                    $context['chapters_action'] = 'addChapters';
                }
            }
        }
    }
    // Adding a chapter? Lets do this thang! ;D
    else {
        // Session check.
        checkSession();

        $_POST['sagas_id'] = (int) $_POST['sagas_id'];
        $_POST['number'] = (int) $_POST['number'];
        $_POST['double'] = empty($_POST['double']) ? 0 : 1;
        // Chapter name and number can't be empty.
        if (empty($_POST['number']) || empty($_POST['title']) || empty($_POST['sagas_id']))
            fatal_lang_error('error_sp_name_empty', false);



        $chapterInfo = array(
            'id_saga' => $_POST['sagas_id'],
            'number' => $_POST['number'],
            'title' => $_POST['title'],
            'id_msg' => null,
            'id_download' => null,
        );

        $chapterInfo['id'] = addChapter($chapterInfo);

        $chapterInfo = getAnimeChaptersInfo($chapterInfo['id']);
        $chapterInfo = $chapterInfo[0];

        //Fill chaptersInfo
        if (!empty($_POST['capture']))
            $chapterInfo = modifyChapterCaptures($chapterInfo, $_POST['capture']);

        if (!empty($_POST['private']))
            $chapterInfo = modifyChapterLinks($chapterInfo, $_POST['private'], 'private');

        if (!empty($_POST['public']))
            $chapterInfo = modifyChapterLinks($chapterInfo, $_POST['public'], 'public');

        $chapterInfo['double'] = $_POST['double'];
        $chapterInfo['id_msg'] = addChapterMessage($chapterInfo);
        modifyChapter($chapterInfo);

        $sagasInfo = getAnimeSagasInfo($chapterInfo['id_saga']);
        modifySagasMessage(null, $sagasInfo[0]);

        // Return back to the series list.
        redirectexit('action=admin;area=an-chapters');
    }
}

function anime_admin_chapters_edit() {
    global $txt, $context;

    if (!empty($_REQUEST['chapter_id']) && !empty($_REQUEST['edit_chapter'])) {
        $_REQUEST['chapter_id'] = (int) $_REQUEST['chapter_id'];
        $_REQUEST['edit_chapter'] = (int) $_REQUEST['edit_chapter'];
        if (!empty($_REQUEST['chapter_id']) && !empty($_REQUEST['edit_chapter'])) {
            $chapterInfo = getAnimeChaptersInfo($_REQUEST['chapter_id']);
            $chapterInfo = $chapterInfo[0];

         //   $_POST['chapter_id'] = (int) $_POST['chapter_id'];
         //   $_POST['category_id'] = (int) $_POST['category_id'];
         //   $_POST['series_id'] = (int) $_POST['series_id'];
         //   $_POST['sagas_id'] = (int) $_POST['sagas_id'];
            
            $_POST['chapter_id'] = (empty($_POST['chapter_id'])) ? $chapterInfo['id'] : (int) $_POST['chapter_id'];
            $_POST['category_id'] = (empty($_POST['category_id'])) ?$chapterInfo['id_category'] : (int) $_POST['category_id'];
            $_POST['series_id'] = (empty($_POST['series_id'])) ? $chapterInfo['id_serie'] : (int) $_POST['series_id'];
            $_POST['sagas_id'] = (empty($_POST['sagas_id'])) ?$chapterInfo['id_saga'] : (int) $_POST['sagas_id'];
        }
    }

// Not actually adding a category? Show the add category page.
    if (empty($_POST['edit_chapter'])) {
        if (empty($_POST['category_id'])) {
            if (!empty($_REQUEST['chapter_id']))
                $_REQUEST['chapter_id'] = (int) $_REQUEST['chapter_id'];

            // Show you ID.
            if (!empty($_REQUEST['chapter_id'])) {
                $context['chapter'] = getAnimeChaptersInfo($_REQUEST['chapter_id']);
                $context['chapter'] = $context['chapter'][0];

                $context['categories'] = getAnimeCategoryInfo();

                // Just we need the template.
                $context['sub_template'] = 'chapters_edit';
                $context['page_title'] = $txt['an-chaptersEdit'];
                $context['button_title'] = $txt['an-chaptersContinueButton'];
                $context['chapters_action'] = 'editChapters';
            } else {
                redirectexit('action=admin;area=an-chapters');
            }
        } else {


            if (empty($_POST['series_id'])) {
                $_POST['chapter_id'] = (int) $_POST['chapter_id'];
                $_POST['category_id'] = (int) $_POST['category_id'];

                if (empty($_POST['chapter_id']) || empty($_POST['category_id']))
                    fatal_lang_error('error_Chapter_Series', false);
                else {
                    $context['chapter'] = getAnimeChaptersInfo($_POST['chapter_id']);
                    $context['chapter'] = $context['chapter'][0];

                    $context['series'] = getAnimeSeriesInfo(null, $_POST['category_id']);

                    $context['chapter']['Nid_category'] = $_POST['category_id'];

                    // Just we need the template.
                    $context['sub_template'] = 'chapters_edit';
                    $context['page_title'] = $txt['an-chaptersEdit'];
                    $context['button_title'] = $txt['an-chaptersContinueButton'];
                    $context['chapters_action'] = 'editChapters';
                }
            } else {
                if (empty($_POST['sagas_id'])) {
                    $_POST['chapter_id'] = (int) $_POST['chapter_id'];
                    $_POST['category_id'] = (int) $_POST['category_id'];
                    $_POST['series_id'] = (int) $_POST['series_id'];

                    if (empty($_POST['chapter_id']) || empty($_POST['category_id']) || empty($_POST['series_id']))
                        fatal_lang_error('error_Chapter_SAGAS', false);
                    else {

                        $context['chapter'] = getAnimeChaptersInfo($_POST['chapter_id']);
                        $context['chapter'] = $context['chapter'][0];

                        $context['sagas'] = getAnimeSagasInfoForSeries($_POST['series_id']);

                        $context['chapter']['Nid_category'] = $_POST['category_id'];
                        $context['chapter']['Nid_series'] = $_POST['series_id'];


                        // Just we need the template.
                        $context['sub_template'] = 'chapters_edit';
                        $context['page_title'] = $txt['an-chaptersEdit'];
                        $context['button_title'] = $txt['an-chaptersContinueButton'];
                        $context['chapters_action'] = 'editChapters';
                    }
                } else {//Heading to last step, fill the general information
                    // Just we need the template.
                    $_POST['chapter_id'] = (int) $_POST['chapter_id'];
                    $_POST['category_id'] = (int) $_POST['category_id'];
                    $_POST['series_id'] = (int) $_POST['series_id'];
                    $_POST['sagas_id'] = (int) $_POST['sagas_id'];

                    if (empty($_POST['chapter_id']) || empty($_POST['category_id']) || empty($_POST['series_id']) || empty($_POST['sagas_id']))
                        fatal_lang_error('error_Chapter_Final', false);
                    else {
                        $context['chapter'] = getAnimeChaptersInfo($_POST['chapter_id']);
                        $context['chapter'] = $context['chapter'][0];

                        $context['chapter']['Nid_category'] = $_POST['category_id'];
                        $context['chapter']['Nid_series'] = $_POST['series_id'];
                        $context['chapter']['Nid_sagas'] = $_POST['sagas_id'];

                        $context['sub_template'] = 'chapters_edit';
                        $context['page_title'] = $txt['an-chaptersEdit'];
                        $context['button_title'] = $txt['an-chaptersEditButton'];
                        $context['chapters_action'] = 'editChapters';
                    }
                }
            }
        }
    }
    // Adding a chapter? Lets do this thang! ;D
    else {
        // Session check.
        checkSession();

        $_POST['sagas_id'] = (int) $_POST['sagas_id'];
        $_POST['chapter_id'] = (int) $_POST['chapter_id'];
        $_POST['number'] = (int) $_POST['number'];
        $_POST['double'] = empty($_POST['double']) ? 0 : 1;

        // Chapter name and number can't be empty.
        if (empty($_POST['number']) || empty($_POST['title']) || empty($_POST['sagas_id']) || empty($_POST['chapter_id']))
            fatal_lang_error('error_sp_name_empty', false);
        else {
            $chapterInfo = getAnimeChaptersInfo($_POST['chapter_id']);
            $chapterInfo = $chapterInfo[0];

            $chapterInfo['id_saga'] = $_POST['sagas_id'];
            $chapterInfo['number'] = $_POST['number'];
            $chapterInfo['title'] = $_POST['title'];
            $chapterInfo['double'] = $_POST['double'];


            //Fill chaptersInfo
            if (!empty($_POST['capture']))
                $chapterInfo = modifyChapterCaptures($chapterInfo, $_POST['capture']);

            if (!empty($_POST['private']))
                $chapterInfo = modifyChapterLinks($chapterInfo, $_POST['private'], 'private');

            if (!empty($_POST['public']))
                $chapterInfo = modifyChapterLinks($chapterInfo, $_POST['public'], 'public');

            modifyChapterMessage($chapterInfo);
            modifyChapter($chapterInfo);

            $sagasInfo = getAnimeSagasInfo($chapterInfo['id_saga']);
            modifySagasMessage(null, $sagasInfo[0]);

            if (!empty($chapterInfo['id_download'])) {
                $newsInfo = getAnimeNewsInfo($chapterInfo['id_download']);
                modifyNewsMessage($newsInfo[0]);
            }
        }
        // Return back to the series list.
        redirectexit('action=admin;area=an-chapters');
    }
}

?>