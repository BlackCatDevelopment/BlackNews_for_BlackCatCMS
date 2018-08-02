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
<input type="hidden" name="saveFields" value="title,text|seoURL,text|wysiwyg_{$section_id},wysiwyg|publishDate,date|unpublishDate,date|publishTime,time|unpublishTime,time">
<input type="hidden" name="saveOptions" value="input|short">
<span class="bcLabel">Titel:</span><input type="text" name="title" value="{$entry.title}"><br>
<span class="bcLabel">URL:</span><input type="text" name="seoURL" value="{$entry.seoURL}" placeholder="Wird automatisch beim ersten Speichern gesetzt"><br>
<span class="bcLabel">Veröffentlichen am:</span><input type="date" name="publishDate" value="{$entry.publishDate}" class="fieldShort" placeholder="Datum Start"><input type="time" name="publishTime" value="{$entry.publishTime}" class="fieldShort" placeholder="Uhrzeit Start"><br>
<span class="bcLabel">Veröffentlichen bis:</span><input type="date" name="unpublishDate" value="{$entry.unpublishDate}" class="fieldShort" placeholder="Datum Ende"><input type="time" name="unpublishTime" value="{$entry.unpublishTime}" class="fieldShort" placeholder="Uhrzeit Ende"><br>

<div id="bN_dropzone_{$section_id}" class="bN_dropzone fc_br_all">
	{translate('Drag &amp; drop')}<span>{translate('your image here or click to upload')}.</span>
</div>

<div id="bN_imgs_{$section_id}" class="bN_imgs">
	<div class="dz-preview dz-processing dz-image-preview">
		<div class="dz-details">
			<img data-dz-thumbnail="" alt="kein Bild hinzugefügt" src="" id="bN_previewIMG_{$section_id}">
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 0%;"></span></div>
		<div class="dz-success-mark"><span>✔</span></div>
		<div class="dz-error-mark"><span>✘</span></div>
		<div class="dz-error-message"><span data-dz-errormessage=""></span></div></div>
</div>
<hr>
<h3 class="bcLabel">Kurzbeschreibung:</h3><br>
<textarea name="short"></textarea>
<hr>
<h3 class="bcLabel">Beschreibung</h3>
{show_wysiwyg_editor($bc_WYSIWYG.name,$bc_WYSIWYG.name,'')}