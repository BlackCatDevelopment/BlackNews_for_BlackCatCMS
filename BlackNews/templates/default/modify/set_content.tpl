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

		<form action="{$CAT_URL}/modules/blacknews/save.php" method="post" enctype="multipart/form-data" class="bN_content bN_form" id="bNcontent_{$section_id}">
			<input type="hidden" name="page_id" value="{$page_id}">
			<input type="hidden" name="section_id" value="{$section_id}">
			<input type="hidden" name="news_id" value="">
			<input type="hidden" name="entry_options" value="url">
			<input type="hidden" name="_cat_ajax" value="1">
			<input type="hidden" name="action" value="saveEntry">

			<input type="hidden" name="fc_form_title" value="{translate('Saving entry')}">
			<div class="bN_content_header">
				<div class="bN_row2">
					<label for="bN_title_{$section_id}" class="bN_label">{translate('Main title')}:</label>
					<input id="bN_title_{$section_id}" type="text" name="title" value="" autofocus="autofocus">
					<label for="bN_subTitle_{$section_id}" class="bN_label">{translate('Subtitle')}:</label>
					<input id="bN_subTitle_{$section_id}" type="text" name="subtitle" value="">
					<label for="bN_url_{$section_id}" class="bN_label">{translate('URL')}:</label>
					<input id="bN_url_{$section_id}" type="text" name="url" value="">
				</div>
				<div class="bN_row2">
					<button name="save" class="fc_gradient_blue fc_gradient_hover">{translate('Save')}</button>
					<button name="publish" class="fc_gradient1 fc_gradient_hover bn_icon-feed{if $entry.active} published{else} drafted{/if}" id="bNpublish_{$section_id}">
						<span class="is_published">{translate('Published')}</span>
						<span class="not_published">{translate('Unpublished')}</span>
					</button>
					<button name="delete" class="fc_gradient_red fc_gradient_hover bN_delete" id="bN_del_{$section_id}"> {translate('Delete')}</button>
				</div>
			</div>
			<button class="bn_icon-menu show_more_options fc_gradient1 fc_gradient_hover">{translate('More options')}</button>
			<div class="bN_contOpt fc_gradient1" id="bN_cOpt_{$section_id}">
					<div class="bN_row2">
						<h3>{translate('Automatic publish')}</h3>
						<label for="bN_dateStart_{$section_id}" class="bN_label">{translate('Publish on')}:</label>
						<input id="bN_dateStart_{$section_id}" type="date" name="start" value="">
						<label for="bN_dateEnd_{$section_id}" class="bN_label">{translate('Publish until')}:</label>
						<input id="bN_dateEnd_{$section_id}" type="date" name="end" value="">
					</div>
					<div class="bN_row2">
						<h3>{translate('Additional information')}</h3>
						<span class="bN_label">{translate('Category')}:</span><input type="text" id="bn_category_{$section_id}" name="category" value=""><br>
						<span class="bN_label">{translate('Image')}:</span><input type="file" name="image" accept="image/*">
					</div>
					<div class="bN_row2">
						<div class="fc_settings_max">
							<input type="checkbox" class="fc_checkbox_jq bN_short_check" name="auto_generate" id="bN_shortbutton_{$section_id}" value="1">
							<label for="bN_shortbutton_{$section_id}">{translate('Automatically generate short content...')}</label>
							<div class="bN_short_on" id="bN_short_on_{$section_id}">
							{translate('Number of characters for preview')}: <input type="text" name="auto_generate_size" value="">
							</div>
						</div>
					</div>
					<div class="bN_row2">
						<p class="bN_show_image"></p>
					</div>
					<div class="bN_short_off clear" id="bN_short_off_{$section_id}">
						<h2 class="line_before">{translate('Short content')}:</h2>
						{show_wysiwyg_editor($WYSIWYG.short,$WYSIWYG.short,'',$WYSIWYG.short_width,$WYSIWYG.short_height)}
					</div>

			</div>
			<h2 class="line_before">{translate('Full content')}:</h2>
			{show_wysiwyg_editor($WYSIWYG.long,$WYSIWYG.long,'',$WYSIWYG.long_width,$WYSIWYG.long_height)}
			<p class="bN_content_header right">
				<span class="bN_label small">{translate('Created by')}:&nbsp;</span><strong class="info_created_by small"></strong><br>
				<span class="bN_label small">{translate('Published')}:&nbsp;</span><strong class="info_published small"></strong><br>
				<span class="bN_label small">{translate('Last update')}:&nbsp;</span><strong class="info_last_update small"></strong>	
			</p>
		</form>