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

include_once( 'classes/class.news.php' );

$blackNews		= new BlackNews( $section, true );

$variant		= $blackNews->getVariant();

$module_path	= '/modules/blacknews/';

if ( file_exists( CAT_PATH . $module_path .'headers_inc/' . $variant . '/headers.inc.php' ) )
	include( CAT_PATH . $module_path . 'headers_inc/' . $variant . '/headers.inc.php' );
elseif ( file_exists( CAT_PATH . $module_path .'headers_inc/default/headers.inc.php' ) )
	include( CAT_PATH . $module_path .'headers_inc/default/headers.inc.php' );
/*
	*
	* This is not working in BC 1.1 - need to find a good fix for that issue
	*

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
*/
?>
