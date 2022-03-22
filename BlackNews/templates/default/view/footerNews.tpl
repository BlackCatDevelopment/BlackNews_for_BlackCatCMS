<article class="bN_FooterEntries">
	{if $entry.image}<figure>
		<div class="bN_mImage"><img src="{$entry.image}" ></div>
		<figcaption>{/if}
		<span class="bNDate ics-calendar">{date('d.m.y',$entry.publishUT)}</span>
		<h4>{$entry.title}</h4>
		<a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/"></a>
		{if $entry.image}</figcaption>
	</figure>{/if}
</article>