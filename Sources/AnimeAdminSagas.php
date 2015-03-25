<?php
/**********************************************************************************
* AnimeAdminSagas.php                                                          *
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

function anime_admin_sagas_main() {
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
    require_once($sourcedir . '/MoveTopic.php');
    //TODO: Own Template
    //We load the template, using SimplePortal One...
    loadTemplate('AnimeAdminSagas');

    //List of all the possible actions
    $subActions = array(
                'listSagas' => 'anime_admin_sagas_list',
		'addSagas' => 'anime_admin_sagas_add',
		'editSagas' => 'anime_admin_sagas_edit',
                'deleteSagas' => 'anime_admin_sagas_delete',
                'stateChange' => 'anime_admin_sagas_change',
    );

    //Check and get if we have the "sa" parameter (Default info)
    $_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'listSagas';

    //Title and all stuff
    $context[$context['admin_menu_name']]['tab_data'] = array(
        'title' => $txt['an-adminSagas'],
	'description' => $txt['an-adminSagasDesc'],
    );

    //Call to the function we want
    $subActions[$_REQUEST['sa']]();
}


function anime_admin_sagas_list() {
    global $txt, $context, $smcFunc, $scripturl;

	// Category list columns.
	$context['columns'] = array(
		'series' => array(
			'width' => '25%',
			'label' => $txt['sp-adminColumnSeries'],
			'class' => 'first_th',
		),
		'name' => array(
			'width' => '25%',
			'label' => $txt['sp-adminColumnName'],
		),
                'picture' => array(
                        'width' => '25%',
			'label' =>  $txt['an-sagasBanner'],
                ),
                'licensed' => array(
                    'width' => '13%',
                    'label' =>  $txt['an-sagasLicensed'],
                ),
		'action' => array(
			'width' => '12%',
			'label' => $txt['sp-adminColumnAction'],
			'class' => 'last_th',
		),
	);
    
    //PAGINACION  desde aqu� faltaba
    // Count all the articles.
	$request = $smcFunc['db_query']('','
		SELECT COUNT(*)
		FROM {db_prefix}an_sagas
        WHERE ID_SAGA IS NOT NULL'
	);
	list ($context['total_articles']) =  $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);
	// Construct the page index. 20 articles per page.
	$context['page_index'] = constructPageIndex($scripturl . '?action=admin;area=an-sagas;sa=listSagas', $_REQUEST['start'], $context['total_articles'], 20);
	$context['start'] = $_REQUEST['start'];
    //hasta aqu� es lo que faltaba de paginaci�n

	// Get all the series.
	$context['sagas'] = getAnimeSagasInfo();

	// Call the sub template.
	$context['sub_template'] = 'sagas_list';
	$context['page_title'] = $txt['an-adminSagasListName'];
}

function anime_admin_sagas_add()
{
    global $txt, $smcFunc, $context, $boardurl;

    // Not actually adding a saga? Show the add saga page.
    if (empty($_POST['edit_sagas'])) {
        $context['seriesInfo'] = getAnimeSeriesInfo();
        $context['specs'] = getAnimeSpecsInfo();

        // Just we need the template.
        $context['sub_template'] = 'sagas_edit';
        $context['page_title'] = $txt['an-sagasAdd'];
        $context['button_title'] = $txt['an-sagasAddButton'];
        $context['sagas_action'] = 'addSagas';
    }
    // Adding a category? Lets do this thang! ;D
    else {
        checkSession();

        // Sagas name and series number can't be empty.
	if (empty($_POST['sagas_name']) || empty($_POST['seriesSelect']))
		fatal_lang_error('error_sp_name_empty', false);

        if(!empty($_POST['sagas_staff']))
            $staff = $smcFunc['htmlspecialchars']($_POST['sagas_staff'], ENT_QUOTES);
        

        $sagasInfo = array(
			'name' => $smcFunc['htmlspecialchars']($_POST['sagas_name'], ENT_QUOTES),
			'banner' => $smcFunc['htmlspecialchars']($_POST['sagas_banner'], ENT_QUOTES),
                        'abstract' => $smcFunc['htmlspecialchars']($_POST['sagas_abstract'], ENT_QUOTES),
                        'licensed' => !empty($_POST['licensed']) ? (int) $_POST['licensed'] : 0,
                        'id_series' =>  (int) $_POST['seriesSelect'],
                        'staff' => !empty($staff) ? $staff : '',
                        'licensed' => empty($_POST['licensed'])? 0 :1,
		);

        $aux = getAnimeSeriesInfo($_POST['seriesSelect']);
        $seriesInfo = $aux[0];

        if(empty($sagasInfo['banner'])){
            $sagasInfo['banner'] = $boardurl."/imgbb/Series/".$seriesInfo['name']."/".$seriesInfo['name']."-Sagas-1.png";
        }

        if($seriesInfo['sagas'] > 0) {
            $prevSagasInfo = getAnimeSagasInfoForSeries($seriesInfo['id']);
            $prevSagasInfo = $prevSagasInfo[0];

            $prevSagasInfo['id_msg'] = createSagasMessage($seriesInfo, $prevSagasInfo);

            modifySagas($prevSagasInfo);

            $sagasInfo['id_msg'] = createSagasMessage($seriesInfo, $sagasInfo);
        }else{
            $sagasInfo['id_msg'] = null;
        }
        $sagasInfo['id'] = addSagas($sagasInfo);

        $seriesInfo['sagas']++;
        //At last we modify the recopilatory series post
        modifySeriesMessage($seriesInfo);

        if($seriesInfo['sagas'] > 1) {
            modifySagasMessage($seriesInfo, $sagasInfo);
        }
        //And back to the sagas list...
        redirectexit('action=admin;area=an-sagas;sa=listSagas');
    }

}

function anime_admin_sagas_edit() {
    global $txt, $smcFunc, $context, $sourcedir;

    require_once($sourcedir . '/RemoveTopic.php');

    // Not actually adding a saga? Show the add saga page.
    if (empty($_POST['edit_sagas'])) {
        $_REQUEST['saga_id'] = (int) $_REQUEST['saga_id'];

	// Show you ID.
	if(empty($_REQUEST['saga_id']))
		fatal_lang_error('error_sp_id_empty', false);

        $context['seriesInfo'] = getAnimeSeriesInfo();
        $context['sagasInfo'] = getAnimeSagasInfo($_REQUEST['saga_id']);
        $context['sagasInfo'] = $context['sagasInfo'][0];

        $context['specs'] = getAnimeSpecsInfo();

        // Just we need the template.
        $context['sub_template'] = 'sagas_edit';
        $context['page_title'] = $txt['an-sagasEdit'];
        $context['button_title'] = $txt['an-sagasEditButton'];
        $context['sagas_action'] = 'editSagas';
    }
    // Adding a category? Lets do this thang! ;D
    else {
        checkSession();

        $_POST['seriesSelect'] = (int) $_POST['seriesSelect'];
        $_POST['sagas_name'] = trim($_POST['sagas_name']);
        $_POST['saga_id'] = (int) $_POST['saga_id'];
        // Sagas name and series number can't be empty.
	if (empty($_POST['sagas_name']) || empty($_POST['seriesSelect']) || empty($_POST['saga_id']))
		fatal_lang_error('error_sp_name_empty', false);

        if(!empty($_POST['sagas_staff']))
            $staff = $smcFunc['htmlspecialchars']($_POST['sagas_staff'], ENT_QUOTES);
        
        if(!empty($_POST['specs'])) {
            updateSpecsForSaga($_POST['specs'], $_POST['saga_id']);
        }

        $aux = getAnimeSagasInfo($_POST['saga_id']);
        $sagasInfo = $aux[0];

        $sagasInfo['name'] =  $smcFunc['htmlspecialchars']($_POST['sagas_name'], ENT_QUOTES);
	$sagasInfo['banner'] = $smcFunc['htmlspecialchars']($_POST['sagas_banner'], ENT_QUOTES);
        $sagasInfo['abstract'] = $smcFunc['htmlspecialchars']($_POST['sagas_abstract'], ENT_QUOTES);
        $sagasInfo['licensed'] = !empty($_POST['licensed']) ? (int) $_POST['licensed'] : 0;
        $sagasInfo['id_series'] =  (int) $_POST['seriesSelect'];
        $sagasInfo['staff'] = (!empty($staff) ? $staff : '');
        $sagasInfo['licensed'] = (empty($_POST['licensed']) ? 0 : 1);

        if(!empty($_POST['previous_series'])) {
            $aux = getAnimeSeriesInfo($_POST['previous_series']);
            $previousSeries = $aux[0];
        }
        $aux = getAnimeSeriesInfo($_POST['seriesSelect']);
        $seriesInfo = $aux[0];

        if(empty($sagasInfo['banner'])){
            $sagasInfo['banner'] = $seriesInfo['picture']['href'];
        }

        if(!empty($previousSeries['id']) && $previousSeries['id'] != $seriesInfo['id']){
            //We are leaving that series
                       
            if($seriesInfo['sagas'] > 0) {
                if($seriesInfo['sagas'] == 1) {
                    $newSagasInfo = getAnimeSagasInfoForSeries($seriesInfo['id']);
                    $newSagasInfo = $newSagasInfo[0];
                    $newSagasInfo['id_msg'] = createSagasMessage($seriesInfo, $newSagasInfo);
                    modifySagas($newSagasInfo);
                }
                if($sagasInfo['id_msg'] != null && $sagasInfo['id_msg'] != 0) {
                    moveTopics($sagasInfo['id_msg'],$seriesInfo['id_board']);
                } else {
                    $sagasInfo['id_msg'] = createSagasMessage($seriesInfo, $sagasInfo);
                }
            }else{
                if($sagasInfo['id_msg'] != null && $sagasInfo['id_msg'] != 0) {
                    removeTopics($sagasInfo['id_msg']);
                }
            }

            modifySagas($sagasInfo);
            $seriesInfo = getAnimeSeriesInfo($seriesInfo['id']);
            $seriesInfo = $seriesInfo[0];
            
            if($previousSeries['sagas'] == 2) {
                $previousSagasInfo = getAnimeSagasInfoForSeries($previousSeries['id']);
                removeTopics($previousSagasInfo[0]['id_msg']);
                modifySagas($previousSagasInfo[0]);
            }

            $previousSeries = getAnimeSeriesInfo($previousSeries['id']);
            $previousSeries = $previousSeries[0];
            modifySeriesMessage($previousSeries);
        }else{
            //We aren't leaving the serie
            if($seriesInfo['sagas'] == 1 && $sagasInfo['id_msg'] != null && $sagasInfo['id_msg'] != 0) {
                //Deleting the sagas post.
                removeTopics($sagasInfo['id_msg']);
                $sagasInfo['id_msg'] = null;
            } else {
                if($sagasInfo['id_msg'] != null && $sagasInfo['id_msg'] != 0)
                    $sagasInfo['id_msg'] = modifySagasMessage($seriesInfo, $sagasInfo);
            }
            modifySagas($sagasInfo);
        }
        //trigger_error("Saga modified");

        //Modify all the news that are from the saga
        $newsInfo = getAnimeNewsInfo();
        foreach ($newsInfo as $news) {
            if($news['id_saga'] == $sagasInfo['id']) {
                modifyNewsMessage($news);
            }
        }
        //trigger_error("News modified");
        //At last we modify the recopilatory series post
        modifySeriesMessage($seriesInfo);
        //trigger_error("Serimes message modified");
        updateBlockSeries();

        //And back to the sagas list...
        redirectexit('action=admin;area=an-sagas;sa=listSagas');
    }
}

function anime_admin_sagas_delete() {

}

function anime_admin_sagas_change() {
     global $smcFunc;

    $_REQUEST['sagas_id'] = (int) $_REQUEST['sagas_id'];

    if(empty($_REQUEST['sagas_id']) || empty($_REQUEST['type']))
			fatal_lang_error('error_sp_id_empty', false);


    if($_REQUEST['type'] == 'Licensed') {
        //Toogle value
        $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_sagas
                        SET ' . $_REQUEST['type'] . ' = 1 -' . $_REQUEST['type']  . '
			WHERE ID_SAGA = {int:id_saga}',
			// Data to put in.
			array(
                                'id_saga' => $_REQUEST['sagas_id'],
			)
		);

        $sagasInfo = getAnimeSagasInfo($_REQUEST['sagas_id']);

        modifySagasMessage(null,$sagasInfo[0]);
        updateBlockSeries();


    }else{
        fatal_lang_error('error_sp_id_empty', false);
    }

    redirectexit('action=admin;area=an-sagas;sa=listSagas');
}
?>