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
<div class="blacknews_all">
	<button class="button icon-plus fc_gradient_blue fc_gradient_hover left blacknews_add"> {translate('Add entry')}</button>
	<button class="button bn_icon-settings fc_gradient1 fc_gradient_hover left blacknews_options_button">{translate('General options')}</button>
	<form class="blacknews_options blacknews_form_options fc_gradient1 clear" action="{$CAT_URL}/modules/blacknews/ajax/save.php" method="post">
		<input type="hidden" name="page_id" value="{$page_id}" />
		<input type="hidden" name="section_id" value="{$section_id}" />
		<input type="hidden" name="options" value="entries_per_page,variant,permalink,rss_counter,rss_title,rss_description" />
		<input type="hidden" name="fc_form_title" value="{translate('Saving options')}" />
		<h3>{translate('Options')}</h3>
		<label for="entries_{$section_id}" class="blacknews_label">{translate('Entries per pages')}:</label>
		<input id="entries_{$section_id}" type="text" name="entries_per_page" value="{$options.entries_per_page}" /><br/>
		<label for="variant_{$section_id}" class="blacknews_label">{translate('Variant')}:</label>
		<select id="variant_{$section_id}" name="variant">
			{foreach $module_variants index variants}<option value="{$index}"{if $options.variant == $variants} selected="selected"{/if}>{$variants}</option>{/foreach}
		</select><br/>
		<label for="permalink_{$section_id}" class="blacknews_label">{translate('Permalink')}</label>
		<input id="permalink_{$section_id}" type="text" name="permalink" value="{$options.permalink}" /><br/>
		<h3>{translate('Options for RSS')}</h3>
		<label for="rss_counter_{$section_id}" class="blacknews_label">{translate('Entries in RSS file')}:</label>
		<input id="rss_counter_{$section_id}" type="text" name="rss_counter" value="{$options.rss_counter}" /><br/>
		<label for="rss_title_{$section_id}" class="blacknews_label">{translate('Title of RSS')}:</label>
		<input id="rss_title_{$section_id}" type="text" name="rss_title" value="{$options.rss_title}" /><br/>
		<label for="rss_description_{$section_id}" class="blacknews_label">{translate('Description of RSS')}:</label>
		<textarea id="rss_description_{$section_id}" name="rss_description">{$options.rss_description}</textarea>
		<button name="save" class="fc_gradient_blue fc_gradient_hover">{translate('Save options')}</button>
	</form>
	<div class="icon-search fc_gradient1 blacknew_search">
		<input type="text" name="search"  placeholder="{translate('Search')}" />
	</div>
	<div class="blacknews_container">
		<div class="blacknews_sidebar fc_gradient1">
			<ul class="blacknews_entries">
				{foreach $entries as entry}
				<li class="bn_icon-feed{if $entry.active} published{else} drafted{/if}" id="blacknews_{$section_id}_{$entry.news_id}">
					<input type="hidden" name="news_id_{$entry.news_id}" value="{$entry.news_id}" />
					<span>{$entry.title}</span>
				</li>
				{/foreach}
			</ul>
		</div>
		<form action="{$CAT_URL}/modules/blacknews/ajax/save.php" method="post" enctype="multipart/form-data" class="blacknews_content blacknews_form">
			<input type="hidden" name="page_id" value="{$page_id}" />
			<input type="hidden" name="section_id" value="{$section_id}" />
			<input type="hidden" name="news_id" value="" />
			<input type="hidden" name="entry_options" value="" />
			<input type="hidden" name="fc_form_title" value="{translate('Saving entry')}" />
			<div class="blacknews_content_header">
				<button name="save" class="fc_gradient_blue fc_gradient_hover right">{translate('Save')}</button>
				<button name="publish" class="fc_gradient1 fc_gradient_hover right bn_icon-feed{if $entry.active} published{else} drafted{/if}">
					<span class="is_published">{translate('Published')}</span>
					<span class="not_published">{translate('Unpublished')}</span>
				</button>
				<button name="delete" class="fc_gradient_red fc_gradient_hover blacknews_delete right"> {translate('Delete')}</button>

				<span class="blacknews_label">{translate('Main title')}:</span><input type="text" name="title" value="" autofocus="autofocus" /><br/>
				<span class="blacknews_label">{translate('Subtitle')}:</span><input type="text" name="subtitle" value="" />
			</div>
			<div class="blacknews_content_options">
				<button class="bn_icon-menu show_more_options fc_gradient1 fc_gradient_hover">{translate('More options')}</button>
				<div class="fc_gradient1 clear">
					<div class="zwei_spalten">
						<h2>{translate('Automatic publish')}</h2>
						<span class="blacknews_label">{translate('Publish on')}:</span><input type="text" name="start" value="" /><br/>
						<span class="blacknews_label">{translate('Publish until')}:</span><input type="text" name="end" value="" />
					</div>
					<div class="zwei_spalten">
						<h2>{translate('Additional information')}</h2>
						<span class="blacknews_label">{translate('Category')}:</span><input type="text" name="category" value="" /><br/>
						<span class="blacknews_label">{translate('Image')}:</span><input type="file" name="image" accept="image/*" />
					</div>
					<p class="clear"></p>
					<p class="blacknews_show_image right"></p>
					<div class="blacknews_content_header">
						<div class="fc_settings_max">
							<input type="checkbox" class="fc_checkbox_jq blacknews_short_check" name="auto_generate" id="blacknews_shortbutton_{$section_id}" value="1">
							<label for="blacknews_shortbutton_{$section_id}">{translate('Automatically generate short content...')}</label>
							<div class="blacknews_short_on">
								{translate('Number of characters for preview')}: <input type="text" name="auto_generate_size" value="" />
							</div>
						</div>
					</div>
					<div class="blacknews_short_off clear">
						<h2 class="line_before">{translate('Short content')}:</h2>
						{show_wysiwyg_editor($WYSIWYG.short,$WYSIWYG.short,'',$WYSIWYG.short_width,$WYSIWYG.short_height)}
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<h2 class="line_before">{translate('Full content')}:</h2>
			{show_wysiwyg_editor($WYSIWYG.long,$WYSIWYG.long,'',$WYSIWYG.long_width,$WYSIWYG.long_height)}
			<p class="blacknews_content_header right">
				<span class="blacknews_label small">{translate('Created by')}:</span><span class="info_created_by"></span><br/>
				<span class="blacknews_label small">{translate('Published')}:</span><span class="info_published"></span><br/>
				<span class="blacknews_label small">{translate('Last update')}:</span><span class="info_last_update"></span>	
			</p>
			<span class="clear"></span>
		</form>
	</div>
	<p class="small right">{translate('Version')}: {$version}</p>
</div>