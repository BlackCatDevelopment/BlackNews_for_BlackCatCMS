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
<section id="eps_Entry" class="c_960">
	<a class="button icon-circle-left" href="{cat_url}/{$options.permalink}/"> Zur&uuml;ck zur &Uuml;bersicht</a> 
	<article>
		{if $entry.image}<img src="/" style="background-image:url('{$entry.image}');" id="eps_mImage" />{/if}
		<div>
			<h1>{$entry.title}</h1>
			{$entry.content}
		</div>
	</article>
	<a class="button icon-circle-left" href="{cat_url}/{$options.permalink}/"> Zur&uuml;ck zur &Uuml;bersicht</a> 
</section>