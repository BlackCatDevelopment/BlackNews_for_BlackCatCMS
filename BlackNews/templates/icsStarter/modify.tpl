{*
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
 *   @copyright			2018, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			blackNews
 *
*}

{include(../default/modify/javascript.tpl)}
<div id="blackNews_{$section_id}">
	{include(../default/modify/set_skin.tpl)}
	<div class="blackNews fc_br_all">
		<form action="{$CAT_URL}/modules/blackNews/save.php" id="bc_Options_{$section_id}" method="post" data-bnid="">
			<input type="hidden" name="page_id" value="{$page_id}">
			<input type="hidden" name="section_id" value="{$section_id}">
			<input type="hidden" name="saveOptions" value="newsCount|setNews|title|sub_title|category|linkCategory">

			<h3>Überschriften</h3>
			<p>
				<label for="title_{$section_id}">Titel:</label>
				<input id="title_{$section_id}" name="title" type="text" class="cc_In300px" value="{if $options.title}{$options.title}{/if}">
			</p>
			<p>
				<label for="sub_title_{$section_id}">Untertitel:</label>
				<input id="sub_title_{$section_id}" name="sub_title" type="text" class="cc_In300px" value="{if $options.sub_title}{$options.sub_title}{/if}">
			</p>

			<h3>Optionen für einzubindende News</h3>
			<p>
				<label for="newsCount_{$section_id}">Anzahl der einzubindenden News:</label>
				<input id="newsCount_{$section_id}" name="newsCount" type="number" value="{if $options.newsCount}{$options.newsCount}{/if}">
			</p>
			<p>
				<label for="setNews_{$section_id}">Sektion der Newsseite:</label>
				<input id="setNews_{$section_id}" name="setNews" type="number" value="{if $options.setNews}{$options.setNews}{/if}">
			</p>
			<p>
				<label for="newsCategory_{$section_id}">Kategorie (optional):</label>

				<select name="category" id="newsCategory_{$section_id}">
					<option value="0"{if $options.category == 0}selected="selected"{/if}>Alle</option>
					{foreach $categories c}
					<option value="{$c.catID}" {if $options.category == $c.catID}selected="selected"{/if}>{$c.category}</option>
					{/foreach}
				</select>
			</p>
			{*<select name="setNews" id=="setNews_{$section_id}">
				<option value="0" >disabled</option>
				<option value="1" {if $options.setNews == 1}selected="selected"{/if}>lorem</option>
			</select>*}
			
			<button name="save" class="fc_gradient_blue fc_gradient_hover" id="saveOption_{$section_id}">{translate('Save options')}</button>
		</form>
	</div>
	<small class="bcVersion">Modulversion: {$version}</small>
</div>