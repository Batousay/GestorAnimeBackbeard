<?php
// Version: 0.1; AnimeAdmin

function template_tutorials()
{
	global $context, $modSettings, $txt, $settings, $scripturl;

        echo '
        <h3 class="catbg"><span class="left"></span>
		', $txt['an-tutorial_title'], '
	</h3>
	<div class="windowbg2">
		<span class="topslice"><span></span></span>
			<div class="sp_content_padding" id="sp_credits">
                        ', $txt['an-tutorialsMessage'], '</div>
		<span class="botslice"><span></span></span>
	</div>';                   
}

function template_information()
{
	global $context, $txt;

        //Information, Left
	echo '
	<div id="sp_admin_main">
		<div id="sp_live_info" class="sp_float_left">
	<h3 class="catbg"><span class="left"></span>
		', $txt['an-info_title'], '
	</h3>
	<div class="windowbg2">
		<span class="topslice"><span></span></span>
			<div class="sp_content_padding" id="sp_credits">';

	foreach ($context['an_credits'] as $section)
	{
		if (isset($section['pretext']))
			echo '
				<p>', $section['pretext'], '</p>';

		foreach ($section['groups'] as $group)
		{
			if (empty($group['members']))
				continue;

			echo '
				<p>';

			if (isset($group['title']))
				echo '
					<strong>', $group['title'], ':</strong> ';

			echo implode(', ', $group['members']), '
				</p>';
		}


		if (isset($section['posttext']))
			echo '
				<p>', $section['posttext'], '</p>';
	}

	echo '
				<hr />
                                <p>', sprintf($txt['an-info_contribute'], 'http://www.batousay.com'), '</p>
			</div>
		<span class="botslice"><span></span></span>
	</div>
        </div>';

        //Version, right
echo '
<div id="sp_general_info" class="sp_float_right">
			<h3 class="catbg"><span class="left"></span>
				', $txt['an-info_general'], '
			</h3>
			<div class="windowbg2">
				<span class="topslice"><span></span></span>
				<div class="sp_content_padding">
					<strong>', $txt['an-info_versions'], ':</strong><br />
					', $txt['an-info_your_version'], ':
					<em id="spYourVersion" style="white-space: nowrap;">', $context['an_version'], '</em><br />
				</div>
				<span class="botslice"><span></span></span>
			</div>
		</div>



        </div>';
}

?>