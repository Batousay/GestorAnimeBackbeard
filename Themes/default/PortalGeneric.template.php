<?php
// Version: 2.3.2; PortalGeneric

function sp_template_inline_permissions()
{
	global $context, $txt;

	echo '
		<fieldset id="permissions">
			<legend><a href="javascript:void(0);" onclick="document.getElementById(\'permissions\').style.display = \'none\';document.getElementById(\'permissions_groups_link\').style.display = \'block\'; return false;">', $txt['avatar_select_permission'], '</a></legend>
			<ul class="permission_groups">';

	foreach ($context['member_groups'] as $group)
	{
		echo '
				<li><input type="checkbox" name="member_groups[', $group['id'], ']" value="', $group['id'], '"', !empty($group['checked']) ? ' checked="checked"' : '', ' class="input_check" /> <span', $group['is_post_group'] ? ' style="font-style: italic;"' : '', '>', $group['name'], '</span></li>';
	}
	echo '
				<li><input type="checkbox" onclick="invertAll(this, this.form, \'member_groups\');" class="input_check" /> <em>', $txt['check_all'], '</em></li>
			</ul> 
		</fieldset>

		<a href="javascript:void(0);" onclick="document.getElementById(\'permissions\').style.display = \'block\'; document.getElementById(\'permissions_groups_link\').style.display = \'none\'; return false;" id="permissions_groups_link" style="display: none;">[ ', $txt['avatar_select_permission'], ' ]</a>

		<script type="text/javascript"><!-- // --><![CDATA[
			document.getElementById("permissions").style.display = "none";
			document.getElementById("permissions_groups_link").style.display = "";
		// ]]></script>';
}

?>