{**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			blacknews
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 *}

{include(modify/javascript.tpl)}

<div class="bN_all" id="bN_{$section_id}">
	{include(modify/set_skin.tpl)}
	<button class="icon-plus fc_br_top fc_gradient_blue fc_gradient_hover bN_add" id="bN_add_{$section_id}"> {translate('Add entry')}</button>
	<span class="bn_icon-settings fc_br_top fc_gradient1 fc_gradient_hover bN_options_button">{translate('General options')}</span>
	{include(modify/global_settings.tpl)}
	{*<div class="icon-search fc_gradient1 bN_search">
		<input type="text" name="search" placeholder="{translate('Search')}">
	</div>*}
	<div class="bN_container">
		<div class="bN_sidebar fc_gradient1">
			<ul class="bN_entries" id="bN_entries_{$section_id}">
				{foreach $entries as entry}{include(modify/side_entry.tpl)}{/foreach}
			</ul>
		</div>
		{include(modify/set_content.tpl)}
	</div>
	<p class="small right">{translate('Version')}: {$version}</p>
</div>