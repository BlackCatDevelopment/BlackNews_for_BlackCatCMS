{*
 * ,-----.  ,--.              ,--.    ,-----.          ,--.       ,-----.,--.   ,--. ,---.   
 * |  |) /_ |  | ,--,--. ,---.|  |,-.'  .--./ ,--,--.,-'  '-.    '  .--./|   `.'   |'   .-'  
 * |  .-.  \|  |' ,-.  || .--'|     /|  |    ' ,-.  |'-.  .-'    |  |    |  |'.'|  |`.  `-.  
 * |  '--' /|  |\ '-'  |\ `--.|  \  \'  '--'\\ '-'  |  |  |      '  '--'\|  |   |  |.-'    | 
 * `------' `--' `--`--' `---'`--'`--'`-----' `--`--'  `--'       `-----'`--'   `--'`-----'  
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author			Matthias Glienke
 *   @copyright			2018, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			blackNews
 *
*}

<section id="bN_List_{$section_id}" class="bN_List">
  {assign var=c value=false}{foreach $entries entry}{if $entry.publish}{if $c==false}{assign var=c value=true}
  <figure class="bN_ListFirst">
    {if $options.title}<h1 class="c_1024"> {$options.title}</h1>{/if}
    {if $category}{assign var=temp value=$categories.$category}{$temp}{assign var=class value=$temp.url}
      <h2 class="c_1024 {$catIcons.$class}">{$temp.category}</h2>
      {elseif $options.subtitle}<h2 class="c_1024">{$options.subtitle}</h2>{/if}
    <div><div style="background-image:url({$entry.image});"></div></div>
    <figcaption class="c_1024">
      {if $entry.image}<div style="background-image:url({$entry.image});" class="bN_ListFirstImage">
        <img src="{$entry.image}" alt="{$entry.title}">
      </div>{/if}
      <div>
        <h3>{$entry.title}</h3>
        {truncateHTML($entry.content,400,' ...')}
        {assign var=class value=$entry.url}<span class="{$catIcons.$class} bN_author" title="{$entry.category}"></span>
        <small>
          <a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" class="icon-coffee">weiterlesen ...</a>
          <span class="icon-calendar">{format_date(strtotime($entry.publishDate))}</span>
        </small>
        <a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" title="{str_replace('"','',$entry.title)}"></a>
      </div>
    </figcaption>
  </figure>
  <div class="c_1024">
{else}
<article class="bN_Entries">	
  <figure>
    {if $entry.image}<div style="background-image: url('{$entry.image}');">
      <img src="{$entry.image}" class="bN_mImage" alt="{$entry.title}">
      {assign var=class value=$entry.url}<span class="bN_author {$catIcons.$class}" title="{$entry.category}"></span>
    </div>{/if}
    <figcaption>
      <h3>{$entry.title}</h3>
      {truncateHTML($entry.text,250,' ...')}
      <aside>
        <a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" class="icon-coffee">weiterlesen ...</a>
        <span class="icon-calendar">{format_date(strtotime($entry.publishDate))}</span>
      </aside>
      <a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" title="{str_replace('"','',$entry.title)}"  class="incNews_fullLink"></a>
    </figcaption>
  </figure>
</article>{/if}
  {/if}{/foreach}</div>
</section>