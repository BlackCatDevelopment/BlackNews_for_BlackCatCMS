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

<article class="eps_Entries">
	<figure>
		{if $entry.image}<img class="eps_mImage" style="background-image: url('{$entry.image}');" />{/if}
		<figcaption>
			<h2>{$entry.title}</h2>
			{truncateHTML($entry.text,250)}
		</figcaption>
	</figure>
	{*<aside>
		<a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" class="icon-book"> weiterlesen...</a> {*need to handle PAGE_DIRECTORY*}
	{*</aside>*}
</article>