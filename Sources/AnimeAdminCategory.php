<?php
/**********************************************************************************
* AnimeAdminCategory.php                                                          *
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

function anime_admin_category_main() {
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

    //TODO: Own Template
    //We load the template, using SimplePortal One...
    loadTemplate('AnimeAdminCategory');

    //List of all the possible actions
    $subActions = array(
                'listCategory' => 'anime_admin_category_list',
		'addCategory' => 'anime_admin_category_add',
		'editCategory' => 'anime_admin_category_edit',
                'deleteCategory' => 'anime_admin_category_delete',
    );

    //Check and get if we have the "sa" parameter (Default info)
    $_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'listCategory';

    //Title and all stuff
    $context[$context['admin_menu_name']]['tab_data'] = array(
        'title' => $txt['an-adminCategory'],
	'description' => $txt['an-adminCategoryDesc'],
    );

    //Call to the function we want
    $subActions[$_REQUEST['sa']]();
}

function anime_admin_category_add()
{
	global $txt, $smcFunc, $context, $func;

	// Not actually adding a category? Show the add category page.
	if(empty($_POST['edit_category']))
	{
		// Just we need the template.
		$context['sub_template'] = 'category_edit';
		$context['page_title'] = $txt['an-categoriesAdd'];
                $context['button_title'] = $txt['an-categoriesAddButton'];
		$context['category_action'] = 'addCategory';
	}
	// Adding a category? Lets do this thang! ;D
	else
	{
		// Session check.
		checkSession();

		// Category name can't be empty.
		if (empty($_POST['category_name']))
			fatal_lang_error('error_sp_name_empty', false);

		// A small info array.
		$categoryInfo = array(
			'name' => $smcFunc['htmlspecialchars']($_POST['category_name'], ENT_QUOTES),
			'picture' => $smcFunc['htmlspecialchars']($_POST['picture_url'], ENT_QUOTES),
		);

		// Insert the category data.
		$smcFunc['db_insert']('normal', '{db_prefix}sp_categories',
			// Columns to insert.
			array(
				'name' => 'string',
				'picture' => 'string',
				'articles' => 'int',
				'publish' => 'int'
			),
			// Data to put in.
			array(
				'name' => $categoryInfo['name'],
				'picture' => $categoryInfo['picture'],
				'articles' => 0,
				'publish' => 1
			),
			// We had better tell SMF about the key, even though I can't remember why? ;)
			array('id_category')
		);
                
                //We get the id of the category
                $mycontext['id_category_sp'] = $smcFunc['db_insert_id']('{db_prefix}sp_categories', 'id_category');
                $mycontext['order'] = getOrderCategory();

                $catOptions['cat_name'] = $categoryInfo['name'] . $txt['an-categoriesPrivateName'] . $txt['an-categoriesFinalizedName'];
                $catOptions['move_after'] = $mycontext['order']['id_category_private_finalized'];
                //Create a category for public forum using "Subs-Categories" functions
                $mycontext['id_category_private_finalized'] = createCategory($catOptions);


                $catOptions['cat_name'] = $categoryInfo['name'] . $txt['an-categoriesPrivateName'];
                $catOptions['move_after'] = $mycontext['order']['id_category_private'];
                //Create a category for private forum using "Subs-Categories" functions
                $mycontext['id_category_private'] = createCategory($catOptions);

                $catOptions['cat_name'] = $categoryInfo['name'] . $txt['an-categoriesFinalizedName'];
                $catOptions['move_after'] = $mycontext['order']['id_category_forums_finalized'];
                //Create a category for public forum using "Subs-Categories" functions
                $mycontext['id_category_forums_finalized'] = createCategory($catOptions);

                $catOptions['cat_name'] = $categoryInfo['name'];
                $catOptions['move_after'] = $mycontext['order']['id_category_forums'];
                //Create a category for public forum using "Subs-Categories" functions
                $mycontext['id_category_forums'] = createCategory($catOptions);

                //Insert into AnimeManager Database
                $smcFunc['db_insert']('normal', '{db_prefix}an_categories',
			// Columns to insert.
			array(
				'id_category_sp' => 'int',
				'id_category_forums' => 'int',
				'id_category_private' => 'int',
                                'id_category_forums_finalized' => 'int',
				'id_category_private_finalized' => 'int',
			),
			// Data to put in.
			array(
				'id_category_sp' => $mycontext['id_category_sp'],
				'id_category_forums' => $mycontext['id_category_forums'],
				'id_category_private' => $mycontext['id_category_private'],
                                'id_category_forums_finalized' => $mycontext['id_category_forums_finalized'],
				'id_category_private_finalized' => $mycontext['id_category_private_finalized'],
			),
			// We had better tell SMF about the key, even though I can't remember why? ;)
			array('id_category')
		);

		// Return back to the category list.
		redirectexit('action=admin;area=an-categories;sa=listCategory');
	}
}

function anime_admin_category_edit()
{

        global $txt, $smcFunc, $context, $func;

        if(empty($_POST['edit_category']))
	{
		// Be sure you made it an integer.
		$_REQUEST['category_id'] = (int) $_REQUEST['category_id'];

		// Show you ID.
		if(empty($_REQUEST['category_id']))
			fatal_lang_error('error_sp_id_empty', false);

		// Get the category info. You need in template.
		$context['category_info'] = getAnimeCategoryInfo($_REQUEST['category_id']);
		$context['category_info'] = $context['category_info'][0];

		// Call the right sub template.
		$context['sub_template'] = 'category_edit';
		$context['page_title'] = $txt['an-categoriesEdit'];
                $context['button_title'] = $txt['an-categoriesEditButton'];
		$context['category_action'] = 'editCategory';
	}
        else
        {
        	// Again.
		checkSession();

		// Why empty? :S
		if (empty($_POST['category_name']))
			fatal_lang_error('error_sp_name_empty', false);

		// Array for the db.
		$categoryInfo = array(
			'name' => $smcFunc['htmlspecialchars']($_POST['category_name'], ENT_QUOTES),
			'picture' => $smcFunc['htmlspecialchars']($_POST['picture_url'], ENT_QUOTES),
			'publish' => '1',
		);

		// What to change?
		$category_fields = array();
		$category_fields[] = "name = {string:name}";
		$category_fields[] = "picture = {string:picture}";
		$category_fields[] = "publish = {int:publish}";

		// Go on.
		$smcFunc['db_query']('','
			UPDATE {db_prefix}sp_categories
			SET ' . implode(', ', $category_fields) . '
			WHERE id_category = {int:id}',
			array(
				'id' => $_POST['category_id'],
				'name' => $categoryInfo['name'],
				'picture' => $categoryInfo['picture'],
				'publish' => $categoryInfo['publish'],
			)
		);

                //Modify the name of the  Forums Categories.
                $catOptions['cat_name'] = $categoryInfo['name'] . $txt['an-categoriesPrivateName'] . $txt['an-categoriesFinalizedName'];
                modifyCategory($_POST['id_category_private_finalized'], $catOptions);

                $catOptions['cat_name'] = $categoryInfo['name'] . $txt['an-categoriesPrivateName'];
                modifyCategory($_POST['id_category_private'], $catOptions);

                $catOptions['cat_name'] = $categoryInfo['name'] . $txt['an-categoriesFinalizedName'];
                modifyCategory($_POST['id_category_forums_finalized'], $catOptions);

                $catOptions['cat_name'] = $categoryInfo['name'];
                modifyCategory($_POST['id_category_forums'], $catOptions);
                

		// Take him back to the list.
		redirectexit('action=admin;area=an-categories;sa=listCategories');
        }
}

function anime_admin_category_delete() {
   //TODO: Delete a category of AnimeManager properly
}

function anime_admin_category_list()
{
	global $txt, $context;

	// Category list columns.
	$context['columns'] = array(
		'picture' => array(
			'width' => '35%',
			'label' => $txt['sp-adminColumnPicture'],
			'class' => 'first_th',
		),
		'name' => array(
			'width' => '45%',
			'label' => $txt['sp-adminColumnName'],
		),
		'articles' => array(
			'width' => '5%',
			'label' => $txt['sp-adminColumnArticles'],
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

	// Get all the categories.
	$context['categories'] = getAnimeCategoryInfo();

	// Call the sub template.
	$context['sub_template'] = 'category_list';
	$context['page_title'] = $txt['an-adminCategoryListName'];
}

?>
