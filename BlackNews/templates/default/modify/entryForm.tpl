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

<h2>Eintrag</h2>
<input type="hidden" name="page_id" value="{$page_id}">
<input type="hidden" name="section_id" value="{$section_id}">
<input type="hidden" name="saveFields" value="title,text|seoURL,text|wysiwyg_{$section_id},wysiwyg|publishDate,date|unpublishDate,date">
<input type="hidden" name="saveOptions" value="input|short{*schulart,select|type,select|subject,text|start,text|end,text|price,text|formularTitle,text|formularDisclaimer,text|formularMailTitelKunde,text|formularMailTitelAnbieter,text|formularPartner,text|linkedPDF,text*}">
<span class="bcLabel">Titel:</span><input type="text" name="title" value="{$entry.title}"><br>
<span class="bcLabel">URL:</span><input type="text" name="seoURL" value="{$entry.seoURL}"><br>
<span class="bcLabel">Veröffentlichen am:</span><input type="date" name="publishDate" value="{$entry.publishDate}" class="fieldShort">
<span class="bcLabel">Veröffentlichen bis:</span><input type="date" name="unpublishDate" value="{$entry.unpublishDate}"class="fieldShort"><br>

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