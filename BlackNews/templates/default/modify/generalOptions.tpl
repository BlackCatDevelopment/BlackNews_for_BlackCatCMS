{**
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
 *   @copyright			2017, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			blacknews
 *
 *}

<button class="fc_gradient1 fc_gradient_hover icon-cog left fc_br_top bn_gOpt" id="bn_gOpt_{$section_id}"> Allgemeine Einstellung</button>
<form action="{$CAT_URL}/modules/blackNews/save.php" id="bc_Options_{$section_id}" method="post" data-bnid="" class="bn_optionForm fc_shadow_big">
	<input type="hidden" name="page_id" value="{$page_id}">
	<input type="hidden" name="section_id" value="{$section_id}">
	<input type="hidden" name="saveOptions" value="permalink,text">

	<h3>General options</h3>
	<label for="permalink_{$section_id}" class="bcLabel">Permalink</label><input id="permalink_{$section_id}" type="text" name="permalink" value="{$options.permalink}"><br>
	<button name="save" class="fc_gradient_blue fc_gradient_hover" id="saveOption_{$section_id}">Save options</button>
</form>