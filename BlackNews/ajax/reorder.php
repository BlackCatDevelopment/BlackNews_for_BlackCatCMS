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
$positions	= $val->sanitizePost('positions','array');

// =============
// ! Get perms
// =============
if ( !$section_id || !$page_id || !$positions )
{
	$ajax	= array(
		'message'	=> $backend->lang()->translate('You sent an invalid value'),
		'success'	=> true
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

foreach ( $positions as $index => $position )
{
	$news_id	= str_replace( 'blacknews_' . $section_id . '_', '', $position );
	$PageHelper->db()->query("UPDATE " . CAT_TABLE_PREFIX . "mod_blacknews_entry SET 
		position		= '$index'
		WHERE section_id = '$section_id' AND
		page_id = '$page_id' AND
		news_id = '$news_id'"
	);
}
$ajax	= array(
	'message'	=> $backend->lang()->translate( 'Entries sorted successfully!' ),
	'success'	=> true
);
print json_encode( $ajax );
exit();
?>