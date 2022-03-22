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

<h2>Eintrag</h2>
<input type="hidden" name="page_id" value="{$page_id}">
<input type="hidden" name="section_id" value="{$section_id}">
<input type="hidden" name="saveFields" value="title,text|seoURL,text|wysiwyg_{$section_id},wysiwyg|publishDate,date|unpublishDate,date|userID,select">
<input type="hidden" name="saveOptions" value="catGallery,select{*schulart,select|type,select|subject,text|start,text|end,text|price,text|formularTitle,text|formularDisclaimer,text|formularMailTitelKunde,text|formularMailTitelAnbieter,text|formularPartner,text|linkedPDF,text*}">
<span class="bcLabel">Titel:</span><input type="text" name="title" value="{if $entry.title}{$entry.title}{/if}"><br>
<span class="bcLabel">URL:</span><input type="text" name="seoURL" value="{if $entry.seoURL}{$entry.seoURL}{/if}"><br>
<span class="bcLabel">Veröffentlichen am:</span><input type="date" name="publishDate" value="{if $entry.publishDate}{$entry.publishDate}{/if}" placeholder="Format: dd.mm.yyyy"><br>
<span class="bcLabel">Veröffentlichen bis:</span><input type="date" name="unpublishDate" value="{if $entry.unpublishDate}{$entry.unpublishDate}{/if}" placeholder="Format: dd.mm.yyyy"><br>
<hr>
<div id="bN_dropzone_{$section_id}" class="bN_dropzone fc_br_all">
	{translate('Drag &amp; drop')}<span>{translate('your image here or click to upload')}.</span>
</div>

<div id="bN_imgs_{$section_id}" class="bN_imgs">
	<div class="dz-preview dz-processing dz-image-preview">
		<div class="dz-details">
			<img data-dz-thumbnail="" alt="Kein Bild bisher hochgeladen" src="" id="bN_previewIMG_{$section_id}">
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 0%;"></span></div>
		<div class="dz-success-mark"><span>✔</span></div>
		<div class="dz-error-mark"><span>✘</span></div>
		<div class="dz-error-message"><span data-dz-errormessage=""></span></div></div>
</div>
<hr>
<h3 class="bcLabel">Beschreibung</h3>
{show_wysiwyg_editor($bc_WYSIWYG.name,$bc_WYSIWYG.name,'')}
<hr>
<h3 class="bcLabel">Kategorie</h3>
<p>
	<select name="category" multiple="multiple" class="cc_In300px category" size="10">
		<option value="-1">Keine Kategorie</option>
		{foreach $categories c}
		<option value="{$c.catID}">{$c.category}</option>
		{/foreach}
	</select>
</p>
	<small><strong>Hinweis:</strong> Mehrfachauswahl (Mit gedr&uuml;ckter Taste - Windows: Strg; Mac: cmd/command) m&ouml;glich.<br>Sobald der erste Punkt &quot;Keine Kategorie&quot; gew&auml;hlt wird, werden alle Kategorien gel&ouml;scht!</small>
<hr>
<h3>Galerie</h3>
<button class="bc_addGallery fc_gradient1 fc_gradient_hover" name="bc_addGallery">Neue Galerie hinzuf&uuml;gen</button><br><br>
...oder Galerie ausw&auml;hlen:
<select name="catGallery">
	<option value="0"{if !$entry.option.catGallery} selected="selected"{/if}>--- Keine gewählt ---</option>
{foreach $galleries ind gal}
	<option value="{$ind}"{if $entry.option.catGallery == $ind} selected="selected"{/if}>{$gal}</option>
{/foreach}
</select>
<hr>
Benutzer w&auml;hlen:
<select name="userID">
	{*<option value="1" {if $entry.option.userID == 1} selected="selected"{/if}>Matthias Glienke</option>*}
	{foreach $users u}
	<option value="{$u.user_id}"{if $entry.option.userID == $u.user_id} selected="selected"{/if}>{$u.display_name}</option>
	{/foreach}
</select>
<hr>