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

{include(modify/javascript.tpl)}
{include(modify/generalOptions.tpl)}
{include(modify/categories.tpl)}
<div id="blackNews_{$section_id}">
	{include(modify/set_skin.tpl)}
	<div class="blackNews fc_br_all">
		<aside class="bc_sidebar fc_br_left fc_gradient1">
			<button class="bc_add fc_gradient_blue fc_gradient_hover bN-icon-file-plus fc_br_topleft"> Eintrag hinzuf&uuml;gen</button>
			<ul id="blackNewsList_{$section_id}">{foreach $entries entry}{include(modify/entryList.tpl)}{/foreach}</ul>
		</aside><div class="bc_Main" class="fc_br_right fc_border_all">
			<form action="{$CAT_URL}/modules/blackNews/save.php" id="bc_Form_{$section_id}" class="bc_Form" method="post" data-entryid="16">
				{include(modify/buttons.tpl)}
				<div class="bc_MainContent">
					{include(modify/entryForm.tpl)}
				</div>
				{include(modify/buttons.tpl)}
			</form>
			<footer>Erzeugt von: <strong class="bN-icon-user bNfooterUser"> {$user}</strong> &bull; Erstellt: <strong class="bN-icon-calendar bNfooterCreated"> {$created}</strong> &bull; Letzte &Auml;nderung: <strong class="bN-icon-quill bNfooterModify"> {$modified}</strong></footer>
		</div>
	</div>
	<small class="bcVersion bN-icon-blacknews"> Modulversion: {$version}</small>
</div>