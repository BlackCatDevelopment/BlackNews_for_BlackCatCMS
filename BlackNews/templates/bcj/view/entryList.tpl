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
<article class="bcj_Entries">	
	{if $entry.image}<figure>
		<div style="background-image: url('{$entry.image}');">
			<img src="{$entry.image}" class="bcj_mImage">
		</div>
		<figcaption>{/if}
		<h2>{$entry.title}</h2>
		{if $entry.short}{$entry.short}{else}<p>{truncateHTML($entry.text,100)}</p>{/if}
		<aside>
			<a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" class="icon-book"> <span>weiterlesen...</span></a>
			<span class="bcjDate">{date('d.m.',$entry.publishUT)}</span>
			<span class="bcjYear">{date('y',$entry.publishUT)}</span>
		</aside>
		{if $entry.image}</figcaption>
	</figure>{/if}
</article>