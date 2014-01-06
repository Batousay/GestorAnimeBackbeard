<?php
// Version: 0.1; AnimeAdmin

function template_maintenance_list()
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
	if (empty($context['news'])&& empty($context['series']) && empty($context['sagas']) && empty($context['chapters']) && empty($context['captures']))
	{
		echo '
					<tr class="windowbg2">
						<td class="sp_center" colspan="', count($context['columns']) + 1, '">&nbsp;</td>
					</tr>';
	}
            //Si encuentra categorías
        if (!empty($context['news'])) {
        foreach ($context['news'] as $new) {
            echo '
				<tr class="windowbg2">
					<td class="sp_center">', $new['id'], '</td>
					<td class="sp_center">', $new['serie'], '</td>
                                        <td class="sp_center">', $new['saga'], '</td>
                                        <td class="sp_center">';
            foreach ($new['chapters'] as $chap) {
                echo $chap['number'] . ',';
            }
            echo '</td>
					<td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-maintenance;sa=newsRegenerate;news_id=', $new['id'], ';', $context['session_var'], '=', $context['session_id'], '">', sp_embed_image('modify'), '</a><a href="', $scripturl, '?action=admin;area=an-maintenance;sa=newsDelete;news_id=', $new['id'], ';', $context['session_var'], '=', $context['session_id'], '"  onclick="return confirm(\'' . $txt['an-newsDeleteConfirm'] . '\');">', sp_embed_image('delete'), '</a></td>
				</tr>';
        }
        }

        if(!empty($context['series'])) {
        foreach($context['series'] as $ser)
	{
		echo '
				<tr class="windowbg2">
					<td class="sp_center">', $ser['id'], '</td>
					<td class="sp_center">', $ser['name'], '</td>
                                        <td class="sp_center">', !empty($ser['picture']['image']) ? $ser['picture']['image'] : '', '</td>
					<td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-maintenance;sa=seriesRegenerate;serie_id=', $ser['id'], ';', $context['session_var'], '=', $context['session_id'], '">', sp_embed_image('modify'), '</a><a href="', $scripturl, '?action=admin;area=an-maintenance;sa=seriesDelete;serie_id=', $ser['id'], ';', $context['session_var'], '=', $context['session_id'], '"  onclick="return confirm(\'' . $txt['an-seriesDeleteConfirm'] . '\');">', sp_embed_image('delete'), '</a></td>
				</tr>';
	}
        }

        if(!empty($context['sagas'])) {
        foreach($context['sagas'] as $saga)
	{
		echo '
				<tr class="windowbg2">
					<td class="sp_center">', $saga['id'], '</td>
					<td class="sp_center">', $saga['SeriesName'], '</td>
                                        <td class="sp_center">', $saga['name'], '</td>
                                        <td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-maintenance;sa=sagasRegenerate;saga_id=', $saga['id'], ';', $context['session_var'], '=', $context['session_id'], '">', sp_embed_image('modify'), '</a><a href="', $scripturl, '?action=admin;area=an-maintenance;sa=sagasDelete;saga_id=', $saga['id'], ';', $context['session_var'], '=', $context['session_id'], '"  onclick="return confirm(\'' . $txt['an-sagasDeleteConfirm'] . '\');">', sp_embed_image('delete'), '</a></td>
				</tr>';
	}
        }

        if(!empty($context['chapters'])) {
        foreach($context['chapters'] as $chap)
	{
		echo '
				<tr class="windowbg2">
					<td class="sp_center">', $chap['id'], '</td>
					<td class="sp_center">', $chap['serie'], '</td>
                                        <td class="sp_center">', $chap['saga'], '</td>
                                        <td class="sp_center">', $chap['number'], '</td>
                                        <td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-maintenance;sa=chaptersRegenerate;chapter_id=', $chap['id'], ';', $context['session_var'], '=', $context['session_id'], '">', sp_embed_image('modify'), '</a><a href="', $scripturl, '?action=admin;area=an-maintenance;sa=chaptersDelete;chapter_id=', $chap['id'], ';', $context['session_var'], '=', $context['session_id'], '"  onclick="return confirm(\'' . $txt['an-chapterDeleteConfirm'] . '\');">', sp_embed_image('delete'), '</a></td>
				</tr>';
	}
        }

	echo '
			</tbody>
		</table>';
}

function template_maintenance_other()
{
	global $context, $settings, $options, $scripturl, $txt;

        echo '
         <div id="fatal_error">
		<div class="cat_bar">
			<h3 class="catbg">',
                            $txt['an-adminMessage']
			,'</h3>
		</div>

		<div class="windowbg">
			<span class="topslice"><span></span></span>
			<div class="padding">',$context['an-message'],'</div>
			<span class="botslice"><span></span></span>
		</div>
	</div>';

}

?>