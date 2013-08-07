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

// ===============
// ! Get page id
// ===============
$page_id	= $val->sanitizePost('page_id', 'numeric');
$section_id	= $val->sanitizePost('section_id', 'numeric');
$id			= $val->sanitizePost('news_id', 'numeric');

// =============
// ! Get perms
// =============
if ( !$section_id || !$page_id || !$id )
{
	$ajax	= array(
		'message'	=> $backend->lang()->translate('You sent an invalid value'),
		'success'	=> false
	);
	print json_encode( $ajax );
	exit();
}

if ( $PageHelper->getPagePermission( $page_id, 'admin' ) !== true )
{
	$ajax	= array(
		'message'	=> $backend->lang()->translate( 'You do not have permissions to modify this page!' ),
		'success'	=> false
	);
	print json_encode( $ajax );
	exit();
}


$auto_generate			= $val->sanitizePost('auto_generate','numeric') != '' ? 1 : 0;
$auto_generate_size		= $val->sanitizePost('auto_generate_size','numeric');

$entries_per_page		= $val->sanitizePost('entries_per_page','numeric');
$variant				= addslashes( $val->sanitizePost('variant') );

$title					= addslashes( $val->sanitizePost('title') );
$subtitle				= addslashes( $val->sanitizePost('subtitle') );
$category				= addslashes( $val->sanitizePost('category') );
$short_check			= $val->sanitizePost('short_check','numeric') != '' ? 1 : 0;

$start					= $val->sanitizePost('start');
$end					= $val->sanitizePost('end');
$short_cont				= addslashes( $val->sanitizePost('short_cont') );
$long_cont				= addslashes( $val->sanitizePost('long_cont') );
$text					= umlauts_to_entities(strip_tags( $short_cont ), strtoupper(DEFAULT_CHARSET), 0) . ' ' .
							umlauts_to_entities(strip_tags( $long_cont ), strtoupper(DEFAULT_CHARSET), 0);

$PageHelper->db()->query("UPDATE " . CAT_TABLE_PREFIX . "mod_blacknews_options SET
		value	= '$entries_per_page'
		WHERE name = 'entries_per_page' AND
		section_id = '$section_id' AND
		page_id = '$page_id'"
	);
$PageHelper->db()->query("UPDATE " . CAT_TABLE_PREFIX . "mod_blacknews_options SET
		value	= '$variant'
		WHERE name = 'variant' AND
		section_id = '$section_id' AND
		page_id = '$page_id'"
	);

$time	= time();

$PageHelper->db()->query("UPDATE " . CAT_TABLE_PREFIX . "mod_blacknews_entry SET 
		updated		= '$time'
		WHERE section_id = '$section_id' AND page_id = '$page_id'"
	);

$PageHelper->db()->query("UPDATE " . CAT_TABLE_PREFIX . "mod_blacknews_content SET
		title				= '$title',
		subtitle			= '$subtitle',
		auto_generate		= '$auto_generate',
		auto_generate_size	= '$auto_generate_size',
		short				= '$short_cont',
		content				= '$long_cont',
		text				= '$text'
		WHERE section_id = '$section_id' AND page_id = '$page_id' AND news_id = '$id'"
	);

// ================================================================ 
// ! Check if there is a database error, otherwise say successful   
// ================================================================ 
if ( $backend->is_error() )
{
	$ajax	= array(
		'message'	=> $backend->lang()->translate( $backend->get_error() ),
		'success'	=> false
	);
	print json_encode( $ajax );
	exit();
}
else
{
	$ajax	= array(
		'message'	=> $backend->lang()->translate( 'Entry saved successfully!' ),
		'title'		=> $title,
		'subtitle'	=> $subtitle,
		'news_id'	=> $id,
		'time'		=> CAT_Helper_DateTime::getInstance()->getDateTime( $time ),
		'success'	=> true
	);
	print json_encode( $ajax );
	exit();
}

?>