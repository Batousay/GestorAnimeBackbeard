<?php
// Version: 0.1; AnimeAdmin

function template_servers_list()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
		<table class="table_grid" cellspacing="0" width="100%">
			<thead>
				<tr class="catbg">';

	foreach ($context['columns'] as $column)
	{
			echo '
					<th scope="col"', isset($column['class']) ? ' class="' . $column['class'] . '"' : '', isset($column['width']) ? ' width="' . $column['width'] . '"' : '', '>
						', $column['label'], '
					</th>';
	}

	echo '
				</tr>
			</thead>
			<tbody>';

        //Linea vacia
	if (empty($context['servers']))
	{
		echo '
					<tr class="windowbg2">
						<td class="sp_center" colspan="', count($context['columns']) + 1, '">&nbsp;</td>
					</tr>';
	}

            //Si encuentra categorías
	foreach($context['servers'] as $server)
	{
		echo '
				<tr class="windowbg2">
					<td class="sp_center">', !empty($server['picture']['href']) ? $server['picture']['image'] : '', '</td>
					<td class="sp_center">', $server['name'], '</td>
                                        <td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-servers;sa=stateChange;server_id=', $server['id'], ';type=Protected;', $context['session_var'], '=', $context['session_id'], '">', empty($server['protected']) ? sp_embed_image('deactive', $txt['sp-stateNo']) : sp_embed_image('active', $txt['sp-stateYes']), '</a></td>
                                        <td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-servers;sa=stateChange;server_id=', $server['id'], ';type=Private;', $context['session_var'], '=', $context['session_id'], '">', empty($server['private']) ? sp_embed_image('deactive', $txt['sp-stateNo']) : sp_embed_image('active', $txt['sp-stateYes']), '</a></td>
					<td class="sp_center">', $server['categoryName'] , '</td>
					<td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-servers;sa=editServers;server_id=', $server['id'], ';', $context['session_var'], '=', $context['session_id'], '">', sp_embed_image('modify'), '</a></td>
				</tr>';
	}
	echo '
			</tbody>
		</table>';
}

function template_servers_edit()
{
	global $context, $settings, $scripturl, $txt, $modSettings;

	echo '
	<div id="sp_edit_category">
		<form action="', $scripturl, '?action=admin;area=an-servers;sa=', $context['servers_action'], '" method="post" accept-charset="', $context['character_set'], '">
			<h3 class="catbg"><span class="left"></span>'
				//<a href="', $scripturl, '?action=helpadmin;help=sp-categories', ucfirst($context['category_action']), '" onclick="return reqWin(this.href);" class="help"><img src="', $settings['images_url'], '/helptopics.gif" alt="', $txt['help'], '" class="icon" /></a>
				, $context['page_title'], '
			</h3>
			<div class="windowbg2">
				<span class="topslice"><span></span></span>
				<div class="sp_content_padding">
					<dl class="sp_form">
						<dt>
							<label for="servers_name">', $txt['an-serversName'], ':</label>
						</dt>
						<dd>
							<input type="text" name="servers_name" id="servers_name" value="', !empty($context['servers_info']['name']) ? $context['servers_info']['name'] : '', '" size="20" class="input_text"/>
						</dd>
                                                <dt>
                                                    <label for="servers_banner">', $txt['an-serversBanner'] , ':</label>
                                                </dt>
                                                <dd>
                                                    <input type="text" name="servers_banner_url" id="servers_banner_url" value="', !empty($context['servers_info']['picture']['href']) ? $context['servers_info']['picture']['href'] : '', '" size="30" class="input_text"/>
                                                </dd>
                                                <dt>
                                                    <label for="servers_protect">', $txt['an-serversProtect'], ':</label>
                                                </dt>
                                                <dd>
                                                    <input type="checkbox" name="servers_protect" id="servers_protect" ', !empty($context['servers_info']['protected']) ? 'checked="checked"' : '', 'value="1" class"input_check" />
                                                </dd>
                                                <dt>
                                                    <label for="servers_private">', $txt['an-serversPrivate'], ':</label>
                                                </dt>
                                                <dd>
                                                    <input type="checkbox" name="servers_private" id="servers_private" ', !empty($context['servers_info']['private']) ? 'checked="checked"' : '', 'value="1" class"input_check" />
                                                </dd>
                                                ';
                                                if(!empty($context['servers_categories'])) {
                                                        echo '
                                                            <dt>
                                                                <label for="servers_categories">', $txt['an-serversCategory'] , ':</label>
                                                            </dt>
                                                            <dd>
                                                                <select name="servers_category" id="servers_category" > ';
                                                        foreach ($context['servers_categories'] as $cat) {
                                                                echo '<option value="', $cat['id'] , '" ', (!empty($context['servers_info']['id_category']) && $cat['id'] == $context['servers_info']['id_category']) ? 'selected="selected">' : '>' , $cat['name'] , '</option>';
                                                        }
                                                               echo'
                                                                   </select>
                                                            </dd>';
                                                }
					echo '
                                            </dl>
					<div class="sp_button_container">
						<input type="submit" name="submit" value="', $context['button_title'], '" class="button_submit" />
					</div>
				</div>
				<span class="botslice"><span></span></span>
			</div>
			<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
			<input type="hidden" name="edit_servers" value="1" />';

	if ($context['servers_action'] == 'editServers') {
		echo '
			<input type="hidden" name="server_id" value="', $context['servers_info']['id'], '" />
                ';
        }
	echo '
		</form>
	</div>';
}

?>