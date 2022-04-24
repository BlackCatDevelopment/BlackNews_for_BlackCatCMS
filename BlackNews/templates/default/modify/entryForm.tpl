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

<h2>{translate("Post")}</h2>
<input type="hidden" name="page_id" value="{$page_id}">
<input type="hidden" name="section_id" value="{$section_id}">
<input type="hidden" name="saveFields" value="title,text|seoURL,text|content,wysiwyg|shortcontent,wysiwyg|publishDate,date|unpublishDate,date|publishTime,time|unpublishTime,time|userID,select">
<input type="hidden" name="saveOptions" value="catGallery,select|truncate,text">
<span class="bcLabel">{translate("Title")}:</span><input type="text" name="title" value="{if $entry.title}{$entry.title}{/if}"><br>
<span class="bcLabel">URL:</span><input type="text" name="seoURL" value="{if $entry.seoURL}{$entry.seoURL}{/if}" placeholder="{translate("Will be set automatically on first save")}">
<hr>
<p><small>{translate("<strong>Hint:</strong> The post is optionally displayed in the specified period if it was switched online using the button at the top right.")}</small></p>
<span class="bcLabel bN-icon-calendar"> {translate("Publish on")}:</span><input type="date" name="publishDate" value="{if $entry.publishDate}{$entry.publishDate}{/if}" placeholder="Format: dd.mm.yyyy"><input type="time" name="publishTime" value="{if $entry.publishTime}{$entry.publishTime}{/if}" placeholder="Format: hh.mm"><br>
<span class="bcLabel bN-icon-calendar"> {translate("Publish until")}:</span><input type="date" name="unpublishDate" value="{if $entry.unpublishDate}{$entry.unpublishDate}{/if}" placeholder="Format: dd.mm.yyyy" ><input type="time" name="unpublishTime" value="{if $entry.unpublishTime}{$entry.unpublishTime}{/if}" placeholder="Format: hh.mm"><br>
<hr>
<div id="bN_dropzone_{$section_id}" class="bN_dropzone fc_br_all">
	{translate('Drag &amp; drop')}<span>{translate("your image here or click to upload")}.</span>
</div>

<div id="bN_imgs_{$section_id}" class="bN_imgs">
	<div class="dz-preview dz-processing dz-image-preview">
		<div class="dz-details">
			<img data-dz-thumbnail="" alt="{translate("No image uploaded yet")}" src="" id="bN_previewIMG_{$section_id}">
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 0%;"></span></div>
		<div class="dz-success-mark"><span>✔</span></div>
		<div class="dz-error-mark"><span>✘</span></div>
		<div class="dz-error-message"><span data-dz-errormessage=""></span></div></div>
</div>
<hr>
<h3 class="bcLabel">{translate("Description")}</h3><br>
<span class="">{translate("Maximum characters in preview text")}:</span><input type="text" name="truncate" value="{if $entry.options.truncate}{$entry.options.truncate}{/if}" placeholder="400" ><br>

{show_wysiwyg_editor("content",$bc_WYSIWYG.name,'')}
<hr>
<h3 class="bcLabel">{translate("Short Description (optional)")}</h3><br>
{show_wysiwyg_editor("shortcontent",$bc_WYSIWYG2.name,'')}
<hr>
<h3 class="bcLabel bN-icon-tags"> {translate("Category")}</h3>
<p>
	<select name="category" multiple="multiple" class="cc_In300px category" size="10">
		<option value="-1">{translate("No category")}</option>
		{foreach $categories c}
		<option value="{$c.catID}">{$c.category}</option>
		{/foreach}
	</select>
</p>
	<small>{translate("<strong>Note:</strong> Multiple selection (with pressed key - Windows: Ctrl; Mac: cmd/command) possible.<br>As soon as the first point &quot;No category&quot; is selected, all categories will be deleted!")}</small>
<hr>
<h3 class="bN-icon-images">  {translate("Gallery")}</h3>
<button class="bc_addGallery fc_gradient1 fc_gradient_hover" name="bc_addGallery"> {translate("Add new gallery")}</button><br><br>
...{translate("or select gallery")}:
<select name="catGallery">
	<option value="0"{if !$entry.option.catGallery} selected="selected"{/if}>--- {translate("None selected")} ---</option>
{foreach $galleries ind gal}
	<option value="{$ind}"{if $entry.option.catGallery == $ind} selected="selected"{/if}>{$gal}</option>
{/foreach}
</select>
<hr>
{translate("Select user")}
<select name="userID">
	{*<option value="1" {if $entry.option.userID == 1} selected="selected"{/if}>Matthias Glienke</option>*}
	{foreach $users u}
	<option value="{$u.user_id}"{if $entry.option.userID == $u.user_id} selected="selected"{/if}>{$u.display_name}</option>
	{/foreach}
</select>
<hr>