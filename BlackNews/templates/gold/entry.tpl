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
<div id="blacknews_{$section_id}" class="blacknews_single_entry">
	<h1>{$entry.title}</h1>
	<span class="bn_category">{translate('Category')}: {$entry.categories}</span>
	<span class="bn_updated">{translate('Last Update')}: {$entry.updated}</span>
	<span class="bn_createdby">{translate('Created by')}: {$entry.created_by}</span>
	{if $entry.image_path != ''}<img src="{makeThumb( $entry.image_path, 'blacknews_',200,600)}" alt="" class="blacknews_single_entry_img" />{/if}
	{if $entry.subtitle}<h2>{$entry.subtitle}</h2>{/if}
	<div>
		{$entry.content}
	</div>
	<a href="{$pagelink}">{translate('Back')}</a>
</div>
{else}
{translate('Nothing to show')}
{/if}
<div class="clear"></div>
<div id="blacknews_{$section_id}" class="gold-news">
	<section class="blacknews_content">
	{$counter = 0}
	{foreach $entries_ci index sing_entry}
		{if $sing_entry.news_id != $entry.news_id && $counter < 3}
		<article class="blacknews_three">
			{if $sing_entry.image_path != ''}<a href="{CAT_URL}/{$sing_entry.url}">
				<img class="blacknews_preview_img" src="{makeThumb( $sing_entry.image_path, 'blacknews_', 200, 330, 'crop' )}" alt="" />
			</a>{/if}
			<h2>{$sing_entry.title}</h2>
			{if $sing_entry.subtitle != ''}<h3>{$sing_entry.subtitle}</h3>{/if}
			{if $sing_entry.short}{$sing_entry.short}{else}{truncateHTML($sing_entry.content, $sing_entry.auto_generate_size)}{/if}<br/>
			<a class="blacknews_link button" href="{CAT_URL}/{$sing_entry.url}">{translate('Read more...')}</a>
		</article>
		{$counter = $counter+1}
		{/if}
	{/foreach}
		<div class="clear"></div>
	</section>
</div>
