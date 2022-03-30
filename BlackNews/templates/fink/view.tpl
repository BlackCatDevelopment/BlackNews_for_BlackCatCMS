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
<style>.scrolledUp a#logo\{background: url(../../../../templates/fink/css/default/images/fink-logo-white.png) no-repeat left center;background-size:234px 32px;margin-top:2rem}@media (min-width: 1080px) \{.scrolledUp #mainN.list > li > a\{color:rgba(252,250,248,1)}}</style>
<section id="bN_List_{$section_id}" class="bN_List">
  {assign var=c value=false}{foreach $entries entry}{if $entry.publish}{if $c==false}{assign var=c value=true}
  <figure class="bN_ListFirst">
    {if $options.title}<h1 class="c_1024"> {$options.title}</h1>{/if}
    {if $category}{assign var=temp value=$categories.$category}{assign var=class value=$temp.url}
      <h2 class="c_1024 {$catIcons.$class}">{$temp.category}</h2>
      {elseif $options.subtitle}<h2 class="c_1024">{$options.subtitle}</h2>{/if}
    <div class="downLight"></div>
    <figcaption class="c_1024">
      {if $entry.image}<div style="background-image:url({$entry.image});" class="bN_ListFirstImage">
        <img src="{$entry.image}" alt="{$entry.title}">
      </div>{/if}
      <div>
        <h3>{$entry.title}</h3>
        {truncateHTML($entry.content,400,' ...')}
        {assign var=class value=$entry.url}<span class="{$catIcons.$class} bN_author" title="{$entry.category}"><img src="{cat_url}/media/email/fink-logo-icon-only.png"></span>
        <small>
          <a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" class="button-line">weiterlesen ...</a>
          <span class="fink-calendar">{format_date(strtotime($entry.publishDate))}</span>
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
      {assign var=class value=$entry.url}<span class="bN_author {$catIcons.$class}" title="{$entry.category}"><img src="{cat_url}/media/email/fink-logo-icon-only.png"></span>
    </div>{/if}
    <figcaption>
      <h3>{$entry.title}</h3>
      {truncateHTML($entry.text,250,' ...')}
      <aside>
        <a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" class="button-line">weiterlesen ...</a>
        <span class="fink-calendar">{format_date(strtotime($entry.publishDate))}</span>
      </aside>
      <a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" title="{str_replace('"','',$entry.title)}"  class="incNews_fullLink"></a>
    </figcaption>
  </figure>
</article>{/if}
  {/if}{/foreach}</div>
</section>