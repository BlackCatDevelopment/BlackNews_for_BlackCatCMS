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

<section id="incNews_{$section_id}" class="incNews">
	{if $options.title}<h2>{$options.title}{if $options.title} <span>{$options.sub_title}</span>{/if}</h2>{/if}
	{$count=0}{foreach $entries entry}{if $entry.publish && $count < $options.newsCount}{$count=$count+1}{include(view/entryList.tpl)}{/if}{/foreach}
</section>