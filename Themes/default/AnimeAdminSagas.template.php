<?php
// Version: 0.1; AnimeAdmin

function template_sagas_list()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
<div id="sp_manage_articles">
<form action="', $scripturl, '?action=admin;area=an-sagas;sa=listSagas" method="post" accept-charset="', $context['character_set'], '" onsubmit="return confirm(\'', $txt['sp-articlesConfirm'], '\');">
<div class="sp_align_left pagesection">
', $txt['pages'], ': ', $context['page_index'], '
</div>
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
	if (empty($context['sagas']))
	{
		echo '
					<tr class="windowbg2">
						<td class="sp_center" colspan="', count($context['columns']) + 1, '">&nbsp;</td>
					</tr>';
	}

            //Si encuentra categorías
	foreach($context['sagas'] as $sagas)
	{
		echo '
				<tr class="windowbg2">
                                        <td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-series;sa=editSeries;series_id=', $sagas['id_series'], ';', $context['session_var'], '=', $context['session_id'], '">', $sagas['SeriesName'] ,'</a></td>
					<td class="sp_center">', $sagas['name'], '</td>
                                        <td class="sp_center">', !empty($sagas['picture']['href']) ? $sagas['picture']['image'] : '', '</td>
                                        <td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-sagas;sa=stateChange;sagas_id=', $sagas['id'], ';type=Licensed;', $context['session_var'], '=', $context['session_id'], '">', empty($sagas['licensed']) ? sp_embed_image('deactive', $txt['sp-stateNo']) : sp_embed_image('active', $txt['sp-stateYes']), '</a></td>
					<td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-sagas;sa=editSagas;saga_id=', $sagas['id'], ';', $context['session_var'], '=', $context['session_id'], '">', sp_embed_image('modify'), '</a></td>
				</tr>';
	}
	echo '
			</tbody>
		</table>
<div class="sp_align_left pagesection">
', $txt['pages'], ': ', $context['page_index'], '
</div></form></div>';
}

function template_sagas_edit()
{
	global $context, $settings, $scripturl, $txt, $modSettings;

	echo '
	<div id="sp_edit_category">
		<form action="', $scripturl, '?action=admin;area=an-sagas;sa=', $context['sagas_action'], '" method="post" accept-charset="', $context['character_set'], '">
			<h3 class="catbg"><span class="left"></span>'
				//<a href="', $scripturl, '?action=helpadmin;help=sp-categories', ucfirst($context['category_action']), '" onclick="return reqWin(this.href);" class="help"><img src="', $settings['images_url'], '/helptopics.gif" alt="', $txt['help'], '" class="icon" /></a>
				, $context['page_title'], '
			</h3>
			<div class="windowbg2">
				<span class="topslice"><span></span></span>
				<div class="sp_content_padding">
					<dl class="sp_form">
						<dt>
							<label for="sagas_name">', $txt['an-sagasName'], ':</label>
						</dt>
						<dd>
							<input type="text" name="sagas_name" id="sagas_name" value="', !empty($context['sagasInfo']['name']) ? $context['sagasInfo']['name'] : '', '" size="20" class="input_text"/>
						</dd>
                                                <dt>
                                                    <label for="sagas_banner">', $txt['an-sagasBanner'] , ':</label>
                                                </dt>
                                                <dd>
                                                    <input type="text" name="sagas_banner" id="sagas_banner" value="', !empty($context['sagasInfo']['picture']['href']) ? $context['sagasInfo']['picture']['href'] : '', '" size="30" class="input_text"/>
                                                </dd>
                                                <dt>
                                                    <label for="sagas_licensed">', $txt['an-sagasLicensed'] , ':</label>
                                                </dt>
                                                <dd>
                                                     <input type="checkbox" name="licensed" id="licensed" ', !empty($context['sagasInfo']['licensed']) ? 'checked="checked"' : '', 'value="1" class"input_check" />
                                                </dd>
                                                ';
                                                if(!empty($context['seriesInfo'])) {
                                                        echo '
                                                            <dt>
                                                                <label for="seriesSelect">', $txt['an-sagasSeries'] , ':</label>
                                                            </dt>
                                                            <dd>
                                                                <select name="seriesSelect" id="seriesSelect" > ';
                                                        foreach ($context['seriesInfo'] as $ser) {
                                                                echo '<option value="', $ser['id'] , '" ', (!empty($context['sagasInfo']) && $ser['id'] == $context['sagasInfo']['id_series']) ? 'selected="selected">' : '>' , $ser['name'] , '</option>';
                                                        }
                                                               echo'
                                                                   </select>
                                                            </dd>';
                                                }
					echo '
                                              <dt>
                                                <label for="sagas_abstract">', $txt['an-sagasAbstract'], ':</label>
                                              </dt>
                                              <dd>
                                                <textarea name="sagas_abstract" rows="10" cols="50">',!empty($context['sagasInfo']['abstract']) ? $context['sagasInfo']['abstract'] : $txt['an-sagasAbstractEmpty'],'</textarea>
                                              </dd>
                                              <dt>
                                                <label for="sagas_staff">', $txt['an-sagasStaff'], ':</label>
                                              </dt>
                                              <dd>
                                                <textarea name="sagas_staff" rows="10" cols="50">',!empty($context['sagasInfo']['staff']) ? $context['sagasInfo']['staff'] : '','</textarea>
                                              </dd>
                                              <dt>
                                                <label for="sagas_abstract">', $txt['an-adminSpecsName'], ':</label>
                                              </dt>
                                              <dd></dd>';
                                                foreach ($context['specs'] as $spec) {
                                                        echo '
                                                            <dt>',$spec['picture']['image'],'</dt>
                                                            <dd>
                                                            <input type="checkbox" name="specs['.$spec['id'].']"'.((!empty($context['sagasInfo']['specs']) && !empty($context['sagasInfo']['specs'][$spec['id']])) ? 'checked=checked' : '' ).'> '.$spec['name'].'
                                                            </dd>
                                                            ';
                                                    }

                                            echo '</dl>
					<div class="sp_button_container">
						<input type="submit" name="submit" value="', $context['button_title'], '" class="button_submit" />
					</div>
				</div>
				<span class="botslice"><span></span></span>
			</div>
			<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
			<input type="hidden" name="edit_sagas" value="1" />';

	if ($context['sagas_action'] == 'editSagas') {
		echo '
			<input type="hidden" name="saga_id" value="', $context['sagasInfo']['id'], '" />
                        <input type="hidden" name="previous_series" value="', $context['sagasInfo']['id_series'], '" />
                ';
        }
	echo '
		</form>
	</div>';
}

function template_sagas_delete()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
	<div id="sp_edit_category">
		<form action="', $scripturl, '?action=admin;area=portalarticles;sa=deletecategory" method="post" accept-charset="', $context['character_set'], '">
			<h3 class="catbg"><span class="left"></span>
				<a href="', $scripturl, '?action=helpadmin;help=sp-categoriesDelete" onclick="return reqWin(this.href);" class="help"><img src="', $settings['images_url'], '/helptopics.gif" alt="', $txt['help'], '" class="icon" /></a>
				', $txt['sp-categoriesDelete'], '
			</h3>
			<div class="windowbg2">
				<span class="topslice"><span></span></span>
				<div class="sp_content_padding">
					<div class="sp_center">
					', sprintf($txt['sp-categoriesDeleteCount'], $context['category_info']['articles']), '<br />';

	if (!empty($context['list_categories']))
	{
		echo '
					', $txt['sp-categoriesDeleteOption1'], '
					</div>
					<dl class="sp_form">
						<dt>
							<label for="category_move">', $txt['sp-categoriesMove'], ':</label>
						</dt>
						<dd>
							<input type="checkbox" name="category_move" value="1" id="category_move" checked="checked" class="input_check" />
						</dd>
						<dt>
							<label for="category_move_to">', $txt['sp-categoriesMoveTo'], ':</label>
						</dt>
						<dd>
							<select id="category_move_to" name="category_move_to">';

		foreach($context['list_categories'] as $category)
		{
			if ($category['id'] != $context['category_info']['id'])
				echo '
								<option value="', $category['id'], '">', $category['name'], '</option>';
		}

							echo '
							</select>
						</dd>
					</dl>';
	}
	else
	{
		echo '
				', $txt['sp-categoriesDeleteOption2'], '
				</div>';
	}

	echo '
					<div class="sp_button_container">
						<input type="submit" name="delete_category" value="', $txt['sp-categoriesDelete'], '" onclick="return confirm(\'' . $txt['sp-categoriesDeleteConfirm'] . '\');" class="button_submit" />
					</div>
				</div>
				<span class="botslice"><span></span></span>
			</div>
			<input type="hidden" name="category_id" value="', $context['category_info']['id'], '" />
			<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
		</form>
	</div>';
}

?>