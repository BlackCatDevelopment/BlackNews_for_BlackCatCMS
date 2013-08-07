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
	<h1>{$entry.title}</h2>
	{if $entry.subtitle}<h2>{$entry.subtitle}</h2>{/if}
	<div>
		{$entry.content}
	</div>
	<a href="{$pagelink}">{translate('Back')}</a>
</div>
{else}
{translate('Nothing to show')}
{/if}