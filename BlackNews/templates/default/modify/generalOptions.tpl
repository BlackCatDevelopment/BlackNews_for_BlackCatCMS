{*
 *
 * ,-----.  ,--.              ,--.    ,-----.          ,--.       ,-----.,--.   ,--. ,---.
 * |  |) /_ |  | ,--,--. ,---.|  |,-.'  .--./ ,--,--.,-'  '-.    '  .--./|   `.'   |'   .-'
 * |  .-.  \|  |' ,-.  || .--'|     /|  |    ' ,-.  |'-.  .-'    |  |    |  |'.'|  |`.  `-.
 * |  '--' /|  |\ '-'  |\ `--.|  \  \'  '--'\\ '-'  |  |  |      '  '--'\|  |   |  |.-'    |
 * `------' `--' `--`--' `---'`--'`--'`-----' `--`--'  `--'       `-----'`--'   `--'`-----'
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author			Matthias Glienke
 *   @copyright		2022, Black Cat Development
 *   @link				https://github.com/BlackCatDevelopment/BlackNews_for_BlackCatCMS
 *   @license			https://www.gnu.org/licenses/gpl-3.0.html
 *   @category		CAT_Modules
 *   @package			blackNews
 *
*}

<button class="fc_gradient1 fc_gradient_hover icon-cog left fc_br_top bn_gOpt" id="bn_gOpt_{$section_id}"> {translate("General options")}</button>
<form action="{$CAT_URL}/modules/blackNews/save.php" id="bc_Options_{$section_id}" method="post" data-bnid="" class="bn_optionForm fc_shadow_big">
	<input type="hidden" name="page_id" value="{$page_id}">
	<input type="hidden" name="section_id" value="{$section_id}">
    <input type="hidden" name="action" value="saveOptions">
    
	<input type="hidden" name="saveOptions" value="permalink,text|usergroup,select|title,text|subtitle,text">

	<h3>{translate("General options")}</h3>
    <hr>
	<p>
		<label for="permalink_{$section_id}" class="bcLabel">{translate("Permalink")}:</label>
		<input id="permalink_{$section_id}" type="text" name="permalink" value="{if $options.permalink}{$options.permalink}{/if}">
	</p>
<p>
    <label for="mainTitle_{$section_id}" class="bcLabel">{translate("Title")}:</label>
    <input id="mainTitle_{$section_id}" type="text" name="title" value="{if $options.title}{$options.title}{/if}"><br>
    <label for="mainSubTitle_{$section_id}" class="bcLabel">{translate("Subtitle")}:</label>
    <input id="mainSubTitle_{$section_id}" type="text" name="subtitle" value="{if $options.subtitle}{$options.subtitle}{/if}">
</p>
	<p>
		<label for="usergroup_{$section_id}" class="bcLabel">{translate("Usergroup of editors")}:</label>
		<select id="usergroup_{$section_id}" name="usergroup">
			{foreach $usergroups k v}
			<option value="{$k}"{if $options.usergroup==$k} selected="selected"{/if}>{$v}</option>
			{/foreach}
		</select>
	</p>

	<button name="save" class="fc_gradient_blue fc_gradient_hover" id="saveOption_{$section_id}">{translate("Save options")}</button>
</form>