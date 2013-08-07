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
	<div class="blacknews_options fc_gradient1 clear">
		<h3>{translate('Options')}</h3>
		<span class="blacknews_label">{translate('Entries per pages')}:</span><input type="text" name="entries_per_page" value="{$options.entries_per_page}" /><br/>
		<span class="blacknews_label">{translate('Variant')}:</span>
		<select name="variant">
			{foreach $variants as variant}<option value="{$variant}"{if $options.variant == $variant} selected="selected"{/if}>{$variant}</option>{/foreach}
		</select>
	</div>
	<div class="icon-search fc_gradient1 blacknew_search">
		<input type="text" name="search"  placeholder="{translate('Search')}" />
	</div>
	<div class="blacknews_container">
		<div class="blacknews_sidebar fc_gradient1">
			<ul class="blacknews_entries">
				{foreach $entries as entry}
				<li class="bn_icon-feed{if $entry.active} published{else} drafted{/if}">
					<input type="hidden" name="news_id_{$entry.news_id}" value="{$entry.news_id}" />
					<span>{$entry.title}</span>
				</li>
				{/foreach}
			</ul>
		</div>
		<form action="{$CAT_URL}/modules/blacknews/save.php" method="post" enctype="multipart/form-data" class="blacknews_content blacknews_form">
			<input type="hidden" name="page_id" value="{$page_id}" />
			<input type="hidden" name="section_id" value="{$section_id}" />
			<input type="hidden" name="id" value="" />
			<div class="blacknews_content_header">
				<button name="save" class="fc_gradient_blue fc_gradient_hover right">{translate('Save')}</button><br/>
				<button name="publish" class="clear fc_gradient1 fc_gradient_hover right bn_icon-feed{if $entry.active} published{else} drafted{/if}">
					<span class="is_published">{translate('Published')}</span>
					<span class="not_published">{translate('Unpublished')}</span>
				</button>
				<span class="blacknews_label">{translate('Main title')}:</span><input type="text" name="title" value="" autofocus="autofocus" /><br/>
				<span class="blacknews_label">{translate('Subtitle')}:</span><input type="text" name="subtitle" value="" />
			</div>
			<div class="blacknews_content_options">
				<button class="bn_icon-menu show_more_options fc_gradient1 fc_gradient_hover"> {translate('More options')}</button>
				<div class="fc_gradient1 clear">
					<div>
						<h2>{translate('Additional information')}</h2>
						<span class="blacknews_label">{translate('Category')}:</span><input type="text" name="category" value="" /><br/>
						<span class="blacknews_label">{translate('Image')}:</span><input type="file" name="image" accept="image/*" />
					</div>
					<div>
						<h2>{translate('Automatic publish')}</h2>
						<span class="blacknews_label">{translate('Publish on')}:</span><input type="text" name="start" value="" /><br/>
						<span class="blacknews_label">{translate('Publish until')}:</span><input type="text" name="end" value="" />
					</div>
					<p class="clear"></p>
				</div>
			</div>
			<h2 class="line_before">{translate('Full content')}:</h2>
			{show_wysiwyg_editor($WYSIWYG.long,$WYSIWYG.long,'',$WYSIWYG.long_width,$WYSIWYG.long_height)}
			<div class="blacknews_content_header clear">
				<div class="fc_settings_max">
					<input type="checkbox" class="fc_checkbox_jq blacknews_short_check" name="auto_generate" id="blacknews_shortbutton_{$section_id}" value="1">
					<label for="blacknews_shortbutton_{$section_id}">{translate('Automatically generate short content...')}</label>
					<div class="blacknews_short_on">
						{translate('Number of characters for preview')}: <input type="text" name="auto_generate_size" value="" />
					</div>
				</div>
			</div>
			<div class="blacknews_short_off">
				<h2 class="line_before">{translate('Short content')}:</h2>
				{show_wysiwyg_editor($WYSIWYG.short,$WYSIWYG.short,'',$WYSIWYG.short_width,$WYSIWYG.short_height)}
			</div>
			<p class="blacknews_content_header">
				<span class="blacknews_label small">{translate('Created by')}:</span><span class="info_created_by"></span><br/>
				<span class="blacknews_label small">{translate('Published')}:</span><span class="info_published"></span><br/>
				<span class="blacknews_label small">{translate('Last update')}:</span><span class="info_last_update"></span>	
				<button name="publish" class="right fc_gradient1 fc_gradient_hover bn_icon-feed{if $entry.active} published{else} drafted{/if}"><span class="is_published">{translate('Published')}</span><span class="not_published">{translate('Unpublished')}</span></button>
				<button name="save" class="clear fc_gradient_blue fc_gradient_hover right"> {translate('Save')}</button>
				<button name="delete" class="fc_gradient_red fc_gradient_hover blacknews_delete left"> {translate('Delete')}</button>
				<span class="clear"></span>
			</p>
		</form>
	</div>
	<p class="small right">{translate('Version')}: {$version}</p>
</div>