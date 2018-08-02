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
	<span>{date('d.m.',$entry.publishUT)}</span>
	<h3>{$entry.title}</h3>
	{if $entry.short}{$entry.short}{else}<p>{truncateHTML($entry.text,100)}</p>{/if}
	<aside>
		<a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/">mehr lesen...</a>
	</aside>
</article>