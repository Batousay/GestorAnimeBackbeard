<?php
// Version: 2.3.3; PortalAdminShoutbox

function template_shoutbox_list()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
	<div id="sp_manage_shoutboxes">
		<form action="', $scripturl, '?action=admin;area=portalshoutbox;sa=list" method="post" accept-charset="', $context['character_set'], '" onsubmit="return confirm(\'', $txt['sp_shoutbox_remove_confirm'], '\');">
			<div class="sp_align_left pagesection">
				', $txt['pages'], ': ', $context['page_index'], '
			</div>
			<table class="table_grid" cellspacing="0" width="100%">
				<thead>
					<tr class="catbg">';

	foreach ($context['columns'] as $column)
	{
		if ($column['selected'])
			echo '
						<th scope="col"', isset($column['class']) ? ' class="' . $column['class'] . '"' : '', isset($column['width']) ? ' width="' . $column['width'] . '"' : '', '>
							<a href="', $column['href'], '">', $column['label'], '&nbsp;<img src="', $settings['images_url'], '/sort_', $context['sort_direction'], '.gif" alt="" /></a>
						</th>';
		elseif ($column['sortable'])
			echo '
						<th scope="col"', isset($column['class']) ? ' class="' . $column['class'] . '"' : '', isset($column['width']) ? ' width="' . $column['width'] . '"' : '', '>
							', $column['link'], '
						</th>';
		else
			echo '
						<th scope="col"', isset($column['class']) ? ' class="' . $column['class'] . '"' : '', isset($column['width']) ? ' width="' . $column['width'] . '"' : '', '>
							', $column['label'], '
						</th>';
	}

	echo '
						<th scope="col" class="last_th">
							<input type="checkbox" class="input_check" onclick="invertAll(this, this.form);" />
						</th>
					</tr>
				</thead>
				<tbody>';
	
	if (empty($context['shoutboxes']))
	{
		echo '
					<tr class="windowbg2">
						<td class="sp_center" colspan="', count($context['columns']) + 1, '">', $txt['sp_error_no_shoutbox'], '</td>
					</tr>';
	}

	foreach ($context['shoutboxes'] as $shoutbox)
	{
		echo '
					<tr class="windowbg2">
						<td class="sp_left">', $shoutbox['name'], '</td>
						<td class="sp_center">', $shoutbox['shouts'], '</td>
						<td class="sp_center">', $shoutbox['caching'] ? $txt['sp_yes'] : $txt['sp_no'], '</td>
						<td class="sp_center">', $shoutbox['status_image'], '</td>
						<td class="sp_center">', implode('&nbsp;', $shoutbox['actions']), '</td>
						<td class="sp_center"><input type="checkbox" name="remove[]" value="', $shoutbox['id'], '" class="input_check" /></td>
					</tr>';
	}

	echo '
				</tbody>
			</table>
			<div class="sp_align_left pagesection">
				<div class="sp_float_right">
					<input type="submit" name="remove_shoutbox" value="', $txt['sp_admin_shoutbox_remove'], '" class="button_submit" />
				</div>
				', $txt['pages'], ': ', $context['page_index'], '
			</div>
			<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
		</form>
	</div>';
}

function template_shoutbox_edit()
{
	global $context, $settings, $options, $scripturl, $txt, $helptxt, $modSettings;

	echo '
	<div id="sp_edit_shoutbox">
		<form action="', $scripturl, '?action=admin;area=portalshoutbox;sa=edit" method="post" accept-charset="', $context['character_set'], '">
			<h3 class="catbg"><span class="left"></span>
				', $context['page_title'], '
			</h3>
			<div class="windowbg2">
				<span class="topslice"><span></span></span>
				<div class="sp_content_padding">
					<dl class="sp_form">
						<dt>
							<label for="shoutbox_name">', $txt['sp_admin_shoutbox_col_name'], ':</label>
						</dt>
						<dd>
							<input type="text" name="name" id="shoutbox_name" value="', $context['SPortal']['shoutbox']['name'], '" class="input_text" />
						</dd>
						<dt>
							', $txt['sp_admin_shoutbox_col_permissions'], ':
						</dt>
						<dd>';

	sp_template_inline_permissions();

	echo '
						</dd>
						<dt>
							', $txt['sp_admin_shoutbox_col_permissions_type'], ':
						</dt>
						<dd>
							<ul class="reset">';

	$permission_types = array('One', 'All', 'Ignore');
	foreach ($permission_types as $id => $type)
		echo '
								<li><input type="radio" name="permission_type" value="', $id, '"', $context['SPortal']['shoutbox']['permission_type'] == $id ? ' checked="checked"' : '', ' class="input_radio" />', $txt['sp-blocksPermission' . $type], '</li>';

	echo '
							</ul>
						</dd>
						<dt>
							<a href="', $scripturl, '?action=helpadmin;help=sp-shoutboxesWarning" onclick="return reqWin(this.href);" class="help"><img src="', $settings['images_url'], '/helptopics.gif" alt="', $txt['help'], '" class="icon" /></a>
							<label for="shoutbox_warning">', $txt['sp_admin_shoutbox_col_warning'], ':</label>
						</dt>
						<dd>
							<input type="text" name="warning" id="shoutbox_warning" value="', $context['SPortal']['shoutbox']['warning'], '" size="25" class="input_text" />
						</dd>
						<dt>
							<a href="', $scripturl, '?action=helpadmin;help=sp-shoutboxesBBC" onclick="return reqWin(this.href);" class="help"><img src="', $settings['images_url'], '/helptopics.gif" alt="', $txt['help'], '" class="icon" /></a>
							<label for="shoutbox_bbc">', $txt['sp_admin_shoutbox_col_bbc'], ':</label>
						</dt>
						<dd>
							<select name="allowed_bbc[]" id="shoutbox_bbc" size="7" multiple="multiple">';

	foreach ($context['allowed_bbc'] as $tag => $label)
		if (!isset($context['disabled_tags'][$tag]))
			echo '
								<option value="', $tag, '"', in_array($tag, $context['SPortal']['shoutbox']['allowed_bbc']) ? ' selected="selected"' : '', '>[', $tag, '] - ', $label, '</option>';

	echo '
							</select>
						</dd>
						<dt>
							<label for="shoutbox_height">', $txt['sp_admin_shoutbox_col_height'], '</label>
						</dt>
						<dd>
							<input type="text" name="height" id="shoutbox_height" value="', $context['SPortal']['shoutbox']['height'], '" size="10" class="input_text" />
						</dd>
						<dt>
							<label for="shoutbox_num_show">', $txt['sp_admin_shoutbox_col_num_show'], ':</label>
						</dt>
						<dd>
							<input type="text" name="num_show" id="shoutbox_num_show" value="', $context['SPortal']['shoutbox']['num_show'], '" size="10" class="input_text" />
						</dd>
						<dt>
							<label for="shoutbox_num_max">', $txt['sp_admin_shoutbox_col_num_max'], ':</label>
						</dt>
						<dd>
							<input type="text" name="num_max" id="shoutbox_num_max" value="', $context['SPortal']['shoutbox']['num_max'], '" size="10" class="input_text" />
						</dd>
						<dt>
							<label for="shoutbox_reverse">', $txt['sp_admin_shoutbox_col_reverse'], ':</label>
						</dt>
						<dd>
							<input type="checkbox" name="reverse" id="shoutbox_reverse" value="1"', $context['SPortal']['shoutbox']['reverse'] ? ' checked="checked"' : '', ' class="input_check" />
						</dd>
						<dt>
							<label for="shoutbox_caching">', $txt['sp_admin_shoutbox_col_caching'], ':</label>
						</dt>
						<dd>
							<input type="checkbox" name="caching" id="shoutbox_caching" value="1"', $context['SPortal']['shoutbox']['caching'] ? ' checked="checked"' : '', ' class="input_check" />
						</dd>
						<dt>
							<label for="shoutbox_refresh">', $txt['sp_admin_shoutbox_col_refresh'], '</label>
						</dt>
						<dd>
							<input type="text" name="refresh" id="shoutbox_refresh" value="', $context['SPortal']['shoutbox']['refresh'], '" size="10" class="input_text" />
						</dd>
						<dt>
							<label for="shoutbox_status">', $txt['sp_admin_shoutbox_col_status'], ':</label>
						</dt>
						<dd>
							<input type="checkbox" name="status" id="shoutbox_status" value="1"', $context['SPortal']['shoutbox']['status'] ? ' checked="checked"' : '', ' class="input_check" />
						</dd>
					</dl>
					<div class="sp_button_container">
						<input type="submit" name="submit" value="', $context['page_title'], '" class="button_submit" />
					</div>
				</div>
				<span class="botslice"><span></span></span>
			</div>
			<input type="hidden" name="shoutbox_id" value="', $context['SPortal']['shoutbox']['id'], '" />
			<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
		</form>
	</div>';
}

function template_shoutbox_block_redirect()
{
	global $context;

	echo '
	<div id="sp_shoutbox_redirect">
		<h3 class="catbg"><span class="left"></span>
			', $context['page_title'], '
		</h3>
		<div class="sp_center windowbg2">
			<span class="topslice"><span></span></span>
			<div class="sp_content_padding">
				', $context['redirect_message'], '
			</div>
			<span class="botslice"><span></span></span>
		</div>
	</div>';
}

?>