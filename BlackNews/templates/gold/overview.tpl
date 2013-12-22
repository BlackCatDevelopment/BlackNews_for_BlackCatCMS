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


{if $entries}
<div id="blacknews_{$section_id}" class="gold-news">
	<section class="blacknews_content">
	{foreach $entries_ci index entry}
		{if $index == 0}
		<article class="blacknews_top">
			{if $entry.image_path != ''}<a href="{$entry.url}">
				<img class="blacknews_preview_img" src="{makeThumb( $entry.image_path, 'blacknews_', 300, 600 )}" alt="" />
			</a>{/if}
			<h2>{$entry.title}</h2>
			{if $entry.subtitle != ''}<h3>{$entry.subtitle}</h3>{/if}
			{if $entry.short}{$entry.short}{else}{truncateHTML($entry.content, $entry.auto_generate_size)}{/if}<br/>
			<a class="blacknews_link button" href="{$entry.url}">{translate('Read more...')}</a>
			<div class="clear"></div>
		</article>
		{elseif $index < 3}
		<article class="blacknews_short">
			{if $entry.image_path != ''}<a href="{$entry.url}">
				<img class="blacknews_preview_img" src="{makeThumb( $entry.image_path, 'blacknews_', 200, 450, 'crop' )}" alt="" />
			</a>{/if}
			<h2>{$entry.title}</h2>
			{if $entry.subtitle != ''}<h3>{$entry.subtitle}</h3>{/if}
			{if $entry.short}{$entry.short}{else}{truncateHTML($entry.content, $entry.auto_generate_size)}{/if}<br/>
			<a class="blacknews_link button" href="{$entry.url}">{translate('Read more...')}</a>
		</article>
		{else}
		{if $index == 3}<div class="clear"></div>{/if}
		<article class="blacknews_three">
			{if $entry.image_path != ''}<a href="{$entry.url}">
				<img class="blacknews_preview_img" src="{makeThumb( $entry.image_path, 'blacknews_', 200, 330, 'crop' )}" alt="" />
			</a>{/if}
			<h2>{$entry.title}</h2>
			{if $entry.subtitle != ''}<h3>{$entry.subtitle}</h3>{/if}
			{if $entry.short}{$entry.short}{else}{truncateHTML($entry.content, $entry.auto_generate_size)}{/if}<br/>
			<a class="blacknews_link button" href="{$entry.url}">{translate('Read more...')}</a>
		</article>
		{/if}
	{/foreach}
		<div class="clear"></div>
	</section>
</div>
{else}
{translate('No entries yet.')}
{/if}