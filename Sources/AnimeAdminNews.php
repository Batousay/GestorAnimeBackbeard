<?php
/**********************************************************************************
* AnimeAdminNews.php                                                          *
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

function anime_admin_news_main() {
    global $sourcedir, $context, $txt;

    //TODO: Need to check permissions
    //Something like
    //
    if (!allowedTo('sp_anime_manager') && !allowedTo('sp_anime_manager_news'))
    		isAllowedTo('sp_admin');

    //We get all the needed functions
    require_once($sourcedir . '/Subs-PortalAdmin.php');
    require_once($sourcedir . '/Subs-Anime.php');
    require_once($sourcedir . '/Subs-Categories.php');
    require_once($sourcedir . '/Subs-Boards.php');

    //TODO: Own Template
    //We load the template, using SimplePortal One...
    loadTemplate('AnimeAdminNews');

    //List of all the possible actions
    $subActions = array(
                'listNews' => 'anime_admin_news_list',
                'lastNews' => 'anime_admin_news_last',
		'addNews' => 'anime_admin_news_add',
		'editNews' => 'anime_admin_news_edit',
                'stateChange' => 'anime_admin_news_change',
    );

    //Check and get if we have the "sa" parameter (Default info)
    $_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'lastNews';

    //Title and all stuff
    $context[$context['admin_menu_name']]['tab_data'] = array(
        'title' => $txt['an-adminNews'],
	'description' => $txt['an-adminNewsDesc'],
    );

    //Call to the function we want
    $subActions[$_REQUEST['sa']]();
}

function anime_admin_news_last() {
 global $txt, $context, $smcFunc;

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
        'thread' => array(
            'width' => '20%',
            'label' => $txt['an-adminColumnThread'],
        ),
        'action' => array(
            'width' => '20%',
            'label' => $txt['sp-adminColumnAction'],
            'class' => 'last_th',
        ),
    );

    // Get all the series.
    //$context['news'] = getAnimeNewsInfo();
    $context['news'] = getAnimeNewsInfoLimit();

    // Call the sub template.
    $context['sub_template'] = 'news_last';
    $context['page_title'] = $txt['an-adminNewsLastName'];
}

function anime_admin_news_list() {
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
        'thread' => array(
            'width' => '20%',
            'label' => $txt['an-adminColumnThread'],
        ),
        'action' => array(
            'width' => '20%',
            'label' => $txt['sp-adminColumnAction'],
            'class' => 'last_th',
        ),
    );
    
    //PAGINACION  desde aqu� faltaba
    // Count all the articles.
	$request = $smcFunc['db_query']('','
		SELECT COUNT(*)
		FROM {db_prefix}an_download
                WHERE ID_DOWNLOAD IS NOT NULL'
	);
	list ($context['total_articles']) =  $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);
	// Construct the page index. 20 articles per page.
	$context['page_index'] = constructPageIndex($scripturl . '?action=admin;area=an-news;sa=listNews', $_REQUEST['start'], $context['total_articles'], 20);
	$context['start'] = $_REQUEST['start'];
    //hasta aqu� es lo que faltaba de paginaci�n

    // Get all the series.
    $context['news'] = getAnimeNewsInfo();
	//$context['news'] = getAnimeNewsInfoLimit();

    // Call the sub template.
    $context['sub_template'] = 'news_list';
    $context['page_title'] = $txt['an-adminNewsListName'];
}

function anime_admin_news_add() {
    global $txt, $smcFunc, $context, $func, $sourcedir;

    // Not actually adding a category? Show the add category page.
    if (empty($_POST['edit_news'])) {
        if (empty($_POST['category_id'])) {
            $context['categories'] = getAnimeCategoryInfo();

            // Just we need the template.
            $context['sub_template'] = 'news_edit';
            $context['page_title'] = $txt['an-newsAdd'];
            $context['button_title'] = $txt['an-chaptersContinueButton'];
            $context['news_action'] = 'addNews';
        } else {
            if (empty($_POST['series_id'])) {
                $context['series'] = getAnimeSeriesInfo(null,$_POST['category_id']);

                $context['news'] = array(
                    'id_category' => $_POST['category_id'],
                    'Nid_category' => $_POST['category_id'],
                );
                // Just we need the template.
                $context['sub_template'] = 'news_edit';
                $context['page_title'] = $txt['an-newsAdd'];
                $context['button_title'] = $txt['an-chaptersContinueButton'];
                $context['news_action'] = 'addNews';
            } else {
                if (empty($_POST['sagas_id'])) {
                    $context['sagas'] = getAnimeSagasInfoForSeries($_POST['series_id']);

                    $context['news'] = array(
                        'id_category' => $_POST['category_id'],
                        'id_serie' => $_POST['series_id'],
                        'Nid_category' => $_POST['category_id'],
                        'Nid_series' => $_POST['series_id'],
                    );

                    // Just we need the template.
                    $context['sub_template'] = 'news_edit';
                    $context['page_title'] = $txt['an-newsAdd'];
                    $context['button_title'] = $txt['an-chaptersContinueButton'];
                    $context['news_action'] = 'addNews';
                } else {//Heading to last step, fill the general information
                    // Just we need the template.

                    $context['news'] = array(
                        'id_category' => $_POST['category_id'],
                        'id_serie' => $_POST['series_id'],
                        'id_saga' => $_POST['sagas_id'],
                        'Nid_category' => $_POST['category_id'],
                        'Nid_series' => $_POST['series_id'],
                        'Nid_sagas' => $_POST['sagas_id'],
                    );

                    $context['chapters'] = getAnimeUnpublishedChaptersInfo($_POST['sagas_id']);

                    $context['sub_template'] = 'news_edit';
                    $context['page_title'] = $txt['an-newsAdd'];
                    $context['button_title'] = $txt['an-newsAddButton'];
                    $context['news_action'] = 'addNews';
                }
            }
        }
    }
    // Adding a chapter? Lets do this thang! ;D
    else {
        // Session check.
        checkSession();

        $_POST['sagas_id'] = (int) $_POST['sagas_id'];
        $_POST['category_id'] = (int)$_POST['category_id'];
        $_POST['text'] = $smcFunc['htmlspecialchars']($_POST['text'], ENT_QUOTES);

        // Chapter name and number can't be empty.
        if (empty($_POST['text']) || empty($_POST['category_id']) || empty($_POST['sagas_id']))
            fatal_lang_error('error_sp_name_empty', false);

        if(empty($_POST['chapters'])) {
            redirectexit('action=admin;area=an-news');
        }

        $newsInfo = array(
            'id' => null,
            'id_msg' => null,
            'id_saga' => $_POST['sagas_id'],
            'text' => $_POST['text'],
        );

        $newsInfo['chapters'] = getSelectedChapters($_POST['chapters']);

        $newsInfo['id'] = getLastNewsId() + 1;
        $expectedId = $newsInfo['id'];
        $newsInfo['id_msg'] = createNewsMessage($newsInfo);
        $newsInfo['id'] = addNews($newsInfo);
        
        if($newsInfo['id'] != $expectedId) {
        //Try to solve the bug when creating a New with the images
            modifyNewsMessage($newsInfo);
        }

        foreach($newsInfo['chapters'] as $chap) {
            $chap['id_download'] = $newsInfo['id'];
            modifyChapter($chap);
        }

        $sagasInfo = getAnimeSagasInfo($newsInfo['id_saga']);
        modifySagasMessage(null,$sagasInfo[0]);
        
        //Publish in portal
        $articleOptions = array(
            'id_category' => $newsInfo['chapters'][0]['id_category'],
            'id_message' => getFirstMessage($newsInfo['id_msg']),
            'approved' => 1,
        );

        
        createArticle($articleOptions);
        updateBlockSeries();

        // Return back to the series list.
        redirectexit('action=admin;area=an-news');
    }
}

function anime_admin_news_edit() {
    global $txt, $smcFunc, $context, $func, $sourcedir;

    // Not actually adding a category? Show the add category page.
    if (empty($_POST['edit_news'])) {
        if (empty($_POST['category_id'])) {
            $_REQUEST['news_id'] = (int) $_REQUEST['news_id'];

            // Show you ID.
            if(empty($_REQUEST['news_id']))
		fatal_lang_error('error_sp_id_empty', false);

            $context['news'] = getAnimeNewsInfo($_REQUEST['news_id']);
            $context['news'] = $context['news'][0];
            $context['categories'] = getAnimeCategoryInfo();

            // Just we need the template.
            $context['sub_template'] = 'news_edit';
            $context['page_title'] = $txt['an-newsEdit'];
            $context['button_title'] = $txt['an-chaptersContinueButton'];
            $context['news_action'] = 'editNews';
        } else {
            if (empty($_POST['series_id'])) {
                $context['series'] = getAnimeSeriesInfo(null,$_POST['category_id']);
                $context['news'] = getAnimeNewsInfo($_POST['news_id']);
                $context['news'] = $context['news'][0];

                //$context['news']['id_category'] = $_POST['category_id'];
                $context['news']['Nid_category'] = $_POST['category_id'];

                // Just we need the template.
                $context['sub_template'] = 'news_edit';
                $context['page_title'] = $txt['an-newsEdit'];
                $context['button_title'] = $txt['an-chaptersContinueButton'];
                $context['news_action'] = 'editNews';
            } else {
                if (empty($_POST['sagas_id'])) {
                    $context['sagas'] = getAnimeSagasInfoForSeries($_POST['series_id']);
                    $context['news'] = getAnimeNewsInfo($_POST['news_id']);
                    $context['news'] = $context['news'][0];

                    //$context['news']['id_category'] = $_POST['category_id'];
                    $context['news']['Nid_category'] = $_POST['category_id'];
                    //$context['news']['id_series'] = $_POST['series_id'];
                    $context['news']['Nid_series'] = $_POST['series_id'];


                    // Just we need the template.
                    $context['sub_template'] = 'news_edit';
                    $context['page_title'] = $txt['an-newsEdit'];
                    $context['button_title'] = $txt['an-chaptersContinueButton'];
                    $context['news_action'] = 'editNews';
                } else {//Heading to last step, fill the general information
                    // Just we need the template.
                    $context['news'] = getAnimeNewsInfo($_POST['news_id']);
                    $context['news'] = $context['news'][0];

                    //$context['news']['id_category'] = $_POST['category_id'];
                    $context['news']['Nid_category'] = $_POST['category_id'];
                    //$context['news']['id_series'] = $_POST['series_id'];
                    $context['news']['Nid_series'] = $_POST['series_id'];
                    //$context['news']['id_sagas'] = $_POST['sagas_id'];
                    $context['news']['Nid_sagas'] = $_POST['sagas_id'];

                    $context['chapters'] = getAnimeUnpublishedChaptersInfo($_POST['sagas_id'], $_POST['news_id']);

                    $context['sub_template'] = 'news_edit';
                    $context['page_title'] = $txt['an-newsEdit'];
                    $context['button_title'] = $txt['an-newsEditButton'];
                    $context['news_action'] = 'editNews';
                }
            }
        }
    }
    // Adding a chapter? Lets do this thang! ;D
    else {
        // Session check.
        checkSession();

        $_POST['sagas_id'] = (int) $_POST['sagas_id'];
        $_POST['category_id'] = (int)$_POST['category_id'];
        $_POST['text'] = $smcFunc['htmlspecialchars']($_POST['text'], ENT_QUOTES);

        // Chapter name and number can't be empty.
        if (empty($_POST['text']) || empty($_POST['category_id']) || empty($_POST['sagas_id']))
            fatal_lang_error('error_sp_name_empty', false);

        if(empty($_POST['chapters'])) {
            redirectexit('action=admin;area=an-news');
        }

        $newsInfo = getAnimeNewsInfo($_POST['news_id']);
        $newsInfo = $newsInfo[0];

        foreach($newsInfo['chapters'] as $chap) {
            $chap['id_download'] = null;
            modifyChapter($chap);
        }

        $newsInfo['id_saga'] = $_POST['sagas_id'];
        $newsInfo['text'] = $_POST['text'];

        $newsInfo['chapters'] = getSelectedChapters($_POST['chapters']);

        foreach($newsInfo['chapters'] as $chap) {
            $chap['id_download'] = $newsInfo['id'];
            modifyChapter($chap);
        }

        modifyNewsMessage($newsInfo);
        modifyNews($newsInfo);

        updateAllSagas();
        updateAllSeries();
        updateAllNews();
        updateBlockSeries();

        // Return back to the series list.
        redirectexit('action=admin;area=an-news');
    }
}

function anime_admin_news_change() {
    
}
?>
