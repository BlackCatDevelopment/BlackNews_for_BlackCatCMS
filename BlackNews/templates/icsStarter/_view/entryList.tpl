	{*
   ____  __      __    ___  _  _  ___    __   ____     ___  __  __  ___
  (  _ \(  )    /__\  / __)( )/ )/ __)  /__\ (_  _)   / __)(  \/  )/ __)
   ) _ < )(__  /(__)\( (__  )  (( (__  /(__)\  )(    ( (__  )    ( \__ \
  (____/(____)(__)(__)\___)(_)\_)\___)(__)(__)(__)    \___)(_/\/\_)(___/

   @author          Black Cat Development
   @copyright       2016 Black Cat Development
   @link            http://blackcat-cms.org
   @license         http://www.gnu.org/licenses/gpl.html
   @category        CAT_Core
   @package         CAT_Core

*}

<article class="incNews_Entries">
	<figure>
		{if $entry.image}<div style="background-image: url('{$entry.image}');">
			<img src="{$entry.image}" class="incNews_mImage" alt="{$entry.title}">
			{$path="`$CAT_PATH`/media/teacher/`$entry.username`.jpg"}
			<img src="{cat_url}/media/news/{if file_exists($path)}{$entry.username}{else}default{/if}.jpg" class="bN_author" title="{$entry.display_name}" alt="{$entry.title}">
		</div>{/if}
		<figcaption>
			<h3>{$entry.title}</h3>
			{truncateHTML($entry.text,250)}
			<aside>
				<a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" class="icon-book"> weiterlesen...</a>
				<span>{format_date(strtotime($entry.modified))}</span>
			</aside>
		</figcaption>
	</figure>
</article>