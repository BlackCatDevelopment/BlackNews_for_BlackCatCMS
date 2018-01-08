{**
 *  @template       blacknews
 *  @version        see info.php of this template
 *  @author         Matthias Glienke, creativecat
 *  @copyright      2012 Matthias Glienke
 *  @license        Copyright by Matthias Glienke, creativecat
 *  @license terms  see info.php of this template
 *  @platform       see info.php of this template
 *  @requirements   PHP 5.2.x and higher
 *}

{if $entry}
<div id="blacknews_{$section_id}">
	{if $options.showCategory}<span class="bn_category">{translate('Category')}: {$entry.categories}</span>{/if}
	{if $options.showDate}<span class="bn_updated">{translate('Last Update')}: {$entry.updated}</span>{/if}
	{if $options.showCreator}<span class="bn_createdby">{translate('Created by')}: {$entry.created_by}</span>{/if}

	<h2>{$entry.title}</h2>
	{if $entry.image_path != ''}<img src="{makeThumb( $entry.image_path, 'blacknews_',200,600)}" alt="" />{/if}
	{if $entry.subtitle}<h2>{$entry.subtitle}</h2>{/if}
	<div>
		{$entry.content}
	</div>
	<a href="{$pagelink}">{translate('Back')}</a>
</div>
{else}
{translate('Nothing to show')}
{/if}