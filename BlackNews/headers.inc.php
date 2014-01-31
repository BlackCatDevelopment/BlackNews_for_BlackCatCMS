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

// include class.secure.php to protect this file and the whole CMS!
if (defined('CAT_PATH')) {	
	include(CAT_PATH.'/framework/class.secure.php'); 
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) { 
		include($root.'/framework/class.secure.php'); 
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php


$getVariant	= CAT_Helper_Page::getInstance()->db()->get_one(
			sprintf(
				'SELECT `value` FROM `%smod_%s`
					WHERE `section_id` = \'%s\'
					AND `name` = \'%s\'',
					CAT_TABLE_PREFIX,
					'blacknews_options',
					$section['section_id'],
					'variant'
			)
);

$getInfo	= CAT_Helper_Addons::checkInfo( CAT_PATH . '/modules/blacknews/' );


$module_path	= '/modules/blacknews/';

$variant	= $getVariant != '' && isset($getInfo['module_variants'][$getVariant]) ?
	$getInfo['module_variants'][$getVariant] : 
	'default';

if ( file_exists( CAT_PATH . $module_path .'headers_inc/' . $variant . '/headers.inc.php' ) )
	include_once( CAT_PATH . $module_path .'headers_inc/' . $variant . '/headers.inc.php' );
elseif ( file_exists( CAT_PATH . $module_path .'headers_inc/default/headers.inc.php' ) )
	include_once( CAT_PATH . $module_path .'headers_inc/default/headers.inc.php' );



if( !isset($mod_headers['frontend']['meta']) ) {
	$mod_headers['frontend']['meta']	= array(
		array( '<link rel="alternate" type="application/rss+xml" title="RSS" href="" />' )
	);
} else {
	array_push(
		$mod_headers['frontend']['meta'],
		array( '<link rel="alternate" type="application/rss+xml" title="RSS" href="" />' )
	);
}

?>
