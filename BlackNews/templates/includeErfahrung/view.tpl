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

<section id="ics_List_{$section_id}" class="ics_List">
  {$c=false}{foreach $entries entry}{if $entry.publish && (!$options.newsCount || $count < $options.newsCount)}{$count=$count+1}
  {if $c==false}{$c=true}
  <figure class="ics_ListFirst">{$class=$entry.url}
	{$temp=$categories.$category}{$temp}{$class=$temp.url}
	{if $options.title}<h1 class="c_1024 {$catIcons.$class}">{$options.title}</h1>{/if}
	{if $options.sub_title}<h2 class="c_1024">{$options.sub_title}
		{if $options.newsCount>0}<a href="{cat_url}/{$options.permalink}/{if $options.category}{$entry.url}{/if}" class="button greenButton ics-arrow-right">Alle {if $options.category}{$entry.category}{else}Neuigkeiten{/if}</a>{/if}</h2>
	{/if}
	<div><div style="background-image:url({$entry.image});"></div></div>
	<figcaption class="c_1024">
	  <div style="background-image:url({$entry.image});" class="ics_ListFirstImage">
		<img src="{$entry.image}" alt="{$entry.title}">
	  </div>
	  <div>
		<h3>{$entry.title}</h3>
		{truncateHTML($entry.content,400,' ...')}
		{$class=$entry.url}<span class="{$catIcons.$class} bN_author" title="{$entry.category}"></span>
		<small>
		  <a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" class="ics-coffee">weiterlesen ...</a>
		  <span class="ics-calendar">{format_date(strtotime($entry.publishDate))}</span>
		</small>
		<a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" title="{str_replace('"','',$entry.title)}"></a>
	  </div>
	</figcaption>
	<img src="{cat_url}/templates/ics/css/default/images/bottom.svg" class="ics_EntryBottom" alt="Bogen">
  </figure>
  <div class="c_1024">
{else}
<article class="ics_Entries">	
  <figure>
	{if $entry.image}<div style="background-image: url('{$entry.image}');">
	  <img src="{$entry.image}" class="ics_mImage"  alt="{$entry.title}">
	  {$class=$entry.url}<span class="bN_author {$catIcons.$class}" title="{$entry.category}"></span>
	</div>{/if}
	<figcaption>
	  <h3>{$entry.title}</h3>
	  {truncateHTML($entry.text,250,' ...')}
	  <aside>
		<a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" class="ics-coffee">weiterlesen ...</a>
		<span class="ics-calendar">{format_date(strtotime($entry.publishDate))}</span>
	  </aside>
	  <a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" title="{str_replace('"','',$entry.title)}"  class="incNews_fullLink"></a>
	</figcaption>
  </figure>
</article>{/if}
  {/if}{/foreach}</div>
</section>