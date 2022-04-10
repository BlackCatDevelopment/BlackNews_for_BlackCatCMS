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
			{assign var=class value=$entry.url}<span class="bN_author {$catIcons.$class}" title="{$entry.category}"></span>
		</div>{/if}
		<figcaption>
			<h3>{$entry.title}</h3>
			{truncateHTML($entry.text,250," ...")}
			<aside>
				<a href="{cat_url}/{$permalink}/{$entry.seoURL}/" class="ics-coffee">weiterlesen ...</a>
				<span class="ics-calendar">{format_date(strtotime($entry.publishDate))}</span>
			</aside>
			<a href="{cat_url}/{$permalink}/{$entry.seoURL}/" title="{str_replace('"','',$entry.title)}" class="incNews_fullLink"></a>
		</figcaption>
	</figure>
</article>