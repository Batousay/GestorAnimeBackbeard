<?php
// Version: 0.1; AnimeAdmin

function template_unpublished_chapters_list()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
<div id="sp_manage_articles">
<form action="', $scripturl, '?action=admin;area=an-chapters;sa=listUnpublishedChapters" method="post" accept-charset="', $context['character_set'], '" onsubmit="return confirm(\'', $txt['sp-articlesConfirm'], '\');">
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
	if (empty($context['chapters']))
	{
		echo '
					<tr class="windowbg2">
						<td class="sp_center" colspan="', count($context['columns']) + 1, '">&nbsp;</td>
					</tr>';
	}

            //Si encuentra categorías
	foreach($context['chapters'] as $chap)
	{
		echo '
				<tr class="windowbg2">
                                        <td class="sp_center">', $chap['category'],'</td>
                                        <td class="sp_center">', $chap['serie'],'</td>
					<td class="sp_center">', $chap['saga'], '</td>
                                        <td class="sp_center"><a href="',$chap['topicurl'],'">', $chap['number'], '</a></td>
					<td class="sp_center"><a href="',$chap['topicurl'],'">', $chap['title'], '</a></td>
					<td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-chapters;sa=editChapters;chapter_id=', $chap['id'], ';', $context['session_var'], '=', $context['session_id'], '">', sp_embed_image('modify'), '</a></td>
				</tr>';
	}
	echo '
			</tbody>
		</table>
<div class="sp_align_left pagesection">
', $txt['pages'], ': ', $context['page_index'], '
</div></form></div>';
}

function template_chapters_list()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
<div id="sp_manage_articles">
<form action="', $scripturl, '?action=admin;area=an-chapters;sa=listChapters" method="post" accept-charset="', $context['character_set'], '" onsubmit="return confirm(\'', $txt['sp-articlesConfirm'], '\');">
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
	if (empty($context['chapters']))
	{
		echo '
					<tr class="windowbg2">
						<td class="sp_center" colspan="', count($context['columns']) + 1, '">&nbsp;</td>
					</tr>';
	}

            //Si encuentra categorías
	foreach($context['chapters'] as $chap)
	{
		echo '
				<tr class="windowbg2">
                                        <td class="sp_center">', $chap['category'],'</td>
                                        <td class="sp_center">', $chap['serie'],'</td>
					<td class="sp_center">', $chap['saga'], '</td>
                                        <td class="sp_center"><a href="',$chap['topicurl'],'">', $chap['number'], '</a></td>
					<td class="sp_center"><a href="',$chap['topicurl'],'">', $chap['title'], '</a></td>
					<td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-chapters;sa=editChapters;chapter_id=', $chap['id'], ';', $context['session_var'], '=', $context['session_id'], '">', sp_embed_image('modify'), '</a></td>
				</tr>';
	}
	echo '
			</tbody>
		</table>
<div class="sp_align_left pagesection">
', $txt['pages'], ': ', $context['page_index'], '
</div></form></div>';
}

function template_chapters_edit() {
    global $context, $settings, $scripturl, $txt, $modSettings;

    echo '
	<div id="sp_edit_category">
		<form action="', $scripturl, '?action=admin;area=an-chapters;sa=', $context['chapters_action'], '" method="post" accept-charset="', $context['character_set'], '">
			<h3 class="catbg"><span class="left"></span>'
				//<a href="', $scripturl, '?action=helpadmin;help=sp-categories', ucfirst($context['category_action']), '" onclick="return reqWin(this.href);" class="help"><img src="', $settings['images_url'], '/helptopics.gif" alt="', $txt['help'], '" class="icon" /></a>
				, $context['page_title'], '
			</h3>
			<div class="windowbg2">
				<span class="topslice"><span></span></span>
				<div class="sp_content_padding">
					<dl class="sp_form">
						';
                                                if(!empty($context['categories'])) {
                                                        echo '
                                                            <dt>
                                                                <label for="category">', $txt['an-adminChaptersCategory'] , ':</label>
                                                            </dt>
                                                            <dd>
                                                                <select name="category_id" id="category_id" > ';
                                                        foreach ($context['categories'] as $cat) {
                                                                echo '<option value="', $cat['id'] , '"', (!empty($context['chapter']['id_category']) && $cat['id'] == $context['chapter']['id_category']) ? ' selected="selected">' : '>' , $cat['name'] , '</option>';
                                                        }
                                                               echo'
                                                                   </select>
                                                            </dd>';
                                                }else{
                                                if(!empty($context['series'])) {
                                                    echo '
                                                            <dt>
                                                                <label for="series">', $txt['an-adminChaptersSeries'] , ':</label>
                                                            </dt>
                                                            <dd>
                                                                <select name="series_id" id="series_id" > ';
                                                        foreach ($context['series'] as $ser) {
                                                                echo '<option value="', $ser['id'] , '" ', (!empty($context['chapter']['id_serie']) && $ser['id'] == $context['chapter']['id_serie']) ? 'selected="selected">' : '>' , $ser['name'] , '</option>';
                                                        }
                                                               echo'
                                                                   </select>
                                                            </dd>';
                                                }else{
                                                if(!empty($context['sagas'])) {
                                                    echo '
                                                            <dt>
                                                                <label for="sagas">', $txt['an-adminChaptersSagas'] , ':</label>
                                                            </dt>
                                                            <dd>
                                                                <select name="sagas_id" id="sagas_id" > ';
                                                        foreach ($context['sagas'] as $sag) {
                                                                echo '<option value="', $sag['id'] , '" ', (!empty($context['chapter']['id_saga']) && $sag['id'] == $context['chapter']['id_saga']) ? 'selected="selected">' : '>' , $sag['name'] , '</option>';
                                                        }
                                                               echo'
                                                                   </select>
                                                            </dd>';
                                                }else{
                                                if(empty($context['categories']) && empty($context['series']) && empty($context['sagas']) && !empty($context['chapter']['id_category']) && !empty($context['chapter']['id_serie']) && !empty($context['chapter']['id_saga'])) {
                                                    echo '
                                                        <dt>
                                                            <label for="number">', $txt['an-adminChapterNumber'] , ':</label>
                                                        </dt>
                                                        <dd>
                                                            <input type="text" name="number" id="number" value="', !empty($context['chapter']['number']) ? $context['chapter']['number'] : '', '" size="10" class="input_text"/>
                                                        </dd>

                                                        <dt>
                                                            <label for="double">', $txt['an-adminChapterDouble'], ':</label>
                                                        </dt>
                                                        <dd>
                                                            <input type="checkbox" name="double" id="double" ', !empty($context['chapter']['double']) ? 'checked="checked"' : '', 'value="1" class"input_check" />
                                                        </dd>
                                                        
                                                        <dt>
                                                            <label for="title">', $txt['an-adminChapterTitle'] , ':</label>
                                                        </dt>
                                                        <dd>
                                                            <input type="text" name="title" id="title" value="', !empty($context['chapter']['title']) ? $context['chapter']['title'] : '', '" size="40" class="input_text"/>
                                                        </dd>

                                                        <dt>
                                                            <label for="capturas">', $txt['an-adminChapterCaptures'] , ':</label>
                                                        </dt>
                                                        ';

                                                    if(!empty($context['chapter']['captures'])) {
                                                    foreach ($context['chapter']['captures'] as $capt) {
                                                        echo '
                                                            <dt>
                                                            '. $capt['image'] .'
                                                            </dt>
                                                            <dd>
                                                                <input type="text" name="capture[ ]" id="title" value="', $capt['href'], '" size="40" class="input_text"/>
                                                            </dd>
                                                            ';
                                                    }
                                                    }
                                                    if(empty($context['chapter']['captures']) || sizeof($context['chapter']['captures']) < 3) {
                                                        for($i = (empty($context['chapter']['captures'])) ? 0 : sizeof($context['chapter']['captures']); $i < 3; $i++) {
                                                            echo '
                                                                <dt>
                                                                <label for="capture">', $i , ':</label>
                                                                </dt>
                                                                <dd>
                                                                <input type="text" name="capture[ ]" id="title" value="" size="40" class="input_text"/>
                                                                </dd>
                                                                ';
                                                        }
                                                    }
                                                    echo '
                                                        <dt>
                                                            <label for="enlaces">', $txt['an-adminChaptersPrivateLinks'] , ':</label>
                                                        </dt>
                                                        ';
                                                    foreach($context['chapter']['links']['private'] as $priv) {
                                                        echo '
                                                            <dt>
                                                            <img src="' . $priv['logo'] .'" width="25" /><label for="link">', $priv['name'] , ':</label>
                                                            </dt>
                                                            <dd>
                                                            <input type="text" name="private['. $priv['name'] .']" id="title" value="', !empty($priv['href']) ? $priv['href'] : '', '" size="40" class="input_text"/>
                                                            </dd>
                                                            ';
                                                    }
                                                    echo '
                                                        <dt>
                                                            <label for="enlaces">', $txt['an-adminChaptersPublicLinks'] , ':</label>
                                                        </dt>
                                                        ';
                                                    foreach($context['chapter']['links']['public'] as $pub) {
                                                        echo '
                                                            <dt>
                                                            <img src="' . $pub['logo'] .'" width="25" /><label for="link">', $pub['name'] , ':</label>
                                                            </dt>
                                                            <dd>
                                                            <input type="text" name="public['. $pub['name'] .']" id="title" value="', !empty($pub['href']) ? $pub['href'] : '', '" size="40" class="input_text"/>
                                                            </dd>
                                                            ';
                                                    }

                                                        echo '
                                                        <input type="hidden" name="edit_chapter" value="1" />';
                                                }else {
                                                    echo $txt['an-adminErrorAddingChapter'];
                                                    }
                                                }
                                                }
                                                }
					echo '
                                            </dl>
					<div class="sp_button_container">
						<input type="submit" name="submit" value="', $context['button_title'], '" class="button_submit" />
					</div>
				</div>
				<span class="botslice"><span></span></span>
			</div>
			<input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '"/>
			';
        if(!empty($context['chapter']['Nid_category'])) {
            echo '
                <input type="hidden" name="category_id" value="', $context['chapter']['Nid_category'], '"/>
                ';
        }
        if(!empty($context['chapter']['Nid_series'])) {
            echo '
                <input type="hidden" name="series_id" value="', $context['chapter']['Nid_series'], '"/>
                ';
        }
        if(!empty($context['chapter']['Nid_sagas'])) {
            echo '
                <input type="hidden" name="sagas_id" value="', $context['chapter']['Nid_sagas'], '"/>
                ';
        }
	if ($context['chapters_action'] == 'editChapters') {
		echo '
			<input type="hidden" name="chapter_id" value="', $context['chapter']['id'], '"/>
                ';
        }
	echo '
		</form>
	</div>';
}

?>