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
<div id="bN_{$section_id}">
	{foreach $entries as entry}
	<section class="bN_content">
		<article class="bN_short">
		{if $entry.image_path != ''}<img class="bN_preview_img" src="{makeThumb( $entry.image_path, 'bN_',100,600)}" alt="" />{/if}
		<h2>{$entry.title}</h2>
		{if $entry.subtitle != ''}<h4>{$entry.subtitle}</h4>{/if}
			{$entry.short}
		</article>
		<a class="bN_link button" href="{cat_url}/{$entry.url}">{translate('Read more')}...</a>
	</section>
	{/foreach}
</div>
{else}
{translate('No entries yet.')}
{/if}