{*
   ____  __      __    ___  _  _  ___    __   ____     ___  __  __  ___
  (  _ \(  )    /__\  / __)( )/ )/ __)  /__\ (_  _)   / __)(  \/  )/ __)
   ) _ < )(__  /(__)\( (__  )  (( (__  /(__)\  )(    ( (__  )    ( \__ \
  (____/(____)(__)(__)\___)(_)\_)\___)(__)(__)(__)    \___)(_/\/\_)(___/

   @author          Matthias Glienke, creativecat
   @copyright       2017 Matthias Glienke, creativecat
   @link            http://blackcat-cms.org
   @license         http://www.gnu.org/licenses/gpl.html
   @category        CAT_Module
   @package         blacknews

*}
<style>.scrolledUp a#logo\{background: url(../../../../templates/fink/css/default/images/fink-logo-white.png) no-repeat left center;background-size:234px 32px;margin-top:2rem}@media (min-width: 1080px) \{.scrolledUp #mainN.list > li > a\{color:rgba(252,250,248,1)}}</style>
<section id="bN_Entry">
	<figure>
		<div class="downLight"></div>
		<figcaption class="c_1024">
			<h1>{$entry.title}</h1>
			<small>{*{assign var=class value=$entry.category.0.url}
				<a href="{cat_url}/{$options.permalink}/{$entry.category.0.url}" class="{$catIcons.$class}" title="{$entry.category.0.category}">{$entry.category.0.category}</a>*}
				<span >{format_date(strtotime($entry.publishDate))}</span>
			</small>
			<img src="{$entry.image}" alt="{$entry.title}">
		</figcaption>
	</figure>
	<article class="c_1024">
			{$entry.content}
		<p><br><a class="button-line {if $referer>0}{$catIcons.$class}{else}fink-arrow-left{/if}" href="{if $referer>0}{cat_url}/{$options.permalink}/{$entry.category.0.url}{elseif $referer<0}{cmsplink(-$referer)}{else}{cat_url}/{$options.permalink}{/if}"> Zur&uuml;ck zu{if $referer>0} {$entry.category.0.category}{elseif $referer<0} {menutitle(-$referer)}{else}r &Uuml;bersicht{/if}</a></p>
		{$gallery}
	</article>
</section>