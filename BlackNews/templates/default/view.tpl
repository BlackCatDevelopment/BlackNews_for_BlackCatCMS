{*
 *
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
 *   @copyright		2022, Black Cat Development
 *   @link				https://github.com/BlackCatDevelopment/BlackNews_for_BlackCatCMS
 *   @license			https://www.gnu.org/licenses/gpl-3.0.html
 *   @category		CAT_Modules
 *   @package			blackNews
 *
*}

<section id="bN_List_{$section_id}" class="bN_List" data-section="{$section_id}" data-permalink="{$permalink}" data-perpage="{if $perPage}{$perPage}{else}20{/if}">
  {if $years || $tags}
  <nav class="bN_Filters c_1080" id="bN_Filters_{$section_id}">
    {if $years}
    <select class="bN_filterYear" data-prefix="jahr">
      <option value="">{translate("All years")}</option>
      {foreach $years y}<option value="{$y}"{if $activeFilters.jahr && in_array($y, $activeFilters.jahr)} selected="selected"{/if}>{$y}</option>{/foreach}
    </select>
    {/if}
    {if $tags}
    {assign var=tagTypes value=[]}{foreach $tags t}{if !in_array($t.type, $tagTypes)}{assign var=tagTypes value=array_merge($tagTypes, [$t.type])}{/if}{/foreach}
    {foreach $tagTypes tt}
    <select class="bN_filterTag" data-prefix="{$tt}">
      <option value="">{$tt}</option>
      {foreach $tags t}{if $t.type == $tt}<option value="{$t.slug}"{if $activeFilters[$tt] && in_array($t.slug, $activeFilters[$tt])} selected="selected"{/if}>{$t.name}</option>{/if}{/foreach}
    </select>
    {/foreach}
    {/if}
  </nav>
  {/if}
  {assign var=c value=false}{foreach $entries entry}{if $entry.publish}{if $c==false}{assign var=c value=true}
  <figure class="bN_ListFirst">
    {if $options.title}<h1 class="c_1080"> {$options.title}</h1>{/if}
    {if $category}{assign var=temp value=$categories.$category}{$temp}{assign var=class value=$temp.url}
      <h2 class="c_1080 {$catIcons.$class}">{$temp.category}</h2>
      {elseif $options.subtitle}<h2 class="c_1080">{$options.subtitle}</h2>{/if}
    <div>{if $entry.image}<div style="background-image:url({$entry.image});"></div>{/if}</div>
    <figcaption class="c_1080{if !$entry.image} bN_noFirstImage{/if}">
      {if $entry.image}<div style="background-image:url({$entry.image});" class="bN_ListFirstImage">
        <img src="{$entry.image}" alt="{$entry.title}">
      </div>{/if}
      <div>
        <h3>{$entry.title}</h3>
        {if !$entry.truncate}{assign var=truncate value=400}{else}{assign var=truncate value=$entry.truncate}{/if}
        {truncateHTML($entry.content,$truncate,' ...')}
        {assign var=class value=$entry.url}<span class="{$catIcons.$class} bN_author" title="{$entry.category}"></span>
        <small>
          <a href="{cat_url}/{$permalink}/{$entry.seoURL}/" class="bN-icon-coffee"> {translate("continue reading")} ...</a>
          <span class="bN-icon-calendar"> {if $entry.publishUT}{cat_format_date($entry.publishUT)}{else}{cat_format_date($entry.isPublishUT)}{/if}</span>
        </small>
        <a href="{cat_url}/{$permalink}/{$entry.seoURL}/" title="{str_replace('"','',$entry.title)}"></a>
      </div>
    </figcaption>
  </figure>
  <div class="c_1080">
{else}
<article class="bN_Entries">	
  <figure>
    {if $entry.image}<div style="background-image: url('{$entry.image}');">
      <img src="{$entry.image}" class="bN_mImage" alt="{$entry.title}">
      {assign var=class value=$entry.url}<span class="bN_author {$catIcons.$class}" title="{$entry.category}"></span>
    </div>{/if}
    <figcaption>
      <h3>{$entry.title}</h3>
      {if !$entry.truncate}{assign var=truncate value=250}{else}{assign var=truncate value=$entry.truncate}{/if}
      {truncateHTML($entry.text,$truncate,' ...')}
      <aside>
        <a href="{cat_url}/{$permalink}/{$entry.seoURL}/" class="bN-icon-coffee"> {translate("continue reading")} ...</a>
        <span class="bN-icon-calendar"> {if $entry.publishUT}{cat_format_date($entry.publishUT)}{else}{cat_format_date($entry.isPublishUT)}{/if}</span>
      </aside>
      <a href="{cat_url}/{$permalink}/{$entry.seoURL}/" title="{str_replace('"','',$entry.title)}"  class="incNews_fullLink"></a>
    </figcaption>
  </figure>
</article>{/if}
  {/if}{/foreach}</div>
  <div class="c_1080"><button id="bN_more_{$section_id}" class="bN_more" style="display:none;">{translate("Load more")}</button></div>
</section>
<script>
(function()\{
  var sec = document.getElementById('bN_List_{$section_id}');
  if (!sec) return;
  var sectionId = sec.getAttribute('data-section');
  var permalink = sec.getAttribute('data-permalink');
  var perPage   = parseInt(sec.getAttribute('data-perpage'), 10) || 20;
  var base      = '{cat_url}/' + permalink + '/';
  var filters   = {json_encode($activeFilters|default:[])};
  var page      = 0;

  function filterUrl(f)\{
    var parts = [];
    Object.keys(f).sort().forEach(function(k)\{
      f[k].forEach(function(s)\{ parts.push(k + '/' + s); });
    });
    return base + parts.join('/');
  }

  // Filter-Wechsel: ohne JS normaler Link, mit JS per AJAX nachladen
  var selects = sec.querySelectorAll('.bN_Filters select');
  selects.forEach(function(sel)\{
    sel.addEventListener('change', function()\{
      var prefix = sel.getAttribute('data-prefix');
      var val = sel.value;
      if (val) \{
        filters[prefix] = [val];
      } else \{
        delete filters[prefix];
      }
      page = 0;
      loadEntries(true);
      if (history.replaceState) \{
        history.replaceState(null, '', filterUrl(filters));
      }
    });
  });

  function loadEntries(reset)\{
    var body = new URLSearchParams();
    body.append('action', 'getEntries');
    body.append('_cat_ajax', '1');
    body.append('section_id', sectionId);
    body.append('page', page);
    body.append('filters', JSON.stringify(filters));
    fetch('{$CAT_URL}/modules/blackNews/save.php', \{
      method: 'POST',
      headers: \{'Content-Type': 'application/x-www-form-urlencoded'},
      body: body.toString()
    }).then(function(r)\{ return r.json(); }).then(function(res)\{
      if (!res || !res.success) return;
      var list = sec.querySelector('div.c_1080');
      if (reset) \{ list.innerHTML = res.html; } else \{ list.insertAdjacentHTML('beforeend', res.html); }
      var more = document.getElementById('bN_more_' + sectionId);
      if (more) \{ more.style.display = res.hasMore ? '' : 'none'; }
    }).catch(function()\{});
  }

  var moreBtn = document.getElementById('bN_more_{$section_id}');
  if (moreBtn) \{
    var total = \{if $totalEntries}{$totalEntries}\{else}0\{/if};
    if (perPage < total) \{ moreBtn.style.display = ''; }
    moreBtn.addEventListener('click', function()\{
      page++;
      loadEntries(false);
    });
  }
})();
</script>