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
{$permalink}
{if count($entries)>0}
<section id="incNews_{$section_id}" class="incNews c_1080">
	<a href="{cat_url}/{$permalink}/{if $options.category}{$firstEntry.url}{/if}" class="button ics-arrow-right">{translate("All")} {if $options.category}{$firstEntry.category}{else}{translate("news")}{/if}</a>
	{if $options.title}<h2>{$options.title}{if $options.title} <span>{$options.sub_title}</span>{/if}</h2>{/if}
	<div>
		{foreach $entries i entry}
			{if $entry.publish && (!$options.newsCount || $i < $options.newsCount)}{include(view/entryList.tpl)}{/if}
		{/foreach}
	</div>
</section>{/if}