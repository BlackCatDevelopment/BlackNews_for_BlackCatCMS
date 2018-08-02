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

{include(../default/modify/javascript.tpl)}
<div id="blackNews_{$section_id}">
	{include(../default/modify/set_skin.tpl)}
	<div class="blackNews fc_br_all">
		<form action="{$CAT_URL}/modules/blackNews/save.php" id="bc_Options_{$section_id}" method="post" data-bnid="">
			<input type="hidden" name="page_id" value="{$page_id}">
			<input type="hidden" name="section_id" value="{$section_id}">
			<input type="hidden" name="saveOptions" value="newsCount|setNews|title|sub_title">

			<label for="title_{$section_id}">Titel:</label>
			<input id="title_{$section_id}" name="title" type="text" value="{if $options.title}{$options.title}{/if}"><br><br>

			<label for="sub_title_{$section_id}">Untertitel:</label>
			<input id="sub_title_{$section_id}" name="sub_title" type="text" value="{if $options.sub_title}{$options.sub_title}{/if}"><br><br>

			<h3>News einbinden</h3>
			<label for="newsCount_{$section_id}">Anzahl der einzubindenden News:</label>
			<input id="newsCount_{$section_id}" name="newsCount" type="number" value="{if $options.newsCount}{$options.newsCount}{/if}"><br><br>
			<label for="setNews_{$section_id}">Sektion der Newsseite:</label>
			<input id="setNews_{$section_id}" name="setNews" type="number" value="{if $options.setNews}{$options.setNews}{/if}"><br><br>
			{*<select name="setNews" id=="setNews_{$section_id}">
				<option value="0" {if $options.setNews == 0}selected="selected"{/if}>disabled</option>
				<option value="1" {if $options.setNews == 1}selected="selected"{/if}>lorem</option>
			</select>*}
			
			<button name="save" class="fc_gradient_blue fc_gradient_hover" id="saveOption_{$section_id}">Save options</button>
		</form>
	</div>
	<small class="bcVersion">Modulversion: {$version}</small>
</div>