<?php
/**********************************************************************************
* PortalAdminBlocks.php                                                           *
***********************************************************************************
* SimplePortal                                                                    *
* SMF Modification Project Founded by [SiNaN] (sinan@simplemachines.org)          *
* =============================================================================== *
* Software Version:           SimplePortal 2.3.2                                  *
* Software by:                SimplePortal Team (http://www.simpleportal.net)     *
* Copyright 2008-2009 by:     SimplePortal Team (http://www.simpleportal.net)     *
* Support, News, Updates at:  http://www.simpleportal.net                         *
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

/*
	void sportal_admin_blocks_main()
		// !!!

	void sportal_admin_block_list()
		// !!!

	void sportal_admin_block_edit()
		// !!!

	void sportal_admin_block_delete()
		// !!!

	void sportal_admin_block_move()
		// !!!

	void sportal_admin_state_state()
		// !!!

	void sportal_admin_column_change()
		// !!!
*/

function sportal_admin_blocks_main()
{
	global $context, $txt, $scripturl, $sourcedir;

	if (!allowedTo('sp_admin'))
		isAllowedTo('sp_manage_blocks');

	require_once($sourcedir . '/Subs-PortalAdmin.php');

	loadTemplate('PortalAdminBlocks');

	$subActions = array(
		'list' => 'sportal_admin_block_list',
		'left' => 'sportal_admin_block_list',
		'right' => 'sportal_admin_block_list',
		'top' => 'sportal_admin_block_list',
		'bottom' => 'sportal_admin_block_list',
		'add' => 'sportal_admin_block_edit',
		'edit' => 'sportal_admin_block_edit',
		'delete' => 'sportal_admin_block_delete',
		'move' => 'sportal_admin_block_move',
		'statechange' => 'sportal_admin_state_change',
		'columnchange' => 'sportal_admin_column_change',
	);

	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'list';

	$context['sub_action'] = $_REQUEST['sa'];

	$context[$context['admin_menu_name']]['tab_data'] = array(
		'title' => $txt['sp-blocksBlocks'],
		'help' => 'sp_BlocksArea',
		'description' => $txt['sp-adminBlockListDesc'],
		'tabs' => array(
			'list' => array(
				'description' => $txt['sp-adminBlockListDesc'],
			),
			'add' => array(
				'description' => $txt['sp-adminBlockAddDesc'],
			),
			'left' => array(
				'description' => $txt['sp-adminBlockLeftListDesc'],
			),
			'top' => array(
				'description' => $txt['sp-adminBlockTopListDesc'],
			),
			'bottom' => array(
				'description' => $txt['sp-adminBlockBottomListDesc'],
			),
			'right' => array(
				'description' => $txt['sp-adminBlockRightListDesc'],
			),
		),
	);

	$subActions[$_REQUEST['sa']]();
}

// Show the Block List.
function sportal_admin_block_list()
{
	global $txt, $context, $scripturl;

	// We have 4 sides...
	$context['sides'] = array(
		'left' => array(
			'id' => '1',
			'name' => 'adminLeft',
			'label' => $txt['sp-positionLeft'],
			'help' => 'sp-blocksLeftList',
		),
		'top' => array(
			'id' => '2',
			'name' => 'adminTop',
			'label' => $txt['sp-positionTop'],
			'help' => 'sp-blocksTopList',
		),
		'bottom' => array(
			'id' => '3',
			'name' => 'adminBottom',
			'label' => $txt['sp-positionBottom'],
			'help' => 'sp-blocksBottomList',
		),
		'right' => array(
			'id' => '4',
			'name' => 'adminRight',
			'label' => $txt['sp-positionRight'],
			'help' => 'sp-blocksRightList',
		),
	);

	$sides = array('left', 'top', 'bottom', 'right');
	// Are we viewing any of the sub lists for an individual side?
	if(in_array($context['sub_action'], $sides))
	{
		// Remove any sides that we don't need to show. ;)
		foreach($sides as $side)
		{
			if($context['sub_action'] != $side)
				unset($context['sides'][$side]);
		}
		$context['sp_blocks_single_side_list'] = true;
	}

	// Columns to show.
	$context['columns'] = array(
		'label' => array(
			'width' => '40%',
			'label' => $txt['sp-adminColumnName'],
			'class' => 'first_th',
		),
		'type' => array(
			'width' => '40%',
			'label' => $txt['sp-adminColumnType'],
		),
		'move' => array(
			'width' => '10%',
			'label' => $txt['sp-adminColumnMove'],
		),
		'action' => array(
			'width' => '10%',
			'label' => $txt['sp-adminColumnAction'],
			'class' => 'last_th',
		),
	);

	// Get the block info for each side.
	foreach($context['sides'] as $side)
	{
		$context['blocks'][$side['name']] = getBlockInfo($side['id']);
		foreach ($context['blocks'][$side['name']] as $block_id => $block)
		{
			$context['blocks'][$side['name']][$block_id] += array(
				'state_icon' => empty($block['state']) ? '<a href="' . $scripturl . '?action=admin;area=portalblocks;sa=statechange;' . (empty($context['sp_blocks_single_side_list']) ? '' : 'redirect=' . $block['column'] . ';') . 'block_id=' . $block['id'] . ';type=block;' . $context['session_var'] . '=' . $context['session_id'] . '">' . sp_embed_image('deactive', $txt['sp-blocksActivate']) . '</a>' : '<a href="' . $scripturl . '?action=admin;area=portalblocks;sa=statechange;' . (empty($context['sp_blocks_single_side_list']) ? '' : 'redirect=' . $block['column'] . ';') . 'block_id=' . $block['id'] . ';type=block;' . $context['session_var'] . '=' . $context['session_id'] . '">' . sp_embed_image('active', $txt['sp-blocksDeactivate']) . '</a>',
				'edit' => '<a href="' . $scripturl . '?action=admin;area=portalblocks;sa=edit;block_id=' . $block['id'] . ';' . $context['session_var'] . '=' . $context['session_id'] . '">' . sp_embed_image('modify') . '</a>',
				'delete' => '<a href="' . $scripturl . '?action=admin;area=portalblocks;sa=delete;block_id=' . $block['id'] . ';col=' . $block['column'] . ';' . $context['session_var'] . '=' . $context['session_id'] . '" onclick="return confirm(\''.$txt['sp-deleteblock'].'\');">' . sp_embed_image('delete') . '</a>',
				'moveup' => '<a href="' . $scripturl . '?action=admin;area=portalblocks;sa=move;redirect=' . $context['sub_action'] . ';block_id=' . $block['id'] . ';direction=up;' . $context['session_var'] . '=' . $context['session_id'] . '">' . sp_embed_image('up', $txt['sp-blocksMoveUp']) . '</a>',
				'movedown' => '<a href="' . $scripturl . '?action=admin;area=portalblocks;sa=move;redirect=' . $context['sub_action'] . ';block_id=' . $block['id'] . ';direction=down;' . $context['session_var'] . '=' . $context['session_id'] . '">' . sp_embed_image('down', $txt['sp-blocksMoveDown']) . '</a>',
				'moveleft' => '<a href="' . $scripturl . '?action=admin;area=portalblocks;sa=columnchange;' . (empty($context['sp_blocks_single_side_list']) ? '' : 'redirect;') . 'block_id=' . $block['id'] . ';to=left;' . $context['session_var'] . '=' . $context['session_id'] . '">' . sp_embed_image('left', $txt['sp-blocksMoveLeft']) . '</a>',
				'moveright' => '<a href="' . $scripturl . '?action=admin;area=portalblocks;sa=columnchange;' . (empty($context['sp_blocks_single_side_list']) ? '' : 'redirect;') . 'block_id=' . $block['id'] . ';to=right;' . $context['session_var'] . '=' . $context['session_id'] . '">' . sp_embed_image('right', $txt['sp-blocksMoveRight']) . '</a>'
			);
		}
	}

	// Call the sub template.
	$context['sub_template'] = 'block_list';
	$context['page_title'] = $txt['sp-adminBlockListName'];
}

// Adding or editing a block.
function sportal_admin_block_edit()
{
	global $txt, $context, $modSettings, $smcFunc, $sourcedir, $boarddir, $boards;

	// Just in case, the admin could be doing something silly like editing a SP block while SP it disabled. ;)
	require_once($sourcedir . '/PortalBlocks.php');

	$context['SPortal']['is_new'] = empty($_REQUEST['block_id']);
	
	// BBC Fix move the parameter to the correct position.
	if (!empty($_POST['bbc_name']))
	{
		$_POST['parameters'][$_POST['bbc_name']] = !empty($_POST[$_POST['bbc_parameter']]) ? $_POST[$_POST['bbc_parameter']] : '';
		// If we came from WYSIWYG then turn it back into BBC regardless.
		if (!empty($_REQUEST['bbc_' . $_POST['bbc_name'] . '_mode']) && isset($_POST['parameters'][$_POST['bbc_name']]))
		{
			require_once($sourcedir . '/Subs-Editor.php');
			$_POST['parameters'][$_POST['bbc_name']] = html_to_bbc($_POST['parameters'][$_POST['bbc_name']]);
			// We need to unhtml it now as it gets done shortly.
			$_POST['parameters'][$_POST['bbc_name']] = un_htmlspecialchars($_POST['parameters'][$_POST['bbc_name']]);
			// We need this for everything else.
			$_POST['parameters'][$_POST['bbc_name']] = $_POST['parameters'][$_POST['bbc_name']];
		}
	}

	// Passing the selected type via $_GET instead of $_POST?
	$start_parameters = array();
	if (!empty($_GET['selected_type']) && empty($_POST['selected_type']))
	{
		$_POST['selected_type'] = array($_GET['selected_type']);
		if (!empty($_GET['parameters']))
		{
			foreach ($_GET['parameters'] as $param)
			{
				if (isset($_GET[$param]))
					$start_parameters[$param] = $_GET[$param];
			}
		}
	}

	if ($context['SPortal']['is_new'] && empty($_POST['selected_type']) && empty($_POST['add_block']))
	{
		$context['SPortal']['block_types'] = getFunctionInfo();

		if (!empty($_REQUEST['col']))
			$context['SPortal']['block']['column'] = $_REQUEST['col'];

		$context['sub_template'] = 'block_select_type';
		$context['page_title'] = $txt['sp-blocksAdd'];
	}
	elseif ($context['SPortal']['is_new'] && !empty($_POST['selected_type']))
	{
		$context['SPortal']['block'] = array(
			'id' => 0,
			'label' => $txt['sp-blocksDefaultLabel'],
			'type' => $_POST['selected_type'][0],
			'type_text' => !empty($txt['sp_function_' . $_POST['selected_type'][0] . '_label']) ? $txt['sp_function_' . $_POST['selected_type'][0] . '_label'] : $txt['sp_function_unknown_label'],
			'column' => !empty($_POST['block_column']) ? $_POST['block_column'] : 0,
			'row' => 0,
			'state' => 1,
			'force_view' => 0,
			'allowed_groups' => 'all',
			'permission_type' => 0,
			'display' => '',
			'display_custom' => '',
			'style' => '',
			'parameters' => !empty($start_parameters) ? $start_parameters : array(),
			'options'=> $_POST['selected_type'][0](array(), false, true),
			'list_blocks' => !empty($_POST['block_column']) ? getBlockInfo($_POST['block_column']) : array(),
		);
	}
	elseif (!$context['SPortal']['is_new'] && empty($_POST['add_block']))
	{
		$_REQUEST['block_id'] = (int) $_REQUEST['block_id'];
		$context['SPortal']['block'] = current(getBlockInfo(null, $_REQUEST['block_id']));

		$context['SPortal']['block'] += array(
			'options'=> $context['SPortal']['block']['type'](array(), false, true),
			'list_blocks' => getBlockInfo($context['SPortal']['block']['column']),
		);
	}

	if (!empty($_POST['preview_block']))
	{
		// Just in case, the admin could be doing something silly like editing a SP block while SP it disabled. ;)
		require_once($boarddir . '/SSI.php');
		sportal_init_headers();
		loadTemplate('Portal');

		$type_parameters = $_POST['block_type'](array(), 0, true);

		if (!empty($_POST['parameters']) && is_array($_POST['parameters']) && !empty($type_parameters))
		{
			foreach ($type_parameters as $name => $type)
			{
				if (isset($_POST['parameters'][$name]))
				{
					if ($type == 'bbc')
					{
						$parameter['value'] = $_POST['parameters'][$name];
						require_once($sourcedir . '/Subs-Post.php');

						$parameter['value'] = $smcFunc['htmlspecialchars']($parameter['value'], ENT_QUOTES);
						preparsecode($parameter['value']);

						$_POST['parameters'][$name] = $parameter['value'];
					}
					elseif ($type == 'boards' || $type == 'board_select')
						$_POST['parameters'][$name] = is_array($_POST['parameters'][$name]) ? implode('|', $_POST['parameters'][$name]) : $_POST['parameters'][$name];
					elseif ($type == 'int' || $type == 'select')
						$_POST['parameters'][$name] = (int) $_POST['parameters'][$name];
					elseif ($type == 'text' || $type == 'textarea' || is_array($type))
						$_POST['parameters'][$name] = $smcFunc['htmlspecialchars']($_POST['parameters'][$name], ENT_QUOTES);
					elseif ($type == 'check')
						$_POST['parameters'][$name] = !empty($_POST['parameters'][$name]) ? 1 : 0;
				}
			}
		}
		else
			$_POST['parameters'] = array();

		if (empty($_POST['display_advanced']))
		{
			if (!empty($_POST['display_simple']) && in_array($_POST['display_simple'], array('all', 'sportal', 'sforum', 'allaction', 'allboard')))
				$display = $_POST['display_simple'];
			else
				$display = '';

			$custom = '';
		}
		else
		{
			$display = array();
			$custom = array();

			if (!empty($_POST['display_actions']))
				foreach ($_POST['display_actions'] as $action)
					$display[] = $smcFunc['htmlspecialchars']($action, ENT_QUOTES);

			if (!empty($_POST['display_boards']))
				foreach ($_POST['display_boards'] as $board)
					$display[] = 'b' . ((int) substr($board, 1));

			if (!empty($_POST['display_pages']))
				foreach ($_POST['display_pages'] as $page)
					$display[] = 'p' . ((int) substr($page, 1));

			if (!empty($_POST['display_custom']))
			{
				$temp = explode(',', $_POST['display_custom']);
				foreach ($temp as $action)
					$custom[] = $smcFunc['htmlspecialchars']($smcFunc['htmltrim']($action), ENT_QUOTES);
			}

			$display = empty($display) ? '' : implode(',', $display);
			$custom = empty($custom) ? '' : implode(',', $custom);
		}

		$context['SPortal']['block'] = array(
			'id' => $_POST['block_id'],
			'label' => $smcFunc['htmlspecialchars']($_POST['block_name'], ENT_QUOTES),
			'type' => $_POST['block_type'],
			'type_text' => !empty($txt['sp_function_' . $_POST['block_type'] . '_label']) ? $txt['sp_function_' . $_POST['block_type'] . '_label'] : $txt['sp_function_unknown_label'],
			'column' => $_POST['block_column'],
			'row' => !empty($_POST['block_row']) ? $_POST['block_row'] : 0,
			'state' => !empty($_POST['block_active']),
			'force_view' => !empty($_POST['block_force']),
			'allowed_groups' => $_POST['member_groups'],
			'permission_type' => $_POST['permission_type'],
			'display' => $display,
			'display_custom' => $custom,
			'style' => sportal_parse_style('implode'),
			'parameters' => !empty($_POST['parameters']) ? $_POST['parameters'] : array(),
			'options'=> $_POST['block_type'](array(), false, true),
			'list_blocks' => getBlockInfo($_POST['block_column']),
			'collapsed' => false,
		);

		if (strpos($modSettings['leftwidth'], '%') !== false || strpos($modSettings['leftwidth'], 'px') !== false)
			$context['widths'][1] = $modSettings['leftwidth'];
		else
			$context['widths'][1] = $modSettings['leftwidth'] . 'px';

		if (strpos($modSettings['rightwidth'], '%') !== false || strpos($modSettings['rightwidth'], 'px') !== false)
			$context['widths'][4] = $modSettings['rightwidth'];
		else
			$context['widths'][4] = $modSettings['rightwidth'] . 'px';

		if (strpos($context['widths'][1], '%') !== false)
			$context['widths'][2] = $context['widths'][3] = 100 - ($context['widths'][1] + $context['widths'][4]) . '%';
		elseif (strpos($context['widths'][1], 'px') !== false)
			$context['widths'][2] = $context['widths'][3] = 960 - ($context['widths'][1] + $context['widths'][4]) . 'px';

		$context['SPortal']['preview'] = true;
	}

	if (!empty($_POST['selected_type']) || !empty($_POST['preview_block']) || (!$context['SPortal']['is_new'] && empty($_POST['add_block'])))
	{
		if ($context['SPortal']['block']['type'] == 'sp_php' && !allowedTo('admin_forum'))
			fatal_lang_error('cannot_admin_forum', false);

		$context['html_headers'] .= '
	<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		function sp_collapseObject(id)
		{
			mode = document.getElementById("sp_object_" + id).style.display == "" ? 0 : 1;
			document.getElementById("sp_collapse_" + id).src = smf_images_url + (mode ? "/collapse.gif" : "/expand.gif");
			document.getElementById("sp_object_" + id).style.display = mode ? "" : "none";
		}
	// ]]></script>';

		loadLanguage('SPortalHelp', sp_languageSelect('SPortalHelp'));
		loadTemplate('PortalGeneric');

		if (isset($_POST['member_groups']))
			$context['SPortal']['block']['allowed_groups'] = $_POST['member_groups'];

		sp_loadMemberGroups($context['SPortal']['block']['allowed_groups']);

		$context['simple_actions'] = array(
			'sportal' => $txt['sp-portal'],
			'sforum' => $txt['sp-forum'],
			'allaction' => $txt['sp-blocksOptionAllActions'],
			'allboard' => $txt['sp-blocksOptionAllBoards'],
			'allpages' => $txt['sp-blocksOptionAllPages'],
			'all' => $txt['sp-blocksOptionEverywhere'],
		);

		$context['display_actions'] = array(
			'portal' => $txt['sp-portal'],
			'forum' => $txt['sp-forum'],
			'recent' => $txt['recent_posts'],
			'unread' => $txt['unread_topics_visit'],
			'unreadreplies' => $txt['unread_replies'],
			'profile' => $txt['profile'],
			'pm' => $txt['pm_short'],
			'calendar' => $txt['calendar'],
			'admin' =>  $txt['admin'],
			'login' =>  $txt['login'],
			'register' =>  $txt['register'],
			'post' =>  $txt['post'],
			'stats' =>  $txt['forum_stats'],
			'search' =>  $txt['search'],
			'mlist' =>  $txt['members_list'],
			'moderate' =>  $txt['moderate'],
			'help' =>  $txt['help'],
			'who' =>  $txt['who_title'],
		);

		$request = $smcFunc['db_query']('','
			SELECT id_board, name
			FROM {db_prefix}boards
			ORDER BY name DESC'
		);
		$context['display_boards'] = array();
		while ($row = $smcFunc['db_fetch_assoc']($request))
			$context['display_boards']['b' . $row['id_board']] = $row['name'];
		$smcFunc['db_free_result']($request);

		$request = $smcFunc['db_query']('','
			SELECT id_page, title
			FROM {db_prefix}sp_pages
			ORDER BY title DESC'
		);
		$context['display_pages'] = array();
		while ($row = $smcFunc['db_fetch_assoc']($request))
			$context['display_pages']['p' . $row['id_page']] = $row['title'];
		$smcFunc['db_free_result']($request);

		if (empty($context['SPortal']['block']['display']))
			$context['SPortal']['block']['display'] = array('0');
		else
			$context['SPortal']['block']['display'] = explode(',', $context['SPortal']['block']['display']);

		if (in_array($context['SPortal']['block']['display'][0], array('all', 'sportal', 'sforum', 'allaction', 'allboard')) || $context['SPortal']['is_new'] || empty($context['SPortal']['block']['display'][0]) && empty($context['SPortal']['block']['display_custom']))
			$context['SPortal']['block']['display_type'] = 0;
		else
			$context['SPortal']['block']['display_type'] = 1;

		$context['SPortal']['block']['style'] = sportal_parse_style('explode', $context['SPortal']['block']['style'], !empty($context['SPortal']['preview']));

		// Prepare the Textcontent for BBC, only the first bbc will be correct detected! (SMF Support only 1 per page with the standard function)
		$firstBBCFound = false;
		foreach ($context['SPortal']['block']['options'] as $name => $type)
		{
			// Selectable Boards :D
			if ($type == 'board_select' || $type == 'boards')
			{
				if (empty($boards))
				{
					require_once($sourcedir.'/Subs-Boards.php');
					getBoardTree();
				}

				// Merge the array ;). (Only in 2.0 needed)
				if(!isset($context['SPortal']['block']['parameters'][$name]))
					$context['SPortal']['block']['parameters'][$name] = array();
				elseif(!empty($context['SPortal']['block']['parameters'][$name]) && is_array($context['SPortal']['block']['parameters'][$name]))
					$context['SPortal']['block']['parameters'][$name] = implode('|', $context['SPortal']['block']['parameters'][$name]);

				$context['SPortal']['block']['board_options'][$name] = array();
				$config_variable = !empty($context['SPortal']['block']['parameters'][$name]) ? $context['SPortal']['block']['parameters'][$name] : array();
				$config_variable = !is_array($config_variable) ? explode('|', $config_variable) : $config_variable;
				$context['SPortal']['block']['board_options'][$name] = array();

				// Create the list for this Item
				foreach ($boards as $board)
				{
					if (!empty($board['redirect'])) // Ignore the redirected boards :)
						continue;

					$context['SPortal']['block']['board_options'][$name][$board['id']] = array(
						'value' => $board['id'],
						'text' => $board['name'],
						'selected' => in_array($board['id'], $config_variable),
					);
				}
			}
			// Prepare the Textcontent for BBC, only the first bbc will be correct detected! (SMF Support only 1 per page with the standard function)
			elseif ($type == 'bbc')
			{
				// SMF support only one bbc correct, multiple bbc do not work at the moment
				if(!$firstBBCFound)
				{
					$firstBBCFound = true;
				 // Start SMF BBC Sytem :)
					require_once($sourcedir . '/Subs-Editor.php');
					// Prepare the output :D
					$form_message = !empty($context['SPortal']['block']['parameters'][$name]) ? $context['SPortal']['block']['parameters'][$name] : '';
					// But if it's in HTML world, turn them into htmlspecialchar's so they can be edited!
					if (strpos($form_message, '[html]') !== false)
					{
						$parts = preg_split('~(\[/code\]|\[code(?:=[^\]]+)?\])~i', $form_message, -1, PREG_SPLIT_DELIM_CAPTURE);
						for ($i = 0, $n = count($parts); $i < $n; $i++)
						{
							// It goes 0 = outside, 1 = begin tag, 2 = inside, 3 = close tag, repeat.
							if ($i % 4 == 0)
								$parts[$i] = preg_replace('~\[html\](.+?)\[/html\]~ise', '\'[html]\' . preg_replace(\'~<br\s?/?>~i\', \'&lt;br /&gt;<br />\', \'$1\') . \'[/html]\'', $parts[$i]);
						}
						$form_message = implode('', $parts);
					}
					$form_message = preg_replace('~<br(?: /)?' . '>~i', "\n", $form_message);

					// Prepare the data before i want them inside the textarea
					$form_message = str_replace(array('"', '<', '>', '&nbsp;'), array('&quot;', '&lt;', '&gt;', ' '), $form_message);
					$context['SPortal']['bbc'] = 'bbc_'.$name;
					$message_data = array(
						'id' => $context['SPortal']['bbc'],
						'width' => '95%',
						'height' => '200px',
						'value' => $form_message,
						'form' => 'sp_block',
					);
					
					// Run the SMF bbc editor rutine
					create_control_richedit($message_data);
					
					// Store the updated data on the parameters
					$context['SPortal']['block']['parameters'][$name] = $form_message;
				}
				else
					$context['SPortal']['block']['options'][$name] = 'textarea';
			}
		}

		$context['sub_template'] = 'block_edit';
		$context['page_title'] = $context['SPortal']['is_new'] ? $txt['sp-blocksAdd'] : $txt['sp-blocksEdit'];
	}

	if (!empty($_POST['add_block']))
	{
		if ($_POST['block_type'] == 'sp_php' && !allowedTo('admin_forum'))
			fatal_lang_error('cannot_admin_forum', false);

		if (!isset($_POST['block_name']) || $smcFunc['htmltrim']($smcFunc['htmlspecialchars']($_POST['block_name']), ENT_QUOTES) === '')
			fatal_lang_error('error_sp_name_empty', false);

		if ($_POST['block_type'] == 'sp_php' && !empty($_POST['parameters']['content']) && empty($modSettings['sp_disable_php_validation']))
		{
			$error = sp_validate_php($_POST['parameters']['content']);

			if ($error)
				fatal_lang_error('error_sp_php_' . $error, false);
		}

		if (!empty($_POST['placement']) && (($_POST['placement'] == 'before') || ($_POST['placement'] == 'after')))
		{
			if (!empty($_REQUEST['block_id']) && ($temp = current(getBlockInfo(null, $_REQUEST['block_id']))))
				$current_row = $temp['row'];
			else
				$current_row = null;

			if ($_POST['placement'] == 'before')
				$row = (int) $_POST['block_row'];
			else
				$row = (int) $_POST['block_row'] + 1;

			if (!empty($current_row) && ($row > $current_row))
			{
				$row = $row - 1;

				$smcFunc['db_query']('', '
					UPDATE {db_prefix}sp_blocks
					SET row = row - 1
					WHERE col = {int:col}
						AND row > {int:start}
						AND row <= {int:end}',
					array(
						'col' => (int) $_POST['block_column'],
						'start' => $current_row,
						'end' => $row,
					)
				);
			}
			else
			{
				$smcFunc['db_query']('', '
					UPDATE {db_prefix}sp_blocks
					SET row = row + 1
					WHERE col = {int:col}
						AND row >= {int:start}' . (!empty($current_row) ? '
						AND row < {int:end}' : ''),
					array(
						'col' => (int) $_POST['block_column'],
						'start' => $row,
						'end' => !empty($current_row) ? $current_row : 0,
					)
				);
			}
		}
		elseif (!empty($_POST['placement']) && $_POST['placement'] == 'nochange')
			$row = 0;
		else
		{
			$request =  $smcFunc['db_query']('','
				SELECT row
				FROM {db_prefix}sp_blocks
				WHERE col = {int:col}' . (!empty($_REQUEST['block_id']) ? '
					AND id_block != {int:current_id}' : '' ) . '
				ORDER BY row DESC
				LIMIT 1',
				array(
					'col' => $_POST['block_column'],
					'current_id' => $_REQUEST['block_id'],
				)
			);
			list ($row) = $smcFunc['db_fetch_row']($request);
			$smcFunc['db_free_result']($request);

			$row = $row + 1;
		}

		$type_parameters = $_POST['block_type'](array(), 0, true);

		if (!empty($_POST['parameters']) && is_array($_POST['parameters']) && !empty($type_parameters))
		{
			foreach ($type_parameters as $name => $type)
			{
				if (isset($_POST['parameters'][$name]))
				{
					// Prepare BBC Content for SMF 2 special case =D
					if ($type == 'bbc')
					{
						$parameter['value'] = $_POST['parameters'][$name];
						require_once($sourcedir . '/Subs-Post.php');
						// Prepare the message a bit for some additional testing.
						$parameter['value'] = $smcFunc['htmlspecialchars']($parameter['value'], ENT_QUOTES);
						preparsecode($parameter['value']);
						//Store now the correct and fixed value ;)
						$_POST['parameters'][$name] = $parameter['value'];
					}
					elseif ($type == 'boards' || $type == 'board_select')
						$_POST['parameters'][$name] = is_array($_POST['parameters'][$name]) ? implode('|', $_POST['parameters'][$name]) : $_POST['parameters'][$name];
					elseif ($type == 'int' || $type == 'select')
						$_POST['parameters'][$name] = (int) $_POST['parameters'][$name];
					elseif ($type == 'text' || $type == 'textarea' || is_array($type))
						$_POST['parameters'][$name] = $smcFunc['htmlspecialchars']($_POST['parameters'][$name], ENT_QUOTES);
					elseif ($type == 'check')
						$_POST['parameters'][$name] = !empty($_POST['parameters'][$name]) ? 1 : 0;
				}
			}
		}
		else
			$_POST['parameters'] = array();

		if (!empty($_POST['member_groups']) && is_array($_POST['member_groups']))
			$_POST['allowed_groups'] = implode(',', $_POST['member_groups']);
		else
			$_POST['allowed_groups'] = '';

		if (empty($_POST['display_advanced']))
		{
			if (!empty($_POST['display_simple']) && in_array($_POST['display_simple'], array('all', 'sportal', 'sforum', 'allaction', 'allboard')))
				$display = $_POST['display_simple'];
			else
				$display = '';

			$custom = '';
		}
		else
		{
			$display = array();
			$custom = array();

			if (!empty($_POST['display_actions']))
				foreach ($_POST['display_actions'] as $action)
					$display[] = $smcFunc['htmlspecialchars']($action, ENT_QUOTES);

			if (!empty($_POST['display_boards']))
				foreach ($_POST['display_boards'] as $board)
					$display[] = 'b' . ((int) substr($board, 1));

			if (!empty($_POST['display_pages']))
				foreach ($_POST['display_pages'] as $page)
					$display[] = 'p' . ((int) substr($page, 1));

			if (!empty($_POST['display_custom']))
			{
				$temp = explode(',', $_POST['display_custom']);
				foreach ($temp as $action)
					$custom[] = $smcFunc['htmlspecialchars']($smcFunc['htmltrim']($action), ENT_QUOTES);
			}

			$display = empty($display) ? '' : implode(',', $display);
			$custom = empty($custom) ? '' : implode(',', $custom);
		}

		$blockInfo = array(
			'id' => (int) $_POST['block_id'],
			'label' => $smcFunc['htmlspecialchars']($_POST['block_name'], ENT_QUOTES),
			'type' => $_POST['block_type'],
			'col' => $_POST['block_column'],
			'row' => $row,
			'state' => !empty($_POST['block_active']) ? 1 : 0,
			'force_view' => !empty($_POST['block_force']) ? 1 : 0,
			'allowed_groups' => $_POST['allowed_groups'],
			'permission_type' => empty($_POST['permission_type']) || $_POST['permission_type'] > 2 ? 0 : $_POST['permission_type'],
			'display' => $display,
			'display_custom' => $custom,
			'style' => sportal_parse_style('implode'),
		);

		if ($context['SPortal']['is_new'])
		{
			unset($blockInfo['id']);

			$smcFunc['db_insert']('',
				'{db_prefix}sp_blocks',
				array(
					'label' => 'string',
					'type' => 'string',
					'col' => 'int',
					'row' => 'int',
					'state' => 'int',
					'force_view' => 'int',
					'allowed_groups' => 'string',
					'permission_type' => 'string',
					'display' => 'string',
					'display_custom' => 'string',
					'style' => 'string',
				),
				$blockInfo,
				array('id_block')
			);

			$blockInfo['id'] = $smcFunc['db_insert_id']('{db_prefix}sp_blocks', 'id_block');
		}
		else
		{
			$block_fields = array(
				"label = {string:label}",
				"state = {int:state}",
				"force_view = {int:force_view}",
				"allowed_groups = {string:allowed_groups}",
				"permission_type = {string:permission_type}",
				"display = {string:display}",
				"display_custom = {string:display_custom}",
				"style = {string:style}",
			);

			if (!empty($blockInfo['row']))
				$block_fields[] = "row = {int:row}";
			else
				unset($blockInfo['row']);

			$smcFunc['db_query']('','
				UPDATE {db_prefix}sp_blocks
				SET ' . implode(', ', $block_fields) . '
				WHERE id_block = {int:id}',
				$blockInfo
			);

			$smcFunc['db_query']('','
				DELETE FROM {db_prefix}sp_parameters
				WHERE id_block = {int:id}',
				array(
					'id' => $blockInfo['id'],
				)
			);
		}

		if (!empty($_POST['parameters']))
		{
			$parameters = array();
			foreach ($_POST['parameters'] as $variable => $value)
				$parameters[] = array(
					'id_block' => $blockInfo['id'],
					'variable' => $variable,
					'value' => $value,
				);

			$smcFunc['db_insert']('',
				'{db_prefix}sp_parameters',
				array(
					'id_block' => 'int',
					'variable' => 'string',
					'value' => 'string',
				),
				$parameters,
				array()
			);
		}

		redirectexit('action=admin;area=portalblocks');
	}
}

// Function for deleting a block.
function sportal_admin_block_delete()
{
	global $smcFunc;

	// Check if he can?
	checkSession('get');

	// Make sure ID is an integer.
	$_REQUEST['block_id'] = (int) $_REQUEST['block_id'];

	// Do we have that?
	if(empty($_REQUEST['block_id']))
		fatal_lang_error('error_sp_id_empty', false);

	// Make sure column ID is an integer too.
	$_REQUEST['col'] = (int) $_REQUEST['col'];

	// Only Admins can Remove PHP Blocks
	if(!allowedTo('admin_forum'))
	{
		$context['SPortal']['block'] = current(getBlockInfo(null, $_REQUEST['block_id']));
		if($context['SPortal']['block']['type'] == 'sp_php' && !allowedTo('admin_forum'))
			fatal_lang_error('cannot_admin_forum', false);
	}

	// We don't need it anymore.
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}sp_blocks
		WHERE id_block = {int:id}',
		array(
			'id' => $_REQUEST['block_id'],
		)
	);

	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}sp_parameters
		WHERE id_block = {int:id}',
		array(
			'id' => $_REQUEST['block_id'],
		)
	);

	// Fix column rows.
	fixColumnRows($_REQUEST['col']);

	// Return back to the block list.
	redirectexit('action=admin;area=portalblocks');
}

// Function for moving a block.
function sportal_admin_block_move()
{
	// Check if he can?
	checkSession('get');

	// Make sure ID is an integer.
	$_REQUEST['block_id'] = (int) $_REQUEST['block_id'];

	// Check it!
	if(empty($_REQUEST['block_id']))
		fatal_lang_error('error_sp_id_empty', false);

	// Change it with the magical tool.
	changeBlockRow($_REQUEST['block_id'], $_REQUEST['direction']);

	$area = !empty($_GET['redirect']) ? $_GET['redirect'] : 'list';

	// Return back to the block list.
	redirectexit('action=admin;area=portalblocks;sa=' . $area);
}

function sportal_admin_column_change()
{
	global $smcFunc;

	checkSession('get');

	if (empty($_REQUEST['block_id']))
		fatal_lang_error('error_sp_id_empty', false);
	else
		$id = (int) $_REQUEST['block_id'];

	if (empty($_REQUEST['to']) || !in_array($_REQUEST['to'], array('left', 'right')))
		fatal_lang_error('error_sp_side_wrong', false);
	else
		$to = $_REQUEST['to'];

	$request =  $smcFunc['db_query']('','
		SELECT col
		FROM {db_prefix}sp_blocks
		WHERE id_block = {int:block_id}
		LIMIT 1',
		array(
			'block_id' => $id,
		)
	);
	list ($from) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);

	if (empty($from))
		fatal_lang_error('error_sp_block_wrong', false);

	$to = ($to == 'left') ? ($from - 1) : ($from + 1);

	if ($to < 1 || $to > 4)
		fatal_lang_error('error_sp_side_wrong', false);

	$smcFunc['db_query']('','
		UPDATE {db_prefix}sp_blocks
		SET col = {int:to}, row = {int:row}
		WHERE id_block = {int:block_id}',
		array(
			'block_id' => $id,
			'to' => $to,
			'row' => 100,
		)
	);

	fixColumnRows($from);
	fixColumnRows($to);

	$sides = array(1 => 'left', 2 => 'top', 3 => 'bottom', 4 => 'right');
	$list = isset($_GET['redirect']) ? $sides[$to] : 'list';

	redirectexit('action=admin;area=portalblocks;sa=' . $list);
}

?>