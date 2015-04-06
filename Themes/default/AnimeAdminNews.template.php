<?php
// Version: 0.1; AnimeAdmin

function template_news_list()
{
	global $context, $settings, $options, $scripturl, $txt, $editorOptions;

	echo '
<div id="sp_manage_articles">
<form action="', $scripturl, '?action=admin;area=an-news;sa=listNews" method="post" accept-charset="', $context['character_set'], '" onsubmit="return confirm(\'', $txt['sp-articlesConfirm'], '\');">
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
	if (empty($context['news']))
	{
		echo '
					<tr class="windowbg2">
						<td class="sp_center" colspan="', count($context['columns']) + 1, '">&nbsp;</td>
					</tr>';
	}

            //Si encuentra categorías
	foreach($context['news'] as $news)
	{

            $first = reset($news['chapters']);
            $first = $first['number'];
            $last = end($news['chapters']);
            $last = $last['number'];
		echo '
				<tr class="windowbg2">
                                        <td class="sp_center">', $news['category'],'</td>
                                        <td class="sp_center">', $news['serie'],'</td>
					<td class="sp_center">', $news['saga'], '</td>
                                        <td class="sp_center"><a href="',$scripturl,'?topic=',$news['id_msg'],'.0">'.(($first == $last) ? $first : ($first . " - " . $last)) .'</a></td>
      					<td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-news;sa=editNews;news_id=', $news['id'], ';', $context['session_var'], '=', $context['session_id'], '">', sp_embed_image('modify'), '</a></td>
				</tr>';
	}
	echo '
			</tbody>
		</table>
<div class="sp_align_left pagesection">
', $txt['pages'], ': ', $context['page_index'], '
</div></form></div>';
}

function template_news_last()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
<div id="sp_manage_articles">
<form action="', $scripturl, '?action=admin;area=an-news;sa=listNews" method="post" accept-charset="', $context['character_set'], '" onsubmit="return confirm(\'', $txt['sp-articlesConfirm'], '\');">
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
	if (empty($context['news']))
	{
		echo '
					<tr class="windowbg2">
						<td class="sp_center" colspan="', count($context['columns']) + 1, '">&nbsp;</td>
					</tr>';
	}

            //Si encuentra categorías
	foreach($context['news'] as $news)
	{

            $first = reset($news['chapters']);
            $first = $first['number'];
            $last = end($news['chapters']);
            $last = $last['number'];
		echo '
				<tr class="windowbg2">
                                        <td class="sp_center">', $news['category'],'</td>
                                        <td class="sp_center">', $news['serie'],'</td>
					<td class="sp_center">', $news['saga'], '</td>
                                        <td class="sp_center"><a href="',$scripturl,'?topic=',$news['id_msg'],'.0">'.(($first == $last) ? $first : ($first . " - " . $last)) .'</a></td>
      					<td class="sp_center"><a href="', $scripturl, '?action=admin;area=an-news;sa=editNews;news_id=', $news['id'], ';', $context['session_var'], '=', $context['session_id'], '">', sp_embed_image('modify'), '</a></td>
				</tr>';
	}
	echo '
			</tbody>
		</table>
</form></div>';
}

function template_news_edit() {
    global $context, $settings, $scripturl, $txt, $modSettings;

    echo '
	<div id="sp_edit_category">
		<form action="', $scripturl, '?action=admin;area=an-news;sa=', $context['news_action'], '" method="post" accept-charset="', $context['character_set'], '">
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
                                                                echo '<option value="', $cat['id'] , '"', (!empty($context['news']['id_category']) && $cat['id'] == $context['news']['id_category']) ? ' selected="selected">' : '>' , $cat['name'] , '</option>';
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
                                                                echo '<option value="', $ser['id'] , '" ', (!empty($context['news']['id_serie']) && $ser['id'] == $context['news']['id_serie']) ? 'selected="selected">' : '>' , $ser['name'] , '</option>';
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
                                                                echo '<option value="', $sag['id'] , '" ', (!empty($context['news']['id_saga']) && $sag['id'] == $context['news']['id_saga']) ? 'selected="selected">' : '>' , $sag['name'] , '</option>';
                                                        }
                                                               echo'
                                                                   </select>
                                                            </dd>';
                                                }else{
                                                if(empty($context['categories']) && empty($context['series']) && empty($context['sagas']) && !empty($context['news']['id_category']) && !empty($context['news']['id_serie']) && !empty($context['news']['id_saga'])) {
                                                    
                                                    $editorOptions = array(
                                                        'id' => $context['post_box_name'],
                                                        'value' => !empty($context['news']['text']) ? $context['news']['text'] : $txt['an-newsTextEmpty'],
                                                    );
                                                    
                                                    create_control_richedit($editorOptions); 
                                                    
                                                    echo '
                                                        <dt>
                                                            <label for="text">', $txt['an-adminNewsText'] , ':</label>
                                                        </dt>
                                                        <dd>
                                                            <div id="bbc"></div><br/><div id="smileys" style="width:650px;"></div>';
                                                     
                                                    template_control_richedit($context['post_box_name'], 'bbc', 'smileys');
                                                     
                                                     echo '</dd>';
                                                     
                                                    if(!empty($context['chapters'])) {
                                                       echo '<dt>'.$txt['an-UnpublishedChapters'].':</dt>' ;

                                                    foreach ($context['chapters'] as $chapt) {
                                                        echo '
                                                            <dt></dt>
                                                            <dd>
                                                            <input type="checkbox" name="chapters['.$chapt['id'].']"'.((!empty($context['news']['id']) && !empty($chapt['id_download']) && $context['news']['id'] == $chapt['id_download']) ? 'checked=checked' : '' ).'> '.$chapt['number']. " - ".$chapt['title'].'
                                                            </dd>
                                                            ';
                                                    }
                                                    }else{
                                                        echo $txt['an-adminErrorAddingNewsNoChapters'];
                                                    }
                                                        echo '
                                                        <input type="hidden" name="edit_news" value="1" />';
                                                }else {
                                                    echo $txt['an-adminErrorAddingNews'];
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
        if(!empty($context['news']['Nid_category'])) {
            echo '
                <input type="hidden" name="category_id" value="', $context['news']['Nid_category'], '"/>
                ';
        }
        if(!empty($context['news']['Nid_series'])) {
            echo '
                <input type="hidden" name="series_id" value="', $context['news']['Nid_series'], '"/>
                ';
        }
        if(!empty($context['news']['Nid_sagas'])) {
            echo '
                <input type="hidden" name="sagas_id" value="', $context['news']['Nid_sagas'], '"/>
                ';
        }
	if ($context['news_action'] == 'editNews') {
		echo '
			<input type="hidden" name="news_id" value="', $context['news']['id'], '"/>
                ';
        }
	echo '
		</form>
	</div>';
}

?>