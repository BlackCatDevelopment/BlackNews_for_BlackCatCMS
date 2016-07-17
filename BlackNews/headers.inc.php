<?php
/**
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
 *   @copyright			2016, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			blacknews
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
