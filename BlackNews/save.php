<?php
/**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			blacknews
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 */

if (defined('CAT_PATH')) {	
    if (defined('CAT_VERSION')) include(CAT_PATH.'/framework/class.secure.php');
} elseif (file_exists($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php')) {
    include($_SERVER['DOCUMENT_ROOT'].'/framework/class.secure.php');
} else {
    $subs = explode('/', dirname($_SERVER['SCRIPT_NAME']));    $dir = $_SERVER['DOCUMENT_ROOT'];
    $inc = false;
    foreach ($subs as $sub) {
        if (empty($sub)) continue; $dir .= '/'.$sub;
        if (file_exists($dir.'/framework/class.secure.php')) {
            include($dir.'/framework/class.secure.php'); $inc = true;    break;
	}
	}
    if (!$inc) trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
}

$val		= CAT_Helper_Validate::getInstance();
$userHelper	= CAT_Users::getInstance();
$backend	= CAT_Backend::getInstance('Pages', 'pages_modify', false);
$dateHelper	= CAT_Helper_DateTime::getInstance();
$PageHelper	= CAT_Helper_Page::getInstance();

header('Content-type: application/json');

$news_id				= $val->sanitizePost('news_id','numeric');

// ===============
// ! Get page id
// ===============
$page_id	= $val->get('_REQUEST','page_id','numeric');
$section_id	= $val->get('_REQUEST','section_id','numeric');

// =============
// ! Get perms
// =============
if ( CAT_Helper_Page::getPagePermission( $page_id, 'admin' ) !== true )
{
	$backend->print_error( 'You do not have permissions to modify this page!' );
}

// ============================= 
// ! Get the current news_id   
// ============================= 
if( $news_id = $val->get('_REQUEST','news_id','numeric') )
{
	$equalize	= $val->sanitizePost( 'equalize' ) != '' ? 1 : 0;

	// ======================= 
	// ! Set kind of columns   
	// ======================= 
	if ( $kind = $val->get('_REQUEST','set_kind','numeric') )
	{
		$backend->db()->query("UPDATE " . CAT_TABLE_PREFIX . "mod_blacknews SET kind = '$kind', equalize = '$equalize' WHERE news_id='$news_id'");
	}

	// =========================== 
	// ! save content of columns   
	// =========================== 
	elseif ( $val->get('_REQUEST','save_columns') != '' )
	{
		$ids	= $val->get( '_REQUEST', 'content_id', 'array', false );

		$backend->db()->query("UPDATE " . CAT_TABLE_PREFIX . "mod_blacknews SET equalize = '$equalize' WHERE news_id='$news_id'");

		foreach( $ids as $id )
		{
			$contentname	= 'content_' . $section_id . '_' . $id;
			$content		= $val->get( '_REQUEST', $contentname, false, true );
			$content		= $val->add_slashes($content);
			$text			= umlauts_to_entities(strip_tags($content), strtoupper(DEFAULT_CHARSET), 0);

			$backend->db()->query("UPDATE " . CAT_TABLE_PREFIX . "mod_blacknews_contents SET content = '$content', text = '$text' WHERE id = '$id' AND news_id = '$news_id'");
		}
	}

	// ================== 
	// ! add new column   
	// ================== 
	elseif ( $val->get('_REQUEST','add_column') != '' )
	{
		$backend->db()->query("INSERT INTO " . CAT_TABLE_PREFIX . "mod_blacknews_contents
			(news_id,page_id,section_id) VALUES
			('$news_id','$page_id','$section_id')");
	}

	// =================== 
	// ! remove a column   
	// =================== 
	elseif ( $id = $val->get('_REQUEST','remove_column','numeric') )
	{
		$backend->db()->query("DELETE FROM " . CAT_TABLE_PREFIX . "mod_blacknews_contents WHERE id='$id'");
	}
	// ================================================================ 
	// ! Check if there is a database error, otherwise say successful   
	// ================================================================ 
	if ( $backend->is_error() )
	{
		$backend->print_error($backend->get_error(), $js_back);
	}
	else
	{
		$backend->print_success('Pages saved successfully', CAT_ADMIN_URL . '/pages/modify.php?page_id=' . $page_id);
	}
}
else $backend->print_error('An error occured while saving!', $js_back);

// ====================== 
// ! Print admin footer   
// ====================== 
$backend->print_footer();

?>