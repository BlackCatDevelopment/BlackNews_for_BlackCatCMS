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
 *   along with this program; if not, see <http://www.gnu.org/licenses>.
 *
 *   @author			Matthias Glienke
 *   @copyright			2014, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			catGallery
 *
 *}


<form class="bN_options fc_gradient1 ajaxForm" action="{$CAT_URL}/modules/blacknews/save.php" method="post" id="bN_form_{$section_id}">
	<div class="bN_row2">
		<h3>{translate('General options')}</h3>
		<label for="entries_{$section_id}" class="bN_label">{translate('Entries per pages')}:</label>
		<input id="entries_{$section_id}" type="text" name="entries_per_page" value="{$options.entries_per_page}" ><br>
		<label for="permalink_{$section_id}" class="bN_label">{translate('Permalink')}</label>
		<input id="permalink_{$section_id}" type="text" name="permalink" value="{$options.permalink}" ><br>
	</div>
	<div class="bN_row2">
		<h3>{translate('Options for RSS')}</h3>
		<label for="rss_counter_{$section_id}" class="bN_label">{translate('Entries in RSS file')}:</label>
		<input id="rss_counter_{$section_id}" type="text" name="rss_counter" value="{$options.rss_counter}" ><br>
		<label for="rss_title_{$section_id}" class="bN_label">{translate('Title of RSS')}:</label>
		<input id="rss_title_{$section_id}" type="text" name="rss_title" value="{$options.rss_title}" ><br>
		<label for="rss_description_{$section_id}" class="bN_label">{translate('Description of RSS')}:</label>
		<textarea id="rss_description_{$section_id}" rows="5" cols="49" name="rss_description">{$options.rss_description}</textarea>
	</div>
	<input type="hidden" name="page_id" value="{$page_id}" >
	<input type="hidden" name="section_id" value="{$section_id}" >
	<input type="hidden" name="action" value="saveOptions">
	<input type="hidden" name="_cat_ajax" value="1">
	<input type="hidden" name="options" value="entries_per_page,permalink,rss_counter,rss_title,rss_description" >
	<input type="hidden" name="fc_form_title" value="{translate('Saving options')}" >
	<button name="save" class="fc_gradient_blue fc_gradient_hover">{translate('Save options')}</button>
	<input type="reset" name="reset" class="bN_close" value="{translate('Close')}">
</form>
