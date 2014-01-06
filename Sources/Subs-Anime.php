<?php

/* * ********************************************************************************
 * Subs-Anime.php                                                                  *
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

/*

  void anime_manager_init() {
  Initilizes the anime-manager languages.
  }



 */

function anime_manager_init() {
    global $txt, $context;

    $anime_manager_version = "0.1";

    $context['an_version'] = $anime_manager_version;

    loadLanguage('Anime', true, false);
}

function getAnimeCategoryInfo($category_id = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt;

    //Only selects articles created via AnimeManager
    $request = $smcFunc['db_query']('', '
		SELECT simple.id_category, simple.name, simple.picture, simple.articles, simple.publish, anime.id_category_forums, anime.id_category_private, anime.id_category_forums_finalized, anime.id_category_private_finalized
		FROM {db_prefix}sp_categories simple, {db_prefix}an_categories anime' . (!empty($category_id) ? '
		WHERE simple.id_category = anime.id_category_sp AND simple.id_category = {int:category_id}' : '
                WHERE simple.id_category = anime.id_category_sp') . '
 		ORDER BY simple.id_category',
                    array(
                        'category_id' => $category_id,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['id_category'],
            'name' => $row['name'],
            'picture' => array(
                'href' => $row['picture'],
                'image' => '<img src="' . $row['picture'] . '" alt="' . $row['name'] . '" width="75" />',
            ),
            'articles' => $row['articles'],
            'publish' => $row['publish'],
            'id_category_forums' => $row['id_category_forums'],
            'id_category_private' => $row['id_category_private'],
            'id_category_forums_finalized' => $row['id_category_forums_finalized'],
            'id_category_private_finalized' => $row['id_category_private_finalized'],
            'selected' => 0,
        );
    }
    $smcFunc['db_free_result']($request);

    return $return;
}

function getOrderCategory() {
    global $smcFunc;

    $request = $smcFunc['db_query']('', '
		SELECT *
		FROM {db_prefix}an_categories
		ORDER BY id_category DESC
                LIMIT 1',
                    array(
                    )
    );

    $row = $smcFunc['db_fetch_assoc']($request);

    if (empty($row)) {
        $row['id_category'] = 0;
        $row['id_category_sp'] = 0;
        $row['id_category_forums'] = 1;
        $row['id_category_forums_finalized'] = 1;
        $row['id_category_private'] = 2;
        $row['id_category_private_finalized'] = 2;
    }

    return $row;
}

function getAnimeSeriesInfo2($series_id = null, $category_id = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $boardurl, $start;
    
    if(empty($context['start'])){$context['start'] = 0;}

    //We obtain the info of the categories
    $categories = getAnimeCategoryInfo();



    $request = $smcFunc['db_query']('', '
		SELECT *
		FROM {db_prefix}an_series ' . (!empty($series_id) || !empty($category_id) ? '
                WHERE ' : '' ) . (!empty($series_id) ? ' {int:my_id}=ID_SERIES ' : '' ) . (!empty($series_id) && !empty($category_id) ? 'AND' : '') . (!empty($category_id) ? ' ID_Category = {int:categoryId}' : '' ) . '
		ORDER BY Finalized ASC, Public ASC, ID_Category ASC, Name ASC
        LIMIT {int:start}, {int:limit}',
                    array(
                        'my_id' => $series_id,
                        'categoryId' => $category_id,
                        'start' => $context['start'],
                        'limit' => 20,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        //Obtenemos el nombre de la categoria
        $catName = $txt['an-categoriesNoCategory'];
        foreach ($categories as $cat) {
            if ($cat['id'] == $row['ID_CATEGORY']) {
                $catName = $cat['name'];
            }
        }

        //Contamos el número de sagas de la serie
        $sagasrequest = $smcFunc['db_query']('',
                        'SELECT COUNT(*) as Number
                  FROM {db_prefix}an_sagas
                  WHERE {int:my_id}=ID_SERIES',
                        array(
                            'my_id' => $row['ID_SERIES'],
                        )
        );
        $aux = $smcFunc['db_fetch_assoc']($sagasrequest);
        $sagasNumber = $aux['Number'];

        $smcFunc['db_free_result']($sagasrequest);

        $return[] = array(
            'id' => $row['ID_SERIES'],
            'id_category' => $row['ID_CATEGORY'],
            'id_board' => $row['ID_BOARD'],
            'id_private_board' => $row['ID_Private_Board'],
            'id_msg' => $row['ID_MSG'],
            'name' => $row['Name'],
            'picture' => array(
                'href' => $row['Img_Banner'],
                'image' => '<img src="' . $row['Img_Banner'] . '" alt="' . $row['Name'] . '" width="200" />',
            ),
            'newsImg' => array(
                'href' => $row['Img_News'],
                'image' => '<img src="'. $row['Img_News']. '" alt="' . $row['Name'] . '" width="200" />',
            ),
            'img_download_block' => array(
                'href' => $row['Img_Download_Block'],
                'image' => '<img src="' . $row['Img_Download_Block'] . '" alt="' . $row['Name'] . '" width="75" />',
            ),
            'img_slider' => array(
                'href' => $row['Img_slider'],
                'image' => '<img src="' . $row['Img_slider'] . '" alt="' . $row['Name'] . '" width="75" />',
            ),
            'abstract' => $row['Abstract'],
            'chapters_made' => CountAnimeChapters($row['ID_SERIES']),
            'chapters_total' => $row['Chapters_total'],
            'finalized' => $row['Finalized'],
            'public' => $row['Public'],
            'category_name' => $catName,
            'sagas' => $sagasNumber,
            'staff' => $row['Staff'],
            'Img_staff' => array(
                'href' => $row ['Img_staff'],
                'image' => '<img src="' . $row['Img_staff'] . '" alt="Staff - ' . $row['Name'] . '" width="100" />'
            ),
            'boardLink' => $boardurl . "/index.php?topic=" . $row['ID_MSG'] . ".0",
        );
    }
    $smcFunc['db_free_result']($request);

    return $return;
}

function getAnimeSeriesInfo($series_id = null, $category_id = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $boardurl;

    //We obtain the info of the categories
    $categories = getAnimeCategoryInfo();



    $request = $smcFunc['db_query']('', '
		SELECT *
		FROM {db_prefix}an_series ' . (!empty($series_id) || !empty($category_id) ? '
                WHERE ' : '' ) . (!empty($series_id) ? ' {int:my_id}=ID_SERIES ' : '' ) . (!empty($series_id) && !empty($category_id) ? 'AND' : '') . (!empty($category_id) ? ' ID_Category = {int:categoryId}' : '' ) . '
		ORDER BY Finalized ASC, Public ASC, ID_Category ASC, Name ASC',
                    array(
                        'my_id' => $series_id,
                        'categoryId' => $category_id,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        //Obtenemos el nombre de la categoria
        $catName = $txt['an-categoriesNoCategory'];
        foreach ($categories as $cat) {
            if ($cat['id'] == $row['ID_CATEGORY']) {
                $catName = $cat['name'];
            }
        }

        //Contamos el número de sagas de la serie
        $sagasrequest = $smcFunc['db_query']('',
                        'SELECT COUNT(*) as Number
                  FROM {db_prefix}an_sagas
                  WHERE {int:my_id}=ID_SERIES',
                        array(
                            'my_id' => $row['ID_SERIES'],
                        )
        );
        $aux = $smcFunc['db_fetch_assoc']($sagasrequest);
        $sagasNumber = $aux['Number'];

        $smcFunc['db_free_result']($sagasrequest);

        $return[] = array(
            'id' => $row['ID_SERIES'],
            'id_category' => $row['ID_CATEGORY'],
            'id_board' => $row['ID_BOARD'],
            'id_private_board' => $row['ID_Private_Board'],
            'id_msg' => $row['ID_MSG'],
            'name' => $row['Name'],
            'picture' => array(
                'href' => $row['Img_Banner'],
                'image' => '<img src="' . $row['Img_Banner'] . '" alt="' . $row['Name'] . '" width="200" />',
            ),
            'newsImg' => array(
                'href' => $row['Img_News'],
                'image' => '<img src="'. $row['Img_News']. '" alt="' . $row['Name'] . '" width="200" />',
            ),
            'img_download_block' => array(
                'href' => $row['Img_Download_Block'],
                'image' => '<img src="' . $row['Img_Download_Block'] . '" alt="' . $row['Name'] . '" width="75" />',
            ),
            'img_slider' => $row['Img_slider'],
            'abstract' => $row['Abstract'],
            'chapters_made' => CountAnimeChapters($row['ID_SERIES']),
            'chapters_total' => $row['Chapters_total'],
            'finalized' => $row['Finalized'],
            'public' => $row['Public'],
            'category_name' => $catName,
            'sagas' => $sagasNumber,
            'staff' => $row['Staff'],
            'Img_staff' => array(
                'href' => $row ['Img_staff'],
                'image' => '<img src="' . $row['Img_staff'] . '" alt="Staff - ' . $row['Name'] . '" width="100" />'
            ),
            'boardLink' => $boardurl . "/index.php?topic=" . $row['ID_MSG'] . ".0",
        );
    }
    $smcFunc['db_free_result']($request);

    return $return;
}

function addSeries($seriesInfo = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt;

    if ($seriesInfo == null) {
        trigger_error('addSeries(): One or more of the required options is not set', E_USER_ERROR);
    }

    //Insert into AnimeManager Database
    $smcFunc['db_insert']('normal', '{db_prefix}an_series',
            // Columns to insert.
            array(
                'ID_CATEGORY' => 'int',
                'ID_BOARD' => 'int',
                'ID_MSG' => 'int',
                'Name' => 'string',
                'Img_Banner' => 'string',
                'Img_News' => 'string',
                'Img_staff' => 'string',
                'Img_slider' => 'string',
                'Img_Download_block' => 'string',
                'Abstract' => 'string',
                'Staff' => 'string',
                'Chapters_made' => 'int',
                'Chapters_total' => 'int',
                'Finalized' => 'int',
                'ID_Private_Board' => 'int',
                'Public' => 'int',
            ),
            // Data to put in.
            array(
                'ID_CATEGORY' => $seriesInfo['id_category'],
                'ID_BOARD' => $seriesInfo['id_board'],
                'ID_MSG' => $seriesInfo['message'],
                'Name' => $seriesInfo['name'],
                'Img_Banner' => $seriesInfo['banner'],
                'Img_News' => $seriesInfo['newsImg']['href'],
                'Img_staff' => $seriesInfo['Img_staff']['href'],
                'Img_slider' => $seriesInfo['img_slider'],
                'Img_Download_block' => $seriesInfo['downloads'],
                'Abstract' => $seriesInfo['abstract'],
                'Staff' => $seriesInfo['staff'],
                'Chapters_made' => 0,
                'Chapters_total' => $seriesInfo['chapters_total'],
                'Finalized' => $seriesInfo['finalized'],
                'ID_Private_Board' => $seriesInfo['id_private_board'],
                'Public' => $seriesInfo['public'],
            ),
            // We had better tell SMF about the key, even though I can't remember why? ;)
            array('ID_SERIES')
    );
}

function editSeries($seriesInfo = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt;

    if ($seriesInfo == null) {
        trigger_error('editSeries(): One or more of the required options is not set', E_USER_ERROR);
    }

    $series_fields = array();
    $series_fields[] = "ID_CATEGORY = {int:ID_CATEGORY}";
    $series_fields[] = "Name = {string:Name}";
    $series_fields[] = "Img_Banner = {string:Img_Banner}";
    $series_fields[] = "Img_News = {string:Img_News}";
    $series_fields[] = "Img_staff = {string:Img_staff}";
    $series_fields[] = "Img_slider = {string:Img_slider}";
    $series_fields[] = "Img_Download_block = {string:Img_Download_block}";
    $series_fields[] = "Abstract = {string:Abstract}";
    $series_fields[] = "Chapters_total = {int:Chapters_total}";
    $series_fields[] = "Finalized = {int:Finalized}";
    $series_fields[] = "Public = {int:Public}";
    $series_fields[] = "Staff = {string:Staff}";
    $series_fields[] = "ID_MSG = {int:ID_MSG}";

    //Update AnimeManager Database
    $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_series
                        SET ' . implode(', ', $series_fields) . '
			WHERE ID_SERIES = {int:id_series}',
            // Data to put in.
            array(
                'id_series' => $seriesInfo['id'],
                'ID_CATEGORY' => $seriesInfo['id_category'],
                'Name' => $seriesInfo['name'],
                'Img_Banner' => empty($seriesInfo['banner']) ? $seriesInfo['picture']['href'] : $seriesInfo['banner'],
                'Img_News' => $seriesInfo['newsImg']['href'],
                'Img_staff' => $seriesInfo['Img_staff']['href'],
                'Img_slider' => $seriesInfo['img_slider'],
                'Img_Download_block' => empty($seriesInfo['downloads']) ? $seriesInfo['img_download_block']['href'] : $seriesInfo['downloads'],
                'Abstract' => $seriesInfo['abstract'],
                'Chapters_total' => empty($seriesInfo['chapters_total']) ? 0 : $seriesInfo['chapters_total'],
                'Finalized' => $seriesInfo['finalized'],
                'Public' => $seriesInfo['public'],
                'Staff' => $seriesInfo['staff'],
                'ID_MSG' => $seriesInfo['id_msg'],
            )
    );
}

function CountAnimeChapters($seriesId = null) {
    global $smcFunc;

    if (empty($seriesId)) {
        trigger_error('AnimeCountChapters(): One or more of the required options is not set', E_USER_ERROR);
    }

//FROM {db_prefix}an_chapter c, {db_prefix}an_sagas s
//WHERE {int:my_id}=s.ID_SERIES AND c.ID_SAGA = s.ID_SAGA AND c.ID_DOWNLOAD IS NOT NULL',

    $request = $smcFunc['db_query']('',
                    'SELECT COUNT(c.ID_CHAPTER) as Number
             		 FROM {db_prefix}an_chapter c, {db_prefix}an_sagas s
				     WHERE {int:my_id}=s.ID_SERIES AND c.ID_SAGA = s.ID_SAGA AND c.ID_DOWNLOAD IS NOT NULL',
                    array(
                        'my_id' => $seriesId,
                    )
    );

    $aux = $smcFunc['db_fetch_assoc']($request);
    $chapterNumber = $aux['Number'];

    $smcFunc['db_free_result']($request);

    return $chapterNumber;
}

function getFirstMessage($topic_id = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $user_info;
    global $sourcedir;

    if ($topic_id == null) {
        trigger_error('getFirstMessage(): One or more of the required options is not set', E_USER_ERROR);
    }

    $request = $smcFunc['db_query']('', '
        SELECT id_first_msg
        FROM    {db_prefix}topics
        WHERE id_topic = {int:topic}',
                    array(
                        'topic' => $topic_id,
                    )
    );
    $aux = $smcFunc['db_fetch_row']($request);

    $message_id = $aux[0];

    $smcFunc['db_free_result']($request);

    return $message_id;
}

function generateSeriesMessage($seriesInfo) {
    global $txt;

    $nl = "<br />";

    $message = "";
    $message .= '[center][html]<img src="'. $seriesInfo['picture']['href'] .'" alt="'. $seriesInfo['name'] .'" title="'. $seriesInfo['name'] .'" />[/html][/center]' . $nl;
    $message .= "[center][font=trebuchet ms][size=11pt][b]" . $seriesInfo['name'] . "[/b][/size][/font][/center]" . $nl . $nl;

 //   $message .= "[size=18pt][u][b]" . $txt['an-seriesAbstract'] . "[/b][/u][/size]" . $nl;
    $message .= "[center][font=trebuchet ms][size=10pt]" . $seriesInfo['abstract'] . "[/size][/font][/center]" . $nl . $nl;
    //$message .= "[size=18pt][u][b]" . $txt['an-seriesStaff'] . "[/b][/u][/size]" . $nl;

    if (!empty($seriesInfo['id'])) {
        $sagas = getAnimeSagasInfoForSeries($seriesInfo['id']);

        if ($seriesInfo['sagas'] > 1) { //More than one saga
            $message .= "[center][font=trebuchet ms][size=11pt][b]" . $txt['an-adminSagas'] . "[/b][/size][/font][/center]" . $nl . $nl;

            foreach ($sagas as $saga) {
                $message .= '[center][html]<a href="'. $saga['boardLink'] .'"><img src="'. $saga['picture']['href'] .'" alt="'. $saga['name'] .'" title="'. $saga['name'] .'" /></a>[/html][/center]' . $nl ."[size=5pt]". $nl . "[/size]";
            }
        } else {
            if ($seriesInfo['sagas'] > 0) { //Only one saga
                $message .= generateDownloadsForSaga($sagas[0]);
            }
        }
    }
    if(!empty($seriesInfo['id']) && $seriesInfo['sagas'] == 1) {
        $sagasInfo = getAnimeSagasInfoForSeries($seriesInfo['id']);
        $sagasInfo = $sagasInfo[0];
        $message .= generateAnimeSpecsMessage($sagasInfo);
    }

    $message .= '[center][html]<img src="'. $seriesInfo['Img_staff']['href'] .'" alt="Staff - '. $seriesInfo['name'] .'" title="Staff - '. $seriesInfo['name'] .'" />[/html][/center]' . $nl;
    $message .= "[center][font=trebuchet ms][size=10pt]" . $seriesInfo['staff'] . "[/size][/font][/center]" . $nl . $nl;

    return $message;
}

function createSeriesBoard($seriesInfo = null) {

    global $txt;

    if(empty($seriesInfo) || empty($seriesInfo['name'])) {
        trigger_error('createSeriesBoard() seriesInfo not valid');
    }
    $aux = getAnimeCategoryInfo($seriesInfo['id_category']);
    $series_categories = $aux[0];

    //Fill generic board info
    $boardOptions = array();

    //Name and description
    $boardOptions['board_name'] = preg_replace('~[&]([^;]{8}|[^;]{0,8}$)~', '&amp;$1', $seriesInfo['name']);
    $boardOptions['board_description'] = preg_replace('~[&]([^;]{8}|[^;]{0,8}$)~', '&amp;$1', $txt['an-seriesDesciptionBegin'] . $seriesInfo['category_name'] . " " . $seriesInfo['name']);
    //No moderators
    $boardOptions['moderator_string'] = '';
    //No redirect
    $boardOptions['redirect'] = '';
    //Default theme
    $boardOptions['override_theme'] = 0;
    $boardOptions['board_theme'] = 0;

    //Permission profile by default
    $boardOptions['profile'] = 1;
    $boardOptions['inherit_permissions'] = 0;

    //Persons that can see the board
    $boardOptions['access_groups'] = array();
    $boardOptions['access_groups'][] = 2; //Global moderators at least
    //TODO: Auto Fansub team adding
    $boardOptions['access_groups'][] = 9; //Fansub Team
    //At the end of the category
    $boardOptions['move_to'] = 'bottom';
    //Count all the messages
    $boardOptions['posts_count'] = 1;


    /*
     * In this "if" block we definetly add  a new forum both in private and in public ones
     * Depending if it's finalized or not.
     */
    if ($seriesInfo['finalized']) {
        //Add to private
        $boardOptions['target_category'] = $series_categories['id_category_private_finalized'];
        $seriesInfo['id_private_board'] = createBoard($boardOptions);

        if ($seriesInfo['public']) {
            //Allow all users to see forum
            $boardOptions['access_groups'][] = -1;
            $boardOptions['access_groups'][] = 0;
	    //Chapuza para meter los otros grupos xD
	    //Vip y colaboradores
	    $boardOptions['access_groups'][] = 21;
          $boardOptions['access_groups'][] = 22;
	    $boardOptions['access_groups'][] = 27;
		//Tharep
		$boardOptions['access_groups'][] = 52;
	    
        }
        //Add public
        $boardOptions['target_category'] = $series_categories['id_category_forums_finalized'];
        $seriesInfo['id_board'] = createBoard($boardOptions);
    } else {
        //Add to private
        $boardOptions['target_category'] = $series_categories['id_category_private'];
        $seriesInfo['id_private_board'] = createBoard($boardOptions);
        if ($seriesInfo['public']) {
            //Allow all users to see forum
            $boardOptions['access_groups'][] = -1;
            $boardOptions['access_groups'][] = 0;
	    //Chapuza para meter los otros grupos xD
	    //Vip y colaboradores
	    $boardOptions['access_groups'][] = 21;
            $boardOptions['access_groups'][] = 22;
	    $boardOptions['access_groups'][] = 27;
	//Tharep
		$boardOptions['access_groups'][] = 52;
        }
        //Add public
        $boardOptions['target_category'] = $series_categories['id_category_forums'];
        $seriesInfo['id_board'] = createBoard($boardOptions);
    }

    return $seriesInfo;
}

function createSeriesMessage($seriesInfo) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $user_info;
    global $sourcedir;

    require_once($sourcedir . '/Subs-Post.php');

    if (empty($seriesInfo) || empty($seriesInfo['name'])) {
        trigger_error('createSeriesMessage(): One or more of the required options is not set', E_USER_ERROR);
    }

    if(empty($seriesInfo['picture']['href']))
        $seriesInfo['picture']['href'] = $seriesInfo['banner'];
    $message = generateSeriesMessage($seriesInfo);

    $msgOptions = array(
        'id' => 0,
        'subject' => $txt['an-series-ThreadName'] . $seriesInfo['name'],
        'body' => $message,
        'icon' => 'xx',
        'smileys_enabled' => true,
        'attachments' => array(),
        'approved' => true,
    );
    $topicOptions = array(
        'id' => 0,
        'board' => $seriesInfo['id_board'],
        'poll' => 0,
        'lock_mode' => null,
        'sticky_mode' => 1,
        'mark_as_read' => true,
        'is_approved' => true,
    );
    $posterOptions = array(
        'id' => $user_info['id'],
        'name' => $user_info['name'],
        'email' => $user_info['email'],
        'update_post_count' => true,
    );

    createPost($msgOptions, $topicOptions, $posterOptions);

    return $topicOptions['id'];
}

function modifySeriesMessage($seriesInfo) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $user_info;
    global $sourcedir;

    require_once($sourcedir . '/Subs-Post.php');

    if ($seriesInfo == null || empty($seriesInfo['id_msg'])) {
        trigger_error('modifySeriesMessage(): One or more of the required options is not set', E_USER_ERROR);
    }

    $message = generateSeriesMessage($seriesInfo);

    $messageId = getFirstMessage($seriesInfo['id_msg']);


    $msgOptions = array(
        'id' => $messageId,
        'subject' => $txt['an-series-ThreadName'] . $seriesInfo['name'],
        'body' => $message,
        'icon' => 'xx',
        'smileys_enabled' => true,
        'attachments' => array(),
        'approved' => true,
    );
    $topicOptions = array(
        'id' => $seriesInfo['id_msg'],
        'board' => $seriesInfo['id_board'],
        'poll' => 0,
        'lock_mode' => null,
        'sticky_mode' => 1,
        'mark_as_read' => true,
        'is_approved' => true,
    );
    $posterOptions = array(
        'id' => $user_info['id'],
        'name' => $user_info['name'],
        'email' => $user_info['email'],
        'update_post_count' => true,
    );

    modifyPost($msgOptions, $topicOptions, $posterOptions);

    return $topicOptions['id'];
}

function getAnimeSagasInfo($sagaId = null, $serieId = null, $limit = true) {
    global $context, $smcFunc, $boardurl;
    
    if(empty($context['start'])){$context['start'] = 0;}

    $request = $smcFunc['db_query']('', '
            SELECT ser.Name as SName, sag.ID_SAGA, sag.ID_SERIES, sag.ID_MSG, sag.Name as Name, sag.Image as Image, sag.Abstract, sag.Staff, sag.Licensed, ser.Img_Banner as sImage, ser.ID_MSG as SerMSG
            FROM {db_prefix}an_sagas sag, {db_prefix}an_series ser
            WHERE sag.ID_SERIES = ser.ID_SERIES ' . (!empty($sagaId) ? 'AND sag.ID_SAGA = {int:sagas_id} ' : '') . (!empty($serieId) ? 'AND ser.ID_SERIES = {int:series_id} ' : '') . '
            ORDER BY Public ASC,Finalized ASC,ser.Name,sag.ID_SAGA
            '.(($limit == true)?'LIMIT {int:start}, {int:limit}':''),
                    array(
                        'sagas_id' => $sagaId,
                        'series_id' => $serieId,
                        'start' => $context['start'],
                        'limit' => 20,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['ID_SAGA'],
            'id_series' => $row['ID_SERIES'],
            'id_msg' => $row['ID_MSG'],
            'name' => $row['Name'],
            'picture' => array(
                'href' => (empty($row['Image']) ? $row['sImage'] : $row['Image']),
                'image' => '<img src="' . (empty($row['Image']) ? $row['sImage'] : $row['Image']) . '" alt="' . $row['Name'] . '" width="200" />',
            ),
            'banner' => (empty($row['Image']) ? $row['sImage'] : $row['Image']),
            'abstract' => $row['Abstract'],
            'staff' => $row['Staff'],
            'boardLink' => $boardurl . "/index.php?topic=" . (empty($row['ID_MSG']) ? $row['SerMSG'] : $row['ID_MSG']) . ".0",
            'SeriesName' => $row['SName'],
            'licensed' => $row['Licensed'],
            'specs' => getAnimeSpecsForSaga($row['ID_SAGA']),
        );
    }

    $smcFunc['db_free_result']($request);

    return $return;
}

function getAnimeSagasInfoForSeries($seriesId = null) {

    $seriesId = (int) $seriesId;
    if ($seriesId == null) {
        trigger_error('getAnimeSagasInfoForSeries(): One or more of the required options is not set', E_USER_ERROR);
    }

    return getAnimeSagasInfo(null, $seriesId, false);
}

function modifyAnimeSeriesBoard($seriesInfo = null) {
    global $context, $txt, $boards;
    global $sourcedir;

    require_once($sourcedir . '/Subs-Boards.php');

    if (empty($seriesInfo)) {
        trigger_error('modifyAnimeSeriesBoard(): One or more of the required options is not set', E_USER_ERROR);
    }

    //Get all the category Info
    $aux = getAnimeCategoryInfo($seriesInfo['id_category']);
    $context['series_categories'] = $aux[0];

    if (empty($context['series_categories'])) {
        trigger_error('modifyAnimeSeriesBoard(): Series_categories empty', E_USER_ERROR);
    }

    //Código para obtener la información del foro privado anterior.
    //Simplemente para mantener los permisos de los colaboradores.
    getBoardTree();
    
    foreach($boards as $oldBoard) {
        if($oldBoard['id'] == $seriesInfo['id_private_board']) {
            $oldPrivateBoard = $oldBoard;
            break;
        }
    }
    
    //Fill generic board info
    $boardOptions = array();

    //Name and description
    $boardOptions['board_name'] = preg_replace('~[&]([^;]{8}|[^;]{0,8}$)~', '&amp;$1', $seriesInfo['name']);
    $boardOptions['board_description'] = preg_replace('~[&]([^;]{8}|[^;]{0,8}$)~', '&amp;$1', $txt['an-seriesDesciptionBegin'] . $seriesInfo['category_name'] . " " . $seriesInfo['name']);
    //No moderators
    //$boardOptions['moderator_string'] = '';
    //No redirect
    $boardOptions['redirect'] = '';
    //Default theme
    $boardOptions['override_theme'] = 0;
    $boardOptions['board_theme'] = 0;

    //Permission profile by default
    $boardOptions['profile'] = 1;
    $boardOptions['inherit_permissions'] = 0;

    //Persons that can see the board are the same than before
    $boardOptions['access_groups'] = $oldPrivateBoard['member_groups'];

    //Count all the messages
    $boardOptions['posts_count'] = 1;
    
    /*
     * In this "if" block we definetly add  a new forum both in private and in public ones
     * Depending if it's finalized or not.
     */
    if ($seriesInfo['finalized']) {
        //Add to private
        $boardOptions['target_category'] = $context['series_categories']['id_category_private_finalized'];
        if($boardOptions['target_category'] != $oldPrivateBoard['category']) {
            $boardOptions['move_to'] = 'bottom';
        }
        
        modifyBoard($seriesInfo['id_private_board'], $boardOptions);

        if ($seriesInfo['public']) {
            //Allow all users to see forum
            $boardOptions['access_groups'][] = -1;
            $boardOptions['access_groups'][] = 0;
            //Chapuza para meter los otros grupos xD
	    //Vip y colaboradores
	    $boardOptions['access_groups'][] = 21;
            $boardOptions['access_groups'][] = 22;
	    $boardOptions['access_groups'][] = 27;
        }
        //Add public
        $boardOptions['target_category'] = $context['series_categories']['id_category_forums_finalized'];
        modifyBoard($seriesInfo['id_board'], $boardOptions);
    } else {
        //Add to private
        $boardOptions['target_category'] = $context['series_categories']['id_category_private'];
        
        if($boardOptions['target_category'] != $oldPrivateBoard['category']) {
            $boardOptions['move_to'] = 'bottom';
        }
        
        modifyBoard($seriesInfo['id_private_board'], $boardOptions);
        if ($seriesInfo['public']) {
            //Allow all users to see forum
            $boardOptions['access_groups'][] = -1;
            $boardOptions['access_groups'][] = 0;
            //Chapuza para meter los otros grupos xD
	    //Vip y colaboradores
	    $boardOptions['access_groups'][] = 21;
            $boardOptions['access_groups'][] = 22;
            $boardOptions['access_groups'][] = 27;
        }
        //Add public
        $boardOptions['target_category'] = $context['series_categories']['id_category_forums'];
        modifyBoard($seriesInfo['id_board'], $boardOptions);
    }
}

function generateSagasMessage($seriesInfo, $sagasInfo) {
    global $txt;

    $nl = "<br />";

    $message = "";
    $message .= '[center][html]<a href="'. $seriesInfo['boardLink'] .'"><img src="'. $seriesInfo['picture']['href'] .'" alt="'. $seriesInfo['name'] .'" title="'. $seriesInfo['name'] .'" /></a>[/html][/center]' . $nl . $nl;

    //$message .= "[center][size=24pt][u][b]" . $seriesInfo['name'] . " - " . $sagasInfo['name'] . "[/b][/u][/size][/center]" . $nl;

    //$message .= $nl . $nl . "[size=18pt][u][b]" . $txt['an-seriesAbstract'] . "[/b][/u][/size]" . $nl;
    $message .= "[center][font=trebuchet ms][size=10pt]" . $sagasInfo['abstract'] . "[/size][/font][/center]" . $nl . $nl;
    //$message .= $nl . $nl . "[size=18pt][u][b]" . $txt['an-seriesStaff'] . "[/b][/u][/size]" . $nl;

    $message .= '[center][html]<img src="' . $sagasInfo['picture']['href'] . '" alt="'.$sagasInfo['name'].'" title="'.$sagasInfo['name'].'" />[/html][/center]' . $nl . $nl;
    if (!empty($sagasInfo['id'])) {
        $message .= generateDownloadsForSaga($sagasInfo);
    }

    $message .= generateAnimeSpecsMessage($sagasInfo);

    $message .= '[center][html]<img src="'. $seriesInfo['Img_staff']['href'] .'" alt="Staff - '. $sagasInfo['name'] .'" title="Staff - '. $sagasInfo['name'] .'" />[/html][/center]' . $nl;
    $message .= "[center][font=trebuchet ms][size=11pt][b]" . (empty($sagasInfo['staff']) ? $seriesInfo['staff'] : $sagasInfo['staff']) . "[/b][/size][/font][/center]" . $nl . $nl;

    return $message;
}

function generateDownloadsForSaga($sagasInfo) {
    global $txt;
    $nl = "<br />";

    $message = "";

    if ($sagasInfo['licensed']) {
        $message .= $nl . $nl . "[center][font=trebuchet ms][size=11pt][b]" . $txt['an-seriesDownloads'] . "[/b][/size][/font][/center]" . $nl;
        $message .= "[center]" . $txt['an-SagasLicensedText'] . "[/center]" . $nl;
    } else {
        //TODO: Protect Links


        $chaptersInfo = getAnimeChaptersInfo(null, $sagasInfo['id'], null, false);
        if (sizeof($chaptersInfo) > 0) {

            //$message .= $nl . $nl . "[center][font=trebuchet ms][size=11pt][b]" . $txt['an-seriesDownloads'] . "[/b][/size][/font]" . $nl;

            $message .= "[center][table]" . $nl;
            foreach ($chaptersInfo as $chap) {
                if (!empty($chap['id_download'])) {
                    $message .= "[tr][td][font=trebuchet ms][size=10pt][b]" . $chap['number'] . (!empty($chap['double']) ? "~" . ($chap['number'] + 1) : '' ) . " - " . $chap['title'] . "  [/b][/size][/font][/td]";

                    foreach ($chap['links']['public'] as $l) {
                        if (empty($l['href'])) {
                            $message .= '[td][/td]';
                        } else {
                            $message .= '[td][html]<a href="'. $l['href'] .'"><img src="' . $l['logo'] . '" alt="'. $l['name'] .'" title="'. $l['name'] .'" width=25 /></a>[/html][/td]';
                        }
                    }

                    $message .= "[/tr]" . $nl;
                }
            }
            $message .= "[/table][/center]" . $nl . $nl;
        }
    }

    return $message;
}

function generateAnimeSpecsMessage($sagasInfo = null) {
    global $txt;

    $count = 0;

    $message = "";

    $message .= "[center][table]";
    if(!empty($sagasInfo['specs'])) {
    foreach ($sagasInfo['specs'] as $spec) {
        $specsInfo = getAnimeSpecsInfo($spec);
        $specsInfo = $specsInfo[0];

        if($count == 0) {
            $message .= '[tr]';
        }
        $message .= '[td][html]<img src="'.$specsInfo['picture']['href'].'" alt="'.$specsInfo['name'].'" title="'.$specsInfo['name'].'" />[/html][/td]';
        
        $count++;
        if($count == 4) {
            $message .= '[/tr]';
            $count = 0;
        }
    }
    if($count != 0) {
        $message .= '[/tr]';
    }
    }
    $message .= "[/table][/center]";

    return $message;

}

function createSagasMessage($seriesInfo, $sagasInfo) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $user_info;
    global $sourcedir;

    require_once($sourcedir . '/Subs-Post.php');

    if ($seriesInfo == null || $sagasInfo == null) {
        trigger_error('createSagasMessage(): One or more of the required options is not set', E_USER_ERROR);
    }

    if (empty($sagasInfo['picture']['href']))
        $sagasInfo['picture']['href'] = $sagasInfo['banner'];
    $message = generateSagasMessage($seriesInfo, $sagasInfo);

    $msgOptions = array(
        'id' => 0,
        'subject' => $seriesInfo['name'] . " - " . $sagasInfo['name'],
        'body' => $message,
        'icon' => 'xx',
        'smileys_enabled' => true,
        'attachments' => array(),
        'approved' => true,
    );
    $topicOptions = array(
        'id' => 0,
        'board' => $seriesInfo['id_board'],
        'poll' => 0,
        'lock_mode' => null,
        'sticky_mode' => 0,
        'mark_as_read' => true,
        'is_approved' => true,
    );
    $posterOptions = array(
        'id' => $user_info['id'],
        'name' => $user_info['name'],
        'email' => $user_info['email'],
        'update_post_count' => true,
    );

    createPost($msgOptions, $topicOptions, $posterOptions);

    return $topicOptions['id'];
}

function modifySagasMessage($seriesInfo, $sagasInfo) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $user_info;
    global $sourcedir;

    require_once($sourcedir . '/Subs-Post.php');

    if ($seriesInfo == null && $sagasInfo == null) {
        trigger_error('modifySagasMessage()1: One or more of the required options is not set', E_USER_ERROR);
    }

    if ($seriesInfo == null) {
        $aux = getAnimeSeriesInfo($sagasInfo['id_series']);
        $seriesInfo = $aux[0];
    }

    if ($seriesInfo == null || $sagasInfo == null) {
        trigger_error('modifySagasMessage()2: One or more of the required options is not set', E_USER_ERROR);
    }

    if (empty($sagasInfo['id_msg'])) {
        modifySeriesMessage($seriesInfo);
        return;
    }

    if (empty($sagasInfo['picture']['href'])) {
        if (!empty($sagasInfo['banner'])) {
            $sagasInfo['picture']['href'] = $sagasInfo['banner'];
        } else {
            $sagasInfo['picture']['href'] = "";
        }
    }
    $message = generateSagasMessage($seriesInfo, $sagasInfo);

    $messageId = getFirstMessage($sagasInfo['id_msg']);

    $msgOptions = array(
        'id' => $messageId,
        'subject' => $seriesInfo['name'] . " - " . $sagasInfo['name'],
        'body' => $message,
        'icon' => 'xx',
        'smileys_enabled' => true,
        'attachments' => array(),
        'approved' => true,
    );
    $topicOptions = array(
        'id' => $sagasInfo['id_msg'],
        'board' => $seriesInfo['id_board'],
        'poll' => 0,
        'lock_mode' => null,
        'sticky_mode' => 0,
        'mark_as_read' => true,
        'is_approved' => true,
    );
    $posterOptions = array(
        'id' => $user_info['id'],
        'name' => $user_info['name'],
        'email' => $user_info['email'],
        'update_post_count' => true,
    );

    modifyPost($msgOptions, $topicOptions, $posterOptions);

    return $topicOptions['id'];
}

function addSagas($sagasInfo = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt;

    if ($sagasInfo == null) {
        trigger_error('addSagas(): One or more of the required options is not set', E_USER_ERROR);
    }

    $p1 = array(
        'ID_SERIES' => 'int',
        'Name' => 'string',
        'Image' => 'string',
        'Abstract' => 'string',
        'Staff' => 'string',
        'Licensed' => 'int',
    );
    $p2 = array(
        'ID_SERIES' => $sagasInfo['id_series'],
        'Name' => $sagasInfo['name'],
        'Image' => $sagasInfo['banner'],
        'Abstract' => $sagasInfo['abstract'],
        'Staff' => $sagasInfo['staff'],
        'Licensed' => $sagasInfo['licensed'],
    );
    if ($sagasInfo['id_msg'] != null && $sagasInfo['id_msg'] != 0) {
        $p1['ID_MSG'] = 'int';
        $p2['ID_MSG'] = $sagasInfo['id_msg'];
    }


    //Insert into AnimeManager Database
    $smcFunc['db_insert']('normal', '{db_prefix}an_sagas',
            // Columns to insert.
            $p1,
            // Data to put in.
            $p2
            ,
            // We had better tell SMF about the key, even though I can't remember why? ;)
            array('ID_SAGA')
    );

    return $smcFunc['db_insert_id']('{db_prefix}an_sagas', 'ID_SAGA');

}

function modifySagas($sagasInfo = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt;

    if ($sagasInfo == null) {
        trigger_error('modifySagas(): One or more of the required options is not set', E_USER_ERROR);
    }

    $sagasfields = array();
    $sagasfields[] = "ID_SERIES = {int:id_series}";
    $sagasfields[] = "Name = {string:name}";
    $sagasfields[] = "Image = {string:image}";
    $sagasfields[] = "Abstract = {string:abstract}";
    $sagasfields[] = "Staff = {string:staff}";
    $sagasfields[] = "Licensed = {int:licensed}";

    if (empty($sagasInfo['banner']) && !empty($sagasInfo['picture']['href'])) {
        $sagasInfo['banner'] = $sagasInfo['picture']['href'];
    }

    $datos = array(
        'id_saga' => $sagasInfo['id'],
        'id_series' => $sagasInfo['id_series'],
        'name' => $sagasInfo['name'],
        'image' => $sagasInfo['banner'],
        'abstract' => $sagasInfo['abstract'],
        'staff' => $sagasInfo['staff'],
        'licensed' => $sagasInfo['licensed'],
    );

    if ($sagasInfo['id_msg'] == null || $sagasInfo['id_msg'] == 0) {
        $sagasfields[] = "ID_MSG = NULL";
    } else {
        $sagasfields[] = "ID_MSG = {int:Id_msg}";
        $datos['Id_msg'] = $sagasInfo['id_msg'];
    }

    //Insert into AnimeManager Database
    $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_sagas
                        SET ' . implode(', ', $sagasfields) . '
			WHERE ID_SAGA = {int:id_saga}',
            // Data to put in.
            $datos
    );
}

function getLinks($chapterId = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $boardurl;


    $request = $smcFunc['db_query']('', '
            SELECT *
            FROM {db_prefix}an_links ' . (!empty($chapterId) ? '
            WHERE ID_CHAPTER = {int:chapterId} ' : '') . '
            ORDER BY ID_PORTAL',
                    array(
                        'chapterId' => $chapterId,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['ID_LINK'],
            'id_portal' => $row['ID_PORTAL'],
            'id_chapter' => $row['ID_CHAPTER'],
            'link' => $row['Route'],
        );
    }

    $smcFunc['db_free_result']($request);

    return $return;
}

function getAnimeLinksInfo($categoryId = null, $chapterId = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $boardurl;

    if ($categoryId == null) {
        trigger_error('getAnimeLinksInfo(): One or more of the required options is not set', E_USER_ERROR);
    }

    $servers = getAnimeServersInfo();

    $myServers = array();
    $myServers['private'] = array();
    $myServers['public'] = array();

    foreach ($servers as $s) {
        if ($s['id_category'] == $categoryId) {
            $aux = ($s['private']) ? 'private' : 'public';
            $myServers[$aux][$s['name']] = array(
                'name' => $s['name'],
                'id_portal' => $s['id'],
                'id' => -1,
                'id_chapter' => -1,
                'href' => "",
                'logo' => $s['picture']['href'],
            );
        }
    }

    if (!empty($chapterId)) {
        $links = getLinks($chapterId);

        foreach ($links as $l) {
            $found = false;
            foreach ($myServers['private'] as $s) {
                if ($s['id_portal'] == $l['id_portal']) {
                    $myServers['private'][$s['name']]['href'] = $l['link'];
                    $myServers['private'][$s['name']]['id'] = $l['id'];
                    $myServers['private'][$s['name']]['id_chapter'] = $chapterId;
                    $found = true;
                    break;
                }
                $myServers['private'][$s['name']] = $s;
            }
            if ($found == false) {
                foreach ($myServers['public'] as $s) {
                    if ($s['id_portal'] == $l['id_portal']) {
                        $myServers['public'][$s['name']]['href'] = $l['link'];
                        $myServers['public'][$s['name']]['id'] = $l['id'];
                        $myServers['public'][$s['name']]['id_chapter'] = $chapterId;
                        $found = true;
                        break;
                    }
                }
            }
        }
    }

    return $myServers;
}

function getAnimeServersInfo($serverId = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $boardurl;


    $request = $smcFunc['db_query']('', '
            SELECT cat.name as CName, por.ID_PORTAL, por.Name, por.Logo, por.Protected, por.ID_CATEGORY, por.Private
            FROM {db_prefix}an_portal por, {db_prefix}sp_categories cat
            WHERE por.ID_CATEGORY = cat.id_category ' . (!empty($serverId) ? 'AND por.ID_PORTAL = {int:portalId} ' : '') . '
            ORDER BY por.ID_CATEGORY,por.ID_PORTAL',
                    array(
                        'portalId' => $serverId,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['ID_PORTAL'],
            'name' => $row['Name'],
            'picture' => array(
                'href' => $row['Logo'],
                'image' => '<img src="' . $row['Logo'] . '" alt="' . $row['Name'] . '" width="20" />',
            ),
            'protected' => $row['Protected'],
            'categoryName' => $row['CName'],
            'id_category' => $row['ID_CATEGORY'],
            'private' => $row['Private'],
        );
    }

    $smcFunc['db_free_result']($request);

    return $return;
}

function addServer($serverInfo = null) {
    global $smcFunc;

    if (empty($serverInfo)) {
        trigger_error('addServer(): One or more of the required options is not set', E_USER_ERROR);
    }

    $smcFunc['db_insert']('normal', '{db_prefix}an_portal',
            array(
                'Name' => 'string',
                'Logo' => 'string',
                'Protected' => 'int',
                'ID_CATEGORY' => 'int',
                'Private' => 'int',
            ),
            array(
                'Name' => $serverInfo['name'],
                'Logo' => $serverInfo['banner'],
                'Protected' => $serverInfo['protected'],
                'ID_CATEGORY' => $serverInfo['id_category'],
                'Private' => $serverInfo['private'],
            ),
            array('ID_PORTAL')
    );
}

function modifyServer($serverInfo = null) {
    global $smcFunc;

    if (empty($serverInfo)) {
        trigger_error('modifyServer(): One or more of the required options is not set', E_USER_ERROR);
    }

    $serversfields = array();
    $serversfields[] = "Name = {string:name}";
    $serversfields[] = "Logo = {string:logo}";
    $serversfields[] = "Protected = {int:protected}";
    $serversfields[] = "ID_CATEGORY = {int:category}";
    $serversfields[] = "Private = {int:private}";

    $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_portal
                        SET ' . implode(', ', $serversfields) . '
			WHERE ID_PORTAL = {int:id_portal}',
            // Data to put in.
            array(
                'id_portal' => $serverInfo['id'],
                'name' => $serverInfo['name'],
                'logo' => $serverInfo['banner'],
                'protected' => $serverInfo['protected'],
                'category' => $serverInfo['id_category'],
                'private' => $serverInfo['private'],
            )
    );
}

function updateAllSagas() {
    $sagasInfo = getAnimeSagasInfo(null,null,false);

    foreach ($sagasInfo as $saga) {
        if (!empty($saga['id_msg']) && $saga['id_msg'] != null && $saga['id_msg'] != 0) {
           // trigger_error("Saga = ".$saga['id'].", ID_MSG = ".$saga['id_msg']);
            modifySagasMessage(null, $saga);
        }
    }
}

function getAnimeUnpublishedChaptersInfo($sagaId = null, $downloadId = null, $limit = true) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $boardurl, $start;//$start para la paginación
    
    if(empty($context['start'])){$context['start'] = 0;}

    $request = $smcFunc['db_query']('', '
            SELECT c.ID_CHAPTER, c.ID_DOWNLOAD, se.Name as Serie, se.ID_SERIES as id_serie, sa.Name as Saga, sa.ID_SAGA as id_saga, c.Number, c.Title, cat.Name as Category, se.ID_CATEGORY as id_category, c.ID_MSG, se.ID_Private_Board as board, c.Double
            FROM {db_prefix}an_chapter c, {db_prefix}an_series se, {db_prefix}an_sagas sa, {db_prefix}sp_categories cat
            WHERE ((c.ID_DOWNLOAD IS NULL ' . (!empty($sagaId) ? 'AND c.ID_SAGA = {int:saga} )' : ')') . (!empty($downloadId) ? ' OR c.ID_DOWNLOAD = {int:download} ' : '') . ') AND c.ID_SAGA = sa.ID_SAGA AND sa.ID_SERIES = se.ID_SERIES AND se.ID_CATEGORY = cat.id_category
            ORDER BY id_category,Serie,id_saga,c.Number 
            '. (($limit == true) ? 'LIMIT {int:start}, {int:limit}' : ''),
            //LIMIT para la paginación
                    array(
                        'download' => $downloadId,
                        'saga' => $sagaId,
                        //start y limit para el query que con cada página seleccione los datos
                        'start' => $context['start'],
                        'limit' => 20,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['ID_CHAPTER'],
            'serie' => $row['Serie'],
            'id_serie' => $row['id_serie'],
            'saga' => $row['Saga'],
            'id_saga' => $row['id_saga'],
            'number' => $row['Number'],
            'title' => $row['Title'],
            'category' => $row['Category'],
            'id_category' => $row['id_category'],
            'id_msg' => $row['ID_MSG'],
            'captures' => getAnimeCapturesForChapter($row['ID_CHAPTER']),
            'links' => getAnimeLinksInfo($row['id_category'], $row['ID_CHAPTER']),
            'id_board' => $row['board'],
            'topicurl' => ($scripturl.'?topic='.$row['ID_MSG'].'.0'),
            'id_download' => $row['ID_DOWNLOAD'],
            'double' => $row['Double'],
        );
    }

    $smcFunc['db_free_result']($request);


    return $return;
}

function getAnimeChaptersInfo($chapterId = null, $sagaId = null, $serieId = null, $limit = true) {
    global $scripturl, $context, $smcFunc;
    
    if(empty($context['start'])){$context['start'] = 0;}

    $request = $smcFunc['db_query']('', '
            SELECT c.ID_CHAPTER, c.ID_DOWNLOAD, se.Name as Serie, se.ID_SERIES as id_serie, sa.Name as Saga, sa.ID_SAGA as id_saga, c.Number, c.Title, cat.Name as Category, se.ID_CATEGORY as id_category, c.ID_MSG, se.ID_Private_Board as board, c.Double
            FROM {db_prefix}an_chapter c, {db_prefix}an_series se, {db_prefix}an_sagas sa, {db_prefix}sp_categories cat
            WHERE ' . (!empty($chapterId) ? 'c.ID_CHAPTER = {int:chapterId} AND ' : '') . (!empty($sagaId) ? 'c.ID_SAGA = {int:sagaId} AND ' : '') . 'c.ID_SAGA = sa.ID_SAGA AND ' . (!empty($serieId) ? 'sa.ID_SERIES = {int:serieId} AND ' : '') . 'sa.ID_SERIES = se.ID_SERIES AND se.ID_CATEGORY = cat.id_category
            ORDER BY id_category,Serie,id_saga,c.Number
            '.(($limit == true) ? 'LIMIT {int:start}, {int:limit}': ''),
                    array(
                        'chapterId' => $chapterId,
                        'sagaId' => $sagaId,
                        'serieId' => $serieId,
                        'start' => $context['start'],
                        'limit' => 20,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['ID_CHAPTER'],
            'serie' => $row['Serie'],
            'id_serie' => $row['id_serie'],
            'saga' => $row['Saga'],
            'id_saga' => $row['id_saga'],
            'number' => $row['Number'],
            'title' => $row['Title'],
            'category' => $row['Category'],
            'id_category' => $row['id_category'],
            'id_msg' => $row['ID_MSG'],
            'captures' => getAnimeCapturesForChapter($row['ID_CHAPTER']),
            'links' => getAnimeLinksInfo($row['id_category'], $row['ID_CHAPTER']),
            'id_board' => $row['board'],
            'topicurl' => ($scripturl.'?topic='.$row['ID_MSG'].'.0'),
            'id_download' => $row['ID_DOWNLOAD'],
            'double' => $row['Double'],
        );
    }

    $smcFunc['db_free_result']($request);


    return $return;
}

function modifyChapterLinks($chapterInfo = null, $links = null, $section = null) {
    if (empty($chapterInfo) || empty($links) || empty($section)) {
        trigger_error('addLinks(): One or more of the required options is not set', E_USER_ERROR);
    }

    foreach ($chapterInfo['links'][$section] as $serv) {
        $chapterInfo['links'][$section][$serv['name']]['href'] = $links[$serv['name']];
        $chapterInfo['links'][$section][$serv['name']]['id_chapter'] = $chapterInfo['id'];
        if ($chapterInfo['links'][$section][$serv['name']]['id'] == -1) {
            if (!empty($chapterInfo['links'][$section][$serv['name']]['href'])) {
                $chapterInfo['links'][$section][$serv['name']] = addLink($chapterInfo['links'][$section][$serv['name']]);
            }
        } else {
            modifyLink($chapterInfo['links'][$section][$serv['name']]);
        }
    }

    return $chapterInfo;
}

function getAnimeCapturesForChapter($chapterId = null) {
    global $smcFunc;

    if (empty($chapterId)) {
        trigger_error('getAnimeCapturesForChapter(): One or more of the required options is not set', E_USER_ERROR);
    }

    $request = $smcFunc['db_query']('', '
        SELECT *
        FROM {db_prefix}an_capture
        WHERE ID_CHAPTER = {int:chapterId}
        ORDER BY ID_CAPTURE',
                    array(
                        'chapterId' => $chapterId,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['ID_CAPTURE'],
            'id_chapter' => $chapterId,
            'href' => $row['Route'],
            'image' => '<img src="' . $row['Route'] . '" alt="' . $row['ID_CAPTURE'] . '" width="100" />',
        );
    }

    $smcFunc['db_free_result']($request);

    return $return;
}

function updateAllChaptersMessages() {
    $chaptersInfo = getAnimeChaptersInfo();

    foreach ($chaptersInfo as $c) {
        modifyChapterMessage($c);
    }
}

function findBoard($id_board) {
    global $smcFunc;

    $request = $smcFunc['db_query']('', '
            SELECT *
            FROM {db_prefix}boards
            WHERE id_board = {int:id_board}',
                    array(
                        'id_board' => $id_board,
                    )
    );

    $row = $smcFunc['db_fetch_assoc']($request);

    $smcFunc['db_free_result']($request);

    if (empty($row['id_board'])) {
        return false;
    }

    return true;

}

function findMessage($id_msg) {
    global $smcFunc;

    $request = $smcFunc['db_query']('', '
            SELECT *
            FROM {db_prefix}topics
            WHERE id_topic = {int:id_msg}',
                    array(
                        'id_msg' => $id_msg,
                    )
    );

    $row = $smcFunc['db_fetch_assoc']($request);

    $smcFunc['db_free_result']($request);

    if (empty($row['id_topic'])) {
        return false;
    }

    return true;
}

function findOrphanNews() {
    $newsInfo = getAnimeNewsInfo();

    $result = array();
    foreach($newsInfo as $new) {
        if(empty($new['id_msg']) || !findMessage($new['id_msg'])) {
            $result[] = $new;
        }
    }

    return $result;
}

function findOrphanSagas() {
    $sagasInfo = getAnimeSagasInfo();

    $result = array();
    foreach($sagasInfo as $saga) {
        $serieInfo = getAnimeSeriesInfo($saga['id_series']);
        if($serieInfo[0]['sagas'] > 1) {
            if(empty($saga['id_msg']) || !findMessage($saga['id_msg'])) {
                $result[] = $saga;
            }
        }else{
            if(!empty($saga['id_msg'])) {
                $result[] = $saga;
            }
        }
    }
    return $result;
}

function findOrphanSeries() {
    $seriesInfo = getAnimeSeriesInfo();

    $result = array();
    foreach ($seriesInfo as $serie) {
        if (empty($serie['id_msg']) || !findMessage($serie['id_msg'])) {
            $result[] = $serie;
        }
        //TODO Find if a Series has all it's boards
    }
    return $result;
}

function findOrphanChapters() {
    $chaptersInfo = getAnimeChaptersInfo();

    $result = array();
    foreach($chaptersInfo as $c) {
        if(empty($c['id_msg']) || !findMessage($c['id_msg'])) {
            $result[] = $c;
        }
    }

    return $result;
}

function addChapter($chapterInfo = null) {
    global $smcFunc;

    if (empty($chapterInfo)) {
        trigger_error('addChapter(): One or more of the required options is not set', E_USER_ERROR);
    }

    $smcFunc['db_insert']('normal', '{db_prefix}an_chapter',
            array(
                'ID_SAGA' => 'int',
                'Title' => 'string',
                'Number' => 'int',
            ),
            array(
                'ID_SAGA' => $chapterInfo['id_saga'],
                'Title' => $chapterInfo['title'],
                'Number' => $chapterInfo['number'],
            ),
            array('ID_CHAPTER')
    );

    return $smcFunc['db_insert_id']('{db_prefix}an_chapter', 'ID_CHAPTER');
}

function modifyChapter($chapterInfo = null) {
    global $smcFunc;

    if (empty($chapterInfo)) {
        trigger_error('modifyChapter(): One or more of the required options is not set', E_USER_ERROR);
    }

    $chapterfields = array();
    $chapterfields[] = "ID_SAGA = {string:saga}";
    $chapterfields[] = "Title = {string:title}";
    $chapterfields[] = "Number = {int:number}";
    $chapterfields[] = "ID_MSG = {int:message}";
    $chapterfields[] = "`Double` = {int:double}";

    if (!empty($chapterInfo['id_download']) && $chapterInfo['id_download'] != 'NULL') {
        $chapterfields[] = "ID_DOWNLOAD = {int:download}";
    } else {
        $chapterInfo['id_download'] = null;
        $chapterfields[] = "ID_DOWNLOAD = NULL";
    }

    $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_chapter
                        SET ' . implode(', ', $chapterfields) . '
			WHERE ID_CHAPTER = {int:id}',
            // Data to put in.
            array(
                'id' => $chapterInfo['id'],
                'title' => $chapterInfo['title'],
                'number' => $chapterInfo['number'],
                'message' => $chapterInfo['id_msg'],
                'saga' => $chapterInfo['id_saga'],
                'double' => $chapterInfo['double'],
                'download' => $chapterInfo['id_download'],
            )
    );
}

function generateChapterMessage($chapterInfo = null) {
    global $txt, $boarddir, $scripturl;

    $nl = "<br />";

    $message = "";
    $message .= "[center][size=14pt][u][b]" . $txt['an-adminChapterTextNumber'] . $chapterInfo['number'] . (!empty($chapterInfo['double']) ? "~" . ($chapterInfo['number'] + 1) : '' ) . " - " . $chapterInfo['title'] . "[/b][/u][/size][/center]" . $nl;
    $message .= "[center][size=12pt][u][b]" . $chapterInfo['saga'] . "[/b][/u][/size][/center]" . $nl . $nl;

    $message .= "[size=12pt][u][b]" . $txt['an-adminChapterCaptures'] . "[/b][/u][/size]" . $nl;
    foreach ($chapterInfo['captures'] as $capt) {
        //$message .= "[img]" . $capt['href'] . "[/img]";
        $message .= "[url=" . $capt['href'] . "]" . $capt['image'] . "[/url] ";
    }
    $message .= $nl . $nl;

    $message .= "[size=12pt][u][b]" . $txt['an-adminChaptersPrivateLinks'] . "[/b][/u][/size]" . $nl;
    foreach ($chapterInfo['links']['private'] as $l) {
        if (!empty($l['href'])) {
            $message .= "[img]" . $l['logo'] . "[/img] - [url=" . $l['href'] . "]" . $l['name'] . "[/url]" . $nl;
        }
    }

    $message .= "[size=12pt][u][b]" . $txt['an-adminChaptersPublicLinks'] . "[/b][/u][/size]" . $nl;
    foreach ($chapterInfo['links']['public'] as $l) {
        if (!empty($l['href'])) {
            $message .= "[img]" . $l['logo'] . "[/img] - [url=" . $l['href'] . "]" . $l['name'] . "[/url]" . $nl;
        }
    }

    $message .= '[center][url='.$scripturl.'?action=admin;area=an-chapters;sa=editChapters;chapter_id='.$chapterInfo['id'].';edit_chapter=1]'.$txt['an-adminEditChapters'].'[/url][/center]';
    return $message;
}

function addChapterMessage($chapterInfo = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $user_info;
    global $sourcedir;

    require_once($sourcedir . '/Subs-Post.php');

    if (empty($chapterInfo)) {
        trigger_error('addChapterMessage(): One or more of the required options is not set', E_USER_ERROR);
    }

    $message = generateChapterMessage($chapterInfo);

    $msgOptions = array(
        'id' => 0,
        'subject' => $chapterInfo['number'] . (!empty($chapterInfo['double']) ? "~" . ($chapterInfo['number'] + 1) : '' ) . " - " . $chapterInfo['title'],
        'body' => $message,
        'icon' => 'xx',
        'smileys_enabled' => true,
        'attachments' => array(),
        'approved' => true,
    );
    $topicOptions = array(
        'id' => 0,
        'board' => $chapterInfo['id_board'],
        'poll' => 0,
        'lock_mode' => null,
        'sticky_mode' => 0,
        'mark_as_read' => true,
        'is_approved' => true,
    );
    $posterOptions = array(
        'id' => $user_info['id'],
        'name' => $user_info['name'],
        'email' => $user_info['email'],
        'update_post_count' => true,
    );

    createPost($msgOptions, $topicOptions, $posterOptions);

    return $topicOptions['id'];
}

function modifyChapterMessage($chapterInfo = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $user_info;
    global $sourcedir;

    require_once($sourcedir . '/Subs-Post.php');

    if (empty($chapterInfo) || empty($chapterInfo['id_msg'])) {
        trigger_error('modifyChapterMessage(): One or more of the required options is not set', E_USER_ERROR);
        die($chapterInfo['id'] . " " . $chapterInfo['id_msg']);
    }

    $message = generateChapterMessage($chapterInfo);

    $msgOptions = array(
        'id' => getFirstMessage($chapterInfo['id_msg']),
        'subject' => $chapterInfo['number'] . (!empty($chapterInfo['double']) ? "~" . ($chapterInfo['number'] + 1) : '' ) . " - " . $chapterInfo['title'],
        'body' => $message,
        'icon' => 'xx',
        'smileys_enabled' => true,
        'attachments' => array(),
        'approved' => true,
    );
    $topicOptions = array(
        'id' => 0,
        'board' => $chapterInfo['id_board'],
        'poll' => 0,
        'lock_mode' => null,
        'sticky_mode' => 0,
        'mark_as_read' => true,
        'is_approved' => true,
    );
    $posterOptions = array(
        'id' => $user_info['id'],
        'name' => $user_info['name'],
        'email' => $user_info['email'],
        'update_post_count' => true,
    );

    modifyPost($msgOptions, $topicOptions, $posterOptions);

    return $topicOptions['id'];
}

function modifyChapterCaptures($chapterInfo = null, $captures = null) {
    if (empty($chapterInfo) || empty($captures)) {
        trigger_error('modifyCaptures(): One or more of the required options is not set', E_USER_ERROR);
    }

    if (empty($chapterInfo['captures'])) {
        $chapterInfo['captures'] = array();
    }

    $i = 0;
    if (sizeof($captures) < sizeof($chapterInfo['captures'])) {
        foreach ($chapterInfo['captures'] as $capt) {
            $capt[$i]['href'] = (empty($captures[$i]) ? '' : $captures[$i]);
            $capt[$i]['image'] = (empty($captures[$i]) ? '' : '<img src="' . $captures[$i] . '" alt="' . $capt[$i]['id'] . '" width="100" />');
            modifyCapture($capt);
            $i++;
        }
    } else {
        foreach ($captures as $capt) {
            if (empty($chapterInfo['captures'][$i])) {
                if (!empty($capt)) {
                    $chapterInfo['captures'][$i] = addCapture($chapterInfo, $capt);
                    $chapterInfo['captures'][$i]['image'] = (empty($captures[$i]) ? '' : '<img src="' . $captures[$i] . '" alt="' . $chapterInfo['title'] . '" width="100" />');
                }
            } else {
                $chapterInfo['captures'][$i]['href'] = $capt;
                $chapterInfo['captures'][$i]['image'] = (empty($captures[$i]) ? '' : '<img src="' . $captures[$i] . '" alt="' . $chapterInfo['title'] . '" width="100" />');
                modifyCapture($chapterInfo['captures'][$i]);
            }
            $i++;
        }
    }

    return $chapterInfo;
}

function addCapture($chapterInfo = null, $href = null) {
    global $smcFunc;

    if (empty($chapterInfo) || empty($href) || empty($chapterInfo['id'])) {
        trigger_error('addCapture(): One or more of the required options is not set', E_USER_ERROR);
    }

    $capture = array(
        'id' => 0,
        'id_chapter' => $chapterInfo['id'],
        'href' => $href,
    );

    $smcFunc['db_insert']('normal', '{db_prefix}an_capture',
            array(
                'ID_CHAPTER' => 'int',
                'Route' => 'string',
            ),
            array(
                'ID_CHAPTER' => $capture['id_chapter'],
                'Route' => $capture['href'],
            ),
            array('ID_CAPTURE')
    );

    $capture['id'] = $smcFunc['db_insert_id']('{db_prefix}an_capture', 'ID_CAPTURE');

    return $capture;
}

function modifyCapture($capture = null) {
    global $smcFunc;

    if (empty($capture)) {
        trigger_error('modifyCapture(): One or more of the required options is not set', E_USER_ERROR);
    }

    if (!empty($capture['href'])) {
        $capturefields = array();
        $capturefields[] = "ID_CHAPTER = {int:id_chapter}";
        $capturefields[] = "Route = {string:href}";

        $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_capture
                        SET ' . implode(', ', $capturefields) . '
			WHERE ID_CAPTURE = {int:id}',
                // Data to put in.
                array(
                    'id' => $capture['id'],
                    'id_chapter' => $capture['id_chapter'],
                    'href' => $capture['href'],
                )
        );
    } else {
        $smcFunc['db_query']('', '
            DELETE FROM {db_prefix}an_capture
            WHERE ID_CAPTURE = {int:id}',
                array(
                    'id' => $capture['id'],
                )
        );
    }
}

function addLink($linkInfo = null) {
    global $smcFunc;

    if (empty($linkInfo)) {
        trigger_error('addLink(): One or more of the required options is not set', E_USER_ERROR);
    }

    $smcFunc['db_insert']('normal', '{db_prefix}an_links',
            array(
                'ID_CHAPTER' => 'int',
                'ID_PORTAL' => 'int',
                'Route' => 'string',
            ),
            array(
                'ID_CHAPTER' => $linkInfo['id_chapter'],
                'ID_PORTAL' => $linkInfo['id_portal'],
                'Route' => $linkInfo['href'],
            ),
            array('ID_LINK')
    );

    $linkInfo['id'] = $smcFunc['db_insert_id']('{db_prefix}an_links', 'ID_LINK');

    return $linkInfo;
}

function modifyLink($linkInfo = null) {
    global $smcFunc;

    if (empty($linkInfo)) {
        trigger_error('modifyLink(): One or more of the required options is not set', E_USER_ERROR);
    }

    if (!empty($linkInfo['href'])) {
        $linkfields = array();
        $linkfields[] = "ID_CHAPTER = {int:id_chapter}";
        $linkfields[] = "ID_PORTAL = {int:id_portal}";
        $linkfields[] = "Route = {string:href}";

        $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_links
                        SET ' . implode(', ', $linkfields) . '
			WHERE ID_LINK = {int:id}',
                // Data to put in.
                array(
                    'id' => $linkInfo['id'],
                    'id_chapter' => $linkInfo['id_chapter'],
                    'id_portal' => $linkInfo['id_portal'],
                    'href' => $linkInfo['href'],
                )
        );
    } else {
        $smcFunc['db_query']('', '
            DELETE FROM {db_prefix}an_links
            WHERE ID_LINK = {int:id}',
                array(
                    'id' => $linkInfo['id'],
                )
        );
    }
}

function getAnimeNewsInfo($newsId = null, $limit = true) {
    global $context, $smcFunc;
    
    if(empty($context['start'])){$context['start'] = 0;}
    if(empty($context['limitNews'])){$context['limitNews'] = 20;}

    $request = $smcFunc['db_query']('', '
            SELECT n.ID_DOWNLOAD, se.Name as Serie, se.ID_SERIES as id_serie, sa.Name as Saga, sa.ID_SAGA as id_saga, cat.Name as Category, se.ID_CATEGORY as id_category, n.ID_MSG, se.ID_Private_Board as board, n.NEWS_TEXT
            FROM {db_prefix}an_download n, {db_prefix}an_series se, {db_prefix}an_sagas sa, {db_prefix}sp_categories cat
            WHERE ' . (!empty($newsId) ? 'n.ID_DOWNLOAD = {int:newsId} AND ' : '') . 'n.ID_SAGA = sa.ID_SAGA AND sa.ID_SERIES = se.ID_SERIES AND se.ID_CATEGORY = cat.id_category
            ORDER BY id_category,Serie,id_saga,n.ID_DOWNLOAD
            '.(($limit == true)?'LIMIT {int:start}, {int:limit}':''),
                    array(
                        'newsId' => $newsId,
                        'start' => $context['start'],
                        'limit' => $context['limitNews'],
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['ID_DOWNLOAD'],
            'serie' => $row['Serie'],
            'id_serie' => $row['id_serie'],
            'saga' => $row['Saga'],
            'id_saga' => $row['id_saga'],
            'category' => $row['Category'],
            'id_category' => $row['id_category'],
            'id_msg' => $row['ID_MSG'],
            'id_board' => $row['board'],
            'text' => $row['NEWS_TEXT'],
            'chapters' => getAnimeChaptersForNews($row['ID_DOWNLOAD']),
        );
    }

    $smcFunc['db_free_result']($request);


    return $return;
}

function getAnimeNewsInfoLimit($newsId = null) {
    global $smcFunc;

    $request = $smcFunc['db_query']('', '
            SELECT n.ID_DOWNLOAD, se.Name as Serie, se.ID_SERIES as id_serie, sa.Name as Saga, sa.ID_SAGA as id_saga, cat.Name as Category, se.ID_CATEGORY as id_category, n.ID_MSG, se.ID_Private_Board as board, n.NEWS_TEXT
            FROM {db_prefix}an_download n, {db_prefix}an_series se, {db_prefix}an_sagas sa, {db_prefix}sp_categories cat
            WHERE ' . (!empty($newsId) ? 'n.ID_DOWNLOAD = {int:newsId} AND ' : '') . 'n.ID_SAGA = sa.ID_SAGA AND sa.ID_SERIES = se.ID_SERIES AND se.ID_CATEGORY = cat.id_category
            ORDER BY n.ID_DOWNLOAD desc LIMIT 0, 30',
                    array(
                        'newsId' => $newsId,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['ID_DOWNLOAD'],
            'serie' => $row['Serie'],
            'id_serie' => $row['id_serie'],
            'saga' => $row['Saga'],
            'id_saga' => $row['id_saga'],
            'category' => $row['Category'],
            'id_category' => $row['id_category'],
            'id_msg' => $row['ID_MSG'],
            'id_board' => $row['board'],
            'text' => $row['NEWS_TEXT'],
            'chapters' => getAnimeChaptersForNews($row['ID_DOWNLOAD']),
        );
    }

    $smcFunc['db_free_result']($request);


    return $return;
}

function getAnimeChaptersForNews($newsId = null) {
    global $scripturl, $context, $smcFunc, $settings, $txt, $boardurl;

    if (empty($newsId)) {
        trigger_error('getAnimeChaptersForNews(): One or more of the required options is not set', E_USER_ERROR);
    }

    $request = $smcFunc['db_query']('', '
            SELECT c.ID_CHAPTER, c.ID_DOWNLOAD, se.Name as Serie, se.ID_SERIES as id_serie, sa.Name as Saga, sa.ID_SAGA as id_saga, c.Number, c.Title, cat.Name as Category, se.ID_CATEGORY as id_category, c.ID_MSG, se.ID_Private_Board as board, c.Double
            FROM {db_prefix}an_chapter c, {db_prefix}an_series se, {db_prefix}an_sagas sa, {db_prefix}sp_categories cat
            WHERE c.ID_DOWNLOAD = {int:download} AND c.ID_SAGA = sa.ID_SAGA AND sa.ID_SERIES = se.ID_SERIES AND se.ID_CATEGORY = cat.id_category
            ORDER BY id_category,id_serie,id_saga,c.Number',
                    array(
                        'download' => $newsId,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['ID_CHAPTER'],
            'serie' => $row['Serie'],
            'id_serie' => $row['id_serie'],
            'saga' => $row['Saga'],
            'id_saga' => $row['id_saga'],
            'number' => $row['Number'],
            'title' => $row['Title'],
            'category' => $row['Category'],
            'id_category' => $row['id_category'],
            'id_msg' => $row['ID_MSG'],
            'captures' => getAnimeCapturesForChapter($row['ID_CHAPTER']),
            'links' => getAnimeLinksInfo($row['id_category'], $row['ID_CHAPTER']),
            'id_board' => $row['board'],
            'id_download' => $row['ID_DOWNLOAD'],
            'double' => $row['Double'],
        );
    }

    $smcFunc['db_free_result']($request);


    return $return;
}

function generateNewsSubject($newsInfo = null, $seriesInfo = null) {
    global $txt;

    $first = null;
    $last = null;

    foreach ($newsInfo['chapters'] as $chapt) {
        if ($first == null)
            $first = $chapt['number'];
        if (!empty($chapt['double'])) {
            $last = $chapt['number'] + 1;
        } else {
            $last = $chapt['number'];
        }
    }

    $subject = $seriesInfo['name'];

    if ($first == $last) {
        $subject .= $txt['an-adminNewsSubjectOne'] . $first;
    } else {
        $subject .= $txt['an-adminNewsSubjectVarious'] . $first . " ~ " . $last;
    }

    return $subject;
}

function generateAnimeGallery($images = null, $newsId = null) {
    $message = '[html]';

    if ($images != null && $newsId != null) {
        $message .= '<div id="myImageFlow' . $newsId . '" class="imageflow">';

        foreach ($images as $i) {
            $message .= '<img src="' . $i['image'] . '" longdesc="' . $i['image'] . '" alt="' . $i['title'] . '" />';
        }

        $message .= '</div>';
    }
    $message .= '[/html]';
    return $message;
}

function generateNewsMessage($newsInfo = null, $seriesInfo = null, $sagasInfo = null) {
    global $txt;

    $nl = "<br />";
    $message = "";

    $message .= '[center][url=' . $sagasInfo['boardLink'] . '][img]' . $seriesInfo['newsImg']['href'] . '[/img][/url]' . $nl . $nl;
//    $message .= '[size=14pt][b][u]' . $seriesInfo['name'] . '[/u][/b][/size]' . $nl;

    $captures = array();

    $message .= "[font=trebuchet ms]";
    foreach ($newsInfo['chapters'] as $chapt) {
        $auxChapter = $chapt['number'] . (!empty($chapt['double']) ? "~" . ($chapt['number'] + 1) : '') . " - " . $chapt['title'];
        $message .= '[size=11pt][b]' . $auxChapter . '[/b][/size]' . $nl;

        foreach ($chapt['captures'] as $img) {
            $captures[] = array(
                'title' => $auxChapter,
                'image' => $img['href'],
            );
        }
    }
    
    $newsInfo['text'] = str_replace("[spoiler]", "[/size][/font][spoiler][font=trebuchet ms][size=10pt]", $newsInfo['text']);
    $newsInfo['text'] = str_replace("[/spoiler]", "[/size][/font][/spoiler][font=trebuchet ms][size=10pt]", $newsInfo['text']);

    $message .= $nl .'[size=10pt]'. $newsInfo['text'] . '[/size][/font]'. $nl;

    $message .= generateAnimeGallery($captures, ($newsInfo['id'] % 10) + 1);

    $message .= $nl . $nl . '[center][html]<a href="' . $sagasInfo['boardLink'] . '"><button type="button" class="catbg" style="width:120px; height:30px; border-radius:7px">' . $txt['an-seriesDownloads'] . '</button></a>[/html][/center]' . $nl;

    
    return $message;
}

function createNewsMessage($newsInfo = null) {
    global $user_info;
    global $sourcedir;

    require_once($sourcedir . '/Subs-Post.php');

    if ($newsInfo == null) {
        trigger_error('createNewsMessage(): One or more of the required options is not set', E_USER_ERROR);
    }

    $sagasInfo = getAnimeSagasInfo($newsInfo['id_saga']);
    $sagasInfo = $sagasInfo[0];

    $seriesInfo = getAnimeSeriesInfo($sagasInfo['id_series']);
    $seriesInfo = $seriesInfo[0];

    $message = generateNewsMessage($newsInfo, $seriesInfo, $sagasInfo);

    $subject = generateNewsSubject($newsInfo, $seriesInfo);


    $msgOptions = array(
        'id' => 0,
        'subject' => $subject,
        'body' => $message,
        'icon' => 'xx',
        'smileys_enabled' => true,
        'attachments' => array(),
        'approved' => true,
    );
    $topicOptions = array(
        'id' => 0,
        'board' => $seriesInfo['id_board'],
        'poll' => 0,
        'lock_mode' => null,
        'sticky_mode' => 0,
        'mark_as_read' => true,
        'is_approved' => true,
    );
    $posterOptions = array(
        'id' => $user_info['id'],
        'name' => $user_info['name'],
        'email' => $user_info['email'],
        'update_post_count' => true,
    );

    createPost($msgOptions, $topicOptions, $posterOptions);

    return $topicOptions['id'];
}

function modifyNewsMessage($newsInfo = null) {
    global $user_info;
    global $sourcedir;

    require_once($sourcedir . '/Subs-Post.php');

    if ($newsInfo == null || empty($newsInfo['id_msg'])) {
        trigger_error('modifyNewsMessage(): One or more of the required options is not set', E_USER_ERROR);
    }

    $sagasInfo = getAnimeSagasInfo($newsInfo['id_saga']);
    $sagasInfo = $sagasInfo[0];

    $seriesInfo = getAnimeSeriesInfo($sagasInfo['id_series']);
    $seriesInfo = $seriesInfo[0];

    $message = generateNewsMessage($newsInfo, $seriesInfo, $sagasInfo);

    $subject = generateNewsSubject($newsInfo, $seriesInfo);

    //trigger_error("Intentando modificar ".$newsInfo['id_msg']);

    $msgOptions = array(
        'id' => getFirstMessage($newsInfo['id_msg']),
        'subject' => $subject,
        'body' => $message,
        'icon' => 'xx',
        'smileys_enabled' => true,
        'attachments' => array(),
        'approved' => true,
    );
    $topicOptions = array(
        'id' => $newsInfo['id_msg'],
        'board' => $seriesInfo['id_board'],
        'poll' => 0,
        'lock_mode' => null,
        'sticky_mode' => 0,
        'mark_as_read' => true,
        'is_approved' => true,
    );
    $posterOptions = array(
        'id' => $user_info['id'],
        'name' => $user_info['name'],
        'email' => $user_info['email'],
        'update_post_count' => true,
    );

    modifyPost($msgOptions, $topicOptions, $posterOptions);

    return $topicOptions['id'];
}

function getSelectedChapters($on = null, $downloadId = null) {

    if (empty($on)) {
        return array();
    }

    $allChapt = getAnimeUnpublishedChaptersInfo(null, $downloadId, false);

    $return = array();
    foreach ($allChapt as $chapt) {
        if (!empty($on[$chapt['id']])) {
            $return[] = $chapt;
        }
    }

    return $return;
}

function getLastNewsId() {
    global $smcFunc;
    
    return $smcFunc['db_insert_id']('{db_prefix}an_download', 'ID_DOWNLOAD');
}

function addNews($newsInfo = null) {
    global $smcFunc;

    if (empty($newsInfo)) {
        trigger_error('addNews(): One or more of the required options is not set', E_USER_ERROR);
    }

    $smcFunc['db_insert']('normal', '{db_prefix}an_download',
            array(
                'ID_SAGA' => 'int',
                'ID_MSG' => 'int',
                'NEWS_TEXT' => 'string',
            ),
            array(
                'ID_SAGA' => $newsInfo['id_saga'],
                'ID_MSG' => $newsInfo['id_msg'],
                'NEWS_TEXT' => $newsInfo['text'],
            ),
            array('ID_DOWNLOAD')
    );

    $newsInfo['id'] = getLastNewsId();
    
    if(empty($newsInfo['id'])) {
        $newsInfo['id'] = getLastNewsId();
        trigger_error('addNews(): NewsInfo - id empty New NewsInfo - id '. $newsInfo['id'], E_USER_ERROR);
    }

    return $newsInfo['id'];
}

function modifyNews($newsInfo = null) {
    global $smcFunc;

    if (empty($newsInfo)) {
        trigger_error('modifyNews(): One or more of the required options is not set', E_USER_ERROR);
    }

    $newsfields = array();
    $newsfields[] = "ID_SAGA = {int:id_saga}";
    $newsfields[] = "ID_MSG = {int:id_msg}";
    $newsfields[] = "NEWS_TEXT = {string:text}";

    $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_download
                        SET ' . implode(', ', $newsfields) . '
			WHERE ID_DOWNLOAD = {int:id}',
            // Data to put in.
            array(
                'id' => $newsInfo['id'],
                'id_saga' => $newsInfo['id_saga'],
                'id_msg' => $newsInfo['id_msg'],
                'text' => $newsInfo['text'],
            )
    );
}

function getBlockSeries($type = "finalized") {
    global $smcFunc;

    if ($type != "finalized" && $type != "process") {
        $type = "finalized";
    }

    $request = $smcFunc['db_query']('', '
		SELECT value
		FROM {db_prefix}an_settings
        WHERE variable = {string:variable}
		LIMIT 1',
                    array(
                        'variable' => "Block_" . $type,
                    )
    );

    $row = $smcFunc['db_fetch_assoc']($request);

    $smcFunc['db_free_result']($request);

    return $row['value'];
}

function setBlockSeries($type = "finalized", $message = null) {
    global $smcFunc;

    if ($message == null || ($type != "finalized" && $type != "process")) {
        return;
    }

    $newsfields = array();
    $newsfields[] = "value = {string:message}";

    $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_settings
                        SET ' . implode(', ', $newsfields) . '
                        WHERE variable = {string:variable}
			',
            // Data to put in.
            array(
                'variable' => "Block_" . $type,
                'message' => $message,
            )
    );
}

function generateBlockSeries($finalized = true) {
    $cuentaFila=0;
    $categories = getAnimeCategoryInfo();

    $nl = "<br />";
    $message = "<center><table border='0'><tr>";

    foreach ($categories as $cat) {
       // $message .= $cat['name'] . $nl;

        $series = getAnimeSeriesInfo(null, $cat['id']);

        foreach ($series as $ser) {
            if ($ser['finalized'] == $finalized && $ser['public'] == true) {
                if ($ser['chapters_total'] == 0 || $ser['chapters_total'] < $ser['chapters_made']) {
                    $ser['chapters_total'] = "??";
                }
                
                $seriesName = $ser['name'];
                if( strlen($seriesName) > 36) {
                    $seriesName = substr($seriesName, 0, 33).'...';
                }
                
                $message .= '<td><a href="' . $ser['boardLink'] . '"><font color="grey">'.$seriesName.'</font>'.$nl.'<img src="' . $ser['img_download_block']['href'] . '" alt="'.$ser['name'].'-'.$ser['chapters_made'].'/'.$ser['chapters_total'].'" title="'.$ser['name'].'-'.$ser['chapters_made'].'/'.$ser['chapters_total'].'"/></a></td>';
               // $message .= '<a href="' . $ser['boardLink'] . '">' . $ser['name'] . '</a> ' . $ser['chapters_made'] . '/' . $ser['chapters_total'] . $nl . $nl;
                $cuentaFila++;
                if ($cuentaFila >= 3) {
                    $cuentaFila=0;
                    $message .= '</tr><tr>';
                }
            }
        }
    }

    $message .= "</tr></table></center>";

    return $message;
}

function updateBlockSeries() {
    $msg = generateBlockSeries(true);
    setBlockSeries("finalized", $msg);
    $msg = generateBlockSeries(false);
    setBlockSeries("process", $msg);
}

function updateAllNews() {
    global $context;
    
    $context['start'] = 800;
    $context['limitNews'] = 400;
    $newsInfo = getAnimeNewsInfo();
    $context['start'] = 0;
    $context['modifiedNews'] = count($newsInfo) . " -- ";
    foreach ($newsInfo as $new) {
        $context['modifiedNews'] .= $new['id'].", ";
        modifyNewsMessage($new);
    }
}

function updateAllSeries() {
    $seriesInfo = getAnimeSeriesInfo();

    foreach ($seriesInfo as $ser) {
        modifySeriesMessage($ser);
    }
}

function deleteNewsArticle($newsInfo = null) {
    global $smcFunc, $sourcedir;

    if (empty($newsInfo)) {
        trigger_error('deleteNewsArticle(): news_info is empty');
    }

    require_once($sourcedir . '/Subs-PortalAdmin.php');

    //Get Article ID
    $request = $smcFunc['db_query']('', '
                    SELECT *
                    FROM {db_prefix}sp_articles
                    WHERE id_message = {int:id_msg}
                    ',
            array(
                'id_msg' => $newsInfo['id_msg'],
            ));

    $row = $smcFunc['db_fetch_assoc']($request);

    $smcFunc['db_free_result']($request);

    if(!empty($row['id_article'])) {
    // Life is short... Delete it.
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}sp_articles
		WHERE id_article = {int:id}',
		array(
			'id' => $row['id_article'],
		)
	);

	// Fix the article counts.
	fixCategoryArticles();
    }
}

function regenerateAnimeNews($newsInfo = null) {
    global $smcFunc, $sourcedir;

    require_once($sourcedir . '/RemoveTopic.php');

    if (empty($newsInfo)) {
        trigger_error('regenerateAnimeNews(): news_info is empty');
    }

    deleteNewsArticle($newsInfo);

    if(!empty($newsInfo['id_msg']) && findMessage($newsInfo['id_msg'])) {
        removeTopics($newsInfo['id_msg']);
    }

    $newsInfo['id_msg'] = createNewsMessage($newsInfo);

    foreach ($newsInfo['chapters'] as $chap) {
        $chap['id_download'] = $newsInfo['id'];
        modifyChapter($chap);
    }

    $sagasInfo = getAnimeSagasInfo($newsInfo['id_saga']);
    modifySagasMessage(null, $sagasInfo[0]);

    //Publish in portal
    $articleOptions = array(
        'id_category' => $newsInfo['chapters'][0]['id_category'],
        'id_message' => getFirstMessage($newsInfo['id_msg']),
        'approved' => 1,
    );

    createArticle($articleOptions);

    modifyNews($newsInfo);
    updateBlockSeries();
}

function deleteAnimeNews($newsInfo = null) {
    global $smcFunc, $sourcedir;

    require_once($sourcedir . '/RemoveTopic.php');

    if (empty($newsInfo)) {
        trigger_error('regenerateAnimeNews(): news_info is empty');
    }

    deleteNewsArticle($newsInfo);

    if(!empty($newsInfo['id_msg']) && findMessage($newsInfo['id_msg'])) {
        removeTopics($newsInfo['id_msg']);
    }

    foreach ($newsInfo['chapters'] as $chap) {
        $chap['id_download'] = null;
        modifyChapter($chap);
    }

    $sagasInfo = getAnimeSagasInfo($newsInfo['id_saga']);
    modifySagasMessage(null, $sagasInfo[0]);

    $smcFunc['db_query']('','
		DELETE FROM {db_prefix}an_download
		WHERE ID_DOWNLOAD = {int:id}',
		array(
			'id' => $newsInfo['id'],
		)
	);

    updateBlockSeries();
}

function regenerateAnimeChapter($chapterInfo = null) {
    $chapterInfo['id_msg'] = addChapterMessage($chapterInfo);

    modifyChapter($chapterInfo);
}

function deleteCapture($capture = null) {
    global $smcFunc;

    if(empty($capture) || empty($capture['id'])) {
        trigger_error("Delete capture: capture is empty");
    }
    
    $smcFunc['db_query']('','
		DELETE FROM {db_prefix}an_capture
		WHERE ID_CAPTURE = {int:id}',
		array(
			'id' => $capture['id'],
		)
	);

}

function deleteChapterLinks($chaptid = null) {
    global $smcFunc;

    $chaptid = (int) $chaptid;
    
    if(empty($chaptid)) {
        trigger_error("Delete link: chapter id is empty");
    }

    $smcFunc['db_query']('','
		DELETE FROM {db_prefix}an_links
		WHERE ID_CHAPTER = {int:id}',
		array(
			'id' => $chaptid,
		)
	);

}

function deleteAnimeChapter($chapterInfo = null) {
    global $smcFunc, $sourcedir;

    require_once($sourcedir . '/RemoveTopic.php');

    foreach($chapterInfo['captures'] as $capt) {
        deleteCapture($capt);
    }
    
    deleteChapterLinks($chapterInfo['id']);

    if(!empty($chapterInfo['id_msg']) && findMessage($chapterInfo['id_msg']) ) {
        removeTopics($chapterInfo['id_msg']);
    }

    //Bye bye TT_TT
    $smcFunc['db_query']('','
		DELETE FROM {db_prefix}an_chapter
		WHERE ID_CHAPTER = {int:id}',
		array(
			'id' => $chapterInfo['id'],
		)
	);

    //Looking for news and ERASING THEM Mhajajaja!!!
    if (!empty($chapterInfo['id_download'])) {
        $newsInfo = getAnimeNewsInfo($chapterInfo['id_download']);
        if (empty($newsInfo['chapters'][0])) {
            deleteAnimeNews($newsInfo[0]);
        } else {
            $sagasInfo = getAnimeSagasInfo($chapterInfo['id_saga']);
            modifySagasMessage(null, $sagasInfo[0]);
            updateBlockSeries();
        }
    }
}

function regenerateAnimeSagas($sagasInfo = null) {

    if(empty($sagasInfo) || empty($sagasInfo['id'])) {
        trigger_error("regenerate anime sagas: Sagas info is not correct");
        return;
    }

    $seriesInfo = getAnimeSeriesInfo($sagasInfo['id_series']);
    $seriesInfo = $seriesInfo[0];

    if($seriesInfo['sagas'] > 1) {
        $sagasInfo['id_msg'] = createSagasMessage($seriesInfo, $sagasInfo);
        modifySagas($sagasInfo);
    }
}

function deleteAnimeSagas($sagasInfo = null) {
    global $smcFunc, $sourcedir;

    require_once($sourcedir . '/RemoveTopic.php');

    if(empty($sagasInfo) || empty($sagasInfo['id'])) {
        trigger_error("delete anime sagas: Sagas info is not correct");
        return;
    }

    $seriesInfo = getAnimeSeriesInfo($sagasInfo['id_series']);
    $seriesInfo = $seriesInfo[0];

    $chaptersInfo = getAnimeChaptersInfo(null, $sagasInfo['id'], null, false);

    foreach ($chaptersInfo as $chap) {
        deleteAnimeChapter($chap);
    }
    //trigger_error("Capitulos borrados");
    //We erase the topic only if we have to do it.
    //If we aren't alone and if wue have topic.
    if ($seriesInfo['sagas'] > 1) {
        if (!empty($sagasInfo['id_msg']) && findMessage($sagasInfo['id_msg'])) {
            removeTopics($sagasInfo['id_msg']);
        }
    }
    //trigger_error("Mensaje de saga mala borrado");
    //Good bye saga
    $smcFunc['db_query']('', '
            DELETE FROM {db_prefix}an_sagas
            WHERE ID_SAGA = {int:id}',
            array(
                'id' => $sagasInfo['id'],
            )
    );

    //trigger_error("Saga mala borrada");
    //If the series has only one saga left, we have to erase the topic
    $seriesInfo = getAnimeSeriesInfo($sagasInfo['id_series']);
    $seriesInfo = $seriesInfo[0];

    if ($seriesInfo['sagas'] == 1) {
        $leftSagaInfo = getAnimeSagasInfoForSeries($seriesInfo['id']);
        $leftSagaInfo = $leftSagaInfo[0];
        if (!empty($leftSagaInfo['id_msg']) && findMessage($leftSagaInfo['id_msg'])) {
            removeTopics($leftSagaInfo['id_msg']);
        }
        //trigger_error("Mensaje de saga unica borrado");
    }

    //Finally we have to update the series message
    modifySeriesMessage($seriesInfo);
    //trigger_error("Mensaje de serie cambiado");
}

function regenerateAnimeSeries($seriesInfo = null) {

    if (empty($seriesInfo) || empty($seriesInfo['id'])) {
        trigger_error("regenerate anime series: Series info is not correct");
        return;
    }

    $seriesInfo['id_msg'] = createSeriesMessage($seriesInfo);
    editSeries($seriesInfo);
}

function deleteAnimeSeries($seriesInfo = null) {
    global $smcFunc, $sourcedir;

    if (empty($seriesInfo) || empty($seriesInfo['id'])) {
        trigger_error("delete anime series: Series info is not correct");
        return;
    }

    require_once($sourcedir . '/Subs-Boards.php');

    $sagasInfo = getAnimeSagasInfoForSeries($seriesInfo['id']);

    foreach ($sagasInfo as $saga) {
        deleteAnimeSagas($saga);
    }
    trigger_error('delete Anime series: Sagas erased');

    $boards_to_remove = array();
    if (!empty($seriesInfo['id_board']) && findBoard($seriesInfo['id_board']))
        $boards_to_remove[] = $seriesInfo['id_board'];
    if (!empty($seriesInfo['id_board']) && findBoard($seriesInfo['id_board']))
        $boards_to_remove[] = $seriesInfo['id_private_board'];

    if (!empty($boards_to_remove))
        deleteBoards($boards_to_remove);

    //Finally we are deleting the series itself
    $smcFunc['db_query']('', '
            DELETE FROM {db_prefix}an_series
            WHERE ID_SERIES = {int:id}',
            array(
                'id' => $seriesInfo['id'],
            )
    );

    //Wow... ¿Are you proud? You've broken the dreams of millions of aliens in the outter space
    updateBlockSeries();
}

function getAnimeSpecsInfo($specs_id = null) {
    global $smcFunc;

    $request = $smcFunc['db_query']('', '
		SELECT *
		FROM {db_prefix}an_specs ' . (!empty($specs_id) ? '
		WHERE id_spec = {int:specs_id}' : '') . '
		ORDER BY id_spec',
                    array(
                        'specs_id' => $specs_id,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[] = array(
            'id' => $row['id_spec'],
            'name' => $row['name'],
            'picture' => array(
                'href' => $row['image'],
                'image' => '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" width="35" />'
            ),
        );
    }
    $smcFunc['db_free_result']($request);

    return $return;
}

function addAnimeSpecs($specsInfo = null) {
    global $smcFunc;

    if (empty($specsInfo) || empty($specsInfo['name'])) {
        trigger_error("addAnimeSpecs(): Error, specs info is incomplete.");
    } else {
        //TODO: Añadir especificaciones,
        $smcFunc['db_insert']('normal', '{db_prefix}an_specs',
                // Columns to insert.
                array(
                    'name' => 'string',
                    'image' => 'string',
                ),
                // Data to put in.
                array(
                    'name' => $specsInfo['name'],
                    'image' => $specsInfo['picture']['href'],
                ),
                // We had better tell SMF about the key, even though I can't remember why? ;)
                array('id_spec')
        );
    }
}

function modifyAnimeSpecs($specsInfo = null) {
    global $smcFunc;

    if (empty($specsInfo) || empty($specsInfo['name']) || empty($specsInfo['id'])) {
        trigger_error("modifyAnimeSpecs(): Error, specs info is incomplete.");
    } else {

        $specs_fields = array();
        $specs_fields[] = "name = {string:name}";
        $specs_fields[] = "image = {string:image}";


        $smcFunc['db_query']('', '
                        UPDATE {db_prefix}an_specs
                        SET ' . implode(', ', $specs_fields) . '
			WHERE id_spec = {int:id_specs}',
                // Data to put in.
                array(
                    'id_specs' => $specsInfo['id'],
                    'name' => $specsInfo['name'],
                    'image' => $specsInfo['picture']['href'],
                )
        );
    }
}

function getAnimeSpecsForSaga($saga_id = null) {
    global $smcFunc;


    $request = $smcFunc['db_query']('', '
		SELECT *
                FROM {db_prefix}an_sagas_specs
                WHERE id_saga = {int:saga_id}
		ORDER BY id_spec',
                    array(
                        'saga_id' => $saga_id,
                    )
    );

    $return = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $return[$row['id_spec']] = $row['id_spec'];
    }

    $smcFunc['db_free_result']($request);

    return $return;

}

function updateSpecsForSaga($specs = null, $saga_id = null) {
    global $smcFunc;

    if (empty($specs) || empty($saga_id)) {
        trigger_error("updateSpecsForSaga(): specs or sagaId empty.");
    } else {
        $smcFunc['db_query']('', '
            DELETE FROM {db_prefix}an_sagas_specs
            WHERE id_saga = {int:id}',
                array(
                    'id' => $saga_id,
                )
        );

        $AnimeSpecs = getAnimeSpecsInfo();

        foreach ($AnimeSpecs as $spec) {
            if (!empty($specs[$spec['id']])) {
                $smcFunc['db_insert']('normal', '{db_prefix}an_sagas_specs',
                        // Columns to insert.
                        array(
                            'id_saga' => 'int',
                            'id_spec' => 'int',
                        ),
                        // Data to put in.
                        array(
                            'id_saga' => $saga_id,
                            'id_spec' => $spec['id'],
                        ),
                        // We had better tell SMF about the key, even though I can't remember why? ;)
                        array('id_saga', 'id_spec')
                );
            }
        }
    }
}

?>
